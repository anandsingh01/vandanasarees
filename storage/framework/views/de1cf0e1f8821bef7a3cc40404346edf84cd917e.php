<?php $getCommonSetting = getCommonSetting();?>
<?php
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.
$url.= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$url.= $_SERVER['REQUEST_URI'];


?>
<meta property="og:url"           content="<?php echo $url;      ?>" />
<meta property="og:type"          content="<?php echo e($product->title); ?>" />
<meta property="og:title"         content="<?php echo e($product->title); ?>" />
<!-- Include jQuery from CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Elevate Zoom CSS from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.css">

<?php $__env->startSection('css'); ?>
    <style>
        .sticky_header{
            position:unset;
        }
        .watch_header + main {
            margin-top: 0px;
        }
        ul.nav.ul_li_block.clearfix li a img {
            width: 100%;
            height: 100px;
            float: left;
        }
        div#filteredProducts {
            width: 89%;
            margin: 0 auto;
        }
        .shop_details_image img {
            width: 100%;
            display: block;
            max-width: 100%;
            max-height: 600px;
            object-fit: contain;
        }
        .nav_wrap {
            height: auto;
            overflow-y: scroll;
        }
        .div_image img {
            max-height: 235px;
            max-width: 100%;
            height: 235px;
        }
        button.btn-color.active {
            border: 2px solid #333;
            border-radius: 50%;
        }
        section.details_section.furniture_details.sec_ptb_50.clearfix {
            padding: 3em 0;
        }
        @media only screen and (min-width: 320px) and (max-width: 767px){
            .deco_image.d-sm-none.d-xs-none{
                display: none;
            }
            .ce_breadcrumb_nav li:not(:last-child) {
                margin-right: 10px;
                padding-right: 10px;
            }
            .furniture_details .nav_wrap .nav li {
                float: left;
                width: 25%;
                display: inline-block;
                margin: 5px;
            }
            ul.nav.ul_li_block.clearfix li a img {
                width: 100%;
                height: 70px;
                float: left;
            }
            .shop_details_content .item_title {
                font-size: 22px;
            }
            ul.btns_group_1.ul_li.mb_30 li {
                display: contents;
            }
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <?php
    $get_hero_banner = get_hero_banner();
    $getCommonSetting = getCommonSetting();
    //    ?>


    <style>
        .product-image img {
            width: 100%;
            height: auto;
        }
        .product-options {
            margin-top: 15px;
        }
        .product-details {
            margin-top: 20px;
        }
        .price {
            font-size: 24px;
            font-weight: bold;
        }
        .btn-book {
            margin-top: 15px;
        }
        .small-text {
            font-size: 12px;
            color: #777;
        }
        .accordion .card-header {
            padding: 0;
            background: none;
            border: none;
        }
        .accordion .card {
            border: none;
        }
    </style>

    <style>
        /* Ensure all carousel images have the same height */
        .carousel img {
            height: 720px; /* Set a fixed height */
            object-fit: cover; /* Ensure the image covers the entire area without stretching */
        }

        /* Thumbnails styling */
        .thumbnail {
            padding: 5px;
        }

        /* Make all thumbnail images the same size */
        .thumbnail img {
            height: 100px; /* Set a fixed height for thumbnails */
            object-fit: cover; /* Ensure thumbnails are not stretched */
            width: 100%; /* Make sure the thumbnails take full width of the container */
        }

    </style>
    <section class="details_section furniture_details sec_ptb_50 clearfix">
        <div class="container-fluid prl_90">
            <div class="row mb_100 product_description justify-content-lg-between">
                <div class="col-lg-6">
                    <!-- Carousel for Product Images -->
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $product->getGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $productdetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset($productdetails->image)); ?>" class="d-block w-100 carousel-img" alt="Product Image <?php echo e($key + 1); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Controls for Main Carousel -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <!-- Thumbnails Section -->
                    <div class="row mt-2 text-center">
                        <div class="col-12 d-flex justify-content-center">
                            <?php $__currentLoopData = $product->getGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $productdetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="thumbnail mx-2" data-bs-target="#productCarousel" data-bs-slide-to="<?php echo e($key); ?>">
                                    <img src="<?php echo e(asset($productdetails->image)); ?>" alt="Thumbnail <?php echo e($key + 1); ?>" class="img-fluid thumbnail-img">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Styles -->
                    <style>
                        /* Set a fixed height for the main carousel images */
                        .carousel-img {
                            height: 500px;
                            object-fit: cover;
                        }

                        /* Thumbnails styling */
                        .thumbnail {
                            width: 80px; /* Fixed width for thumbnails */
                            height: 80px; /* Fixed height for thumbnails */
                            overflow: hidden; /* Hide overflow to prevent image distortion */
                            padding: 5px;
                            cursor: pointer;
                            display: flex; /* Use flexbox for proper centering */
                            align-items: center;
                            justify-content: center;
                        }

                        /* Make all thumbnail images fit properly without stretching */
                        .thumbnail-img {
                            width: 100%; /* Full width inside the thumbnail */
                            height: 100%; /* Full height inside the thumbnail */
                            object-fit: cover; /* Ensures image maintains aspect ratio and is cropped to fit */
                        }

                        /* Ensure the thumbnail container is centered */
                        .row.text-center {
                            justify-content: center;
                        }
                    </style>


                </div>

                <div class="col-lg-6">
                    <div class="shop_details_content">
                        <span class="f2p_code">Tpr: <?php echo e($product->product_sku_id); ?></span>
                        <h2 class="item_title text-uppercase"><?php echo e($product->title); ?></h2>
                        <hr>
                        <!-- Product Price and Savings Display -->
                        <span class="f2p_price mb_15">
    <strong style="font-size: 24px; color:green;">Rs. <?php echo e(number_format($product->product_actual_price, 2)); ?></strong>
    <del>Rs. <?php echo e(number_format($product->product_max_selling_price, 2)); ?></del>
    <br>
                            <!-- Display savings -->
    <span style="color: red; font-size: 18px;">
        You Save: Rs. <?php echo e(number_format($product->product_max_selling_price - $product->product_actual_price, 2)); ?>

        (<?php echo e(round((($product->product_max_selling_price - $product->product_actual_price) / $product->product_max_selling_price) * 100)); ?>%)
    </span>
