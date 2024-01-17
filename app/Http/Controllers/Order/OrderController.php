<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrnOrderDetail;
use App\Models\TrnOrder;
use App\Models\CityList;
use App\Models\CountryList;
use App\Models\StateList;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function index()
    {
        $data = array();
        $data['title'] = "Order";
        return view('order/index', compact('data'));
    }

    public function add()
    {
        $data = array();
        $data['title'] = "Add-Order";
        return view('order/add_order', compact('data'));
    }

    public function ajax(Request $request)
    {
        $searchColumns = array(

            0 => 'trn_order.id',
            1 => 'trn_order.customer_name',
            2 => 'trn_order.customer_email',
            3 => 'trn_order.customer_phone_number',
        );

        $columns = array(
            0 => 'trn_order.id',
            1 => 'trn_order.customer_name',
            2 => 'trn_order.customer_email',
            3 => 'trn_order.customer_phone_number',
            4 => 'trn_order.taxable_amount',
            5 => 'trn_order.igst_per',
            6 => 'trn_order.created_at',
            7 => 'trn_order.status',
            8 => 'trn_order.entryby',
            9 => 'trn_order.total_amount',

        );

        $recordsTotal = TrnOrder::count();
        $recordsFiltered = $recordsTotal; // when there is no search parameter then total number rows = total number filtered rows.
        
        $query = TrnOrder::query();
        if(Auth::user()->type == 1){

        }
        // $query->where('entryby', Auth::user()->id);
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
        $data = json_decode(json_encode($data), true);

        if ($isFilterApply == 1) {
            $recordsFiltered = count($data);
        }

        $viewData = array();
        foreach ($data as $key => $value) {

            $viewData[$key] = array();
            $viewData[$key]['id'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">#' . $value['id'] . '</a></h5>
            <p class="text-muted mb-0" data-bs-toggle="tooltip"  data-bs-original-title="' . convertOrderDateTime($value['created_at'], "time") . '" ><a href="javascript:void(0)"  onclick="changeOrderDate(\'' . $value['id'] . '\')" >' . convertOrderDateTime($value['created_at'], "date") . '</a></p>';

            $user = User::select('first_name', 'phone_number')->where('id', $value['entryby'])->first();
            $viewData[$key]['order_by'] =  '<p class="text-muted mb-0">' . $user['first_name'] . '</p><p class="text-muted mb-0">' . $user['phone_number'] . '</p>';

            $viewData[$key]['customer_name'] = '<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">' . $value['customer_name'] . "<br> " . $value['customer_email'] . "<br> " . $value['customer_phone_number'] . '</a></h5>';

            $viewData[$key]['payment_detail'] = '<p class="text-muted mb-0">EXGST&nbsp&nbsp;&nbsp;&nbsp;: <i class="fas fa-rupee-sign"></i> <span class="price-lable-font">' . priceLable($value['taxable_amount']) . '</span></p>

          <p class="text-muted mb-0 ">TOTAL&nbsp;&nbsp;&nbsp;&nbsp: <i class="fas fa-rupee-sign"></i> <span class="price-lable-font">' . priceLable($value['total_amount']) . '</span></p>';

            $viewData[$key]['status'] = getMainMasterStatusLable($value['status']);

            $uiAction = '<ul class="list-inline font-size-20 contact-links z-0">';
            $uiAction .= '<a onclick="ViewOrder(\'' . $value['id'] . '\')" href="javascript: void(0);" title="View"><i class="mdi mdi-eye"></i></a>';
            $viewData[$key]['action'] = $uiAction;
        }
        // ANKIT CHANGE START
        $jsonData = array(
            "draw" => intval($request['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($recordsTotal), // total number of records
            "recordsFiltered" => intval($recordsFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $viewData, // total data array

        );
        return $jsonData;
        // ANKIT CHANGE END
    }

    public function orderEdite(Request $request)
    {
        $Order = TrnOrder::find($request->order_id);
        $Order['created_date'] = date('d/M/Y', strtotime($Order['created_at']));
        if ($Order) {



            $branch = Branch::find($Order->branch_id);
            $county = CountryList::select('id', 'name as text');
            $county->where('id', $branch->country_id);
            $county = $county->first();

            $state = StateList::select('id', 'name as text');
            $state->where('id', $branch->state_id);
            $state = $state->first();

            $city = CityList::select('id', 'name as text');
            $city->where('id', $branch->city_id);
            $city = $city->first();

            $names = compact('state', 'county', 'city');

            $user = User::select('first_name', 'sign_image')->where('id', $Order['entryby'])->first();
            $user['sign_image'] = asset("" . $user['sign_image']);
            $Items = TrnOrderDetail::query();
            $Items->where('order_id', $Order->id);
            $Items = $Items->get();

            $totalVAT = 0;

            foreach ($Items as $key => $value) {
                $totalVAT += $value['item_vat'];
            }

            $company = Company::select('id', 'name as text', 'company_logo')->where('id', $Order->company_id)->first();
            $company['com_logo'] = asset($company['company_logo']);
            $company['company_id'] = $company['id'];

            // $Order['trn_no'] = $Order->trn_no;

            $data['Order'] = $Order;
            $data['Order']['total_item_vat'] = $totalVAT;
            $data['user'] = $user;
            $data['company'] = $company;
            $data['branch'] = $branch;
            $data['items'] = $Items;
            $data['name'] = $names;


            $response = successRes();
            $response['view'] = view('order/comman/modal', compact('data'))->render();
            $response['data'] = $data;
        } else {
            $response = errorRes("Invalid id");
        }


        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function invoicePDF(Request $request)
    {

        $Order = TrnOrder::find($request->order_id);
        $Order['created_date'] = date('d/M/Y', strtotime($Order['created_at']));
        if ($Order) {
            $branch = Branch::find($Order->branch_id);
            $county = CountryList::select('id', 'name as text');
            $county->where('id', $branch->country_id);
            $county = $county->first();

            $state = StateList::select('id', 'name as text');
            $state->where('id', $branch->state_id);
            $state = $state->first();

            $city = CityList::select('id', 'name as text');
            $city->where('id', $branch->city_id);
            $city = $city->first();

            $names = compact('state', 'county', 'city');

            $user = User::select('first_name', 'sign_image')->where('id', $Order['entryby'])->first();
            $user['sign_image'] = asset("" . $user['sign_image']);

            $Items = TrnOrderDetail::query();
            $Items->where('order_id', $Order->id);

            $Items = $Items->get();

            $company = Company::select('id', 'name as text', 'company_logo')->where('id', $Order->company_id)->first();
            $company['com_logo'] = asset($company['company_logo']);
            $company['company_id'] = $company['id'];

            $data['Order'] = $Order;
            $data['user'] = $user;
            $data['company'] = $company;
            $data['branch'] = $branch;
            $data['items'] = $Items;
            $data['name'] = $names;

            // $view = view('order/comman/modal', compact('data'))->render();

            // // $pdf = Pdf::loadView($view);
            // $pdf = PDF::loadView($view);
            // $pdf->setPaper('a4', 'portrait');
            // return  $pdf->download(time() . '_quotation.pdf');

            return PDF::loadView('order/comman/modal', compact('data'))->download($Order['customer_name'] . '.pdf');
            
            // $pdf = app('dompdf.wrapper');
            // $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);

            // $pdf->getDomPDF()->set_option("isRemoteEnabled", true);
            // $pdf->getDomPDF()->set_option("enable_php", true);
            // $pdf->loadHTML($pdf);
            // $response = successRes();
            // $response['view'] = view('order/comman/modal', compact('data'))->render();
            // $response = $view;
            // return response()->json($response)->header('Content-Type', 'application/json');
            // } 



        }
    }

    public function invoiceActive(Request $request)
    {

        $Order = TrnOrder::find($request->id);
        if ($Order) {

            $Order->is_edit = $request->is_edit;
            $Order->save();

            if ($Order->is_edit == 1) {
                $response = successRes("SuccessFully Order Active");
            } else if ($Order->is_edit == 0) {
                $response = successRes("SuccessFully Order Deactive");
            }
            $response['id'] = $Order->id;
        }

        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function compnayDetail(Request $request)
    {

        $SearchValue = isset($request->q) ? $request->q : "";

        $CompanyDetail = array();
        $CompanyDetail = Company::select('id', 'name as text', 'arabic_name');
        $CompanyDetail->where('id', Auth::user()->company_id);
        $CompanyDetail->where('name', 'like', "%" . $SearchValue . "%");
        $CompanyDetail->where('status', 1);
        $CompanyDetail->limit(5);
        $CompanyDetail = $CompanyDetail->get();

        $response = array();
        $response['results'] = $CompanyDetail;
        $response['pagination']['more'] = false;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function detail(Request $request)
    {
        $column = array('mst_branch.*', 'country_list.name as country_name', 'state_list.name as state_name', 'city_list.name as city_name');
        $BranchDetail = Branch::query();
        $BranchDetail->select($column);
        $BranchDetail->where('mst_branch.id', $request->id);
        $BranchDetail->leftJoin('country_list', 'country_list.id', '=', 'mst_branch.country_id');
        $BranchDetail->leftJoin('state_list', 'state_list.id', '=', 'mst_branch.state_id');
        $BranchDetail->leftJoin('city_list', 'city_list.id', '=', 'mst_branch.city_id');
        $BranchDetail = $BranchDetail->get();

        if ($BranchDetail) {
            $response = successRes("Successfully get Branch detail");
            $response['data'] = $BranchDetail;
        } else {
            $response = errorRes("Invalid id");
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
    public function selectState(Request $request)
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

    public function selectCity(Request $request)
    {
        $CityList = array();
        $CityList = CityList::select('id', 'name as text', 'arabic_city_name');
        $CityList->where('country_id', $request->country_id);
        $CityList->where('state_id', $request->state_id);
        $CityList->where('name', 'like', "%" . $request->q . "%");
        $CityList->limit(5);
        $CityList = $CityList->get();

        $response = array();
        $response['results'] = $CityList;
        $response['pagination']['more'] = false;
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function calculation(Request $request)
    {

        if ($request->expectsJson()) {
            $inputJSON = $request->all();
            $orderItems = array();

            foreach ($inputJSON['order_items'] as $key => $value) {

                $orderItems[$key]['item_id'] = $value['item_id'];
                $orderItems[$key]['mrp'] = $value['item_price'];
                $orderItems[$key]['item_name'] = $value['item_name'];
                $orderItems[$key]['item_gold_ct'] = $value['item_gold_ct'];
                $orderItems[$key]['item_diamond_ct'] = $value['item_diamond_ct'];
                $orderItems[$key]['item_design_no'] = $value['item_design_no'];
                $orderItems[$key]['grm'] = number_format((float)($value['item_gram']), 2);
                $orderItems[$key]['qty'] = $value['qty'];

                $orderItems[$key]['Subtotal'] = round($value['qty'] * $value['item_price'], 2);
                $orderItems[$key]['item_vat_gross_amt'] =  round($orderItems[$key]['Subtotal'] / 1.05, 2);
                $orderItems[$key]['item_vat'] = round($orderItems[$key]['Subtotal'] - $orderItems[$key]['item_vat_gross_amt'], 2);
                $orderItems[$key]['discount_percentage'] = 0;
            }
            $company = Company::select('id', 'name', 'arabic_name', 'shortname', 'address_line_1', 'arabic_area', 'arabic_address_line_2', 'arabic_address_line_1', 'area', 'pincode', 'address_line_2', 'company_logo', 'status', 'city_id', 'state_id', 'country_id')->where('id', Auth::user()->company_id)->first();
            $company['com_logo'] = asset($company['company_logo']);

            $branch = Branch::select('id', 'name', 'arabic_name', 'shortname', 'company_id', 'email', 'phone_number', 'address_line_1', 'created_at', 'address_line_2', 'arabic_address_line_1', 'pincode', 'area', 'arabic_area', 'country_id', 'state_id', 'city_id', 'status', 'arabic_address_line_2');
            $branch->where('company_id', $company['id']);
            $branch = $branch->get();

            $user = User::select('id', 'parent_id', 'type', 'first_name', 'last_name', 'email', 'has_email', 'dialing_code', 'phone_number', 'password', 'mpin', 'created_by', 'one_time_password', 'reset_password_token', 'is_changed_password', 'avatar', 'sign_image', 'status', 'reference_type', 'reference_id', 'ctc', 'house_no', 'address_line1', 'address_line2', 'area', 'pincode', 'country_id', 'state_id', 'city_id', 'company_id', 'branch_id', 'last_active_date_time', 'last_login_date_time', 'privilege', 'remember_token', 'is_sent_mail', 'fcm_token', 'no_of_deal', 'joining_date', 'main_contact_id', 'created_at', 'updated_at', 'tag')->where('id', Auth::user()->id)->first();
            $user['sig_img'] = asset($user['sign_image']);

            $GSTPercentage = GSTPercentage();
            $shippingCost = $inputJSON['shipping_cost'];
            $orderDetail = calculationProcessOfOrder($orderItems, $GSTPercentage, $shippingCost);



            $response = successRes("Order detail");
            $response['order'] = $orderDetail;

            $orderCount = TrnOrder::count();
            if ($orderCount != 0) {
                $trn_no = TrnOrder::selectRaw('max(trn_no + 1) as new_trn');
                $trn_no = $trn_no->first();
                $newTrnNo = $trn_no->new_trn;
            }else{
                $newTrnNo = "100282361300001";
            }


            $data = $response;
            $data['client_name'] = $inputJSON['client_name'];
            $data['client_email_address'] = $inputJSON['email_address'];
            $data['client_phone_number'] = $inputJSON['phone_number'];
            $data['client_address'] = $inputJSON['client_address'];
            $data['client_pincode'] = $inputJSON['pincode'];
            $data['client_city'] = $inputJSON['d_city'];
            $data['client_state'] = $inputJSON['d_state'];
            $data['client_country'] = $inputJSON['d_country'];
            $data['company'] = $company;
            $data['new_trn_no'] = $newTrnNo;
            $data['branch'] = $branch;
            $data['user'] = $user;

            // $response['data'] = $data;
            $response['preview'] = view('order/preview', compact('data'))->render();
        } else {

            $response = errorRes("Something went wrong");
        }



        return response()->json($response)->header('Content-Type', 'application/json');
    }


    public function save(Request $request)
    {

        $requestData = $request->input('data');

        // Access values from the JSON data
        $order_customer_name = $requestData['client_name'];
        $order_customer_email = $requestData['client_email_address'];
        $order_customer_phone_number = $requestData['client_phone_number'];
        $order_shipping_address_line_1 = $requestData['client_address'];
        $order_shipping_pincode = $requestData['client_pincode'];
        $order_shipping_country_id = $requestData['client_country'];
        $order_shipping_state_id = $requestData['client_state'];
        $order_shipping_city_id = $requestData['client_city'];
        // $order_customer_company_id = $requestData['company']['id'];
        // $order_customer_branch_id = $requestData['branch'][0]['id'];
        // $order_vat_per = 5; // You can set this variable to a fixed value, for example

        $items = $requestData['items'][0];

        if (count($items) >= 1) {
            // Initialize order totals
            $total_item = count($items);
            $total_qty = 0;
            $total_amount = 0;
            $grossAmount = 0;
            $itemVat_grossAMT = 0;

            // Calculate order totals
            foreach ($items as $value) {
                if (isset($value['qty']) && intval($value['qty']) != 0) {
                    $SubTotal = floatval($value['mrp']) * floatval($value['qty']);
                    $total_qty += $value['qty'];
                    $total_amount += $SubTotal;

                    $Discount_Amount = floatval($SubTotal) * floatval($value['discount_percentage']) / 100;
                    $GAmount = floatval($SubTotal) - floatval($Discount_Amount);

                    $itemVat_grossAMT += floatval($GAmount) / 1.05;

                    $grossAmount += $GAmount;
                }
            }

            // Calculate GST and other order values
            $GSTAmount = floatval($grossAmount) + (floatval($grossAmount) / 1.05);
            $order_vat_amount = (floatval($grossAmount) / 1.05);
            $Roundup_Amount = floatval($GSTAmount) - floatval(round($GSTAmount));
            $Net_Amount = round($GSTAmount);


            $orderCount = TrnOrder::count();
            if ($orderCount != 0) {
                $trn_no = TrnOrder::selectRaw('max(trn_no + 1) as new_trn');
                $trn_no = $trn_no->first();
                $newTrnNo = $trn_no->new_trn;
            }else{
                $newTrnNo = "100282361300001";
            }

            // Create the order
            $Order = new TrnOrder();
            $Order->customer_name = $order_customer_name;
            $Order->customer_email = $order_customer_email;
            $Order->customer_phone_number = $order_customer_phone_number;
            $Order->company_id = Auth::user()->company_id;
            $Order->branch_id = Auth::user()->branch_id;
            $Order->shipping_address_line_1 = (isset($order_shipping_address_line_1)) ? isset($order_shipping_address_line_1) : "";
            $Order->shipping_pincode = (isset($order_shipping_pincode)) ? isset($order_shipping_pincode) : 0;
            $Order->shipping_country_id = (isset($order_shipping_country_id)) ? isset($order_shipping_country_id) : 0;
            $Order->shipping_state_id = (isset($order_shipping_state_id)) ? isset($order_shipping_state_id) : 0;
            $Order->shipping_city_id = (isset($order_shipping_city_id)) ? isset($order_shipping_city_id) : 0;
            $Order->total_item = $total_item;
            $Order->total_qty = $total_qty;
            $Order->total_amount = $total_amount;
            $Order->trn_no = $newTrnNo;
            $Order->igst_per = '0.00';
            $Order->igst_amount = '0.00';
            $Order->cgst_per = '0.00';
            $Order->cgst_amount = '0.00';
            $Order->sgst_per = '0.00';
            $Order->sgst_amount = '0.00';
            $Order->add_amount = '0.00';
            $Order->less_amount = '0.00';
            $Order->taxable_amount = $itemVat_grossAMT;
            $Order->roundup_amount = $Roundup_Amount;
            $Order->net_amount = $Net_Amount;
            $Order->status = 1;
            $Order->source = "WEB";
            $Order->entryby = Auth::user()->id; // Live
            $Order->entryip = $request->ip();
            $Order->updateby = Auth::user()->id; // Live
            $Order->updateip = $request->ip();

            $Order->save();

            if ($Order) {
                foreach ($items as $value) {

                    $SubTotal = floatval($value['mrp']) * floatval($value['qty']);



                    $Discount_Amount = floatval($SubTotal) * floatval($value['discount_percentage']) / 100;
                    $GroosAmount = floatval($SubTotal) - floatval($Discount_Amount);

                    $itemVat_grossAMT = floatval($SubTotal) / 1.05;

                    $item_vat = floatval($SubTotal) - floatval($itemVat_grossAMT);

                    $Roundup_Amount = floatval($GroosAmount) - floatval(round($GroosAmount));
                    $Net_amount = round($GroosAmount);

                    $Order_item = new TrnOrderDetail();
                    $Order_item->company_id = $Order->company_id;
                    $Order_item->branch_id = $Order->branch_id;
                    $Order_item->order_id = $Order->id;
                    $Order_item->item_name = $value['item_name'];
                    $Order_item->item_design_no = $value['item_design_no'];
                    $Order_item->item_gold_ctc = $value['item_gold_ct'];
                    $Order_item->item_diamond_ctc = $value['item_diamond_ct'];
                    $Order_item->item_weight = $value['grm'];
                    $Order_item->item_amount_aed = $value['mrp'];
                    $Order_item->item_price = $value['mrp'];
                    $Order_item->item_qty = $value['qty'];
                    $Order_item->disc_per = $value['discount_percentage'];
                    $Order_item->disc_amount = $Discount_Amount;
                    $Order_item->gross_amount = $GroosAmount;
                    $Order_item->add_amount = '0.00';
                    $Order_item->less_amount = '0.00';
                    $Order_item->taxable_amount = $GroosAmount;
                    $Order_item->roundup_amount = $Roundup_Amount;
                    $Order_item->item_vat = $item_vat;
                    $Order_item->item_vat_gross_amt = $itemVat_grossAMT;
                    $Order_item->net_amount = $Net_amount;
                    $Order_item->source = "WEB";
                    $Order_item->entryby = Auth::user()->id; // Live
                    $Order_item->entryip = $request->ip();
                    $Order_item->updateby = Auth::user()->id; // Live
                    $Order_item->updateip = $request->ip();

                    $Order_item->save();
                }
                $response = successRes("Successfully Created Invoice");
            }
        } else {
            $response = errorRes("No order items found.");
        }

        // $response = successRes();
        // $response['data'] = $requestData;
        return response()->json($response)->header('Content-Type', 'application/json');
    }
}
