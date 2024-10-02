@extends('layouts.web')
<?php
session_start();
?>
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>

        .faq-section {
            /*background: #fdfdfd;*/
            min-height: 100vh;
            padding: 10vh 0 0;
        }

        .faq-title h2 {
            position: relative;
            margin-bottom: 45px;
            display: inline-block;
            font-weight: 600;
            line-height: 1;
        }
        .faq-title h2::before {
            content: "";
            position: absolute;
            left: 50%;
            width: 60px;
            height: 2px;
            background: #E91E63;
            bottom: -25px;
            margin-left: -30px;
        }
        .faq-title p {
            padding: 0 190px;
            margin-bottom: 10px;
        }

        .faq {
            background: #FFFFFF;
            box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.06);
            border-radius: 4px;
        }

        .faq .card {
            border: none;
            background: none;
            border-bottom: 1px dashed #CEE1F8;
        }

        .faq .card .card-header {
            padding: 0px;
            border: none;
            background: none;
            -webkit-transition: all 0.3s ease 0s;
            -moz-transition: all 0.3s ease 0s;
            -o-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
        }

        .faq .card .card-header:hover {
            background: rgb(23, 48, 84);
            padding-left: 10px;
        }
        .faq .card .card-header .faq-title {
            width: 100%;
            text-align: left;
            padding: 0px;
            padding-left: 30px;
            padding-right: 30px;
            font-weight: 400;
            font-size: 15px;
            letter-spacing: 1px;
            color: #3B566E;
            text-decoration: none !important;
            -webkit-transition: all 0.3s ease 0s;
            -moz-transition: all 0.3s ease 0s;
            -o-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
            cursor: pointer;
            padding-top: 10px;
            padding-bottom: 10px;
        }


        .faq .card .card-header .faq-title .badge {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 14px;
            float: left;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
            text-align: center;
            background: unset;
            color: #fff;
            font-size: 12px;
            margin-right: 20px;
        }

        .faq .card .card-body {
            padding: 30px;
            padding-left: 35px;
            padding-bottom: 16px;
            font-weight: 400;
            font-size: 16px;
            color: #6F8BA4;
            line-height: 28px;
            letter-spacing: 1px;
            border-top: 1px solid #F3F8FF;
        }

        .faq .card .card-body p {
            margin-bottom: 14px;
        }

        @media (max-width: 991px) {
            .faq {
                margin-bottom: 30px;
            }
            .faq .card .card-header .faq-title {
                line-height: 26px;
                margin-top: 10px;
            }
        }
        .faq .card .card-header:hover h5.faq-title{
            color:#fff !important;
        }

        #privacy_policy, #privacy_policy p, #privacy_policy span{
            padding: 0px 0;
            font-family: 'Albert Sans', sans-serif !important;
        }

        .faq .card .card-header:hover #privacy_policy,
        .faq .card .card-header:hover #privacy_policy p,
        .faq .card .card-header:hover #privacy_policy span{
            color:#fff !important;
        }
        .card-header:hover .badge{
            color:#fff !important;
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
                    <li class="breadcrumb-item active" aria-current="page">FAQ's</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="" style="background-image: url('assets/images/backgrounds/login-bg.jpg');
        margin-bottom:15px;
        padding-bottom:15px;
        ">
            <div class="container"  id="privacy_policy">
                <div class="row">
                    <div class="col-md-12">
                        <section class="faq-section">
                            <div class="container">
                                <div class="row">
                                    <!-- ***** FAQ Start ***** -->
                                    <div class="col-md-6 offset-md-3">

                                        <div class="faq-title text-center pb-3">
                                            <h2>FAQ's</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6 offset-md-3">
                                        <div class="faq" id="accordion">
                                            @forelse($faq as $key => $faqs)
                                            <div class="card">
                                                <div class="card-header" id="faqHeading-{{$key+1}}">
                                                    <div class="mb-0">
                                                        <h5 class="faq-title" data-toggle="collapse"
                                                            data-target="#faqCollapse-{{$key+1}}" data-aria-expanded="true"
                                                            data-aria-controls="faqCollapse-{{$key+1}}">
                                                            <span class="badge">{{$key+1}}</span>
                                                            {{$faqs->heading}}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div id="faqCollapse-{{$key+1}}" class="collapse"
                                                     aria-labelledby="faqHeading-{{$key+1}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <p><?php echo $faqs->metal_content;?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div><!-- End .container -->
        </div><!-- End .login-page section-bg -->
    </main>

@stop
@section('js')

@stop
