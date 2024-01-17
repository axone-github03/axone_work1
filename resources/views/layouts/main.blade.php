<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Whitelion" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/mamaiyalogo.ico') }}">


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
    </style>

</head>

<body data-sidebar="dark">


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


    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">

                <div class="d-flex align-items-center">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" style="height: 70px;">
                        <div class="col-10" style="height: 100%">
                            @php
                                // Assuming the User model has a company relationship
                                $company = Auth::user()->company;
                                if ($company) {
                                    $companyLogo = asset($company->company_logo);
                                }
                            @endphp

                            <a class="item">
                                @if (isset($companyLogo))
                                    <img src="{{ $companyLogo }}" style="height: 120%; width: 130%" alt="">
                                @endif
                            </a>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
                <div class="w-100 ms-4 " id="top-menu-lead">
                    <div class="row align-items-center">
                        <div class="col-12 text-end">
                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect"
                                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <img class="rounded-circle header-profile-user"
                                        src="{{ asset('assets/images/users/default.png') }}" alt="Header Avatar">
                                </button>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('profile') }}"><i
                                            class="bx bx-user font-size-16 align-middle me-1"></i> <span
                                            key="t-profile">Profile</span></a>

                                    <a class="dropdown-item" href="{{ route('changepassword') }}"><i
                                            class="bx bx-lock font-size-16 align-middle me-1"></i> <span
                                            key="t-change-password">Change Password</span></a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                        <span key="t-logout">Logout</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">


                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu">Menu</li>
                    <li>
                        <a href="{{ route('dashboard') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i><span
                                class="badge rounded-pill bg-info float-end"></span>
                            <span key="t-dashboards">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('company.index') }}" class="waves-effect">
                            <i class="bx bx-group"></i>
                            <span key="t-company">Company Master</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('branch.index') }}" class="waves-effect">
                            <i class="bx bx-group"></i>
                            <span key="t-branch">Branch Master</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.admin') }}" class="waves-effect">
                            <i class="bx bx-group"></i>
                            <span key="t-user">User</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('user.type.index') }}" class="waves-effect">
                            <i class="bx bx-group"></i>
                            <span key="t-user">User Type</span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ route('users.order.index') }}" class="waves-effect">
                            <i class="bx bx-group"></i>
                            <span key="t-order">Order</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-map"></i>
                            <span key="t-location">Location</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">




                            <li>
                                <a href="{{ route('countrylist') }}" class="waves-effect">

                                    <span key="t-country">Country List</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('statelist') }}" class="waves-effect">

                                    <span key="t-state">State List</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('citylist') }}" class="waves-effect">

                                    <span key="t-city">City List</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
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
    </script>

    @yield('custom-scripts')
</body>

</html>
