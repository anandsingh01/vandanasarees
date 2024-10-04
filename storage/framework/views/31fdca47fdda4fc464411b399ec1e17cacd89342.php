<?php
session_start();
?>
<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $prodTotal = $get_count->cartTotal;
    $getAllCart = getCartProducts();
    ?>

        <!-- breadcrumb_section - start
       ================================================== -->
    <section class="breadcrumb_section text-white text-center text-uppercase d-flex align-items-end clearfix"
             data-background="<?php echo e(asset('images/webp/74651700935498.webp')); ?>">
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

            <form action="<?php echo e(url('/payment-successsss')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="rzp_test_qhoHxWm9KDHv1C"
                data-amount="100000"
                data-currency="INR"
                data-order_id="<?php echo e($orderid); ?>"
                data-buttontext="Pay with Razorpay"
                data-name="Your Company Name"
                data-description="Purchase Description"
                data-theme.color="#F37254"
                data-redirect="true">
                </script>

                <!-- Hidden fields to include in the form submission -->
                <input type="hidden" name="order_id" value="<?php echo e($orderid); ?>">




            </form>


        </div>

        </div>
    </section>
    <!-- checkout_section - end
       ================================================== -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <?php if(Session::has('error')): ?>
        <script>
            swal("Address not found");
        </script>
    <?php endif; ?>

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
                    url: '<?php echo e(url("otp_for_cod/")); ?>',
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
                    url: '<?php echo e(url("verify-codotp")); ?>',
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
                    url: '<?php echo e(route('cart.apply_coupon')); ?>',
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
<?php $__env->stopSection(); ?>

























































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































<?php echo $__env->make('layouts.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xampp\htdocs\silkashi\resources\views/web/razorpay-payment.blade.php ENDPATH**/ ?>