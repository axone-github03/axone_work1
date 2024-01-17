<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Models\TrnOrder;
use App\Models\TrnOrderDetail;
use App\Models\Company;
use App\Models\Branch;
use App\Models\CountryList;
use App\Models\CityList;
use App\Models\StateList;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Mike42\Escpos\Printer;
use PHPUnit\Util\Printer as UtilPrinter;

class InvoiceController extends Controller
{
    function save(Request $request)
    {
        $response = [];
        $request_data = $request->input();
        $validator = Validator::make($request->input(), [
            'order' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = [];
            $response['status'] = 0;
            $response['msg'] = $validator->errors()->first();
            $response['statuscode'] = 400;
            $response['data'] = $validator->errors();
        } else {
            $order_id = $request['order'][0]['id'];
            $order_customer_name = $request['order'][0]['customer_name'];
            $order_customer_email = $request['order'][0]['customer_email'];
            $order_customer_phone_number = $request['order'][0]['customer_phone_number'];
            $order_customer_company_id = $request['order'][0]['company_id'];
            $order_customer_branch_id = $request['order'][0]['branch_id'];
            $order_shipping_address_line_1 = $request['order'][0]['shipping_address_line_1'];
            $order_shipping_address_line_2 = $request['order'][0]['shipping_address_line_2'];
            $order_shipping_pincode = $request['order'][0]['shipping_pincode'];
            $order_shipping_area = $request['order'][0]['shipping_area'];
            $order_shipping_country_id = $request['order'][0]['shipping_country_id'];
            $order_shipping_state_id = $request['order'][0]['shipping_state_id'];
            $order_shipping_city_id = $request['order'][0]['shipping_city_id'];
            $order_vat_per = $request['order'][0]['vat_per'];

            if ($order_id != 0) {
                if (count($request_data['order_item']) >= 1) {
                    $total_item = 0;
                    $total_item = count($request['order_item']);
                    $total_qty = 0;
                    $total_amount = 0;
                    $grossAmount = 0;
                    $itemVat_grossAMT = 0;

                    foreach ($request_data['order_item'] as $value) {
                        if (intval($value['item_qty']) != 0) {
                            $SubTotal = floatval($value['item_amount_aed']) * floatval($value['item_qty']);
                            $total_qty += $value['item_qty'];
                            $total_amount += $SubTotal;

                            $Discount_Amount = (floatval($SubTotal) * floatval($value['disc_per'])) / 100;
                            $GAmount = floatval($SubTotal) - floatval($Discount_Amount);
                            $grossAmount += $GAmount;
                            $itemVat_grossAMT += floatval($GAmount) / 1.05;
                        }
                    }

                    $GSTAmount = floatval($grossAmount) + (floatval($grossAmount) * floatval($order_vat_per)) / 100;
                    $order_vat_amount = (floatval($grossAmount) * floatval($order_vat_per)) / 100;
                    $Roundup_Amount = floatval($GSTAmount) - floatval(round($GSTAmount));
                    $Net_Amount = round($GSTAmount);

                    $Order = TrnOrder::find($order_id);
                    // Find the last order with the highest trn_no
                    $lastOrder = TrnOrder::orderBy('trn_no', 'desc')->first();

                    // Set the initial trn_no value

                    // If there is a last order, extract the trn_no
                    if ($lastOrder) {
                        $lastTrnNo = $lastOrder->trn_no;

                        // Check if the last trn_no is not zero
                        if ($lastTrnNo == '0') {
                            $newTrnNo = '100282361300001';
                        } else {
                            $newTrnNo = (int) $lastTrnNo + 1;
                        }
                    } else {
                        $newTrnNo = '100282361300001';
                    }

                    // Create the order
                    $Order->customer_name = $order_customer_name;
                    $Order->customer_email = $order_customer_email;
                    $Order->customer_phone_number = $order_customer_phone_number;
                    $Order->company_id = $order_customer_company_id;
                    $Order->branch_id = $order_customer_branch_id;
                    $Order->shipping_address_line_1 = isset($order_shipping_address_line_1) ? isset($order_shipping_address_line_1) : '';
                    $Order->shipping_pincode = isset($order_shipping_pincode) ? isset($order_shipping_pincode) : 0;
                    $Order->shipping_country_id = isset($order_shipping_country_id) ? isset($order_shipping_country_id) : 0;
                    $Order->shipping_state_id = isset($order_shipping_state_id) ? isset($order_shipping_state_id) : 0;
                    $Order->shipping_city_id = isset($order_shipping_city_id) ? isset($order_shipping_city_id) : 0;
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
                    $Order->source = 'APP';
                    $Order->updateby = Auth::user()->id; // Live
                    $Order->updateip = $request->ip();

                    $Order->save();
                    if ($Order) {
                        $Order_item = TrnOrderDetail::where('order_id', $Order->id)->delete();
                        foreach ($request_data['order_item'] as $value) {
                            $SubTotal = floatval($value['item_amount_aed']) * floatval($value['item_qty']);

                            $Discount_Amount = (floatval($SubTotal) * floatval($value['disc_per'])) / 100;
                            $GroosAmount = floatval($SubTotal) - floatval($Discount_Amount);

                            $item_vat_gross_amt = floatval($GroosAmount) / 1.05;

                            $item_vat = floatval($GroosAmount) - floatval($item_vat_gross_amt);

                            $Roundup_Amount = floatval($GroosAmount) - floatval(round($GroosAmount));
                            $Net_amount = round($GroosAmount);

                            $Order_item = new TrnOrderDetail();
                            $Order_item->company_id = $Order->company_id;
                            $Order_item->branch_id = $Order->branch_id;
                            $Order_item->order_id = $Order->id;
                            $Order_item->item_name = $value['item_name'];
                            $Order_item->item_design_no = $value['item_design_no'];
                            $Order_item->item_gold_ctc = $value['item_gold_ctc'];
                            $Order_item->item_diamond_ctc = $value['item_diamond_ctc'];
                            $Order_item->item_weight = $value['item_weight'];
                            $Order_item->item_amount_aed = $value['item_amount_aed'];
                            $Order_item->item_price = $value['item_price'];
                            $Order_item->item_qty = $value['item_qty'];
                            $Order_item->disc_per = $value['disc_per'];
                            $Order_item->disc_amount = $Discount_Amount;
                            $Order_item->gross_amount = $GroosAmount;
                            $Order_item->add_amount = '0.00';
                            $Order_item->less_amount = '0.00';
                            $Order_item->taxable_amount = $GroosAmount;
                            $Order_item->roundup_amount = $Roundup_Amount;
                            $Order_item->item_vat = $item_vat;
                            $Order_item->item_vat_gross_amt = $item_vat_gross_amt;
                            $Order_item->net_amount = $Net_amount;
                            $Order_item->source = 'APP';
                            $Order_item->entryby = Auth::user()->id; //Live
                            $Order_item->entryip = $request->ip();
                            $Order_item->updateby = Auth::user()->id; //Live
                            $Order_item->updateip = $request->ip();

                            $Order_item->save();

                            $response = successRes('Invoice Successfully Updated');
                        }
                    }
                } else {
                    $response = errorRes('Something Wrong');
                }
            } else {
                if (count($request_data['order_item']) >= 1) {
                    $total_item = 0;
                    $total_item = count($request['order_item']);

                    $total_qty = 0;
                    $total_amount = 0;
                    $grossAmount = 0;
                    $itemVat_grossAMT = 0;

                    foreach ($request_data['order_item'] as $value) {
                        if (intval($value['item_qty']) != 0) {
                            $SubTotal = floatval($value['item_amount_aed']) * floatval($value['item_qty']);
                            $total_qty += $value['item_qty'];
                            $total_amount += $SubTotal;

                            $Discount_Amount = (floatval($SubTotal) * floatval($value['disc_per'])) / 100;
                            $GAmount = floatval($SubTotal) - floatval($Discount_Amount);

                            $grossAmount += $GAmount;
                            $itemVat_grossAMT += floatval($GAmount) / 1.05;
                        }
                    }

                    $GSTAmount = floatval($grossAmount) + (floatval($grossAmount) * floatval($order_vat_per)) / 100;
                    $order_vat_amount = (floatval($grossAmount) * floatval($order_vat_per)) / 100;
                    $Roundup_Amount = floatval($GSTAmount) - floatval(round($GSTAmount));
                    $Net_Amount = round($GSTAmount);

                    $orderCount = TrnOrder::count();
                    if ($orderCount != 0) {
                        $trn_no = TrnOrder::selectRaw('max(trn_no + 1) as new_trn');
                        $trn_no = $trn_no->first();
                        $newTrnNo = $trn_no->new_trn;
                    } else {
                        $newTrnNo = '100282361300001';
                    }

                    // Create the order
                    $Order = new TrnOrder();
                    $Order->customer_name = $order_customer_name;
                    $Order->customer_email = $order_customer_email;
                    $Order->customer_phone_number = $order_customer_phone_number;
                    $Order->company_id = $order_customer_company_id;
                    $Order->branch_id = $order_customer_branch_id;
                    $Order->shipping_address_line_1 = isset($order_shipping_address_line_1) ? isset($order_shipping_address_line_1) : '';
                    $Order->shipping_pincode = isset($order_shipping_pincode) ? isset($order_shipping_pincode) : 0;
                    $Order->shipping_country_id = isset($order_shipping_country_id) ? isset($order_shipping_country_id) : 0;
                    $Order->shipping_state_id = isset($order_shipping_state_id) ? isset($order_shipping_state_id) : 0;
                    $Order->shipping_city_id = isset($order_shipping_city_id) ? isset($order_shipping_city_id) : 0;
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
                    $Order->source = 'APP';
                    $Order->entryby = Auth::user()->id; // Live
                    $Order->entryip = $request->ip();
                    $Order->updateby = Auth::user()->id; // Live
                    $Order->updateip = $request->ip();

                    $Order->save();
                    if ($Order) {
                        foreach ($request_data['order_item'] as $value) {
                            $SubTotal = floatval($value['item_amount_aed']) * floatval($value['item_qty']);

                            $Discount_Amount = (floatval($SubTotal) * floatval($value['disc_per'])) / 100;
                            $GroosAmount = floatval($SubTotal) - floatval($Discount_Amount);

                            $Roundup_Amount = floatval($GroosAmount) - floatval(round($GroosAmount));
                            $Net_amount = round($GroosAmount);

                            $item_vat_gross_amt = floatval($GroosAmount) / 1.05;

                            $item_vat = floatval($GroosAmount) - floatval($item_vat_gross_amt);

                            $Order_item = new TrnOrderDetail();
                            $Order_item->company_id = $Order->company_id;
                            $Order_item->branch_id = $Order->branch_id;
                            $Order_item->order_id = $Order->id;
                            $Order_item->item_name = $value['item_name'];
                            $Order_item->item_design_no = $value['item_design_no'];
                            $Order_item->item_gold_ctc = $value['item_gold_ctc'];
                            $Order_item->item_diamond_ctc = $value['item_diamond_ctc'];
                            $Order_item->item_weight = $value['item_weight'];
                            $Order_item->item_amount_aed = $value['item_amount_aed'];
                            $Order_item->item_price = $value['item_price'];
                            $Order_item->item_qty = $value['item_qty'];
                            $Order_item->disc_per = $value['disc_per'];
                            $Order_item->disc_amount = $Discount_Amount;
                            $Order_item->gross_amount = $GroosAmount;
                            $Order_item->add_amount = '0.00';
                            $Order_item->less_amount = '0.00';
                            $Order_item->item_vat = $item_vat;
                            $Order_item->item_vat_gross_amt = $item_vat_gross_amt;
                            $Order_item->taxable_amount = $GroosAmount;
                            $Order_item->roundup_amount = $Roundup_Amount;
                            $Order_item->net_amount = $Net_amount;
                            $Order_item->source = 'APP';
                            $Order_item->entryby = Auth::user()->id; //Live
                            $Order_item->entryip = $request->ip();
                            $Order_item->updateby = Auth::user()->id; //Live
                            $Order_item->updateip = $request->ip();

                            $Order_item->save();

                            $response = successRes('Invoice Successfully Created');
                        }
                    }
                } else {
                    $response = errorRes('Something Wrong');
                }
            }
        }
        return response()
            ->json($response)
            ->header('Content-Type', 'application/json');
    }

    function invoiceList(Request $request)
    {
        $searchColumns = [
            0 => 'trn_order.id',
            1 => 'trn_order.customer_name',
            2 => 'trn_order.customer_email',
            3 => 'trn_order.customer_phone_number',
        ];

        $searchKeyword = isset($request->q) ? $request->q : '';

        $Order = TrnOrder::query();
        $Order->orderBy('id', 'DESC');
        if (isset($searchKeyword)) {
            $search_value = $searchKeyword;
            $Order->where(function ($query) use ($search_value, $searchColumns) {
                for ($i = 0; $i < count($searchColumns); $i++) {
                    if ($i == 0) {
                        $query->where($searchColumns[$i], 'like', '%' . $search_value . '%');
                    } else {
                        $query->orWhere($searchColumns[$i], 'like', '%' . $search_value . '%');
                    }
                }
            });
        }
        $Order = $Order->get();
        $Order = json_decode(json_encode($Order), true);
        foreach ($Order as $key => $value) {
            $Order[$key]['created_date'] = date('d/M/Y', strtotime($value['created_at']));
        }
        $response = successRes();
        $response['data'] = $Order;
        return $response;
    }

    function InvoiceDetail(Request $request)
    {
        if (!$request->has('order_id')) {
            $response = errorRes('Order ID is missing in the request.');
            return $response;
        } else {
            $selectColumns = ['trn_order.*', 'mst_branch.name as branch_name', 'mst_branch.shortname as branch_shortname', 'mst_branch.email as branch_email', 'mst_branch.phone_number as branch_phone_number', 'mst_branch.address_line_1 as branch_address_line_1', 'mst_branch.address_line_2 as branch_address_line_2', 'mst_branch.pincode as branch_pincode', 'mst_branch.area as branch_area', 'mst_branch.country_id as branch_country_id', 'mst_branch.state_id as branch_state_id', 'mst_branch.city_id as branch_city_id'];

            $Order = DB::table('trn_order');
            $Order->select($selectColumns);
            $Order->leftJoin('mst_branch', 'mst_branch.id', '=', 'trn_order.branch_id');
            $Order->where('trn_order.id', $request->order_id);
            $Order = $Order->first();

            $Order = json_decode(json_encode($Order), true);

            if ($Order) {
                $Order_Detail = TrnOrderDetail::query()
                    ->where('order_id', $request->order_id)
                    ->get();
                $Order['Order_detail'] = $Order_Detail;

                $totalVAT = 0;

                foreach ($Order['Order_detail'] as $key => $value) {
                    $totalVAT += round($value['item_vat'], 2);
                }
                $Order['total_item_vat'] = $totalVAT;

                $country = CountryList::select('id', 'name as text');
                $country->where('id', $Order['branch_country_id']);
                $country = $country->first();
                $Order['branch_country_id'] = $country;

                $state_id = StateList::select('id', 'name as text');
                $state_id->where('id', $Order['branch_state_id']);
                $state_id = $state_id->first();

                $Order['branch_state_id'] = $state_id;

                $city_id = CityList::select('id', 'name as text');
                $city_id->where('id', $Order['branch_city_id']);
                $city_id = $city_id->first();
                $Order['branch_city_id'] = $city_id;

                $Order = json_decode(json_encode($Order), true);
                $Order['created_date'] = date('d/M/Y', strtotime($Order['created_at']));

                $response = successRes();
                $response['data'] = $Order;
                return $response;
            } else {
                $response = errorRes('Order ID is not Found');
                return $response;
            }
        }
    }

    public function searchCountry(Request $request)
    {
        $searchKeyword = isset($request->q) ? $request->q : '';

        $CountryList = CountryList::select('id', 'name as text');
        $CountryList->where('name', 'like', '%' . $searchKeyword . '%');
        $CountryList->limit(15);

        $CountryList = $CountryList->get();
        $response = successRes('CountryList');
        $response['data'] = $CountryList;
        return response()
            ->json($response, $response['status_code'])
            ->header('Content-Type', 'application/json');
    }

    public function searchState(Request $request)
    {
        $searchKeyword = isset($request->q) ? $request->q : '';

        $StateList = StateList::select('id', 'name as text');
        $StateList->where('name', 'like', '%' . $searchKeyword . '%');
        $StateList->where('country_id', $request->country_id);
        $StateList->limit(15);

        $StateList = $StateList->get();
        $response = successRes('StateList');
        $response['data'] = $StateList;
        return response()
            ->json($response, $response['status_code'])
            ->header('Content-Type', 'application/json');
    }

    public function searchCity(Request $request)
    {
        $searchKeyword = isset($request->q) ? $request->q : '';

        $CityList = CityList::select('id', 'name as text');
        $CityList->where('name', 'like', '%' . $searchKeyword . '%');
        $CityList->where('state_id', $request->state_id);
        $CityList->where('status', 1);
        $CityList->limit(15);
        $CityList = $CityList->get();
        $response = [];
        $response = successRes('CityList');
        $response['data'] = $CityList;
        return response()
            ->json($response, $response['status_code'])
            ->header('Content-Type', 'application/json');
    }

    public function searchCompany(Request $request)
    {
        $searchKeyword = isset($request->q) ? $request->q : '';

        $CompanyList = Company::select('id', 'name as text');
        $CompanyList->where('name', 'like', '%' . $searchKeyword . '%');
        $CompanyList->where('status', 1);
        $CompanyList->limit(5);
        $CompanyList = $CompanyList->get();
        $response = [];
        $response = successRes('CompanyList');
        $response['data'] = $CompanyList;
        return response()
            ->json($response, $response['status_code'])
            ->header('Content-Type', 'application/json');
    }

    public function searchBranch(Request $request)
    {
        $searchKeyword = isset($request->q) ? $request->q : '';

        $BranchList = Branch::select('id', 'name as text');
        $BranchList->where('name', 'like', '%' . $searchKeyword . '%');
        $BranchList->where('company_id', $request->company_id);
        $BranchList->where('status', 1);
        $BranchList->limit(5);
        $BranchList = $BranchList->get();
        $response = [];
        $response = successRes('BranchList');
        $response['data'] = $BranchList;
        return response()
            ->json($response, $response['status_code'])
            ->header('Content-Type', 'application/json');
    }

    public function searchPrinter(Request $request)
    {
        $searchKeyword = isset($request->q) ? $request->q : '';
        // Rawilk\Printing\Contracts\Printer
        $PrinterList = shell_exec('wmic printer get name');
        // $PrinterList = exec('wmic printer get name', $output, $exitCode);
        // $PrinterList = exec("AcroRd32.exe /t \"C:\Users\ankit\Downloads\EVA%20JEWELLERS.html.pdf\"", $output, $exitCode);
        // $PrinterList = UtilPrinter::class;
        // if ($exitCode === 0) {
        //     return "File successfully sent to the printer.";
        // } else {
        //     return "Error: Unable to print the file.";
        // }
        $response = [];
        $response = successRes('Peinter List');
        $response['data'] = $PrinterList;
        return response()->json($response, $response['status_code'])->header('Content-Type', 'application/json');
    }

    public function postDownloadInvoice(Request $request)
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

            $user = User::select('first_name', 'sign_image')
                ->where('id', $Order['entryby'])
                ->first();
            $user['sign_image'] = asset('' . $user['sign_image']);

            $Items = TrnOrderDetail::query();
            $Items->where('order_id', $Order->id);
            $Items = $Items->get();

            $totalVAT = 0;

            foreach ($Items as $key => $value) {
                $totalVAT += $value['item_vat'];
            }

            $company = Company::select('id', 'name as text', 'company_logo')
                ->where('id', $Order->company_id)
                ->first();
            $company['com_logo'] = asset($company['company_logo']);
            $company['company_id'] = $company['id'];

            $data['Order'] = $Order;
            $data['Order']['total_item_vat'] = $totalVAT;
            $data['user'] = $user;
            $data['company'] = $company;
            $data['branch'] = $branch;
            $data['items'] = $Items;
            $data['name'] = $names;

            $view = view('order/comman/modal', compact('data'))->render();
            // $pdf = app('dompdf.wrapper');
            // $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
            // $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
            // $pdf->getDomPDF()->set_option('enable_php', true);


            // $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);
            // $pdf->setOption('fontPath', public_path('font/')); // Path to your fonts directory
            // $pdf->setOption('fontData', [
            //     'arialuni' => [
            //         'R' => 'arialuni.ttf',
            //         'useOTL' => 0xff, // required for complicated langs like Arabic
            //         'useKashida' => 75, // required for complicated langs like Arabic
            //     ],
            // ]);
            // // $pdf->setDefaultFont('arialuni');

            // $pdf->loadHTML($view);

            // $filePath = public_path('mamiya_invoice/' . $Order['customer_name'] . '.pdf');
            // $pdf->save($filePath);

            // $response = successRes('Success');
            // $fileSize = filesize($filePath);

            // $response['data']['size'] = $fileSize;
            // $response['data']['url'] = url('mamiya_invoice/' . $Order['customer_name'] . '.pdf');
            $response = successRes();
            $response['data']['size'] = "";
            $response['data']['url'] = "";
            $response['data']['view'] = $view;
            return response()
                ->json($response)
                ->header('Content-Type', 'application/json');
        }
    }

    // public function DownloadInvoice(Request $request) {

    //     $data = array();
    //     $Order = TrnOrder::find($request->order_id);
    //     $Order['created_date'] = date('d/M/Y', strtotime($Order['created_at']));
    //     if ($Order) {
    //         $branch = Branch::find($Order->branch_id);
    //         $county = CountryList::select('id', 'name as text');
    //         $county->where('id', $branch->country_id);
    //         $county = $county->first();

    //         $state = StateList::select('id', 'name as text');
    //         $state->where('id', $branch->state_id);
    //         $state = $state->first();

    //         $city = CityList::select('id', 'name as text');
    //         $city->where('id', $branch->city_id);
    //         $city = $city->first();

    //         $names = compact('state', 'county', 'city');

    //         $user = User::select('first_name', 'sign_image')
    //             ->where('id', $Order['entryby'])
    //             ->first();
    //         $user['sign_image'] = asset('' . $user['sign_image']);

    //         $Items = TrnOrderDetail::query();
    //         $Items->where('order_id', $Order->id);

    //         $Items = $Items->get();

    //         $company = Company::select('id', 'name as text', 'company_logo')
    //             ->where('id', $Order->company_id)
    //             ->first();
    //         $company['com_logo'] = asset($company['company_logo']);
    //         $company['company_id'] = $company['id'];

    //         $data['Order'] = $Order;
    //         $data['user'] = $user;
    //         $data['company'] = $company;
    //         $data['branch'] = $branch;
    //         $data['items'] = $Items;
    //         $data['name'] = $names;

    //         $view = view('order/comman/modal', compact('data'))->render();
    //     }

    //     $response = successRes();
    //     $response['data'] = $view;
    //     return response()->json($response)->header('Content-Type', 'application/json');
    // }
}
