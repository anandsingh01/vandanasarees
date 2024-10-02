@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{asset('/')}}/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <style>
        i.zmdi.zmdi-plus-circle-o {
            color: #fff !important;
        }
        label.btn.btn-danger.active.toggle-off, label.btn.btn-success.toggle-on {
            margin-top: 3px;
            background: transparent;
            font-size: 11px;
            font-weight: 600;
        }
        span.toggle-handle.btn.btn-default {
            padding: 10px;
        }
        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: unset;
        }
        .table tr{
            border-bottom:1px solid #ddd;
        }
        .toggle-off.btn {
            padding-left: 20px;
        }

        .body {
            padding: 20px;
            border: 1px solid;
        }
        @media print {
            #printable-content {
                /* Define styles for the printable content */
            }

            #printable-content button {
                display: none; /* Hide the button when printing */
            }
        }
    </style>
@stop
@section('body')
    <div class="block-header" id="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>{{$page_heading}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}"><i class="zmdi zmdi-home"></i> Admin </a></li>
                    <li class="breadcrumb-item active">{{$page_heading}}</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">

            <div class="col-lg-12">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>Congrats</strong> {{Session::get('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                        </button>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-success" role="alert">
                        <strong>Sorry</strong> {{Session::get('error')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="body">
                        <h5><strong>Order ID: </strong> #{{$orders->order_id}}</h5>
                        <div class="row">
                            <div class="col-md-4 col-sm-3">
                                <address>
                                    <b>Shipping address : </b>
                                    <strong>{{$orders->first_name}} {{$orders->last_name}}</strong><br>
                                    {{$orders->address_1}}, {{$orders->address_2}},{{$orders->city}}, {{$orders->state}}, {{$orders->pincode}},  </span>
                                    <br><abbr class="newfontdisplay" title="Phone"> {{$orders->phone}}</abbr> <br>
                                    {{$orders->email}}
                                </address>
                            </div>

                            <div class="col-md-4 col-sm-3">
                                <address>
                                    <b>Billing address : </b>
                                    <strong>{{$orders->billing_first_name}} {{$orders->billing_last_name}}</strong><br>
                                    {{$orders->billing_address_1}}, {{$orders->billing_address_2}},{{$orders->billing_city}},
                                    {{$orders->billing_state}}, {{$orders->billing_pincode}},  </span>
                                    <br><abbr class="newfontdisplay" title="Phone"> {{$orders->billing_phone}}</abbr> <br>
                                    {{$orders->billing_email}}

                                </address>
                            </div>
                            <div class="col-md-4 col-sm-6 text-right">
                                <p class="mb-0"><strong>Order Date: </strong> {{$orders->updated_at}}</p>
                                <p class="mb-0"><strong>Order Status: </strong>
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

                                    </p>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="printable-content">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover c_table theme-color">
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
                                            <td><img src="{{asset($products->sizeAttributes[0]->image)}}" width="40" alt="Product img"></td>
                                            <td>{{$products->title}}</td>
                                            <td class="hidden-sm-down">{{$products->pivot->size}}</td>
                                            <td>{{$products->pivot->quantity}}</td>
                                            <td class="hidden-sm-down">{{$products->pivot->price}}</td>
                                            <td>{{$products->pivot->price * $products->pivot->quantity }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <h5>Status</h5>
                                    <input type="hidden" name="order_id" id="order_id" value="{{$orders->id}}"/>
                                    <select class="change_order_status ms form-control" name="change_order_status">
                                        <option>Select Option</option>
                                        <option value="2" >Shipped </option>
                                        <option value="3" >In transit</option>
                                        <option value="4">Delivered </option>
                                        <option value="5">Cancelled </option>
                                        <option value="6">Failed </option>
{{--                                        <option value="6">Return Request </option>--}}
{{--                                        <option value="7">Returned </option>--}}
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 text-right">
                                <ul class="list-unstyled">
                                    <li><strong>Product:-</strong>
                                        <?php
                                        $total = $orders->final_amount; // Replace with the actual total value
                                        $shipping = $orders->shipping_price; // Replace with the actual shipping price
                                        $salesTax = $orders->sales_tax; // Replace with the actual sales tax

                                        $productPrice = $total - $shipping - $salesTax;

                                        $formattedProductPrice = number_format($productPrice, 2);

                                        echo $formattedProductPrice; // This will give you the product price
                                        ?></li>
                                    <li><strong>Shipping:-</strong>$ {{$orders->shipping_price ?? 'NA'}}</li>
                                    <li><strong>Sales Tax:-</strong>$ {{$orders->sales_tax ?? 'NA'}}</li>
                                </ul>
                                <h3 class="mb-0 text-success">$ {{number_format($orders->final_amount,2)}}</h3>
                                <a href="{{url('admin/print-order/'.$orders->order_id)}}"
                                   class="btn btn-info"
                                   id="print-button"><i class="zmdi zmdi-print"></i> Print</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('/')}}assets/bundles/datatablescripts.bundle.js"></script>
    <script src="{{asset('/')}}/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="{{asset('/')}}/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('/')}}/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
    <script src="{{asset('/')}}/assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
    <script src="{{asset('/')}}/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
    <script src="{{asset('/')}}/assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>
    <script src="{{asset('/')}}/assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        // // Get a reference to the print button and the printable content div
        // const printButton = document.getElementById('print-button');
        // const printableContent = document.getElementById('printable-content');
        // const slimScrollDiv = document.getElementById('leftsidebar');
        // const blockheader = document.getElementById('block-header');
        //
        // // Add a click event listener to the print button
        // printButton.addEventListener('click', function () {
        //     // Hide the button before printing
        //     printButton.style.display = 'none';
        //     slimScrollDiv.style.display = 'none';
        //     blockheader.style.display = 'none';
        //     // printButton.style.display = 'none';
        //
        //     // Trigger the print dialog
        //     window.print();
        //
        //     // Show the button again after printing
        //     printButton.style.display = 'block';
        // });

        $(function() {
            $('.change_order_status').change(function() {
                var order_id = $('#order_id').val();
                var status_id = $(this).val();

                // alert(status);return false;
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("admin/update-order-Status")}}',
                    data: {'order_id': order_id, 'status_id': status_id},
                    success: function(data){
                        if(data.code == 200){
                            alert('Status Changed');
                            location.reload();
                        }else{
                            alert('Something went wrong. Try Again');
                            location.reload();
                        }
                    }
                });
            })
        });
    </script>
    <script>

        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 'active' : 'inactive';
                var product_id = $(this).data('id');

                // alert(status);return false;
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("/update-products-Status")}}',
                    data: {'status': status, 'product_id': product_id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        });

        function deleteConfirmation(id) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'get',
                        url: "{{url('/delete-products')}}/" + id,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success");
                                location.reload();
                            } else {
                                swal("Error!", results.message, "error");
                                location.reload();
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }
    </script>

@stop
