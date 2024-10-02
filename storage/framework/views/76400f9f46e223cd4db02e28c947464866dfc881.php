<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $getCommonSetting = getCommonSetting();
        $get_footer_banner = get_footer_banner();
        $get_cart = get_cart();
        $getcount = json_decode($get_cart);
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($getCommonSetting->site_title); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(asset($getCommonSetting->favicon)); ?>" type="image/x-icon">

    <style>
        .poppins-thin {
            font-family: "Poppins", sans-serif;
            font-weight: 100;
            font-style: normal;
        }

        .poppins-extralight {
            font-family: "Poppins", sans-serif;
            font-weight: 200;
            font-style: normal;
        }

        .poppins-light {
            font-family: "Poppins", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .poppins-regular {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .poppins-medium {
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        .poppins-semibold {
            font-family: "Poppins", sans-serif;
            font-weight: 600;
            font-style: normal;
        }

        .poppins-bold {
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .poppins-extrabold {
            font-family: "Poppins", sans-serif;
            font-weight: 800;
            font-style: normal;
        }

        .poppins-black {
            font-family: "Poppins", sans-serif;
            font-weight: 900;
            font-style: normal;
        }

        .poppins-thin-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 100;
            font-style: italic;
        }

        .poppins-extralight-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 200;
            font-style: italic;
        }

        .poppins-light-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 300;
            font-style: italic;
        }

        .poppins-regular-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: italic;
        }

        .poppins-medium-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-style: italic;
        }

        .poppins-semibold-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 600;
            font-style: italic;
        }

        .poppins-bold-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            font-style: italic;
        }

        .poppins-extrabold-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 800;
            font-style: italic;
        }

        .poppins-black-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 900;
            font-style: italic;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="https://md-aqil.github.io/images/swiper.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Custom Styles -->
    <style>
        *{
            font-family: "Poppins", sans-serif;
        }
        a{
            text-decoration: none;
            color:unset;
        }

        .dark-pink {
            background: #ff9494;
            color: #000;
            border: unset;
            width: 100%;
        }

        .dark-pink:hover{
            background: #333;
            color: #fff;
        }

    </style>

    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>

<style>


    .top-banner {
        background-color: #f7e2e2;
        text-align: center;
        padding: 10px;
        color: #7c1c1c;
        font-size: 14px;
    }

    /* Header layout */
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: white;
        border-bottom: 1px solid #eee;
        position: relative;
    }

    .logo img {
        width: 150px;
    }

    .search-bar {
        flex-grow: 1;
        max-width: 500px;
        margin: 0 20px;
        position: relative;
    }

    .search-bar input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-bar button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 16px;
        color: #666;
        cursor: pointer;
    }

    .header-icons {
        display: flex;
        align-items: center;
    }

    .header-icons i {
        margin-left: 20px;
        font-size: 22px;
        color: #7c1c1c;
    }

    .language-flag img {
        width: 30px;
        margin-right: 10px;
    }

    /* Hamburger Menu */
    .hamburger {
        display: none;
        font-size: 24px;
        color: #7c1c1c;
        cursor: pointer;
    }

    /* Navbar styling */
    .navbar {
        background-color: white;
        border-top: 1px solid #eee;
        padding: 10px 20px;
        justify-content: center;
    }

    .navbar ul {
        list-style: none;
        display: flex;
        justify-content: center;
    }

    .navbar ul li {
        margin: 0 15px;
    }

    .navbar ul li a {
        text-decoration: none;
        font-size: 16px;
        color: #7c1c1c;
        font-weight: 500;
    }

    .navbar ul li a:hover {
        color: #b32a2a;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
        /* Stack the header elements */
        .header-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-bar {
            margin: 10px 0;
            width: 100%;
        }

        /* Hide icons, logo stays centered */
        .header-icons {
            display: none;
        }

        /* Hamburger Menu appears */
        .hamburger {
            display: block;
        }

        /* Navbar hidden by default */
        .navbar ul {
            display: none;
            flex-direction: column;
            width: 100%;
        }

        /* Toggle menu active on click */
        .navbar ul.active {
            display: flex;
        }

        .navbar ul li {
            margin: 10px 0;
            text-align: left;
        }
    }

    @media screen and (max-width: 480px) {
        /* Smaller screens adjustments */
        .logo img {
            width: 120px;
        }

        .search-bar input {
            font-size: 14px;
        }
    }
</style>

<header>
    <div class="top-banner">
        <p>Free shipping on orders above 25000/-</p>
    </div>

    <div class="header-container">
        <div class="logo">
            <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset($getCommonSetting->logo_header)); ?>" alt="Vandana Sarees"></a>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Find Your Saree...">
            <button><i class="fas fa-search"></i></button>
        </div>
        <div class="header-icons">
            <a href="<?php echo e(url('login')); ?>">
                <i class="fas fa-user-circle"></i>
            </a>
            <i class="fas fa-heart"></i>
            <a class="nav-link" href="<?php echo e(url('/checkout/cart')); ?>" style="position: relative;">
                <i class="fas fa-shopping-bag"></i>
                <!-- Display number at the bottom -->
                <span style="color:#000; position: absolute; bottom: -5px; right: 0%; transform: translateX(-50%); font-size: 15px;">
                            <?php echo e($getcount->count ?? '0'); ?>

                        </span>
            </a>

        </div>
        <!-- Hamburger Menu Icon for Mobile -->
        <div class="hamburger" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </div>

    <!-- Navbar (hidden by default on mobile) -->
    <nav class="navbar">
        <ul id="nav-menu">
            <li><a href="#">Shop By</a></li>
            <li><a href="#">Kanchipuram</a></li>
            <li><a href="#">Fabric</a></li>
            <li><a href="#">Occasion</a></li>
            <li><a href="#">Accessories</a></li>
            <li><a href="#">Suits</a></li>
            <li><a href="#">Blog</a></li>
        </ul>
    </nav>

