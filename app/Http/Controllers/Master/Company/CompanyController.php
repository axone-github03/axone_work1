<?php

namespace App\Http\Controllers\Master\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CityList;
use App\Models\StateList;
use App\Models\CountryList;
use App\Models\MstLog;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Redirect;
use Nette\Utils\Paginator;

class CompanyController extends Controller
{
    public function index()
    {
        $data = array();
        $data['title'] = "Company Master";
        return view('master/company/index', compact('data'));
    }
    public function insert(Request $request)
    {
        if ($request->id != 0) {
            $data = Company::find($request->id);

            $chng_filed = "";
            $source = "Web";
            $arry = array();
            $i = 0;
            if ($data->name != $request->name) {
                $new_value = $request->name;
                $old_value = $data->name;
                $filed_name = "name";
                $chng_filed = "Client Name Chang : " . $old_value . " to " . $new_value;

                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }
            if ($data->arabic_name != $request->arabic_name) {
                $new_value = $request->arabic_name;
                $old_value = $data->arabic_name;
                $filed_name = "arabic_name";
                $chng_filed = "Client arabic_Name Chang : " . $old_value . " to " . $new_value;

                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->shortname != $request->shortname) {
                $new_value = $request->shortname;
                $old_value = $data->shortname;
                $filed_name = "shortname";
                $chng_filed = "Client shortname chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->address_line_1 != $request->address_line_1) {
                $new_value = $request->address_line_1;
                $old_value = $data->address_line_1;
                $filed_name = " address_line_1";
                $chng_filed = "Client address_line_1 chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->address_line_2 != $request->address_line_2) {
                $new_value = $request->second_eddress;
                $old_value = $data->address_line_2;
                $filed_name = "address_line_2";
                $chng_filed = "Client address_line_2 chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }
            if ($data->arabic_address_line_1 != $request->arabic_address_line_1) {
                $new_value = $request->second_eddress;
                $old_value = $data->arabic_address_line_1;
                $filed_name = "arabic_address_line_1";
                $chng_filed = "Client arabic_address_line_1 chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }
            if ($data->arabic_address_line_2 != $request->arabic_address_line_2) {
                $new_value = $request->second_eddress;
                $old_value = $data->arabic_address_line_2;
                $filed_name = "arabic_address_line_2";
                $chng_filed = "Client arabic_address_line_2 chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->pincode != $request->pincode) {
                $new_value = $request->pincode;
                $old_value = $data->pincode;
                $filed_name = "pincode";
                $chng_filed = "Client pincode chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->area != $request->area) {
                $new_value = $request->area;
                $old_value = $data->area;
                $filed_name = "area";
                $chng_filed = "Client area chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }
            if ($data->arabic_area != $request->arabic_area) {
                $new_value = $request->arabic_area;
                $old_value = $data->arabic_area;
                $filed_name = "arabic_area";
                $chng_filed = "Client arabic_area chang : " . $old_value . " to " . $new_value;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->country_id != $request->country_id) {
                $Newcountyname = CountryList::select('name')->find($request->country_id);
                if ($Newcountyname) {
                    $New_country_name = $Newcountyname->name;
                } else {
                    $New_country_name = "";
                }
                $new_value = $request->country_id;
                $OldCountyName = CountryList::select('name')->find($data->city_id);
                if ($OldCountyName) {
                    $Old_country_name = $OldCountyName->name;
                } else {
                    $Old_country_name = "";
                }
                $old_value = $data->country_id;
                $filed_name = "country_id";
                $chng_filed = "Client country_name chang : " . $New_country_name . " to " . $Old_country_name;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->state_id != $request->state_id) {
                $Newstatename = StateList::select('name')->find($request->state_id);
                if ($Newstatename) {
                    $New_state_name = $Newstatename->name;
                } else {
                    $New_state_name = "";
                }
                $new_value = $request->state_id;
                $OldstateName = StateList::select('name')->find($data->city_id);
                if ($OldstateName) {
                    $Old_state_name = $OldstateName->name;
                } else {
                    $Old_state_name = "";
                }
                $old_value = $data->state_id;
                $filed_name = "state";
                $chng_filed = "Client state_name chang : " . $New_state_name . " to " . $Old_state_name;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }

            if ($data->city_id != $request->city_id) {
                $Newcityname = CityList::select('name')->find($request->city_id);
                if ($Newcityname) {
                    $New_city_name = $Newcityname->name;
                } else {
                    $New_city_name = "";
                }
                $new_value = $request->city_id;
                $OldcityName = CityList::select('name')->find($data->city_id);
                if ($OldcityName) {
                    $Old_city_name = $OldcityName->name;
                } else {
                    $Old_city_name = "";
                }
                $old_value = $data->city_id;
                $filed_name = "city";
                $chng_filed = "Client city_name chang : " . $New_city_name . " to " . $Old_city_name;
                $arry[$i]['filed_name'] = $filed_name;
                $arry[$i]['old_value'] = $old_value;
                $arry[$i]['new_value'] = $new_value;
                $arry[$i]['chng_filed'] = $chng_filed;
                $i++;
            }
        } else {
            $arry = array();
            $data = new  Company();
            $data->entry_by = Auth::user()->id;
            $data->entry_ip = $request->ip();
        }

        $company_images = '';
        if ($request->hasFile('company_logo')) {
            $request->validate(['company_logo' => 'required|image|mimes:jpg,png,gif|max:2048',]);

            $folderPathofFile = '/assets/images/company_img';

            $avatar = $request->file('company_logo');


            $fileName1 = uniqid() . '_' . time() . '.' . $avatar->getClientOriginalExtension();

            $destinationPath = public_path($folderPathofFile);
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath);
            }

            $avatar->move($destinationPath, $fileName1);

            $company_images = $folderPathofFile . '/' . $fileName1;

            $data->company_logo = $company_images;
        };

        $data->name = $request->name;
        $data->arabic_name = $request->arabic_name;
        $data->shortname = $request->shortname;
        $data->address_line_1 = $request->address_line_1;
        $data->address_line_2 = $request->address_line_2;
        $data->arabic_address_line_1 = $request->arabic_address_line_1;
        $data->arabic_address_line_2 = $request->arabic_address_line_2;
        $data->pincode = $request->pincode;
        $data->area = $request->area;
        $data->arabic_area = $request->arabic_area;
        $data->country_id = $request->country_id;
        $data->state_id = $request->state_id;
        $data->city_id = $request->city_id;
        $data->status = $request->main_status;
        $data->source = "web";
        $data->update_by = Auth::user()->id;
        $data->update_ip = $request->ip();
        $data->save();


        if ($data) {

            foreach ($arry as $val) {

                $product = new MstLog();

                $product->user_id = Auth::user()->id;
                $product->company_id = 0;
                $product->log_type = "company_edited";
                $product->field_name = $val['filed_name'];
                $product->old_value = $val['old_value'];
                $product->new_value = $val['new_value'];
                $product->transaction_type = 'Company';
                $product->transaction_id = $request->id;
                $product->description = $val['chng_filed'];
                $product->source = $source;
                $product->entryby = Auth::user()->id;
                $product->entryip = $request->ip();
                $product->updateby = Auth::user()->id;
                $product->updateip = $request->ip();
                $product->save();
            }
        }

        $response = successRes("Successfully saved item master");
        $response['data'] = $arry;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function selectSate(Request $request)
    {

        $serach_value = isset($request->q) ? $request->q : "";

        $StateList = array();
        $StateList = StateList::select('id', 'name as text', 'arabic_state_name');
        $StateList->where('country_id', $request->country_id);

        $StateList->where('name', 'like', "%" . $serach_value . "%");

        $StateList->limit(5);
        $StateList = $StateList->get();

        $response = array();
        $response['results'] = $StateList;
        $response['pagination']['more'] = false;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function SelectCity(Request $request)
    {
        $searchKeyword = isset($request->q) ? $request->q : "";
        $CityList = array();
        $CityList = CityList::select('id', 'name as text', 'arabic_city_name');
        $CityList->where('country_id', $request->country_id);
        $CityList->where('state_id', $request->state_id);
        $CityList->where('name', 'like', "%" . $searchKeyword . "%");
        $CityList->limit(5);
        $CityList = $CityList->get();

        $response = array();
        $response['results'] = $CityList;
        $response['pagination']['more'] = false;
        return response()->json($response)->header('Content-Type', 'application/json');
    }
    function searchCountry(Request $request)
    {

        $searchKeyword = isset($request->q) ? $request->q : "";
        $CountryList = array();
        $CountryList = CountryList::select('id', 'name as text', 'arabic_country_name');
        $CountryList->where('name', 'like', $searchKeyword . "%");
        $CountryList->limit(5);
        $CountryList = $CountryList->get();
        $response = array();
        $response['results'] = $CountryList;
        $response['pagination']['more'] = false;
        return response()->json($response)->header('Content-Type', 'application/json');
    }
    public function ajex(Request $request)
    {
        $searchColumns = array(
            0 => 'mst_company.id',
            1 => 'mst_company.name',
        );
        $colums = array(
            0 => 'mst_company.id',
            1 => 'mst_company.name',
            2 => 'mst_company.shortname',
            3 => 'mst_company.address_line_1',
            4 => 'mst_company.address_line_2',
            5 => 'mst_company.pincode',
            6 => 'mst_company.area',
            7 => 'mst_company.city_id',
            8 => 'mst_company.status',
            9 => 'mst_company.arabic_address_line_1',
            10 => 'mst_company.arabic_address_line_2',
            11 => 'mst_company.arabic_name',
        );

        $recodeTotal = Company::count();
        $recodFilterd = $recodeTotal;

        $query = Company::query();
        $query->select($colums);
        $query->limit($request->length);
        $query->offset($request->start);
        $query->orderBy($colums[$request['order'][0]['column']], $request['order'][0]['dir']);
        $isfilterapply = 0;

        if (isset($request['search']['value'])) {
            $isfilterapply = 1;
            $search_Value = $request['search']['value'];

            $query->where(function ($query) use ($search_Value, $searchColumns) {
                for ($i = 0; $i < count($searchColumns); $i++) {
                    if ($i == 0) {
                        $query->where($searchColumns[$i], 'like', "%" . $search_Value . "%");
                    } else {
                        $query->orWhere($searchColumns[$i], 'like', "%" . $search_Value . "%");
                    }
                }
            });
        }

        $data = $query->get();
        $data = json_decode(json_encode($data), true);
        if ($isfilterapply == 1) {
            $recodFilterd = count($data);
        }

        foreach ($data as $key => $value) {
            $data[$key]['id'] = '<div class="avatar-xs">' . $value['id'] . '</div>';
            $data[$key]['name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $value['name'] . ' <br>' . $value['arabic_name'] . '</a></h5>';
            $data[$key]['address'] =  '<p class="text-muted mb-0">' . $value['address_line_1'] . ', ' . $value['address_line_2'] . '</p>';
            $data[$key]['address_arabic'] =  '<p class="text-muted mb-0">' . $value['arabic_address_line_1'] . ', ' . $value['arabic_address_line_2'] . '</p>';

            $data[$key]['status'] = getMainMasterStatusLable($value['status']);
            $uiAction = '<ul class="list-inline font-size-20 contact-links mb-0"><li class="list-inline-item px-2"><a class="me-2" onclick="editData(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Edit"><i class="bx bx-edit-alt text-info"></i></a><a onclick="deleteData(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Delete"><i class="bx bx-trash-alt text-danger"></i></a></li></ul>';
            // $uiAction = '<ul class="list-inline font-size-20 contact-links z-0">';
            // $uiAction .= '<a onclick="editedata(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Edit"><i class="bx bx-edit-alt"></i></a>';
            // $uiAction .= '<a onclick="delete_warning(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Delete"><i class="bx bx-trash-alt"></i></a>';
            $data[$key]['action'] = $uiAction;
        }
        $jsondata = array(
            "draw" => intval($request['draw']),
            'recordsTotal' => intval($recodeTotal),
            'recordsFiltered' => intval($recodFilterd),
            'data' => $data,
            "search" => $request['search']['value'],
        );
        return $jsondata;
    }


    public function EditData(Request $request)
    {
        $mainhouse = Company::find($request->id);
        if ($mainhouse) {


            $state = StateList::select('id', 'name as text', 'arabic_state_name')->where('id', $mainhouse->state_id)->first();
            $CountryList = CountryList::select('id', 'name as text', 'arabic_country_name')->where('id', $mainhouse->country_id)->first();
            $city = CityList::select('id', 'name as text', 'arabic_city_name')->where('id', $mainhouse->city_id)->first();

            $mainhouse['company_img'] = asset('' . $mainhouse['company_logo']);
            // $status = master_wearhouse::select('id', 'name as text')->where('id', $mainhouse->status)->first();

            $response = successRes("Successfully get quotation item master");
            $response['data'] = $mainhouse;
            $response['data']['state'] = $state;
            $response['data']['city'] = $city;
            $response['data']['country'] = $CountryList;
            // $response['data']['status'] = $status;
        } else {
            $response = errorRes("Invalid id");
        }

        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function deleteData(Request $request)
    {

        $data = Company::find($request->id);

        if ($data) {
            $data->delete();
        }
        $response = successRes("Successfully delete file");
        return response()->json($response)->header('Content-Type', 'application/json');
    }
}
