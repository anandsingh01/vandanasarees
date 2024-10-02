@extends('layouts.web')
<?php
session_start();
?>
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .input-group {
            padding: 0;
            justify-content: center;
        }
        .cart-bottom{
            display:block;
        }
        form {
            width: 100%;
        }
        .form-control {
            height: 40px;
            padding: 0.85rem 1rem;
        }
        .table th {
            font-weight: 400;
            font-size: 1.4rem;
            line-height: 1.5;
            color: #000;
        }
        .page-header h1 {
            color: #fff;
            background: #173054ab;
            padding: 1em 0 !important;
        }
        .fav_hr {
            margin-top: -0.6rem;
            width: 12%;
            border: 1px solid;
        }
        .heading {
            margin: 1.1rem 0 0;
        }
        .title{
            font-size: 2rem;
        }
        .breadcrumb {
            background-color: transparent;
            border-radius: 0;
            margin: 0;
            padding: 0;
            position: absolute;
            border: 0;
            padding: 30px 0;
        }

        .heading .title {
            font-size: 2.4rem;
            letter-spacing: -.025em;
        }
        select#couponCode {
            width: 100% !important;
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
    <main class="main">

        <div class="heading heading-center mb-3">
            <h2 class="title mb-1">CHECKOUT</h2>
            <hr class="fav_hr">

        </div>
        <!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </div>
                </div> </nav>

                <div class="row">
                    <div class="col-md-8 text-right">
                        <p class="text-dark">Free shipping on orders above $75</p>

                        <p class="text-dark">
                            "All orders placed after 1PM will be processed on the next business day for shipping"</p>
                    </div>
                </div>

                <style>
                    .breadcrumb-nav .container, .breadcrumb-nav .container-fluid {
                        padding-top: 1.4rem;
                        padding-bottom: 0.4rem;
                    }
                    a.backBtn {
                        border: 1px solid !important;
                        padding: 5px 4em !important;
                    }
                </style>
                <div class="row">
                    <div class="col-md-2">
                        <?php
                        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard';
                        ?>
                        <a href="{{ url($referer) }}" class="backBtn" >Back</a>
                    </div>
                </div>
            </div>


        <!-- End .breadcrumb-nav -->
        <div class="page-content">


            <div class="cart">

                <div class="container">

                    <div class="row">
                        @if(Session::has('error'))
                            <div class="alert alert-danger text-center">
                                {{Session::get('error')}}
                            </div>
                        @endif


                        <form action="{{ route('checkout.submit') }}" method="post" novalidate>
                            @csrf

                            <div class="row form-fields">
                                <div class="col-lg-9">

                                    <div id="billing-address-container">

                                        <label>
                                            <input type="checkbox" id="same_billing" name="same_billing_details"
                                                   value="1" />
                                            Same as shipping address
                                        </label>

                                    </div>

                                    <br>

                                    <div id="different_address" class="billing_address">
                                        <input type="hidden" name="same_billing" value="1" />
                                        <div class="billing_details">
                                            <h2 class="checkout-title">Billing Details</h2>
                                            <!-- End .checkout-title -->
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>First Name *</label>
                                                    <input type="text" class="form-control"
                                                           name="billing_first_name" required >
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Last Name *</label>
                                                    <input type="text" class="form-control"
                                                           name="billing_last_name" required>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Country *</label>
                                                    <input type="text" class="form-control" name="billing_country"
                                                           value="USA" required>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label>Street address *</label>
                                                    <input name="billing_address_1" type="text" class="form-control"
                                                           placeholder="House number and Street name"
                                                           required
                                                    >
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Street address *</label>
                                                    <input name="billing_address_2" type="text" class="form-control"
                                                           placeholder="Appartments, suite, unit etc ..."

                                                    >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Town / City *</label>
                                                    <input name="billing_city" type="text" class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>State / County *</label>
                                                    <select name="billing_state" class="form-control" required>
                                                        <option value="AL">Alabama</option>
                                                        <option value="AK">Alaska</option>
                                                        <option value="AZ">Arizona</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="CA">California</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="HI">Hawaii</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WA">Washington</option>
                                                        <option value="WV">West Virginia</option>
                                                        <option value="WI">Wisconsin</option>
                                                        <option value="WY">Wyoming</option>
                                                    </select>

                                                </div>

                                            </div>
                                            <!-- End .row -->
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Postcode / ZIP *</label>
                                                    <input name="billing_pincode" type="text" class="form-control"
                                                           required>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Phone *</label>
                                                    <input name="billing_phone" type="tel" class="form-control"
                                                           required>
                                                </div>

                                            </div>
                                            <!-- End .row -->
                                            <label>Email address *</label>
                                            <input name="billing_email" type="email" class="form-control"
                                                   required>

                                        </div>
                                    </div>

                                    <div class="same_address">

                                        <input type="hidden" name="same_billing" value="0" required>
                                        <div class="billing_details">
                                            <h2 class="checkout-title">Shipping Details</h2>
                                            <!-- End .checkout-title -->
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>First Name *</label>
                                                    <input type="text" class="form-control"
                                                           value="{{$first_name}}"
                                                           name="billing_first_name" required >
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Last Name *</label>
                                                    <input type="text" class="form-control"
                                                           value="{{$last_name}}"
                                                           name="billing_last_name" required>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Country *</label>
                                                    <input type="text" class="form-control" name="billing_country"
                                                           value="{{$country}}"
                                                           value="USA" required>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label>Street address *</label>
                                                    <input name="billing_address_1" type="text" class="form-control"
                                                           placeholder="House number and Street name"
                                                           value="{{$address_1}}"
                                                           required
                                                    >
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Street address *</label>
                                                    <input name="billing_address_2" type="text" class="form-control"
                                                           placeholder="Appartments, suite, unit etc ..."
                                                           value="{{$address_2}}"

                                                    >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Town / City *</label>
                                                    <input name="billing_city" type="text" class="form-control"
                                                           value="{{$city}}"
                                                           required>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>State / County *</label>
                                                    <input name="state" type="text" class="form-control"
                                                           value="{{$state}}"
                                                           readonly>
                                                </div>

                                            </div>
                                            <!-- End .row -->
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Postcode / ZIP *</label>
                                                    <input name="billing_pincode" type="text" class="form-control"
                                                           value="{{$pincode}}"
                                                           required>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Phone *</label>
                                                    <input name="billing_phone" type="tel" class="form-control"
                                                           value="{{$phone}}"
                                                           required>
                                                </div>

                                            </div>
                                            <!-- End .row -->
                                            <label>Email address *</label>
                                            <input name="billing_email" type="email" class="form-control"
                                                   value="{{$email}}"
                                                   required>

                                        </div>




                                        <div class="shipping_details" style="display:none;">
                                            <h2 class="checkout-title">Shipping Details</h2>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>First Name *</label>
                                                    <input type="text" class="form-control"
                                                           value="{{$first_name}}"
                                                           name="first_name" readonly>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Last Name *</label>
                                                    <input type="text" class="form-control" name="last_name"
                                                           value="{{$last_name}}"
                                                           readonly>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Country *</label>
                                                    <input type="text" class="form-control" name="country"
                                                           value="{{$country}}"
                                                           readonly>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label>Street address *</label>
                                                    <input name="address_1" type="text" class="form-control"
                                                           placeholder="House number and Street name"
                                                           value="{{$address_1}}"
                                                           readonly>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Street address *</label>
                                                    <input name="address_2" type="text" class="form-control"
                                                           placeholder="Appartments, suite, unit etc ..."
                                                           value="{{$address_2}}"
                                                           readonly
                                                    >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Town / City *</label>
                                                    <input name="city" type="text" class="form-control"
                                                           value="{{$city}}"
                                                           readonly>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>State / County *</label>
                                                    <input name="state" type="text" class="form-control"
                                                           value="{{$state}}"
                                                           readonly>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Postcode / ZIP *</label>
                                                    <input name="pincode" type="text" class="form-control"
                                                           value="{{$pincode}}"
                                                           id="zipcode"
                                                           readonly>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Phone *</label>
                                                    <input name="phone" type="tel" class="form-control"
                                                           value="{{$phone}}"
                                                           readonly>
                                                </div>

                                            </div>

                                            <label>Email address *</label>
                                            <input name="email" type="email" class="form-control"
                                                   value="{{$email}}"
                                                   readonly>

                                        </div>
                                    </div>

                                </div>

                                <?php
                                $get_cart = get_cart();
                                $get_count = json_decode($get_cart);
                                $getAllCart = getCartProducts();

