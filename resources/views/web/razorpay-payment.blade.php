@extends('layouts.web')
<?php
session_start();
?>
@section('css')
    <style>
        .sticky_header{
            position:unset;
        }
        .watch_header + main {
            margin-top: 0px;
        }

    </style>

    <style>
        .modal-full-width {
            width: 100%;
            max-width: 60%;
        }

        .modal-full-width .modal-content {
            width: 100%;
            /*max-width: 60%;*/
        }

        .billing_form .form_wrap {
            padding: 15px;
            border: 2px solid #e6e6e6;
        }
        .billing_form .checkbox_item {
            padding-left: 0;
        }

        .plans {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;

            max-width: 100%;
            padding: 25px 20px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            background: #fff;
            border-radius: 20px;
            /*-webkit-box-shadow: 0px 8px 10px 0px #d8dfeb;*/
            /*box-shadow: 0px 8px 10px 0px #d8dfeb;*/
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .plans .plan input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .plans .plan {
            cursor: pointer;
            width: 100%;
        }

        .plans .plan .plan-content {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding: 30px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            border: 2px solid #e1e2e7;
            border-radius: 10px;
            -webkit-transition: -webkit-box-shadow 0.4s;
            transition: -webkit-box-shadow 0.4s;
            -o-transition: box-shadow 0.4s;
            transition: box-shadow 0.4s;
            transition: box-shadow 0.4s, -webkit-box-shadow 0.4s;
            position: relative;
        }

        .plans .plan .plan-content img {
            margin-right: 30px;
            height: 72px;
        }

        .plans .plan .plan-details span {
            margin-bottom: 10px;
            display: block;
            font-size: 20px;
            line-height: 24px;
            color: #252f42;
        }

        .container .title {
            font-size: 20px;
            font-weight: 500;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
            color: #252f42;
            margin-bottom: 20px;
        }

        .plans .plan .plan-details p {
            color: #646a79;
            font-size: 14px;
            line-height: 18px;
        }

        .plans .plan .plan-content:hover {
            -webkit-box-shadow: 0px 3px 5px 0px #e8e8e8;
            box-shadow: 0px 3px 5px 0px #e8e8e8;
        }

        .plans .plan input[type="radio"]:checked + .plan-content:after {
            content: "";
            position: absolute;
            height: 8px;
            width: 8px;
            background: #216fe0;
            right: 20px;
            top: 20px;
            border-radius: 100%;
            border: 3px solid #fff;
            -webkit-box-shadow: 0px 0px 0px 2px #0066ff;
            box-shadow: 0px 0px 0px 2px #0066ff;
        }

        .plans .plan input[type="radio"]:checked + .plan-content {
            border: 2px solid #216ee0;
            background: #eaf1fe;
            -webkit-transition: ease-in 0.3s;
            -o-transition: ease-in 0.3s;
            transition: ease-in 0.3s;
        }

        @media screen and (max-width: 991px) {
            .plans {
                margin: 0 20px;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-align: start;
                -ms-flex-align: start;
                align-items: flex-start;
                padding: 40px;
            }

            .plans .plan {
                width: 100%;
            }

            .plan.complete-plan {
                margin-top: 20px;
            }

            .plans .plan .plan-content .plan-details {
                width: 70%;
                display: inline-block;
            }

            .plans .plan input[type="radio"]:checked + .plan-content:after {
                top: 45%;
                -webkit-transform: translate(-50%);
                -ms-transform: translate(-50%);
                transform: translate(-50%);
            }
        }

        @media screen and (max-width: 767px) {
            .plans .plan .plan-content .plan-details {
                width: 60%;
                display: inline-block;
            }
        }

        @media screen and (max-width: 540px) {
            .plans .plan .plan-content img {
                margin-bottom: 20px;
                height: 56px;
                -webkit-transition: height 0.4s;
                -o-transition: height 0.4s;
                transition: height 0.4s;
            }

            .plans .plan input[type="radio"]:checked + .plan-content:after {
                top: 20px;
                right: 10px;
            }

            .plans .plan .plan-content .plan-details {
                width: 100%;
            }

            .plans .plan .plan-content {
                padding: 20px;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-align: baseline;
                -ms-flex-align: baseline;
                align-items: baseline;
            }
        }

        /* inspiration */
        .inspiration {
            font-size: 12px;
            margin-top: 50px;
            position: absolute;
            bottom: 10px;
            font-weight: 300;
        }

        .inspiration a {
            color: #666;
        }
        #otpContainer {
            text-align: right;
            display: inline-block;
            width: 60%;
        }

        input#otpInput {
            width: 60%;
            padding: 15px;
        }

        .custom_btn.bg_danger{
            box-shadow:unset;
        }
        .coupon_wrap .form_item {
            width: 100%;
            margin-right: 30px;
            display: inline-block;
        }
        .checkout_table .subtotal_text, .checkout_table .total_price {
            font-weight: 700;
            text-align: left !important;
            float: right;
        }

        .image-round{
            width:10px;height:10px;border-radius: 50%;
            object-fit: cover;
        }
    </style>
@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $prodTotal = $get_count->cartTotal;
    $getAllCart = getCartProducts();
    ?>

        <!-- breadcrumb_section - start
       ================================================== -->
    <section class="breadcrumb_section text-white text-center text-uppercase d-flex align-items-end clearfix"
             data-background="{{asset('images/webp/74651700935498.webp')}}">
        <div class="overlay" data-bg-color="#1d1d1d"></div>
        <div class="container">
            <h1 class="page_title text-white">Checkout</h1>
            <ul class="breadcrumb_nav ul_li_center clearfix">
                <li><a href="#!">Home</a></li>
                <li>Shop</li>
                <li>Checkout</li>
            </ul>
        </div>
    </section>
    <!-- breadcrumb_section - end
       ================================================== -->


    <!-- checkout_section - start
   ================================================== -->
    <section class="checkout_section sec_ptb_140 clearfix">
        <div class="container">

            <form action="{{ url('/payment-successsss') }}" method="POST">
                @csrf
                <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="rzp_test_qhoHxWm9KDHv1C"
                data-amount="100000"
                data-currency="INR"
                data-order_id="{{ $orderid }}"
                data-buttontext="Pay with Razorpay"
                data-name="Your Company Name"
                data-description="Purchase Description"
                data-theme.color="#F37254"
                data-redirect="true">
                </script>

                <!-- Hidden fields to include in the form submission -->
                <input type="hidden" name="order_id" value="{{ $orderid }}">
{{--                <input type="hidden" name="total_amount" value="{{ $totalAmount }}">--}}


