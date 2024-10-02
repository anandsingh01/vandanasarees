<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('/assets/admin/')); ?>/assets/plugins/summernote/dist/summernote.css"/>

    <!-- Bootstrap Spinner Css -->
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
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin/dashboard')); ?>"><i class="zmdi zmdi-home"></i> Admin </a></li>
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
        <form method="post" action="<?php echo e(url('admin/save-products')); ?>" enctype="multipart/form-data">

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





                                <div class="col-lg-6 col-md-6 mtb-10">
                                    <label class="control-label" for="Status">Section <br></label>
                                    <select name="section_id" class="form-control show-tick ms select2 section_id" id="section_id" data-placeholder="Select">
                                        <option>Select</option>
                                        <?php if(!empty($sections)): ?>
                                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($section->id); ?>"><?php echo e($section->category_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6 mtb-10 parent_cat_div">
                                    <label class="">Category</label>
                                    <select name="category_ids" class="form-control show-tick ms select2 removeSpace"  id="category_ids" data-placeholder="Select">
                                        <option>Please Select An Option</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($categorys->id); ?>"><?php echo e($categorys->category_name ?? ''); ?></option>
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
                            <?php if(Auth::check()): ?>
                                <input type="hidden" name="userid" value="<?php echo e(Auth::user()->id); ?>"/>
                            <?php endif; ?>
                            <?php echo csrf_field(); ?>
                            <input type="submit" class="btn btn-raised btn-primary waves-effect" value="Save & Continue" />
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xampp\htdocs\silkashi\resources\views/admin/products/create.blade.php ENDPATH**/ ?>