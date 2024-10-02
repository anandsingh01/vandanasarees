@extends('layouts.web')

@section('css')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" integrity="sha256-yrj5fXlNcKz4PP4UVLG3B1TlTt7pMr4I5jovQVRSHqQ=" crossorigin="anonymous" />
    <style>
        .sticky_header {
            position: unset;
            z-index: 9999;
        }
        .watch_header + main {
            margin-top: 0px;
        }

    </style>
    <style>


        .login {
            background: #e1e3de;
            transtion: 0.5s
        }
        /*.login.active {*/
        /*    background: #f43648;*/
        /*}*/
        .login.active {
            background: #ffffff;
        }
        #login .container {
            position: relative;
            width: 800px;
            height: 500px;
            margin: 20px;
            margin:0 auto;
            /*   background: #F00 */
        }
        .blueBg {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 40px;
            width: 100%;
            height: 420px;
            background: rgba(255,255,255,0.2);
            box-shadow: 0 5px 45px rgba(0,0,0,0.15);
        }

        .blueBg .box {
            position: relative;
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .blueBg .box h2 {
            color: #000;
            font-size: 1.2em;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .blueBg .box button {
            cursor: pointer;
            padding: 10px 20px;
            background: #FFF;
            color: #333;
            font-weight: 500;
            border: none
        }

        .formBx {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: #FFF;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 45px rgba(0,0,0,0.25);
            transition: 0.5s ease-in-out;
            overflow: hidden;
        }

        .formBx.active {
            left: 50%;
        }

        .formBx .form {
            position: absolute;
            left: 0;
            width: 100%;
            padding: 50px;
            transition: 0.5s;
        }

        .formBx .signinForm {
            transition-delay: 0.25s;
        }

        .formBx.active .signinForm {
            left: -100%;
            transition-delay: 0s;
        }

        .formBx .signupForm {
            left: 100%;
            transition-delay: 0s;
        }

        .formBx.active .signupForm {
            left: 0;
            transition-delay: 0.25s;
        }

        .formBx .form form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        .formBx .form form h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .formBx .form form input {
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            outline: none;
            font-size: 16px;
            border: 1px solid #333
        }

        .formBx .form form input[type="submit"] {
            background: #03a9f4;
            border: none;
            color: #FFF;
            max-width: 100px;
            cusror: pointer;
        }

        .formBx .form form .forgot {
            color: #333;
        }

        .formBx.active .signupForm input[type="submit"] {
            background: #f43648;
        }
        div#login {
            padding: 5em;
        }
        button#verifyBtn {
            background: #da0a2c;
            color: #fff;
            padding: 2px 5px;
        }

        input#mobileInput {
            position: relative;
            padding: 10px 40px;
        }
        span.flag-icon.flag-icon-in {
            position: absolute;
            top: 18%;
            padding: 0px 10px;
        }
        input#mobileInput2 {
            position: relative;
            padding: 10px 40px;
        }
        span.flagabsolute {
            position: absolute;
            top: 18%;
            left: 0;
            padding: 0px 10px;
        }
        @media(max-width: 991px) {

            #login  .container {
                max-width: 100%;
                height: 650px;
                display: flex;
                justify-content: center;
                align-item: center;
            }

            #login .container .blueBg {
                top: 0;
                height: 100%;
            }

            #login .container .blueBg .box {
                position: absolute;
                width: 100%;
                height: 150px;
                bottom: 0
            }

            .box.signin {
                top: 0;
            }

            .formBx {
                width: 100%;
                height: 500px;
                top: 0;
                box-shadow: none
            }

            .formBx.active {
                left: 0;
                top: 150px;
            }
        }

        @media(max-width: 600px) {
            div#login {
                padding: 15px;
            }
        }
    </style>
