@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css"/>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
@stop
@section('body')
    <div class="block-header">

        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Dashboard</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}"><i class="zmdi zmdi-home"></i> Admin </a></li>
                    <li class="breadcrumb-item active">Section</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-5 col-md-5 col-sm-12">
            <div class="card">

                <div class="body">


                    <form method="post" action="{{url('admin/create-section')}}" class="category_form"
                    enctype="multipart/form-data">
                        @csrf

{{--                        <input type="hidden" value="{{$_GET['type']}}" name="category_type">--}}
                        <div class="form-group">
                            <label for="category_name"><b>Section Name</b></label>
                            <input name="name" type="text" id="category_name"
                                   required class="form-control" placeholder="Enter category">
                        </div>




                        <div class="form-group">
                            <label for="slug"><b>Image (1200x1800)</b></label>
                            <input name="image" type="file" id="image" class="form-control" placeholder="">
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label for="meta_keywords"><b>Banner Text</b></label>--}}

{{--                            <input name="banner_text" type="text" id="meta_keywords" class="form-control"--}}
{{--                                   placeholder="Enter Banner Text">--}}
{{--                        </div>--}}


                        <div class="form-group">
                            <label for="slug"><b>Banner Image</b></label>
                            <input name="banner_image" type="file" id="banner_image" class="form-control" placeholder="">
                        </div>


{{--                        <div class="form-group">--}}
{{--                            <label for="slug"><b>Banner Image</b></label>--}}
{{--                            <input name="banner_image" type="file" id="banner_image" class="form-control" placeholder="">--}}
{{--                        </div>--}}


{{--                        <div class="form-group">--}}
{{--                            <label for="meta_keywords"><b>Banner Text</b></label>--}}

{{--                            <input name="banner_text" type="text" id="meta_keywords" class="form-control"--}}
{{--                                   placeholder="Enter Banner Text">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="show_on_menu">--}}
{{--                                <label><b>Show on Menu</b></label>--}}
{{--                            </label>--}}
{{--                            <div class="radio radio-inline">--}}
{{--                                <input name="show_on_menu" class="" type="radio" id="radio1" value="1" checked >--}}
{{--                                <label for="radio1">Yes</label>--}}
{{--                            </div>--}}

