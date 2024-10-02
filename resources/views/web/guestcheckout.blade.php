@extends('layouts.web')
<?php
session_start();
?>
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        .billing_form .form_wrap{padding:15px;border:2px solid #e6e6e6}.billing_form .checkbox_item{padding-left:0}#otpContainer{text-align:right;display:inline-block;width:60%}input#otpInput{width:60%;padding:15px}
        .checkout_section.sec_ptb_140.clearfix{
            margin: 4em 0;
        }
        .coupon_wrap {
            background: #FAEEC8;
            padding: 2em;
            margin: 1em 0 2em;
        }
        /*.table td{*/
        /*    width:25%;*/
        /*}*/

        /*.imagetd{*/
        /*    */
        /*}*/
        .form_item {
            padding: 10px 0px;
        }
        button#applyCouponBtn {
            margin: 10px 0;
            justify-content: center;
            align-items: center;
            display: flex;
            border-radius: 5px;
        }
        td p {
            margin: 0;
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


    <section class="checkout_section sec_ptb_140 clearfix">
        <div class="container">


            @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif

            <form action="{{url('checkout/submit')}}" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="billing_form mb_50">
                            <h3 class="form_title mb_30">Billing details</h3>

                            @csrf
                            <div class="form_wrap">
                                <div class="form_item">
                                    <span class="input_title">First Name<sup>*</sup></span>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="form_item">
                                    <span class="input_title">Last Name<sup>*</sup></span>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>

                                <div class="form_item">
                                    <span class="input_title">Address<sup>*</sup></span>
                                    <input type="text" class="form-control" name="address_1" required
                                           placeholder="House number and street name">
                                </div>
                                <div class="form_item">
                                    <span class="input_title">Town/City<sup>*</sup></span>
                                    <input type="text" class="form-control" name="city" required>
                                </div>
                                <div class="form_item">
                                    <span class="input_title">State<sup>*</sup></span>
                                    <input type="text" class="form-control" name="state" required>
                                </div>
                                <div class="form_item">
                                    <span class="input_title">Postcode / Zip<sup>*</sup></span>
                                    <input type="text" class="form-control" name="pincode"
                                           required
                                           maxlength="6"
                                           pattern="\d{6}"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '');"

                                           title="Please enter exactly 6 digits">

                                </div>
                                <div class="form_item">
                                    <span class="input_title">Phone<sup>*</sup></span>
                                    <input type="tel" class="form-control" name="phone"
                                           maxlength="10"
                                           pattern="\d{10}"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '');"
                                           id="mobileInput"
                                    >
                                </div>
                                <div class="form_item">
                                    <span class="input_title">Email Address<sup>*</sup></span>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="checkbox_item">
                                    <label for="account_create_checkbox">
                                        <input id="account_create_checkbox" value="yes" name="create_account"
                                               type="checkbox"> Create an account?</label>
                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="billing_form1">
                            <h3 class="form_title mb_30">Your order</h3>
                            <div class="coupon_wrap mb_50">
                                <div class="row justify-content-lg-between">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="coupon_form">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form_item mb-0">
                                                        <input type="text" class="coupon form-control" id="couponCode"
                                                               placeholder="Coupon Code">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <button type="submit" id="applyCouponBtn"
                                                            class="custom_btn bg_danger dark-pink py-2 ">Apply Coupon
                                                    </button>

                                                </div>
                                            </div>
                                        </div>

                                        @if(Session::has('discounted_total'))
                                            <div class="coupon_applied">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h6 style="font-size: 13px;font-weight: 800;">Coupon Applied: {{ Session::get('applied_coupon') }}</h6>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <span>
                                                            <a href="{{ url('remove-coupon') }}"
                                                               style="font-size:12px; color:red;">Remove Coupon</a>
                                                        </span>
                                                    </div>
                                                </div>


                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form_wrap">
                                <div class="checkout_table">
                                    <table class="table mb_50">
                                        <thead class="text-uppercase text-uppercase">
                                        <tr>
                                            <th>Image</th>
                                            <th> Details</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($getAllCart as $getAllCarts)
                                            <tr>
                                                <td style="width:15%;">
                                                    <img src="{{asset($getAllCarts->getProducts->photo)}}"
                                                         style="width:3.5rem;" alt="image_not_found">
                                                </td>
                                                <td style="width: 60%;">
                                                    <p class="item_title"> {{$getAllCarts->getProducts->title ?? ''}}</p>
                                                    <p>
                                                     ₹ {{number_format($getAllCarts->per_piece_price,2)}} * {{$getAllCarts->cartqty}}

                                                    </p>
                                                </td>

                                                <td style="width: 40%;"><span class="total_price{{$getAllCarts->id}}"
                                                          id="total_price{{$getAllCarts->id}}">
                                                        ₹ {{number_format($getAllCarts->subtotal,2)}}</span></td>
                                            </tr>
                                            <input type="hidden" name="product_name[]"
                                                   value="{{$getAllCarts->getProducts->title}}"/>

                                            <input type="hidden" name="product_id[]"
                                                   value="{{$getAllCarts->getProducts->id}}"/>
                                            {{-- <input type="hidden" name="attribute_id[]" value="{{$getAllCarts->attribute_id}}"/>--}}
                                            <input type="hidden" name="qty[]" value="{{$getAllCarts->cartqty}}"/>
                                            <input type="hidden" name="price[]" value="{{$getAllCarts->price}}"/>
                                            <input type="hidden" name="per_piece_price[]"
                                                   value="{{$getAllCarts->per_piece_price}}"/>

                                        @empty
                                        @endforelse


                                        <tr>

                                            <td>
                                                <span class="subtotal_text">Subtotal</span>
                                            </td>
{{--                                            <td></td>--}}
                                            <td></td>
{{--                                            <td></td>--}}
                                            <td style="width: 100%;"><span class="total_price">₹ {{number_format($getsubtotal,2)}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                <span class="subtotal_text">Total</span>
                                            </td>
{{--                                            <td></td>--}}
                                            <td></td>
                                            <td >
                                                <span class="total_price">
                                                    @if(Session::has('discounted_total'))

                                                        <strike class="text-danger">₹ {{number_format($get_count->cartTotal,2) ?? '0'}}</strike>

                                                        <p class="final_amount d-inline-flex">
                                                            <span class="finalamountspan" style="font-size:17px; margin-right: 10px;">
                                                                ₹ {{Session::get('discounted_total').'.00' ?? '0'}}
                                                            </span>
                                                            </p>

                                                    @else
                                                        ₹ {{number_format($get_count->cartTotal,2) ?? '0'}}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" name="subtotal" value="{{$getsubtotal}}"/>
                                <input type="hidden" name="final_amount" id="final_amount_input"
                                       value="{{$getsubtotal}}"/>
                                <input type="hidden" name="coupon_code" id="coupon_code_input" value=""/>


                                <div class="billing_payment_mathod">
                                    <style>
                                        .ul_li_block{
                                            list-style: none;
                                            margin: 0;
                                            padding: 0 !important;
                                        }
                                    </style>
                                    <ul class="ul_li_block clearfix">
                                        <li>
                                            <div class="checkbox_item mb-0 pl-0">
                                                <label for="cash_delivery">
                                                    <input id="cash_delivery" name="payment_mode" value="cod"
                                                           type="radio"> Cash On Delivery</label>
                                                <!-- Button to trigger OTP -->
                                                <!-- Container for OTP-related elements -->
                                                <div id="otpContainer" style="display: none;">
                                                    <a id="getOtpBtn">Get OTP</a>


                                                </div>
                                                <!-- OTP input field and verification button -->
                                                <div id="otpInputContainer" style="display: none;">
                                                    <input type="text" id="otpInput" placeholder="Enter OTP">
                                                    <a id="verifyOtpBtn">Verify OTP</a>
                                                </div>
                                            </div>


                                        </li>
                                        <li>
                                            <div class="checkbox_item mb-0 pl-0">

                                                <label for="cash_delivery">
                                                    <input id="cash_delivery2" name="payment_mode" value="online"
                                                           type="radio" checked> Pay Online </label>
                                            </div>

                                        </li>
                                    </ul>

                                    <button type="submit" class="custom_btn bg_default_red dark-pink py-2 my-3" id="placeOrderBtn">PLACE
                                        ORDER
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>


    </section>
    <!-- checkout_section - end
       ================================================== -->

@stop
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>


    {{--    @if(Session::has('error'))--}}
    {{--        <script>--}}
    {{--            swal("Address not found");--}}
    {{--            // location.reload();--}}
    {{--            // console.log(data.success)--}}
    {{--        </script>--}}
    {{--    @endif--}}


    <script>
        $(document).ready(function () {
            // Get references to the elements
            var otpContainer = $('#otpContainer');
            var otpInputContainer = $('#otpInputContainer');
            var getOtpBtn = $('#getOtpBtn');
            var verifyOtpBtn = $('#verifyOtpBtn');
            var placeOrderBtn = $('#placeOrderBtn');

            $('#cash_delivery2').change(function () {
                placeOrderBtn.prop('disabled', false);
                otpContainer.hide();
                otpInputContainer.hide();
            });

            // Add event listener to the radio button
            $('#cash_delivery').change(function () {
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
            getOtpBtn.click(function () {
                var phone = $('#mobileInput').val();

                console.log('Sending AJAX request for OTP...');

                $.ajax({
                    url: '{{ url("otp_for_cod/") }}',
                    method: 'get',
                    dataType: 'json', // Specify the expected data type
                    data: {
                        phone: phone
                    },
                    contentType: 'application/json', // Specify the content type
                    success: function (response) {
                        console.log('AJAX success:', response);

                        if (response.code == 200) {
                            $('#otpInputContainer').show();
                        } else {
                            alert('Failed to send OTP. Please try again.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        alert('Error sending OTP. Please try again.');
                    }
                });
            });

            // Add event listener to the "Verify OTP" button
            verifyOtpBtn.click(function () {
                // Perform AJAX to verify OTP (replace with your actual URL and data)
                $.ajax({
                    url: '{{url("verify-codotp")}}',
                    method: 'POST',
                    data: {
                        otp: $('#otpInput').val(),// Include the entered OTP
                        phone: $('#mobileInput').val() // Include the entered OTP
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.code == 200) {
                            alert('OTP Verified!');
                            placeOrderBtn.prop('disabled', false); // Enable Place Order button
                        } else {
                            alert('OTP verification failed. Please try again.');
                        }
                    },
                    error: function () {
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
                if ($("#same_billing").prop('checked') == false) {
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
    <script>
        $(document).ready(function () {

            //$("#freeshipval").hide();
            $("#finalpay").hide();
            const $addressRadioButtons = $('input[name="selected_address"]');
            const $manualForm = $('.manual-form');
            const $savedAddresses = $('.saved-addresses');

            const $shippingOptions = $('#shipping-options');
            const $selectedCourier = $('#courier-select');
            const $shippingPriceInput = $('#shipping-price'); // Update this line
            const $totalAmountInput = $('#total-amount'); // Add this line

            const $pincodeInput = $('input[name="pincode"]');
            const sum_length = $('.sLength').val();
            const sum_width = $('.sWidth').val();
            const sum_height = $('.sHeight').val();
            const $finalAmountInput = $('#final-amount'); // Define the input field for the final amount

            let ratesArray = [];

            let salesTax = 0;
            const debounceDelay = 100;
            let shippingTimer;


            $(document).ready(function () {
                clearTimeout(shippingTimer);

                const zipCode = $('#zipcode').val();
                // alert(zipCode);
                // return false;

                // Only fetch sales tax if ZIP code is 5 or more digits
                if (zipCode.length >= 5) {
                    shippingTimer = setTimeout(function () {
                        fetchSalesTax(zipCode);
                    }, debounceDelay);
                }
            });

            function fetchSalesTax(zipCode) {

                $.ajax({
                    method: 'GET',
                    url: 'https://api.api-ninjas.com/v1/salestax?zip_code=' + zipCode,
                    headers: {'X-Api-Key': '4NZW/DZKECPyubyiLhZvcg==LEgqG60lhPyYuwSn'}, // Replace with your API key
                    contentType: 'application/json',
                    success: function (result) {

                        var ptot = "<?php echo $productTotal = $get_count->cartTotal; ?>";

                        const salesTaxRate = parseFloat(result[0].total_rate);
                        const productTotal = parseFloat(ptot);

                        const totalAmount = productTotal + (productTotal * salesTaxRate);

                        // Display calculated values with $ sign in div elements
                        $('.salesTaxDiv').text('$' + (productTotal * salesTaxRate).toFixed(2));
                        $('.finalTaxDiv').text('$' + totalAmount.toFixed(2));

                        // Set calculated values in input fields without $ sign
                        $('#sales-tax').val((productTotal * salesTaxRate).toFixed(2));
                        $finalAmountInput.val(totalAmount.toFixed(2));
                    },
                    error: function (jqXHR) {

                        console.error('Error fetching sales tax:', jqXHR.responseText);
                    }
                });
            }


            // Event listener for the courier select input
            $selectedCourier.on('change', function () {

                const shippingPrice = $(this).val();

                const salesTax = parseFloat($('#sales-tax').val());
                if (salesTax == '' || salesTax == null) {
                    salesTax = 0;
                }

                const productTotal = parseFloat($('input[name="product_total"]').val());

                const selectedRate = shippingPrice;


                const selectedCourier1 = $(this).val();
                if (selectedCourier1 == 10) {
                    $("#finalpay").hide();
                } else {
                    $("#finalpay").show();
                }

                //  alert(selectedCourier1);
                // return false;


                if (!isNaN(productTotal)) {

                    if (selectedRate) {


                        $shippingPriceInput.val(selectedRate);

                        const newFinalAmount = parseFloat(salesTax) + parseFloat(productTotal) + parseFloat(selectedRate);
                        //alert(newFinalAmount );
                        $finalAmountInput.val(newFinalAmount.toFixed(2));
                        $('.finalTaxDiv').text('$' + newFinalAmount.toFixed(2));

                        const courierName = $selectedCourier.find(':selected').attr('data-name');

                        $(".issubmit").hide();
                        // alert(courierName);
                        // return false;

                        // if(selectedRate == 0){
                        //     const courierName = $selectedCourier.find(':selected').attr('data-name');
                        // }else{
                        //     const courierName = $selectedCourier.find(':selected').attr('data-name');
                        // }

                        $('#courier-name').val(courierName);
                        $('#selected_del').text('$' + selectedRate);
                    } else {

                        $shippingPriceInput.val('N/A');
                        $finalAmountInput.val(productTotal.toFixed(2));
                        $('.finalTaxDiv').text('$' + productTotal.toFixed(2));
                        $('#courier-name').val('N/A');
                    }
                } else {
                    //  alert('abc');
                    // return false;

                    $finalAmountInput.val('N/A');
                    $('#courier-name').val('');
                }
            });

            // Initial call to fetch and display shipping options
            fetchShippingOptions($pincodeInput.val());

            // Initial call to calculate sales tax
            fetchSalesTax($pincodeInput.val());
        });

        $(document).ready(function () {

            const $formFields = {
                first_name: $('input[name="first_name"]'),
                last_name: $('input[name="last_name"]'),
                country: $('input[name="country"]'),
                address_1: $('input[name="address_1"]'),
                address_2: $('input[name="address_2"]'),
                city: $('input[name="city"]'),
                state: $('input[name="state"]'),
                pincode: $('input[name="pincode"]'),
                phone: $('input[name="phone"]'),
                email: $('input[name="email"]')
            };

            function showSavedAddresses() {
                $savedAddresses.show();
                $manualForm.hide();
            }

            function showManualForm() {
                $savedAddresses.hide();
                $manualForm.show();
            }

            function populateAddressFields(address) {
                for (const field in $formFields) {
                    $formFields[field].val(address[field]);
                }
            }

            function clearFormFields() {
                for (const field in $formFields) {
                    $formFields[field].val('');
                }
            }

            $addressRadioButtons.on('change', function () {
                const selectedAddressId = $(this).val();
                if (selectedAddressId !== '') {
                    const selectedAddress = addresses.find(address => address.id === parseInt(selectedAddressId));
                    populateAddressFields(selectedAddress);
                    fetchShippingOptions(selectedAddress.pincode);
                    fetchSalesTax(selectedAddress.pincode);
                } else {
                    clearFormFields();
                    $shippingOptions.empty();
                    $selectedCourier.html('');
                }
            });

            $pincodeInput.on('keyup', function () {
                fetchShippingOptions($(this).val());
            });

            $('input[name="shipping_option"]').on('change', function () {
                $selectedCourier.html(`Selected Courier: ${$(this).val()}`);
            });

            (isAuthenticated && addresses.length > 0) ? showSavedAddresses() : showManualForm();
        });

    </script>
    <script>
        $(document).ready(function () {
            const applyCouponBtn = $('#applyCouponBtn');
            const couponCodeInput = $('#couponCode');

            applyCouponBtn.click(function (event) {
                event.preventDefault();
                const couponCode = couponCodeInput.val();

                // Make an AJAX request to apply the coupon code
                $.ajax({
                    url: '{{ route('cart.apply_coupon') }}',
                    type: 'POST',
                    data: {coupon_code: couponCode},
                    dataType: 'json',
                    success: function (response) {

                        // Update the cart total with the discounted total
                        const summaryTotal = $('.summary-total td:last-child');
                        summaryTotal.text('$ ' + response.discounted_total.toFixed(2));
                        $('.final_amount').html('$ ' + response.discounted_total.toFixed(2));
                        $('#body-id').load('#body-id');
                    },
                    error: function (xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });
        });

    </script>
@stop

