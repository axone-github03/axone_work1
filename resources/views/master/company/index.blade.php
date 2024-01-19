@extends('layouts.main')
@section('title', $data['title'])
@section('content')

    <style type="text/css">
        td p {
            max-width: 100%;
            white-space: break-spaces;
            word-break: break-all;
        }

        thead th {
            /* padding: 8px; */
            /* font-size: 1rem; */
            /* text-align: center; */
        }

        .summary_table td,
        .summary_table th {
            vertical-align: middle !important;
        }

        .summary_table thead {
            background-color: #eff2f7;
        }

        .summary_table tbody,
        .summary_table td,
        .summary_table tfoot .summary_table th,
        .summary_table thead,
        .summary_table tr {
            border-color: #eff2f7;
            border-width: 1px !important;
        }

        #imgPreview {
            width: 100% !important;
            height: 100% !important;
        }

        #div_q_item_image {
            width: 100px;
            height: 100px;
            padding: 4px;
            margin: 0 auto;
            cursor: pointer;
        }
    </style>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Company Master</h4>
                        <div class="page-title-right">
                            {{-- @if (isAdminOrCompanyAdmin() == 1)
                        <a href="{{route('quot.item.master.export')}}" target="_blank" class="btn btn-info" type="button"><i class="bx bx-export font-size-16 align-middle me-2"></i>Export </a>
                        @endif --}}
                            <button id="addBtnMainMaster" class="btn btn-primary" data-bs-toggle="offcanvas"
                                data-bs-target="#canvasMainMaster" role="button" type="button"><i
                                    class="bx bx-plus font-size-16 align-middle me-2"></i>Add Company</button>

                            <div class="offcanvas offcanvas-end" tabindex="-1" id="canvasMainMaster"
                                aria-labelledby="canvasMainMasterLable">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="canvasMainMasterLable"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>

                                <div class="offcanvas-body">
                                    <div class="col-md-12 text-center loadingcls">
                                        <button type="button" id="loader" class="btn btn-light waves-effect">
                                            <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i>
                                            Loading...
                                        </button>
                                    </div>
                                    <form id="formMainMaster" enctype="multipart/form-data" class="custom-validation"
                                        action="{{ route('company.insert') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" id="id">


                                        <div class="col-md-12 ">
                                            <div class="mb-3">

                                                <label for="user_profile_img" class="form-label">Profile-Image <code
                                                        class="highlighter-rouge">*</code></label>
                                                <input type="file" class="form-control-file" hidden name="company_logo"
                                                    id="company_logo" placeholder="" aria-describedby="fileHelpId">
                                                <img name="show_company_logo" id="show_company_logo"
                                                    style="height: 100px; width: 100px" src="">

                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="q_item_master_name" class="form-label">Name <code
                                                            class="highlighter-rouge">*</code></label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="q_item_master_app_display_name" class="form-label">Short
                                                        Name </label>
                                                    <input type="text" class="form-control" id="shortname"
                                                        name="shortname" placeholder="Short Name" value="" readonly>
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_item_master_app_display_name" class="form-label">Arabic Name
                                                    <code class="highlighter-rouge">*</code> </label>
                                                <input type="text" class="form-control" id="arabic_name"
                                                    name="arabic_name" placeholder="Arabic Name" value="">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_item_master_app_display_name" class="form-label">Address line
                                                    1<code class="highlighter-rouge">*</code> </label>
                                                <input type="text" class="form-control" id="address_line_1"
                                                    name="address_line_1" placeholder="Address Line 1" value="">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_item_master_module" class="form-label">Address line 2 <code
                                                        class="highlighter-rouge">*</code></label>
                                                <input type="text" class="form-control" id="address_line_2"
                                                    name="address_line_2" onkeypress="" placeholder="Address Line 2"
                                                    value="" required>
                                            </div>
                                        </div><br>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_item_master_app_display_name" class="form-label">Arabic
                                                    Address line 1<code class="highlighter-rouge">*</code> </label>
                                                <input type="text" class="form-control" id="arabic_address_line_1"
                                                    name="arabic_address_line_1" placeholder="Arabic Address Line 1"
                                                    value="">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_item_master_module" class="form-label">Arabic Address line 2
                                                    <code class="highlighter-rouge">*</code></label>
                                                <input type="text" class="form-control" id="arabic_address_line_2"
                                                    name="arabic_address_line_2" onkeypress=""
                                                    placeholder="Arabic Address line 2" value="" required>
                                            </div>
                                        </div><br>


                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_item_master_sequence" class="form-label">Area<code
                                                        class="highlighter-rouge">*</code>
                                                </label>
                                                <input type="text" class="form-control" id="area" name="area"
                                                    placeholder="Area" value="0" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_item_master_sequence" class="form-label">Arabic Area<code
                                                        class="highlighter-rouge">*</code>
                                                </label>
                                                <input type="text" class="form-control" id="arabic_area"
                                                    name="arabic_area" placeholder="Area" value="0" required>
                                            </div>
                                        </div>


                                        <br>

                                        <div class="col-md-12">
                                            <label for="q_item_master_country" class="form-label">Country</label>
                                            <select class="form-select" id="country_id"
                                                aria-label="Disabled select example" name="country_id">
                                                <option selected>Select Country</option>


                                            </select>
                                        </div><br>

                                        <div class="col-md-12">
                                            <label for="q_item_master_satate" class="form-label">State<code
                                                    class="highlighter-rouge">*</code></label>
                                            <select class="form-select" id="state_id"
                                                aria-label="Disabled select example" name="state_id">
                                                <option selected>Select Country</option>


                                            </select>
                                        </div>
                                        <br>

                                        <div class="col-md-12">
                                            <label for="q_item_master_city" class="form-label">City<code
                                                    class="highlighter-rouge">*</code></label>
                                            <select class="form-select" id="city_id"
                                                aria-label="Disabled select example" name="city_id">
                                                <option selected>Select Country</option>


                                            </select>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="q_item_master_max_module" class="form-label">Pincode
                                                        <code class="highlighter-rouge">*</code></label>
                                                    <input type="number" class="form-control" id="pincode"
                                                        name="pincode" placeholder="00" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="main_status" class="form-label">IS Active </label>
                                                <select id="main_status" name="main_status"
                                                    class="form-control select2-apply">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Save
                                            </button>
                                            <button type="reset" class="btn btn-secondary waves-effect">
                                                Reset
                                            </button>

                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-striped dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Arabic Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
    @csrf
