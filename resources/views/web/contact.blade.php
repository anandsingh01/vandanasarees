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
        .item.slick-slide{
            margin:0;
        }

    </style>
<style>
    body{
        color:#fff
    }
    .right_conatct_social_icon{
        background: linear-gradient(to top right, #1325e8 -5%, #8f10b7 100%);
    }
    .contact_us{
        background-color: #f1f1f1;
        padding: 120px 0px;
    }

    .contact_inner{
        background-color: #fff;
        position: relative;
        box-shadow: 20px 22px 44px #cccc;
        border-radius: 25px;
    }
    .contact_field{
        padding: 60px 340px 90px 100px;
    }
    .right_conatct_social_icon{
        height: 100%;
    }

    .contact_field h3{
        color: #000;
        font-size: 40px;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 10px
    }
    .contact_field p{
        color: #000;
        /*font-size: 13px;*/
        font-weight: 400;
        letter-spacing: 1px;
        margin-bottom: 35px;
    }
    .contact_field .form-control{
        border-radius: 0px;
        border: none;
        border-bottom: 1px solid #ccc;
    }
    .contact_field .form-control:focus{
        box-shadow: none;
        outline: none;
        border-bottom: 2px solid #1325e8;
    }
    .contact_field .form-control::placeholder{
        /*font-size: 13px;*/
        letter-spacing: 1px;
    }

    .contact_info_sec {
        position: absolute;
        background-color: #2d2d2d;
        right: 1px;
        top: 18%;
        height: 340px;
        width: 340px;
        padding: 40px;
        border-radius: 25px 0 0 25px;
    }
    .contact_info_sec h4{
        letter-spacing: 1px;
        padding-bottom: 15px;
    }

    .info_single{
        margin: 30px 0px;
    }
    .info_single i{
        margin-right: 15px;
    }
    .info_single span{
        /*font-size: 14px;*/
        letter-spacing: 1px;
    }

    button.contact_form_submit {
        background: linear-gradient(to top right, #1325e8 -5%, #8f10b7 100%);
        border: none;
        color: #fff;
        padding: 10px 15px;
        width: 100%;
        margin-top: 25px;
        border-radius: 35px;
        cursor: pointer;
        /*font-size: 14px;*/
        letter-spacing: 2px;
    }
    .socil_item_inner li{
        list-style: none;
    }
    .socil_item_inner li a{
        color: #fff;
        margin: 0px 15px;
        /*font-size: 14px;*/
    }
    .socil_item_inner{
        padding-bottom: 10px;
    }

    .map_sec{
        padding: 50px 0px;
    }
    .map_inner h4, .map_inner p{
        color: #000;
        text-align: center
    }
    .map_inner p{
        /*font-size: 13px;*/
    }
    .map_bind{
        margin-top: 50px;
        border-radius: 30px;
        overflow: hidden;
    }
</style>
@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();
    ?>

    <section class="contact_us">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="contact_inner">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="contact_form_inner">
                                    <div class="contact_field">
                                        <h3>Contatc Us</h3>
                                        <p>Feel Free to contact us any time. We will get back to you as soon as we can!.</p>
                                        <input type="text" class="form-control form-group" placeholder="Name" />
                                        <input type="text" class="form-control form-group" placeholder="Email" />
                                        <textarea class="form-control form-group" placeholder="Message"></textarea>
                                        <button class="contact_form_submit">Send</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="right_conatct_social_icon d-flex align-items-end">
                                    <div class="socil_item_inner d-flex">
                                        <li><a href="#"><i class="fab fa-facebook-square"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="contact_info_sec" style="background: #efeee9;">
                            <h4>Contact Info</h4>
                            <div class="d-flex info_single align-items-center">
                                <i class="fas fa-headset"></i>
                                <span>+91 8009 054294</span>
                            </div>
                            <div class="d-flex info_single align-items-center">
                                <i class="fas fa-envelope-open-text"></i>
                                <span>info@flightmantra.com</span>
                            </div>
                            <div class="d-flex info_single align-items-center">
                                <i class="fas fa-map-marked-alt"></i>
                                <span>1000+ Travel partners and 65+ Service city across India, USA, Canada & UAE</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="map_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="map_inner">
                        <h4>Find Us on Google Map</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quo beatae quasi assumenda, expedita aliquam minima tenetur maiores neque incidunt repellat aut voluptas hic dolorem sequi ab porro, quia error.</p>
                        <div class="map_bind">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d471220.5631094339!2d88.04952462217592!3d22.6757520733225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1596988408134!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    {{--    <main class="main">--}}
{{--        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">--}}
{{--            <div class="container">--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
{{--                    <li class="breadcrumb-item active" aria-current="page">Contact</li>--}}
{{--                </ol>--}}
{{--            </div><!-- End .container -->--}}
{{--        </nav><!-- End .breadcrumb-nav -->--}}

{{--        <div class="enquiry-form login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('assets/images/backgrounds/login-bg.jpg')">--}}
{{--            <div class="container">--}}

{{--                <div class="form-box">--}}
{{--                    @if(Session::has('success'))--}}
{{--                        <div class="col-6 col-lg-4 col-xl-2 text-center">--}}
{{--                            <div class="btn-wrap">--}}
{{--                                <span>{{Session::get('success')}}</span>--}}
{{--                                --}}{{--                            <a href="#" class="btn btn-outline-primary btn-rounded"><i class="icon-long-arrow-right"></i><span>Button text</span></a>--}}
{{--                            </div><!-- End .btn-wrap -->--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <div class="form-tab">--}}
{{--                        <ul class="nav nav-pills nav-fill" role="tablist">--}}
{{--                            <li class="nav-item">--}}
{{--                                <h4>Contact Us</h4>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <style>--}}
{{--                            a#signin-tab h4 {--}}
{{--                                font-weight: 600 !important;--}}
{{--                                color: #173054;--}}
{{--                            }--}}
{{--                        </style>--}}

{{--                        @if(Session::has('enquiry_sent'))--}}
{{--                            <div class="alert alert-info text-center">--}}
{{--                                {{Session::get('enquiry_sent')}}--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <div class="tab-content" id="tab-content-5">--}}
{{--                            <p>Note : Please contact us directly for wholesale or bulk order of above 15 pieces.</p>--}}
{{--<?php--}}
{{--$conn = mysqli_connect('localhost',env('DB_USERNAME'),env('DB_PASSWORD'),env('DB_DATABASE'));--}}

{{--$query= mysqli_query($conn, "SELECT * FROM `settings`");--}}
{{--while($row=mysqli_fetch_array($query)){--}}
{{--	$email=$row['contact_email'];--}}
{{--	$phone=$row['contact_phone'];--}}
{{--}--}}


{{--?>--}}
{{--                            <br><div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">--}}
{{--                                <div class="cta-content-area">--}}
{{--                                    <h5 class="text-black font-25">--}}
{{--                                        <a href="mailto://info@lifragrances.com ">--}}
{{--                                            <i class="fa fa-envelope"></i> Email: <span>   <?php echo $email ?> </span>--}}
{{--                                        </a>--}}
{{--                                    </h5>--}}
{{--                                    <br>--}}

{{--                                    <h5 class="text-black font-25">--}}
{{--                                        <a href="tel://<?php echo $phone ?>">--}}
{{--                                        <i class="fa fa-phone"></i> Phone: <span>  <?php echo $phone ?> </span>--}}
{{--                                        </a>--}}
{{--                                    </h5>--}}
{{--                                    <br>--}}

{{--                                    <div class="social_icon" style="    text-align: center;">--}}
{{--                               <span class="text-black  font-25" style="margin:15px;">--}}
{{--                                         <a href="https://www.facebook.com/Long-Island-Fragrances-117685804710901"--}}
{{--                                            target="_blank"><i class="fa fa-facebook"></i></a> </span>--}}
{{--                                        <span class="text-black  font-25" style="margin:15px;">--}}
{{--                                            <a href="https://www.instagram.com/longisland_fragrances/" target="_blank"><i class="fa fa-instagram"></i></a></span>--}}
{{--                                    </div>--}}


{{--                                </div>--}}
{{--                            </div><!-- .End .tab-pane -->--}}

{{--                        </div><!-- End .tab-content -->--}}
{{--                    </div><!-- End .form-tab -->--}}
{{--                </div><!-- End .form-box -->--}}
{{--            </div><!-- End .container -->--}}
{{--        </div><!-- End .login-page section-bg -->--}}
{{--    </main>--}}




@stop
@section('js')

@stop
