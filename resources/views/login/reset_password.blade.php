
<!doctype html>
<html lang="en">
<head>

        <meta charset="utf-8" />
        <title>Login | ERP - Whitelion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta content="Whitelion" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
         <style>
            body{
                background-image: linear-gradient(to right top, #ffffff, #d6d0fc, #aaa4f7, #7579f2, #1251eb);
            }
        </style>

    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Reset Password</h5>
                                            <p>Whitelion</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">

                                <div class="p-2">
                                    <form class="needs-validation" action="{{route('reset.password.process')}}" method="POST" novalidate>
                                        @csrf

                                        <input type="hidden" name="reset_password_token" value="{{$data['reset_password_token']}}" >

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" required name="password" >

                                            </div>
                                        </div>

                                         <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="cpassword-addon" required name="cpassword" >

                                            </div>
                                        </div>




                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Reset Password</button>
                                        </div>

                                        <br>

                                         @if(session('error'))
                                   <div class="alert alert-danger" role="alert">
                                              <i class="mdi mdi-block-helper me-2"></i> {{ session('error') }}
                                        </div>

                                         @endif
                                            @if(session('success'))
                                   <div class="alert alert-success" role="alert">
                                              <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                                        </div>

                                         @endif






                                    </form>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
       <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script type="text/javascript">
            setTimeout(function(){

                $(".alert").hide(1000);

            }, 2000);
        </script>
    </body>


</html>
