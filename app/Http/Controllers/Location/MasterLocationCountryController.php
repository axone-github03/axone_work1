<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\CityList;
use App\Models\CountryList;
use App\Models\StateList;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class MasterLocationCountryController extends Controller
{

	public function index()
	{

		$data = array();
		$data['title'] = "Country List";
		return view('master/location/country', compact('data'));
	}

	function ajax(Request $request)
	{

		$columns = array(
			// datatable column index  => database column name
			0 => 'country_list.id',
			1 => 'country_list.name',
			2 => 'country_list.arabic_country_name',
			3 => 'country_list.created_at',

		);

		$recordsTotal = DB::table('country_list')->count();
		$recordsFiltered = $recordsTotal; // when there is no search parameter then total number rows = total number filtered rows.

		$query = DB::table('country_list');
		$query->select('country_list.id', 'country_list.name', 'country_list.arabic_country_name', 'country_list.created_at');
		$query->limit($request->length);
		$query->offset($request->start);
		$query->orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir']);
		$isFilterApply = 0;

		if (isset($request['search']['value'])) {
			$isFilterApply = 1;
			$search_value = $request['search']['value'];

			$query->where(function ($query) use ($search_value) {
				$query->where('country_list.code', 'like', "%" . $search_value . "%")
					->orWhere('country_list.name', 'like', "%" . $search_value . "%")->orWhere('country_list.id', 'like', "%" . $search_value . "%");
			});
		}
		$data = $query->get();
		$data = json_decode(json_encode($data), true);

		if ($isFilterApply == 1) {
			$recordsFiltered = count($data);
		}

		foreach ($data as $key => $val) {
			$data[$key]['id'] = '<div class="avatar-xs"><span class="avatar-title rounded-circle">' . $val['id'] . '</span></div>';
			$data[$key]['country_name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $val['name'] . '</a></h5>';
			$data[$key]['arabic_country_name'] =  '<p class="text-muted mb-0">' . $val['arabic_country_name'] . '</p>';

			$data[$key]['created_at'] = convertDateTime($val['created_at']);
			$uiAction = '<ul class="list-inline font-size-20 contact-links mb-0">';

			$uiAction .= '<li class="list-inline-item px-2">';
			$uiAction .= '<a onclick="editView(\'' . $val['id'] . '\')" href="javascript: void(0);" title="Edit"><i class="bx bx-edit-alt"></i></a>';
			$uiAction .= '</li>';

			$uiAction .= '</ul>';
			$data[$key]['action'] = $uiAction;
			// $data[$key]['flag'] = '<img id="header-lang-img" src="' . URL('/') . "/assets/images/flags/" . $val['name'] . ".jpg" . '" height="16">';
		}

		$jsonData = array(
			"draw" => intval($request['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal" => intval($recordsTotal), // total number of records
			"recordsFiltered" => intval($recordsFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data, // total data array

		);
		return $jsonData;
	}

	public function save(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'country_name' => ['required'],
			'arabic_country_name' => ['required'],
		]);

		if ($validator->fails()) {

			$response = array();
			$response['status'] = 0;
			$response['msg'] = "Please fill required filed.";
			$response['statuscode'] = 400;
			$response['data'] = $validator->errors();
		} else {

			$alreadyCountry = CountryList::query();
			$alreadyCountry->where('name', $request->country_name);
			if ($request->id != 0) {
				$alreadyCountry->where('id', '!=', $request->id);
			}
			$alreadyCountry = $alreadyCountry->first();

			if ($alreadyCountry) {

				$response = errorRes("Already name exists, Try with another name");
			} else {

				if ($request->id != 0) {
					$CityList = CountryList::find($request->id);
				} else {
					$CityList = new CountryList();
				}

				$CityList->name = $request->country_name;
				$CityList->arabic_country_name = $request->arabic_country_name;
				$CityList->code = 0;
				$CityList->save();
				$response = successRes("Successfully added Country");
			}
		}

		return response()->json($response)->header('Content-Type', 'application/json');
	}

	function edite(Request $request)
	{

		$country = CountryList::find($request->id);
		if ($country) {

			$response = successRes("Successfully get Country detail");
			$response['data'] = $country;
		} else {
			$response = errorRes("Invalid id");
		}
		return response()->json($response)->header('Content-Type', 'application/json');
	}
}