{{--                            <div class="radio radio-inline">--}}
{{--                                <input name="show_on_menu" class="checkbox-inline" type="radio"  id="radio2" value="0">--}}
{{--                                <label for="radio2">No</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label for="show_on_homepage"><b>Show on Homepage</b></label>

                            <div class="radio radio-inline">
                                <input name="show_at_homepage" class="" type="radio" id="radio1" value="1" checked >
                                <label for="radio1">Yes</label>
                            </div>

                            <div class="radio radio-inline">
                                <input name="show_at_homepage" class="checkbox-inline" type="radio"  id="radio2" value="0">
                                <label for="radio2">No</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn  btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="body">

                    <!-- Display errors here -->
                    <div id="errorMessage" style="color: red;"></div>
                    <div id="successMessage" style="color: green;"></div>

                    <!-- Full-screen loading overlay -->

                    <!-- CSS for the overlay -->
                    <style>
                        .loading-overlay {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 9999;
                        }

                        .loading-message {
                            color: white;
                            font-size: 24px;
                            font-weight: bold;
                        }
                    </style>
                    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
                        <div class="loading-message">Please wait... Uploading</div>
                    </div>
                    <form class="row g-3" id="uploadForm" enctype="multipart/form-data">

                        @csrf

                        <div class="col-md-12">
                            <label for="file" class="form-label">Upload CSV</label>
                            <input type="file" class="form-control  @error('file') is-invalid @enderror" accept="image/*" name="csv_file" id="file" accept="application/vnd.ms-excel" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                            @error('file')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>

        <div class="col-lg-7 col-md-7 col-sm-12">
            <div class="card">
                <div class="body">
{{--                    <div class="header">--}}
{{--                        <h2><strong>All</strong> Categories </h2>--}}
{{--                    </div>--}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="tabledata">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>

                                <th>Slug</th>
                                <th>Status</th>
                                <th>On home</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>On Home</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @if(!empty($categories))
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td>{{$category->slug}}</td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input status-toggle" id="statusSwitch{{$category->id}}"
                                                   data-id="{{$category->id}}" data-status="{{$category->status}}"
                                                   @if($category->status == 1) checked @endif>
                                            <label class="custom-control-label" for="statusSwitch{{$category->id}}">
                                                @if($category->status == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </label>
                                        </div>



                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input change_home_status" id="switch-{{$category->id}}"
                                                   data-id="{{$category->id}}" data-status="{{$category->show_on_homepage == '1' ? '0' : '1'}}"
                                                   @if($category->show_on_homepage == '1') checked @endif>
                                            <label class="custom-control-label" for="switch-{{$category->id}}">
                                                @if($category->show_on_homepage == '1') Active @else Inactive @endif
                                            </label>
                                        </div>


                                    </td>
                                    <td>
                                        <a href="{{url('admin/edit-section/'.$category->id)}}" class="btn btn-success btn-sm btn-icon">
                                            <i class="zmdi zmdi-edit"></i></a>
                                        <button class="btn btn-sm btn-danger btn-icon" onclick="deleteConfirmation({{$category->id}})">
                                            <i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <h3>No Data Found</h3>
                            @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/admin')}}/assets/bundles/datatablescripts.bundle.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>

    <script src="{{asset('assets/admin')}}assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="{{asset('assets/admin')}}/assets/js/pages/tables/jquery-datatable.js"></script>
    <script>
        $('#uploadForm').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting the traditional way

            var formData = new FormData(this);

            // Disable all inputs and buttons inside the form
            $('#uploadForm').find('input, button').prop('disabled', true);

            // Show the full-screen overlay with the loading message
            $('#loadingOverlay').show();

            // Clear previous messages
            $('#errorMessage').text('');
            $('#successMessage').text('');

            $.ajax({
                url: "{{ url('admin/uploadsectionContent') }}", // Adjust the route
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Hide the loading overlay
                    $('#loadingOverlay').hide();

                    // Re-enable all inputs and buttons in the form
                    $('#uploadForm').find('input, button').prop('disabled', false);

                    if (response.message) {
                        $('#successMessage').text(response.message);
                    }
                },
                error: function(response) {
                    // Hide the loading overlay
                    $('#loadingOverlay').hide();

                    // Re-enable all inputs and buttons in the form
                    $('#uploadForm').find('input, button').prop('disabled', false);

                    // Display error message
                    var error = response.responseJSON.error || "Something went wrong!";
                    $('#errorMessage').text(error);
                }
            });
        });
    </script>
    <script>

        $(function() {
            // Listen for changes on the toggle switch
            $('#tabledata tbody').on("change", ".status-toggle", function() {
                var status = $(this).is(':checked') ? 1 : 0;  // Check if the switch is on or off
                var id = $(this).data('id');
                var table = 'categories';

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ url("admin/change-section-status") }}',
                    data: { 'status': status, 'id': id, 'table': table },
                    success: function(data){
                        swal("Status Changed!");
                        location.reload();  // Optionally reload the page
                        console.log(data.success);
                    },
                    error: function(xhr, status, error) {
                        swal("Error", "There was an issue changing the status", "error");
                    }
                });
            });
        });

        $(function() {
            $('#tabledata tbody').on("change", ".change_home_status", function() {
                var status = $(this).is(':checked') ? 1 : 0;
                var id = $(this).data('id');
                var table = 'categories';

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ url("admin/change_sectionhome_status") }}',
                    data: { 'status': status, 'id': id, 'table': table },
                    success: function(data){
                        swal("Status Changed!");
                        location.reload();
                        console.log(data.success);
                    },
                    error: function(xhr, status, error) {
                        swal("Error", "There was an issue changing the status", "error");
                    }
                });
            });
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
                        url: "{{url('admin/delete/category')}}/" + id,
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
