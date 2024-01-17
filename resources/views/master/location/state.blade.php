@extends('layouts.main')
@section('title', $data['title'])
@section('content')



    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">State List

                        </h4>

                        {{-- 
                                <div class="page-title-right">
                                    <select class="form-select" id="country_id" >

                                        @foreach ($data['country_list'] as $key => $value)
                                        <option value="{{$value->id}}" > {{$value->name   }} ({{$value->code}}) </option>
                                        @endforeach
                                    </select>
                                </div> --}}

                        <button id="addBtnMainMaster" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#canvasMainMaster" aria-controls="canvasMainMaster"><i
                                class="bx bx-plus font-size-16 align-middle me-2"></i>Add State</button>
                    </div>
                    <div class="page-title-right">
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="canvasMainMaster"
                            aria-labelledby="canvasMainMasterLable">
                            <div class="offcanvas-header">
                                <h5 id="canvasMainMasterLable">Country Master</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="col-md-12 text-center loadingcls">
                                    <button type="button" id="loader" class="btn btn-light waves-effect">
                                        <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> Loading
                                    </button>
                                </div>
                                <form id="formMainMaster" class="custom-validation" action="{{ route('statelist.save') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="id">
                                    <div class="col-md-12">
                                        <label for="q_item_master_country" class="form-label">Select Country<code
                                                class="highlighter-rouge">*</code></label>
                                        <select class="form-select" id="country_id" aria-label="Disabled select example"
                                            name="country_id">
                                            <option selected>Select Country</option>
                                        </select>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_brance_master_name" class="form-label">State Name <code
                                                        class="highlighter-rouge">*</code></label>
                                                <input type="text" class="form-control" id="state_name" name="state_name"
                                                    placeholder="Country Name" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_brance_master_code" class="form-label">Arabic State Name
                                                </label>
                                                <input type="text" class="form-control" id="arabic_state_name"
                                                    name="arabic_state_name" placeholder="Arabic Country Name"
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


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">



                        <table id="datatable" class="table table-striped dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Country Name</th>
                                    <th>State Name</th>
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
        var ajaxURL = '{{ route('statelist.ajax') }}';
        var ajaxURLselectCountry = '{{ route('selectCountry') }}';
        var ajaxURLselectstate = '{{ route('statelist.edite') }}';
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
                    "country_id": function() {
                        return $("#country_id").val()
                    }
                }


            },
            "aoColumns": [{
                    "mData": "id"
                },
                {
                    "mData": "country_name"
                },
                {
                    "mData": "name"
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

        $('#country_id').select2({
            ajax: {
                url: ajaxURLselectCountry,
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
            $('#formMainMaster').ajaxForm(options);
        });

        function resetInputForm() {

            $('#formMainMaster').trigger("reset");
            $("#arabic_state_name").empty().trigger('change');
            $("#state_name").empty().trigger('change');
            $("#country_id").select2("val", "1");
            $("#formMainMaster").removeClass('was-validated');

        }

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

        $('#addBtnMainMaster').click(function() {
            $('#loader').hide();
            resetInputForm();
        });

        function editView(id) {

            $("#canvasMainMaster").offcanvas('show');
            $("#canvasMainMasterLable").html("Edit state #" + id);
            // $("#formCity .row").hide();
            // $(".loadingcls").show();


            $.ajax({
                type: 'GET',
                url: ajaxURLselectstate + "?id=" + id,
                success: function(resultData) {

                    if (resultData['status'] == 1) {
                        console.log(resultData);
                        $('#state_name').val(resultData['data']['name'])
                        $('#arabic_state_name').val(resultData['data']['arabic_state_name'])

                        var newOption = new Option(resultData['country']['0']['text'] + "(" + resultData[
                                'country']['0']['arabic_country_name'] + ")", resultData['country'][0][
                            'id'], false, false);
                        $('#country_id').append(newOption).trigger('change');
                        $("#country_id").val("" + resultData['country']['0']['id'] + "");
                        $('#country_id').trigger('change');


                        $(".loadingcls").hide();
                        $("#formCity .row").show();


                    }
                }
            });
        }

        function resetInputForm() {
            $('#formMainMaster').trigger("reset");
            $('#state_name').empty().trigger('change');
            $('#country_id').empty().trigger('change');
            $('#arabic_state_name').empty().trigger('change');
        }
    </script>
@endsection
