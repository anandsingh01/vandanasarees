@extends('layouts.web')
<?php
session_start();
?>
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
        div#tab-content-7 {
            width: 75%;
        }
        .table th, .table thead th, .table td {
            border-top: none;
            border-bottom: 0.1rem solid #ebebeb;
            text-align: center;
            padding: 15px;
        }

        table#example thead {
            background: #173054;
        }
        .table th, .table thead th {
            color: #fff;
        }
        table#example thead {
            background: #173054;
        }
        .table th, .table thead th {
            color: #fff;
        }
        .table th, .table thead th {
            color: #fff;
            font-size: 18px;
        }
    </style>
@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();
    ?>

        <!-- breadcrumb_section - start
       ================================================== -->
    <section class="breadcrumb_section text-white text-center text-uppercase d-flex align-items-end clearfix"
             data-background="{{asset('images/webp/74651700935498.webp')}}">
        <div class="overlay" data-bg-color="#1d1d1d"></div>
        <div class="container">
            <h1 class="page_title text-white">My Orders</h1>
            <ul class="breadcrumb_nav ul_li_center clearfix">
                <li><a href="#!">Home</a></li>
                <li>My Orders</li>
            </ul>
        </div>
    </section>
    <!-- breadcrumb_section - end
       ================================================== -->

    <main class="main">
        <div class="page-content">
            <div class="container">
                <h3 class="text-center">Welcome {{Auth::user()->name}}</h3>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>NO.</th>
                                <th>ORDER ID</th>
                                <th>USER</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(!empty($orders))
                                @foreach($orders as $key =>  $order)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>Order Id -  {{$order->order_id}}</td>
                                        <td>
                                            Name - {{$order->first_name}}, {{$order->last_name}} <br>
                                            Address - {{$order->address_1}}, {{$order->address_2}},
                                            {{$order->city}}, {{$order->state}}, {{$order->pincode}},<br>
                                            Phone - {{$order->phone}}<br>
                                            Email - {{$order->email}}
                                        </td>
                                        <td>
                                            @if($order->status == 0)
                                                <span class="badge badge-warning">New </span>
                                            @endif

                                            @if($order->status == 1)
                                                <p class="badge badge-success">Paid </p>
                                            @endif

                                            @if($order->status == 2)
                                                <span class="badge badge-primary">Shipped </span>
                                            @endif

                                            @if($order->status == 3)
                                                <span class="badge badge-warning">Transit  </span>
                                            @endif

                                            @if($order->status == 4)
                                                <span class="badge badge-success">Delivered </span>
                                            @endif

                                            @if($order->status == 5)
                                                <span class="badge badge-danger">Cancelled </span>
                                            @endif

                                            @if($order->status == 6)
                                                <span class="badge badge-danger">Failed </span>
                                            @endif
                                        </td>
                                        <td class="" style="">
                                            <a href="{{url('view-orders/'.$order->id)}}"
                                               class="btn btn-primary waves-effect waves-float btn-sm waves-green">
                                                View</a> <br>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div><!-- End .page-content -->
    </main>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#register-confirm-password').on('input', function() {
                var password = $('#register-password').val();
                var confirmPassword = $(this).val();

                if (password === confirmPassword) {
                    $('#password-match-message').text('Passwords match').css('color', 'green');
                } else {
                    $('#password-match-message').text('Passwords do not match').css('color', 'red');
                }
            });

            $('form').on('submit', function(event) {
                var password = $('#register-password').val();
                var confirmPassword = $('#register-confirm-password').val();

                if (password !== confirmPassword) {
                    event.preventDefault();
                    $('#password-match-message').text('Passwords do not match').css('color', 'red');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script>
        $(document).ready(function() {
            //Only needed for the filename of export files.
            //Normally set in the title tag of your page.
            document.title='User Dashboard';
            // DataTable initialisation
            $('#example').DataTable(
                {
                    "dom": '<"dt-buttons"Bf><"clear">lirtp',
                    "paging": true,
                    "autoWidth": true,
                    "buttons": [
                        'colvis',
                        'copyHtml5',
                        'csvHtml5',
                        'excelHtml5',
                        'pdfHtml5',
                        'print'
                    ]
                }
            );
        });
    </script>

@stop
