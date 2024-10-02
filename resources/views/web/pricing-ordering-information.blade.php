@extends('layouts.web')
<?php
session_start();
$getCommonSetting = getCommonSetting();
?>
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@100;300;400;500;600&display=swap" rel="stylesheet">
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

        #privacy_policy , #privacy_policy p{
            color:#000;
            font-size: 16px;
        }
        #privacy_policy h3{
            color: #173054;
            font-weight: 600;
        }
        #privacy_policy, #privacy_policy h1, #privacy_policy h2, #privacy_policy h3,
        #privacy_policy h4, #privacy_policy h5,#privacy_policy h6,#privacy_policy p,
        #privacy_policy div,#privacy_policy span,#privacy_policy a, #privacy_policy label, h1.page-title{
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 400;
        }
    </style>

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

        #privacy_policy{
            color:#000;
            font-size: 16px;
        }
        #privacy_policy h3{
            color: #173054;
            text-align: left;
            font-weight: 600;
        }
        div#privacy_policy {
            padding: 15px;
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
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pricing Information</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="" style="background-image: url('assets/images/backgrounds/login-bg.jpg')">
            <div class="container"  id="privacy_policy">
                <div class="row">

                    <div class="col-md-12">
                        <?php
                        echo $getCommonSetting->price_info_content;
                        ?>
                       <br>

                    </div>
                </div>
            </div><!-- End .container -->
        </div><!-- End .login-page section-bg -->
    </main>

@stop
@section('js')

@stop
