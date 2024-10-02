@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css"/>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/summernote/dist/summernote.css"/>
    <link rel="stylesheet" href="{{asset('assets/admin/assets/plugins/dropify/css/dropify.min.css')}}"/>
    <!-- Colorpicker Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
    <!-- Multi Select Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/multi-select/css/multi-select.css">
    <!-- Bootstrap Spinner Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/jquery-spinner/css/bootstrap-spinner.css">
    <!-- Bootstrap Tagsinput Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />
    <!-- noUISlider Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/nouislider/nouislider.min.css" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/select2/select2.css" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/css/style.min.css">

    <style>
        .checkbox .bootstrap-tagsinput {
            border: 1px solid #ccc !important;
        }
    </style>
@stop
@section('body')
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Dashboard</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('admin/')}}"><i class="zmdi zmdi-home"></i> 24x7LiveKannada</a></li>
                    <li class="breadcrumb-item active">{{$page_heading}}</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
        </div>
    </div>
    <div class="container">
        <form method="post" action="{{url('admin/create-post')}}" class="category_form">
            <div class="row clearfix">
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="card">
                        <div class="body">
                            @csrf
                            <input type="hidden" name="post_format" value="{{$_GET['type']}}" />
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" id="wr_input_post_title" class="form-control" name="title" placeholder="Title" value="" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Slug <small>(If you leave it blank, it will be generated automatically.)</small>
                                </label>
                                <input type="text" class="form-control" name="title_slug" placeholder="Slug" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Summary &amp; Description (Meta Tag)</label>
                                <textarea class="form-control text-area" name="summary" placeholder="Summary &amp; Description (Meta Tag)"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Keywords (Meta Tag)</label>
                                <input type="text" class="form-control" name="keywords"
                                       placeholder="Keywords (Meta Tag)" value="">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="show_on_menu">
                                            <label><b>Visibility</b></label>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="radio radio-inline">
                                            <input name="visibility" class="" type="radio" id="radio1" value="1" checked >
                                            <label for="radio1">Yes</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input name="visibility" class="checkbox-inline" type="radio"  id="radio2" value="0">
                                            <label for="radio2">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label> <b>Add to Featured</b></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="radio radio-inline">
                                            <input name="is_featured" class="" type="radio" id="radio5" value="1"  >
                                            <label for="radio5">Yes</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input name="is_featured" class="checkbox-inline" type="radio" id="radio6" value="0" checked>
                                            <label for="radio6">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label> <b>This moment</b></label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="checkbox">
                                            <div class="radio radio-inline">
                                                <input name="is_breaking" class="" type="radio" id="radio7" value="1"  >
                                                <label for="radio7">Yes</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input name="is_breaking" class="checkbox-inline" type="radio" id="radio8" value="0" checked>
                                                <label for="radio8">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label> <b>Tags</b></label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <input type="text" name="tags" class="form-control" data-role="tagsinput" value="24X7LiveKannda, kannada news">

                                        </div>
                                        <small>(Type tag and hit enter)</small>

                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label">Summernote (<span style="color:red;">Required**</span>)</label>
                                <textarea type="text" class="form-control summernote"
                                          name="rcontent" placeholder="Keywords (Meta Tag)" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <div class="row">
                                @if($_GET['type'] == 'article')
                                    <div class="col-md-12">
                                        <label class="control-label">Main Post Image </label>
                                        <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder"
                                               class="btn btn-primary text-white">
                                              <i class="fa fa-picture-o"></i> Main Post Image
                                            </a>
                                        </span>
                                            <input id="thumbnail" class="form-control" type="hidden" name="post_image_id">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px; width:100%;">
                                            <img src="" id="img_preview"/>
                                        </div>
                                    </div>

                                    {{--                                    <div class="col-md-12">--}}
                                    {{--                                        <div class="form-group">--}}
                                    {{--                                            <label class="control-label">or Add Image Url </label>--}}
                                    {{--                                            <input type="text" class="form-control" name="image_url" placeholder="Add Image Url" value="">--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Image Description </label>
                                            <input type="text" class="form-control" name="image_description"
                                                   placeholder="Image description" value="">
                                        </div>
                                    </div>
                                @endif
                                @if($_GET['type'] == 'video')
                                    <div class="col-md-12" id="tab_1">
                                        <div class="form-group">
                                            <label class="control-label">Video URL<small>(Youtube, Vimeo, Dailymotion, Facebook)</small>
                                            </label>
                                            <input type="text" class="form-control" name="video_url" id="video_url" placeholder="Video URL">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right btn-get-embed" onclick="get_video_from_url();">Click here to get video</a>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label video-embed-lbl">Video Embed Code </label>
                                            <textarea class="form-control text-embed" name="video_embed_code" id="video_embed_code" placeholder="Video Embed Code"></textarea>
                                        </div>

                                        <iframe src="" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen="" class="video-embed-preview"></iframe>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="control-label">Video Thumbnail (Required)</label>
                                        <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder"
                                               class="btn btn-primary text-white">
                                              <i class="fa fa-picture-o"></i> Video Thumbnail
                                            </a>
                                        </span>
                                            <input id="thumbnail" class="form-control" required type="hidden" name="image">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px; width:100%;"></div>
                                    </div>

                                @endif


                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="body">

                            <div class="col-md-12">
                                <label class="control-label">Categories </label>
                                <select name="category_id" required class="getcategories1 form-control ms select2">
                                    @if(!empty($category))
                                        @foreach($category as $categories)
                                            <option value="{{$categories->id}}">{{$categories->name}}</option>
                                            {{--                                        <?php--}}
                                            {{--                                            $get_subcategory = \App\Models\Category::where('parent_id',$categories->id)->get();--}}
                                            {{--                                            ?>--}}
                                            {{--                                        @forelse($get_subcategory as $subcat)--}}
                                            {{--                                            <option value="{{$subcat->name_slug}}"> - {{$subcat->name}}</option>--}}
                                            {{--                                        @empty--}}
                                            {{--                                            No Category--}}
                                            {{--                                        @endforelse--}}

                                        @endforeach
                                    @else
                                        <option>No category</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="control-label">Subcategories </label>
                                <select name="subcategory_id" class="getsubctegories show-tick ms form-control" >
                                    <option></option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-raised btn-success btn-round waves-effect">Submit</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
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
    <script src="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js -->
    <script src="{{asset('assets/admin')}}/assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="{{asset('assets/admin')}}/assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/summernote/dist/summernote.js"></script>
    <script src="{{asset('assets/admin')}}/assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="{{asset('assets/admin')}}/assets/js/pages/forms/dropify.js"></script>
    <script src="{{asset('assets/admin')}}/assets/js/pages/forms/advanced-form-elements.js"></script>
    <script src="{{asset('')}}/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('')}}/vendor/laravel-filemanager/js/dropzone.min.js"></script>
    {{--    <script src="{{asset('')}}/vendor/laravel-filemanager/js/stand-alone-button.js"></script>--}}
    <script>
        var route_prefix = "/filemanager";
    </script>
    <script>
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
    </script>
    <script>
        $('#lfm').filemanager('image', {prefix: route_prefix});
        $('#lfm2').filemanager('file', {prefix: route_prefix});
    </script>


    <script>
        $(document).ready(function () {
            $("#video_embed_preview").hide();
            $('.getcategories1').on('change',function(e){
                // console.log(e);
                var cat_id = e.target.value;
                $.ajax({
                    method: "GET",
                    url: "{{url('/ajax-subcat?cat_id=')}}"+cat_id,
                    success: function(response) {
                        $('.getsubctegories').html('<option value="">-- Select Option --</option>');
                        $.each(response, function (key, value) {
                            $(".getsubctegories").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(error) {

                    }
                });
            });
        });
    </script>


    {{--    <script>--}}
    {{--        var lfm = function(id, type, options) {--}}
    {{--            let button = document.getElementById(id);--}}

    {{--            button.addEventListener('click', function () {--}}
    {{--                var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';--}}
    {{--                var target_input = document.getElementById(button.getAttribute('data-input'));--}}
    {{--                var target_preview = document.getElementById(button.getAttribute('data-preview'));--}}

    {{--                window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');--}}
    {{--                window.SetUrl = function (items) {--}}
    {{--                    var file_path = items.map(function (item) {--}}
    {{--                        return item.url;--}}
    {{--                    }).join(',');--}}


    {{--                    // set the value of the desired input to image url--}}
    {{--                    target_input.value = file_path;--}}
    {{--                    target_input.dispatchEvent(new Event('change'));--}}

    {{--                    alert(file_path);return false;--}}

    {{--                    // clear previous preview--}}
    {{--                    target_preview.innerHtml = '';--}}

    {{--                    // set or change the preview image src--}}
    {{--                    items.forEach(function (item) {--}}
    {{--                        let img = document.createElement('img')--}}
    {{--                        img.setAttribute('style', 'height: 5rem')--}}
    {{--                        img.setAttribute('src', item.thumb_url)--}}
    {{--                        target_preview.appendChild(img);--}}
    {{--                    });--}}

    {{--                    // trigger change event--}}
    {{--                    target_preview.dispatchEvent(new Event('change'));--}}
    {{--                };--}}
    {{--            });--}}
    {{--        };--}}

    {{--        lfm('lfm2', 'file', {prefix: route_prefix});--}}
    {{--    </script>--}}

    <script>
        /*
*
* Video Upload Functions
*
* */

        $("#video_embed_code").on("input change keyup paste", function () {
            var embed_code = $("#video_embed_code").val();
            $("#video_preview").attr('src', embed_code);
            if ($("#video_embed_code").val() == '') {
                $("#video_embed_preview").attr('src', '');
                $("#video_embed_preview").hide();
            }
        });


        function get_video_from_url() {
            var url = $("#video_url").val();

            if (url) {
                var data = {
                    "url": url,
                };

                $.ajax({
                    type: "GET",
                    url: "{{url('getVdoThumbnail')}}",
                    data: data,
                    success: function (response) {
                        // console.log(response);return false;
                        var obj = JSON.parse(response);

                        if (obj.video_embed_code) {
                            $("#video_embed_code").val(obj.video_embed_code);
                            $("#video_embed_preview").attr('src', obj.video_embed_code);
                            $("#video_embed_preview").show();
                        }
                        if (obj.video_thumbnail) {
                            $("#video_thumbnail_url").val(obj.video_thumbnail);
                            var image = '<div class="post-select-image-container">' +
                                '<img src="' + obj.video_thumbnail + '" alt="">' +
                                '<a id="btn_delete_post_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
                                '<i class="fa fa-times"></i> ' +
                                '</a>' +
                                '</div>';
                            document.getElementById("post_select_image_container").innerHTML = image;
                        }
                    }
                });
            }
        }
    </script>
@stop

{{--@extends('layouts.admin')--}}
{{--@section('css')--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css"/>--}}
{{--    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">--}}
{{--    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/summernote/dist/summernote.css"/>--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin/assets/plugins/dropify/css/dropify.min.css')}}"/>--}}
{{--    <!-- Colorpicker Css -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />--}}
{{--    <!-- Multi Select Css -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/multi-select/css/multi-select.css">--}}
{{--    <!-- Bootstrap Spinner Css -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/jquery-spinner/css/bootstrap-spinner.css">--}}
{{--    <!-- Bootstrap Tagsinput Css -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">--}}
{{--    <!-- Bootstrap Select Css -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />--}}
{{--    <!-- noUISlider Css -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/nouislider/nouislider.min.css" />--}}
{{--    <!-- Select2 -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/plugins/select2/select2.css" />--}}

{{--    <!-- Custom Css -->--}}
{{--    <link rel="stylesheet" href="{{asset('assets/admin')}}/assets/css/style.min.css">--}}

{{--    <style>--}}
{{--        .checkbox .bootstrap-tagsinput {--}}
{{--            border: 1px solid #ccc !important;--}}
{{--        }--}}
{{--    </style>--}}
{{--@stop--}}
{{--@section('body')--}}
{{--    <div class="block-header">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-7 col-md-6 col-sm-12">--}}
{{--                <h2>Dashboard</h2>--}}
{{--                <ul class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}"><i class="zmdi zmdi-home"></i> Admin </a></li>--}}
{{--                    <li class="breadcrumb-item active">{{$page_heading}}</li>--}}
{{--                </ul>--}}
{{--                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="container">--}}
{{--        <form method="post" action="{{url('admin/create-post')}}" enctype="multipart/form-data" class="category_form">--}}
{{--            <div class="row clearfix">--}}
{{--                <div class="col-lg-7 col-md-7 col-sm-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="body">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="post_format" value="{{$_GET['type']}}" />--}}
{{--                            <div class="form-group">--}}
{{--                                <label class="control-label">Title</label>--}}
{{--                                <input type="text" id="wr_input_post_title" class="form-control" name="title" placeholder="Title" value="" required="">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label class="control-label">Slug <small>(If you leave it blank, it will be generated automatically.)</small>--}}
{{--                                </label>--}}
{{--                                <input type="text" class="form-control" name="title_slug" placeholder="Slug" value="">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label class="control-label">Summary &amp; Description (Meta Tag)</label>--}}
{{--                                <textarea class="form-control text-area" name="summary" placeholder="Summary &amp; Description (Meta Tag)"></textarea>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label class="control-label">Keywords (Meta Tag)</label>--}}
{{--                                <input type="text" class="form-control" name="keywords" placeholder="Keywords (Meta Tag)" value="">--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <label for="show_on_menu">--}}
{{--                                            <label><b>Visibility</b></label>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <div class="radio radio-inline">--}}
{{--                                            <input name="visibility" class="" type="radio" id="radio1" value="1" checked >--}}
{{--                                            <label for="radio1">Yes</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="radio radio-inline">--}}
{{--                                            <input name="visibility" class="checkbox-inline" type="radio"  id="radio2" value="0">--}}
{{--                                            <label for="radio2">No</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <label> <b>Tags</b></label>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="checkbox">--}}
{{--                                            <input type="text" name="tags" class="form-control" data-role="tagsinput" value="Amsterdam,Sydney,Cairo">--}}

{{--                                        </div>--}}
{{--                                        <small>(Type tag and hit enter)</small>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <label class="control-label">Summernote</label>--}}
{{--                                <textarea type="text" class="form-control summernote" name="blogcontent" placeholder="Keywords (Meta Tag)" value=""></textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-5 col-md-5 col-sm-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="body">--}}
{{--                            <div class="row">--}}
{{--                                @if($_GET['type'] == 'article')--}}
{{--                                    <div class="col-lg-12 col-md-12">--}}
{{--                                        <label> Image</label>--}}
{{--                                        <div class="input-group masked-input mb-3">--}}
{{--                                            <input type="file" class="form-control" name="image" placeholder="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label class="control-label">Image Description </label>--}}
{{--                                            <input type="text" class="form-control" name="image_description"--}}
{{--                                                   placeholder="Image description" value="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}

{{--                            </div>--}}
{{--                        </div>--}}


{{--                    </div>--}}

{{--                    <div class="card">--}}
{{--                        <div class="body">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <button type="submit" class="btn btn-raised btn-success btn-round waves-effect">Submit</button>--}}
{{--                                <?php--}}
{{--                                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard';--}}
{{--                                ?>--}}
{{--                                <a href="{{ url($referer) }}" class="btn btn-raised btn-danger waves-effect" >Back</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@stop--}}
{{--@section('js')--}}
{{--    <!-- Jquery DataTable Plugin Js -->--}}
{{--    <script src="{{asset('assets/admin')}}/assets/bundles/datatablescripts.bundle.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js -->--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->--}}
{{--    <script src="{{asset('assets/admin')}}/assets/js/pages/tables/jquery-datatable.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/summernote/dist/summernote.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/plugins/dropify/js/dropify.min.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/js/pages/forms/dropify.js"></script>--}}
{{--    <script src="{{asset('assets/admin')}}/assets/js/pages/forms/advanced-form-elements.js"></script>--}}


{{--    <script>--}}

{{--    </script>--}}
{{--@stop--}}