</header>

<script>
    // Function to toggle mobile menu
    function toggleMenu() {
        const navMenu = document.getElementById('nav-menu');
        navMenu.classList.toggle('active');
    }
</script>

<div class="section content-start">
    <?php echo $__env->yieldContent('body'); ?>
</div>




<style>
    .footer {
        background: url(<?php echo e(asset($get_footer_banner->banner)); ?>);
        color: #fff;
        padding: 40px 0;
        font-size: 14px;
    }

    .footer {
        background: url(<?php echo e(asset($get_footer_banner->banner)); ?>);/* Replace with your background image URL */
        background-size: cover;
        background-position: center;
        padding: 60px 0;
        position: relative;
        color: #fff; /* Change text color to white for better contrast with overlay */
        z-index: 1;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
        z-index: -1; /* Ensure the overlay is behind the content */
    }

    .footer-logo {
        max-width: 150px;
        margin-bottom: 20px;
    }

    .footer h5 {
        font-size: 16px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .footer ul {
        padding-left: 0;
        list-style: none;
    }

    .footer ul li {
        margin-bottom: 10px;
    }

    .footer ul li a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer ul li a:hover {
        color: #f0a500;
    }

    .footer .social-icons a {
        margin-right: 15px;
        font-size: 18px;
        color: #333;
    }

    .footer .social-icons a:hover {
        color: #f0a500;
    }

    .footer .payment-icons img {
        max-width: 50px;
        margin: 10px;
    }

    .footer address {
        font-style: normal;
        line-height: 1.6;
    }

    .footer .form-inline .form-control {
        width: auto;
        margin-right: 10px;
    }

    .footer .form-inline .btn {
        background-color: #333;
        color: #fff;
        border: none;
    }

    .footer .form-inline .btn:hover {
        background-color: #f0a500;
    }

</style>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="<?php echo e(asset($getCommonSetting->logo_header)); ?>" class="footer-logo">
                <address>
                    <?php echo e($getCommonSetting->contact_address); ?>

                    <br>
                    <strong>Phone:</strong> <a href="tel:<?php echo e($getCommonSetting->contact_phone); ?>"><?php echo e($getCommonSetting->contact_phone); ?></a><br>
                    <strong>Email:</strong> <a href=""><?php echo e($getCommonSetting->contact_email); ?></a>
                </address>
            </div>
            <div class="col-md-3">
                <h5>Legals</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Exchange Policy</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <h5>Informations</h5>
                <ul class="list-unstyled">
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Press & Media</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Frequently Asked Questions</a></li>
                    <li><a href="#">e-Gift Card</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Customer Services</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Reward Points</a></li>
                    <li><a href="#">Suit Stitching</a></li>
                    <li><a href="#">Blouse Stitching</a></li>
                    <li><a href="#">Lehenga Stitching</a></li>
                    <li><a href="#">Petticoat</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                
                
                
                
                
                <p>&copy; <?php echo e($getCommonSetting->copyright); ?>.</p>
                <div class="payment-icons">
                    <img src="https://via.placeholder.com/50x50?text=Vandana Sarees" alt="Payment Method 1">
                    <img src="https://via.placeholder.com/50x50?text=Vandana Sarees" alt="Payment Method 2">
                    <img src="https://via.placeholder.com/50x50?text=Vandana Sarees" alt="Payment Method 3">
                </div>
            </div>
        </div>
    </div>
</footer>




<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Include Slick Slider JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script src="https://md-aqil.github.io/images/swiper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.product-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>
<script>
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: '2',
        // coverflowEffect: {
        //   rotate: 50,
        //   stretch: 0,
        //   depth: 100,
        //   modifier: 1,
        //   slideShadows : true,
        // },

        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 50,
            modifier: 6,
            slideShadows : false,
        },

    });


    var galleryTop = new Swiper('.swiper-container.testimonial', {
        speed: 400,
        spaceBetween: 50,
        autoplay: {
            delay: 3000.00,
            disableOnInteraction: false,
        },
        direction: 'vertical',
        pagination: {
            clickable: true,
            el: '.swiper-pagination',
            type: 'bullets',
        },
        thumbs: {
            swiper: galleryThumbs
        }
    });

</script>
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('js'); ?>
<!-- Initialize Slick Slider -->

</body>
</html>



<?php /**PATH H:\xampp\htdocs\silkashi\resources\views/layouts/web.blade.php ENDPATH**/ ?>