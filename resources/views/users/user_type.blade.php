@extends('layouts.main')
@section('title', $data['title'])
@section('content')

    <style type="text/css">
        td p {
            max-width: 100%;
            white-space: break-spaces;
            word-break: break-all;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">User type</h4>
                        <div class="page-title-right">
                    
                            <button id="addBtnMainMaster" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#canvasMainMaster" aria-controls="canvasMainMaster"><i
                                    class="bx bx-plus font-size-16 align-middle me-2"></i>Add User Type</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="canvasMainMaster"
                                aria-labelledby="canvasMainMasterLable">
                                <div class="offcanvas-header">
                                    <h5 id="canvasMainMasterLable">User Type Master</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <div class="col-md-12 text-center loadingcls">
                                        <button type="button" id="loader" class="btn btn-light waves-effect">
                                            <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> Loading
                                        </button>
                                    </div>
                                    <form id="formMainMaster" class="custom-validation"
                                        action="{{ route('user.type.save') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" id="id">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="user_type_name" class="form-label">Name <code class="highlighter-rouge">*</code></label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="user_type_remark" class="form-label">Remark <code class="highlighter-rouge">*</code></label>
                                                    <input type="text" class="form-control" id="remark" name="remark" placeholder="remark" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="user_type_status" class="form-label">Is Active
                                                    </label>

                                                    <select id="user_type_status" name="user_type_status"
                                                        class="form-control select2-apply">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
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
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-striped dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @csrf
@endsection('content')


@section('custom-scripts')

    <script src="{{ asset('assets/ckeditor5/build/ckeditor.js') }}"></script>

    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/jquery.form.js') }}"></script>
    <script class="text/javascript">
        var AjaxdataSelect = '{{ route('user.type.ajax') }}';
        var AjaxediteData = '{{ route('user.type.detail') }}';
        var ajaxURLDeleteFile = '{{ route('user.type.delete') }}';

        $("#user_type_status").select2({
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

        // function reloadTable() {
        //     table.ajax.reload(null, false);
        // }

        // $(document).ready(function() {
        //     $("#s_main_master_id").val($("#main_master_id").val());
        //     var option = {
        //         beforeSubmit: showRequest,
        //         success: showResponse
        //     };
        //     $("#formMainMaster").ajaxForm(option);
        // });

        // function showRequest(FormData, jqForm, option) {
        //     // generateHierarchyCode($("#main_master_name").val());
        //     var queryString = $.param(FormData);
        //     return true;
        // }

        // function resetInputForm() {

        //     $('#formMainMaster').trigger("reset");
        //     $("#main_master_id").val(0);

        // }

        // function showResponse(reshponsText, statusText, xhr, $form) {
        //     if (reshponsText['status'] == 1) {
        //         toastr['success'](reshponsText['msg']);
        //         reloadTable();
        //         resetInputForm();
        //         $("#canvasMainMaster").hide();
        //     } else if (reshponsText['status'] == 0) {
        //         toastr['error'](reshponsText['msg']);
        //     }
        // }

        function editdata(id) {

            $("#canvasMainMaster").offcanvas('show');
            $('#canvasMainMasterLable').html("Edite " + id);
            $("#loader").hide();
            $('#formMainMaster').show();
            $.ajax({
                type: 'get',
                url: AjaxediteData,
                data: {
                    "id": id,
                },
                success: function(resultData) {
                    if (resultData['status'] == 1) {
                        $("#id").val(resultData['data']['id']);
                        $("#name").val(resultData['data']['name']);
                        $("#remark").val(resultData['data']['remark']);
                        $("#user_type_status").select2("val", "" + resultData['data']['status'] + "");
                    } else {
                        toastr["error"](resultData['msg']);
                    }
                }
            })
        }
        // $('#addBtnMainMaster').click(function() {
        //     $("#formMainMaster").show();
        //     $("#loader").hide();
        //     resetclassinput();
        // });

        // function resetclassinput() {
        //     $("#formMainMaster").removeClass('was-validated');
        //     $('#formMainMaster').trigger("reset");
        //     $("#id").val(0);
        //     $("#state_id").empty().trigger('change');
        //     $("#city_id").empty().trigger('change');
        //     $("#company_id").empty().trigger('change');
        //     // save();
        // }

        

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

        $("#user_type_status").select2({
            minimumResultsForSearch: Infinity,
            dropdownParent: $("#canvasMainMaster")
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

        $('#addBtnMainMaster').click(function() {
            $("#formMainMaster").show();
            $("#loader").hide();
            resetclassinput();
        });

        function resetclassinput() {
            $("#formMainMaster").removeClass('was-validated');
            $('#formMainMaster').trigger("reset");
            $("#id").val(0);
            $("#state_id").empty().trigger('change');
            $("#city_id").empty().trigger('change');
            $("#branch_id").empty().trigger('change');
            $("#canvasMainMasterLable").empty().trigger('change');
            // save();
        }
    </script>






@endsection
