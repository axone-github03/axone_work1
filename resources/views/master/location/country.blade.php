@extends('layouts.main')
@section('title', $data['title'])
@section('content')


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">City List</h4>

                        <div class="page-title-right">


                            <button id="addBtnCountry" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#canvasCountry" aria-controls="canvasCountry"><i
                                    class="bx bx-plus font-size-16 align-middle me-2"></i>Add Country</button>

                            <div class="offcanvas offcanvas-end" tabindex="-1" id="canvasCountry"
                                aria-labelledby="canvasCountryLabel">
                                <div class="offcanvas-header">
                                    <h5 id="canvasCountryLabel"></h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">

                                    <div class="col-md-12 text-center loadingcls">
                                        <button type="button" id="loader" class="btn btn-light waves-effect">
                                            <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> Loading
                                        </button>
                                    </div>





                                    <form id="formMainMaster" class="custom-validation"
                                        action="{{ route('countrylist.save') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" id="id">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="q_brance_master_name" class="form-label">Country Name <code
                                                            class="highlighter-rouge">*</code></label>
                                                    <input type="text" class="form-control" id="country_name"
                                                        name="country_name" placeholder="Country Name" value=""
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="q_brance_master_code" class="form-label">Arabic Country Name
                                                    </label>
                                                    <input type="text" class="form-control" id="arabic_country_name"
                                                        name="arabic_country_name" placeholder="Arabic Country Name"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
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
            <!-- start row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">



                            <table id="datatable" class="table table-striped dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Country Name</th>
                                        <th>Arabic Country Name</th>
                                        <th>Date & Time</th>
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
    <script type="text/javascript">
        var ajaxURL = '{{ route('countrylist.ajax') }}';
        var ajaxURLCountry = '{{ route('countrylist.edite') }}';
        var csrfToken = $("[name=_token").val();
        var locationPageLength = getCookie('locationPageLength') !== undefined ? getCookie('locationPageLength') : 10;


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
            "pageLength": locationPageLength,
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
                    "mData": "country_name"
                },
                {
                    "mData": "arabic_country_name"
                },
                {
                    "mData": "created_at"
                },
                {
                    "mData": "action"
                },
            ]
        });

        $('#datatable').on('length.dt', function(e, settings, len) {

            setCookie('locationPageLength', len, 100);


        });

        function reloadTable() {
            table.ajax.reload(null, false);
        }

        $(document).ready(function() {
            var options = {
                beforeSubmit: showRequest, // pre-submit callback
                success: showResponse, // post-submit callback

                // other available options:
                //url:       url         // override for form's 'action' attribute
                //type:      type        // 'get' or 'post', override for form's 'method' attribute
                //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
                //clearForm: true        // clear all form fields after successful submit
                //resetForm: true        // reset the form after successful submit

                // $.ajax options can be used here too, for example:
                //timeout:   3000
            };
            $("#formMainMaster").ajaxForm(options);

            // bind form using 'ajaxForm'
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
                reloadTable();
                resetInputForm();
                $("#canvasMainMaster").offcanvas('hide');


            } else if (responseText['status'] == 0) {

                toastr["error"](responseText['msg']);

            }

            // for normal html responses, the first argument to the success callback
            // is the XMLHttpRequest object's responseText property

            // if the ajaxForm method was passed an Options Object with the dataType
            // property set to 'xml' then the first argument to the success callback
            // is the XMLHttpRequest object's responseXML property

            // if the ajaxForm method was passed an Options Object with the dataType
            // property set to 'json' then the first argument to the success callback
            // is the json data object returned by the server

            // alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
            //     '\n\nThe output div should have already been updated with the responseText.');
        }

        $("#addBtnCountry").click(function() {
            $("#loader").hide();
            resetInputForm();


        });

        function editView(id) {

            $("#canvasCountry").offcanvas('show');
            $("#canvasCountryLabel").html("Edit country  #" + id);
            // $("#formCity .row").hide();
            // $(".loadingcls").show();


            $.ajax({
                type: 'GET',
                url: ajaxURLCountry + "?id=" + id,
                success: function(resultData) {

                    if (resultData['status'] == 1) {
                        console.log(resultData);
                        $('#country_name').val(resultData['data']['name'])
                        $('#arabic_country_name').val(resultData['data']['arabic_country_name'])

                        $(".loadingcls").hide();
                        $("#formCity .row").show();


                    }
                }
            });
        }

        function resetInputForm() {
            $('#formMainMaster').trigger("reset");
            $('#country_name').empty().trigger('change');
            $('#arabic_country_name').empty().trigger('change');
        }
    </script>
@endsection
