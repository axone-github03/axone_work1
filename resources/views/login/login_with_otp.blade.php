
</html>
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
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
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
                                <form class="needs-validation" action="{{ route('login.otp.process') }}"
                                    method="POST" novalidate>
                                    @csrf
                                    <input type="hidden" id="type" name="type"
                                        value="{{ $data['type'] }}">
                                    <div class="alert alert-danger" id="error" style="display: none;"></div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email / Phone number</label>
                                        {{-- <div class="alert alert-success" id="successAuth" style="display: none;"></div> --}}
                                        <input type="text" class="form-control" id="email"
                                            placeholder="Enter email/phone number" required name="email"
                                            @if ($data['type'] == 1) readonly @endif
                                            value="{{ $data['email'] }}">
                                    </div>
                                    {{-- <div id="recaptcha-container"></div> --}}
                                    {{-- <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div> --}}
                                    @if ($data['type'] == 1)
                                        <div class="container height-100 d-flex justify-content-center align-items-center"
                                            id="div_verify_otp">
                                            <div class="position-relative">
                                                <div class="card-1 p-2 text-center">
                                                    <h6>Please enter the one time password <br> to verify your account
                                                    </h6>
                                                    <div>
                                                        <span>A code has been sent to</span>
                                                        <small id="recieverLable"></small>
                                                    </div>
                                                    <div id="otp"
                                                        class="inputs d-flex flex-row justify-content-center mt-2">
                                                        <input class="m-2 text-center form-control rounded"
                                                            type="text" id="first" maxlength="1"
                                                            name="one_time_password[]" />
                                                        <input class="m-2 text-center form-control rounded"
                                                            type="text" id="second" maxlength="1"
                                                            name="one_time_password[]" />
                                                        <input class="m-2 text-center form-control rounded"
                                                            type="text" id="third" maxlength="1"
                                                            name="one_time_password[]" />
                                                        <input class="m-2 text-center form-control rounded"
                                                            type="text" id="fourth" maxlength="1"
                                                            name="one_time_password[]" />

                                                    </div>
                                                    <div class="mt-4">
                                                        <button type="submit"
                                                            class="btn btn-primary waves-effect waves-light"
                                                            formaction="{{ route('login.otp.process') }}?validate=1">Validate</button>
                                                    </div>
                                                    <br>
                                                    <div class="content justify-content-center align-items-center">
                                                        <span>Didn't get the code?</span>
                                                        <button type="submit" id="resendOTP"
                                                            class="btn btn-sm btn-dark" type="submit">Resend</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif

                                    @if ($data['type'] == 0)
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light"
                                                type="submit">Send
                                                {{-- <button class="btn btn-primary waves-effect waves-light" onclick="sendOTP();" type="button">Send --}}
                                                OTP</button>
                                        </div>
                                    @endif

                                    <br>

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

                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="btn btn-info waves-effect waves-light w-100">Login With Password</a>

                                    </div>

                                    <div class="mt-1 text-center">
                                        <a href="{{ route('forgot.password') }}" class="btn btn-warning waves-effect waves-light w-100"><i
                                                class="mdi mdi-lock me-1"></i> Forgot your password?</a>

                                    </div>
                                </form>

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

    <script type="text/javascript">
        // window.onload = function() {
        //     render();
        // };

        // function render() {
        //     window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
        //     recaptchaVerifier.render();
        // }

        // function sendOTP() {
        //     var number = $("#email").val();
        //     firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
        //         window.confirmationResult = confirmationResult;
        //         coderesult = confirmationResult;
        //         console.log(coderesult);
        //         $("#successAuth").text("Message sent");
        //         $("#successAuth").show();
        //     }).catch(function (error) {
        //         $("#error").text(error.message);
        //         $("#error").show();
        //     });
        // }

        // function verify() {
        //     var code = $("#verification").val();
        //     coderesult.confirm(code).then(function (result) {
        //         var user = result.user;
        //         console.log(user);
        //         $("#successOtpAuth").text("Auth is successful");
        //         $("#successOtpAuth").show();
        //     }).catch(function (error) {
        //         $("#error").text(error.message);
        //         $("#error").show();
        //     });
        // }

        document.addEventListener("DOMContentLoaded", function(event) {

            function OTPInput() {
                const inputs = document.querySelectorAll('#otp > *[id]');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('keydown', function(event) {
                        if (event.key === "Backspace") {
                            inputs[i].value = '';
                            if (i !== 0) inputs[i - 1].focus();
                        } else {
                            if (i === inputs.length - 1 && inputs[i].value !== '') {
                                return true;
                            } else if (event.keyCode > 47 && event.keyCode < 58) {
                                inputs[i].value = event.key;
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            } else if (event.keyCode > 64 && event.keyCode < 91) {
                                inputs[i].value = String.fromCharCode(event.keyCode);
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            }
                        }
                    });
                }
            }
            OTPInput();


        });
        setTimeout(function() {

            $(".alert").hide(1000);

        }, 2000);
    </script>
</body>

</html>
