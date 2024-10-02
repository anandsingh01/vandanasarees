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


.large-table-container-3 {
  max-width: 100%;
  overflow-x: scroll;
  overflow-y: auto;
}
.large-table-container-3 table {

}
.large-table-fake-top-scroll-container-3 {
  max-width: 100%;
  overflow-x: scroll;
  overflow-y: auto;
}
.large-table-fake-top-scroll-container-3 div {
  background-color: red;/*Just for test, to see the 'fake' div*/
  font-size:1px;
  line-height:1px;
}

    </style>
@stop
@section('body')
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>{{$page_heading}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}"><i class="zmdi zmdi-home"></i> Admin </a></li>
                    <li class="breadcrumb-item active">{{$page_heading}}</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
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
                            <h2><strong>All</strong> Products </h2>
                            <ul class="header-dropdown">
                                <li>
                                    <a href="{{url('admin/add-products')}}" class="btn bg-purple waves-effect"><i class="zmdi zmdi-plus-circle-o"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
						<div class="large-table-fake-top-scroll-container-3">
						  <div>&nbsp;</div>
						</div>
                        <div class="table-responsive large-table-container-3">
                            <table class="table dataTable js-exportable" id="tabledata">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Show Fav </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Show Highlight </th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>

                                @if(!empty($products))
                                    @foreach($products as $key =>  $product)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><img src="{{asset($product->photo ?? '')}}" style="width: 50px;"> {{$product->title}}</td>

                                        <td>
                                            <b>Section</b> : @php
                                                $section = \App\Models\Section::find($product->section_id);
                                            @endphp
                                            {{$section->category_name ?? 'NA'}}

                                            <br>

                                            <b>Category</b> :
                                            @php
                                                $category = \App\Models\Category::find($product->category_id);
                                            @endphp

                                            {{$category->category_name ?? ''}}
                                        </td>

                                        <td>

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input status-toggle toggle-class"
                                                       id="statusSwitch{{$product->id}}"
                                                       data-id="{{$product->id}}" data-status="{{$product->status}}"
                                                       @if($product->status == 1) checked @endif>
                                                <label class="custom-control-label" for="statusSwitch{{$product->id}}">
                                                    {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input highlight-status"
                                                       id="statusHighlightSwitch{{$product->id}}"
                                                       data-id="{{$product->id}}" data-status="{{$product->highlights}}"
                                                       @if($product->highlights == 1) checked @endif>
                                                <label class="custom-control-label" for="statusHighlightSwitch{{$product->id}}">
                                                    {{ $product->highlights == 1 ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>



                                        </td>

                                        <td class="" style="">
                                            <a href="{{url('admin/edit-products/'.$product->id)}}" class="btn btn-primary"><i class="zmdi zmdi-edit"></i>  </a> <br>
{{--                                            <a href="{{url('admin/products/add/attribute/display/'.$product->id)}}" class="btn btn-primary waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i> Edit Attribute</a> <br>--}}
                                            <a href="javascript:void(0);" onclick="deleteConfirmation({{$product->id}})" class="btn btn-danger"><i class="zmdi zmdi-delete"></i>  </a>
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

			var tableContainer = $(".large-table-container-3");
			  var table = $(".large-table-container-3 table");
			  var fakeContainer = $(".large-table-fake-top-scroll-container-3");
			  var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

			  var tableWidth = table.width();
			  fakeDiv.width(tableWidth);

			  fakeContainer.scroll(function() {
			tableContainer.scrollLeft(fakeContainer.scrollLeft());
			 });

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
            //$('.toggle-class').click(function() {
            $('#tabledata tbody').on("click", ".toggle-class",function() {
                var status = $(this).data('status');

                var id = $(this).data('id');
                // alert(id);
                // return false;
                var table = 'categories';
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("admin/update-products-Status")}}',
                    data: {'status': status, 'id': id,'table' : table},
                    success: function(data){
                        console.log(data);
                        // location.reload();
                        swal("Status Changed!");
                        location.reload();
                        // console.log(data.success)
                    }
                });
            })
        });
        $(function() {
            //$('.status').click(function() {
             $('#tabledata tbody').on("click", ".highlight-status",function(){
                var status = $(this).data('status');
                var id = $(this).data('id');
                var table = 'categories';
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("admin/highlight-status")}}',
                    data: {'status': status, 'id': id,'table' : table},
                    success: function(data){
                        swal("Status Changed!");
                        location.reload();
                        console.log(data);
                    }
                });
            })
        });
        $(function() {
            //$('.fav').click(function() {
             $('#tabledata tbody').on("click", ".fav",function(){
                var status = $(this).data('status');
                var id = $(this).data('id');
                var table = 'categories';
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{url("admin/fav-status")}}',
                    data: {'status': status, 'id': id,'table' : table},
                    success: function(data){
                        console.log(data);
                        swal("Status Changed!");
                        location.reload();
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
                        url: "{{url('admin/delete-products')}}/" + id,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            location.reload();
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
