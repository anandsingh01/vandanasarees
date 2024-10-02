<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/summernote/dist/summernote.css"/>

    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" />
    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/select2/select2.css" />
    
    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/summernote/dist/summernote.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/css/dropzone.css"/>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2><?php echo e($page_heading); ?></h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><i class="zmdi zmdi-home"></i> Admin </a></li>
                    <li class="breadcrumb-item active"><?php echo e($page_heading); ?></li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <form method="post" action="<?php echo e(url('admin/update-products/'.$product_details->id)); ?>" enctype="multipart/form-data">

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
                                    <input type="text" class="form-control" required
                                           value="<?php echo e($product_details->title); ?>" name="title" placeholder="Enter Product Title"/>
                                </div>

                                <div class="col-lg-6 col-md-6 mtb-10">
                                    <label class="control-label" for="Status">Section <br></label>
                                    <select name="section_id" class="form-control show-tick ms select2"
                                            id="section_id">
                                        <option>Select</option>
                                        <?php if(!empty($sections)): ?>
                                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($section->id); ?>" <?php echo e($product_details->section_id == $section->id ? 'selected':''); ?>><?php echo e($section->category_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6 mtb-10 parent_cat_div">
                                    <label class="">Category</label>
                                    <select name="category_ids" class="form-control show-tick ms select2 removeSpace"  id="category_ids" data-placeholder="Select">
                                        <option>Please Select An Option</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($categorys->id); ?>" <?php echo e($categorys->id == $product_details->category_id ? 'selected' : ''); ?>><?php echo e($categorys->category_name ?? ''); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
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
                                    <textarea class="summernote" name="product_short_desc"><?php echo $product_details->product_short_desc;?></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="">Product Description</label>
                                    <textarea class="summernote" name="product_desc"><?php echo $product_details->product_desc;?></textarea>
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
                                    <input type="number" class="form-control" name="product_actual_price"
                                           value="<?php echo e($product_details->product_actual_price); ?>"/>
                                </div>

                                <div class="col-md-6">
                                    <label class="">Max Selling Price</label>
                                    <input type="number" class="form-control" name="product_max_selling_price"
                                           value="<?php echo e($product_details->product_max_selling_price); ?>"/>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="">Stock </label>
                                    <input type="number" class="form-control" name="stock"
                                           value="<?php echo e($product_details->stock); ?>"
                                           placeholder="Stock"/>
                                </div>

                                <div class="col-md-6">
                                    <label class="">SKU</label>
                                    <input type="text" class="form-control" name="product_sku_id"
                                           value="<?php echo e($product_details->product_sku_id); ?>"
                                           placeholder="SKU"/>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="body">
                            <div class="form-group mtb-10">
                                <label class="control-label " for="password">Product Photo</label>
                                <input type="file" id="dropify-event" data-default-file="<?php echo e(asset('/'.$product_details->photo)); ?>" name="photo">

                            </div>
                            <div class="form-group mtb-10">
                                <label class="control-label " for="password">Img Alt</label>
                                <input type="text" value="<?php echo e($product_details->img_alt); ?>" name="img_alt" class="form-control" placeholder="Product Image Alt tag">
                            </div>
                            <div class="form-group mtb-10">

                                <div class="form-group mtb-10">
                                    <label class="control-label " for="password">Video</label>
                                    <input type="file" name="video">
                                    <span id="error-message" class="validation-error-label"></span><br>
                                </div>
                            </div>



                        </div>

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="body">
                            <div class="container">
                                <div class="form-group mtb-10">
                                    <label class="control-label" for="password">Product Photo (Drag & Drop into the box)</label>
                                    <input type="file" id="product-gallery" name="productgallery[]" class="form-control" multiple>
                                </div>
                                <div class="preview-images-zone">
                                    <div class="preview-image-container">
                                        <?php
                                        $product_gallery = \App\Models\Gallery::where('product_id',$product_details->id)->get();
                                        ?>
                                        <?php $__currentLoopData = $product_gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productGallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <img src="<?php echo e(asset($productGallery->image)); ?>" style="width: 80px;" class="img-thumbnail m-1">
                                            <button type="button" class="btn btn-danger btn-sm m-1 remove-preview-btn"
                                                    data-id="<?php echo e($productGallery->id); ?>">Remove</button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                                            <div class="row">


                                                <div class="col-lg-12 col-md-12 col-sm-6">
                                                    <div class="form-group mtb-10">
                                                        <label class="control-label " for="password">Certificate Of Authenticity</label>
                                                        <input type="file" class="form-control" name="cert_of_auth">
                                                        <?php if(!empty($product_details->cert_of_auth)): ?>
                                                            <img src="<?php echo e(asset($product_details->cert_of_auth)); ?>" style="width:100px;"/>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 mtb-10">
                                                    <label class="control-label " for="password"> Custom Duties & Import Taxes </label>
                                                    <textarea name="custom_duties" class="form-control summernote"><?php echo $product_details->custom_duties;?></textarea>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mtb-10">
                                                    <label class="control-label " for="password"> Color & Care </label>
                                                    <textarea name="color_and_care" class="form-control summernote"><?php echo $product_details->color_and_care;?></textarea>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mtb-10">
                                                    <label class="control-label " for="password"> Supplier Information</label>
                                                    <textarea name="supplier_info" class="form-control summernote"><?php echo $product_details->supplier_info;?></textarea>
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

                            <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingThree_1">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseThree_1" aria-expanded="false"
                                               aria-controls="collapseThree_1"> SEO <span class="text-right">+</span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_1">
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
                            <?php if(Auth::check()): ?>
                                <input type="hidden" name="userid" value="<?php echo e(Auth::user()->id); ?>"/>
                            <?php endif; ?>
                            <?php echo csrf_field(); ?>
                            <input type="submit" class="" value="Save & Continue" />
                                <?php
                                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/dashboard';
                                ?>
                                <a href="<?php echo e(url($referer)); ?>" class="btn btn-raised btn-danger waves-effect" >Back</a>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="<?php echo e(asset('/assets/admin/')); ?>/assets/js/pages/forms/dropify.js"></script>
    <script src="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/summernote/dist/summernote.js"></script>

    <script src="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
    <script src="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js -->
    <script src="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="<?php echo e(asset('/assets/admin/')); ?>/assets/js/pages/forms/advanced-form-elements.js"></script>


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
        $(document).ready(function(){
            $('#dropify-eventt').on('change',function(){
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

    <script>
        $('.section_id').change(function(){
            var section_id = $(this).val();
            $('.parent_cat_div  .select2-chosen').html('Please Select An Option');
            $('.subparent_cat_div  .select2-chosen').html('Please Select An Option');

            $.ajax({
                type:'get',
                url: '<?php echo e(url("/getcategoriesBySectionOnProduct")); ?>',
                data: {section_id: section_id},
                success:function(response){
                    $("#parent_id").empty();
                    $("#subparent_id").empty();

                    // Without parent div of select2 , don't change

                    $('#parent_id').html('Please Select An Option');
                    $.each(response, function(key, value) {
                        // console.log(value.title);
                        $('#parent_id').append('<option value="'+ value.id +'">'+ value.title +'</option>');
                        // $('#parent_id').val(1).trigger('change.select2');
                    });

                }
                ,error:function(){
                    alert('Error');
                }
            });
        });


        $('#parent_id').change(function(){

            var parent_id = $(this).val();
            $('.subparent_cat_div  .select2-chosen').html('Please Select An Option');

            // alert(parent_id); return false;
            $.ajax({
                type:'get',
                url: '<?php echo e(url("/getSubcategoriesByCategoriesOnProduct")); ?>',
                data: {parent_id: parent_id},
                success:function(response){
                    console.log(response);

                    $("#subparent_id").empty();

                    // Without parent div of select2 , don't change
                    $('.subparent_cat_div #select2-chosen-2').html('Please Select An Option');

                    $.each(response, function(key, value) {
                        console.log(value.title);
                        $('#subparent_id').append('<option value="'+ value.id +'">'+ value.title +'</option>');
                    });
                }
                ,error:function(){
                    alert('Error');
                }
            });
        });
    </script>
    <script>

        <?php if($product_details->video_type == 'video'): ?>
            $('#video').show();
        <?php else: ?>
            $('#url').show();
        <?php endif; ?>

        $(function() {
            $('#colorselector').change(function(){
                $('.video_upload').hide();
                $('#' + $(this).val()).show();
            });
        });

        <?php if($product_details->flash_sale == 'yes'): ?>
            $(document).ready(function(){
                $('#is_special_product').css('display','none');
                $('#is_flash_sale').css('display','block');
            });
        <?php endif; ?>

        <?php if($product_details->special_product == 'yes'): ?>
            $(document).ready(function(){
                $('#is_special_product').css('display','block');
                $('#is_flash_sale').css('display','none');
            });
        <?php endif; ?>

        $('#flash_sale').change(function() { //on change do stuff
            var is_Flash = $(this).val();
            if(is_Flash == 'yes'){
                $('#is_special_product').css('display','none');
                $('#is_flash_sale').css('display','block');
            }else{
                $('#is_flash_sale').css('display','none');

            }
        });
        $('#special_product').change(function() { //on change do stuff
            var is_Special = $(this).val();
            if(is_Special == 'yes'){
                $('#is_special_product').css('display','block');
                $('#is_flash_sale').css('display','none');
            }else{
                $('#is_special_product').css('display','none');

            }
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <script>
        // Function to handle the file input change event
        document.getElementById('product-gallery').addEventListener('change', function () {
            // Get the file input element
            const input = this;

            // Get the image preview container
            const imagePreviewContainer = document.querySelector('.preview-images-zone');

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
                removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'm-1', 'remove-preview-btn');
                removeBtn.addEventListener('click', function () {
                    // Remove the corresponding preview image and button
                    img.remove();
                    removeBtn.remove();
                });

                // Create a div to hold both the image and the remove button
                const previewContainer = document.createElement('div');
                previewContainer.classList.add('preview-image-container');
                previewContainer.appendChild(img);
                previewContainer.appendChild(removeBtn);

                // Append the image and remove button to the preview container
                imagePreviewContainer.appendChild(previewContainer);
            }
        });
    </script>

    <script>
        // Function to remove the image using AJAX
        function removeImage(imageId, previewContainer) {
            // Make an AJAX request to remove the image
            $.ajax({
                url: '<?php echo e(url('admin/remove_image')); ?>', // Replace this with the actual URL of your PHP script to handle the image removal
                type: 'GET',
                data: {image_id: imageId},
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Image removed successfully, remove the image container from the preview zone
                        $('#' + previewContainer).remove();
                    } else {
                        alert('Failed to remove image. Please try again.');
                    }
                },
                error: function() {
                    alert('Error occurred while removing image. Please try again.');
                }
            });
        }

        // Add click event listener to all the "Remove" buttons
        $('.remove-preview-btn').on('click', function() {
            var imageId = $(this).data('id');
            var previewContainer = $(this).closest('.preview-image-container').attr('id');

            // Call the removeImage function
            removeImage(imageId, previewContainer);
        });
    </script>







<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xampp\htdocs\silkashi\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>