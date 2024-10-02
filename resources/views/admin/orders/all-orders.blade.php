@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css"/>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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

    </style>
@stop
@section('body')
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>{{$page_heading}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="zmdi zmdi-home"></i> Admin </a></li>
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
                        <div class="header">
                            <h2><strong>All</strong> Orders </h2>
                        </div>
                        <div class="table-responsive">
                            <table class="table dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Order Id</th>
                                    <th>User</th>
                                    <th>Address</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Size</th>
                                    <th>Final Price</th>
                                    <th>Shipping Price</th>
                                    <th>Sales Price</th>
                                    <th>Coupon</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Order Id</th>
                                    <th>User</th>
                                    <th>Address</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Size</th>
                                    <th>Final Price</th>
                                    <th>Shipping Price</th>
                                    <th>Sales Price</th>
                                    <th>Coupon</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>

                                @if(!empty($orders))
                                    @foreach($orders as $key =>  $order)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <a href="{{url('admin/view-orders/'.$order->order_id)}}">
                                                <span class="badge badge-danger">Order Id -
                                                {{$order->order_id}}</span>
                                                </a>

                                            </td>
                                            <td>
                                                <span class="badge badge-info">Name - {{$order->first_name}}, {{$order->last_name}}     </span>
                                                </td>
                                            <td>
                                                <span class="badge badge-info">Address - {{$order->address_1}}, {{$order->address_2}},{{$order->city}}, {{$order->state}}, {{$order->pincode}},  </span>
                                                <br><span class="badge badge-info">Phone - {{$order->phone}}</span>
                                                <br><span class="badge badge-info">Email - {{$order->email}}</span>
                                            </td>
                                            <td>
                                                @forelse($order->get_order_products as $order_product)
                                                    <span class="badge badge-primary">Product - {{ $order_product->title }}</span>
                                                   @empty
                                                    <!-- Handle the case where there are no order products -->
                                                @endforelse

                                            </td>
                                            <td>
                                                @forelse($order->get_order_products as $order_product)
                                                    <span class="badge badge-primary">Quantity - {{ $order_product->pivot->quantity }}</span>
                                                @empty
                                                    <!-- Handle the case where there are no order products -->
                                                @endforelse

                                            </td>
                                            <td>
                                                @forelse($order->get_order_products as $order_product)
                                                        <span class="badge badge-primary">Size - {{ $order_product->pivot->size }}</span>
                                                @empty
                                                    <!-- Handle the case where there are no order products -->
                                                @endforelse

                                            </td>

                                            <td>
                                                <span class="badge badge-primary">Final Amount  - $ {{$order->final_amount}}</span>
                                            </td>
                                            <td>
                                               <span class="badge badge-primary">Shipping  - $ {{$order->shipping_price}}</span>
                                               </td>
                                            <td>
                                                 <span class="badge badge-primary">Sales Tax  - $ {{$order->sales_tax}}</span>
                                            </td>
                                            <td>
                                                 <span class="badge badge-primary">Coupon - {{$order->coupon_code ?? ''}}</span>
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
                                            <td>
                                                {{$order->created_at}}
                                            </td>
                                            <td class="" style="">
                                                <a href="{{url('admin/view-orders/'.$order->order_id)}}" class="btn btn-primary waves-effect waves-float btn-sm waves-green">
                                                    <i class="zmdi zmdi-eye"></i></a> <br>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/admin')}}/assets/bundles/datatablescripts.bundle.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>

    <script src="{{asset('assets/admin')}}assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->

    {{--    <script src="{{asset('assets/admin')}}/assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->--}}
    <script src="{{asset('assets/admin')}}/assets/js/pages/tables/jquery-datatable.js"></script>

    <script>
        $(document).ready(function(){
            $('#filesizecheck').on('change',function(){
                for(var i=0; i< $(this).get(0).files.length; ++i){
                    var file1 = $(this).get(0).files[i].size;
                    if(file1){
                        var file_size = $(this).get(0).files[i].size;
                        if(file_size > 2000000){
                            $('#error-message').html("File upload size is larger than 2MB");
                            $('#error-message').css("display","block");
                            $('#error-message').css("color","red");
                        }else{
                            $('#error-message').css("display","none");
                        }
                    }
                }
            });
        });

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
