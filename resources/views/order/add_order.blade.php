@extends('layouts.main')
@section('title', $data['title'])
@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->

            <!-- end page title -->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="formOrder" method="POST" action="">

                                @csrf
                                <div class="row">

                                    <div class="col-lg-4">


                                        <div class="mb-3">

                                            <label class="form-label">Bill From</label>
                                            <select class="form-select" id="company_bill" name="company_bill">
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-lg-8">
                                        <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                            <label class="form-label">Bill to</label>
                                            <div class="button">
                                                <button type="button" class="btn btn-primary" id=""
                                                    data-bs-toggle="modal" data-bs-target="#addClientModal"> <i
                                                        class="mdi mdi-plus me-1"></i>
                                                    Add Client
                                                </button>

                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row col-4">
                                        <div class="col-lg-6 d-none mb-2" id="branch_address_show">
                                            <div class="popovercontainer address-group ember-view">
                                                <div class="ember-view">
                                                    <div class="ember-view">
                                                        <div class="address-list">
                                                            <span data-ember-action="" data-ember-action-3935="3935">
                                                                <span
                                                                    class="text-muted text-uppercase font-small d-inline-block mb-2">
                                                                    <b>Branch Address</b>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span id="branch_address_line1_text"></span><br>
                                                            <span id="branch_address_line2_text"></span><br>
                                                            <span id="branch_pincode_text"></span><br>
                                                            <span id="branch_country_id_text"></span><br>
                                                            <span id="branch_state_id_text"></span>
                                                            <span id="branch_city_id_text"></span>
                                                            <input type="hidden" name="branch_id" id="branch_id">
                                                            <input type="hidden" name="branch_address_line1"
                                                                id="branch_address_line1">
                                                            <input type="hidden" name="branch_address_line2"
                                                                id="branch_address_line2">
                                                            <input type="hidden" name="branch_pincode" id="branch_pincode">
                                                            <input type="hidden" name="branch_country_id"
                                                                id="branch_country_id">
                                                            <input type="hidden" name="branch_state_id"
                                                                id="branch_state_id">
                                                            <input type="hidden" name="branch_city_id" id="branch_city_id">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-8" style="margin-left: 10px">
                                        <div class="col-lg-6 d-none mb-2" id="client_detail_address_show">
                                            <div class="popovercontainer address-group ember-view">
                                                <div class="ember-view">
                                                    <div class="ember-view">
                                                        <div class="address-list">
                                                            <span data-ember-action="" data-ember-action-3935="3935">
                                                                <span
                                                                    class="text-muted text-uppercase font-small d-inline-block mb-2">
                                                                    <b>Client Details</b>
                                                                    <a class="d-none" data-bs-toggle="modal"
                                                                        id="clientEditeButton"
                                                                        data-bs-target="#addClientModal">&nbsp;&nbsp;<i
                                                                            class="bi bi-pencil-square w-50"></i></a>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span id="client_detail_name_text"></span><br>
                                                            <span id="client_detail_number_text"></span><br>
                                                            <span id="client_detail_email_text"></span><br>
                                                            <span id="client_detail_address_line1_text"></span>&nbsp;
                                                            <span id="client_detail_pincode_text"></span><br>
                                                            <span id="client_detail_country_text_"></span><br>
                                                            <span id="client_detail_state_text_"></span>&nbsp;
                                                            <span id="client_detail_city_text_"></span><br>
                                                            <input type="hidden" name="client_detail_name"
                                                                id="client_detail_name">
                                                            <input type="hidden" name="client_detail_number"
                                                                id="client_detail_number">
                                                            <input type="hidden" name="client_detail_email"
                                                                id="client_detail_email">
                                                            <input type="hidden" name="client_detail_address_line1"
                                                                id="client_detail_address_line1">
                                                            <input type="hidden" name="client_detail_pincode"
                                                                id="client_detail_pincode">
                                                            <input type="hidden" name="client_detail_country_id"
                                                                id="client_detail_country_id">
                                                            <input type="hidden" name="client_detail_state_id"
                                                                id="client_detail_state_id">
                                                            <input type="hidden" name="client_detail_city_id"
                                                                id="client_detail_city_id">
                                                            <input type="hidden" name="client_detail_country_text"
                                                                id="client_detail_country_text">
                                                            <input type="hidden" name="client_detail_state_text"
                                                                id="client_detail_state_text">
                                                            <input type="hidden" name="client_detail_city_text"
                                                                id="client_detail_city_text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="me-3" style="width: 120px">
                                    <input type="hidden" value="" name="input_product_id[]" >
                                    <input type="text" class="input_product_id"  value="" id="input_product_id" name="input_qty[]">
                                </div> --}}


                                <div class="row" id="seaction_order_items">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">


                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">



                                                            <input type="hidden" class="form-control product-qty-cls"
                                                                id="product_qty" name="product_qty" placeholder="QTY"
                                                                value="0">


                                                        </div>
                                                    </div>
                                                </div>





                                                <div class="table-responsive w-100">
                                                    <table class="table align-middle mb-0 table-nowrap">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Item Design No</th>
                                                                <th>Item Name</th>
                                                                <th>Gold CT </th>
                                                                <th>Diamond CT</th>
                                                                <th>Gram</th>
                                                                <th>Quantity </th>
                                                                <th>Price</th>
                                                                <th>Vat 5%</th>
                                                                <th>Payable Amt</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="cartTbody">


                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-11">

                                                    </div> <!-- end col -->
                                                    <div class="col-md">
                                                        <div class="mb-3 ajax-select">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#addItemModal">
                                                                <i class="mdi mdi-plus me-1"></i> Add Items
                                                            </button>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row-->

                                            </div>

                                        </div>
                                    </div><br>
                                    <div class="col-xl-8"></div>

                                    <div class="col-xl-4">

                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-3">Order Summary</h4>

                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>Total MRP :</td>
                                                                <td><i class="fas fa-rupee-sign"></i> <span
                                                                        id="order_summary_order_total_mrp"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total Discount : - </td>
                                                                <td class="text-danger"><i class="fas fa-rupee-sign"></i>
                                                                    <span id="order_summary_order_total_discount">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ex. VAT (Order value) :</td>
                                                                <td><i class="fas fa-rupee-sign"></i> <span
                                                                        id="order_summary_order_vat_value"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Estimated Tax (GST) - <span
                                                                        id="order_summary_order_gst_percentage"></span>% :
                                                                </td>
                                                                <td><i class="fas fa-rupee-sign"></i> <span
                                                                        id="order_summary_order_gst_value"></td>
                                                            </tr>
                                                            <tr>

                                                                <th>Total:</th>
                                                                <th><i class="fas fa-rupee-sign"></i> <span
                                                                        id="order_summary_order_payable_total"></span></th>
                                                                <input type="hidden" id="verify_payable_total"
                                                                    name="verify_payable_total" accept="">
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end table-responsive -->
                                            </div>
                                            <div class="col-sm-12 mb-4">
                                                <div class="text-sm-end mt-2 mt-sm-0">
                                                    <button type="button" disabled id="btnCheckOut"
                                                        class="btn btn-success">
                                                        <i class="mdi mdi-cart-arrow-right me-1"></i> Checkout
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>




                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <div class="modal fade" id="modalOrderPreviw" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        role="dialog" aria-labelledby="modalOrderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6 text-sm-end">
                        <button id="btnPlaceOrder" type="button" class="btn btn-success waves-effect waves-light">Place
                            Order</button>

                        <button id="btnPlaceOrderCancel" data-bs-dismiss="modal" aria-label="Close" type="button"
                            class="btn btn-warning waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Add Items Modal -->
    <div class="modal" id="addItemModal" tabindex="-1" aria-labelledby="addClientModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="itemForm" method="post">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="item_design_no" class="form-label">Item Design No <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="text" class="form-control" id="item_design_no" name="item_design_no"
                                    placeholder="Item Design No" value="" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="item_name" class="form-label">Item Name <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    placeholder="Item Name" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_gold_ct" class="form-label">Gold CT <code
                                            class="highlighter-rouge">*</code></label>
                                    <input type="number" class="form-control" id="item_gold_ct" name="item_gold_ct"
                                        placeholder="Gold CT" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_diamond_ct" class="form-label">Diamond CT <code
                                            class="highlighter-rouge">*</code></label>
                                    <input type="number" class="form-control" id="item_diamond_ct"
                                        name="item_diamond_ct" placeholder="Diamond CT" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_gram" class="form-label">Gram <code
                                            class="highlighter-rouge">*</code></label>
                                    <input type="number" class="form-control" id="item_gram" name="item_gram"
                                        placeholder="Gram" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_quantity" class="form-label">Quantity <code
                                            class="highlighter-rouge">*</code></label>
                                    <input type="number" class="form-control" id="item_quantity" name="item_quantity"
                                        placeholder="Quantity" value="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="item_price" class="form-label">Price <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="number" class="form-control" id="item_price" name="item_price"
                                    placeholder="Price" value="" required>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="itemSave">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--Add Client Modal -->
    <div class="modal" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="clicntForm" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden" name="client_id" id="client_id">
                                    <label for="client_name" class="form-label">Client Name <code
                                            class="highlighter-rouge">*</code></label>
                                    <input type="text" class="form-control" id="client_name" name="client_name"
                                        placeholder="Client Name" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email_address" class="form-label">Email Address <code
                                            class="highlighter-rouge">*</code></label>
                                    <input type="email" class="form-control" id="email_address" name="email_address"
                                        placeholder="Email Address" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number <code
                                            class="highlighter-rouge">*</code></label>
                                    <input type="number" class="form-control" id="phone_number" name="phone_number"
                                        placeholder="Phone Number" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_address" class="form-label">Address </label>
                                    <input type="text" class="form-control" id="client_address" name="client_address"
                                        placeholder="Client Address" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_country_id" class="form-label">Country </label>
                                    <select class="form-select" id="client_country_id"
                                        aria-label="Disabled select example" name="client_country_id">
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select country.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                    <label class="form-label">State</label>
                                    <select class="form-control select2-ajax" id="client_state_id"
                                        aria-label="Disabled select example" name="client_state_id" required>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select state.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                    <label class="form-label">City</label>
                                    <select class="form-control select2-ajax" id="client_city_id"
                                        aria-label="Disabled select example" name="client_city_id" required>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select city.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                    <label class="form-label">Pincode</label>
                                    <input type="number" class="form-control" id="pincode" name="pincode"
                                        placeholder="Pincode" value="" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveClient()">Save</button>
                </div>
            </div>
        </div>
    </div>


