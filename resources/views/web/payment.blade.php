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
        .heading {
            margin: 1.1rem 0 0;
        }
        .summary {
            padding: 2.5rem 3rem 3rem;
            border: 0.1rem dashed #d7d7d7;
            background-color: #f9f9f9;
            border-radius: 0.3rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        hr.fav_hr {
            width: 11%;
            border: 1px solid;
        }

        .title{
            font-size: 2rem;
        }
        .heading .title {
            font-size: 2.4rem;
            letter-spacing: -.025em;
        }
    </style>
@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();
    ?>
    <main class="main">
{{--        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">--}}
{{--            <div class="container">--}}
{{--                <h1 class="page-title">Checkout <span></span></h1>--}}
{{--            </div><!-- End .container -->--}}
{{--        </div><!-- End .page-header -->--}}

        <div class="heading heading-center mb-3">
            <h2 class="title mb-1">PAYMENT</h2>
            <hr class="fav_hr">

        </div>
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment</li>
                </ol>

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
{{--                        <?php--}}
{{--                        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard';--}}
{{--                        ?>--}}
{{--                        <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="backBtn" >Back </a>--}}
                    </div>
                </div>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <div class="row">

                        <div class="col-md-8">
                            <div class="payment_image  mb-2">
                                <img src="data:image/png;base64,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" style="    width: 35%;
    height: 70px;">
                            </div>
                            <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                                  data-cc-on-file="false"
                                  data-stripe-publishable-key="pk_live_51NUiUUIDs9T2ySQhRcBpyW5hrtfK31RUXheVR1XO3wSz2CvckYrZ0YXhQQV7abLASxPrjK3pLHsASdFEBefDNjIV00BdOtJvON"
                                  id="payment-form">
                                @csrf

                                <input type="hidden" name="order_id" value="{{$order_id}}"/>
                                <input type="hidden" name="order_primary_key" value="{{$order_primary_key}}"/>
                                <div class='form-row row'>
                                    <div class='col-md-6 form-group required'>
                                        <label class='control-label'>Name on Card</label>
                                        <input class='form-control' required size='4' name="name_on_card" type='text'>
                                    </div>

                                    <div class='col-md-6 form-group required'>
                                        <label class='control-label'>Card Number</label>
                                        <input autocomplete='off' name="card_no" required  class='form-control card-number' size='20' type='text'>
                                    </div>

                                    <div class='col-xs-6 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label>
                                        <input autocomplete='off' name="cvc" required  class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                                    </div>

                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label>
                                        <input class='form-control card-expiry-month' name="exp_month" required  placeholder='MM' size='2' type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label>
                                        <input class='form-control card-expiry-year' name="exp_year" required  placeholder='YYYY' size='4' type='text'>
                                    </div>
                                </div>

                                *We do not save your data.

                                <div class="row">
                                    <div class="col-xs-12">
                                        <button class="
                                        btn btn-block pb-2 pt-2
                                   btn-outline-primary-2
                                   " type="submit">Pay Now</button>
                                    </div>

{{--                                    <?php--}}
{{--                                    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard';--}}
{{--                                    ?>--}}
{{--                                    <a href="{{ url($referer) }}" class="btn btn-lg btn-raised btn-danger waves-effect" >Back</a>--}}



                                </div>

                            </form>

                        </div>
                        <div class="col-md-4">
                            <div class="summary summary-cart">
                                @if(Session::has('products_details'))
                                        <?php
                                        $productDetailsSession = Session::get('products_details');
//                                        print_r($productDetailsSession);
//                                        die;
                                        ?>
                                @endif

                                <table class="table table-summary">
                                    <tr>
                                        <td>Cart Amount :</td>
{{--                                        <td>$<?php echo $productDetailsSession['product_total'];?></td>--}}
                                        <td>Rs. <?php echo $productDetailsSession['subtotal'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Amount :</td>
                                        <td>Rs. <?php echo $productDetailsSession['shipping_price'] ?? '0.00';?></td>
                                    </tr>
                                    <tr>
                                        <td>Sales Tax :</td>
{{--                                        <td>$<?php echo $productDetailsSession['sales_tax'];?></td>--}}
                                    </tr>

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>Rs. <?php echo $productDetailsSession['final_amount'];?></td>
                                    </tr><!-- End .summary-total -->
                                </table>
                            </div>

                        </div>

                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </main>
@stop
@section('js')

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script>
        $(document).ready(function() {
            $('.errordiv').addClass('hide');
        });
    </script>

    <script type="text/javascript">
        $(function() {

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
@stop
