<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Whitelion" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/axone.jpg') }}">


    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css?v=2') }}" id="app-style" rel="stylesheet" type="text/css" />



    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    {{-- <link href="{{ asset('assets/css/datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">

    {{-- <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon--> --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.min.css') }}" />
    <!-- Custom Css -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">

    {{-- <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" /> --}}
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        function baseURL(parameters = "") {

            var baseURL = '{{ URL::to('/') }}' + parameters;
            return baseURL;

        }

        function getSpaceFilePath(filePath = "") {

            var getSpaceFilePath = '{{ getSpaceFilePath('') }}';

            return getSpaceFilePath + filePath;

        }
    </script>
    <style type="text/css">
        .form-check,
        .form-check-input,
        .form-check-label {
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .logo-lg img,
        .logo-sm img {
            filter: drop-shadow(2px 4px 6px black);
        }

        .custom-loader {
            animation: none !important;
            border-width: 0 !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-close-mask {
            z-index: 2099;
        }

        .select2-dropdown {
            z-index: 3051;
        }

        .vertical-align-middle td,
        .vertical-align-middle th {
            vertical-align: middle;
        }

        .badge-soft-orange {
            color: orange;
            background-color: rgb(231 205 152 / 18%);

        }

        .dropdown-menu-notification {

            width: 600px;

        }

        .user-notification-avatar-xs {
            min-width: 2rem !important;
        }

        .user-notication-btm:hover {
            fill: black;
        }

        .btn-notification-action.btn-outline-primary:hover {
            background-color: white;
            color: #556ee6;
        }

        ::-webkit-scrollbar {

            width: 20px;

        }

        ::-webkit-scrollbar-thumb {

            background-color: #d6dee1;

            border-radius: 20px;

            border: 6px solid transparent;

            background-clip: content-box;

        }

        ::-webkit-scrollbar-thumb:hover {

            background-color: #a8bbbf;

        }

        ::-webkit-scrollbar-track {

            background-color: transparent;

        }

        .inquiry-log-active {
            background: black;
            border-color: black;
        }

        .inquiry-log-active:focus {
            background: black;
            border-color: black;
            box-shadow: none;
        }

        .fc-event {
            border: 0 !important;
        }

        .class-closing {
            background: #cd4444 !important;
        }

        .sidebar-enable.vertical-collpsed .collpsed-icon {
            left: -10px;
            top: 0px !important;
            position: relative;
        }

        .uncollpsed-icon {
            top: 20px;
            position: relative;
            left: 0px;
        }

        .noti-icon .badge {
            top: 3px !important;
        }

        .input-box input {
            height: 100%;
            width: 100%;
            outline: none;
            font-size: 18px;
            font-weight: 400;
            border: none;
            padding: 0 155px 0 65px;
            background-color: transparent;
        }

        .funnel {
            height: 30px;
            width: auto;
            float: left;
            margin-right: 0.50%;
            position: relative;
            text-align: center;
            text-indent: 16px;
            line-height: 30px;
            font-size: 14px;
            background: #A9A9A9;
            color: #ffffff;
            /* box-shadow: inset 0px 20px 20px 20px rgb(0 0 0 / 15%); */
        }

        .funnel.active {
            background: #556ee6;
            color: #fff;
        }

        .funnel.active:before {
            border-left-color: #556ee6 !important;
            z-index: 999 !important;
        }

        .funnel.active:before,
        .funnel.active:after {
            position: absolute !important;
            content: '' !important;
            z-index: 1;
            width: 0px !important;
            height: 0 !important;
            top: 50% !important;
            margin: -15px 0 0 !important;
            border: 15px solid transparent;
            border-left-color: #fff;
        }

        .funnel:hover {
            background: #556ee6;
            color: #fff;
        }

        .funnel:hover::before {
            border-left-color: #556ee6;
        }

        /* .funnel:first-child {
            margin-right: 3.99%;
        } */

        .funnel:before,
        .funnel:after {
            position: absolute;
            content: '';
            z-index: 1;
            width: 0px;
            height: 0;
            top: 50%;
            margin: -15px 0 0;
            border: 15px solid transparent;
            border-left-color: #ffffff;
        }

        .funnel:after {
            left: 0%;
        }

        .funnel:before {
            left: 100%;
            z-index: 99;
        }

        .funnel:before {
            border-left-color: #A9A9A9;
        }

        .dropdown-menu-advancefilter {
            width: 700px !important;
        }

        .funnel.next-status-active-class {
            background: #556ee6;
            color: #fff;
        }

        .funnel.next-status-active-class:before {
            border-left-color: #556ee6 !important;
            z-index: 999 !important;
        }

        .funnel.next-status-active-class:before,
        .funnel.next-status-active-class:after {
            position: absolute !important;
            content: '' !important;
            z-index: 1;
            width: 0px !important;
            height: 0 !important;
            top: 50% !important;
            margin: -15px 0 0 !important;
            border: 15px solid transparent;
            border-left-color: #fff;
        }

        .phone_error {
            background-color: #fff;
            padding: 15px;
            width: auto;
            border-radius: 20px;
            box-shadow: 0 2px 5px #00000033;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            overflow: hidden;
        }

        .phone_error svg,
        .phone_error i {
            color: white;
            border-radius: 50%;
            font-size: 20px;
            width: 50px;
            height: 40px;
            display: flex !important;
            justify-content: center;
            align-items: center;
        }

        .phone_error span {
            font-size: 18px;
            color: white !important;
            line-height: 1.6;
            width: 100%;
        }

        .phone_error.danger {
            border: 1px solid #bd3630;
            background-color: #bd3630b0;
        }

        .phone_error.danger svg,
        .phone_error.danger i {
            background-color: #bd3630;
        }

        .phone_error .bx-x-circle {
            /* position: absolute; */
            /* right: 15px; */
            color: white;
            background-color: transparent !important;
        }

        #phone_no_error_dialog {
            position: absolute;
            top: 40%;
            z-index: 999;
        }



        ul ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        li:hover>ul {
            display: block;
        }




        ul ul a:hover {
            background-color: #f0f0f0;
        }

        .d-flex {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 3rem;
        }

        .user-info {
            margin-bottom: 4rem;
        }

        .user-info .row {
            display: none;
        }

        .user-info .row.show {
            display: flex;
        }

        .image {
            cursor: pointer;
        }

        .image img {
            width: 50%;
        }

        .mega-menu {
            font-size: 20px;
            text-decoration: none;
            color: #000;
            /* Adjust color as needed */
            margin-right: 10px;
            /* Adjust spacing as needed */
        }

        #user-dropdown {
            display: none;
        }

        #page-header-user-dropdown:focus+#user-dropdown,
        #user-dropdown:hover {
            display: block;
        }
    </style>

</head>

<body>


    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>





    <header class="navbar-header" id="page-topbar">
        <div class="w-100 ms-4" id="top-menu-lead">
            <div class="row align-items-center">
                <div class="col-12 text-end">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown">
                            <img class="rounded-circle header-profile-user" src="{{ asset('images/axone.jpg') }}"
                                alt="Header Avatar">
                        </button>

                        <div class="dropdown-menu dropdown-menu-lg-right" id="user-dropdown">


                            <a class="dropdown-item" href="{{ route('changepassword') }}">
                                <i class="bx bx-lock font-size-14 align-middle text-danger me-1">&nbsp;Change
                                    Password</i>

                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                <i
                                    class="bx bx-power-off font-size-14 align-middle me-1 text-danger">&nbsp;Logout</i>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!-- ========== Left Sidebar Start ========== -->
    <aside id="leftsidebar" class="sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dashboard"><i
                        class="bx bx-home m-r-5"></i>Oreo</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#user" id="userDetail"><i
                        class="bx bx-user m-r-5"></i>User</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane stretchRight active" id="dashboard">

                {{-- <div class="user-info mb-4">
                    <div class="image" id="img_logo"> <img src="{{ asset('images/axone.jpg') }}" width="50%">
                    </div>
                </div> --}}

                <div class="menu">
                    <ul class="list">

                        <li class="header">MAIN</li>
                        <li class=" open"> <a href="{{ route('dashboard') }}"><i
                                    class="bx bx-home"></i><span>Dashboard</span></a>
                        </li>
                        <li class="open"> <a href="{{ route('company.index') }}"><i
                                    class="bx bx-group"></i><span>Company</span></a>
                        </li>
                        <li class="open"> <a href="{{ route('branch.index') }}"><i
                                    class="bx bx-group"></i><span>Branch</span></a>
                        </li>
                        <li class="open"> <a href="{{ route('users.admin') }}"><i
                                    class="bx bx-group"></i><span>User</span></a>
                        </li>
                        <li class="open"> <a href="{{ route('users.order.index') }}"><i
                                    class="bx bx-group"></i><span>Order</span></a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class=""><i
                                    class="bx bx-map"></i><span>Location</span></a>
                            <ul class="">
                                <li><a href="{{ route('countrylist') }}">Country</a></li>
                                <li><a href="{{ route('statelist') }}">State</a></li>
                                <li><a href="{{ route('citylist') }}">City</a></li>
                            </ul>
                        </li>




                    </ul>
                </div>
            </div>
            <div class="tab-pane stretchLeft" id="user">
                <div class="menu">
                    <ul class="list">
                        <li>
                            <div class="user-info mt-4">
                                <div class="image mb-5"><img width="50%" id="user_img" alt="User"></div>
                                <div class="detail">
                                    <h4 id="full_name"></h4>
                                    <small></small>
                                </div>

                                <p class="text-muted" id="address"></p>
                            </div>
                        </li>
                        <li>
                            <small class="text-muted">Email address: </small>
                            <p id="email"> </p>
                            <hr>
                            <small class="text-muted">Phone: </small>
                            <p id="phone_number"></p>
                            <hr>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </aside>
    <!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        @yield('content')

    </div>

    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script><!-- Morris Plugin Js -->
    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script> <!-- Jquery Knob, Count To, Sparkline Js -->

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>




    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/datetimepicker.min.js') }}"></script>

    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>


    <!-- dashboard init -->

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-fixedcolumns/js/fixedColumns.min.js') }}"></script>






    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>


    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/c/user-notification.js') }}?v={{ time() }}"></script>

    <script type="text/javascript">
        //  $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 200,
            "hideDuration": 1000,
            "timeOut": 3000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        @if (session('success'))
            toastr["success"](" {{ session('success') }}")
        @endif
        @if (session('error'))
            toastr["error"](" {{ session('error') }}")
        @endif
        @if (session('warning'))
            toastr["warning"](" {{ session('warning') }}")
        @endif
        @if (session('info'))
            toastr["info"](" {{ session('info') }}")
        @endif

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }


        function getCookie(cookieName) {
            let cookie = {};
            document.cookie.split(';').forEach(function(el) {
                let [key, value] = el.split('=');
                cookie[key.trim()] = value;
            })
            return cookie[cookieName];
        }

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }


        $(document).on('click', '.dropdown-menu-notification', function(e) {

            $(this).addClass('show');
            $("#page-header-notifications-dropdown").addClass('show');

        });

        $(document).ready(function() {
            var ajaxURLUserDetail = '{{ route('user.detail') }}';

            $.ajax({
                type: 'GET',
                url: ajaxURLUserDetail,
                success: function(resultData) {
                    if (resultData['status'] == 1) {
                        var userData = resultData.data;

                        // Update the HTML elements with user data
                        $('#user_img').attr('src', resultData['img']);
                        $('#full_name').text(userData.first_name + ' ' + userData.last_name);
                        $('#address').text(userData.address_line1 + ' ' + userData.address_line2 +
                            ', ' + userData.area + ', ' + userData.pincode);
                        $('#email').text(userData.email);
                        $('#phone_number').text(userData.dialing_code + ' ' + userData.phone_number);
                    }
                }
            });
        });
        document.querySelector('.image').addEventListener('click', function() {
            document.querySelectorAll('.user-info .row').forEach(function(row) {
                row.classList.toggle('show');
            });
        });
    </script>

    @yield('custom-scripts')
</body>

</html>