@endsection('content')
@section('custom-scripts')
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/order.js') }}"></script>


    <script type="text/javascript">
        var csrfToken = $("[name=_token").val();
        var ajaxURLCompanyDetail = '{{ route('order.company.detail') }}'
        var ajaxURLBranchDetail = '{{ route('order.branch.detail') }}'
        var ajaxURLSerachCountry = '{{ route('order.select.country') }}'
        var ajaxURLSerachState = '{{ route('order.select.state') }}'
        var ajaxURLSerachCity = '{{ route('order.select.city') }}'
        var ajaxURLOrderCalculation = '{{ route('order.calculation') }}'
        var ajaxURLOrderSave = '{{ route('order.save') }}'
        var reditectURL = '{{ route('users.order.index') }}';

        $("#seaction_credit").hide();
        $("#seaction_order_items").hide();
        $("#product_qty").val(1);
        var channelPartnerObject = {};

        var currentProduct = {};
        var orderItems = [];
        var productIds = [];
        var shippingCost = 0;
        var itemIdCounter = 1;
        var itemArray = [];
        // var OrderArry = [];

        $(document).ready(function() {
            var options = {
                beforeSubmit: showRequest, // pre-submit callback
                success: showResponse // post-submit callback

                // other available options:
                //url:       url         // override for form's 'action' attribute
                //type:      type        // 'get' or 'post', override for form's 'method' attribute
                //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
                //clearForm: true        // clear all form fields after successful submit
                //resetForm: true        // reset the form after successful submit

                // $.ajax options can be used here too, for example:
                //timeout:   3000
            };

            // bind form using 'ajaxForm'
            $('#formOrder').ajaxForm(options);
        });

        function showRequest(formData, jqForm, options) {

            // formData is an array; here we use $.param to convert it to a string to display it
            // but the form plugin does this for you automatically when it submits the data
            var queryString = $.param(formData);

            // jqForm is a jQuery object encapsulating the form element.  To access the
            // DOM element for the form do this:
            // var formElement = jqForm[0];

            // alert('About to submit: \n\n' + queryString);

            // here we could return false to prevent the form from being submitted;
            // returning anything other than false will allow the form submit to continue
            return true;
        }
        // post-submit callback
        function showResponse(responseText, statusText, xhr, $form) {
            if (responseText['status'] == 1) {
                toastr["success"](responseText['msg']);
                orderItems = [];
                productIds = [];
                // orderCalculationProcess();
            } else if (responseText['status'] == 0) {
                toastr["error"](responseText['msg']);
            }
        }

        $("#btnCheckOut").click(function() {
            orderCalculationProcess();
            $("#modalOrderPreviw").modal('show');



        });

        function orderCalculationProcess() {

            itemArray = [];
            // OrderArry = [];
            if (orderItems.length > 0) {
                $("#btnCheckOut").prop('disabled', false);
            } else {
                $("#btnCheckOut").prop('disabled', true);
            }

            var requestData = {
                'shipping_cost': shippingCost,
                'order_items': orderItems,
                'item_id': itemIdCounter,
                'company_bill': $("#company_bill").val(),
                'client_name': $("#client_detail_name").val(),
                'email_address': $("#client_detail_email").val(),
                'phone_number': $('#client_detail_number').val(),
                'client_address': $('#client_detail_address_line1').val(),
                'pincode': $('#client_detail_pincode').val(),
                'd_country': $('#client_detail_country_id').val(),
                'd_state': $('#client_detail_state_id').val(),
                'd_city': $('#client_detail_city_id').val(),
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    "content-type": "application/json"
                },
                type: 'POST',
                url: ajaxURLOrderCalculation,
                data: JSON.stringify(requestData),
                success: function(resultData) {
                    itemArray.push(resultData['order']['items']);
                    // OrderArry.push(resultData['order']);

                    $("#cartTbody").html('');

                    if (resultData['status'] == 1) {

                        $("#modalOrderPreviw .modal-body").html(resultData['preview']);

                        for (var i = 0; i < resultData['order']['items'].length; i++) {
                            var htmlTR = '<tr>';
                            htmlTR += '<td>';
                            htmlTR += '<h5 class="font-size-14 text-truncate">';
                            htmlTR += '</h5>';
                            htmlTR += '<p class="mb-0"><span class="fw-medium">' + (resultData['order']['items']
                                [i]['item_design_no'] || '') + '</span></p>';
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<h5 class="font-size-14 text-truncate">';
                            htmlTR += '</h5>';
                            htmlTR += '<p class="mb-0"><span class="fw-medium">' + (resultData['order']['items']
                                [i]['item_name'] || '') + '</span></p>';
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<i class="fas fa-rupee-sign"></i>' + numberWithCommas(resultData['order']
                                ['items'][i]['item_gold_ct'] || 0);
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<i class="fas fa-rupee-sign"></i>' + numberWithCommas(resultData['order']
                                ['items'][i]['item_diamond_ct'] || 0);
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<i class="fas fa-rupee-sign"></i>' + numberWithCommas(resultData['order']
                                ['items'][i]['grm'] || 0);
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<div class="me-3" style="width: 120px">';
                            htmlTR += '<input type="hidden" value="' + resultData['order']['items'][i][
                                    'item_id'
                                ] +
                                '" name="input_product_id[]" ><input type="text" class="input_product_id"  value="' +
                                resultData['order']['items'][i]['qty'] + '" id="input_product_id_' + resultData[
                                    'order']['items'][i]['item_id'] + '" name="input_qty[]">';
                            htmlTR += '</div>';
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<i class="fas fa-rupee-sign"></i>' + numberWithCommas(resultData['order']
                                ['items'][i]['mrp'] || 0);
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<i class="fas fa-rupee-sign"></i>' + numberWithCommas(resultData['order']
                                ['items'][i]['item_vat'] || 0);
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<i class="fas fa-rupee-sign"></i>' + numberWithCommas(resultData['order']
                                ['items'][i]['item_vat_gross_amt'] || 0);
                            htmlTR += '</td>';
                            htmlTR += '<td>';
                            htmlTR += '<a href="javascript:void(0);" onclick="removeProduct(' + (resultData[
                                    'order']['items'][i]['item_id'] || '') +
                                ')" class="action-icon text-danger"> <i class="mdi mdi-trash-can font-size-18"></i></a>';
                            htmlTR += '</td>';
                            htmlTR += '</tr>';
                            $("#cartTbody").append(htmlTR);
                        }

                        $(".input_product_id").TouchSpin({
                            min: 1,
                            max: 1000,
                        }).on('change', function() {
                            console.log($(this).val());
                        });

                        $("#order_summary_order_total_mrp").html(numberWithCommas(resultData['order'][
                            'total_item_vat_gross_amt'
                        ] || 0));
                        $("#order_summary_order_total_discount").html(numberWithCommas(resultData['order'][
                            'total_discount'
                        ] || 0));
                        $("#order_summary_order_vat_value").html(numberWithCommas(resultData['order'][
                            'total_item_vat'
                        ] || 0));
                        $("#order_summary_order_gst_percentage").html(numberWithCommas(resultData['order'][
                            'gst_percentage'
                        ] || 0));
                        $("#order_summary_order_gst_value").html(numberWithCommas(resultData['order'][
                            'gst_tax'
                        ] || 0));
                        $("#order_summary_order_payable_total").html(numberWithCommas(resultData['order'][
                            'total_item_bill_amt'
                        ] || 0));
                        $("#verify_payable_total").val(resultData['order']['Net_Amount'] || '');
                    } else {
                        toastr["error"](resultData['msg']);
                    }

                }
            });
        }

        function removeProduct(productId) {
            for (var i = 0; i < orderItems.length; i++) {
                if (orderItems[i]['item_id'] == productId) {
                    orderItems.splice(i, 1);
                    break;
                }
            }
            // Now, after removing the item, call orderCalculationProcess()
            orderCalculationProcess();
        }

        $(document).delegate('.input_product_id', 'change', function() {


            var newQty = $(this).val();
            var selectedProductId = $(this).attr("id");
            updateCartQty(newQty, selectedProductId)



        });

        $(document).delegate('.input_product_id', 'keyup', function() {


            var newQty = $(this).val();
            var selectedProductId = $(this).attr("id");
            updateCartQty(newQty, selectedProductId)



        });


        function updateCartQty(newQty, selectedProductId) {

            var selectedProductIdPieces = selectedProductId.split("_");
            var changeProductId = selectedProductIdPieces[selectedProductIdPieces.length - 1];

            for (var i = 0; i < orderItems.length; i++) {
                if (orderItems[i]['item_id'] == changeProductId) {
                    orderItems[i]['qty'] = parseFloat(newQty);
                    break;
                    console.log(newQty);
                }

            }
            orderCalculationProcess();

        }




        $(document).delegate('#btnPlaceOrder', 'click', function() {



            $("#remark").val($("#previewRemark").val());

            $("#btnPlaceOrder").prop('disabled', true);
            $("#btnPlaceOrder").html("Place Order...");
            $("#btnPlaceOrderCancel").prop('disabled', true);


            // $("#formOrder").submit();

        });

        $("#company_bill").select2({
            ajax: {
                url: ajaxURLCompanyDetail,
                dataType: 'json',
                delay: 0,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    // Modify the data.results array to display both name and arabic_state_name
                    var results = data.results.map(function(company) {
                        return {
                            id: company.id,
                            text: company.text + ' ( ' + company.arabic_name + ' ) '
                        };
                    });

                    return {
                        results: results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: false
            },
            placeholder: 'Seen Company Details',
        }).on('change', function(e) {
            $('#clicntForm').trigger("reset");
            $('#branch_address_show').removeClass('d-none');
            var id = $(this).val();
            $.ajax({
                type: 'GET',
                url: ajaxURLBranchDetail + "?id=" + id,
                success: function(resultData) {
                    if (resultData['status'] == 1) {


                        $('#branch_address_line1_text').text(resultData['data'][0]['address_line_1']);
                        $('#branch_address_line1_text').val(resultData['data'][0]['address_line_1']);
                        $('#branch_id').val(resultData['data'][0]['id']);

                        $('#branch_address_line2_text').text(resultData['data'][0]['address_line_2'] +
                            ",  " +
                            resultData['data'][0]['area']);
                        $('#branch_pincode_text').text(resultData['data'][0]['pincode']);
                        $('#branch_country_id_text').text(resultData['data'][0]['country_name']);
                        $('#branch_state_id_text').text(resultData['data'][0]['state_name']);

                        $('#branch_city_id').text(resultData['data'][0]['city_name']);

                        var orderItems = [];
                        var productIds = [];
                    }
                }
            })
        });

        $('#client_country_id').select2({
            ajax: {
                url: ajaxURLSerachCountry,
                dataType: 'json',
                delay: 0,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    // Modify the data.results array to display both name and arabic_state_name
                    var results = data.results.map(function(country) {
                        return {
                            id: country.id,
                            text: country.text + ' ( ' + country.arabic_country_name + ' ) '
                        };
                    });

                    return {
                        results: results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: false
            },
            placeholder: 'Search for country',
            dropdownParent: $("#addClientModal .modal-body")
        });

        $('#client_state_id').select2({
            ajax: {
                url: ajaxURLSerachState,
                dataType: 'json',
                delay: 0,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                        "country_id": function() {
                            return $('#client_country_id').val();
                        }
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    // Modify the data.results array to display both name and arabic_state_name
                    var results = data.results.map(function(state) {
                        return {
                            id: state.id,
                            text: state.text + ' ( ' + state.arabic_state_name + ' ) '
                        };
                    });

                    return {
                        results: results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: false
            },
            placeholder: 'Search for State',
            dropdownParent: $("#addClientModal .modal-body")
        });
        $('#client_city_id').select2({
            ajax: {
                url: ajaxURLSerachCity,
                dataType: 'json',
                delay: 0,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                        "country_id": function() {
                            return $('#client_country_id').val();
                        },
                        "state_id": function() {
                            return $('#client_state_id').val();
                        }
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    // Modify the data.results array to display both name and arabic_state_name
                    var results = data.results.map(function(city) {
                        return {
                            id: city.id,
                            text: city.text + ' ( ' + city.arabic_city_name + ' ) '
                        };
                    });

                    return {
                        results: results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: false
            },
            placeholder: 'Search for city',
            dropdownParent: $("#addClientModal .modal-body")
        });

        function saveClient() {

            var requiredFields = [
                "client_name",
                "email_address",
                "phone_number",
            ];

            var isAnyEmpty = false;

            // Check if any of the required fields are empty
            requiredFields.forEach(function(field) {
                if ($("#" + field).val() === "") {
                    isAnyEmpty = true;
                    $("#" + field).addClass("is-invalid"); // Add a CSS class to highlight the empty field
                } else {
                    $("#" + field).removeClass("is-invalid"); // Remove the CSS class if the field is filled
                }
            });

            if (isAnyEmpty) {
                toastr.error("Please fill in all required fields.");
            } else {
                // If all required fields are filled, you can proceed to save the data
                // Get the values from the input fields
                var clientName = $('#client_name').val();
                var emailAddress = $('#email_address').val();
                var phoneNumber = $('#phone_number').val();
                var clientAddress = $('#client_address').val();
                var pincode = $('#pincode').val();
                var client_city_id = $('#client_city_id').val();
                var client_state_id = $('#client_state_id').val();
                var client_country_id = $('#client_country_id').val();
                var selectedValue = $("#company_bill").val();

                // Check if a value is selected
                if (selectedValue === "") {
                    // Display an error message using toastr
                    toastr.error("select your company");
                } else {
                    // Continue with your order placement logic
                    // You can submit the form or perform any other actions here
                }

                // Check if any of the required fields are empty
                if (clientName === "" || emailAddress === "" || phoneNumber === "" || client_country_id === "") {
                    toastr.error("Please fill in all required fields.");
                    return; // Exit the function if validation fails
                }

                // If all fields are filled, proceed with saving the client data
                $('#client_detail_name').val(clientName);
                $('#client_detail_email').val(emailAddress);
                $('#client_detail_number').val(phoneNumber);
                $('#client_detail_address_line1').val(clientAddress);
                $('#client_detail_pincode').val(pincode);
                $('#client_detail_country_id').val($('#client_country_id').val());
                $('#client_detail_state_id').val($('#client_state_id').val());
                $('#client_detail_city_id').val($('#client_city_id').val());
                $('#client_detail_city_text').val($("#client_city_id option:selected").text());
                $('#client_detail_state_text').val($("#client_state_id option:selected").text());
                $('#client_detail_country_text').val($("#client_country_id option:selected").text());

                $('#client_detail_name_text').html(clientName);
                $('#client_detail_email_text').html(emailAddress);
                $('#client_detail_number_text').html(phoneNumber);
                $('#client_detail_address_line1_text').html(clientAddress);
                $('#client_detail_pincode_text').html(pincode);
                $('#client_detail_country_text_').html($('#client_detail_country_text').val())
                $('#client_detail_state_text_').html($('#client_detail_state_text').val())
                $('#client_detail_city_text_').html($('#client_detail_city_text').val())

                $("#client_detail_address_show").removeClass("d-none");
                $("#clientEditeButton").removeClass("d-none");
                resetClinetInput();

                $("#addClientModal").modal("hide");
                orderItems = [];
                productIds = [];
                $('#seaction_order_items').show();
            }

        }




        $("#itemSave").click(function() {

            var requiredFields = [
                "item_design_no",
                "item_name",
                "item_gold_ct",
                "item_diamond_ct",
                "item_gram",
                "item_quantity",
                "item_price"
            ];

            var isAnyEmpty = false;

            // Check if any of the required fields are empty
            requiredFields.forEach(function(field) {
                if ($("#" + field).val() === "") {
                    isAnyEmpty = true;
                    $("#" + field).addClass("is-invalid"); // Add a CSS class to highlight the empty field
                } else {
                    $("#" + field).removeClass("is-invalid"); // Remove the CSS class if the field is filled
                }
            });

            if (isAnyEmpty) {
                toastr.error("Please fill in all required fields.");
            } else {
                // If all required fields are filled, you can proceed to save the data
                // Add your save logic here
                processItemSave();

                $('#itemForm').trigger('reset');
                $('#item_quantity').empty().val('');
                $('#item_gram').empty().val('');
                $('#item_diamond_ct').empty().val('');
                $('#item_gold_ct').empty().val('');
                $('#item_name').empty().val('');
                $('#item_design_no').empty().val('');
                $("#item_price").empty().val('');
            }
        });

        $('#addItemModal').on('shown.bs.modal', function(e) {
            $("#itemForm").focus();
            $('#itemForm').trigger('reset');
        })

        function processItemSave() {
            $("#addItemModal").modal('hide');

            var currentProduct = {
                item_id: itemIdCounter,
                item_name: $("#item_name").val(),
                item_design_no: $("#item_design_no").val(),
                item_gold_ct: $("#item_gold_ct").val(),
                item_diamond_ct: $("#item_diamond_ct").val(),
                qty: $("#item_quantity").val(),
                item_gram: $("#item_gram").val(),
                item_price: $("#item_price").val(),


            };
            
            if (currentProduct['qty'] !== "") {
                if (!isNaN(currentProduct['qty']) && parseFloat(currentProduct['qty']) > 0) {
                    orderItems.push(currentProduct);
                    itemIdCounter++; // Increment the counter to ensure unique item IDs
                    orderCalculationProcess();
                } else {
                    toastr["error"]("Invalid Product Quantity");
                }
            } else {
                toastr["error"]("Invalid Quantity");
            }

        }

        $('#btnPlaceOrder').click(function() {


            var clientName = $('#client_detail_name').val();
            var emailAddress = $('#client_detail_email').val();
            var phoneNumber = $('#client_detail_number').val();
            var clientAddress = $('#client_detail_address_line1').val();
            var clientCountryId = $('#client_detail_country_id').val();
            var clientStateId = $('#client_detail_state_id').val();
            var clientCityId = $('#client_detail_city_id').val();
            var pincode = $('#client_detail_city_id').val();
            var brancID = $('#branch_id').val();
            var companyID = $('#company_bill').val();

            var requestData = {
                "_token": csrfToken,
                "data": {
                    "client_name": clientName,
                    "client_email_address": emailAddress,
                    "client_phone_number": phoneNumber,
                    "client_address": clientAddress,
                    "client_country": clientCountryId,
                    "client_state": clientStateId,
                    "client_city": clientCityId,
                    "client_pincode": pincode,
                    "company": {
                        "id": companyID // Replace with the actual company ID
                    },
                    "branch": [{
                        "id": brancID // Replace with the actual branch ID
                    }],
                    "items": itemArray,
                    // "order": OrderArry,
                }
            };

            // Make the AJAX request with the extracted data
            $.ajax({
                type: 'post',
                url: ajaxURLOrderSave, // Replace with your actual URL
                data: requestData,

                success: function(resultData) {
                    toastr['success'](resultData['msg']);
                    $("#modalOrderPreviw").modal('hide');
                    window.location = reditectURL
                }
            });
        });
        // Add an event listener to the "Edit" button

        $("#clientEditeButton").click(function() {
            resetClinetInput()
            $("#addClientModal").modal("show");
            var clientName = $("#client_detail_name_text").text();
            var email = $("#client_detail_email_text").text();
            var phoneNumber = $("#client_detail_number_text").text();
            var address = $("#client_detail_address_line1_text").text();
            var pincode = $("#client_detail_pincode_text").text();

            $("#client_name").val(clientName);
            $("#email_address").val(email);
            $("#phone_number").val(phoneNumber);
            $("#client_address").val(address);
            $("#pincode").val(pincode);

            var defaultCountryValue = $('#client_detail_country_id')
                .val(); // Replace with the actual default country value
            var defaultCountryText = $('#client_detail_country_text')
                .val(); // Replace with the actual default country text

            var defaultStateValue = $('#client_detail_state_id')
                .val(); // Replace with the actual default state value
            var defaultStateText = $('#client_detail_state_text')
                .val(); // Replace with the actual default state text

            var defaultCityValue = $('#client_detail_city_id').val(); // Replace with the actual default city value
            var defaultCityText = $('#client_detail_city_text').val(); // Replace with the actual default city text


            if (defaultCountryValue != null) {
                var newOption = new Option(defaultCountryText, defaultCountryValue, false, false);
                $('#client_country_id').append(newOption).trigger('change');
                $("#client_country_id").val("" + defaultCountryValue + "");
                $('#client_country_id').trigger('change');
            }

            if (defaultStateValue != null) {
                var newOption = new Option(defaultStateText, defaultStateValue, false, false);
                $('#client_state_id').append(newOption).trigger('change');
                $("#client_state_id").val("" + defaultStateValue + "");
                $('#client_state_id').trigger('change');
            }

            if (defaultCityValue != null) {
                var newOption = new Option(defaultCityText, defaultCityValue, false, false);
                $('#client_city_id').append(newOption).trigger('change');
                $("#client_city_id").val("" + defaultCityValue + "");
                $('#client_city_id').trigger('change');
            }


        });

        function resetClinetInput() {
            $('#clicntForm').trigger("reset");
            $('#client_name').val('');
            $('#email_address').val('');
            $('#phone_number').val('');
            $('#client_address').val('');
            $('#pincode').val('');
            $('#client_city_id').empty().trigger('change');
            $('#client_state_id').empty().trigger('change');
            $('#client_country_id').empty().trigger('change');

        }

        $('#addClientModal').on('hidden.bs.modal', function() {
            // Reset the form and empty the input values
            $('#clicntForm')[0].reset();
            $('#client_country_id').val(''); // Reset the selected country to the default option
            $('#client_state_id').val(''); // Reset the selected state to the default option
            $('#client_city_id').val(''); // Reset the selected city to the default option
            // Clear any error messages or validation styles if present
            $('.is-invalid').removeClass('is-invalid');
            resetClinetInput()
        });

        $(function() {
            $(".product-qty-cls").change(function() {

                if ($(this).val() > 1000) {
                    $(this).val(1000);
                } else if ($(this).val() < 1) {
                    $(this).val(1);
                }
            });
        });
    </script>
@endsection
