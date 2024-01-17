<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Architect;
use App\Models\Electrician;
use App\Models\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;

class DashboardController extends Controller
{

	public function index()
	{
		$data = array();
		$data['title'] = "Dashboard";

		$MyPrivilege = getMyPrivilege('dashboard');
		return view('dashboard/index', compact('data'));
	}

	public function profile()
	{
		$data = array();
		$data['title'] = "Profile";
		return view('dashboard/profile', compact('data'));
	}

	public function changePassword()
	{
		$data = array();
		$data['title'] = "Change Password";
		return view('dashboard/changepassword', compact('data'));
	}

	public function doChangePassword(Request $request)
	{

		// $formType = isset($request->form_type) ? $request->form_type : 'form_otp';

		// if ($formType == "form_otp") {

		// 	$validator = Validator::make($request->all(), [
		// 		'one_time_password' => ['required'],

		// 	]);

		// } else if ($formType == "form_change_password") {

		if (Auth::User()->is_changed_password == 1) {
			$validator = Validator::make($request->all(), [
				'old_password' => ['required'],
				'new_password' => ['required'],
				'confirm_password' => ['required'],

			]);
		} else if (Auth::User()->is_changed_password == 0) {

			$validator = Validator::make($request->all(), [

				'new_password' => ['required'],
				'confirm_password' => ['required'],

			]);
		}

		//} else {
		//$validator = Validator::make($request->all(), []);
		//}

		{
			if ($validator->fails()) {

				$response = array();
				$response['status'] = 0;
				$response['msg'] = "The request could not be understood by the server due to malformed syntax";
				$response['statuscode'] = 400;
				$response['data'] = $validator->errors();
			} else {

				// if ($formType == "form_otp" && Auth::User()->is_changed_password == 0) {

				// 	$one_time_password = implode("", $request->one_time_password);

				// 	$user = User::find(Auth::User()->id);

				// 	if ($user->one_time_password != "" && $user->one_time_password == $one_time_password) {

				// 		$response = successRes("Valid one time password");

				// 	} else {

				// 		$response = errorRes("Invalid one time password");

				// 	}

				// } else if ($formType == "form_change_password" && Auth::User()->is_changed_password == 0) {

				// 	$one_time_password = implode("", $request->one_time_password);
				// 	$user = User::find(Auth::User()->id);
				// 	if ($user->one_time_password != "" && $user->one_time_password == $one_time_password) {

				// 		if ($request->new_password == $request->confirm_password) {

				// 			Auth::User()->is_changed_password = 1;
				// 			Auth::User()->password = Hash::make($request->new_password);

				// 			Auth::User()->save();

				// 			$debugLog = array();
				// 			$debugLog['name'] = "user-password";
				// 			$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been updated password ";
				// 			saveDebugLog($debugLog);

				// 			$response = successRes("Successfully updated password");

				// 		} else {
				// 			$response = errorRes("New password and Confirm password mismatch");
				// 		}

				// 	} else {

				// 		$response = errorRes("Invalid one time password");

				// 	}

				// } else if ($formType == "form_change_password" && Auth::User()->is_changed_password == 1) {

				if (Auth::User()->is_changed_password == 1) {

					$current_password = Auth::User()->password;
					if (Hash::check($request->old_password, $current_password)) {

						if ($request->new_password == $request->confirm_password) {

							Auth::User()->password = Hash::make($request->new_password);
							Auth::User()->is_changed_password = 1;
							Auth::User()->save();

							$debugLog = array();
							$debugLog['name'] = "user-password";
							$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been updated password ";
							saveDebugLog($debugLog);

							$response = successRes("Successfully updated password");
						} else {
							$response = errorRes("New password and Confirm password mismatch");
						}
					} else {
						$response = errorRes("Invalid old password");
					}
				} else {
					Auth::User()->password = Hash::make($request->new_password);
					Auth::User()->is_changed_password = 1;
					Auth::User()->save();
					$debugLog = array();
					$debugLog['name'] = "user-password";
					$debugLog['description'] = "user #" . Auth::user()->id . "(" . Auth::user()->email . ") has been updated password ";
					saveDebugLog($debugLog);
					$response = successRes("Successfully updated password");
				}

				// } else {
				// 	$response = errorRes("Something went wrong");
				// }

			}
		}

		return response()->json($response)->header('Content-Type', 'application/json');
	}

	function sendOTPForChangePassword()
	{

		if (Auth::User()->is_changed_password == 0) {
			$one_time_password = (rand(1000, 9999));
			Auth::User()->one_time_password = $one_time_password;
			Auth::User()->save();
			$reciever_lable = array();
			$params = array();

			if (Auth::User()->type != 302) {

				$params['to_email'] = Auth::User()->email;

				$configrationForNotify = configrationForNotify();
				$params['from_name'] = $configrationForNotify['from_name'];
				$params['from_email'] = $configrationForNotify['from_email'];
				$params['to_name'] = $configrationForNotify['to_name'];
				$params['subject'] = "OTP (One Time Password) - Whitelion";
				$params['one_time_password'] = $one_time_password;

				if (Config::get('app.env') == "local") {
					$params['to_email'] = $configrationForNotify['test_email'];
				}
				Mail::send('emails.one_time_password', ['params' => $params], function ($m) use ($params) {
					$m->from($params['from_email'], $params['from_name']);
					$m->to($params['to_email'], $params['to_name'])->subject($params['subject']);
				});
				$reciever_lable[] = $params['to_email'];
			}

			$params['mobile_numer'] = Auth::User()->phone_number;
			if (Config::get('app.env') == "local") {
				//$params['mobile_numer'] = "9913834380";

			}

			$reciever_lable[] = $params['mobile_numer'];

			sendOTPToMobile($params['mobile_numer'], $one_time_password);
			$response = successRes("Successfully sent otp");
			$response['reciever_lable'] = implode(" and ", $reciever_lable);
		} else {

			$response = errorRes("Something went wrong");
		}
		return response()->json($response)->header('Content-Type', 'application/json');
	}
}
