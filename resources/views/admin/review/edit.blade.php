@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/summernote/dist/summernote.css"/>
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/multi-select/css/multi-select.css">
    <!-- Bootstrap Spinner Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/select2/select2.css" />
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <style>
        .select2-container .select2-choice{
            border:unset;
        }
        .bootstrap-tagsinput{
            border:1px solid #ddd !important;
            width:100%;
        }
        label{
            font-weight: 800;
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
        <form class="form" action="{{url('admin/update-reviews')}}" method="post" enctype="multipart/form-data">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Update</strong> {{$page_heading}}</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 mtb-10">
                                    <label class="control-label" for="password">  Heading </label>
                                    <input type="text" class="form-control" name="heading"
                                    value="{{$reviews->heading}}"/>
                                </div>


                                <div class="col-lg-12 col-md-12">
                                    <label>User Image</label>
                                    <div class="input-group masked-input mb-3">
                                        <input type="file" class="form-control" name="user_image" placeholder="">
                                        @if(!empty($reviews->user_image))
                                            <img src="{{asset($reviews->user_image)}}" style="width: 100px;">
                                            @endif
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12">
                                    <label>User name</label>
                                    <div class="input-group masked-input mb-3">
                                        <input type="text" class="form-control" name="username"
                                               value="{{$reviews->username}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <label>Stars</label>
                                    <div class="input-group masked-input mb-3">
                                        <select name="rating" class="form-control ms select2">
                                            <option value="1" {{$reviews->rating == 1 ? 'selected' : ''}}>1 star</option>
                                            <option value="2" {{$reviews->rating == 2 ? 'selected' : ''}}>2 star</option>
                                            <option value="3" {{$reviews->rating == 3 ? 'selected' : ''}}>3 star</option>
                                            <option value="4" {{$reviews->rating == 4 ? 'selected' : ''}}>4 star</option>
                                            <option value="5" {{$reviews->rating == 5 ? 'selected' : ''}}>5 star</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <label>Content</label>
                                    <div class="input-group masked-input mb-3">
                                        <textarea  id='about' name="review" required
                                                   class='form-control p-textarea summernote'
                                                   >{{$reviews->review}}</textarea><br />
                                    </div>
                                </div>

                                <input type="hidden" name="added_by" value="1"/>
                                <input type="hidden" name="id" value="{{$reviews->id}}"/>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            @if (Auth::check())
                                <input type="hidden" name="userid" value="{{Auth::user()->id}}"/>
                            @endif
                            @csrf
                            <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                            <?php
                            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard';
                            ?>
                            <a href="{{ url($referer) }}" class="btn btn-raised btn-danger waves-effect" >Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
@section('js')
    <script src="{{asset('assets/admin')}}/assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/js/pages/forms/dropify.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/summernote/dist/summernote.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js -->
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js -->
    <script src="{{asset('assets/admin')}}/assets/plugins/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-spinner/js/jquery.spinner.js"></script> <!-- Jquery Spinner Plugin Js -->
    <script src="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js -->
    <script src="{{asset('assets/admin')}}/assets/plugins/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js -->
    <script src="{{asset('assets/admin')}}/assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="{{asset('assets/admin')}}/assets/js/pages/forms/advanced-form-elements.js"></script>

    <script>
        $(document).ready(function(){
            $('#dropify-event').on('change',function(){
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
    </script>

@stop