@endsection('content')


@section('custom-scripts')


    <script src="{{ asset('assets/ckeditor5/build/ckeditor.js') }}"></script>

    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/jquery.form.js') }}"></script>
    <script class="text/javascript">
        var AjaxSelectCIty = '{{ route('company.SelectCity') }}';
        var AjaxSelectState = '{{ route('company.selectSate') }}';
        var AjaxSelectCountry = '{{ route('company.searchCountry') }}';
        var AjaxdataSelect = '{{ route('company.ajax') }}';
        var AjaxediteData = '{{ route('company.editadata') }}';




        function generateHierarchyCode(dInput) {
            dInput = dInput.replace(/[_\W]+/g, "_")
            dInput = dInput.toUpperCase();
            $("#shortname").val(dInput)
        }

        $("#name").keyup(function() {
            generateHierarchyCode(this.value);
        });

        $("#name").change(function() {
            generateHierarchyCode(this.value);
        });

        $('#state_id').select2({
            ajax: {
                url: AjaxSelectState,
                dataType: 'json',
                delay: 0,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                        "country_id": function() {
                            return $('#country_id').val();
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
            dropdownParent: $("#canvasMainMaster .offcanvas-body"),
        });


        $('#city_id').select2({
            ajax: {
                url: AjaxSelectCIty,
                dataType: 'json',
                delay: 0,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page,
                        "country_id": function() {
                            return $('#country_id').val();
                        },
                        "state_id": function() {
                            return $('#state_id').val();
                        }
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    // Modify the data.results array to display both name and arabic_state_name
                    var results = data.results.map(function(state) {
                        return {
                            id: state.id,
                            text: state.text + ' ( ' + state.arabic_city_name + ' ) '
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
            dropdownParent: $("#canvasMainMaster .offcanvas-body"),
        });


        $('#country_id').select2({
            ajax: {
                url: AjaxSelectCountry,
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
                    var results = data.results.map(function(state) {
                        return {
                            id: state.id,
                            text: state.text + ' ( ' + state.arabic_country_name + ' ) '
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
            dropdownParent: $("#canvasMainMaster .offcanvas-body"),
        });


        $("#main_status").select2({
            minimumResultsForSearch: Infinity,
            dropdownParent: $("#canvasMainMaster")
        });

        var csrfToken = $("[name=_token]").val();
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
                "url": AjaxdataSelect,
                "type": "POST",
                "data": {
                    "_token": csrfToken,
                }
            },
            "aoColumns": [{
                    "mData": "id"
                },
                {
                    "mData": "name"
                },
                {
                    "mData": "address"
                },
                {
                    "mData": "address_arabic"
                },
                {
                    "mData": "status"
                },
                {
                    "mData": "action"
                },
            ]
        });
        $('#datatable').on('lenght.dt', function(e, settings, len) {
            setCookie('usersPageLength', len, 100);
        });

        function reloadTable() {
            table.ajax.reload(null, false);
        }

        $(document).ready(function() {
            $("#s_main_master_id").val($("#main_master_id").val());
            var option = {
                beforeSubmit: showRequest,
                success: showResponse
            };
            $("#formMainMaster").ajaxForm(option);
        });

        function showRequest(FormData, jqForm, option) {
            // generateHierarchyCode($("#main_master_name").val());
            var queryString = $.param(FormData);
            return true;
        }

        function resetInputForm() {

            $('#formMainMaster').trigger("reset");
            $("#main_master_id").val(0);
            $("#show_company_logo").attr("src", "")

        }

        function showResponse(reshponsText, statusText, xhr, $form) {
            if (reshponsText['status'] == 1) {
                toastr['success'](reshponsText['msg']);
                reloadTable();
                resetInputForm();
                $("#canvasMainMaster").offcanvas('hide');

            } else if (reshponsText['status'] == 0) {
                toastr['error'](reshponsText['msg']);
            }
        }

        function editData(id) {
            $("#canvasMainMaster").offcanvas('show');
            $('#canvasMainMasterLable').html("Edite " + id);
            $(".loadingcls").hide();
            $('#formMainMaster').show();
            $.ajax({
                type: 'get',
                url: AjaxediteData,
                data: {
                    "id": id,
                },
                success: function(resultData) {
                    console.log(resultData);
                    if (resultData['status'] == 1) {
                        if (resultData['data']['state'] != null) {
                            var newOption = new Option(resultData['data']['state']['text'] + "(" + resultData[
                                'data']['state']['arabic_state_name'] + ")", resultData['data'][
                                'state'
                            ]['id'], false, false);
                            $('#state_id').append(newOption).trigger('change');
                            $("#state_id").val("" + resultData['data']['state']['id'] + "");
                            $('#state_id').trigger('change');
                        }

                        if (resultData['data']['city'] != null) {
                            var newOption = new Option(resultData['data']['city']['text'] + "(" + resultData[
                                'data']['city']['arabic_city_name'] + ")", resultData['data'][
                                'city'
                            ]['id'], false, false);
                            $('#city_id').append(newOption).trigger('change');
                            $("#city_id").val("" + resultData['data']['city']['id'] + "");
                            $('#city_id').trigger('change');
                        }

                        if (resultData['data']['country'] != null) {

                            var newOption = new Option(resultData['data']['country']['text'] + "(" + resultData[
                                'data']['country']['arabic_country_name'] + ")", resultData['data'][
                                'country'
                            ]['id'], false, false);
                            $('#country_id').append(newOption).trigger('change');
                            $("#country_id").val("" + resultData['data']['country']['id'] + "");
                            $('#country_id').trigger('change');
                        }



                        $("#id").val(resultData['data']['id']);
                        $("#name").val(resultData['data']['name']);
                        $("#arabic_name").val(resultData['data']['arabic_name']);
                        $("#shortname").val(resultData['data']['shortname']);
                        $("#address_line_1").val(resultData['data']['address_line_1']);
                        $("#address_line_2").val(resultData['data']['address_line_2']);
                        $("#arabic_address_line_1").val(resultData['data']['arabic_address_line_1']);
                        $("#arabic_address_line_2").val(resultData['data']['arabic_address_line_2']);
                        $("#pincode").val(resultData['data']['pincode']);
                        $("#area").val(resultData['data']['area']);
                        $("#arabic_area").val(resultData['data']['arabic_area']);
                        $("#main_status").select2("val", "" + resultData['data']['status'] + "");
                        $("#show_company_logo").attr('src', " " + resultData['data']['company_img'] + "");

                    } else {
                        toastr["error"](resultData['msg']);
                    }
                }
            });

        }

        $('#addBtnMainMaster').click(function() {
            $("#formMainMaster").show();
            $("#loader").hide();
            resetclassinput();
            resetInputForm();
        });

        function resetclassinput() {
            $("#formMainMaster").removeClass('was-validated');
            $('#formMainMaster').trigger("reset");
            $("#id").val(0);
            $("#city_id").empty().trigger('change');
            $("#state_id").empty().trigger('change');
            $("#country_id").empty().trigger('change');
            $("#canvasMainMasterLable").empty().trigger('change');
            // save();
        }

        var ajaxURLDeleteFile = '{{ route('company.deleteData') }}';

        function deleteData(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ms-2 mt-2",
                loaderHtml: "<i class='bx bx-hourglass bx-spin font-size-16 align-middle me-2'></i> Loading",
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    cancelButton: 'btn btn-danger btn-lg',
                    loader: 'custom-loader'
                },
                buttonsStyling: !1,
                preConfirm: function(n) {
                    return new Promise(function(t, e) {
                        Swal.showLoading()
                        $.ajax({
                            type: 'GET',
                            url: ajaxURLDeleteFile + "?id=" + id,
                            success: function(resultData) {
                                if (resultData['status'] == 1) {
                                    reloadTable();
                                    t()
                                }
                            }
                        });
                    })
                },
            }).then(function(t) {
                if (t.value === true) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your record has been deleted.",
                        icon: "success"
                    });
                }
            });
        }


        $(document).ready(function() {
            $('#company_logo').change(function() {
                var file = this.files[0]
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#show_company_logo').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

        });
        $('#show_company_logo').click(function() {
            $('#company_logo').trigger('click');
        });
    </script>






@endsection