{{--                <button type="submit">Pay Now</button>--}}
            </form>


        </div>

        </div>
    </section>
    <!-- checkout_section - end
       ================================================== -->

@stop
@section('js')


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    @if(Session::has('error'))
        <script>
            swal("Address not found");
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // Get references to the elements
            var otpContainer = $('#otpContainer');
            var otpInputContainer = $('#otpInputContainer');
            var getOtpBtn = $('#getOtpBtn');
            var verifyOtpBtn = $('#verifyOtpBtn');
            var placeOrderBtn = $('#placeOrderBtn');

            $('#cash_delivery2').change(function() {
                placeOrderBtn.prop('disabled', false);
                otpContainer.hide();
                otpInputContainer.hide();
            });

            // Add event listener to the radio button
            $('#cash_delivery').change(function() {
                placeOrderBtn.prop('disabled', true);

                // Toggle visibility of OTP-related elements based on the selection
                if ($(this).prop('checked')) {
                    otpContainer.show();
                    otpInputContainer.show(); // Show OTP input on successful response
                    otpInputContainer.hide(); // Hide OTP input initially
                } else {
                    otpContainer.hide();
                    otpInputContainer.hide();
                }
            });

            // Add event listener to the "Get OTP" button
            getOtpBtn.click(function() {
                var phone = $('#mobileInput').val();

                console.log('Sending AJAX request for OTP...');

                $.ajax({
                    url: '{{ url("otp_for_cod/") }}',
                    method: 'get',
                    dataType: 'json', // Specify the expected data type
                    data:{
                        phone : phone
                    },
                    contentType: 'application/json', // Specify the content type
                    success: function(response) {
                        console.log('AJAX success:', response);

                        if (response.code == 200) {
                            $('#otpInputContainer').show();
                        } else {
                            alert('Failed to send OTP. Please try again.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        alert('Error sending OTP. Please try again.');
                    }
                });
            });

            // Add event listener to the "Verify OTP" button
            verifyOtpBtn.click(function() {
                // Perform AJAX to verify OTP (replace with your actual URL and data)
                $.ajax({
                    url: '{{url("verify-codotp")}}',
                    method: 'POST',
                    data: {
                        otp: $('#otpInput').val() ,// Include the entered OTP
                        phone: $('#mobileInput').val() // Include the entered OTP
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.code == 200) {
                            alert('OTP Verified!');
                            placeOrderBtn.prop('disabled', false); // Enable Place Order button
                        } else {
                            alert('OTP verification failed. Please try again.');
                        }
                    },
                    error: function() {
                        alert('Error verifying OTP. Please try again.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#ship_address_checkbox').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#popup_address').show();
                } else {
                    $('#popup_address').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $('#different_address').css('display', 'block');

            $('#same_billing').on('change', function () {
                if (this.checked) {
                    // alert('yes');
                    // If the checkbox is checked, hide 'different_address' and show 'same_address'
                    // $('#different_address').css('display', 'none');
                    //  $('#same_address').css('display', 'block');
                    $('#shipping_first_name').val($('#billing_first_name').val());
                    $('#shipping_last_name').val($('#billing_last_name').val());
                    $('#shipping_city').val($('#billing_city').val());
                    $('#shipping_state').val($('#billing_state').val());
                    $('#shipping_street').val($('#billing_street').val());
                    $('#shipping_street2').val($('#billing_street2').val());
                    $('#shipping_country').val($('#billing_country').val());
                    $('#shipping_zip').val($('#billing_zip').val());
                    $('#shipping_email').val($('#billing_email').val());
                    $('#shipping_phone').val($('#billing_phone').val());


                }
                if($("#same_billing").prop('checked') == false){
                    //alert('no');
                    // If the checkbox is unchecked, hide 'same_address' and show 'different_address'
                    //$('#same_address').css('display', 'none');
                    // $('#different_address').css('display', 'block');
                    // $('#shipping_first_name').val(""));
                    $('#shipping_first_name').val(null);
                    $('#shipping_last_name').val(null);
                    $('#shipping_city').val(null);
                    $('#shipping_state').val(null);
                    $('#shipping_street').val(null);
                    $('#shipping_street2').val(null);
                    $('#shipping_country').val(null);
                    $('#shipping_zip').val(null);
                    $('#shipping_email').val(null);
                    $('#shipping_phone').val(null);


                }
            });
        });

    </script>

    <!--Coupon Apply-->
    <script>
        $(document).ready(function() {
            const applyCouponBtn = $('#applyCouponBtn');
            const couponCodeInput = $('#couponCode');

            applyCouponBtn.click(function(event) {
                event.preventDefault();
                const couponCode = couponCodeInput.val();

                // Make an AJAX request to apply the coupon code
                $.ajax({
                    url: '{{ route('cart.apply_coupon') }}',
                    type: 'POST',
                    data: { coupon_code: couponCode },
                    dataType: 'json',
                    success: function(response) {

                        // Update the cart total with the discounted total
                        const summaryTotal = $('.summary-total td:last-child');
                        summaryTotal.text('Rs. ' + response.discounted_total.toFixed(2));
                        $('.total_price').html('Rs. ' + response.discounted_total.toFixed(2));
                        $('#final_amount_input').val(response.discounted_total.toFixed(2));
                        $('#coupon_code_input').val(response.discounted_total.toFixed(2));
                        // $('#body-id').load('#body-id');
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });
        });

    </script>
@stop




{{--@extends('layouts.web')--}}
{{--<?php--}}
{{--session_start();--}}
{{--?>--}}
{{--@section('css')--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}" />--}}
{{--    <style>--}}
{{--        .input-group {--}}
{{--            padding: 0;--}}
{{--            justify-content: center;--}}
{{--        }--}}
{{--        .cart-bottom{--}}
{{--            display:block;--}}
{{--        }--}}
{{--        form {--}}
{{--            width: 100%;--}}
{{--        }--}}
{{--        .form-control {--}}
{{--            height: 40px;--}}
{{--            padding: 0.85rem 1rem;--}}
{{--        }--}}
{{--        .table th {--}}
{{--            font-weight: 400;--}}
{{--            font-size: 1.4rem;--}}
{{--            line-height: 1.5;--}}
{{--            color: #000;--}}
{{--        }--}}
{{--        .page-header h1 {--}}
{{--            color: #fff;--}}
{{--            background: #173054ab;--}}
{{--            padding: 1em 0 !important;--}}
{{--        }--}}
{{--        .fav_hr {--}}
{{--            margin-top: -0.6rem;--}}
{{--            width: 12%;--}}
{{--            border: 1px solid;--}}
{{--        }--}}
{{--        .heading {--}}
{{--            margin: 1.1rem 0 0;--}}
{{--        }--}}
{{--        .title{--}}
{{--            font-size: 2rem;--}}
{{--        }--}}
{{--        .breadcrumb {--}}
{{--            background-color: transparent;--}}
{{--            border-radius: 0;--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            position: absolute;--}}
{{--            border: 0;--}}
{{--            padding: 30px 0;--}}
{{--        }--}}

{{--        .heading .title {--}}
{{--            font-size: 2.4rem;--}}
{{--            letter-spacing: -.025em;--}}
{{--        }--}}
{{--        select#couponCode {--}}
{{--            width: 100% !important;--}}
{{--        }--}}
{{--		  a.backBtn {--}}
{{--                        border: 1px solid !important;--}}
{{--                        padding: 5px 4em !important;--}}
{{--                    }--}}
{{--					a.backBtn:hover {--}}
{{--                        border: 1px solid !important;--}}
{{--                        padding: 5px 4em !important;--}}
{{--						background-color:#225777;--}}
{{--						color:#ffffff;--}}
{{--                    }--}}
{{--    </style>--}}
{{--@stop--}}
{{--@section('body')--}}
{{--    <?php--}}
{{--    $get_cart = get_cart();--}}
{{--    $get_count = json_decode($get_cart);--}}
{{--    $prodTotal = $get_count->cartTotal;--}}
{{--    $getAllCart = getCartProducts();--}}
{{--    ?>--}}
{{--    <main class="main">--}}

{{--        <div class="heading heading-center mb-3">--}}
{{--            <h2 class="title mb-1">CHECKOUT</h2>--}}
{{--            <hr class="fav_hr">--}}

{{--        </div>--}}
{{--        <!-- End .page-header -->--}}
{{--       <nav aria-label="breadcrumb" class="breadcrumb-nav">--}}
{{--            <div class="container">--}}



{{--               <div class="row">--}}
{{--     <div class="col-md-12" style="z-index:100;height:20px;">--}}
{{--                        <ol class="breadcrumb">--}}
{{--                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
{{--                            <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>--}}
{{--                            <li class="breadcrumb-item"><a href="{{url('/checkout')}}">checkout</a></li>--}}
{{--                        </ol>--}}
{{--                    </div></div>--}}
{{--                        <div class="row">--}}
{{--                     <div class="col-md-2 col-sm-2 col-2 text-left"><br><br>--}}
{{--						<a href="{{ url('checkout/cart') }}" class="backBtn" >Back</a>--}}
{{--        </div>--}}

{{--            <div class="col-md-10 text-right" id="righttext">--}}
{{--                <p class="text-dark">Free shipping on orders above $75</p>--}}
{{--                <p class="text-dark">All orders placed after 1PM will be processed on the next business day for shipping</p>--}}
{{--            </div>--}}

{{--    </div>--}}
{{--</div>--}}

{{--                  <style>--}}
{{--                    .breadcrumb-nav .container, .breadcrumb-nav .container-fluid {--}}
{{--                        padding-top: 1.4rem;--}}
{{--                        padding-bottom: 0.4rem;--}}
{{--                    }--}}
{{--                    a.backBtn {--}}
{{--                        border: 1px solid !important;--}}
{{--                        padding: 4px 4em !important;--}}
{{--                    }--}}
{{--                </style>--}}


{{--        </nav>--}}
{{--        <!-- End .breadcrumb-nav -->--}}
{{--        <div class="page-content">--}}


{{--            <div class="cart">--}}

{{--                <div class="container">--}}

{{--                    <div class="row">--}}
{{--                        @if(Session::has('error'))--}}
{{--                            <div class="alert alert-danger text-center">--}}
{{--                                {{Session::get('error')}}--}}
{{--                            </div>--}}
{{--                        @endif--}}


{{--                        <form action="{{ route('checkout.submit') }}" method="post" >--}}
{{--                            @csrf--}}

{{--                            <div class="row form-fields">--}}
{{--                                <div class="col-lg-9">--}}

{{--                                    <div id="billing-address-container">--}}
{{--                                        <!-- Billing Address Form -->--}}
{{--                                        <!-- ... your billing address form code ... -->--}}

{{--                                        <label>--}}
{{--                                            <input type="checkbox" id="same_billing" name="same_billing_details"--}}
{{--                                                   value="1" />--}}
{{--                                            Same as shipping address--}}
{{--                                        </label>--}}


{{--                                    </div>--}}

{{--                                    <br>--}}

{{--                                    @if($sameBilling == 1)--}}

{{--                                        <div id="different_address" class="billing_address">--}}
{{--                                            <input type="hidden" name="same_billing" value="1" />--}}
{{--                                            <div class="billing_details">--}}
{{--                                                <h2 class="checkout-title">Billing Details</h2>--}}
{{--                                                <!-- End .checkout-title -->--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>First Name *</label>--}}
{{--                                                        <input type="text" class="form-control"--}}
{{--                                                               name="billing_first_name" id="shipping_first_name" required >--}}
{{--                                                    </div>--}}
{{--                                                    <!-- End .col-sm-6 -->--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>Last Name *</label>--}}
{{--                                                        <input type="text" class="form-control"--}}
{{--                                                               name="billing_last_name" id="shipping_last_name" required>--}}
{{--                                                    </div>--}}
{{--                                                    <!-- End .col-sm-6 -->--}}
{{--                                                </div>--}}

{{--                                                <div class="row">--}}
{{--                                                    <div class="col-sm-12">--}}
{{--                                                        <label>Country *</label>--}}
{{--                                                        <input type="text" class="form-control"  id="shipping_country" name="billing_country"--}}
{{--                                                               value="USA" required>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

{{--                                                <div class="row">--}}

{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>Street address *</label>--}}
{{--                                                        <input name="billing_address_1" type="text" class="form-control"--}}
{{--                                                               placeholder="House number and Street name"--}}
{{--                                                               required id="shipping_street"--}}
{{--                                                        >--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>Street address *</label>--}}
{{--                                                        <input name="billing_address_2" type="text" class="form-control"--}}
{{--                                                               placeholder="Appartments, suite, unit etc ..." id="shipping_street2"--}}

{{--                                                        >--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>Town / City *</label>--}}
{{--                                                        <input name="billing_city" type="text" class="form-control"--}}
{{--                                                               required id="shipping_city">--}}
{{--                                                    </div>--}}
{{--                                                    <!-- End .col-sm-6 -->--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>State / County *</label>--}}
{{--                                                        <select name="billing_state" id="shipping_state" class="form-control" required>--}}
{{--                                                            <option value="AL">Alabama</option>--}}
{{--                                                            <option value="AK">Alaska</option>--}}
{{--                                                            <option value="AZ">Arizona</option>--}}
{{--                                                            <option value="AR">Arkansas</option>--}}
{{--                                                            <option value="CA">California</option>--}}
{{--                                                            <option value="CO">Colorado</option>--}}
{{--                                                            <option value="CT">Connecticut</option>--}}
{{--                                                            <option value="DE">Delaware</option>--}}
{{--                                                            <option value="FL">Florida</option>--}}
{{--                                                            <option value="GA">Georgia</option>--}}
{{--                                                            <option value="HI">Hawaii</option>--}}
{{--                                                            <option value="ID">Idaho</option>--}}
{{--                                                            <option value="IL">Illinois</option>--}}
{{--                                                            <option value="IN">Indiana</option>--}}
{{--                                                            <option value="IA">Iowa</option>--}}
{{--                                                            <option value="KS">Kansas</option>--}}
{{--                                                            <option value="KY">Kentucky</option>--}}
{{--                                                            <option value="LA">Louisiana</option>--}}
{{--                                                            <option value="ME">Maine</option>--}}
{{--                                                            <option value="MD">Maryland</option>--}}
{{--                                                            <option value="MA">Massachusetts</option>--}}
{{--                                                            <option value="MI">Michigan</option>--}}
{{--                                                            <option value="MN">Minnesota</option>--}}
{{--                                                            <option value="MS">Mississippi</option>--}}
{{--                                                            <option value="MO">Missouri</option>--}}
{{--                                                            <option value="MT">Montana</option>--}}
{{--                                                            <option value="NE">Nebraska</option>--}}
{{--                                                            <option value="NV">Nevada</option>--}}
{{--                                                            <option value="NH">New Hampshire</option>--}}
{{--                                                            <option value="NJ">New Jersey</option>--}}
{{--                                                            <option value="NM">New Mexico</option>--}}
{{--                                                            <option value="NY">New York</option>--}}
{{--                                                            <option value="NC">North Carolina</option>--}}
{{--                                                            <option value="ND">North Dakota</option>--}}
{{--                                                            <option value="OH">Ohio</option>--}}
{{--                                                            <option value="OK">Oklahoma</option>--}}
{{--                                                            <option value="OR">Oregon</option>--}}
{{--                                                            <option value="PA">Pennsylvania</option>--}}
{{--                                                            <option value="RI">Rhode Island</option>--}}
{{--                                                            <option value="SC">South Carolina</option>--}}
{{--                                                            <option value="SD">South Dakota</option>--}}
{{--                                                            <option value="TN">Tennessee</option>--}}
{{--                                                            <option value="TX">Texas</option>--}}
{{--                                                            <option value="UT">Utah</option>--}}
{{--                                                            <option value="VT">Vermont</option>--}}
{{--                                                            <option value="VA">Virginia</option>--}}
{{--                                                            <option value="WA">Washington</option>--}}
{{--                                                            <option value="WV">West Virginia</option>--}}
{{--                                                            <option value="WI">Wisconsin</option>--}}
{{--                                                            <option value="WY">Wyoming</option>--}}
{{--                                                        </select>--}}

{{--                                                    </div>--}}
{{--                                                    <!-- End .col-sm-6 -->--}}
{{--                                                </div>--}}
{{--                                                <!-- End .row -->--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>Postcode / ZIP *</label>--}}
{{--                                                        <input name="billing_pincode" type="text" id="shipping_zip" class="form-control"--}}
{{--                                                               required>--}}
{{--                                                    </div>--}}
{{--                                                    <!-- End .col-sm-6 -->--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <label>Phone *</label>--}}
{{--                                                        <input name="billing_phone" type="tel" id="shipping_phone" class="form-control"--}}
{{--                                                               required>--}}
{{--                                                    </div>--}}
{{--                                                    <!-- End .col-sm-6 -->--}}
{{--                                                </div>--}}
{{--                                                <!-- End .row -->--}}
{{--                                                <label>Email address *</label>--}}
{{--                                                <input name="billing_email" type="email" id="shipping_email" class="form-control"--}}
{{--                                                       required>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @else--}}

{{--                                        <div class="same_address">--}}

{{--                                        <input type="hidden" name="same_billing" value="0" required>--}}
{{--                                        <div class="billing_details" style="display:none;">--}}
{{--                                            <h2 class="checkout-title">Shipping Details</h2>--}}
{{--                                            <!-- End .checkout-title -->--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>First Name *</label>--}}
{{--                                                    <input type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->first_name ?? '}}"--}}
{{--                                                           name="billing_first_name" id="billing_first_name" required >--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Last Name *</label>--}}
{{--                                                    <input type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->last_name ?? '}}"--}}
{{--                                                           name="billing_last_name" id="billing_last_name" required>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-12">--}}
{{--                                                    <label>Country *</label>--}}
{{--                                                    <input type="text" class="form-control" id="billing_country" name="billing_country"--}}
{{--                                                           value="{{$user_address->country ?? '}}"--}}
{{--                                                           value="USA" required>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}

{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Street address *</label>--}}
{{--                                                    <input name="billing_address_1" type="text" class="form-control"--}}
{{--                                                           placeholder="House number and Street name" id="billing_street"--}}
{{--                                                           value="{{$user_address->address_1 ?? '}}"--}}
{{--                                                           required--}}
{{--                                                    >--}}
{{--                                                </div>--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Street address *</label>--}}
{{--                                                    <input name="billing_address_2" type="text" class="form-control"--}}
{{--                                                           placeholder="Appartments, suite, unit etc ..." id="billing_street2"--}}
{{--                                                           value="{{$user_address->address_2 ?? '}}"--}}

{{--                                                    >--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Town / City *</label>--}}
{{--                                                    <input name="billing_city" type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->city ?? '}}" id="billing_city"--}}
{{--                                                           required>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>State / County *</label>--}}
{{--                                                    <input name="billing_state" type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->billing_state}}"--}}
{{--                                                           required>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>State / County *</label>--}}
{{--                                                    <input name="state" type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->state ?? '}}" id="billing_state"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                            </div>--}}
{{--                                            <!-- End .row -->--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Postcode / ZIP *</label>--}}
{{--                                                    <input name="billing_pincode" type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->pincode ?? '}}" id="billing_zip"--}}
{{--                                                           required>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Phone *</label>--}}
{{--                                                    <input name="billing_phone" type="tel" class="form-control"--}}
{{--                                                           value="{{$user_address->phone ?? '}}" id="billing_phone"--}}
{{--                                                           required>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                            </div>--}}
{{--                                            <!-- End .row -->--}}
{{--                                            <label>Email address *</label>--}}
{{--                                            <input name="billing_email" type="email" class="form-control"--}}
{{--                                                   value="{{$user_address->email ?? '}}" id="billing_email"--}}
{{--                                                   required>--}}

{{--                                        </div>--}}




{{--                                        <div class="shipping_details" style="display:none;">--}}
{{--                                            <h2 class="checkout-title">Shipping Details</h2>--}}

{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>First Name *</label>--}}
{{--                                                    <input type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->first_name ?? '}}"--}}
{{--                                                           name="first_name" readonly>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Last Name *</label>--}}
{{--                                                    <input type="text" class="form-control" name="last_name"--}}
{{--                                                           value="{{$user_address->last_name ?? '}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-12">--}}
{{--                                                    <label>Country *</label>--}}
{{--                                                    <input type="text" class="form-control" name="country"--}}
{{--                                                           value="{{$user_address->country ?? '}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}

{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Street address *</label>--}}
{{--                                                    <input name="address_1" type="text" class="form-control"--}}
{{--                                                           placeholder="House number and Street name"--}}
{{--                                                           value="{{$user_address->address_1 ?? '}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Street address *</label>--}}
{{--                                                    <input name="address_2" type="text" class="form-control"--}}
{{--                                                           placeholder="Appartments, suite, unit etc ..."--}}
{{--                                                           value="{{$user_address->address_2 ?? '}}"--}}
{{--                                                           readonly--}}
{{--                                                    >--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Town / City *</label>--}}
{{--                                                    <input name="city" type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->city ?? '}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>State / County *</label>--}}
{{--                                                    <input name="state" type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->state ?? '}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Postcode / ZIP *</label>--}}
{{--                                                    <input name="pincode" type="text" class="form-control"--}}
{{--                                                           value="{{$user_address->pincode ?? '}}"--}}
{{--                                                           id="zipcode"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Phone *</label>--}}
{{--                                                    <input name="phone" type="tel" class="form-control"--}}
{{--                                                           value="{{$user_address->phone ?? '}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                <!-- End .col-sm-6 -->--}}
{{--                                            </div>--}}

{{--                                            <label>Email address *</label>--}}
{{--                                            <input name="email" type="email" class="form-control"--}}
{{--                                                   value="{{$user_address->email ?? '}}"--}}
{{--                                                   readonly>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    @endif--}}

{{--                                </div>--}}

{{--                                <?php--}}
{{--                                $get_cart = get_cart();--}}
{{--                                $get_count = json_decode($get_cart);--}}
{{--                                $getAllCart = getCartProducts();--}}

{{--//                                print_r($get_count->cartTotal);--}}
{{--                                ?>--}}
{{--                                <aside class="col-lg-3">--}}
{{--                                    <div class="summary summary-cart">--}}
{{--                                        <div class="cart-bottom">--}}
{{--                                                @if($get_count->cartTotal > 15)--}}
{{--                                            <div class="cart-discount">--}}
{{--                                                @if(Session::has('discounted_total'))--}}
{{--                                                    Coupon Applied : {{Session::get('applied_coupon')}}--}}
{{--                                                    <br>--}}
{{--                                                    <span style="font-size:12px; color:red;">--}}
{{--                                                    <a href="{{url('remove-coupon')}}">Remove Coupon</a>--}}
{{--                                                </span>--}}

{{--                                                @endif--}}

{{--                                                <form id="applyCouponForm" action="#">--}}
{{--                                                    <div class="input-group">--}}
{{--                                                        @php--}}
{{--                                                            $coupons = \App\Models\Offer::where('status','1')->get();--}}
{{--                                                        @endphp--}}
{{--                                                        <select id="couponCode" class="form-control">--}}
{{--                                                            <option>Select Coupon</option>--}}
{{--                                                            @forelse($coupons as $key => $coupon)--}}
{{--                                                                <option value="{{$coupon->code}}">{{$coupon->code}} </option>--}}
{{--                                                            @empty--}}
{{--                                                            @endforelse--}}
{{--                                                        </select>--}}

{{--                                                        <div class="input-group-append">--}}
{{--                                                            <button class="btn btn-outline-primary-2"--}}
{{--                                                                    type="button" id="applyCouponBtn"><i class="icon-long-arrow-right"></i></button>--}}
{{--                                                        </div><!-- .End .input-group-append -->--}}
{{--                                                    </div><!-- End .input-group -->--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                        <h3 class="summary-title">Cart Total</h3>--}}

{{--                                        <table class="table table-summary">--}}
{{--                                            <tbody>--}}
{{--                                            @php--}}
{{--                                                $sumLength = 0;--}}
{{--                                                $sumWidth = 0;--}}
{{--                                                $sumHeight = 0;--}}
{{--                                            @endphp--}}
{{--                                            @forelse($getAllCart as $key => $getAllCarts)--}}
{{--                                                <tr style="display: none;">--}}
{{--                                                    <td><a href="{{url('products/'.$getAllCarts->getProducts->slug ?? '')}}">--}}
{{--                                                            {{$getAllCarts->getProducts->title ?? ''}}</a></td>--}}
{{--                                                    <td>--}}
{{--                                                       <span class="cart-product-info">--}}
{{--                                                       <span class="cart-product-qty">{{$getAllCarts->cartqty}}--}}
{{--                                                       </span>x ${{$getAllCarts->price}}--}}
{{--                                                       </span><!--End .cart-product-info-->--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}

{{--                                                <input type="hidden" name="product_name[]" value="{{$getAllCarts->getProducts->title}}"/>--}}
{{--                                                <input type="hidden" name="product_id[]" value="{{$getAllCarts->getProducts->id}}"/>--}}
{{--                                                <input type="hidden" name="attribute_id[]" value="{{$getAllCarts->attribute_id}}"/>--}}
{{--                                                <input type="hidden" name="qty[]" value="{{$getAllCarts->cartqty}}"/>--}}
{{--                                                <input type="hidden" name="price[]" value="{{$getAllCarts->price}}"/>--}}
{{--                                                <input type="hidden" name="size[]" value="{{$getAllCarts->size}}"/>--}}
{{--                                                <input type="hidden" name="height[]" value="{{$getAllCarts->height}}"/>--}}
{{--                                                <input type="hidden" name="width[]" value="{{$getAllCarts->width}}"/>--}}
{{--                                                <input type="hidden" name="length[]" value="{{$getAllCarts->length}}"/>--}}
{{--                                                @php--}}
{{--                                                    $get_dimension = \App\Models\Product_size::find($getAllCarts->attribute_id);--}}
{{--                                                    $sumLength += $get_dimension->length;--}}
{{--                                                    $sumWidth += $get_dimension->width;--}}
{{--                                                    $sumHeight += $get_dimension->height;--}}
{{--                                                @endphp--}}
{{--                                            @empty--}}
{{--                                            @endforelse--}}

{{--                                            <tr>--}}
{{--                                                <td>Subtotal</td>--}}
{{--                                                <td>--}}
{{--                                                    $ {{$prodTotal}}--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <!-- Include the sum in a hidden input field -->--}}
{{--                                            <input type="hidden" class="sLength" name="sum_length[]" value="{{ $sumLength }}"/>--}}
{{--                                            <input type="hidden" class="sWidth"  name="sum_width[]" value="{{ $sumWidth }}"/>--}}
{{--                                            <input type="hidden" class="sHeight" name="sum_height[]" value="{{ $sumHeight }}"/>--}}
{{--                                            <tr>--}}
{{--                                                <td> Tax</td>--}}
{{--                                                <td><div class="salesTaxDiv"></div></td>--}}
{{--                                            </tr>--}}
{{--                                            @if(Session::has('discounted_total'))--}}
{{--                                                    <?php $productTotal = Session::get('discounted_total'); ?>--}}
{{--                                                <input type="hidden" name="product_total" id="total-amount" value="{{$productTotal}}"/>--}}
{{--                                                <input type="hidden" name="coupon_code" value="{{Session::get('applied_coupon')}}"/>--}}
{{--                                            @else--}}
{{--                                                    <?php $productTotal = $get_count->cartTotal; ?>--}}

{{--                                                <input type="hidden" name="product_total" id="total-amount" value="{{$productTotal}}"/>--}}
{{--                                            @endif--}}
{{--                                            @if(Session::has('discounted_total'))--}}
{{--                                                <tr class="summary-subtotal">--}}
{{--                                                    <td>Coupon Applied</td>--}}
{{--                                                    <td>{{Session::get('applied_coupon')}}</td>--}}
{{--                                                </tr><!-- End .summary-subtotal -->--}}
{{--                                            @endif--}}
{{--                                            <tr class="">--}}
{{--                                                <td> Sub total:</td>--}}
{{--                                                <td>--}}
{{--                                                    @if(Session::has('discounted_total'))--}}
{{--                                                        $ {{number_format(Session::get('discounted_total'),2) ?? '0'}}--}}
{{--                                                    @else--}}
{{--                                                       $ {{number_format($get_count->cartTotal,2) ?? '0'}}--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                @if($get_count->cartTotal < 75)--}}
{{--                                                <td>Delivery</td>--}}
{{--                                                <td>--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <select class="form-control"--}}
{{--                                                                required id="courier-select" name="selected_courier">--}}
{{--                                                            <option value="0.00"> Select Shipping</option>--}}
{{--                                                            <option value="7.99" data-name="Standard U.S Shipping (4-7 business days)">--}}
{{--                                                                Standard U.S Shipping (4-7 business days): $7.99</option>--}}
{{--                                                            <option value="15.99" data-name="Priority U.S Shipping (2-3 business days)">--}}
{{--                                                                Priority U.S Shipping (2-3 business days): $15.99</option>--}}
{{--                                                        F    <option value="19.99" data-name="1-Business day Shipping">--}}
{{--                                                                1-Business day Shipping: $19.99</option>--}}
{{--                                                        </select>--}}
{{--                                                    </div>--}}
{{--                                                </td>--}}
{{--                                                @else--}}
{{--                                                <td><b class="text-success">Congratulations!</b> You are eligible for free delivery.</td>--}}
{{--                                                <td style="width:100%">--}}
{{--                                                    <div class="form-group"style="display: unset;">--}}
{{--                                                        <label style="display: inline;text-align: left;" for="courier-select">Click to Claim</label>--}}
{{--                                                        <input type="checkbox" name="selected_courier" id="courier-select" value="0.00" required>--}}
{{--                                                    </div>--}}
{{--                                                </td>--}}
{{--                                                @endif--}}
{{--                                            </tr>--}}

{{--                                            <tr class="" colspan="1">--}}
{{--                                                <td>Shipping</td>--}}
{{--                                                <td><span id="selected_del">$0.00</span></td>--}}

{{--                                            </tr>--}}



{{--                                            <input type="hidden" class="form-control" id="sales-tax" name="sales_tax" readonly>--}}
{{--                                            <input type="hidden" class="form-control" id="shipping-price" name="shipping_price" readonly>--}}
{{--                                            <input type="hidden" class="form-control" id="final-amount" name="final_amount" readonly>--}}
{{--                                            <input type="hidden" class="form-control" id="courier-name" name="courier_nmae" readonly>--}}

{{--                                            <tr  class="summary-subtotal">--}}
{{--                                                <td>Total</td>--}}
{{--                                                <td><div class="finalTaxDiv"></div></td>--}}
{{--                                            </tr>--}}
{{--											<tr  class="issubmit">--}}
{{--                                                <td colspan="2">Select Delivery Method to proceed</td>--}}

{{--                                            </tr>--}}

{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                        <button type="submit" id="finalpay" class="btn btn-order btn-block pb-2 pt-2--}}
{{--                                   btn-outline-primary-2">PAY</button>--}}
{{--                                    </div><!-- End .summary -->--}}
{{--                                </aside>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                    <!-- End .row -->--}}
{{--                </div>--}}
{{--                <!-- End .container -->--}}
{{--            </div>--}}
{{--            <!-- End .cart -->--}}
{{--        </div>--}}
{{--        <!-- End .page-content -->--}}
{{--    </main>--}}
{{--@stop--}}
{{--@section('js')--}}
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>--}}


{{--    @if(Session::has('error'))--}}
{{--        <script>--}}
{{--            swal("Address not found");--}}
{{--            // location.reload();--}}
{{--            // console.log(data.success)--}}
{{--        </script>--}}
{{--    @endif--}}
{{--    --}}{{--    <script>--}}
{{--    --}}{{--        $(document).ready(function() {--}}
{{--    --}}{{--            // Attach a keyup event handler to the pin code input field--}}
{{--    --}}{{--            $('#pincode-input').on('keyup', function() {--}}
{{--    --}}{{--                const pincode = $(this).val();--}}

{{--    --}}{{--                // Check if the entered pin code has at least 5 characters--}}
{{--    --}}{{--                if (pincode.length >= 5) {--}}
{{--    --}}{{--                    // Call the fetchShippingServices function to fetch shipping services and update the displayed information--}}
{{--    --}}{{--                    fetchShippingOptions($(this).val());--}}
{{--    --}}{{--                }--}}
{{--    --}}{{--            });--}}
{{--    --}}{{--        });--}}
{{--    --}}{{--    </script>--}}

{{--    <script>--}}

{{--        $(document).ready(function () {--}}


{{--$("#finalpay").hide();--}}


{{--            $('#different_address').css('display', 'block');--}}

{{--           $('#same_billing').on('change', function () {--}}
{{--                if (this.checked) {--}}
{{--					// alert('yes');--}}
{{--                    // If the checkbox is checked, hide 'different_address' and show 'same_address'--}}
{{--                   // $('#different_address').css('display', 'none');--}}
{{--				   //  $('#same_address').css('display', 'block');--}}
{{--				   $('#shipping_first_name').val($('#billing_first_name').val());--}}
{{--				   $('#shipping_last_name').val($('#billing_last_name').val());--}}
{{--				   $('#shipping_city').val($('#billing_city').val());--}}
{{--				   $('#shipping_state').val($('#billing_state').val());--}}
{{--				   $('#shipping_street').val($('#billing_street').val());--}}
{{--				   $('#shipping_street2').val($('#billing_street2').val());--}}
{{--				   $('#shipping_country').val($('#billing_country').val());--}}
{{--				   $('#shipping_zip').val($('#billing_zip').val());--}}
{{--				   $('#shipping_email').val($('#billing_email').val());--}}
{{--				   $('#shipping_phone').val($('#billing_phone').val());--}}


{{--                }--}}
{{--				if($("#same_billing").prop('checked') == false){--}}
{{--					 //alert('no');--}}
{{--                    // If the checkbox is unchecked, hide 'same_address' and show 'different_address'--}}
{{--                    //$('#same_address').css('display', 'none');--}}
{{--                   // $('#different_address').css('display', 'block');--}}
{{--				   // $('#shipping_first_name').val(""));--}}
{{--				   $('#shipping_first_name').val(null);--}}
{{--				   $('#shipping_last_name').val(null);--}}
{{--				   $('#shipping_city').val(null);--}}
{{--				    $('#shipping_state').val(null);--}}
{{--					 $('#shipping_street').val(null);--}}
{{--				   $('#shipping_street2').val(null);--}}
{{--				    $('#shipping_country').val(null);--}}
{{--				    $('#shipping_zip').val(null);--}}
{{--				    $('#shipping_email').val(null);--}}
{{--				    $('#shipping_phone').val(null);--}}


{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--        // $(document).ready(function () {--}}
{{--        //     // Get a reference to the "Same as shipping address" checkbox element using jQuery--}}
{{--        //     const sameBillingCheckbox = $('#same_billing');--}}
{{--        //--}}
{{--        //     // Add an event listener to the checkbox using jQuery--}}
{{--        //     sameBillingCheckbox.on('change', function () {--}}
{{--        //         // Check if the checkbox is checked--}}
{{--        //         if (this.checked) {--}}
{{--        //             // If checked, perform actions here--}}
{{--        //             console.log('Checkbox is checked');--}}
{{--        //             $('#same_address').css('display','block');--}}
{{--        //             $('#different_address').css('display','none');--}}
{{--        //             // You can hide the billing address form or perform any other actions--}}
{{--        //         } else {--}}
{{--        //             // If unchecked, perform actions here--}}
{{--        //             console.log('Checkbox is unchecked');--}}
{{--        //             // You can show the billing address form or perform any other actions--}}
{{--        //         }--}}
{{--        //     });--}}
{{--        // });--}}
{{--    </script>--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}


{{--            const $addressRadioButtons = $('input[name="selected_address"]');--}}
{{--            const $manualForm = $('.manual-form');--}}
{{--            const $savedAddresses = $('.saved-addresses');--}}

{{--            const $shippingOptions = $('#shipping-options');--}}
{{--            const $selectedCourier = $('#courier-select');--}}
{{--            const $shippingPriceInput = $('#shipping-price'); // Update this line--}}
{{--            const $totalAmountInput = $('#total-amount'); // Add this line--}}

{{--            const $pincodeInput = $('input[name="pincode"]');--}}
{{--            const sum_length = $('.sLength').val();--}}
{{--            const sum_width = $('.sWidth').val();--}}
{{--            const sum_height = $('.sHeight').val();--}}
{{--            const $finalAmountInput = $('#final-amount'); // Define the input field for the final amount--}}

{{--            let ratesArray = [];--}}

{{--            let salesTax = 0;--}}
{{--            const debounceDelay = 100;--}}
{{--            let shippingTimer;--}}



{{--            $(document).ready(function () {--}}
{{--                clearTimeout(shippingTimer);--}}

{{--                const zipCode = $('#zipcode').val();--}}
{{--                // alert(zipCode);--}}
{{--                // return false;--}}

{{--                // Only fetch sales tax if ZIP code is 5 or more digits--}}
{{--                if (zipCode.length >= 5) {--}}
{{--                    shippingTimer = setTimeout(function () {--}}
{{--                        fetchSalesTax(zipCode);--}}
{{--                    }, debounceDelay);--}}
{{--                }--}}
{{--            });--}}

{{--            function fetchSalesTax(zipCode) {--}}

{{--                $.ajax({--}}
{{--                    method: 'GET',--}}
{{--                    url: 'https://api.api-ninjas.com/v1/salestax?zip_code=' + zipCode,--}}
{{--                    headers: { 'X-Api-Key': '4NZW/DZKECPyubyiLhZvcg==LEgqG60lhPyYuwSn' }, // Replace with your API key--}}
{{--                    contentType: 'application/json',--}}
{{--                    success: function (result) {--}}

{{--                        var ptot = "<?php echo $productTotal = $get_count->cartTotal; ?>";--}}

{{--                        const salesTaxRate = parseFloat(result[0].total_rate);--}}
{{--                        const productTotal = parseFloat(ptot) ;--}}

{{--                        const totalAmount = productTotal + (productTotal * salesTaxRate);--}}

{{--                        // Display calculated values with $ sign in div elements--}}
{{--                        $('.salesTaxDiv').text('$' + (productTotal * salesTaxRate).toFixed(2));--}}
{{--                        $('.finalTaxDiv').text('$' + totalAmount.toFixed(2));--}}

{{--                        // Set calculated values in input fields without $ sign--}}
{{--                        $('#sales-tax').val((productTotal * salesTaxRate).toFixed(2));--}}
{{--                        $finalAmountInput.val(totalAmount.toFixed(2));--}}
{{--                    },--}}
{{--                    error: function (jqXHR) {--}}
{{--                        console.error('Error fetching sales tax:', jqXHR.responseText);--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}


{{--            // Event listener for the courier select input--}}
{{--            $selectedCourier.on('change', function () {--}}
{{--                // const selectedCourier = $(this).val();--}}
{{--                const shippingPrice = $(this).val();--}}

{{--                const salesTax = parseFloat(0);--}}

{{--                const productTotal = parseFloat($('input[name="product_total"]').val());--}}

{{--                const selectedRate = shippingPrice;--}}



{{--  const selectedCourier1 = $(this).val();--}}
{{--if(selectedCourier1==10){--}}
{{--	$("#finalpay").hide();--}}
{{--}else{--}}
{{--	$("#finalpay").show();--}}
{{--}--}}

{{--                // alert(selectedRate);--}}
{{--                // return false;--}}


{{--                if (!isNaN(productTotal)) {--}}
{{--                    if (selectedRate) {--}}


{{--                        $shippingPriceInput.val(selectedRate);--}}

{{--                        const newFinalAmount = parseFloat(salesTax) + parseFloat(productTotal) + parseFloat(selectedRate);--}}
{{--//alert(newFinalAmount );--}}
{{--                        $finalAmountInput.val(newFinalAmount.toFixed(2));--}}
{{--                        $('.finalTaxDiv').text('$' + newFinalAmount.toFixed(2));--}}

{{--                        const courierName = $selectedCourier.find(':selected').attr('data-name');--}}


{{--$(".issubmit").hide();--}}
{{--                        // alert(courierName);--}}
{{--                        // return false;--}}

{{--                        // if(selectedRate == 0){--}}
{{--                        //     const courierName = $selectedCourier.find(':selected').attr('data-name');--}}
{{--                        // }else{--}}
{{--                        //     const courierName = $selectedCourier.find(':selected').attr('data-name');--}}
{{--                        // }--}}

{{--                        $('#courier-name').val(courierName);--}}
{{--                        $('#selected_del').text('$' + selectedRate);--}}
{{--                    } else {--}}
{{--                        $shippingPriceInput.val('N/A');--}}
{{--                        $finalAmountInput.val(productTotal.toFixed(2));--}}
{{--                        $('.finalTaxDiv').text('$' + productTotal.toFixed(2));--}}
{{--                        $('#courier-name').val('N/A');--}}
{{--                    }--}}
{{--                } else {--}}
{{--                    // alert('abc');--}}
{{--                    // return false;--}}
{{--                    $finalAmountInput.val('N/A');--}}
{{--                    $('#courier-name').val('');--}}
{{--                }--}}
{{--            });--}}

{{--            // Initial call to fetch and display shipping options--}}
{{--            fetchShippingOptions($pincodeInput.val());--}}

{{--            // Initial call to calculate sales tax--}}
{{--            fetchSalesTax($pincodeInput.val());--}}
{{--        });--}}

{{--        $(document).ready(function () {--}}

{{--            const $formFields = {--}}
{{--                first_name: $('input[name="first_name"]'),--}}
{{--                last_name: $('input[name="last_name"]'),--}}
{{--                country: $('input[name="country"]'),--}}
{{--                address_1: $('input[name="address_1"]'),--}}
{{--                address_2: $('input[name="address_2"]'),--}}
{{--                city: $('input[name="city"]'),--}}
{{--                state: $('input[name="state"]'),--}}
{{--                pincode: $('input[name="pincode"]'),--}}
{{--                phone: $('input[name="phone"]'),--}}
{{--                email: $('input[name="email"]')--}}
{{--            };--}}

{{--            function showSavedAddresses() {--}}
{{--                $savedAddresses.show();--}}
{{--                $manualForm.hide();--}}
{{--            }--}}

{{--            function showManualForm() {--}}
{{--                $savedAddresses.hide();--}}
{{--                $manualForm.show();--}}
{{--            }--}}

{{--            function populateAddressFields(address) {--}}
{{--                for (const field in $formFields) {--}}
{{--                    $formFields[field].val(address[field]);--}}
{{--                }--}}
{{--            }--}}

{{--            function clearFormFields() {--}}
{{--                for (const field in $formFields) {--}}
{{--                    $formFields[field].val('');--}}
{{--                }--}}
{{--            }--}}

{{--            $addressRadioButtons.on('change', function () {--}}
{{--                const selectedAddressId = $(this).val();--}}
{{--                if (selectedAddressId !== '') {--}}
{{--                    const selectedAddress = addresses.find(address => address.id === parseInt(selectedAddressId));--}}
{{--                    populateAddressFields(selectedAddress);--}}
{{--                    fetchShippingOptions(selectedAddress.pincode);--}}
{{--                    fetchSalesTax(selectedAddress.pincode);--}}
{{--                } else {--}}
{{--                    clearFormFields();--}}
{{--                    $shippingOptions.empty();--}}
{{--                    $selectedCourier.html('');--}}
{{--                }--}}
{{--            });--}}

{{--            $pincodeInput.on('keyup', function () {--}}
{{--                fetchShippingOptions($(this).val());--}}
{{--            });--}}

{{--            $('input[name="shipping_option"]').on('change', function () {--}}
{{--                $selectedCourier.html(`Selected Courier: ${$(this).val()}`);--}}
{{--            });--}}

{{--            (isAuthenticated && addresses.length > 0) ? showSavedAddresses() : showManualForm();--}}
{{--        });--}}

{{--    </script>--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            const applyCouponBtn = $('#applyCouponBtn');--}}
{{--            const couponCodeInput = $('#couponCode');--}}

{{--            applyCouponBtn.click(function(event) {--}}
{{--                event.preventDefault();--}}
{{--                const couponCode = couponCodeInput.val();--}}

{{--                // Make an AJAX request to apply the coupon code--}}
{{--                $.ajax({--}}
{{--                    url: '{{ route('cart.apply_coupon') }}',--}}
{{--                    type: 'POST',--}}
{{--                    data: { coupon_code: couponCode },--}}
{{--                    dataType: 'json',--}}
{{--                    success: function(response) {--}}

{{--                        // Update the cart total with the discounted total--}}
{{--                        const summaryTotal = $('.summary-total td:last-child');--}}
{{--                        summaryTotal.text('$ ' + response.discounted_total.toFixed(2));--}}
{{--                        $('.final_amount').html('$ ' + response.discounted_total.toFixed(2));--}}
{{--                        $('#body-id').load('#body-id');--}}
{{--                    },--}}
{{--                    error: function(xhr) {--}}
{{--                        console.log('Error:', xhr.responseText);--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}

{{--    </script>--}}
{{--@stop--}}