//                                print_r($get_count->cartTotal);
                                ?>
                                <aside class="col-lg-3">
                                    <div class="summary summary-cart">
                                        <div class="cart-bottom">
                                            @if($get_count->cartTotal > 15)
                                                <div class="cart-discount">
                                                    @if(Session::has('discounted_total'))
                                                        Coupon Applied : {{Session::get('applied_coupon')}}
                                                        <br>
                                                        <span style="font-size:12px; color:red;">
                                                    <a href="{{url('remove-coupon')}}">Remove Coupon</a>
                                                </span>

                                                    @endif

                                                    <form id="applyCouponForm" action="#">
                                                        <div class="input-group">
                                                            @php
                                                                $coupons = \App\Models\Offer::where('status','1')->get();
                                                            @endphp
                                                            <select id="couponCode" class="form-control">
                                                                <option>Select Coupon</option>
                                                                @forelse($coupons as $key => $coupon)
                                                                    <option value="{{$coupon->code}}">{{$coupon->code}} </option>
                                                                @empty
                                                                @endforelse
                                                            </select>

                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-primary-2"
                                                                        type="button" id="applyCouponBtn"><i class="icon-long-arrow-right"></i></button>
                                                            </div><!-- .End .input-group-append -->
                                                        </div><!-- End .input-group -->
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="summary-title">Cart Total</h3>

                                        <table class="table table-summary">
                                            <tbody>
                                            @php
                                                $sumLength = 0;
                                                $sumWidth = 0;
                                                $sumHeight = 0;
                                            @endphp
                                            @forelse($getAllCart as $key => $getAllCarts)
                                                <tr style="display: none;">
                                                    <td><a href="{{url('products/'.$getAllCarts->getProducts->slug ?? '')}}">
                                                            {{$getAllCarts->getProducts->title ?? ''}}</a></td>
                                                    <td>
                                                       <span class="cart-product-info">
                                                       <span class="cart-product-qty">{{$getAllCarts->cartqty}}
                                                       </span>x ${{$getAllCarts->price}}
                                                       </span><!--End .cart-product-info-->
                                                    </td>
                                                </tr>

                                                <input type="hidden" name="product_name[]" value="{{$getAllCarts->getProducts->title}}"/>
                                                <input type="hidden" name="product_id[]" value="{{$getAllCarts->getProducts->id}}"/>
                                                <input type="hidden" name="attribute_id[]" value="{{$getAllCarts->attribute_id}}"/>
                                                <input type="hidden" name="qty[]" value="{{$getAllCarts->cartqty}}"/>
                                                <input type="hidden" name="price[]" value="{{$getAllCarts->price}}"/>
                                                <input type="hidden" name="size[]" value="{{$getAllCarts->size}}"/>
                                                <input type="hidden" name="height[]" value="{{$getAllCarts->height}}"/>
                                                <input type="hidden" name="width[]" value="{{$getAllCarts->width}}"/>
                                                <input type="hidden" name="length[]" value="{{$getAllCarts->length}}"/>
                                                @php
                                                    $get_dimension = \App\Models\Product_size::find($getAllCarts->attribute_id);
                                                    $sumLength += $get_dimension->length;
                                                    $sumWidth += $get_dimension->width;
                                                    $sumHeight += $get_dimension->height;
                                                @endphp
                                            @empty
                                            @endforelse

                                            <tr>
                                                <td>Subtotal</td>
                                                <td>
                                                    $ {{$prodTotal}}
                                                </td>
                                            </tr>
                                            <!-- Include the sum in a hidden input field -->
                                            <input type="hidden" class="sLength" name="sum_length[]" value="{{ $sumLength }}"/>
                                            <input type="hidden" class="sWidth"  name="sum_width[]" value="{{ $sumWidth }}"/>
                                            <input type="hidden" class="sHeight" name="sum_height[]" value="{{ $sumHeight }}"/>
                                            <tr>
                                                <td> Tax</td>
                                                <td><div class="salesTaxDiv"></div></td>
                                            </tr>
                                            @if(Session::has('discounted_total'))
                                                    <?php $productTotal = Session::get('discounted_total'); ?>
                                                <input type="hidden" name="product_total" id="total-amount" value="{{$productTotal}}"/>
                                                <input type="hidden" name="coupon_code" value="{{Session::get('applied_coupon')}}"/>
                                            @else
                                                    <?php $productTotal = $get_count->cartTotal; ?>

                                                <input type="hidden" name="product_total" id="total-amount" value="{{$productTotal}}"/>
                                            @endif
                                            @if(Session::has('discounted_total'))
                                                <tr class="summary-subtotal">
                                                    <td>Coupon Applied</td>
                                                    <td>{{Session::get('applied_coupon')}}</td>
                                                </tr><!-- End .summary-subtotal -->
                                            @endif
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
                                            <tr>
                                                <td>Delivery</td>
                                                <td>
                                                    @if($get_count->cartTotal < 75)
                                                        <div class="form-group">
                                                            <select class="form-control"
                                                                    required id="courier-select" name="selected_courier">
                                                                <option></option>
                                                                <option value="7.99" data-name="Standard U.S Shipping (4-7 business days)">
                                                                    Standard U.S Shipping (4-7 business days): $7.99</option>
                                                                <option value="15.99" data-name="Priority U.S Shipping (2-3 business days)">
                                                                    Priority U.S Shipping (2-3 business days): $15.99</option>
                                                                F    <option value="19.99" data-name="1-Business day Shipping">
                                                                    1-Business day Shipping: $19.99</option>
                                                            </select>
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <select class="form-control"
                                                                    required id="courier-select"
                                                                    name="selected_courier">
                                                                <option value="0" data-name="Free shipping">Free Shipping</option>
                                                                <option value="15.99" data-name="Priority U.S Shipping (2-3 business days)">
                                                                    Priority U.S Shipping (2-3 business days): $15.99</option>
                                                                <option value="19.99" data-name="1-Business day Shipping">
                                                                    1-Business day Shipping: $19.99</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr class="" colspan="1">
                                                <td>Shipping</td>
                                                <td><span id="selected_del">$0.00</span></td>

                                            </tr>



                                            <input type="hidden" class="form-control" id="sales-tax" name="sales_tax" readonly>
                                            <input type="hidden" class="form-control" id="shipping-price" name="shipping_price" readonly>
                                            <input type="hidden" class="form-control" id="final-amount" name="final_amount" readonly>
                                            <input type="hidden" class="form-control" id="courier-name" name="courier_nmae" readonly>

                                            <tr  class="summary-subtotal">
                                                <td>Total</td>
                                                <td><div class="finalTaxDiv"></div></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-order btn-block pb-2 pt-2
                                   btn-outline-primary-2">PAY</button>
                                    </div><!-- End .summary -->
                                </aside>
                            </div>
                        </form>
                    </div>
                    <!-- End .row -->
                </div>
                <!-- End .container -->
            </div>
            <!-- End .cart -->
        </div>
        <!-- End .page-content -->
    </main>
