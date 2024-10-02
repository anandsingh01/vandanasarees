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
      /*.main_contact_section  button{*/
      /*      color:#ffffff;*/
      /*      height:40px;*/
      /*      width:10%;*/
      /*      margin-top:15px;*/
      /*      cursor: pointer;*/
      /*      border:none;*/
      /*      border-radius:2%;*/
      /*      outline:none;*/
      /*      text-align:center;*/
      /*      font-size:16px;*/
      /*      text-decoration:none;*/
      /*      -webkit-transition-duration:0.4s;*/
      /*      transition-duration:0.4s;*/
      /*  }*/

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
        .nice-select{
            width:100%;
        }

        #newTicketModal .modal-footer button{
            width:40%;
        }

        #newTicketModal button.close{
            color:#000;
        }

        #newTicketModal .modal-dialog {
            max-width: 74%;
            margin: 1.75rem auto;
        }
    </style>
@stop
@section('body')
    <?php
    $get_hero_banner = get_hero_banner();
    $getCommonSetting = getCommonSetting();
//    ?>

    <style>
        .main_contact_section .card-1{
            box-shadow: 2px 4px 15px 0px #ddd;
        }


        .main_contact_section  .small{
            font-size: 9px !important;
        }

        .main_contact_section .cursor-pointer{
            cursor: pointer;
        }

        .main_contact_section .btn-round-lg {
            border-radius: 22.5px;
            background-color: #eee;
            color: #3D5AFE;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.9px;
            padding: 8px 20px  8px  20px !important;
            border: 1px solid #fff;
            width:100%;
        }

        .main_contact_section .btn-round-lg:hover{
            background-color: #fff;
            color: #3D5AFE;
            border: 1px solid #fff;
        }

        .main_contact_section .btn-round-lg:focus{
            border: 1px solid #fff !important;
        }

       .main_contact_section .card{
            background-color: #fff !important;
            color: white;
        }
        img.irc_mi.img-fluid.mr-0 {
            padding: 1em;
        }
    </style>

    <section class="main_contact_section sec_ptb_100 clearfix">
{{--        <div class="container">--}}
            <div class="container d-flex justify-content-center">
                <div class="row">
                    <div class="col-md-12">
                        @if(Session::has('register_success'))
                            <div class="alert alert-success">{{Session::get('register_success')}}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="card shaodw-lg  card-1">

                            <div class="card-body  d-flex pt-0">
                                <div class="row no-gutters  mx-auto justify-content-start flex-sm-row flex-column">
                                    <div class="col-md-4  text-center"><img class="irc_mi img-fluid mr-0" src="https://cdn4.iconfinder.com/data/icons/logistics-delivery-2-5/64/137-512.png"  width="150" height="150"></div>
                                    <div class="col-md-8 ">

                                        <div class="card border-0 ">
                                            <div class="card-body">
                                                <h5 class="card-title "><b>Raises Ticket</b></h5>
                                                <p class="card-text "><p>In the event that you face any issues with your Grooves Lifestyle product, please contact us and raise a ticket by clicking below.
                                                    Our service team will be delighted to help you.</p></p>
                                                <!-- Button to trigger modal -->
                                                <button type="button" class="btn btn-primary btn-round-lg btn-lg" data-toggle="modal" data-target="#newTicketModal">Claim Warranty</button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="newTicketModal" tabindex="-1" role="dialog" aria-labelledby="newTicketModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="newTicketModalLabel">New Ticket</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <style>
                                                                    #claimwarranty label {
                                                                        color: #000;
                                                                    }
                                                                </style>
                                                                <form id="claimwarranty" action="{{url('claim-warranty')}}" method="post" enctype="multipart/form-data">
@csrf
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="mobileNumber">Name</label>
                                                                                <input type="text" class="form-control" id="name" name="name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="mobileNumber">Mobile Number</label>
                                                                                <input type="text" class="form-control" id="mobileNumber" name="phone">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="emailAddress">Email Address</label>
                                                                                <input type="email" class="form-control" id="emailAddress" name="email">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="email">Date Of Purchase</label>
                                                                                <input type="date" class="form-control" id="dateofpurchase" name="purchased_date">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                                            <div class="form-group">
                                                                                <label>Invoice number</label>
                                                                                <input type="text"
                                                                                       class="form-control" name="invoice_number" placeholder="Invoice Number">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">

                                                                            <div class="form-group">
                                                                                <label for="email">Product Category</label>
                                                                                <select class="form-control" name="product_category">
                                                                                    @forelse($category as $categories)
                                                                                        <option value="{{$categories->category_name}}">{{$categories->category_name}}</option>
                                                                                    @empty
                                                                                    @endforelse
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">

                                                                            <div class="form-group">
                                                                                <label for="email">Point of Purchase</label>
                                                                                <select class="form-control" id="pointofpurchase" name="point_of_purchase">
                                                                                    <option value="Amazon">Amazon</option>
                                                                                    <option value="Flipkart">Flipkart</option>
                                                                                    <option value="Website">Website</option>
                                                                                    <option value="Other">Other</option>
                                                                                    <!-- Add more options as needed -->
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">

                                                                            <div class="form-group">
                                                                                <label for="issueCategory">Issue Category</label>

                                                                                <br>
                                                                                <select class="form-control" id="issueCategory" name="issueCategory">
                                                                                    <option value="technical">Technical Issue</option>
                                                                                    <option value="billing">Billing Issue</option>
                                                                                    <option value="damaged_product">Damaged Product</option>
                                                                                    <option value="damaged_product">Wrong Product</option>
                                                                                    <!-- Add more options as needed -->
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-md-12">
                                                                            <label>Description</label>
                                                                            <textarea name="description" class="form-control"></textarea>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label>Image</label>
                                                                            <input type="file" name="images" class="form-control"/>
                                                                        </div>
                                                                    </div>




                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                                    </div>
                                                                    <!-- Add more fields as needed -->
                                                                </form>
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

                    <div class="col-md-6">
                        <div class="card shaodw-lg  card-1">

                            <div class="card-body  d-flex pt-0">
                                <div class="row no-gutters  mx-auto justify-content-start flex-sm-row flex-column">
                                    <div class="col-md-4  text-center"><img class="irc_mi img-fluid mr-0" src="https://cdn4.iconfinder.com/data/icons/logistics-delivery-2-5/64/137-512.png"  width="150" height="150"></div>
                                    <div class="col-md-8 ">
                                        <div class="card border-0 ">
                                            <div class="card-body">
                                                <h5 class="card-title "><b>Call us</b></h5>
                                                <p class="card-text ">
                                                <p>
                                                    In case you have already raised a ticket for your concerns regarding our product or service,
                                                    please track the real-time status of the ticket by using the link below.
                                                </p>
                                                <a href="tel:/{{$getCommonSetting->contact_phone}}" type="button" class="btn btn-primary btn-round-lg btn-lg"> Call Now </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{--        </div>--}}
    </section>

@stop
@section('script')


@stop
