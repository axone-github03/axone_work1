<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
    type="text/css">
<div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" role="dialog"
    aria-labelledby="modalUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUserLabel"> User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUser" action="{{ route('users.save') }}" method="POST" class="needs-validation" novalidate>
                <div class="modal-body">
                    @csrf
                    <div class="col-md-12 text-center loadingcls">
                        <button type="button" class="btn btn-light waves-effect">
                            <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> Loading
                        </button>
                    </div>
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="row ">

                        <div class="col-md-6 ">
                            <div class="mb-3 d-flex">

                                <label for="user_profile_img" class="form-label">Profile-Image <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="file" class="form-control-file" hidden name="select_img" id="select_img"
                                    placeholder="" aria-describedby="fileHelpId">
                                <img name="profile_img" id="profile_img" style="height: 100px; width: 100px"
                                    src="">

                            </div>


                        </div>
                        <div class="col-md-6 ">
                            <div class="mb-3 d-flex">

                                <label for="user_signature" class="form-label">Uplode-Signature<code
                                        class="highlighter-rouge">*</code></label>
                                <input type="file" class="form-control-file" hidden name="select_SIGR"
                                    id="select_SIGR" placeholder="" aria-describedby="fileHelpId">
                                <img name="SIGR_img" id="SIGR_img" style="height: 100px; width: 100px" src="">
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_first_name" class="form-label">First name <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="text" class="form-control" id="user_first_name" name="user_first_name"
                                    placeholder="First Name" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_last_name" class="form-label">Last name <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="text" class="form-control" id="user_last_name" name="user_last_name"
                                    placeholder="Last Name" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_email" class="form-label">Email <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="email" class="form-control" id="user_email" name="user_email"
                                    placeholder="Email" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="insert_phone_number" class="form-label">Phone number <code
                                        class="highlighter-rouge">*</code></label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        +91
                                    </div>
                                    <input type="number" class="form-control" id="user_phone_number"
                                        name="user_phone_number" placeholder="Phone number" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_ctc" class="form-label">CTC </label>
                                <input type="number" class="form-control" id="user_ctc" name="user_ctc"
                                    placeholder="CTC" value="" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_ctc" class="form-label">Joining Date</label>
                                <div class="input-group" id="user_joining_date">
                                    <input autocomplete="off" type="text" class="form-control"
                                        placeholder="YYYY-MM-DD" data-date-format="yyyy-mm-dd"
                                        data-date-container='#user_joining_date' data-provide="datepicker"
                                        data-date-autoclose="true" name="user_joining_date" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_country_id" class="form-label">Country <code
                                        class="highlighter-rouge">*</code></label>
                                <select class="form-select" id="user_country_id" aria-label="Disabled select example"
                                    name="user_country_id">
                                    <option selected>Select Country</option>
                                </select>

                                <div class="invalid-feedback">
                                    Please select country.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                <label class="form-label">State <code class="highlighter-rouge">*</code></label>
                                <select class="form-control select2-ajax" id="user_state_id" name="user_state_id"
                                    required>
                                </select>
                                <div class="invalid-feedback">
                                    Please select state.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                <label class="form-label">City <code class="highlighter-rouge">*</code></label>
                                <select class="form-control select2-ajax" id="user_city_id" name="user_city_id"
                                    required>
                                </select>
                                <div class="invalid-feedback">
                                    Please select state.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_pincode" class="form-label">Pincode <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="number" class="form-control" id="user_pincode" name="user_pincode"
                                    placeholder="Pincode" value="" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_address_line1" class="form-label">Address line 1 <code
                                        class="highlighter-rouge">*</code></label>
                                <input type="text" class="form-control" id="user_address_line1"
                                    name="user_address_line1" placeholder="Address line 1" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_address_line2" class="form-label">Address line 2</label>
                                <input type="text" class="form-control" id="user_address_line2"
                                    name="user_address_line2" placeholder="Address line 2" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="user_status" class="form-label">Status <code
                                        class="highlighter-rouge">*</code></label>
                                <select class="form-select" id="user_status" name="user_status" required>
                                    <option selected value="1">Active</option>
                                    <option value="0">Inactive</option>
                                    <option value="2">Pending</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select status.
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_company" class="form-label">Company <code
                                        class="highlighter-rouge">*</code></label>
                                <select class="form-select" id="user_company" name="user_company" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_branch" class="form-label">Branch<code
                                        class="highlighter-rouge">*</code></label>
                                <select class="form-select" id="user_branch" name="user_branch" required>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-lg-12" id="div_user_type">
                            <div class="mb-3 ajax-select mt-3 mt-lg-0">
                                <label class="form-label">User Type <code class="highlighter-rouge">*</code></label>
                                <select class="form-control select2-ajax" id="user_type" name="user_type" required>
                                    {{-- @php
                                        $accessTypes = getUsersAccess(Auth::user()->type);
                                    @endphp
                                    @if (count($accessTypes) > 0)
                                        @foreach ($accessTypes as $key => $value)
                                            <option value="{{ $key }}"> {{ $value['name'] }} </option>
                                        @endforeach
                                    @endif --}}

                                </select>

                            </div>

                        </div>




                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button id="btnSave" type="submit" class="btn btn-primary">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('assets/ckeditor5/build/ckeditor.js') }}"></script>
