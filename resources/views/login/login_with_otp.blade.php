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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        body {
            background-image: linear-gradient(to right top, #ffffff, #d6d0fc, #aaa4f7, #7579f2, #1251eb);
        }
    </style>

    <style type="text/css">
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }


        .card-2 {

            padding: 10px;
            width: 350px;
            height: 100px;
            bottom: -50px;
            left: 20px;
            position: absolute;
            border-radius: 5px;
        }

        .card-2 .content {
            margin-top: 50px;
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
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Sign in to continue to Whitelion.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">

                            <div class="p-2">
                                <form class="needs-validation" action="{{ route('login.otp.process') }}" method="POST"
                                    novalidate>
                                    @csrf
                                    <input type="hidden" id="type" name="type" value="{{ $data['type'] }}">
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
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Send
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

                                    <div class="mt-4 text-center">
                                        <a href="{{ route('login') }}" class="text-primary">Login With Password</a>

                                    </div>

                                    <div class="mt-1 text-center">
                                        <a href="{{ route('forgot.password') }}" class="text-primary"><i
                                                class="mdi mdi-lock me-1"></i> Forgot your password?</a>

                                    </div>
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    {{-- <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script> --}}

    <script>
        // var firebaseConfig = {
        //     apiKey: "AIzaSyDpibnKQmI4KIcW8TNwXbquNZ69GxO8aUw",
        //     authDomain: "whitelion-erp.firebaseapp.com",
        //     databaseURL: "https://whitelion-erp.firebaseio.com",
        //     projectId: "whitelion-erp",
        //     storageBucket: "whitelion-erp.appspot.com",
        //     messagingSenderId: "877490806309",
        //     appId: "1:877490806309:web:b474f6be0305c76759a9cc",
        //     measurementId: "G-TYCCHHZFBE"
        // };
        // firebase.initializeApp(firebaseConfig);
    </script>
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
