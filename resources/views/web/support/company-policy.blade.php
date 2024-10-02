<?php $getCommonSetting = getCommonSetting();?>

<?php
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.
$url.= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$url.= $_SERVER['REQUEST_URI'];


?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include elevateZoom script and CSS -->
<script src="https://cdn.jsdelivr.net/npm/elevatezoom.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/elevatezoom.js/dist/jquery.elevateZoom.css">

<!-- Your other head elements -->
@extends('layouts.web')
@section('css')
    <style>
        .sticky_header{
            position:unset;
        }
        .watch_header + main {
            margin-top: 0px;
        }
        ul.nav.ul_li_block.clearfix li a img {
            width: 100%;
            height: 100px;
            float: left;
        }
        div#filteredProducts {
            width: 89%;
            margin: 0 auto;
        }
        .shop_details_image img {
            width: 100%;
            display: block;
            max-width: 100%;
            max-height: 600px;
            object-fit: contain;
        }

        .nav_wrap {
            height: auto;
            overflow-y: scroll;
        }
        @media only screen and (min-width: 320px) and (max-width: 767px){
            .deco_image.d-sm-none.d-xs-none{
                display: none;
            }
            .ce_breadcrumb_nav li:not(:last-child) {
                margin-right: 10px;
                padding-right: 10px;
            }
            .furniture_details .nav_wrap .nav li {
                float: left;
                width: 25%;
                display: inline-block;
                margin: 5px;
            }
            ul.nav.ul_li_block.clearfix li a img {
                width: 100%;
                height: 70px;
                float: left;
            }
            .shop_details_content .item_title {
                font-size: 22px;
            }
            ul.btns_group_1.ul_li.mb_30 li {
                display: contents;
            }


        }

        .content{
            background-color:white;
            width:500px;
            height:500px;
        }
        img{
            width: 100%;
            height: 25%;
        }
        .form-title{
            padding:10px 40px 0px;
        }
        form{
            padding:0px 40px;
        }
        input[type=text], [type=email]{
            border: none;
            border-bottom: 1px solid black;
            outline:none;
            width:100%;
            margin: 8px 0;
            padding:10px 0;
        }
        input[type=number]{
            border: none;
            border-bottom: 1px solid black;
            outline:none;
            margin: 8px 0;
            padding:5px 0;
        }
        input :hover {
            background-color: red;
        }
        select{
            border: none;
            border-bottom: 1px solid black;
            outline:none;
            margin: 8px 0;
            padding:5px 0;
            width:50%;
        }
        .beside{
            display:flex;
            justify-content: space-between;
        }
        button{
            color:#ffffff;
            background-color: #4caf50;
            height:40px;
            width:25%;
            margin-top:15px;
            cursor: pointer;
            border:none;
            border-radius:2%;
            outline:none;
            text-align:center;
            font-size:16px;
            text-decoration:none;
            -webkit-transition-duration:0.4s;
            transition-duration:0.4s;
        }
        button:hover{
            background-color:#333333;
        }

        .nice-select.form-control.ms {
            width: 100%;
            height: 55px;
        }
        .home_watch .custom_btn {
            padding: 10px 35px;
            text-align: center;
            display: block;
            margin: 0 auto;
        }
        .main_contact_section .form_item input, .main_contact_section .form_item textarea {
            background-color: #f3f4f6;
            padding: 15px;
        }
        .track_order{
            width: 70%;
            margin: 0 auto;
        }

        .form_item {
            background: #fff;
            border-radius: 4px;
            /*padding-bottom: 100%;*/
        }
        .form_item a {
            color: #fff;
            font-size: 22px;
        }
    </style>
@stop
@section('body')
    <?php
    $get_hero_banner = get_hero_banner();
    $getCommonSetting = getCommonSetting();
//    ?>


    <section class="main_contact_section sec_ptb_100 clearfix">
        <div class="container">
            <div class="row justify-content-lg-between">

                <div class="col-lg-12">
                    <div class="main_contact_form">
                        <h3 class="title_text mb_30 text-center">Company Policy</h3>


                        <style>
                            .card{

                                width: 100%;
                                border:none;
                                /*height: 320px;*/
                                border-radius: 15px;
                                padding: 20px;
                                background-color: #D50000;
                                color:#fff;
                            }

                            .percent{

                                font-size: 40px;
                                color: #fff;
                            }

                            .discount{

                                font-size: 27px;
                                color: #fff;
                            }

                            .line{

                                color: #fff;
                            }
                            h1.mb-0.percent a {
                                color: #fff;
                            }
                            .form-check-input:checked {
                                background-color: #F44336;
                                border-color: #F44336;
                            }


                            .form-check-input:focus {
                                border-color: #d50000;
                                outline: 0;
                                box-shadow: none;
                            }


                            .form-check {
                                display: block;
                                min-height: 1.5rem;
                                padding-left: 1.75em;
                                margin-bottom: -5px;
                            }
                        </style>
                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <div class="card">
                                        <div class="text-center">
                                            <div class="d-flex1 flex-row1 text-center">
                                                <div class="d-flex flex-column ml-1">
                                                    <h4 class="mb-0 percent">
                                                        <a href="{{url('privacy-policy')}}">
                                                            Privacy Policy
                                                        </a>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <div class="card">
                                        <div class="text-center">
                                            <div class="d-flex1 flex-row1 text-center">
                                                <div class="d-flex flex-column ml-1">
                                                    <h4 class="mb-0 percent">
                                                        <a href="{{url('privacy-policy')}}">
                                                            Terms & Conditions
                                                        </a>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <div class="card">
                                        <div class="text-center">
                                            <div class="d-flex1 flex-row1 text-center">
                                                <div class="d-flex flex-column ml-1">
                                                    <h4 class="mb-0 percent">
                                                        <a href="{{url('shipping-policy')}}">
                                                            Shipping
                                                            Policy
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <div class="card">
                                        <div class="text-center">
                                            <div class="d-flex1 flex-row1 text-center">
                                                <div class="d-flex flex-column ml-1">
                                                    <h4 class="mb-0 percent">
                                                        <a href="{{url('refund-policy')}}">
                                                            Refund
                                                            Policy
                                                        </a>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <div class="card">
                                        <div class="text-center">
                                            <div class="d-flex1 flex-row1 text-center">
                                                <div class="d-flex flex-column ml-1">
                                                    <h4 class="mb-0 percent">
                                                        <a href="{{url('return-policy')}}">
                                                            Return
                                                            Policy
                                                        </a>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>

@stop
@section('script')


@stop