<script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ asset('assets/js/pages/jquery.form.js') }}"></script>
{{-- <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script type="text/javascript">
    var ajaxURLSearchState = "{{ route('users.search.state') }}";
    var ajaxURLSearchCity = "{{ route('users.search.city') }}";
    var ajaxURLSearchCompany = "{{ route('users.search.company') }}";
    var ajaxURLSearchBranch = "{{ route('users.search.branch') }}";
    var ajaxURLSearchUserType = "{{ route('users.search.usertype') }}";
    var ajaxURLSearchStateCities = "{{ route('users.search.state.cities') }}";
    var ajaxURLSearchSalePersonType = "{{ route('users.search.saleperson.type') }}";
    var ajaxURLSearchPurchasePersonType = "{{ route('users.search.purcheperson.type') }}";
    var ajaxURLSearchSalePersonReportingManager = "{{ route('users.reporting.manager') }}";
    var ajaxURLSearchPurchasePersonReportingManager = "{{ route('users.reporting.manager.purchase') }}";
    var ajaxURLUserDetail = "{{ route('users.detail') }}";
    var ajaxURLStateCities = "{{ route('users.state.cities') }}";
    var isChannelPartner = "{{ isChannelPartner(Auth::user()->type) }}";
    var AjaxSelectCountry = '{{ route('users.search.selectCountry') }}';

    var ajaxURLSearchServiceExecutiveType = '{{ route('users.search.service.executive.type') }}';
    var ajaxURLSearchServiceExecutiveReportingManager =
        '{{ route('users.search.service.executive.reporting.manager') }}';


    $("#user_type").select2({
        ajax: {
            url: ajaxURLSearchUserType,
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

                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: false
        },
        placeholder: 'serch for your type',
        dropdownParent: $("#modalUser .modal-body"),
    });

    $('#user_company').select2({
        ajax: {
            url: ajaxURLSearchCompany,
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

                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: false
        },
        placeholder: 'serch for company',
        dropdownParent: $("#modalUser .modal-body"),
    });

    $('#user_branch').select2({
        ajax: {
            url: ajaxURLSearchBranch,
            dataType: 'json',
            delay: 0,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page,
                    "company_id": function() {
                        return $('#user_company').val();
                    }
                };
            },
            processResults: function(data, params) {

                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: false
        },
        placeholder: 'serch for branch',
        dropdownParent: $("#modalUser .modal-body"),
    });

    $('#user_country_id').select2({
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
        placeholder: 'Search for country',
        dropdownParent: $("#modalUser .modal-body"),
    });


    $('#user_city_id').select2({
        ajax: {
            url: ajaxURLSearchCity,
            dataType: 'json',
            delay: 0,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page,
                    "user_country_id": function() {
                        return $('#user_country_id').val();
                    },
                    "user_state_id": function() {
                        return $('#user_state_id').val();
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
        placeholder: 'Search for city',
        dropdownParent: $("#modalUser .modal-body"),
    });

    $('#user_state_id').select2({
        ajax: {
            url: ajaxURLSearchState,
            dataType: 'json',
            delay: 0,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page,
                    "user_country_id": function() {
                        return $('#user_country_id').val();
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
        dropdownParent: $("#modalUser .modal-body"),
    });

    $("#user_status").select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $("#modalUser .modal-body")
    });


    $(document).ready(function() {


        //




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
        $('#formUser').ajaxForm(options);
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
        $("#btnSave").html("Saving...");
        $("#btnSave").prop("disabled", true);
        return true;
    }

    // post-submit callback
    function showResponse(resultData, statusText, xhr, $form) {

        $("#btnSave").html("Save");
        $("#btnSave").prop("disabled", false);


        if (resultData['status'] == 1) {
            toastr["success"](resultData['msg']);
            $("#btnSave").html("Save");
            $("#btnSave").prop("disabled", false);
            reloadTable();
            resetInputForm();
            $("#modalUser").modal('hide');


        } else if (resultData['status'] == 0) {

            if (typeof resultData['data'] !== "undefined") {

                var size = Object.keys(resultData['data']).length;
                if (size > 0) {

                    for (var [key, value] of Object.entries(resultData['data'])) {

                        toastr["error"](value);
                    }

                }

            } else {
                toastr["error"](resultData['msg']);
            }

            $("#btnSave").html("Save");
            $("#btnSave").prop("disabled", false);

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

    $("#addBtnUser").click(function() {

        resetInputForm();

        $("#modalUserLabel").html("Add User");
        $("#user_id").val(0);
        $(".loadingcls").hide();
        $("#formUser .row").show();
        $("#modalUser .modal-footer").show();

    });

    function resetInputForm() {

        $('#formUser').trigger("reset");
        $("#user_status").select2("val", "1");
        $("#user_city_id").empty().trigger('change');
        $("#user_state_id").empty().trigger('change');
        $("#user_country_id").empty().trigger('change');
        $("#sale_person_type").empty().trigger('change');
        $("#purchase_person_type").empty().trigger('change');
        $("#sale_person_reporting_manager").empty().trigger('change');
        $("#purchase_person_reporting_manager").empty().trigger('change');
        $("#sale_person_state").empty().trigger('change');
        $("#purchase_person_state").empty().trigger('change');
        $("#user_company").empty().trigger('change');
        $("#user_branch").empty().trigger('change');
        $("#user_type").empty().trigger('change');
        $("#profile_img").attr("src", "")
        $("#SIGR_img").attr("src", "")


        $("#formUser").removeClass('was-validated');
        $("#btnSave").html("Save");
        $("#btnSave").prop("disabled", false);
        previousselectedSaleState = [];



    }

    var editModeLoading = 0;
    var previousselectedSaleState = [];
    var previousselectedPurchaseState = [];


    function editView(id) {
        editModeLoading = 1;

        resetInputForm();

        $("#modalUser").modal('show');
        $("#modalUserLabel").html("Edit User #" + id);
        $("#formUser .row").hide();
        $(".loadingcls").show();
        $("#modalUser .modal-footer").hide();

        $.ajax({
            type: 'GET',
            url: ajaxURLUserDetail + "?id=" + id,
            success: function(resultData) {
                if (resultData['status'] == 1) {

                    console.log(resultData);


                    $("#user_id").val(resultData['data']['id']);


                    $("#user_first_name").val(resultData['data']['first_name']);
                    $("#user_last_name").val(resultData['data']['last_name']);
                    $("#user_phone_number").val(resultData['data']['phone_number']);
                    $("#user_email").val(resultData['data']['email']);
                    $("#user_ctc").val(resultData['data']['ctc']);
                    $("#user_pincode").val(resultData['data']['pincode']);
                    $("#user_address_line1").val(resultData['data']['address_line1']);
                    $("#user_address_line2").val(resultData['data']['address_line2']);

                    $("#SIGR_img").attr('src', " " + resultData['data']['sign_image'] + "");
                    $("#profile_img").attr('src', " " + resultData['data']['avatar'] + "");

                    var newOption = new Option(resultData['data']['company']['name'], resultData['data'][
                        'company'
                    ]['id'], false, false);
                    $('#user_company').append(newOption).trigger('change');
                    $("#user_company").val("" + resultData['data']['company']['id'] + "");
                    $('#user_company').trigger('change');


                    var newOption = new Option(resultData['data']['branch'][0]['text'], resultData['data'][
                        'branch'
                    ][0]['id'], false, false);
                    $('#user_branch').append(newOption).trigger('change');
                    $("#user_branch").val("" + resultData['data']['branch'][0]['id'] + "");
                    $('#user_branch').trigger('change');

                    if (resultData['data']['type'] != null) {
                        var newOption = new Option(resultData['data']['type'][0]['text'], resultData['data']
                            [
                                'type'
                            ][0]['id'], false, false);
                        $('#user_type').append(newOption).trigger('change');
                        $("#user_type").val("" + resultData['data']['type'][0]['id'] + "");
                        $('#user_type').trigger('change');
                    }

                    $("#user_status").select2("val", "" + resultData['data']['status'] + "");

                    if (resultData['data']['country'] != null) {
                        $("#user_country_id").empty().trigger('change');
                        var newOption = new Option(resultData['data']['country']['name'] + "(" + resultData[
                                'data']['country']['arabic_country_name'] + ")", resultData['data']
                            [
                                'country'
                            ]['id'], false, false);
                        $('#user_country_id').append(newOption).trigger('change');

                    }

                    if (resultData['data']['state'] != null) {
                        $("#user_state_id").empty().trigger('change');
                        var newOption = new Option(resultData['data']['state']['name'] + "(" + resultData[
                            'data']['state']['arabic_state_name'] + ")", resultData['data'][
                            'state'
                        ]['id'], false, false);
                        $('#user_state_id').append(newOption).trigger('change');

                    }

                    if (resultData['data']['city'] != null) {
                        $("#user_city_id").empty().trigger('change');
                        var newOption = new Option(resultData['data']['city']['name'] + "(" + resultData[
                            'data']['city']['arabic_city_name'] + ")", resultData['data'][
                            'city'
                        ]['id'], false, false);
                        $('#user_city_id').append(newOption).trigger('change');

                    }

                    $(".loadingcls").hide();
                    $("#formUser .row").show();
                    $("#modalUser .modal-footer").show();

                    // // END AXONE WORK
                    editModeLoading = 0;
                } else {
                    toastr["error"](resultData['msg']);
                }

            }
        });

    }


    $('#user_country_id').on('change', function() {

        $("#user_state_id").empty().trigger('change');
        $("#user_city_id").empty().trigger('change');

    });
    $('#user_company').on('change', function() {

        $("#user_branch").empty().trigger('change');

    });

    $('#user_state_id').on('change', function() {

        $("#user_city_id").empty().trigger('change');

    });

    $(document).ready(function() {
        $('#select_img').change(function() {
            var file = this.files[0]
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#profile_img').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

    });
    $('#profile_img').click(function() {
        $('#select_img').trigger('click');
    });

    $(document).ready(function() {
        $('#select_SIGR').change(function() {
            var file = this.files[0]
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#SIGR_img').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

    });
    $('#SIGR_img').click(function() {
        $('#select_SIGR').trigger('click');
    });
</script>
