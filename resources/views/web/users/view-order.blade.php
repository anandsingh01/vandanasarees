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
        .table td {
            vertical-align: middle;
            width: 100px;
        }
        .page-content, .page-content p {
            font-size: 18px;
        }
        .page-content {
            padding-bottom: 5em;
        }
        table#example thead {
            background: #173054;
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
    <main class="main">

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Orders</a></li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">

                <h3 class="text-center">Welcome {{Auth::user()->name}}</h3>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="newfontdisplay"><strong>Order ID: </strong> #{{$orders->order_id}}</h5>
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <address>
                                    <strong>{{$orders->first_name}} {{$orders->last_name}}</strong><br>
                                    {{$orders->address_1}}, {{$orders->address_2}},{{$orders->city}}, {{$orders->state}}, {{$orders->pincode}},  </span>
                                    <br><abbr class="newfontdisplay" title="Phone"> {{$orders->phone}}</abbr> <br>
                                    {{$orders->email}}
                                </address>
                            </div>

                            <div class="col-md-3 col-sm-3">
{{--                                <address>--}}
{{--                                    <b>Billing address : </b>--}}
{{--                                    <strong>{{$orders->billing_first_name}} {{$orders->billing_last_name}}</strong><br>--}}
{{--                                    {{$orders->billing_address_1}}, {{$orders->billing_address_2}},{{$orders->billing_city}},--}}
{{--                                    {{$orders->billing_state}}, {{$orders->billing_pincode}},  </span>--}}
{{--                                    <br><abbr class="newfontdisplay" title="Phone"> {{$orders->billing_phone}}</abbr> <br>--}}
{{--                                    {{$orders->billing_email}}--}}

{{--                                </address>--}}
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <p class="mb-0 newfontdisplay"><strong>Order Date: </strong> {{$orders->updated_at}}</p>
                                <p class="mb-0"><strong>Order Status: </strong>

                                    @if($orders->status == 0)
                                        <span class="badge badge-warning"> Payment Failure </span>
                                @endif

                                @if($orders->status == 1)
                                    <p class="badge badge-success">Paid </p>
                                @endif

                                @if($orders->status == 2)
                                    <span class="badge badge-primary">Shipped </span>
                                @endif

                                @if($orders->status == 3)
                                    <span class="badge badge-warning">Transit  </span>
                                @endif

                                @if($orders->status == 4)
                                    <span class="badge badge-success">Delivered </span>
                                @endif

                                @if($orders->status == 5)
                                    <span class="badge badge-danger">Cancelled </span>
                                @endif

                                @if($orders->status == 6)
                                    <span class="badge badge-danger">Failed </span>
                                    @endif
                                </p>

                                    <!--<p class="mb-0"><strong>Payment Status: </strong> {{$orders->transaction_status}}</p>-->

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover c_table theme-color" id="example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="60px">Item</th>
                                        <th></th>
                                        <th class="hidden-sm-down">Size</th>
                                        <th>Quantity</th>
                                        <th class="hidden-sm-down">Unit Cost</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($orders->get_order_products as $key =>  $products)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{asset($products->photo)}}"
                                                     alt="Product img">
                                            </td>
                                            <td>
                                                {{$products->title}}
{{--                                                {{$products->pivot->product_id}}--}}
                                                <br>
                                                <?php
                                                    $review = \App\Models\ReviewModel::where('user_id',Auth::user()->id)
                                                        ->where('product_id',$products->pivot->product_id )
                                                        ->first();