</span>

                        <div>

                            <!-- Book a Video Call Session Button -->
                            <button type="button" class="btn btn-outline-danger mt-3" data-bs-toggle="modal" data-bs-target="#videoCallModal">
                                <img src="https://img.icons8.com/?size=50&id=37978&format=png" style="width:25px; "> Book a Video Call
                            </button>

                            <!-- Modal for Booking Video Call -->
                            <div class="modal fade" id="videoCallModal" tabindex="-1" aria-labelledby="videoCallModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="videoCallModalLabel">Book a Video Call Session</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form for Video Call Booking -->
                                            <form id="videoCallForm">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mobile" class="form-label">Mobile</label>
                                                    <input type="tel" class="form-control" id="mobile" name="mobile" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="date" name="date" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="time" class="form-label">Time</label>
                                                    <input type="time" class="form-control" id="time" name="time" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Book Session</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="row">

                            <style>
                                .product-action {
                                    display: flex;
                                    align-items: center;
                                    margin:15px 0;
                                }

                                .quantity-input {
                                    width: 30%;
                                    text-align: center;
                                    padding: 5px;
                                    margin-right: 10px;
                                    border: 1px solid #ccc;
                                    border-radius: 4px;
                                    font-size: 16px;
                                }

                                .btn-cart {
                                    background-color: #555;
                                    color: white;
                                    padding: 6px 20px;
                                    text-decoration: none;
                                    font-size: 16px;
                                    border-radius: 4px;
                                    cursor: pointer;
                                }

                                .btn-cart:hover {
                                    background-color: #444;
                                }

                                .product-action .fal {
                                    margin-right: 5px;
                                }

                            </style>
                            <div class="product-action">
                                <input type="number" id="quantityInput<?php echo e($product->id); ?>" value="1" min="1" max="3" class="quantity-input">
                                <a href="#"
                                   data-size="<?php echo e($product->size); ?>"
                                   data-id="<?php echo e($product->id); ?>"
                                   data-price="<?php echo e($product->product_actual_price); ?>"
                                   data-product_name="<?php echo e($product->title); ?>"
                                   data-qty="1"
                                   data-msp="<?php echo e($product->product_max_selling_price); ?>"
                                   data-image="<?php echo e($product->photo); ?>"
                                   data-variation_product_id="<?php echo e($product->product_id); ?>"
                                   data-flash_sale="<?php echo e($product->flash_sale); ?>"
                                   data-flash_price="<?php echo e($product->flash_price); ?>"
                                   data-color_id_attr="<?php echo e($product->getProductAttr[0]->id ?? '0'); ?>"
                                   class="btn-cart"
                                   id="qvid<?php echo e($product->id); ?>">
                                    <img src="https://img.icons8.com/?size=50&id=11938&format=png" style="width: 20px;"/> Add to Cart
                                </a>
                            </div>


                        </div>
                        <p class="mb-0">
                            <?php
                            echo $product->product_short_desc;
                            ?>
                        </p>
                        <p class="mb-0">
                            <?php
                            echo $product->product_desc;
                            ?>
                        </p>


                        <!-- Accordion Section -->
                        <style>
                            .accordion {
                                width: 100%;
                                margin: 25px auto;
                                border-top: 1px solid #ccc;
                            }

                            .accordion-item {
                                border: unset;
                            }

                            .accordion-button {
                                background-color: white;
                                border: none;
                                padding: 20px;
                                text-align: left;
                                width: 100%;
                                cursor: pointer;
                                outline: none;
                                font-size: 18px;
                                font-weight: bold;
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                transition: background-color 0.3s ease;
                            }

                            .accordion-button:hover {
                                background-color: #f8f8f8;
                            }

                            .accordion-content {
                                max-height: 0;
                                overflow: hidden;
                                padding: 0 20px;
                                transition: max-height 0.5s ease, padding 0.5s ease;
                            }

                            .accordion-content p {
                                margin: 20px 0;
                                font-size: 16px;
                                color: #555;
                            }

                            .accordion-button[aria-expanded="true"] + .accordion-content {
                                max-height: 300px; /* Adjust based on your content size */
                                padding: 20px;
                            }
                            .accordion-button:not(.collapsed){
                                background:unset;
                            }
                            .icon {
                                transition: transform 0.3s ease;
                                font-size: 18px;
                            }

                            .accordion-button[aria-expanded="true"] .icon {
                                transform: rotate(45deg);
                            }


                        </style>
                        <!-- Accordion Section -->

                        <div class="accordion">
                            <div class="accordion-item">
                                <button class="accordion-button" aria-expanded="false">
                                    <span>Certificate</span>

                                </button>
                                <div class="accordion-content">
                                    <img src="<?php echo e(asset($productdetails->cert_of_auth)); ?>">
                                </div>
                            </div>

                            <div class="accordion-item">
                                <button class="accordion-button" aria-expanded="false">
                                    <span>Specifications</span>

                                </button>
                                <div class="accordion-content">
                                    <p>Details about the specifications...</p>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <button class="accordion-button" aria-expanded="false">
                                    <span>About Product Images</span>

                                </button>
                                <div class="accordion-content">
                                    <p>Information about product images...</p>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <button class="accordion-button" aria-expanded="false">
                                    <span>Shipping & Delivery</span>

                                </button>
                                <div class="accordion-content">
                                    <p>Details about shipping and delivery...</p>
                                </div>
                            </div>
                        </div>


                        <script>
                            const accordions = document.querySelectorAll('.accordion-button');

                            accordions.forEach((accordion) => {
                                accordion.addEventListener('click', function () {
                                    const isExpanded = this.getAttribute('aria-expanded') === 'true';

                                    // Close all accordions
                                    accordions.forEach(btn => btn.setAttribute('aria-expanded', 'false'));

                                    // If this is not expanded, open it
                                    if (!isExpanded) {
                                        this.setAttribute('aria-expanded', 'true');
                                    }
                                });
                            });

                        </script>





                    </div>
                </div>
            </div>


            <!-- Product Slider Section -->
            <div class="container-fluid" style="margin: 2em 0;">
                <div class="heading text-center">
                    <h2 class="collection-title section_heading">You might also love</h2>
                </div>
            </div>
            <style>
                /* Product slider styles */
                .product-slider {
                    margin: 40px 0;
                    margin:0 auto;
                }

                .product-item {
                    padding: 15px;
                    text-align: center;
                    box-sizing: border-box;
                }

                .product-item img {
                    width: 100%;
                    height: auto;
                    object-fit: cover;

                    border-top-left-radius: 50%;
                    border-top-right-radius: 50%;
                }

                .product-title {
                    font-size: 15px;
                    margin-top: 10px;
                    font-weight: 300;
                }

                .product-price {
                    font-size: 16px;
                    color: #d9534f;
                    font-weight: 300;
                }

                .product-price-strike {
                    font-size: 14px;
                    text-decoration: line-through;
                    color: #999;
                    margin-left: 10px;
                }

                .product-slider.slick-initialized.slick-slider.slick-dotted{
                    width:95%;
                    margin:0 auto;
                }
                .product-slider .slick-slide img {
                    height:400px;
                    object-position: top;
                }
                h3.product-title a:hover {
                    color: maroon;
                }
            </style>
            <div class=" product-slider">

                <?php $__empty_1 = true; $__currentLoopData = $get_sarees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $get_sareess): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="product-item">
                        <a href="<?php echo e(url('products/'.$get_sareess->slug)); ?>">
                            <img src="<?php echo e(asset($get_sareess->photo)); ?>" alt="Beautiful Saffron Orange Lehenga With Heavy Hand Embroidery From Banaras">
                        </a>
                        <h3 class="product-title">
                            <a href="<?php echo e(url('products/'.$get_sareess->slug)); ?>">    <?php echo e($get_sareess->title); ?> </a>
                        </h3>
                        <p class="product-price">
                            <span class="currency-symbol">₹</span> <?php echo e(number_format($get_sareess->product_actual_price ?? '' , 2)); ?> <span
                                class="product-price-strike"><span class="currency-symbol">₹</span>  <?php echo e(number_format($get_sareess->product_max_selling_price ?? '', 2)); ?></span></p>



                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>

            </div>
        </div>

    </section>
    <!-- details_section - end
       ================================================== -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    
    <!----Carousel----->
    <script>
        // Fit inner div to gallery
        $('<div />', { 'class': 'inner'  }).appendTo('.gallery');

        // Create main image block and apply first img to it
        var imageSrc1 = $('.gallery').children('img').eq(0).attr('src');
        $('<div />', { 'class': 'main'  }).appendTo('.gallery .inner').css('background-image', 'url(' + imageSrc1 + ')');

        // Create image number label
        var noOfImages = $('.gallery').children('img').length;
        $('<span />').appendTo('.gallery .inner .main').html('Image 1 of ' + noOfImages);

        // Create thumb roll
        $('<div />', { 'class': 'thumb-roll'  }).appendTo('.gallery .inner');

        // Create thumbail block for each image inside thumb-roll
        $('.gallery').children('img').each( function() {
            var imageSrc = $(this).attr('src');
            $('<div />', { 'class': 'thumb'  }).appendTo('.gallery .inner .thumb-roll').css('background-image', 'url(' + imageSrc + ')');
        });

        // Make first thumbnail selected by default
        $('.thumb').eq(0).addClass('current');

        // Select thumbnail function
        $('.thumb').click(function() {

            // Make clicked thumbnail selected
            $('.thumb').removeClass('current');
            $(this).addClass('current');

            // Apply chosen image to main
            var imageSrc = $(this).css('background-image');
            $('.main').css('background-image', imageSrc);
            $('.main').addClass('main-selected');
            setTimeout(function() {
                $('.main').removeClass('main-selected');
            }, 500);

            // Change text to show current image number
            var imageIndex = $(this).index();
            $('.gallery .inner .main span').html('Image ' + (imageIndex + 1) + ' of ' + noOfImages);
        });

        // Arrow key control function
        $(document).keyup(function(e) {

            // If right arrow
            if (e.keyCode === 39) {

                // Mark current thumbnail
                var currentThumb = $('.thumb.current');
                var currentThumbIndex = currentThumb.index();
                if ( (currentThumbIndex+1) >= noOfImages) { // if on last image
                    nextThumbIndex = 0; // ...loop back to first image
                } else {
                    nextThumbIndex = currentThumbIndex+1;
                }
                var nextThumb = $('.thumb').eq(nextThumbIndex);
                currentThumb.removeClass('current');
                nextThumb.addClass('current');

                // Switch main image
                var imageSrc = nextThumb.css('background-image');
                $('.main').css('background-image', imageSrc);
                $('.main').addClass('main-selected');
                setTimeout(function() {
                    $('.main').removeClass('main-selected');
                }, 500);

                // Change text to show current image number
                $('.gallery .inner .main span').html('Image ' + (nextThumbIndex+1) + ' of ' + noOfImages);

            }

            // If left arrow
            if (e.keyCode === 37) {

                // Mark current thumbnail
                var currentThumb = $('.thumb.current');
                var currentThumbIndex = currentThumb.index();
                if ( currentThumbIndex == 0) { // if on first image
                    prevThumbIndex = noOfImages-1; // ...loop back to last image
                } else {
                    prevThumbIndex = currentThumbIndex-1;
                }
                var prevThumb = $('.thumb').eq(prevThumbIndex);
                currentThumb.removeClass('current');
                prevThumb.addClass('current');

                // Switch main image
                var imageSrc = prevThumb.css('background-image');
                $('.main').css('background-image', imageSrc);
                $('.main').addClass('main-selected');
                setTimeout(function() {
                    $('.main').removeClass('main-selected');
                }, 500);

                // Change text to show current image number
                $('.gallery .inner .main span').html('Image ' + (prevThumbIndex+1) + ' of ' + noOfImages);

            }

        });

    </script>
    <!----Carousel----->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!----Review ---->
    <script>
        $(document).ready(function() {
            $('#review-form').submit(function(event) {
                event.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo e(url("save-review")); ?>', // Update with the actual route
                    data: formData,
                    success: function(response) {
                        // Review saved successfully, fetch and display approved reviews
                        // Product added to cart
                        Swal.fire({
                            icon: 'success',
                            title: 'Review will update soon',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // fetchApprovedReviews();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            
            
            
            
            
            
            

            // Fetch and display approved reviews on page load
            // fetchApprovedReviews();
        });
    </script>
    <script>
        $(document).ready(function(){
            if(screen.width > 768){

            }else{
                $(".input-group-append").css("margin-left", "30px");
                $(".input-group-prepend").css("margin-left", "25px");


            }
        });

    </script>
    <script>
        $(document).ready(function(){
            if(screen.width > 768){
                $(".qtybtn1").css("margin-bottom", "10px");
            }else{
                //alert("hello");

                $(".imgStyle").css("height", "210px");
                $(".qtybtn1").css("margin-bottom", "40px");
                $(".bannerbtn").css("zoom", "0.4");
                $("#qtybox").css("margin-left", "-20px");
            }

        });
    </script>

    <script>
        $(document).ready(function() {
            const addToCartButton = $('.btn-cart');


            // Add to Cart button click event
            addToCartButton.on('click', function(event) {

                const qtyInput = $('#qty');
                const maxLimitMsg = $('#maxLimitMsg');
                const loader = $('#loader');

                let productid = $(this).data('id');
                // alert(productid);
                // return false;
                let selectedPrice = $(this).data('price');
                let product_name = $(this).data('product_name');
                let msp = $(this).data('msp');
                let image = $(this).data('image');
                let flash_sale = $(this).data('flash_sale');
                let flash_price = $(this).data('flash_price');
                let selectedQty = $(this).attr('data-qty');
                let color_id_attr = $(this).attr('data-color_id_attr');

                event.preventDefault();

                $.ajax({
                    url: '<?php echo e(url('addToCart')); ?>',
                    method: 'POST',
                    data: {
                        price: selectedPrice,
                        flash_price: flash_price, // Add flash_price to the data object
                        flash_sale: flash_sale, // Add flash_ to the data object
                        quantity: selectedQty,
                        subtotal: (flash_sale === 'yes') ? flash_price : selectedPrice * selectedQty,
                        product_name: product_name,
                        color_id_attr: color_id_attr,
                        product_id: productid,
                        msp: msp
                    },
                    success: function(response) {
                        // Hide loader

                        console.log(response);


                        if(response.code == 200){
                            toastr.success('Added to Cart Successfully', 'Success', { timeOut: 1000 });
                            $('.cartQtyno').text(response.qty.cartqty);
                        }
                        if(response.code == 429){
                            toastr.error('Cart Limit Exceed', 'Not Added', { timeOut: 1500 });
                        }
                        if(response.code == 301){
                            toastr.success('Added to Cart Successfully', 'Success', { timeOut: 1000 });
                            $('.cartQtyno').text(response.qty.cartqty);


                        }

                        return  false;

                    },
                    error: function(xhr, status, error) {
                        // Hide loader
                        loader.hide();

                        // Handle error if needed
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xampp\htdocs\silkashi\resources\views/web/product-details.blade.php ENDPATH**/ ?>