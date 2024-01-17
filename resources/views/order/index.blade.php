@extends('layouts.main')
@section('title', $data['title'])
@section('content')

    <style type="text/css">
        @media print {

            thead,
            tfoot {
                display: none !important
            }

            @page {
                size: 'a4';
                margin: 0mm;
            }

        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-2 font-size-18">Order</h4>

                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('add.order') }}" role="button"><i
                                class="bx bx-plus font-size-16 align-middle me-2"></i>Add Order</a>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <!-- start row -->


            <div class="row">

                <div class="card">
                    <div class="card-body">
                        {{-- @include('../users/comman/tab') --}}
                        <div class="table-responsive">
                            <table id="datatable"
                                class="table align-middle table-nowrap table-hover table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Detail</th>
                                        <th>Order By</th>
                                        <th>Client Detail</th>
                                        <th>Payment Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>

                                </tbody>
                            </table>

                        </div>

                        <!-- start model -->
                        <div class="modal fade" id="modalOrder" data-bs-backdrop="static" data-bs-keyboard="true"
                            tabindex="-1" role="dialog" aria-labelledby="modalOrderLabel" aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-title">Order</h5>&nbsp;&nbsp;&nbsp;&nbsp;
                                        @if (Auth::user()->type == 1)
                                            <label class="switch" id="is_edit_switch_div">

                                            </label>
                                        @endif

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>


                                    <div class="modal-body" id="modal">

                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:void(0)" target="_blenk" class="btn btn-primary d-none"
                                            id="itempdfdownload">Download</a>
                                        <a href="javascript:void(0)" class="btn btn-primary" id="itempdfPrint">Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ennd model -->
                <br>


            </div>
        </div>
    </div>
    </div>



    <!-- end row -->
    </div>
    <!-- container-fluid -->
    </div>
    <!-- End Page-content -->







@endsection('content')
@section('custom-scripts')


    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/jquery.form.js') }}"></script>
    {{-- <script src="{{ asset('assets/css/font.css') }}"></script> --}}
    <script src="{{ asset('assets/libs/kendo/kendo.all.min.js') }}"></script>
    @include('../users/comman/modal')

    <script type="text/javascript">
        var order_id = 0;
        var ajaxURlOrderActive = '{{ route('users.order.active') }}'
        var ajaxURL = '{{ route('users.order.ajax') }}';
        var ajaxOrderDetail = '{{ route('users.order.orderEdite') }}';
        var csrfToken = $("[name=_token").val();

        var usersPageLength = getCookie('usersPageLength') !== undefined ? getCookie('usersPageLength') : 10;


        var table = $('#datatable').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": []
            }],
            "order": [
                [0, 'desc']
            ],
            "processing": true,
            "serverSide": true,
            "pageLength": usersPageLength,
            "ajax": {
                "url": ajaxURL,
                "type": "POST",
                "data": {
                    "_token": csrfToken,
                }
            },
            "aoColumns": [{
                    "mData": "id"
                },
                {
                    "mData": "order_by"
                },
                {
                    "mData": "customer_name"
                },
                {
                    "mData": "payment_detail"
                },
                {
                    "mData": "status"
                },
                {
                    "mData": "action"
                },

            ]
        });


        $('#datatable').on('length.dt', function(e, settings, len) {

            setCookie('usersPageLength', len, 100);


        });


        function ViewOrder(id) {

            order_id = id;

            $("#modalOrder").modal('show');
            $("#modal-title").html("Order #" + id);
            $("#orderDetailLoading").show();
            $('#loadr').hide();
            $("#orderDetailBody").hide();


            $.ajax({
                type: 'GET',
                url: ajaxOrderDetail + "?order_id=" + id,
                success: function(resultData) {
                    $('#modal').html(resultData['view']);

                    if (resultData['status'] == 1) {
                        if (resultData['data']['Order']['is_edit'] == 1) {
                            $('#is_edit_switch_div').html(
                                '<input name="someSwitchOption001" value="" class="ads_Checkbox modal-checkbox" type="checkbox" id="Active_switch" onchange="InvoiceActive(' +
                                id + ', 0)" checked="" /><span class="slider"></span>')
                        } else {
                            $('#is_edit_switch_div').html(
                                '<input name="someSwitchOption001" value="" class="ads_Checkbox modal-checkbox" type="checkbox" id="Active_switch" onchange="InvoiceActive(' +
                                id + ', 1)"/><span class="slider"></span>')
                        }

                    }
                }
            });

        }

        var ajaxInvoicePDF = '{{ route('users.order.invoicePDF') }}';
        $('#itempdfdownload').on('click', function() {
            $('#itempdfdownload').attr('href', ajaxInvoicePDF + "?order_id=" + order_id)
        })

        $('#itempdfPrint').on('click', function() {

            var divToPrint = document.getElementById('modal');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open(divToPrint);
            newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
            newWin.document.close(divToPrint);
            setTimeout(function() {
                newWin.close();
            }, 1000);
        });


        function InvoiceActive(id, is_edit) {
            $.ajax({
                type: 'POST',
                url: ajaxURlOrderActive,
                data: {
                    'id': order_id,
                    'is_edit': is_edit,
                    '_token': $("[name=_token]").val()
                },
                success: function(resultData) {
                    if (resultData['status'] == 1) {
                        toastr["success"](resultData['msg']);
                    } else {
                        toastr["error"](resultData['msg']);
                    }
                }
            })
        }
    </script>
    @include('../users/comman/script')
@endsection
