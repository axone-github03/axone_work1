<!DOCTYPE html>
<!--
Template Name: Deepor - Responsive Bootstrap 4 Admin Dashboard Template
Author: Hencework

License: You must have a valid license purchased only from templatemonster to legally use the template for your project.
-->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Axone I Login</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/axone.jpg') }}">
    <link rel="icon" href="{{ asset('images/axone.jpg') }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css?v=2') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Toggles CSS -->
    <link href="{{ asset('assets/vendors4/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendors4/toggles-light.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/dist/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>


    <!-- HK Wrapper -->
    <div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 pa-0">
                        <div class="auth-form-wrap pt-xl-0 pt-70">
                            <div class="auth-form w-xl-30 w-lg-55 w-sm-75 w-100">
                                <a class="d-flex auth-brand align-items-center justify-content-center  mb-20"
                                    href="#">
                                    <img class="brand-img d-inline-block mr-5" src="{{ asset('images/axone.jpg') }}"
                                        alt="brand" />
                                </a>
                                <form class="needs-validation" action="{{ route('login.process') }}" method="POST"
                                    novalidate>
                                    @csrf
                                    <h1 class="display-4 text-center mb-10">Welcome Back :)</h1>
                                    <p class="text-center font-19 mb-30">Sign in to your account and enjoy unlimited perks.</p>
                                    <div class="form-group">
                                        <input class="form-control" id="email" required
                                            placeholder="Email / Phone number" name="email" type="email">
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Password" id="password-addon"
                                                required name="password" type="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><span class="feather-icon"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">

                                        <button class="btn btn-primary btn-block w-50 mt-3 font-15"
                                            type="submit">Login</button>&nbsp;&nbsp;&nbsp;&nbsp;

                                        <a href="{{ route('forgot.password') }}"
                                            class="btn btn-warning btn-block w-50 mt-3 font-15">Forget
                                            Password</a>
                                    </div>

                                </form>

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <i class="mdi mdi-block-helper me-2"></i> {{ session('error') }}
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- JavaScript -->

    <!-- jQuery -->
    <script src="{{ asset('assets/vendors4/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/vendors4/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendors4/bootstrap.min.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('assets/dist/jquery.slimscroll.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('assets/dist/dropdown-bootstrap-extended.js') }}"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="{{ asset('assets/dist/feather.min.js') }}"></script>

    <!-- Init JavaScript -->
    <script src="{{ asset('assets/dist/init.js') }}"></script>
</body>

</html>
