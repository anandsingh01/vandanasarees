@extends('layouts.web')
<?php
session_start();
if(!Auth::check()){
    return redirect(url('login'));
}
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


    </style>

    <style>
        :root {
            --theme-yellow:   #FEE715FF;
            --theme-black:    #101820FF;
            --theme-gray:       #8892B0;

        }

        /* SECTION VERTICAL TABS */
        #experienceTab.nav-pills .nav-link.active {
            color: #000;
            background-color: transparent;
            border-radius: 0px;
            border-left: #000;
        }
        #experienceTab.nav-pills .nav-link {
            border-radius: 0px;
            bottom: 2px solid #000;
        }
        .date-range {
            letter-spacing: 0.01em;
            color: var(--theme-gray);
        }

        section.body_yield_div {
            background: #f1f1f1;
        }

        label {
            color: #000;
        }

        .container.userdash {
            background: #fff;
            border-radius: 10px;
            padding: 2em 0;
        }
        ul#experienceTab {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .col-md-10.use {
            /* padding: 15px; */
            background: #f1f1f1;
            border-radius: 10px;
            padding: 3em;
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
        <div class="page-content">
            @if(Auth::user()->status == '0')
            <p class="text-danger text-center">
                Verification Email has been sent. Please verify your email.
                <a href="{{url("resent-email-verification")}}">Click here to resent</a>
            </p>
            @endif
            <div class="container userdash">

                <h3 class="text-center">Welcome, {{ucwords(Auth::user()->name)}}</h3>

                <div class="row p-5">
                    <div class="col-md-2 mb-3">
                        <ul class="nav nav-pills flex-column" id="experienceTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#snit" role="tab"
                                   aria-controls="home" aria-selected="true"> <i class="fa fa-home text-dark"></i>  Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="order-tab" data-toggle="tab" href="#order" role="tab"
                                   aria-controls="profile" aria-selected="false"><i class="fa fa-list text-dark"></i> Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="wishlist-tab" data-toggle="tab" href="#wishlist" role="tab"
                                   aria-controls="profile" aria-selected="false">  <i class="fa fa-heart text-dark"></i>  Wishlist</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="wishlist-tab" data-toggle="tab" href="#address" role="tab"
                                   aria-controls="address" aria-selected="false">  <i class="fa fa-heart text-dark"></i>  Address </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                   class="nav-link" title="Sign Out">
                                    <i class="fal fa-sign-out-alt"></i>   Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    <!-- /.col-md-4 -->
                    <div class="col-md-10 use">
                        <div class="tab-content" id="experienceTabContent">

                            <div class="tab-pane fade show active text-left text-light" id="snit" role="tabpanel" aria-labelledby="home-tab">
                                <div class="profile-section">
                                    <div class="row g-5">

                                        @if(session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        <form action="{{ url('update-profile') }}" method="post">

                                            @csrf

                                            <div class="form-group">
                                                <label for="register-name">Name  *</label>
                                                <input type="text" class="form-control" id="register-name"
                                                       name="name" value="{{Auth::user()->name}}" required readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="register-email">Your email address *</label>
                                                <input type="email" class="form-control" id="register-email"
                                                       name="email" value="{{Auth::user()->email}}" required readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="register-email">Your mobile *</label>
                                                <input type="text" class="form-control" id="register-mobile"
                                                       name="mobile_number" value="{{Auth::user()->mobile_number}}" required readonly>
                                            </div>


                                            <div class="form-group">
                                                <label for="register-password">Password *</label>
                                                <input type="password" class="form-control" id="register-password"
                                                       name="password" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="register-confirm-password">Confirm Password *</label>
                                                <input type="password" class="form-control" id="register-confirm-password" name="register-confirm-password" required>
                                                <span id="password-match-message"></span>
                                            </div>


                                            <div class="form-footer">
                                                <button type="submit" class="btn btn-success btn-outline-primary-2">
                                                    <span>Update</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade text-left text-light" id="order" role="tabpanel" aria-labelledby="order-tab">
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

                            <div class="tab-pane fade text-left text-light" id="wishlist" role="tabpanel"
                                 aria-labelledby="wishlist-tab">
                                <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>PRODUCT</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(!empty($wishlist))
                                        @foreach($wishlist as $key =>  $wishlists)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>
                                                    <img src="{{asset($wishlists->product[0]->photo)}}" style="width: 100px;"/>

                                                    <br>
                                                    {{$wishlists->product[0]->title}}
                                                </td>

                                                <td class="" style="">
                                                    <a href="{{url('products/'.$wishlists->product[0]->slug)}}"
                                                       class="btn btn-primary waves-effect waves-float btn-sm waves-green">
                                                        View</a> <br>
                                                    <a href="{{url('products/'.$wishlists->product[0]->slug)}}"
                                                       class="btn btn-danger waves-effect waves-float btn-sm waves-green">
                                                        Remove</a> <br>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade text-left text-light" id="address" role="tabpanel"
                                 aria-labelledby="wishlist-tab">
                                <form id="addressForm" action="{{ url('save-address') }}" method="post">

                                    @csrf

                                    <div class="form_wrap">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form_item text-dark">
                                                    <span class="input_title">Full Name<sup>*</sup></span>
                                                    <input type="text" name="first_name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form_item text-dark">
                                                    <span class="input_title">Address<sup>*</sup></span>
                                                    <input type="text" name="address_1" placeholder="House number and street name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form_item text-dark">
                                                    <span class="input_title">Town/City<sup>*</sup></span>
                                                    <input type="text" name="city">
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form_item text-dark">
                                                    <span class="input_title">State<sup>*</sup></span>
                                                    <input type="text" name="state">
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form_item text-dark">
                                                    <span class="input_title">Postcode / Zip<sup>*</sup></span>
                                                    <input type="text" name="pincode">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">

                                                <div class="form_item text-dark">
                                                    <span class="input_title">Phone<sup>*</sup></span>
                                                    <input type="tel" name="phone">
                                                </div>
                                            </div>

                                            <input type="submit" name="submit" value="submit" id="submitBtn" class="btn btn-success">
                                        </div>


                                    </div>
                                </form>

                                <div class="row">
                                    <div class="col-md-4">


                                        <table id="example2" class="table table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th> Name </th>
                                                <th>Phone</th>
                                                <th>Address </th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Pincode</th>

                                                <th>ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(!empty($user_address))
                                                @foreach($user_address as $key =>  $user_addresss)
                                                    <tr>
                                                        <td>
                                                            {{$user_addresss->first_name}}
                                                        </td>

                                                        <td>
                                                            {{$user_addresss->phone}}
                                                        </td>
                                                        <td>
                                                            {{$user_addresss->address_1}}
                                                        </td>
                                                        <td>
                                                            {{$user_addresss->city}}
                                                        </td>
                                                        <td>
                                                            {{$user_addresss->state}}
                                                        </td>
                                                        <td>
                                                            {{$user_addresss->pincode}}
                                                        </td>
                                                        <td class="" style="">
                                                            <a href="{{url('update-address/'.$user_addresss->id)}}"
                                                               class="btn btn-primary waves-effect waves-float btn-sm waves-green">
                                                                View</a> <br>
                                                            <a href="{{url('remove-address/'.$user_addresss->id)}}"
                                                               class="btn btn-danger waves-effect waves-float btn-sm waves-green">
                                                                Remove</a>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><!--tab content end-->
                    </div><!-- col-md-8 end -->
                </div>
            </div>
        </div><!-- End .page-content -->
    </main>
@stop
@section('js')
    <script>
        $(document).ready(function () {
            $('#submitBtn').on('click', function () {
                var formData = $('#addressForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: $('#addressForm').attr('action'),
                    data: formData,
                    success: function (response) {
                        // Handle the successful response
                        console.log(response);

                        // Update the table with the new data
                        updateTable(response);

                        // Optionally, you can clear the form fields after successful submission
                        $('#addressForm')[0].reset();
                    },
                    error: function (error) {
                        // Handle errors here
                        console.log(error);
                    }
                });
            });

            // Function to update the table with new data
            function updateTable(data) {
                var newRow = '<tr>' +
                    '<td>' + data.first_name + '</td>' +
                    '<td>' + data.last_name + '</td>' +
                    '<td>' + data.company_name + '</td>' +
                    '<td>' + data.address_1 + '</td>' +
                    '<td>' + data.city + '</td>' +
                    '<td>' + data.state + '</td>' +
                    '<td>' + data.pincode + '</td>' +
                    '<td>' + data.phone + '</td>' +
                    '<td class="">' +
                    '<a href="#" class="btn btn-primary waves-effect waves-float btn-sm waves-green">View</a>' +
                    '<br>' +
                    '<a href="#" class="btn btn-danger waves-effect waves-float btn-sm waves-green">Remove</a>' +
                    '<br>' +
                    '</td>' +
                    '</tr>';

                $('#example2 tbody').append(newRow);
            }
        });
    </script>
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