@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();
    ?>

            <!-- breadcrumb_section - start
       ================================================== -->
    {{--    <section class="breadcrumb_section text-white text-center text-uppercase d-flex align-items-end clearfix"--}}
    {{--             data-background="{{asset('images/webp/74651700935498.webp')}}">--}}
    {{--        <div class="overlay" data-bg-color="#1d1d1d"></div>--}}
    {{--        <div class="container">--}}
    {{--            <h1 class="page_title text-white">Order Page</h1>--}}
    {{--            <ul class="breadcrumb_nav ul_li_center clearfix">--}}
    {{--                <li><a href="#!">Home</a></li>--}}
    {{--                <li>Order details</li>--}}
    {{--            </ul>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    <!-- breadcrumb_section - end
       ================================================== -->


    <div class="login" id="login">

        <div class="container">

            <div class="blueBg">
                <div class="box signin">
                    <h2>Already have an account ?</h2>
                    <button class="signinBtn">Sign In</button>
                    <a href="{{ url('login/google') }}" style="display: inline-block;
                         background-color: #DD4B39; color: #ffffff; padding: 10px 15px;  width: auto;
                          text-decoration: none; margin:10px 0;" >
                        Login With <i class="fab fa-google" style="margin-left: 5px;"></i>
                    </a>
                </div>

                <div class="box signup">
                    <h2>Create new account ?</h2>
                    <button class="signupBtn">Sign Up</button>
                    <a href="{{ url('login/google') }}" style="display: inline-block;
                         background-color: #DD4B39; color: #ffffff; padding: 10px 15px;  width: auto;
                          text-decoration: none; margin:10px 0;" >
                        Login With <i class="fab fa-google" style="margin-left: 5px;"></i>
                    </a>
                </div>

            </div>


            <div class="formBx">


                <div class="form signinForm">

                    {{--                    --}}
                    <h3  class="text-center">Login Using OTP</h3>
                    <div class="container1">

                        <style>
                            #otpSection {
                                display: none;
                            }
                        </style>
                        <div id="mobileSection">
{{--                            @if(Session::has('otp_details'))--}}
{{--                                {{ Session::get('otp_details') }}--}}
{{--                            @endif--}}
                            <form id="mobileForm" style="position: relative;">
                                <div style="position: relative;">
                                    <!-- Wrapper around input to control positioning -->
                                    <span class="flag-icon flag-icon-in" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">+91</span>
                                    <input type="tel" name="mobile" id="mobileInput" placeholder="Enter Mobile"
                                           maxlength="10"
                                           style="padding-left: 40px;"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '');">
                                </div>
                                <input type="submit" value="Send OTP">
                            </form>
                        </div>

                        <div id="otpSection">
                            <div id="result"></div>
                            <input type="text" class="textbox" id="otpInput" placeholder="Enter OTP" maxlength="6">

                            <button type="button" id="verifyBtn">Verify OTP</button>
                            <button type="button" id="resendBtn" class="badge badge-primary">Resend OTP</button>
                            <button type="button" id="changeMobileBtn" class="badge badge-warning">Change Mobile Number</button>
                        </div>

                        <div id="result"></div>
                        <div id="error" style="color:red;"></div>
                    </div>


{{--                    <form action="{{ url('check-login') }}" method="post" id="login_form" name="login_form">--}}

{{--                        <h3 class="text-center">OR</h3>--}}
{{--                        @csrf--}}
{{--                        <input type="text" name="email" placeholder="User Name">--}}
{{--                        <input type="password"  name="password" placeholder="Password">--}}
{{--                        <input type="submit" value="Login">--}}
{{--                        <a href="{{route('password.request')}}" class="forgot">Forgot Password</a>--}}
{{--                    </form>--}}
                </div>

                <div class="form signupForm">
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf
                        <h3>Sign Up</h3>

                        <input type="text" name="name" placeholder="User Name" required>

                        <div style="position: relative;">
                            <input type="text" name="phone" placeholder="Phone" id="mobileInput2"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '');"
                                   maxlength="10" required>
                            <span class="flag-icon flag-icon-in flagabsolute">+91</span>
                        </div>

                        <!-- Hidden OTP input (initially not shown) -->
                        <div id="otpField" style="display: none; margin-top: 10px;">
                            <input type="text" name="otp" id="otpInput" placeholder="Enter OTP" maxlength="6">
                        </div>

                        <span id="passwordError" style="color: red;"></span>
                        <button type="button" id="resendBtn" class="badge badge-primary">Resend OTP</button>
                        <input type="submit" id="submitBtn" value="Register">

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const form = document.getElementById('registerForm');
                                const submitBtn = document.getElementById('submitBtn');
                                const otpField = document.getElementById('otpField');
                                let otpRequested = false;

                                form.addEventListener('submit', function (event) {
                                    // Prevent form submission
                                    event.preventDefault();

                                    if (!otpRequested) {
                                        // Simulate sending OTP and show OTP input field
                                        otpRequested = true;
                                        alert('OTP has been sent to your phone!'); // You can replace this with actual OTP sending logic

                                        // Display the OTP field
                                        otpField.style.display = 'block';
                                        submitBtn.value = 'Submit OTP'; // Change button text
                                    } else {
                                        // Validate OTP
                                        const otpInput = document.getElementById('otpInput').value;

                                        if (otpInput.length === 6) {
                                            // If OTP is valid, allow the form to be submitted
                                            form.submit();
                                        } else {
                                            alert('Please enter a valid 6-digit OTP.');
                                        }
                                    }
                                });
                            });
                        </script>
                    </form>
                </div>

            </div>
        </div>
    </div>