@stop
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>


    @if(Session::has('error'))
        <script>
            swal("Address not found");
            // location.reload();
            // console.log(data.success)
        </script>
    @endif
    {{--    <script>--}}
    {{--        $(document).ready(function() {--}}
    {{--            // Attach a keyup event handler to the pin code input field--}}
    {{--            $('#pincode-input').on('keyup', function() {--}}
    {{--                const pincode = $(this).val();--}}

    {{--                // Check if the entered pin code has at least 5 characters--}}
    {{--                if (pincode.length >= 5) {--}}
    {{--                    // Call the fetchShippingServices function to fetch shipping services and update the displayed information--}}
    {{--                    fetchShippingOptions($(this).val());--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}

    <script>

        $(document).ready(function () {

            $('#different_address').css('display', 'block');

            $('#same_billing').on('change', function () {
                if (this.checked) {
                    // If the checkbox is checked, hide 'different_address' and show 'same_address'
                    $('#different_address').css('display', 'none');
                    $('#same_address').css('display', 'block');
                } else {
                    // If the checkbox is unchecked, hide 'same_address' and show 'different_address'
                    $('#same_address').css('display', 'none');
                    $('#different_address').css('display', 'block');
                }
            });
        });
        // $(document).ready(function () {
        //     // Get a reference to the "Same as shipping address" checkbox element using jQuery
        //     const sameBillingCheckbox = $('#same_billing');
        //
        //     // Add an event listener to the checkbox using jQuery
        //     sameBillingCheckbox.on('change', function () {
        //         // Check if the checkbox is checked
        //         if (this.checked) {
        //             // If checked, perform actions here
        //             console.log('Checkbox is checked');
        //             $('#same_address').css('display','block');
        //             $('#different_address').css('display','none');
        //             // You can hide the billing address form or perform any other actions
        //         } else {
        //             // If unchecked, perform actions here
        //             console.log('Checkbox is unchecked');
        //             // You can show the billing address form or perform any other actions
        //         }
        //     });
        // });
    </script>
    <script>
        $(document).ready(function () {


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
                    headers: { 'X-Api-Key': '4NZW/DZKECPyubyiLhZvcg==LEgqG60lhPyYuwSn' }, // Replace with your API key
                    contentType: 'application/json',
                    success: function (result) {

                        var ptot = "<?php echo $productTotal = $get_count->cartTotal; ?>";

                        const salesTaxRate = parseFloat(result[0].total_rate);
                        const productTotal = parseFloat(ptot) ;

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
                // const selectedCourier = $(this).val();
                const shippingPrice = $(this).val();

                const salesTax = parseFloat($('#sales-tax').val());

                const productTotal = parseFloat($('input[name="product_total"]').val());

                const selectedRate = shippingPrice;

                // alert(selectedRate);
                // return false;


                if (!isNaN(productTotal)) {
                    if (selectedRate) {

                        $shippingPriceInput.val(selectedRate);

                        const newFinalAmount = parseFloat(salesTax) + parseFloat(productTotal) + parseFloat(selectedRate);

                        $finalAmountInput.val(newFinalAmount.toFixed(2));
                        $('.finalTaxDiv').text('$' + newFinalAmount.toFixed(2));

                        const courierName = $selectedCourier.find(':selected').attr('data-name');

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
                    // alert('abc');
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
                        summaryTotal.text('$ ' + response.discounted_total.toFixed(2));
                        $('.final_amount').html('$ ' + response.discounted_total.toFixed(2));
                        $('#body-id').load('#body-id');
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
{{--        body, h1, h2, h3, h4, h5, h6, p, div, span, a, label, h1.page-title{--}}
{{--            font-family: 'Albert Sans';--}}
{{--            font-weight: 400;--}}
{{--        }--}}
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
{{--            <h2 class="title mb-1">Checkout</h2>--}}
{{--            <hr class="fav_hr">--}}

{{--        </div>--}}
{{--        <!-- End .page-header -->--}}
{{--        <nav aria-label="breadcrumb" class="breadcrumb-nav">--}}
{{--            <div class="container">--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
{{--                    <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>--}}
{{--                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>--}}
{{--                </ol>--}}
{{--                <style>--}}
{{--                    .breadcrumb-nav .container, .breadcrumb-nav .container-fluid {--}}
{{--                        padding-top: 1.4rem;--}}
{{--                        padding-bottom: 0.4rem;--}}
{{--                    }--}}
{{--                    a.backBtn {--}}
{{--                        border: 1px solid !important;--}}
{{--                        padding: 5px 4em !important;--}}
{{--                    }--}}
{{--                </style>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-2">--}}
{{--                        <?php--}}
{{--                        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard';--}}
{{--                        ?>--}}
{{--                        <a href="{{ url($referer) }}" class="backBtn" >Back</a>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <!-- End .container -->--}}


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
{{--                        <form action="{{ route('checkout.submit') }}" method="post">--}}
{{--                            @csrf--}}

{{--                            <div class="row form-fields">--}}

{{--                                <div class="col-lg-9">--}}
{{--                                    @if($sameBilling == 1)--}}
{{--                                    <div class="gchekc">--}}
{{--                                        <h2 class="checkout-title">Billing Details</h2>--}}
{{--                                        <!-- End .checkout-title -->--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label>First Name *</label>--}}
{{--                                                <input type="text" class="form-control"--}}
{{--                                                       value="{{$first_name}}"--}}
{{--                                                       name="first_name" readonly>--}}
{{--                                            </div>--}}
{{--                                            --}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label>Last Name *</label>--}}
{{--                                                <input type="text" class="form-control" name="last_name"--}}
{{--                                                       value="{{$last_name}}"--}}
{{--                                                       readonly>--}}
{{--                                            </div>--}}
{{--                                            --}}
{{--                                        </div>--}}
{{--                                        <!-- End .row -->--}}
{{--                                        <label>Company Name (Optional)</label>--}}
{{--                                        <input type="text" value="{{$first_name}}"--}}
{{--                                               readonly--}}
{{--                                               class="form-control">--}}
{{--                                        <label>Country *</label>--}}
{{--                                        <input type="text" class="form-control" name="country"--}}
{{--                                               value="{{$country}}"--}}
{{--                                               readonly>--}}

{{--                                        <label>Street address *</label>--}}
{{--                                        <input name="address_1" type="text" class="form-control"--}}
{{--                                               placeholder="House number and Street name"--}}
{{--                                               value="{{$address_1}}"--}}
{{--                                               readonly>--}}

{{--                                        <input name="address_2" type="text" class="form-control"--}}
{{--                                               placeholder="Appartments, suite, unit etc ..."--}}
{{--                                               value="{{$address_2}}"--}}
{{--                                               readonly--}}
{{--                                        >--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label>Town / City *</label>--}}
{{--                                                <input name="city" type="text" class="form-control"--}}
{{--                                                       value="{{$city}}"--}}
{{--                                                       readonly>--}}
{{--                                            </div>--}}
{{--                                            --}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label>State / County *</label>--}}
{{--                                                <input name="state" type="text" class="form-control"--}}
{{--                                                       value="{{$state}}"--}}
{{--                                                       readonly>--}}
{{--                                            </div>--}}
{{--                                            --}}
{{--                                        </div>--}}
{{--                                        <!-- End .row -->--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label>Postcode / ZIP *</label>--}}
{{--                                                <input name="pincode" type="text" class="form-control"--}}
{{--                                                       value="{{$pincode}}"--}}
{{--                                                       id="zipcode"--}}
{{--                                                       readonly>--}}
{{--                                            </div>--}}
{{--                                            --}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <label>Phone *</label>--}}
{{--                                                <input name="phone" type="tel" class="form-control"--}}
{{--                                                       value="{{$phone}}"--}}
{{--                                                       readonly>--}}
{{--                                            </div>--}}
{{--                                            --}}
{{--                                        </div>--}}
{{--                                        <!-- End .row -->--}}
{{--                                        <label>Email address *</label>--}}
{{--                                        <input name="email" type="email" class="form-control"--}}
{{--                                               value="{{$email}}"--}}
{{--                                               readonly>--}}
{{--                                    </div>--}}
{{--                                    @else--}}

{{--                                        <input type="hidden" name="same_billing" value="0" required>--}}
{{--                                        <div class="billing_details">--}}
{{--                                            <h2 class="checkout-title">Billing Details</h2>--}}
{{--                                            <!-- End .checkout-title -->--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>First Name *</label>--}}
{{--                                                    <input type="text" class="form-control"--}}
{{--                                                           name="billing_first_name" required >--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Last Name *</label>--}}
{{--                                                    <input type="text" class="form-control"--}}
{{--                                                           name="billing_last_name" required>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-12">--}}
{{--                                                    <label>Country *</label>--}}
{{--                                                    <input type="text" class="form-control" name="billing_country"--}}
{{--                                                          value="USA" required>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}

{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Street address *</label>--}}
{{--                                                    <input name="billing_address_1" type="text" class="form-control"--}}
{{--                                                           placeholder="House number and Street name"--}}
{{--                                                           required--}}
{{--                                                    >--}}
{{--                                                </div>--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Street address *</label>--}}
{{--                                                    <input name="billing_address_2" type="text" class="form-control"--}}
{{--                                                           placeholder="Appartments, suite, unit etc ..."--}}

{{--                                                    >--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Town / City *</label>--}}
{{--                                                    <input name="billing_city" type="text" class="form-control"--}}
{{--                                                           required>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>State / County *</label>--}}
{{--                                                    <input name="billing_state" type="text" class="form-control">--}}
{{--                                                    <select name="billing_state" class="form-control" required>--}}
{{--                                                        <option value="AL">Alabama</option>--}}
{{--                                                        <option value="AK">Alaska</option>--}}
{{--                                                        <option value="AZ">Arizona</option>--}}
{{--                                                        <option value="AR">Arkansas</option>--}}
{{--                                                        <option value="CA">California</option>--}}
{{--                                                        <option value="CO">Colorado</option>--}}
{{--                                                        <option value="CT">Connecticut</option>--}}
{{--                                                        <option value="DE">Delaware</option>--}}
{{--                                                        <option value="FL">Florida</option>--}}
{{--                                                        <option value="GA">Georgia</option>--}}
{{--                                                        <option value="HI">Hawaii</option>--}}
{{--                                                        <option value="ID">Idaho</option>--}}
{{--                                                        <option value="IL">Illinois</option>--}}
{{--                                                        <option value="IN">Indiana</option>--}}
{{--                                                        <option value="IA">Iowa</option>--}}
{{--                                                        <option value="KS">Kansas</option>--}}
{{--                                                        <option value="KY">Kentucky</option>--}}
{{--                                                        <option value="LA">Louisiana</option>--}}
{{--                                                        <option value="ME">Maine</option>--}}
{{--                                                        <option value="MD">Maryland</option>--}}
{{--                                                        <option value="MA">Massachusetts</option>--}}
{{--                                                        <option value="MI">Michigan</option>--}}
{{--                                                        <option value="MN">Minnesota</option>--}}
{{--                                                        <option value="MS">Mississippi</option>--}}
{{--                                                        <option value="MO">Missouri</option>--}}
{{--                                                        <option value="MT">Montana</option>--}}
{{--                                                        <option value="NE">Nebraska</option>--}}
{{--                                                        <option value="NV">Nevada</option>--}}
{{--                                                        <option value="NH">New Hampshire</option>--}}
{{--                                                        <option value="NJ">New Jersey</option>--}}
{{--                                                        <option value="NM">New Mexico</option>--}}
{{--                                                        <option value="NY">New York</option>--}}
{{--                                                        <option value="NC">North Carolina</option>--}}
{{--                                                        <option value="ND">North Dakota</option>--}}
{{--                                                        <option value="OH">Ohio</option>--}}
{{--                                                        <option value="OK">Oklahoma</option>--}}
{{--                                                        <option value="OR">Oregon</option>--}}
{{--                                                        <option value="PA">Pennsylvania</option>--}}
{{--                                                        <option value="RI">Rhode Island</option>--}}
{{--                                                        <option value="SC">South Carolina</option>--}}
{{--                                                        <option value="SD">South Dakota</option>--}}
{{--                                                        <option value="TN">Tennessee</option>--}}
{{--                                                        <option value="TX">Texas</option>--}}
{{--                                                        <option value="UT">Utah</option>--}}
{{--                                                        <option value="VT">Vermont</option>--}}
{{--                                                        <option value="VA">Virginia</option>--}}
{{--                                                        <option value="WA">Washington</option>--}}
{{--                                                        <option value="WV">West Virginia</option>--}}
{{--                                                        <option value="WI">Wisconsin</option>--}}
{{--                                                        <option value="WY">Wyoming</option>--}}
{{--                                                    </select>--}}


{{--                                                </div>--}}
{{--                                                --}}
{{--                                            </div>--}}
{{--                                            <!-- End .row -->--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Postcode / ZIP *</label>--}}
{{--                                                    <input name="billing_pincode" type="text" class="form-control"--}}
{{--                                                           required>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Phone *</label>--}}
{{--                                                    <input name="billing_phone" type="tel" class="form-control"--}}
{{--                                                           required>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                            </div>--}}
{{--                                            <!-- End .row -->--}}
{{--                                            <label>Email address *</label>--}}
{{--                                            <input name="billing_email" type="email" class="form-control"--}}
{{--                                                   required>--}}

{{--                                        </div>--}}


{{--                                    <hr>--}}
{{--                                        <div class="gchekc" style="display: none;">--}}
{{--                                            <h2 class="checkout-title">Shipping Details</h2>--}}
{{--                                            <!-- End .checkout-title -->--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>First Name *</label>--}}
{{--                                                    <input type="text" class="form-control"--}}
{{--                                                           value="{{$first_name}}"--}}
{{--                                                           name="first_name" readonly>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Last Name *</label>--}}
{{--                                                    <input type="text" class="form-control" name="last_name"--}}
{{--                                                           value="{{$last_name}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                            </div>--}}
{{--                                            <!-- End .row -->--}}
{{--                                            <label>Company Name (Optional)</label>--}}
{{--                                            <input type="text" value="{{$first_name}}"--}}
{{--                                                   readonly--}}
{{--                                                   class="form-control">--}}
{{--                                            <label>Country *</label>--}}
{{--                                            <input type="text" class="form-control" name="country"--}}
{{--                                                   value="{{$country}}"--}}
{{--                                                   readonly>--}}

{{--                                            <label>Street address *</label>--}}
{{--                                            <input name="address_1" type="text" class="form-control"--}}
{{--                                                   placeholder="House number and Street name"--}}
{{--                                                   value="{{$address_1}}"--}}
{{--                                                   readonly>--}}

{{--                                            <input name="address_2" type="text" class="form-control"--}}
{{--                                                   placeholder="Appartments, suite, unit etc ..."--}}
{{--                                                   value="{{$address_2}}"--}}
{{--                                                   readonly--}}
{{--                                            >--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Town / City *</label>--}}
{{--                                                    <input name="city" type="text" class="form-control"--}}
{{--                                                           value="{{$city}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>State / County *</label>--}}
{{--                                                    <input name="state" type="text" class="form-control"--}}
{{--                                                           value="{{$state}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                            </div>--}}
{{--                                            <!-- End .row -->--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Postcode / ZIP *</label>--}}
{{--                                                    <input name="pincode" type="text" class="form-control"--}}
{{--                                                           value="{{$pincode}}"--}}
{{--                                                           id="zipcode"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <label>Phone *</label>--}}
{{--                                                    <input name="phone" type="tel" class="form-control"--}}
{{--                                                           value="{{$phone}}"--}}
{{--                                                           readonly>--}}
{{--                                                </div>--}}
{{--                                                --}}
{{--                                            </div>--}}
{{--                                            <!-- End .row -->--}}
{{--                                            <label>Email address *</label>--}}
{{--                                            <input name="email" type="email" class="form-control"--}}
{{--                                                   value="{{$email}}"--}}
{{--                                                   readonly>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}


{{--                                </div>--}}


{{--                                <div class="col-lg-9">--}}
{{--                                    <h2 class="checkout-title">Billing Details</h2>--}}
{{--                                    <!-- End .checkout-title -->--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <label>First Name *</label>--}}
{{--                                            <input type="text" class="form-control"--}}
{{--                                                   value="{{$first_name}}"--}}
{{--                                                   name="first_name" readonly>--}}
{{--                                        </div>--}}
{{--                                        --}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <label>Last Name *</label>--}}
{{--                                            <input type="text" class="form-control" name="last_name"--}}
{{--                                                   value="{{$last_name}}"--}}
{{--                                                   readonly>--}}
{{--                                        </div>--}}
{{--                                        --}}
{{--                                    </div>--}}
{{--                                    <!-- End .row -->--}}
{{--                                    <label>Company Name (Optional)</label>--}}
{{--                                    <input type="text" value="{{$first_name}}"--}}
{{--                                           readonly--}}
{{--                                           class="form-control">--}}
{{--                                    <label>Country *</label>--}}
{{--                                    <input type="text" class="form-control" name="country"--}}
{{--                                           value="{{$country}}"--}}
{{--                                           readonly>--}}

{{--                                    <label>Street address *</label>--}}
{{--                                    <input name="address_1" type="text" class="form-control"--}}
{{--                                           placeholder="House number and Street name"--}}
{{--                                           value="{{$address_1}}"--}}
{{--                                           readonly>--}}

{{--                                    <input name="address_2" type="text" class="form-control"--}}
{{--                                           placeholder="Appartments, suite, unit etc ..."--}}
{{--                                           value="{{$address_2}}"--}}
{{--                                           readonly--}}
{{--                                    >--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <label>Town / City *</label>--}}
{{--                                            <input name="city" type="text" class="form-control"--}}
{{--                                                   value="{{$city}}"--}}
{{--                                                   readonly>--}}
{{--                                        </div>--}}
{{--                                        --}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <label>State / County *</label>--}}
{{--                                            <input name="state" type="text" class="form-control"--}}
{{--                                                   value="{{$state}}"--}}
{{--                                                   readonly>--}}
{{--                                        </div>--}}
{{--                                        --}}
{{--                                    </div>--}}
{{--                                    <!-- End .row -->--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <label>Postcode / ZIP *</label>--}}
{{--                                            <input name="pincode" type="text" class="form-control"--}}
{{--                                                   value="{{$pincode}}"--}}
{{--                                                   id="zipcode"--}}
{{--                                                   readonly>--}}
{{--                                        </div>--}}
{{--                                        --}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <label>Phone *</label>--}}
{{--                                            <input name="phone" type="tel" class="form-control"--}}
{{--                                                   value="{{$phone}}"--}}
{{--                                                   readonly>--}}
{{--                                        </div>--}}
{{--                                        --}}
{{--                                    </div>--}}
{{--                                    <!-- End .row -->--}}
{{--                                    <label>Email address *</label>--}}
{{--                                    <input name="email" type="email" class="form-control"--}}
{{--                                           value="{{$email}}"--}}
{{--                                           readonly>--}}

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
{{--                                            @if($get_count->cartTotal > 15)--}}
{{--                                                <div class="cart-discount">--}}
{{--                                                    @if(Session::has('discounted_total'))--}}
{{--                                                        Coupon Applied : {{Session::get('applied_coupon')}}--}}
{{--                                                        <br>--}}
{{--                                                        <span style="font-size:12px; color:red;">--}}
{{--                                                    <a href="{{url('remove-coupon')}}">Remove Coupon</a>--}}
{{--                                                </span>--}}

{{--                                                    @endif--}}

{{--                                                    <form id="applyCouponForm" action="#">--}}
{{--                                                        <div class="input-group">--}}
{{--                                                            @php--}}
{{--                                                                $coupons = \App\Models\Offer::where('status','1')->get();--}}
{{--                                                            @endphp--}}
{{--                                                            <select id="couponCode" class="form-control">--}}
{{--                                                                <option>Select Coupon</option>--}}
{{--                                                                @forelse($coupons as $key => $coupon)--}}
{{--                                                                    <option value="{{$coupon->code}}">{{$coupon->code}} </option>--}}
{{--                                                                @empty--}}
{{--                                                                @endforelse--}}
{{--                                                            </select>--}}

{{--                                                            <div class="input-group-append">--}}
{{--                                                                <button class="btn btn-outline-primary-2"--}}
{{--                                                                        type="button" id="applyCouponBtn"><i class="icon-long-arrow-right"></i></button>--}}
{{--                                                            </div><!-- .End .input-group-append -->--}}
{{--                                                        </div><!-- End .input-group -->--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
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
{{--                                            --}}{{--                                            <tr class="">--}}
{{--                                            --}}{{--                                                <td> Sub total:</td>--}}
{{--                                            --}}{{--                                                <td>--}}
{{--                                            --}}{{--                                                    @if(Session::has('discounted_total'))--}}
{{--                                            --}}{{--                                                        $ {{number_format(Session::get('discounted_total'),2) ?? '0'}}--}}
{{--                                            --}}{{--                                                    @else--}}
{{--                                            --}}{{--                                                       $ {{number_format($get_count->cartTotal,2) ?? '0'}}--}}
{{--                                            --}}{{--                                                    @endif--}}
{{--                                            --}}{{--                                                </td>--}}
{{--                                            --}}{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td>Delivery</td>--}}
{{--                                                <td>--}}
{{--                                                    @if($get_count->cartTotal < 75)--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <select class="form-control"--}}
{{--                                                                    required id="courier-select" name="selected_courier">--}}
{{--                                                                <option></option>--}}
{{--                                                                <option value="7.99" data-name="Standard U.S Shipping (4-7 business days)">--}}
{{--                                                                    Standard U.S Shipping (4-7 business days): $7.99</option>--}}
{{--                                                                <option value="15" data-name="Priority U.S Shipping (2-3 business days)">--}}
{{--                                                                    Priority U.S Shipping (2-3 business days): $15</option>--}}
{{--                                                                F    <option value="20" data-name="1-Business day Shipping">--}}
{{--                                                                    1-Business day Shipping: $20</option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                    @else--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <select class="form-control"--}}
{{--                                                                    required id="courier-select"--}}
{{--                                                                    name="selected_courier">--}}
{{--                                                                <option value="0" data-name="Free shipping">Free Shipping</option>--}}
{{--                                                                <option value="15" data-name="Priority U.S Shipping (2-3 business days)">--}}
{{--                                                                    Priority U.S Shipping (2-3 business days): $15</option>--}}
{{--                                                                <option value="20" data-name="1-Business day Shipping">--}}
{{--                                                                    1-Business day Shipping: $20</option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
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
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                        <button type="submit" class="btn btn-order btn-block pb-2 pt-2--}}
{{--                                   btn-outline-primary-2">PAY</button>--}}
{{--                                    </div><!-- End .summary -->--}}
{{--                                </aside>--}}
{{--                                <?php--}}
{{--                                $get_cart = get_cart();--}}
{{--                                $get_count = json_decode($get_cart);--}}
{{--                                $getAllCart = getCartProducts();--}}
{{--//                                print_r($get_count->cartTotal);--}}
{{--                                ?>--}}
{{--                                <aside class="col-lg-3">--}}
{{--                                    <div class="summary summary-cart">--}}
{{--                                        <div class="cart-bottom">--}}
{{--                                            @if($get_count->cartTotal > 15)--}}
{{--                                                <div class="cart-discount">--}}
{{--                                                    @if(Session::has('discounted_total'))--}}
{{--                                                        Coupon Applied : {{Session::get('applied_coupon')}}--}}
{{--                                                        <br>--}}
{{--                                                        <span style="font-size:12px; color:red;">--}}
{{--                                                    <a href="{{url('remove-coupon')}}">Remove Coupon</a>--}}
{{--                                                </span>--}}

{{--                                                    @endif--}}

{{--                                                    <form id="applyCouponForm" action="#">--}}
{{--                                                        <div class="input-group">--}}
{{--                                                            @php--}}
{{--                                                                $coupons = \App\Models\Offer::where('status','1')->get();--}}
{{--                                                            @endphp--}}
{{--                                                            <select id="couponCode" class="form-control">--}}
{{--                                                                <option>Select Coupon</option>--}}
{{--                                                                @forelse($coupons as $key => $coupon)--}}
{{--                                                                    <option value="{{$coupon->code}}">{{$coupon->code}} </option>--}}
{{--                                                                @empty--}}
{{--                                                                @endforelse--}}
{{--                                                            </select>--}}
{{--                                                            --}}{{----}}{{--                                                            <input type="text" class="form-control"--}}
{{--                                                            --}}{{----}}{{--                                                                   placeholder="coupon code">--}}
{{--                                                            <div class="input-group-append">--}}
{{--                                                                <button class="btn btn-outline-primary-2"--}}
{{--                                                                        type="button" id="applyCouponBtn"><i class="icon-long-arrow-right"></i></button>--}}
{{--                                                            </div><!-- .End .input-group-append -->--}}
{{--                                                        </div><!-- End .input-group -->--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
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
{{--                                                <tr>--}}
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
{{--                                            <!-- Include the sum in a hidden input field -->--}}
{{--                                            <input type="hidden" class="sLength" name="sum_length[]" value="{{ $sumLength }}"/>--}}
{{--                                            <input type="hidden" class="sWidth"  name="sum_width[]" value="{{ $sumWidth }}"/>--}}
{{--                                            <input type="hidden" class="sHeight" name="sum_height[]" value="{{ $sumHeight }}"/>--}}
{{--                                            <tr>--}}
{{--                                                <td>Sales Tax:</td>--}}
{{--                                                <td><div class="salesTaxDiv"></div></td>--}}
{{--                                            </tr>--}}
{{--                                            @if(Session::has('discounted_total'))--}}
{{--                                                    <?php $productTotal = Session::get('discounted_total'); ?>--}}
{{--                                                <input type="hidden" name="product_total" id="total-amount" value="{{$productTotal}}"/>--}}
{{--                                                <input type="hidden" name="coupon_code" value="{{Session::get('applied_coupon')}}"/>--}}
{{--                                            @else--}}
{{--                                                    <?php $productTotal = $get_count->cartTotal; ?>--}}
{{--                                                --}}{{----}}{{--                                                        {{number_format($productTotal, 2) ?? '0'}}--}}
{{--                                                <input type="hidden" name="product_total" id="total-amount" value="{{$productTotal}}"/>--}}
{{--                                            @endif--}}
{{--                                            @if(Session::has('discounted_total'))--}}
{{--                                                <tr class="summary-subtotal">--}}
{{--                                                    <td>Coupon Applied:</td>--}}
{{--                                                    <td>{{Session::get('applied_coupon')}}</td>--}}
{{--                                                </tr><!-- End .summary-subtotal -->--}}
{{--                                            @endif--}}
{{--                                            <tr class="">--}}
{{--                                                <td> Sub total:</td>--}}
{{--                                                <td>--}}
{{--                                                    @if(Session::has('discounted_total'))--}}
{{--                                                        $  {{number_format(Session::get('discounted_total'),2) ?? '0'}}--}}
{{--                                                    @else--}}
{{--                                                        {{number_format($get_count->cartTotal,2) ?? '0'}}--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td>Delivery</td>--}}
{{--                                                <td>--}}
{{--                                                    @if($get_count->cartTotal < 75)--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <select class="form-control"--}}
{{--                                                                    required id="courier-select" name="selected_courier">--}}
{{--                                                                <option></option>--}}
{{--                                                                <option value="7.99" data-name="Standard U.S Shipping (4-7 business days)">--}}
{{--                                                                    Standard U.S Shipping (4-7 business days): $7.99</option>--}}
{{--                                                                <option value="15" data-name="Priority U.S Shipping (2-3 business days)">--}}
{{--                                                                    Priority U.S Shipping (2-3 business days): $15</option>--}}
{{--                                                                <option value="20" data-name="1-Business day Shipping">--}}
{{--                                                                    1-Business day Shipping: $20</option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                    @else--}}
{{--                                                        Free Shipping--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}

{{--                                            <tr class="" colspan="1">--}}
{{--                                                <td>Shipping Cost   :</td>--}}
{{--                                                <td><span id="selected_del"></span></td>--}}

{{--                                            </tr>--}}

{{--                                            <input type="hidden" class="form-control" id="sales-tax" name="sales_tax" readonly>--}}
{{--                                            <input type="hidden" class="form-control" id="shipping-price" name="shipping_price" readonly>--}}
{{--                                            <input type="hidden" class="form-control" id="final-amount" name="final_amount" readonly>--}}
{{--                                            <input type="hidden" class="form-control" id="courier-name" name="courier_nmae" readonly>--}}

{{--                                            <tr  class="summary-subtotal">--}}
{{--                                                <td>Total:</td>--}}
{{--                                                <td><div class="finalTaxDiv"></div></td>--}}
{{--                                            </tr>--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                        <button type="submit" class="btn btn-order btn-block pb-2 pt-2--}}
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

{{--                        // alert(ptot);--}}
{{--                        // return false;--}}

{{--                        const salesTaxRate = parseFloat(result[0].total_rate);--}}
{{--                        const productTotal = parseFloat(ptot) ;--}}

{{--                        // const salesTaxRate = parseFloat(result[0].total_rate);--}}
{{--                        // const productTotal = parseFloat($('input[name="product_total"]').val());--}}
{{--                        // const totalAmount = productTotal + (productTotal * salesTaxRate);--}}

{{--                        const totalAmount = productTotal + (productTotal * salesTaxRate);--}}

{{--                        // alert(totalAmount);--}}
{{--                        // return false;--}}


{{--                        // Display calculated values with $ sign in div elements--}}
{{--                        $('.salesTaxDiv').text('$' + (productTotal * salesTaxRate).toFixed(2));--}}
{{--                        $('.finalTaxDiv').text('$' + totalAmount.toFixed(2));--}}
{{--                        // $('.salesTaxDiv').text('$' + (productTotal * salesTaxRate).toFixed(2));--}}
{{--                        // $('.finalTaxDiv').text('$' + totalAmount.toFixed(2));--}}

{{--                        // Set calculated values in input fields without $ sign--}}
{{--                        $('#sales-tax').val((productTotal * salesTaxRate).toFixed(2));--}}
{{--                        $finalAmountInput.val(totalAmount.toFixed(2));--}}

{{--                        console.log(productTotal * salesTaxRate);--}}
{{--                        // return false;--}}


{{--                        console.log(salesTaxValue);--}}
{{--                        console.log(finalTaxValue);--}}

{{--// Check if salesTaxValue or finalTaxValue is NaN--}}
{{--                        if (isNaN(parseFloat(salesTaxValue)) || isNaN(parseFloat(finalTaxValue))) {--}}
{{--                            // Disable the button--}}
{{--                            $('.btn-order').prop('disabled', true);--}}
{{--                        } else {--}}
{{--                            // Enable the button--}}
{{--                            $('.btn-order').prop('disabled', false);--}}
{{--                        }--}}
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

{{--                const salesTax = parseFloat($('#sales-tax').val());--}}

{{--                const productTotal = parseFloat($('input[name="product_total"]').val());--}}

{{--                const selectedRate = shippingPrice;--}}


{{--                if (!isNaN(productTotal)) {--}}
{{--                    if (selectedRate) {--}}
{{--                        // $shippingPriceInput.val('$' + selectedRate.total_charge);--}}
{{--                        $shippingPriceInput.val(selectedRate);--}}
{{--                        // const newFinalAmount = salesTax + productTotal + selectedRate.total_charge;--}}
{{--                        const newFinalAmount = parseFloat(salesTax) + parseFloat(productTotal) + parseFloat(selectedRate);--}}
{{--                        // alert(newFinalAmount);--}}
{{--                        // return false;--}}

{{--                        $finalAmountInput.val(newFinalAmount.toFixed(2));--}}
{{--                        $('.finalTaxDiv').text('$' + newFinalAmount.toFixed(2));--}}

{{--                        // Get the data-name attribute value of the selected option--}}
{{--                        const courierName = $selectedCourier.find(':selected').attr('data-name');--}}
{{--                        $('#courier-name').val(courierName);--}}
{{--                        $('#selected_del').text('$' + selectedRate);--}}
{{--                    } else {--}}
{{--                        $shippingPriceInput.val('N/A');--}}
{{--                        $finalAmountInput.val(productTotal.toFixed(2));--}}
{{--                        $('.finalTaxDiv').text('$' + productTotal.toFixed(2));--}}
{{--                        $('#courier-name').val('N/A');--}}
{{--                    }--}}
{{--                } else {--}}
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
