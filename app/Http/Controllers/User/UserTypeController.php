<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CountryList;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;

class UserTypeController extends Controller {
    public function index()
    {
        
        $data = array();
		$data['title'] = "User Type Master";

		return view('users/user_type', compact('data'));
    }


    public function save(Request $request)
    {
        if ($request->id != 0) {
            $data = UserType::find($request->id);
        } else {
            $arry = array();
            $data = new  UserType();
        }
        $data->name = $request->name;
        $data->remark = $request->remark;
        $data->status = $request->user_type_status;
        $data->entryby = Auth::user()->id;
        $data->entryip = $request->ip();
        $data->updateby = Auth::user()->id;
        $data->updateip = $request->ip();
        $data->save();

        $response = successRes("Successfully Saved User Type");
        $response['data'] = $arry;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function ajax(Request $request)
    {
        $searchColumns = array(
            0 => 'mst_user_type.id',
            1 => 'mst_user_type.name',
        );
        $colums = array(
            0 => 'mst_user_type.id',
            1 => 'mst_user_type.name',
            2 => 'mst_user_type.status',
        );

        $recodeTotal = UserType::count();
        $recodFilterd = $recodeTotal;

        $query = UserType::query();
        
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
            $data[$key]['name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $value['name'] . '</a></h5>';
            $data[$key]['status'] = getMainMasterStatusLable($value['status']);
            $uiAction = '<ul class="list-inline font-size-20 contact-links mb-0"><li class="list-inline-item px-2"><a class="me-2" onclick="editdata(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Edit"><i class="bx bx-edit-alt"></i></a><a onclick="deleteData(\'' . $value['id'] . '\')" href="javascript: void(0);" title="Delete"><i class="bx bx-trash-alt"></i></a></li></ul>';
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

    public function detail(Request $request)
    {
        $mainhouse = UserType::find($request->id);
        if ($mainhouse) {

            $response = successRes("Successfully get quotation item master");
            $response['data'] = $mainhouse;
        } else {
            $response = errorRes("Invalid id");
        }

        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function delete(Request $request)
    {

        $data = UserType::find($request->id);

        if ($data) {
            $data->delete();
        }
        $response = successRes("Successfully delete User Type");
        return response()->json($response)->header('Content-Type', 'application/json');
    }
}