@stop
@section('js')

    <script>
        document.getElementById('mobileForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let mobileInput = document.getElementById('mobileInput');
            let mobileNumber = mobileInput.value.trim();

            // Validate mobile number for 10 digits
            if (/^\d{10}$/.test(mobileNumber)) {
                // Your logic for sending OTP
                // Show OTP section
                document.getElementById('mobileSection').style.display = 'none';
                document.getElementById('otpSection').style.display = 'block';
            } else {
                // Display error if mobile number is invalid
                document.getElementById('error').innerHTML = 'Please enter a valid 10-digit mobile number';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#mobileForm').submit(function(event) {
                event.preventDefault();
                sendOTP();
            });

            $('#verifyBtn').click(function() {
                verifyOTP();
            });

            $('#resendBtn').click(function() {
                resendOTP();
            });

            $('#changeMobileBtn').click(function() {
                changeMobile();
            });
        });

        function sendOTP() {
            var mobileNumber = $('#mobileInput').val();

            // AJAX request to send OTP
            $.ajax({
                url: '{{url('sent-login-otp')}}', // Replace with your actual endpoint
                type: 'GET',
                data: { mobile: mobileNumber },
                success: function(response) {

                    console.log(response);
                    if(response.code == 200){
                        // Handle success response
                        $('#otpSection').show();
                        $('#mobileSection').hide();
                        $('#error').hide();
                        $('#result').text('OTP sent to ' + mobileNumber);
                    }
                    if(response.code == 404){
                        $('#error').text('User not found. Check your number');
                    }


                    return false;

                },
                error: function(error) {
                    // Handle error response
                    console.error('Error sending OTP: ', error);
                }
            });
        }

        function verifyOTP() {
            // alert('abc');

            // Implement OTP verification logic here
            var enteredOTP = $('#otpInput').val();
            var mobileNumber = $('#mobileInput').val();
            // alert(mobileNumber);
            // return false;

            $.ajax({
                url: '{{url('verify-otp')}}', // Replace with your actual endpoint
                type: 'GET', // Change to POST if needed
                data: { mobile: mobileNumber, otp: enteredOTP },
                success: function(response) {
                    console.log(response);

                    if(response.code == 200){
                        window.location.href = '{{url('/')}}';
                    }
                    if(response.code == 404){
                        $('#error2').text('User not found. Check your number');

                        // Redirect to the login page after failure
                        window.location.href = '{{url('/login')}}';
                    }
                    return false;
                },
                error: function(error) {
                    // Handle error response
                    console.error('Error sending OTP: ', error);
                }
            });
            // Implement OTP verification logic here
            {{--var enteredOTP = $('#otpInput').val();--}}

            {{--$.ajax({--}}
            {{--    url: '{{url('sverify-otp')}}', // Replace with your actual endpoint--}}
            {{--    type: 'GET',--}}
            {{--    data: { mobile: mobileNumber },--}}
            {{--    success: function(response) {--}}

            {{--        console.log(response);--}}
            {{--        if(response.code == 200){--}}
            {{--            // Handle success response--}}
            {{--            $('#otpSection').show();--}}
            {{--            $('#mobileSection').hide();--}}
            {{--            $('#error').hide();--}}
            {{--            $('#result').text('OTP sent to ' + mobileNumber);--}}
            {{--        }--}}
            {{--        if(response.code == 404){--}}
            {{--            $('#error').text('User not found. Check your number');--}}
            {{--        }--}}


            {{--        return false;--}}

            {{--    },--}}
            {{--    error: function(error) {--}}
            {{--        // Handle error response--}}
            {{--        console.error('Error sending OTP: ', error);--}}
            {{--    }--}}
            {{--});--}}
            {{--// Replace the following condition with your actual OTP verification logic--}}
            {{--if (enteredOTP === '123456') {--}}
            {{--    $('#result').text('OTP Verified!');--}}
            {{--} else {--}}
            {{--    $('#result').text('Incorrect OTP. Please try again.');--}}
            {{--}--}}
        }

        function resendOTP() {
            // Implement OTP resending logic here
            var mobileNumber = $('#mobileInput').val();
            $('#result').text('OTP resent to ' + mobileNumber);
        }

        function changeMobile() {
            $('#otpSection').hide();
            $('#mobileSection').show();
            $('#result').text(''); // Clear result message
        }
    </script>

    {{--    <script>--}}
    {{--        $(document).ready(function() {--}}
    {{--            $('#mobileForm').submit(function(event) {--}}
    {{--                event.preventDefault();--}}
    {{--                sendOTP();--}}
    {{--            });--}}

    {{--            $('#verifyBtn').click(function() {--}}
    {{--                verifyOTP();--}}
    {{--            });--}}

    {{--            $('#resendBtn').click(function() {--}}
    {{--                resendOTP();--}}
    {{--            });--}}

    {{--            $('#changeMobileBtn').click(function() {--}}
    {{--                changeMobile();--}}
    {{--            });--}}
    {{--        });--}}

    {{--        function sendOTP() {--}}
    {{--            // // Implement OTP sending logic here--}}
    {{--            var mobileNumber = $('#mobileInput').val();--}}
    {{--            $('#otpSection').show();--}}
    {{--            $('#mobileSection').hide();--}}
    {{--            $('#result').text('OTP sent to ' + mobileNumber);--}}
    {{--        }--}}



    {{--        function verifyOTP() {--}}
    {{--            // Implement OTP verification logic here--}}
    {{--            var enteredOTP = $('#otpInput').val();--}}
    {{--            // Replace the following condition with your actual OTP verification logic--}}
    {{--            if (enteredOTP === '123456') {--}}
    {{--                $('#result').text('OTP Verified!');--}}
    {{--            } else {--}}
    {{--                $('#result').text('Incorrect OTP. Please try again.');--}}
    {{--            }--}}
    {{--        }--}}

    {{--        function resendOTP() {--}}
    {{--            // Implement OTP resending logic here--}}
    {{--            var mobileNumber = $('#mobileInput').val();--}}
    {{--            $('#result').text('OTP resent to ' + mobileNumber);--}}
    {{--        }--}}

    {{--        function changeMobile() {--}}
    {{--            $('#otpSection').hide();--}}
    {{--            $('#mobileSection').show();--}}
    {{--            $('#result').text(''); // Clear result message--}}
    {{--        }--}}
    {{--    </script>--}}
    <script>
        const signingBtn = document.querySelector(".signinBtn");
        const signiupBtn = document.querySelector(".signupBtn");
        const formBx = document.querySelector(".formBx");
        const body = document.querySelector(".login");

        signiupBtn.onclick = function() {
            formBx.classList.add("active");
            body.classList.add("active");
        }

        signingBtn.onclick = function() {
            formBx.classList.remove("active");
            body.classList.remove("active");
        }

    </script>


    <script>
        $(document).ready(function () {
            // Add keyup event listeners to password and password confirmation fields
            $("#password, #passwordConfirmation").keyup(function () {
                // Get the values of the password and password confirmation fields
                var password = $("#password").val();
                var passwordConfirmation = $("#passwordConfirmation").val();

                // Check if the passwords match
                if (password !== passwordConfirmation) {
                    // Show an error message
                    $("#passwordError").text("Passwords do not match");
                } else {
                    // Clear the error message
                    $("#passwordError").text("");
                }
            });

            // Add an event listener to the form submission
            $("#registrationForm").submit(function (event) {
                // Prevent the form from submitting
                event.preventDefault();

                // Get the values of the password and password confirmation fields
                var password = $("#password").val();
                var passwordConfirmation = $("#passwordConfirmation").val();

                // Check if the passwords match
                if (password !== passwordConfirmation) {
                    // Show an error message
                    $("#passwordError").text("Passwords do not match");
                } else {
                    // Clear the error message and submit the form
                    $("#passwordError").text("");
                    this.submit();
                }
            });
        });
    </script>

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{your-app-id}',
                cookie     : true,
                xfbml      : true,
                version    : '{api-version}'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    </script>

@stop
