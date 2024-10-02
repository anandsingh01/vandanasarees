@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/plugins/summernote/dist/summernote.css"/>
{{--    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/plugins/multi-select/css/multi-select.css">--}}
    <!-- Bootstrap Spinner Css -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/plugins/select2/select2.css" />
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/plugins/summernote/dist/summernote.css"/>
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/assets/css/dropzone.css"/>
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

        .preview-images-zone {
            width: 100%;
            border: 1px solid #ddd;
            min-height: 100px;
            /* display: flex; */
            padding: 5px 5px 0px 5px;
            position: relative;
            overflow:auto;
        }
        .preview-images-zone > .preview-image:first-child {
            height: 100px;
            width: 100px;
            position: relative;
            margin-right: 5px;
        }
        .preview-images-zone > .preview-image {
            height: 90px;
            width: 90px;
            position: relative;
            margin-right: 5px;
            float: left;
            margin-bottom: 5px;
        }
        .preview-images-zone > .preview-image > .image-zone {
            width: 100%;
            height: 100%;
        }
        .preview-images-zone > .preview-image > .image-zone > img {
            width: 100%;
            height: 100%;
        }
        .preview-images-zone > .preview-image > .tools-edit-image {
            position: absolute;
            z-index: 100;
            color: #fff;
            bottom: 0;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
            display: none;
        }
        .preview-images-zone > .preview-image > .image-cancel {
            font-size: 18px;
            position: absolute;
            top: 0;
            right: 0;
            font-weight: bold;
            margin-right: 10px;
            cursor: pointer;
            display: none;
            z-index: 100;
        }
        .preview-image:hover > .image-zone {
            cursor: move;
            opacity: .5;
        }
        .preview-image:hover > .tools-edit-image,
        .preview-image:hover > .image-cancel {
            display: block;
        }
        .ui-sortable-helper {
            width: 90px !important;
            height: 90px !important;
        }

        input#product-gallery {
            height: 200px;
        }
        img.img-thumbnail.m-1 {
            width: 100px;
            height: 100px;
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
        <form method="post" action="{{url('admin/save-products')}}" enctype="multipart/form-data">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong> Product</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 mtb-10">
                                    <label class="control-label" for="password">Product Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter Product Title"/>
                                </div>
{{--                                <div class="col-lg-12 col-md-12 mtb-10">--}}
{{--                                    <label class="control-label" for="password">Product Tagline</label>--}}
{{--                                    <input type="text" class="form-control" name="tagline" placeholder="Enter Product Tagline"/>--}}
{{--                                </div>--}}

                                <div class="col-lg-6 col-md-6 mtb-10">
                                    <label class="control-label" for="Status">Section <br></label>
                                    <select name="section_id" class="form-control show-tick ms select2 section_id" id="section_id" data-placeholder="Select">
                                        <option>Select</option>
                                        @if(!empty($sections))
                                            @foreach($sections as $section)
                                                <option value="{{$section->id}}">{{$section->category_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6 mtb-10 parent_cat_div">
                                    <label class="">Category</label>
                                    <select name="category_ids" class="form-control show-tick ms select2 removeSpace"  id="category_ids" data-placeholder="Select">
                                        <option>Please Select An Option</option>
                                        @forelse($category as $categorys)
                                            <option value="{{$categorys->id}}">{{$categorys->category_name ?? ''}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="">Product short description</label>
                                    <textarea class="summernote" name="product_short_desc"></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="">Product Description</label>
                                    <textarea class="summernote" name="product_desc"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="">Selling Price</label>
                                    <input type="number" class="form-control" name="product_actual_price" placeholder="Product Actual Price"/>
                                </div>

                                <div class="col-md-6">
                                    <label class="">Max Selling Price</label>
                                    <input type="number" class="form-control" name="product_max_selling_price" placeholder="Product Selling Price"/>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="">Stock </label>
                                    <input type="number" class="form-control" name="stock" placeholder="Stock"/>
                                </div>

                                <div class="col-md-6">
                                    <label class="">SKU</label>
                                    <input type="text" class="form-control" name="product_sku_id" placeholder="SKU"/>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="body">
                            <div class="form-group mtb-10">
                                <label class="control-label " for="password">Product Photo</label>
                                <input type="file" id="dropify-event" data-default-file="" name="photo">
{{--                                <span id="error-message" class="validation-error-label">File Should Not be above 2MB</span><br>--}}
                            </div>
                            <div class="form-group mtb-10">
                                <label class="control-label " for="password">Img Alt</label>
                                <input type="text" name="img_alt" class="form-control" placeholder="Product Image Alt tag">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="body">
                            <div class="container">
                                <div class="form-group  mtb-10">
                                    <label class="control-label " for="password">Product Photo (Drag & Drop into the box)</label>

                                    <input type="file" id="product-gallery" name="productgallery[]" class="form-control" multiple>
                                </div>
                                <div id="imagePreview">
                                    <!-- Preview images will be displayed here -->
                                </div>
                            </div>
                            <div class="form-group mtb-10">
                                <label class="control-label " for="password">Img Alt</label>
                                <input type="text" name="gallery_img_alt" class="form-control" placeholder="Product image tag">
                            </div>
                        </div>
                    </div>
                </div>

{{--                <div class="col-md-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group form-group mtb-10 ">--}}
{{--                                        <label class="control-label ">Is Featured ?</label>--}}
{{--                                        <select name="is_featured" id="is_featured">--}}
{{--                                            <option value="no">No</option>--}}
{{--                                            <option value="yes">Yes</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-md-12">--}}
{{--                    <div class="card">--}}
{{--                        <div class="body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                        <label class="control-label ">Flash Sale ?</label>--}}
{{--                                        <select name="flash_sale" id="flash_sale" class="form-control">--}}
{{--                                            <option value="no">No</option>--}}
{{--                                            <option value="yes">Yes</option>--}}
{{--                                        </select>--}}
{{--                                    <div class="form-group mtb-10 flash_sale" id="is_flash_sale"  style="display: none;">--}}
{{--                                        <div class="col-lg-12 col-md-12 mtb-10">--}}
{{--                                            <label class="control-label" for="password">Flash Price</label>--}}
{{--                                            <input type="text" class="form-control" name="flash_price" placeholder="Enter Flash Price"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-lg-12 col-md-12 mtb-10">--}}
{{--                                            <label class="control-label" for="password">Flash Sale Start</label>--}}
{{--                                            <input type="date" class="form-control" name="flash_price_start_date" placeholder="Enter Start"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-lg-12 col-md-12 mtb-10">--}}
{{--                                            <label class="control-label" for="password">Flash Sale End</label>--}}
{{--                                            <input type="date" class="form-control" name="flash_price_end_date" placeholder="Enter End Date"/>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-lg-12 col-md-12 mtb-10">--}}
{{--                                            <label class="control-label" for="password">Status</label>--}}
{{--                                            <select name="flash_product_status" class="form-control">--}}
{{--                                                <option value="active">Active</option>--}}
{{--                                                <option value="inactive">Inactive</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Product</strong> Additional Details</h2>
                        </div>
                        <div class="body">

                            <div class="panel-group" id="accordion_0" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingThree_0">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_0" href="#collapseThree_0" aria-expanded="false"
                                               aria-controls="collapseThree_0"> Additional Details <span class="text-right">+</span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree_0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_0">
                                        <div class="panel-body">
                                            <div class="row">

                                                <div class="col-md-12">

                                                    <h5>Details</h5>

                                                    <div class="row">


                                                        <div class="col-lg-12 col-md-12 col-sm-6">
                                                            <div class="form-group mtb-10">
                                                                <label class="control-label " for="password">Certificate Of Authenticity</label>
                                                                <input type="file" class="form-control" name="cert_of_auth">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-6 mtb-10">
                                                            <label class="control-label " for="password"> Custom Duties & Import Taxes </label>
                                                            <textarea name="custom_duties" class="form-control summernote"></textarea>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 mtb-10">
                                                            <label class="control-label " for="password"> Color & Care </label>
                                                            <textarea name="color_and_care" class="form-control summernote"></textarea>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 mtb-10">
                                                            <label class="control-label " for="password"> Supplier Information</label>
                                                            <textarea name="supplier_info" class="form-control summernote"></textarea>
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
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Product</strong> SEO</h2>
                        </div>
                        <div class="body">

                            <div class="panel-group" id="accordion_2" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingThree_2">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseThree_2" aria-expanded="false"
                                               aria-controls="collapseThree_2"> SEO <span class="text-right">+</span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_2">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 mtb-10">
                                                    <label class="control-label " for="password">Meta Title </label>
                                                    <input type="text" name="meta_title" class="form-control">
                                                </div>
                                                <div class="col-lg-12 col-md-12 mtb-10">
                                                    <label class="control-label " for="password">Meta Description </label>
                                                    <input type="text" name="meta_desc" class="form-control">
                                                </div>

                                                <div class="col-lg-12 col-md-12 mtb-10">
                                                    <label class="control-label " for="password">Meta Keywords </label>
                                                    <input type="text" class="form-control tags_border" data-role="tagsinput" name="meta_keywords" value="Amsterdam,Sydney,Cairo">
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

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            @if (Auth::check())
                                <input type="hidden" name="userid" value="{{Auth::user()->id}}"/>
                            @endif
                            @csrf
                            <input type="submit" class="btn btn-raised btn-primary waves-effect" value="Save & Continue" />
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
    <script src="{{asset('/assets/admin/')}}/assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="{{asset('/assets/admin/')}}/assets/js/pages/forms/dropify.js"></script>
    <script src="{{asset('/assets/admin/')}}/assets/plugins/summernote/dist/summernote.js"></script>

    <script src="{{asset('/assets/admin/')}}/assets/plugins/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
    <script src="{{asset('/assets/admin/')}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js -->
    <script src="{{asset('/assets/admin/')}}/assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="{{asset('/assets/admin/')}}/assets/js/pages/forms/advanced-form-elements.js"></script>


{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#section_id').on('change', function() {--}}
{{--                var sectionId = $(this).val();--}}
{{--                if(sectionId) {--}}
{{--                    $.ajax({--}}
{{--                        url: '{{ url("admin/get-categories-by-section") }}',--}}
{{--                        type: "GET",--}}
{{--                        data: { section_id: sectionId },--}}
{{--                        dataType: "json",--}}
{{--                        success: function(data) {--}}
{{--                            $('#category_ids').empty(); // Clear the existing options--}}
{{--                            if(data.length > 0) {--}}
{{--                                $('#category_ids').append('<option value="">Please Select An Option</option>');--}}
{{--                                $.each(data, function(key, value) {--}}
{{--                                    $('#category_ids').append('<option value="'+ value.id +'">'+ value.category_name +'</option>');--}}
{{--                                });--}}
{{--                            } else {--}}
{{--                                $('#category_ids').append('<option value="">No Categories Available</option>');--}}
{{--                            }--}}
{{--                        },--}}
{{--                        error: function(xhr, status, error) {--}}
{{--                            console.error(error);--}}
{{--                            alert('Error fetching categories');--}}
{{--                        }--}}
{{--                    });--}}
{{--                } else {--}}
{{--                    $('#category_ids').empty();--}}
{{--                    $('#category_ids').append('<option>Please Select An Option</option>');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--    </script>--}}
    <script>
        // Function to handle the file input change event
        document.getElementById('product-gallery').addEventListener('change', function () {
            // Get the file input element
            const input = this;

            // Get the image preview container
            const imagePreviewContainer = document.getElementById('imagePreview');

            // Clear any previous previews
            imagePreviewContainer.innerHTML = '';

            // Loop through selected files
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];

                // Create a new image element
                const img = document.createElement('img');
                img.classList.add('img-thumbnail', 'm-1'); // Add any CSS classes for styling

                // Set the image source to the selected file
                img.src = URL.createObjectURL(file);

                // Create a remove button for each image
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'm-1');
                removeBtn.addEventListener('click', function () {
                    // Remove the corresponding preview image and button
                    img.remove();
                    removeBtn.remove();
                });

                // Append the image and remove button to the preview container
                imagePreviewContainer.appendChild(img);
                imagePreviewContainer.appendChild(removeBtn);
            }
        });
    </script>
@stop