//                                                    print_r($review);
                                                    ?>
                                                @if(!empty($review))
                                                    @if($review->status == 0)
                                                    <p class="badge badge-warning">Pending Review</p>
                                                    @endif

                                                        @if($review->status == 1)
                                                            <p class="badge badge-warning"> Review Posted</p>
                                                        @endif
                                                @else
                                                    @if($orders->status == '4')
                                                        <a href="" class="badge badge-success"
                                                           data-toggle="modal" data-target="#reviewModal"
                                                        >Add Review </a>
                                                    @endif
                                                @endif



                                            </td>
                                            <td class="hidden-sm-down">{{$products->pivot->size}}</td>
                                            <td>{{$products->pivot->quantity}}</td>
                                            <td class="hidden-sm-down">{{$products->pivot->price/$products->pivot->quantity}}</td>
                                            <td>{{$products->pivot->price }}</td>
                                        </tr>


                                        <div class="modal fade" id="reviewModal" tabindex="-1"
                                             role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">

                                                        <h5 class="modal-title" id="reviewModalLabel">Review Product</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form action="{{ url('save-reviews') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="order_id" value="{{ $orders->order_id }}">
                                                                        <input type="hidden" name="product_id" value="{{ $products->pivot->product_id }}">
                                                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                                        <input type="hidden" name="username" value="{{ Auth::user()->name }}">
                                                                        <div class="form-group">

                                                                            <div class="col-sm-12">
                                                                                <label for="return_reason">Rating</label>
                                                                                <label for="star1">1 ★
                                                                                    <input type="radio" id="star1" name="rating" value="1">
                                                                                </label>

                                                                                <label for="star2">2 ★
                                                                                    <input type="radio" id="star2" name="rating" value="2">
                                                                                </label>

                                                                                <label for="star3">3 ★
                                                                                    <input type="radio" id="star3" name="rating" value="3">
                                                                                </label>

                                                                                <label for="star4">4 ★
                                                                                    <input type="radio" id="star4" name="rating" value="4">
                                                                                </label>

                                                                                <label for="star5">5 ★
                                                                                    <input type="radio" id="star5" name="rating" value="5" checked="">
                                                                                </label>


                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="return_description">Title</label>
                                                                            <input type="text" class="form-control" id="" name="heading" >

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="return_description">Description</label>
                                                                            <textarea class="form-control" id="return_description"
                                                                                      name="review" rows="3" required></textarea>
                                                                        </div>
                                                                        <input type="submit" class="btn btn-primary pt-2 pb-2" value="submit">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                Current Status :
                                @if($orders->status == 0)
                                    <span class="badge badge-warning">New </span>
                                @endif

                                @if($orders->status == 1)
                                    <p class="badge badge-success">Paid </p>
                                @endif

                                @if($orders->status == 2)
                                    <span class="badge badge-primary">Shipped </span>
                                @endif

                                @if($orders->status == 3)
                                    <span class="badge badge-warning">Transit  </span>
                                @endif

                                @if($orders->status == 4)
                                    <span class="badge badge-success">Delivered </span>
                                @endif

                                @if($orders->status == 5)
                                    <span class="badge badge-danger">Cancelled </span>
                                @endif

                                @if($orders->status == 6)
                                    <span class="badge badge-danger">Failed </span>
                                @endif

{{--                                @php--}}
{{--                                    $productReturn = \App\Models\ProductReturn::where('order_id',$orders->order_id)->count();--}}
{{--//                                    print_r($productReturn);--}}
{{--                                @endphp--}}

{{--                                @if($productReturn == 6)--}}
{{--                                    <button type="button" class="btn btn-danger pt-2 pb-2">--}}
{{--                                        Return Placed--}}
{{--                                    </button>--}}
{{--                                @else--}}
{{--                                    <h5>Return Product</h5>--}}
{{--                                    <button type="button" class="btn btn-primary pt-2 pb-2" data-toggle="modal" data-target="#returnModal">--}}
{{--                                        Return--}}
{{--                                    </button>--}}
{{--                                @endif--}}



                                <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h5 class="modal-title" id="returnModalLabel">Return Product</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <form action="{{ url('return-product') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="order_id" value="{{ $orders->order_id }}">
                                                                <div class="form-group">
                                                                    <label for="return_reason">Reason for Return</label>
                                                                    <select class="form-control" id="return_reason" name="return_reason" required>
                                                                        <option value="" disabled selected>Choose an option</option>
                                                                        <option value="Defective">Defective</option>
                                                                        <option value="Wrong Size">Wrong Size</option>
                                                                        <option value="Changed Mind">Changed Mind</option>
                                                                        <!-- Add more options if needed -->
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="return_description">Description</label>
                                                                    <textarea class="form-control" id="return_description" name="return_description" rows="3" required></textarea>
                                                                </div>
                                                                <input type="submit" class="btn btn-primary pt-2 pb-2" value="submit">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6 text-right">
                                <ul class="list-unstyled">
                                    <ul class="list-unstyled">
                                        <li><strong>Product:-</strong>
                                            <?php
                                            $total = $orders->final_amount; // Replace with the actual total value
                                            $shipping = $orders->shipping_price; // Replace with the actual shipping price
                                            $salesTax = $orders->sales_tax; // Replace with the actual sales tax

                                            $productPrice = $total - $shipping - $salesTax;

                                            $formattedProductPrice = number_format($productPrice, 2);

                                            echo 'Rs.'.$formattedProductPrice; // This will give you the product price
                                            ?></li>
{{--                                        <li><strong>Shipping:-</strong> Rs.{{$orders->shipping_price ?? 'NA'}}</li>--}}
{{--                                        <li><strong>Sales Tax:-</strong>$ {{$orders->sales_tax ?? 'NA'}}</li>--}}
                                    </ul>
                                    <li><strong>Sub-Total:-</strong>Rs. {{number_format($orders->final_amount,2)}}</li>
                                    {{--                                        <li class="text-danger"><strong>Discout:-</strong> 12.9%</li>--}}
                                    {{--                                        <li><strong>VAT:-</strong> 12.9%</li>--}}
                                </ul>
                                <h3 class="mb-0 text-success">Rs. {{number_format($orders->final_amount,2)}}</h3>
                                {{--                                        <a href="javascript:void(0);" class="btn btn-info"><i class="zmdi zmdi-print"></i></a>--}}
                                {{--                                        <a href="javascript:void(0);" class="btn btn-primary">Submit</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End .page-content -->
    </main>
@stop
@section('js')

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
