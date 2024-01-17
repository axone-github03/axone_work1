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


class MasterLocationStateController extends Controller
{
    public function index()
    {
        $data = array();
        $data['title'] = "State List";
        $data['country_list'] = CountryList::get();
        return view('master/location/state', compact('data'));
    }

    function ajax(Request $request)
    {
        $searchColumns = array(
            0 => 'state_list.id',
            1 => 'state_list.name',
        );

        $columns = array(
            0 => 'state_list.id',
            1 => 'state_list.name',
            2 => 'state_list.country_id',
            3 => 'state_list.arabic_state_name',
            4 => 'state_list.created_at',
            5 => 'country_list.name as country_name',
            6 => 'country_list.arabic_country_name',
        );

        $recordsTotal = StateList::count();
        $recordsFiltered = $recordsTotal; // when there is no search parameter then total number rows = total number filtered rows.

        $query = StateList::query();
        $query->leftJoin('country_list', 'country_list.id', '=', 'state_list.country_id');
        $query->select($columns);
        $query->limit($request->length);
        $query->offset($request->start);
        $query->orderBy($columns[$request['order'][0]['column']], $request['order'][0]['dir']);
        $isFilterApply = 0;

        if (isset($request['search']['value'])) {
            $isFilterApply = 1;
            $search_value = $request['search']['value'];
            $query->where(function ($query) use ($search_value, $searchColumns) {
                for ($i = 0; $i < count($searchColumns); $i++) {
                    if ($i == 0) {
                        $query->where($searchColumns[$i], 'like', "%" . $search_value . "%");
                    } else {
                        $query->orWhere($searchColumns[$i], 'like', "%" . $search_value . "%");
                    }
                }
            });
        }

        $data = $query->get();
        // echo "<pre>";
        // print_r(DB::getQueryLog());
        // die;

        $data = json_decode(json_encode($data), true);

        if ($isFilterApply == 1) {
            $recordsFiltered = count($data);
        }

        foreach ($data as $key => $value) {
            $data[$key]['id'] = '<div class="avatar-xs"><span class="avatar-title rounded-circle">' . $value['id'] . '</span></div>';

            $data[$key]['country_name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $data[$key]['country_name'] . '</a></h5>
            <p class="text-muted mb-0">' . $data[$key]['arabic_country_name'] . '</p>';

            $data[$key]['name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $data[$key]['name'] . '</a></h5>
            <p class="text-muted mb-0">' . $data[$key]['arabic_state_name'] . '</p>';

            $data[$key]['created_at'] = convertDateTime($value['created_at']);
            $uiAction = '<ul class="list-inline font-size-20 contact-links mb-0">';

            $uiAction .= '<li class="list-inline-item px-2">';
            $uiAction .= '<a onclick="editView(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Edit"><i class="bx bx-edit-alt"></i></a>';
            $uiAction .= '</li>';

            $uiAction .= '</ul>';
            $data[$key]['action'] = $uiAction;
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

        $data = new StateList();

        $data->country_id = $request->country_id;
        $data->name = $request->state_name;
        $data->arabic_state_name = $request->arabic_state_name;

        $data->save();
        $response = successRes("Successfully saved country");
        $response['data'] = $data;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function selectCountry(Request $request)
    {
        $country = array();
        $country = CountryList::select('id', 'name as text', 'arabic_country_name');
        $country->limit(5);
        $country = $country->get();

        $response = array();
        $response['results'] = $country;
        $response['pagination']['more'] = false;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    function edite(Request $request)
    {

        $state = StateList::find($request->id);
        if ($state) {

            $country = CountryList::select('id', 'name as text', 'arabic_country_name')->where('id', $state->country_id)->get();

            $response = successRes("Successfully get state detail");
            $response['data'] = $state;
            $response['country'] = $country;
        } else {
            $response = errorRes("Invalid id");
        }
        return response()->json($response)->header('Content-Type', 'application/json');
    }
}
