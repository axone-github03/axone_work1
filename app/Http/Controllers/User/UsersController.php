<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CityList;
use App\Models\CountryList;
use App\Models\Company;
use App\Models\Parameter;
use App\Models\PurchaseHierarchy;
use App\Models\PurchasePerson;
use App\Models\SalePerson;
use App\Models\SalesHierarchy;
use App\Models\ServiceHierarchy;
use App\Models\StateList;
use App\Models\UserType;
use App\Models\TeleSales;
use App\Models\User;
use App\Models\Branch;
use App\Models\Wlmst_ServiceExecutive;
use Config;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;

//use Session;

class UsersController extends Controller
{

	public function salesReportingManager(Request $request)
	{

		if ($request->sale_person_type != "") {

			$SalesHierarchy = array();
			$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
			$SalesHierarchy->where('status', 1);
			$SalesHierarchy->where('id', $request->sale_person_type);
			$SalesHierarchy = $SalesHierarchy->get();

			$SalesHierarchyId = array();
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end

			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end

			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end

			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end

			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end

			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = SalesHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end

			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			$SalesHierarchyId = array_unique($SalesHierarchyId);
			$SalesHierarchyId = array_values($SalesHierarchyId);

			$q = $request->q;

			$query = DB::table('sale_person');
			$query->leftJoin('users', 'sale_person.user_id', '=', 'users.id');
			$query->leftJoin('sales_hierarchy', 'sales_hierarchy.id', '=', 'sale_person.type');
			$query->select('users.id as id', 'sale_person.type', 'sales_hierarchy.code', DB::raw('CONCAT(first_name," ", last_name) AS text'));
			$query->whereIn('sale_person.type', $SalesHierarchyId);
			$query->where('users.type', 2);
			$query->where('users.status', 1);
			// $query->where('users.company_id', $request->user_company_id);
			$query->where('users.reference_id', '!=', 0);
			$query->where('users.id', '!=', $request->user_id);
			$query->where(function ($query) use ($q) {
				$query->where('users.first_name', 'like', '%' . $q . '%');
				$query->orWhere('users.last_name', 'like', '%' . $q . '%');
			});

			$query->limit(5);
			$data = $query->get();

			$data = json_decode(json_encode($data), true);

			foreach ($data as $key => $value) {

				$data[$key]['id'] = "u-" . $value['id'];
				$data[$key]['text'] = $data[$key]['text'] . " (" . $data[$key]['code'] . ")";
				unset($data[$key]['code']);
			}

			$Company = array();
			$Company = Company::select('id', 'name as text');
			$Company->where(function ($query) use ($q) {
				$query->where('name', 'like', '%' . $q . '%');
			});
			$Company = $Company->first();

			if ($Company) {

				$countData = count($data);
				$data[$countData]['id'] = "c-" . $Company['id'];
				$data[$countData]['text'] = $Company->text . " (COMPANY)";
			}

			$response = array();
			$response['results'] = $data;
		} else {
			$response = array();
			$response['results'] = array();
		}

		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function purchaseReportingManager(Request $request)
	{

		if ($request->purchase_person_type != "") {

			$SalesHierarchy = array();
			$SalesHierarchy = PurchaseHierarchy::select('id', 'parent_id');
			$SalesHierarchy->where('status', 1);
			$SalesHierarchy->where('id', $request->purchase_person_type);
			$SalesHierarchy = $SalesHierarchy->get();

			$SalesHierarchyId = array();
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = PurchaseHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = PurchaseHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = PurchaseHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = PurchaseHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$SalesHierarchy = array();
				$SalesHierarchy = PurchaseHierarchy::select('id', 'parent_id');
				$SalesHierarchy->where('status', 1);
				$SalesHierarchy->whereIn('id', $parentIds);
				$SalesHierarchy = $SalesHierarchy->get();
			}
			/// Repeat Code end

			$parentIds = array();
			foreach ($SalesHierarchy as $key => $value) {
				$SalesHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			$SalesHierarchyId = array_unique($SalesHierarchyId);
			$SalesHierarchyId = array_values($SalesHierarchyId);

			$q = $request->q;

			$query = DB::table('purchase_person');
			$query->leftJoin('users', 'purchase_person.user_id', '=', 'users.id');
			$query->leftJoin('purchase_hierarchy', 'purchase_hierarchy.id', '=', 'purchase_person.type');
			$query->select('users.id as id', 'purchase_person.type', 'purchase_hierarchy.code', DB::raw('CONCAT(first_name," ", last_name) AS text'));
			$query->whereIn('purchase_person.type', $SalesHierarchyId);
			$query->where('users.type', 10);
			$query->where('users.status', 1);
			// $query->where('users.company_id', $request->user_company_id);
			$query->where('users.reference_id', '!=', 0);
			$query->where('users.id', '!=', $request->user_id);
			$query->where(function ($query) use ($q) {
				$query->where('users.first_name', 'like', '%' . $q . '%');
				$query->orWhere('users.last_name', 'like', '%' . $q . '%');
			});

			$query->limit(5);
			$data = $query->get();

			$data = json_decode(json_encode($data), true);

			foreach ($data as $key => $value) {

				$data[$key]['id'] = "u-" . $value['id'];
				$data[$key]['text'] = $data[$key]['text'] . " (" . $data[$key]['code'] . ")";
				unset($data[$key]['code']);
			}

			$Company = array();
			$Company = Company::select('id', 'name as text');
			$Company->where(function ($query) use ($q) {
				$query->where('name', 'like', '%' . $q . '%');
			});
			$Company = $Company->first();

			if ($Company) {

				$countData = count($data);
				$data[$countData]['id'] = "c-" . $Company['id'];
				$data[$countData]['text'] = $Company->text . " (COMPANY)";
			}

			$response = array();
			$response['results'] = $data;
		} else {
			$response = array();
			$response['results'] = array();
		}

		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	function searchStateCities(Request $request)
	{

		$CityList = array();
		$CityList = CityList::select('id', 'name as text');
		//$CityList->where('country_id', $request->country_id);
		$CityList->whereIn('state_id', explode(",", $request->sale_person_state));
		$CityList->where('name', 'like', "%" . $request->q . "%");
		$CityList->where('status', 1);
		$CityList->limit(5);
		$CityList = $CityList->get();

		$response = array();
		$response['results'] = $CityList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function stateCities(Request $request)
	{

		$CityList = array();
		$CityList = CityList::select('id', 'name as text');
		$CityList->whereIn('state_id', explode(",", $request->state_ids));
		$CityList->orderByRaw('FIELD (state_id, ' . $request->state_ids . ') ASC');
		$CityList->where('status', 1);
		$CityList = $CityList->get();
		// $CityArray = array();
		// foreach ($CityList as $key => $value) {
		// 	$newarr['data']['id'] = $value->id;
		// 	$newarr['data']['text'] = $value->text;
		// 	array_push($CityArray,$newarr);
		// }
		$response = array();
		$response['data'] = $CityList;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function searchSalePersonType(Request $request)
	{

		$SalesHierarchy = array();
		$SalesHierarchy = SalesHierarchy::select('id', 'name as text');
		$SalesHierarchy->where('status', 1);
		$SalesHierarchy->where('name', 'like', "%" . $request->q . "%");
		$SalesHierarchy->limit(5);
		$SalesHierarchy = $SalesHierarchy->get();

		$response = array();
		$response['results'] = $SalesHierarchy;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function searchPurchasePersonType(Request $request)
	{

		$SalesHierarchy = array();
		$SalesHierarchy = PurchaseHierarchy::select('id', 'name as text');
		$SalesHierarchy->where('status', 1);
		$SalesHierarchy->where('name', 'like', "%" . $request->q . "%");
		$SalesHierarchy->limit(5);
		$SalesHierarchy = $SalesHierarchy->get();

		$response = array();
		$response['results'] = $SalesHierarchy;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function searchState(Request $request)
	{
		$serachvalue = isset($request->q) ? $request->q : "";

		$StateList = array();
		$StateList = StateList::select('id', 'name as text', 'arabic_state_name');
		$StateList->where('country_id', $request->user_country_id);
		$StateList->where('name', 'like', "%" . $serachvalue . "%");

		$StateList->limit(5);
		$StateList = $StateList->get();

		$response = array();
		$response['results'] = $StateList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function searchCity(Request $request)
	{

		$CityList = array();
		$CityList = CityList::select('id', 'name as text', 'arabic_city_name');
		$CityList->where('country_id', $request->user_country_id);
		$CityList->where('state_id', $request->user_state_id);
		$CityList->where('name', 'like', "%" . $request->q . "%");
		$CityList->where('status', 1);
		$CityList->limit(5);
		$CityList = $CityList->get();

		$response = array();
		$response['results'] = $CityList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function searchCompany(Request $request)
	{

		$Company = array();
		$Company = Company::select('id', 'name as text');
		$Company->where('name', 'like', "%" . $request->q . "%");
		$Company->where('status', 1);
		$Company->limit(5);
		$Company = $Company->get();
		$response = array();
		$response['results'] = $Company;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function save(Request $request)
	{

		// ADMIN

		$user_address_line2 = isset($request->user_address_line2) ? $request->user_address_line2 : '';
		$user_ctc = isset($request->user_ctc) ? $request->user_ctc : 0;

		$rules = array(
			'user_id' => ['required'],
			'user_first_name' => ['required'],
			'user_last_name' => ['required'],
			'user_email' => ['required'],
			'user_phone_number' => ['required'],
			'user_address_line1' => ['required'],
			'user_pincode' => ['required'],
			'user_country_id' => ['required'],
			'user_state_id' => ['required'],
			'user_city_id' => ['required'],
			'user_type' => ['required'],
		);

		$customMessage = array(
			'user_id.required' => "Invalid parameters",
			'user_first_name.required' => "Please enter first name",
			'user_last_name.required' => "Please enter last name",
			'user_email.required' => "Please enter email",
			'user_phone_number.required' => "Please enter phone number",
			'user_address_line1.required' => "Please enter addressline1",
			'user_pincode.required' => "Please enter pincode",
			'user_country_id.required' => "Please select country",
			'user_state_id.required' => "Please select state",
			'user_city_id.required' => "Please select city",
			'user_type.required' => "Please select user type",
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
			if ($request->user_id != 0) {
				$alreadyEmail->where('id', '!=', $request->user_id);
			}
			$alreadyEmail = $alreadyEmail->first();

			$alreadyPhoneNumber = User::query();
			$alreadyPhoneNumber->where('type', '!=', 10000);
			$alreadyPhoneNumber->where('phone_number', $request->user_phone_number);
			if ($request->user_id != 0) {
				$alreadyPhoneNumber->where('id', '!=', $request->user_id);
			}
			$alreadyPhoneNumber = $alreadyPhoneNumber->first();

			if ($alreadyEmail) {
				$response = errorRes("Email already exists(" . $AllUserTypes[$alreadyEmail->type]['name'] . "), Try with another email");
			} else if ($alreadyPhoneNumber) {
				$response = errorRes("Phone number already exists(" . $AllUserTypes[$alreadyPhoneNumber->type]['name'] . "), Try with another phone number");
			} else {

				if ($request->user_id == 0) {

					$User = User::where('type', 10000)->where(function ($query) use ($request) {
						$query->where('email', $request->user_email)->orWhere('phone_number', $request->user_phone_number);
					})->first();

					if ($User) {
						$User->type = $request->user_type;
						$User->reference_type = getUserTypes()[$User->type]['lable'];
						$User->reference_id = 0;
					} else {
						$User = new User();
						$User->created_by = Auth::user()->id;
						$User->password = Hash::make("111111");
						$User->last_active_date_time = date('Y-m-d H:i:s');
						$User->last_login_date_time = date('Y-m-d H:i:s');
						$User->avatar = "default.png";
						$User->type = $request->user_type;
						$User->company_id = $request->user_company;
						$User->reference_type = getUserTypes()[$User->type]['lable'];
						$User->reference_id = 0;
					}
				} else {
					$User = User::find($request->user_id);
				}

				$User_Img = '';
				if ($request->hasFile('select_img')) {
					$request->validate(['select_img' => 'required|image|mimes:jpg,png,gif|max:2048',]);

					$folderPathofFile = '/assets/user_profile';

					$sign_img = $request->file('select_img');


					$fileName1 = uniqid() . '_' . time() . '.' . $sign_img->getClientOriginalExtension();

					$destinationPath = public_path($folderPathofFile);
					if (!File::exists($destinationPath)) {
						File::makeDirectory($destinationPath);
					}

					$sign_img->move($destinationPath, $fileName1);

					$User_Img = $folderPathofFile . '/' . $fileName1;

					$User->avatar = $User_Img;
				};


				$User_Signatuer = '';
				if ($request->hasFile('select_SIGR')) {
					$request->validate(['select_SIGR' => 'required|image|mimes:jpg,png,gif|max:2048',]);

					$folderPathofFile = '/assets/user_sign';

					$sign_img = $request->file('select_SIGR');


					$fileName1 = uniqid() . '_' . time() . '.' . $sign_img->getClientOriginalExtension();

					$destinationPath = public_path($folderPathofFile);
					if (!File::exists($destinationPath)) {
						File::makeDirectory($destinationPath);
					}

					$sign_img->move($destinationPath, $fileName1);

					$User_Signatuer = $folderPathofFile . '/' . $fileName1;

					$User->sign_image = $User_Signatuer;
				}else{
					$User->sign_image = '';

				};
				



				$User->first_name = $request->user_first_name;
				$User->last_name = $request->user_last_name;
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

				$User->status = $request->user_status;
				$User->company_id = $request->user_company;
				$User->branch_id = $request->user_branch;
				if (isset($request->user_joining_date) && $request->user_joining_date != "") {
					$joining_date_time = $request->user_joining_date . " " . date('H:i:s');
					$joining_date_time = date('Y-m-d H:i:s', strtotime($joining_date_time));

					$User->joining_date = $joining_date_time;
				} else {
					$User->joining_date = date('d-m-y');
				}
				$User->save();
				$debugLog = array();
				if ($request->user_id != 0) {
					$debugLog['name'] = "user-edit";
					$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been updated ";
					$response = successRes("Successfully saved user");
				} else {
					$debugLog['name'] = "user-add";
					$debugLog['description'] = "user #" . $User->id . "(" . $User->first_name . " " . $User->last_name . ") has been added ";
					$response = successRes("Successfully added user");
				}
				saveDebugLog($debugLog);
			}

			return response()->json($response)->header('Content-Type', 'application/json');
		}

	}

	public function searchBranch(Request $request)
	{
		$BranchList = array();
		$BranchList = Branch::select('id', 'name as text');

		$BranchList->where('company_id', $request->company_id);
		$BranchList->where('name', 'like', "%" . $request->q . "%");

		$BranchList->limit(5);
		$BranchList = $BranchList->get();

		$response = array();
		$response['results'] = $BranchList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}


	public function detail(Request $request)
	{

		$User = User::with(array('country' => function ($query) {
			$query->select('id', 'name', 'arabic_country_name');
		}, 'state' => function ($query) {
			$query->select('id', 'name', 'arabic_state_name');
		}, 'city' => function ($query) {
			$query->select('id', 'name', 'arabic_city_name');
		}, 'company' => function ($query) {
			$query->select('id', 'name');
		}))->find($request->id);


		if ($User) {

			$branch = Branch::select('id', 'name as text');
			$branch->where('id', $User->branch_id);
			$branch = $branch->get();

			$type = UserType::select('id', 'name as text')->where('id', $User->type)->get();



			$User['sign_image'] = asset("" . $User['sign_image']);
			// $User['profile_pic'] =  $User['avatar'];
			// };
			$response = successRes("Successfully get user");
			$response['data'] = $User;
			$response['data']['branch'] = $branch;
			$response['data']['type'] = $type;
			// }
			// } else {
			// 	$response = errorRes("Invalid user access", 402);
			// }
		} else {
			$response = errorRes("Invalid id");
		}
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	// AXONE WORK START
	public function searchServiceExecutiveType(Request $request)
	{

		$ServiceHierarchy = array();
		$ServiceHierarchy = ServiceHierarchy::select('id', 'name as text');
		$ServiceHierarchy->where('status', 1);
		$ServiceHierarchy->where('name', 'like', "%" . $request->q . "%");
		$ServiceHierarchy->limit(5);
		$ServiceHierarchy = $ServiceHierarchy->get();

		$response = array();
		$response['results'] = $ServiceHierarchy;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function searchServiceExecutiveReportingManager(Request $request)
	{

		if ($request->service_executive_type != "") {

			$ServiceHierarchy = array();
			$ServiceHierarchy = ServiceHierarchy::select('id', 'parent_id');
			$ServiceHierarchy->where('status', 1);
			$ServiceHierarchy->where('id', $request->service_executive_type);
			$ServiceHierarchy = $ServiceHierarchy->get();

			$ServiceHierarchyId = array();
			/// Repeat Code start
			$parentIds = array();
			foreach ($ServiceHierarchy as $key => $value) {
				$ServiceHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$ServiceHierarchy = array();
				$ServiceHierarchy = ServiceHierarchy::select('id', 'parent_id');
				$ServiceHierarchy->where('status', 1);
				$ServiceHierarchy->whereIn('id', $parentIds);
				$ServiceHierarchy = $ServiceHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($ServiceHierarchy as $key => $value) {
				$ServiceHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$ServiceHierarchy = array();
				$ServiceHierarchy = ServiceHierarchy::select('id', 'parent_id');
				$ServiceHierarchy->where('status', 1);
				$ServiceHierarchy->whereIn('id', $parentIds);
				$ServiceHierarchy = $ServiceHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($ServiceHierarchy as $key => $value) {
				$ServiceHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$ServiceHierarchy = array();
				$ServiceHierarchy = ServiceHierarchy::select('id', 'parent_id');
				$ServiceHierarchy->where('status', 1);
				$ServiceHierarchy->whereIn('id', $parentIds);
				$ServiceHierarchy = $ServiceHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($ServiceHierarchy as $key => $value) {
				$ServiceHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$ServiceHierarchy = array();
				$ServiceHierarchy = ServiceHierarchy::select('id', 'parent_id');
				$ServiceHierarchy->where('status', 1);
				$ServiceHierarchy->whereIn('id', $parentIds);
				$ServiceHierarchy = $ServiceHierarchy->get();
			}
			/// Repeat Code end
			/// Repeat Code start
			$parentIds = array();
			foreach ($ServiceHierarchy as $key => $value) {
				$ServiceHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			if (count($parentIds) > 0) {

				$ServiceHierarchy = array();
				$ServiceHierarchy = ServiceHierarchy::select('id', 'parent_id');
				$ServiceHierarchy->where('status', 1);
				$ServiceHierarchy->whereIn('id', $parentIds);
				$ServiceHierarchy = $ServiceHierarchy->get();
			}
			/// Repeat Code end

			$parentIds = array();
			foreach ($ServiceHierarchy as $key => $value) {
				$ServiceHierarchyId[] = $value->id;
				if ($value->parent_id != 0) {
					$parentIds[] = $value->parent_id;
				}
			}

			$ServiceHierarchyId = array_unique($ServiceHierarchyId);
			$ServiceHierarchyId = array_values($ServiceHierarchyId);

			$q = $request->q;

			$query = DB::table('wlmst_service_user');
			$query->leftJoin('users', 'wlmst_service_user.user_id', '=', 'users.id');
			$query->leftJoin('sales_hierarchy', 'sales_hierarchy.id', '=', 'wlmst_service_user.type');
			$query->select('users.id as id', 'wlmst_service_user.type', 'sales_hierarchy.code', DB::raw('CONCAT(first_name," ", last_name) AS text'));
			$query->whereIn('wlmst_service_user.type', $ServiceHierarchyId);
			$query->where('users.type', 11);
			$query->where('users.status', 1);
			// $query->where('users.company_id', $request->user_company_id);
			$query->where('users.reference_id', '!=', 0);
			$query->where('users.id', '!=', $request->user_id);
			$query->where(function ($query) use ($q) {
				$query->where('users.first_name', 'like', '%' . $q . '%');
				$query->orWhere('users.last_name', 'like', '%' . $q . '%');
			});

			$query->limit(5);
			$data = $query->get();

			$data = json_decode(json_encode($data), true);

			foreach ($data as $key => $value) {

				$data[$key]['id'] = "u-" . $value['id'];
				$data[$key]['text'] = $data[$key]['text'] . " (" . $data[$key]['code'] . ")";
				unset($data[$key]['code']);
			}

			$Company = array();
			$Company = Company::select('id', 'name as text');
			$Company->where(function ($query) use ($q) {
				$query->where('name', 'like', '%' . $q . '%');
			});
			$Company = $Company->first();

			if ($Company) {

				$countData = count($data);
				$data[$countData]['id'] = "c-" . $Company['id'];
				$data[$countData]['text'] = $Company->text . " (COMPANY)";
			}

			$response = array();
			$response['results'] = $data;
		} else {
			$response = array();
			$response['results'] = array();
		}

		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function checkUserPhoneNumberAndEmail(Request $request)
	{
		if ($request->is_number ==  1) {
			$rules = array();
			$rules['user_phone_number'] = 'required|digits:10|numeric';

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				$response = errorRes("The request could not be understood by the server due to malformed syntax");
				$response['data'] = $validator->errors();
			} else {
				$User = User::select('id', 'first_name', 'last_name')->where('phone_number', $request->user_phone_number)->first();
				if ($User) {

					$response = errorRes("User already registed with phone number, #" . $User->id . " assigned to " . $User->first_name . " " . $User->last_name);
				} else {
					$response = successRes("User phone number is valid");
				}
			}
		} else if ($request->is_number == 0) {
			$rules = array();
			$rules['user_email'] = 'required';

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				$response = errorRes("The request could not be understood by the server due to malformed syntax");
				$response['data'] = $validator->errors();
			} else {
				$User = User::select('id', 'first_name', 'last_name')->where('email', $request->user_email)->first();
				if ($User) {

					$response = errorRes("User already registed with email, #" . $User->id . " assigned to " . $User->first_name . " " . $User->last_name);
				} else {
					$response = successRes("User Email is valid");
				}
			}
		}
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function selectCountry(Request $request)
	{

		$serach_value = isset($request->q) ? $request->q : "";

		$StateList = array();
		$StateList = CountryList::select('id', 'name as text', 'arabic_country_name');
		$StateList->where('name', 'like', "%" . $serach_value . "%");

		$StateList->limit(5);
		$StateList = $StateList->get();

		$response = array();
		$response['results'] = $StateList;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}

	public function usertype(Request $request)
	{

		$UserType = array();
		$UserType = UserType::select('id', 'name as text');

		$UserType->where('name', 'like', "%" . $request->q . "%");

		$UserType->limit(5);
		$UserType = $UserType->get();

		$response = array();
		$response['results'] = $UserType;
		$response['pagination']['more'] = false;
		return response()->json($response)->header('Content-Type', 'application/json');
	}
	
}
