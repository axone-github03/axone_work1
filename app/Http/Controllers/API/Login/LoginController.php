<?php

namespace App\Http\Controllers\API\Login;

use App\Http\Controllers\Controller;
use App\Models\Architect;
use App\Models\Electrician;
use App\Models\User;
use App\Models\Company;
use App\Models\StateList;
use App\Models\CountryList;
use App\Models\CityList;
use App\Models\Branch;
use App\Models\UserType;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Mail;

class LoginController extends Controller
{
	public function loginProcess(Request $request)
	{

		$rules = array();
		$rules['email'] = 'required';

		// $rules['password'] = 'required';

		$rules['login_type'] = 'required';

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {

			$response = array();
			$response['status'] = 0;
			$response['msg'] = "The request could not be understood by the server due to malformed syntax";
			$response['status_code'] = 400;
			$response['data'] = $validator->errors();

		} else {
			if ($request->login_type == 'password') {
				if (isset($request->password)) {
					if ($request->password != '' && $request->password != null) {
						if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]) && !Auth::attempt(['phone_number' => $request->email, 'password' => $request->password])) {
							$response = errorRes(" Email/Phone number or password incorrect!");
						} else {

							$user = Auth::user();
							$tokenResult = $user->createToken('Personal Access Token');
							$token = $tokenResult->token;
							$token->save();

							$userTypes = getAllUserTypes();

							if (!isset($userTypes[$request->user()->type]['can_login']) || (isset($userTypes[$request->user()->type]['can_login']) && $userTypes[$request->user()->type]['can_login'] == 0)) {

								$accessToken = Auth::user()->token();
								$token = $request->user()->tokens->find($accessToken);
								$token->revoke();

								$response = errorRes("You haven't access to sign in");
							} else if ($request->user()->status != 1) {

								//$accessToken = auth()->guard('api')->attempt($credentials);
								$token = $request->user()->tokens->find($token);
								$token->revoke();
								$response = errorRes("You cannot login because your account has been locked");
							} else {

								if ($user->is_changed_password == 0) {

									// $accessToken = auth()->guard('api')->attempt($credentials);
									$token = $request->user()->tokens->find($token);
									$token->revoke();

									$response = errorRes("Must login with OTP(One Time Password) first time");
									return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
								}

								//$request->session()->regenerate();

								$user->last_login_date_time = date('Y-m-d H:i:s');
								$user->save();

								// Start Debug Log

								$debugLog = array();
								$debugLog['name'] = "user-login";
								$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been logged in ";
								saveDebugLog($debugLog);

								// End Debug Log

								$response = successRes("Successfully Login");

								$response['token_type'] = 'Bearer';
								$response['token'] = $tokenResult->accessToken;

							}
						}
					} else {
						$response = errorRes("Please Enter password");
						return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
					}
				} else {
					$response = errorRes("password field is required");
					return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
				}

			} elseif ($request->login_type == 'mpin') {
				if (isset($request->mpin) && $request->mpin != 0 && $request->mpin != '' && $request->mpin != null) {
					$User = User::where('email', $request->email)->where('mpin', $request->mpin)->first();
					if (!$User) {
						// $typeOfLogin = "phone_number";
						$User = User::where('phone_number', $request->email)->where('mpin', $request->mpin)->first();
					}
					if ($User) {
						$userTypes = getAllUserTypes();

						if (!isset($userTypes[$User->type]['can_login']) || (isset($userTypes[$User->type]['can_login']) && $userTypes[$User->type]['can_login'] == 0)) {

							$response = errorRes("You haven't access to sign in");
							return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
						} else if ($User->status != 1) {

							$response = errorRes("You cannot login because your account has been locked");

							return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
						}

						if ($User->mpin == $request->mpin) {

							$User->last_login_date_time = date('Y-m-d H:i:s');
							$User->save();

							Auth::loginUsingId($User->id);
							$user = Auth::user();
							$tokenResult = $user->createToken('Personal Access Token');
							$token = $tokenResult->token;
							$token->save();

							// Start Debug Log

							$debugLog = array();
							$debugLog['name'] = "user-login";
							$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been logged in ";
							saveDebugLog($debugLog);

							// End Debug Log

							$response = successRes("Successfully Login");
							$response['token_type'] = 'Bearer';
							$response['token'] = $tokenResult->accessToken;
						} else {
							$response = errorRes("incorrect mpin");
						}
					} else {
						$response = errorRes(" Email/Phone number or mpin incorrect!");

					}
				} else {
					$response = errorRes("Please Enter mpin");
					return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
				}
			}
		}
		return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
	}
	public function sendOTP(Request $request)
	{

		$rules = array();
		$rules['email'] = 'required';
		$customMessage = array();
		$validator = Validator::make($request->all(), $rules, $customMessage);

		if ($validator->fails()) {

			$response = array();
			$response['status'] = 0;
			$response['msg'] = "The request could not be understood by the server due to malformed syntax";
			$response['statuscode'] = 400;
			$response['data'] = $validator->errors();
		} else {

			$typeOfLogin = "email";

			$User = User::where('email', $request->email)->first();
			if ($User) {

				$userTypes = getAllUserTypes();

				if (!isset($userTypes[$User->type]['can_login']) || (isset($userTypes[$User->type]['can_login']) && $userTypes[$User->type]['can_login'] == 0)) {

					$response = errorRes("You haven't access to sign in");
					return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
				} else if ($User->status != 1) {

					$response = errorRes("You cannot login because your account has been locked");

					return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
				}

				// if ($typeOfLogin == "email") {

				// } else if ($typeOfLogin == "phone_number") {

				// }

				$one_time_password = (rand(1000, 9999));
				$User->one_time_password = $one_time_password;
				$User->save();

				$params = array();

				$params['to_email'] = $User->email;
				// if (Config::get('app.env') == "local") {
				// 	$params['to_email'] = "ankitsardhara4@gmail.com";
				// }

				$configrationForNotify = configrationForNotify();

				$params['from_name'] = $configrationForNotify['from_name'];
				$params['from_email'] = $configrationForNotify['from_email'];
				$params['to_name'] = $configrationForNotify['to_name'];
				$params['subject'] = "OTP (One Time Password) - Whitelion";
				$params['one_time_password'] = $one_time_password;

				// if (Config::get('app.env') == "local") {
				// 	$params['to_email'] = $configrationForNotify['test_email'];
				// }

				Mail::send('emails.one_time_password', ['params' => $params], function ($m) use ($params) {
					$m->from($params['from_email'], $params['from_name']);
					$m->to($params['to_email'], $params['to_name'])->subject($params['subject']);
				});

				$params['mobile_numer'] = $User->phone_number;
				// if (Config::get('app.env') == "local") {
				// 	$params['mobile_numer'] = "9913834380";
				// }

				$response = successRes("Successfully sent otp to " . $params['to_email'] . "/" . $params['mobile_numer']);
			} else {
				$response = errorRes("Email/Phone number not found");
			}
		}

		return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
	}

	public function verifyOTP(Request $request)
	{

		$rules = array();
		$rules['email'] = 'required';
		$rules['one_time_password'] = 'required';
		$customMessage = array();
		$validator = Validator::make($request->all(), $rules, $customMessage);

		if ($validator->fails()) {

			$response = array();
			$response['status'] = 0;
			$response['msg'] = "The request could not be understood by the server due to malformed syntax";
			$response['status_code'] = 400;
			$response['data'] = $validator->errors();
		} else {

			$typeOfLogin = "email";

			$User = User::where('email', $request->email)->first();
			if ($User) {

				$userTypes = getAllUserTypes();

				if (!isset($userTypes[$User->type]['can_login']) || (isset($userTypes[$User->type]['can_login']) && $userTypes[$User->type]['can_login'] == 0)) {

					$response = errorRes("You haven't access to sign in");
					return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
				} else if ($User->status != 1) {

					$response = errorRes("You cannot login because your account has been locked");

					return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
				}

				if ($User->one_time_password == $request->one_time_password) {
					$User->one_time_password = "";
					$User->save();

					$User->last_login_date_time = date('Y-m-d H:i:s');
					$User->save();

					Auth::loginUsingId($User->id);
					$user = Auth::user();
					$tokenResult = $user->createToken('Personal Access Token');
					$token = $tokenResult->token;
					$token->save();

					// Start Debug Log

					$debugLog = array();
					$debugLog['name'] = "user-login";
					$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been logged in ";
					saveDebugLog($debugLog);

					// End Debug Log

					$response = successRes("Successfully Login");
					$response['token_type'] = 'Bearer';
					$response['token'] = $tokenResult->accessToken;
				} else {
					$response = errorRes("incorrect OTP(One Time Password)");
				}
			} else {
				$response = errorRes("Email/Phone number not found");
			}
		}
		return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
	}

	public function logout(Request $request)
	{

		// Start Debug Log

		if (isset(Auth::user()->id)) {
			$debugLog = array();
			$debugLog['name'] = "user-logout";
			$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been logged out ";
			saveDebugLog($debugLog);
		}
		// End Debug Log

		$accessToken = Auth::user()->token();
		$token = $request->user()->tokens->find($accessToken);
		$token->revoke();
		$response = successRes("Successfully Logout");

		return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
	}

	public function profile(Request $request)
	{
			$user = User::select('users.*');
			$user->where('users.id', Auth::user()->id);
			$user = $user->first();

			$data = array();
			if ($user) {
				$user = json_encode($user);
				$user = json_decode($user, true);

				$data['user'] = $user;
				$data['user']['sign_image'] = asset($data['user']['sign_image']);

				$country = CountryList::select('id', 'name as text');
				$country->where('id', $data['user']['country_id']);
				$country = $country->first();
				$data['user']['country_id'] = $country;
	
	
				$state_id = StateList::select('id', 'name as text');
				$state_id->where('id', $data['user']['state_id']);
				$state_id = $state_id->first();
				$data['user']['state_id'] = $state_id;
	
				
				$city_id = CityList::select('id', 'name as text');
				$city_id->where('id', $data['user']['city_id']);
				$city_id = $city_id->first();
				$data['user']['city_id'] = $city_id;
			
			  /////// company ///////

				
				$company = Company::select('id', 'name', 'shortname', 'address_line_1', 'address_line_2', 'pincode', 'area', 'country_id', 'state_id', 'city_id', 'status', 'company_logo','source' );
				$company->where('status', 1);
				$company->where('id', $data['user']['company_id']);
				$company = $company->first();
				$company['company_logo'] = asset(''.$company['company_logo']);


				if($company){
					$data['user']['company_id'] = $company;
					
					
					$country = CountryList::select('id', 'name as text');
					$country->where('id', $data['user']['company_id']['country_id']);
					$country = $country->first();
					$data['user']['company_id']['country_id'] = $country;
		
		
					$state_id = StateList::select('id', 'name as text');
					$state_id->where('id', $data['user']['company_id']['state_id']);
					$state_id = $state_id->first();
					$data['user']['company_id']['state_id'] = $state_id;
		

					$city_id = CityList::select('id', 'name as text');
					$city_id->where('id', $data['user']['company_id']['city_id']);
					$city_id = $city_id->first();
					$data['user']['company_id']['city_id'] = $city_id;
		
					$branch = Branch::select('id', 'name as text','shortname','email', 'phone_number', 'address_line_1', 'address_line_2', 'pincode', 'area', 'country_id', 'state_id', 'city_id', 'status', 'source' );
					$branch->where('status', 1);
					$branch->where('id', $data['user']['branch_id']);
					$branch = $branch->first();
					$data['user']['branch_id'] = $branch;

					$country = CountryList::select('id', 'name as text');
					$country->where('id', $data['user']['branch_id']['country_id']);
					$country = $country->first();
					$data['user']['branch_id']['country_id'] = $country;
		
		
					$state_id = StateList::select('id', 'name as text');
					$state_id->where('id', $data['user']['branch_id']['state_id']);
					$state_id = $state_id->first();
					$data['user']['branch_id']['state_id'] = $state_id;
		
					
					$city_id = CityList::select('id', 'name as text');
					$city_id->where('id', $data['user']['branch_id']['city_id']);
					$city_id = $city_id->first();
					$data['user']['branch_id']['city_id'] = $city_id;
					/////// End Branch //////
		
					////// User-type ///////
					$user_type = UserType::select('id', 'name as text', 'remark', 'status');
					$user_type->where('status', 1);
					$user_type->where('id', $data['user']['type']);
					$user_type = $user_type->first();
					$data['user']['user_type_id'] = $user_type;
		
					/////// End User-type //////
				
					
				}
				$response = successRes();
				$response['data'] = $data;
			}else {
				$response = errorRes("Something went wrong");
			}
			return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function changePassword(Request $request)
	{

		if ($request->is_forget == 1) {
			$validator = Validator::make($request->all(), [
				'new_password' => ['required'],
			]);
		} else if ($request->is_forget == 0) {
			$validator = Validator::make($request->all(), [
				'old_password' => ['required'],
				'new_password' => ['required'],
			]);
			
		}

		if ($validator->fails()) {

			$response = errorRes("Validation Error", 400);
			$response['data'] = $validator->errors();
			return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
		} else {

			if ($request->is_forget == 1) {
				Auth::User()->is_changed_password = 1;
				Auth::User()->password = Hash::make($request->new_password);
				Auth::User()->save();

				$debugLog = array();
				$debugLog['name'] = "user-password";
				$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been updated password ";
				saveDebugLog($debugLog);
				$response = successRes("Successfully updated password");
			} else {

				$current_password = Auth::User()->password;
				if (Hash::check($request->old_password, $current_password)) {

					Auth::User()->is_changed_password = 1;
					Auth::User()->password = Hash::make($request->new_password);

					Auth::User()->save();

					$debugLog = array();
					$debugLog['name'] = "user-password";
					$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been updated password ";
					saveDebugLog($debugLog);

					$response = successRes("Successfully updated password");

				} else {
					$response = errorRes("Invalid old password");
				}
			}
		}

		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function changempin(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'mpin' => ['required'],
		]);

		if ($validator->fails()) {

			$response = errorRes("Validation Error", 400);
			$response['data'] = $validator->errors();
			return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
		} else {

			Auth::User()->mpin = $request->mpin;
			Auth::User()->save();

			$debugLog = array();
			$debugLog['name'] = "user-mpin";
			$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been updated mpin ";
			saveDebugLog($debugLog);
			$response = successRes("Successfully updated mpin");

		}

		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function editProfile(Request $request){

		$user = User::find(Auth::user()->id);

		$Profile_image = '';
		if(isset($request->avatar))
		{
			$folderPathofFile = '/assets/images/user_profile';
			$fileObject1 = base64_decode($request->avatar);
			$extension = '.png';
			$fileName1 = uniqid() .'_'. time() . $extension;
			$destinationPath = public_path($folderPathofFile);

			if (!File::exists($destinationPath)) {
				File::makeDirectory($destinationPath);
			}

			file_put_contents($destinationPath . '/' . $fileName1, $fileObject1);


			if (File::exists(public_path($folderPathofFile . '/' . $fileName1))) {
				$Profile_image = $folderPathofFile . '/' . $fileName1;
			} else {
				$Profile_image = '';
			}
		};
		
		$Image_Path = '';
		if(isset($request->sign_image))
		{
			$folderPathofFile = '/assets/images/user_sign';
			$fileObject1 = base64_decode($request->sign_image);
			$extension = '.png';
			$fileName1 = uniqid() .'_'. time() . $extension;
			$destinationPath = public_path($folderPathofFile);

			if (!File::exists($destinationPath)) {
				File::makeDirectory($destinationPath);
			}

			file_put_contents($destinationPath . '/' . $fileName1, $fileObject1);


			if (File::exists(public_path($folderPathofFile . '/' . $fileName1))) {
				$Image_Path = $folderPathofFile . '/' . $fileName1;
			} else {
				$Image_Path = '';
			}
		};


		if($user){

			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->email = $request->email;
			$user->phone_number = $request->phone_number;
			$user->avatar = $Profile_image;
			$user->house_no = $request->house_no;
			$user->address_line1 = $request->address_line1;
			$user->address_line2 = $request->address_line2;
			$user->area = $request->area;
			$user->pincode = $request->pincode;
			$user->country_id = $request->country_id;
			$user->state_id = $request->state_id;
			$user->city_id = $request->city_id;
			$user->sign_image = $Image_Path;

			$user->save();


		}else{
			$response = errorRes("Something went wrong");
		}
		$response = successRes('your data update');
		return response()->json($response)->header('Content-Type', 'application/json');

	}

	public function createUser(Request $request){

		$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';
		$user_ctc = isset($request->user_ctc) ? $request->user_ctc : 0;

		$rules = array(
			'user_first_name' => ['required'],
			'user_last_name' => ['required'],
			'user_email' => ['required'],
			'user_phone_number' => ['required'],
			'user_address_line1' => ['required'],
			'user_pincode' => ['required'],
			'user_country_id' => ['required'],
			'user_state_id' => ['required'],
			'user_city_id' => ['required'],
			'user_company_id' => ['required'],
			'user_branch_id' => ['required'],

		);

		$customMessage = array(
			'user_first_name.required' => "Please enter first name",
			'user_last_name.required' => "Please enter last name",
			'user_email.required' => "Please enter email",
			'user_phone_number.required' => "Please enter phone number",
			'user_address_line1.required' => "Please enter addressline1",
			'user_pincode.required' => "Please enter pincode",
			'user_country_id.required' => "Please select country",
			'user_state_id.required' => "Please select state",
			'user_city_id.required' => "Please select city",
			'user_company_id.required' => "Please select company",
			'user_branch_id.required' => "Please select branch",

		);

		$validator = Validator::make($request->all(), $rules, $customMessage);

		if ($validator->fails()) {

			$response = array();
			$response['status'] = 0;
			$response['msg'] = "The request could not be understood by the server due to malformed syntax";
			$response['statuscode'] = 400;
			$response['data'] = $validator->errors();
		} else {

			$AllUserTypes = getAllUserTypes();

			$alreadyEmail = User::query();
			$alreadyEmail->where('email', $request->user_email);
			$alreadyEmail->where('type', '!=', 10000);
			$alreadyEmail = $alreadyEmail->first();

			$alreadyPhoneNumber = User::query();
			$alreadyPhoneNumber->where('type', '!=', 10000);
			$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);
			$alreadyPhoneNumber = $alreadyPhoneNumber->first();

			if ($alreadyEmail) {
				$response = errorRes("Email already exists(" . $AllUserTypes[$alreadyEmail->type]['name'] . "), Try with another email");
			} else if ($alreadyPhoneNumber) {
				$response = errorRes("Phone number already exists(" . $AllUserTypes[$alreadyPhoneNumber->type]['name'] . "), Try with another phone number");
			} else {
				$Profile_image = '';
				if(isset($request->avatar))
				{
					$folderPathofFile = '/assets/images/user_profile';
					$fileObject1 = base64_decode($request->avatar);
					$extension = '.png';
					$fileName1 = uniqid() .'_'. time() . $extension;
					$destinationPath = public_path($folderPathofFile);

					if (!File::exists($destinationPath)) {
						File::makeDirectory($destinationPath);
					}

					file_put_contents($destinationPath . '/' . $fileName1, $fileObject1);


					if (File::exists(public_path($folderPathofFile . '/' . $fileName1))) {
						$Profile_image = $folderPathofFile . '/' . $fileName1;
					} else {
						$Profile_image = '';
					}
				};
	
					$Image_Path = '';
				if(isset($request->sign_image))
				{
					$folderPathofFile = '/assets/images/user_sign';
					$fileObject1 = base64_decode($request->sign_image);
					$extension = '.png';
					$fileName1 = uniqid() .'_'. time() . $extension;
					$destinationPath = public_path($folderPathofFile);

					if (!File::exists($destinationPath)) {
						File::makeDirectory($destinationPath);
					}

					file_put_contents($destinationPath . '/' . $fileName1, $fileObject1);


					if (File::exists(public_path($folderPathofFile . '/' . $fileName1))) {
						$Image_Path = $folderPathofFile . '/' . $fileName1;
					} else {
						$Image_Path = '';
					}
				};

				$User = User::where('type', 10000)->where(function ($query) use ($request) {
					$query->where('email', $request->user_email)->orWhere('phone_number', $request->user_phone_number);
				})->first();

				if ($User) {
					$User->type = 0;
					$User->reference_type = getUserTypes()[$User->type]['lable'];
					$User->reference_id = 0;
				} else {
					$User = new User();
					// $User->created_by = Auth::user()->id;
					$User->password = Hash::make('179358');
					$User->last_active_date_time = date('Y-m-d H:i:s');
					$User->last_login_date_time = date('Y-m-d H:i:s');
					$User->avatar = "default.png";
					$User->type = 0;
					$User->reference_type = getUserTypes()[$User->type]['lable'];
					$User->reference_id = 0;
				}
					

				$User->first_name = $request->user_first_name;
				$User->last_name = $request->user_last_name;
				$User->type = 2;
				$User->email = $request->user_email;
				$User->dialing_code = "+91";
				$User->phone_number = $request->user_phone_number;
				$User->ctc = $user_ctc;
				$User->address_line1 = $request->user_address_line1;
				$User->address_line2 = $user_address_line2;
				$User->pincode = $request->user_pincode;
				$User->country_id = $request->user_country_id;
				$User->state_id = $request->user_state_id;
				$User->city_id = $request->user_city_id;
				$User->company_id = $request->user_company_id;
				$User->branch_id = $request->user_branch_id;
				$User->avatar = $Profile_image;
				$User->sign_image = $Image_Path;
				$User->status = 2;
				$User->save();

				$debugLog = array();
				$debugLog['name'] = "user-add";
				$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
				$response = successRes("Successfully added user");
				
				// saveDebugLog($debugLog);

				$response = successRes("Successfully User Register");
			}

		}
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function searchUserType(Request $request)
	{
		$searchKeyword = isset($request->q) ? $request->q : "";

		$UserTypeList = UserType::select('id', 'name as text');
		$UserTypeList->where('name', 'like', "%" . $searchKeyword . "%");
		$UserTypeList->where('status', 1);
		$UserTypeList->limit(5);
		$UserTypeList = $UserTypeList->get();
		$response = array();
		$response = successRes("UserTypeList");
		$response['data'] = $UserTypeList;
		return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
	}
}