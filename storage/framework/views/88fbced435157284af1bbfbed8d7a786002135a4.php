<?php
session_start();
$get_category = get_category();
$get_brands = get_brands();
?>
<?php $__env->startSection('css'); ?>
    <style>
        body {
            position: relative;
        }

        .product-card {
            border: 1px solid #e0e0e0;
            text-align: center;
            padding: 15px;
            background-color: #ffffff;
            position: relative;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
        }

        .product-card .product-info {
            margin-top: 10px;
        }

        .product-card .product-price {
            color: #333;
        }

        .product-card .product-discounted {
            color: #b12704;
            text-decoration: line-through;
            margin-right: 5px;
        }

        .filter-btn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }

        /* Filter slider */
        .filter-slider {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 3;
            top: 0;
            left: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            border-right: 1px solid #e0e0e0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .filter-slider .closebtn {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 36px;
            cursor: pointer;
            color: #333;
        }

        .filter-slider .filter-content {
            padding: 20px;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 2;
            display: none;
        }

        /* Ratings */
        .product-rating {
            color: gold;
        }

        /* Text colors */
        .product-info h5, .filter-slider h4 {
            color: #333;
        }


    </style>

    <style>
        .banner {
            background-image: url(<?php echo e(asset($sections->image)); ?>);
            background-size: cover;
            background-position: center center;
            height: 70vh;
            border-image: fill 0 linear-gradient(#0003, #000);
            display: grid;
            place-items: center;
            padding: 2rem;
        }


        .banner .tooltip {
            width: 300px;
            background: yellow;
            height: 100px;
            color: #fff;
            font-size: 20px;
            padding: 20px;
            text-align: center;
            top: anchor(10px);
        }

        .banner h2 {
            color: #fff;
            text-align: center;
        }

    </style>

    <style>
        .product-slider .slick-slide img {
            height: 400px;
            object-position: top;
        }

        h3.product-title a:hover {
            color: maroon;
        }

        h3.product-title {
            font-size: 16px;
            margin: 15px 0;
        }

        .product-item img {
            width: 100%;
            border-top-left-radius: 50%;
            border-top-right-radius: 50%;
            height: 400px;
        }

        .product-price-strike {
            color: maroon;
            font-size: 14px;
        }

        .sale_price {
            font-size: 18px;
        }

        .discount-percentage {
            font-size: 12px;
            font-weight: 600;
            background: maroon;
            color: #fff;
            padding: 0px 10px;
        }

        h3.product-title {
            font-size: 16px;
            margin: 15px 0;
            font-weight: unset;
        }

        .product-desc:hover {
            box-shadow: 0px 0px 15px #ddd;
        }

        .col-md-3.mt-3.product-desc {
            padding: 15px 15px;
        }
    </style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();
    ?>


    <div class="overlay" id="overlay"></div>

    <section class="banner">

        <div class="container ">
            <h2><?php echo e($sections->category_name); ?></h2>
        </div>
    </section>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <button class="filter-btn" onclick="openFilter()">Filter</button>
            </div>
            <div>
                <span><?php echo e(count($sections->get_products ?? '')); ?> products</span>
            </div>
            <div>
                <select name="sortby" id="sortby2" class="form-control">

                    <option value="newarrivals">New Arrivals</option>
                    <option value="lowtohigh">Low To High</option>
                    <option value="hightolow">High To Low</option>
                </select>
            </div>
            <input type="hidden" name="section_id" id="section_id" value="<?php echo e($sections->id ?? ''); ?>">
        </div>



        <div class="row product-list">
            <?php $__empty_1 = true; $__currentLoopData = $sections->get_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getProducts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-3 mt-3 product-desc">
                    <div class="product-item">
                        <a href="<?php echo e(url('products/'.$getProducts->slug)); ?>">
                            <img src="<?php echo e(asset($getProducts->photo)); ?>"
                                 alt="<?php echo e($getProducts->title); ?>">
                        </a>
                        <h3 class="product-title text-center">
                            <a href="<?php echo e(url('products/'.$getProducts->slug)); ?>"><?php echo e($getProducts->title); ?></a>
                        </h3>
                        <p class="product-price text-center">
                            <span class="currency-symbol">₹</span>
                            <span class="sale_price"><?php echo e(number_format($getProducts->product_actual_price ?? 0 , 2)); ?></span>
                            <del class="product-price-strike">
                                <span class="currency-symbol">₹</span>
                                <?php echo e(number_format($getProducts->product_max_selling_price ?? 0, 2)); ?>

                            </del>
                            <br>
                            <?php if(!empty($getProducts->product_max_selling_price) && !empty($getProducts->product_actual_price)): ?>
                                <?php
                                    $discount = (($getProducts->product_max_selling_price - $getProducts->product_actual_price) / $getProducts->product_max_selling_price) * 100;
                                ?>
                                <span class="discount-percentage"><?php echo e(number_format($discount, 2)); ?>% OFF</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <p>No products found.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Filter Slider -->
    <div id="filterSlider" class="filter-slider">
        <span class="closebtn" onclick="closeFilter()">&times;</span>
        <div class="filter-content">
            <h4>Filter Options</h4>
            <!-- Filter content goes here -->
            <form>
                <div class="form-group">
                    <label for="priceRange">Price Range</label>
                    <input type="range" class="form-control-range" id="priceRange">
                </div>
                <div class="form-group my-3">
                    <label for="categoryFilter">Categories</label>
                    <div id="categoryFilter">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo e($category->id); ?>" id="category<?php echo e($category->id); ?>">
                                <label class="form-check-label" for="category<?php echo e($category->id); ?>">
                                    <?php echo e($category->category_name); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <script>
        function openFilter() {
            document.getElementById("filterSlider").style.width = "250px";
            document.getElementById("overlay").style.display = "block";
        }

        function closeFilter() {
            document.getElementById("filterSlider").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#sortby2').on('change', function () {
                const selectedSort = $(this).val();
                const sectionId = $('#section_id').val();

                $.ajax({
                    url: "<?php echo e(url('/filter-by-price')); ?>",
                    method: 'GET',
                    data: {
                        sortby: selectedSort,
                        section_id: sectionId,
                    },
                    success: function (response) {
                        // Replace the product list with the filtered/sorted products
                        $('.product-list').html(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });

    </script>


    <script>
        $('.button').click(function () {
            var buttonId = $(this).attr('id');
            $('#modal-container').removeAttr('class').addClass(buttonId);
            $('body').addClass('modal-active');
        })

        $('#modal-container').click(function () {
            $(this).addClass('out');
            $('body').removeClass('modal-active');
        });
    </script>
    <script>

        $(document).ready(function () {
            $('.quick-view-link11').on('click', function (e) {
                e.preventDefault();
                var productId = $(this).data('product-id');

                $.ajax({
                    url: "<?php echo e(url('getProductDetails')); ?>/" + productId,
                    method: "GET",
                    dataType: "json",
                    success: function (response) {
                        console.log(response);

                        if (response.success) {
                            var product = response.product;
                            $('#modal-container .productImage').attr('src', product.photo);
                            $('#modal-container .item_title').text(product.title);
                            $('#modal-container .item_price').text('Rs. ' + product.product_actual_price);
                            $('#modal-container .short_desc').html(product.product_short_desc);
                            $('#modal-container .category').text(product.sections.category_name);
                            $('#modal-container .size').text(product.size);


                            // Update other modal content with product details
                        } else {
                            // Handle error
                        }
                    },
                    error: function (error) {
                        // Handle error
                    }
                });
            });
        });
    </script>
    <?php echo $__env->make('inc.web.sidebar-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>















































































































































































































<!-- End .main -->



<?php echo $__env->make('layouts.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xampp\htdocs\silkashi\resources\views/web/shop.blade.php ENDPATH**/ ?>