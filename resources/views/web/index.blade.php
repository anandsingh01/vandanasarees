<?php $getCommonSetting = getCommonSetting(); ?>
@extends('layouts.web')
@section('css')
    <style>
        .carousel-inner {
            width: 100%;
            max-height: 700px; /* Set a max height for the carousel */
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            min-height: 100vh;
        }

        .header-text {
            position: absolute;
            bottom: 20%;
            left: 5%;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            z-index: 10;
        }

        /* Product slider styles */
        .product-slider {
            margin: 40px 0;
            margin: 0 auto;
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

        .product-slider.slick-initialized.slick-slider.slick-dotted {
            width: 95%;
            margin: 0 auto;
        }

        /* Ensure carousel controls are on top of images */
        .carousel-control-prev, .carousel-control-next {
            z-index: 11;
        }

        /* Collection title */
        .collection-title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
        }

        .section_heading {
            padding: 0;
            margin-bottom: 0;
        }


    </style>

@stop
@section('body')
    <!-- Banner Slider -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($get_hero_banner as $bannerkey => $banner)
                <div class="carousel-item {{$bannerkey == 0 ? 'active' : ''}}">
                    <img src="{{ asset($banner->banner) }}" class="d-block w-100" alt="Banner {{$bannerkey + 1}}">
                    <div class="carousel-caption d-non1e d-md-block">
                        <h5>{{ $banner->banner_heading }}</h5>
                        <p>{{ $banner->banner_subheading }}</p>
                        @if($banner->button_text && $banner->button_url)
                            <a href="{{ $banner->button_url }}" class="btn btn-primary">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Optionally add a fallback banner if no banners are available -->
                <div class="carousel-item active">
                    <img src="path/to/default/banner.jpg" class="d-block w-100" alt="Default Banner">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Default Heading</h5>
                        <p>Default Subheading</p>
                        <a href="#" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            @endforelse
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <style>

        .main-content {
            background-color: #fff;
            text-align: center;
            padding: 0;
            margin-bottom: 2em;
        }

        .main-content h1 {
            font-size: 28px;
            color: #8e2832;
        }

        .main-content .features {
            display: flex;
            justify-content: space-around;

        }

        .feature-item {
            text-align: center;
            /*max-width: 150px;*/
        }

        .feature-item img {
            height: 80px;
            margin-bottom: 10px;
            border: 2px solid;
            border-radius: 50%;
            padding: 15px;
        }

        .feature-item h3 {
            font-size: 18px;
            color: #8e2832;
            margin-bottom: 5px;
        }

        .feature-item p {
            font-size: 14px;
            color: #333;
        }
    </style>
    <div class="main-content ">
        <h2 class="collection-title py-5">Our Legacy</h2>
        <div class="container">
            <div class="features row">

                <div class="feature-item col-md-3 col-sm-3 col-xs-3 col-6">
                    <img
                        src="https://cdn-icons-png.freepik.com/256/15682/15682984.png?ga=GA1.1.98304431.1716115737&semt=ais_hybrid"
                        alt="Family">
                    <h3>Instant shipping </h3>
                </div>
                <div class="feature-item col-md-3 col-sm-3 col-xs-3 col-6">
                    <img
                        src="https://cdn-icons-png.freepik.com/256/12838/12838411.png?ga=GA1.1.98304431.1716115737&semt=ais_hybrid"
                        alt="Handloom">
                    <h3>Authentic Handlooms</h3>
                </div>
                <div class="feature-item col-md-3 col-sm-3 col-xs-3 col-6">
                    <img
                        src="https://cdn-icons-png.freepik.com/256/5277/5277616.png?ga=GA1.1.98304431.1716115737&semt=ais_hybrid"
                        alt="Legacy">
                    <h3>Legacy since 1974</h3>
                </div>
                <div class="feature-item col-md-3 col-sm-3 col-xs-3 col-6">
                    <img
                        src="https://cdn-icons-png.freepik.com/256/7665/7665890.png?ga=GA1.1.98304431.1716115737&semt=ais_hybrid"
                        alt="India">
                    <h3>Silk mark </h3>
                </div>
            </div>
        </div>
    </div>



    <style>
        .collection-section {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .collection-item {
            position: relative;
            color: white;
            text-align: left;
            overflow: hidden;
        }

        .collection-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.5s ease;
            height: 500px;
        }

        .collection-item:hover img {
            transform: scale(1.1);
        }

        .collection-content {
            position: absolute;
            bottom: 4em;
            left: 3em;
            z-index: 2;
        }


        .collection-text {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .btn-shop {
            background-color: white;
            color: black;
            border-radius: 25px;
            font-weight: bold;
            padding: 10px 20px;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .btn-shop:hover {
            background-color: black;
            color: white;
        }

        .second_section .slick-initialized .slick-slide {
            padding: 5px;
        }


    </style>
    <!-- Collection Section -->
    <div class="container-fluid second_section">
        <h2 class="collection-title section_heading py-5">OUR COLLECTIONS</h2>
        <div class="row">
            <div class="collection-slider">
                @forelse($section_on_home as $key => $section_on_homes)
                    <div class="collection-item">
                        <img src="{{asset($section_on_homes->image)}}" alt="Handwoven Sarees">
                        <div class="collection-content">
                            {{--                        <p class="collection-text">THE FINEST</p>--}}
                            <h3 class="collection-title1">{{$section_on_homes->category_name}}</h3>
                            <a href="{{url('collections/'.$section_on_homes->slug)}}" class="btn btn-shop">SHOP NOW</a>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>


        </div>
    </div>



    <style>
        .hero-section1 {
            position: relative;
            height: 100vh;
            background-image: url({{asset($get_below_banner->banner)}});
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hero-content1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #fff;
        }

        .hero-content1 h1 {
            font-size: 5rem;
            letter-spacing: 0.1rem;
            text-transform: uppercase;
            font-weight: 800;
        }

        .hero-content1 p {
            font-size: 1.2rem;
            margin: 2em 0 2em;
        }

        .hero-content1 .btn {
            padding: 10px 30px;
            font-size: 1rem;
            text-transform: uppercase;
            border: 2px solid #fff;
            background-color: transparent;
            color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }

        .hero-content1 .btn:hover {
            background-color: #fff;
            color: #000;
        }
    </style>
    <div class="hero-section1 my-5">
        <div class="hero-content1">
            <h1>{{$get_below_banner->banner_heading ?? ''}}</h1>
            <h4>{{$get_below_banner->banner_subheading ?? ''}}</h4>
            <p>{{$get_below_banner->banner_description ?? ''}}</p>
            <a href="{{$get_below_banner->banner_link ?? ''}}" class="btn">Book Now</a>

        </div>
    </div>




    <!-- Product Slider Section -->
    <div class="container-fluid">
        <div class="heading text-center py-5">
            <h2 class="collection-title section_heading ">SAREES</h2>
        </div>
    </div>
    <style>
        .product-slider .slick-slide img {
            height: 400px;
            object-position: top;
        }

        h3.product-title a:hover {
            color: maroon;
        }
    </style>

    <div class=" product-slider">

        @forelse($get_sarees as $key => $get_sareess )
            <div class="product-desc">
            <div class="product-item">
                <a href="{{url('products/'.$get_sareess->slug)}}">
                    <img src="{{asset($get_sareess->photo)}}"
                         alt="Beautiful Saffron Orange Lehenga With Heavy Hand Embroidery From Banaras">
                </a>
                <h3 class="product-title">
                    <a href="{{url('products/'.$get_sareess->slug)}}">    {{$get_sareess->title}} </a>
                </h3>
                <p class="product-price text-center">

                    <span class="currency-symbol">₹</span>
                    <span class="sale_price">{{ number_format($get_sareess->product_actual_price ?? 0 , 2) }}</span>
                    <del class="product-price-strike">
                        <span class="currency-symbol">₹</span>
                        {{ number_format($get_sareess->product_max_selling_price ?? 0, 2) }}
                    </del>
                    <br>
                    @if(!empty($get_sareess->product_max_selling_price) && !empty($get_sareess->product_actual_price))
                        @php
                            $discount = (($get_sareess->product_max_selling_price - $get_sareess->product_actual_price) / $get_sareess->product_max_selling_price) * 100;
                        @endphp
                        <span class="discount-percentage">{{ number_format($discount, 2) }}% OFF</span>
                    @endif

                </p>
            </div>
            </div>
        @empty
        @endforelse

    </div>


    <!-- Product Slider Section -->
    <div class="container-fluid">
        <div class="heading text-center py-5">
            <h2 class="collection-title section_heading">FABRICS</h2>
        </div>
    </div>
    <style>
        .grid-item {
            position: relative;
            background-color: white;
            border: unset;
            overflow: hidden;
            width: 100%;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0;
            margin: 15px;
        }

        .grid-item img {
            width: 100%;
            height: auto;
            flex-grow: 1;
        }

        .grid-item h3 {
            position: absolute;
            bottom: 50%;
            transform: translateY(50%);
            background-color: #fff;
            padding: 10px;
            width: 70%;
            text-align: center;
            margin: 0;
            color: #333;
            font-size: 18px;
        }
    </style>

    <section class="category-section">
        <div class="container-fluid">
            <div class="row">
                @forelse($category_on_home as $categories)
                    <div class="col-md-3">
                        <a href="{{url('fabrics/'.$categories->slug)}}">
                            <div class="grid-item">
                                <img src="{{asset($categories->image)}}" alt="Linen Sarees">
                                <h3 class="category-title">{{$categories->category_name ?? ''}}</h3>
                            </div>
                        </a>
                    </div>

                @empty
                    <h4 class="text-center">No Category Found</h4>
                @endforelse
            </div>
        </div>
    </section>



    <style>
        .hero-section {
            position: relative;
            height: 80vh;
            background-image: url({{asset($get_middle_banner->banner)}}); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #fff;
        }

        .hero-content h1 {
            font-size: 3rem;
            letter-spacing: 0.1rem;
            text-transform: uppercase;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin: 10px 0 20px;
        }

        .hero-content .btn {
            padding: 10px 30px;
            font-size: 1rem;
            text-transform: uppercase;
            border: 2px solid #fff;
            background-color: transparent;
            color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }

        .hero-content .btn:hover {
            background-color: #fff;
            color: #000;
        }
    </style>
    <div class="hero-section my-5">
        <div class="hero-content">
            <h1>{{$get_middle_banner->banner_heading ?? ''}}</h1>
            <h4>{{$get_middle_banner->banner_subheading ?? ''}}</h4>
            <p>{{$get_middle_banner->banner_description ?? ''}}</p>
            <a href="{{$get_middle_banner->banner_link ?? ''}}"
               class="btn">{{$get_middle_banner->banner_text ?? ''}}</a>
        </div>
    </div>




    <!-- Product Slider Section -->
    <div class="container-fluid">
        <div class="heading text-center">
            <h2 class="collection-title section_heading">LEHNGA</h2>
        </div>
    </div>
    <div class="product-slider">

        <div class="product-item">
            <img src="https://www.koskii.com/cdn/shop/files/Untitled-2_1_360x.jpg?v=1719216315"
                 alt="Beautiful Saffron Orange Lehenga With Heavy Hand Embroidery From Banaras">
            <h3 class="product-title">Beautiful Saffron Orange Lehenga With Heavy Hand Embroidery From Banaras</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2000.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3000.00</span></p>
        </div>
        <div class="product-item">
            <img src="https://www.koskii.com/cdn/shop/files/KSK6237_360x.jpg?v=1719214558" alt="" Special Price" : Green
            & Pink Floral Digital Print Organza Lehenga">
            <h3 class="product-title">"Special Price" : Green & Pink Floral Digital Print Organza Lehenga</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2500 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3500.00</span></p>
        </div>
        <div class="product-item">
            <img
                src="https://cdn.shopify.com/s/files/1/0049/3649/9315/files/koskii-babypink-printed-crepe-designer-saree-saus0031503_babypink_6_large.jpg?v=1689579661"
                alt="Teal Green Banarasi Silk Embroidered Desinger Lehenga">
            <h3 class="product-title">Teal Green Banarasi Silk Embroidered Desinger Lehenga</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 1800.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 2800.00</span></p>
        </div>
        <div class="product-item">
            <img
                src="https://cdn.shopify.com/s/files/1/0049/3649/9315/products/koskii-grey-sequins-shimmer-designer-saree-saus0021889_grey_6_large.jpg?v=1719838256"
                alt="Spectra Green Patola Lehenga With  Banarasi Dupatta">
            <h3 class="product-title">Spectra Green Patola Lehenga With Banarasi Dupatta</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2200.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3200.00</span></p>
        </div>
        <div class="product-item">
            <img
                src="https://cdn.shopify.com/s/files/1/0049/3649/9315/files/koskii-mauve-swarovski-semicrepe-designer-saree-saus0030407_mauve_1_1_large.jpg?v=1719812469"
                alt="Product 5">
            <h3 class="product-title">Pink Meenakari Uppada Katan Silk Handloom Banarasi Saree</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2400.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3400.00</span></p>
        </div>
    </div>






    <style>
        .mystical-banaras-section {
            background-image: url({{asset($get_mystic_banner->banner)}}); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            height: 80vh;
            padding: 60px 0;
            position: relative;
            color: maroon; /* Change text color to white for better contrast with overlay */
            z-index: 1;
            display: flex;
            align-items: center;
        }

        .mystical-banaras-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
            z-index: -1; /* Ensure the overlay is behind the content */
        }

        /*.mystical-banaras-section h2 {*/
        /*    font-size: 36px;*/
        /*    font-weight: 600;*/
        /*    margin-bottom: 20px;*/
        /*    text-transform: uppercase;*/
        /*    letter-spacing: 2px;*/
        /*    z-index: 2; !* Ensure the heading appears above the overlay *!*/
        /*}*/

        .mystical-banaras-section .lead {
            font-size: 18px;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
            z-index: 2; /* Ensure the text appears above the overlay */
        }

        {{--.mystical-banaras-section::after {--}}
        {{--    content: '';--}}
        {{--    position: absolute;--}}
        {{--    width: 100px;--}}
        {{--    height: 100px;--}}
        {{--    background: url({{asset($get_mystic_banner->banner)}}) no-repeat; /* Replace with decorative image URL */--}}
        {{--    background-size: contain;--}}
        {{--    z-index: 2; /* Ensure the decorative image appears above the overlay */--}}
        {{--}--}}

        .mystical-banaras-section::after {
            bottom: 20px;
            right: 20px;
        }
    </style>

    <section class="mystical-banaras-section my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <h1>{{$get_mystic_banner->banner_heading}}</h1>
                    <h4>{{$get_mystic_banner->banner_subheading}}</h4>
                    <p class="lead">
                        {{$get_mystic_banner->banner_description}}
                    </p>
                </div>
            </div>
        </div>
    </section>



    <!-- Product Slider Section -->
    <div class="container-fluid">
        <div class="heading text-center py-5">
            <h2 class="collection-title section_heading">DUPATTA</h2>
        </div>
    </div>

    <div class=" product-slider">

        <div class="product-item">
            <img src="https://www.koskii.com/cdn/shop/files/Untitled-2_1_360x.jpg?v=1719216315"
                 alt="Beautiful Saffron Orange Lehenga With Heavy Hand Embroidery From Banaras">
            <h3 class="product-title">Beautiful Saffron Orange Lehenga With Heavy Hand Embroidery From Banaras</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2000.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3000.00</span></p>
        </div>
        <div class="product-item">
            <img src="https://www.koskii.com/cdn/shop/files/KSK6237_360x.jpg?v=1719214558" alt="" Special Price" : Green
            & Pink Floral Digital Print Organza Lehenga">
            <h3 class="product-title">"Special Price" : Green & Pink Floral Digital Print Organza Lehenga</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2500 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3500.00</span></p>
        </div>
        <div class="product-item">
            <img
                src="https://cdn.shopify.com/s/files/1/0049/3649/9315/files/koskii-babypink-printed-crepe-designer-saree-saus0031503_babypink_6_large.jpg?v=1689579661"
                alt="Teal Green Banarasi Silk Embroidered Desinger Lehenga">
            <h3 class="product-title">Teal Green Banarasi Silk Embroidered Desinger Lehenga</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 1800.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 2800.00</span></p>
        </div>
        <div class="product-item">
            <img
                src="https://cdn.shopify.com/s/files/1/0049/3649/9315/products/koskii-grey-sequins-shimmer-designer-saree-saus0021889_grey_6_large.jpg?v=1719838256"
                alt="Spectra Green Patola Lehenga With  Banarasi Dupatta">
            <h3 class="product-title">Spectra Green Patola Lehenga With Banarasi Dupatta</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2200.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3200.00</span></p>
        </div>
        <div class="product-item">
            <img
                src="https://cdn.shopify.com/s/files/1/0049/3649/9315/files/koskii-mauve-swarovski-semicrepe-designer-saree-saus0030407_mauve_1_1_large.jpg?v=1719812469"
                alt="Product 5">
            <h3 class="product-title">Pink Meenakari Uppada Katan Silk Handloom Banarasi Saree</h3>
            <p class="product-price"><span class="currency-symbol">₹</span> 2400.00 <span
                    class="product-price-strike"><span class="currency-symbol">₹</span> 3400.00</span></p>
        </div>
    </div>



    <style>
        section.spacer {
            background: #f7e2e2;
        }

        .c-container {
            margin: auto;
            width: 93%;
            position: relative;
            z-index: 1;
        }

        .btn-outline-white {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            background-image: none;
            border-width: 2px;
            border-color: #fff;
            font-weight: 500;
            -webkit-transition: all .2s;
            transition: all .2s;
        }

        .btn {
            border-radius: 5px;
            font-weight: normal;
            font-size: 15px;
            letter-spacing: 0.02em;
            line-height: 12px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            padding: 14px 30px;
            cursor: pointer;
        }

        .btn-outline-white:hover {
            background-color: #fff;
            color: var(--text-dark);
        }

        /* common css up */

        .testimonial p {
            font-size: 28px;
            letter-spacing: 0.02em;
            line-height: 35px;
        }

        .testimonial .name {
            font-weight: bold;
            font-size: 18px;
            letter-spacing: 0.04em;
            line-height: 35px;
            text-align: left;
        }

        .testimonial .designation {
            font-size: 14px;
            letter-spacing: 0.04em;
            text-align: left;
            color: #fff;
            opacity: 0.65;
        }

        .unt {
            margin-bottom: 20px;
            margin-top: 60px;
        }

        .hero-text {
            font-size: 30px;
            letter-spacing: 0.02em;
            color: #fff;
        }

        .gallery-thumbs {
            height: 100%;
        }

        .gallery-thumbs .swiper-wrapper {
            align-items: center;
        }

        .gallery-thumbs .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 250px !important;
            height: 330px;
            position: relative;
        }

        .gallery-thumbs .swiper-slide img {
            filter: contrast(0.5) blur(1px);
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .gallery-thumbs .swiper-slide-active img {
            filter: contrast(1) blur(0px) !important;
        }

        .flex-row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .flex-row .flex-col {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .gallery-thumbs .swiper-wrapper {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }


        .testimonial-section .quote {
            width: 75%;
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            padding-left: 100px;
            padding-right: 100px;
        }

        .swiper-container.testimonial {
            height: 100vh;
        }

        .testimonial-section .user-saying {
            background: var(--theme-color2);
            width: 60%;
            color: #fff;
            height: 100%;
        }

        .testi-user-img {
            width: 40%;
        }

        .testimonial-section {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            width: 100%;
            height: 100%;
        }

        .testimonial-section .quote p {
            font-size: 20px;
            font-weight: 300;
            line-height: 1.8;
            font-style: italic;
            margin: 0;
        }

        .quote-icon {
            width: 38px;
            display: block;
            margin-bottom: 30px;
        }
    </style>
    <section class="spacer">

        <div class="testimonial-section">
            <div class="testi-user-img">
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper">
                        @forelse($reviews as $key => $reviewss)
                            <div class="swiper-slide">
                                <img class="u{{$key+1}}" src="{{asset($reviewss->user_image)}}" alt="">
                            </div>
                        @empty
                        @endforelse

                    </div>
                </div>
            </div>
            <div class="user-saying">
                <div class="swiper-container testimonial">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper ">
                        <!-- Slides -->
                        @forelse($reviews as $key => $reviewss)
                            <div class="swiper-slide">
                                <div class="quote">
                                    <img class="quote-icon" src="https://md-aqil.github.io/images/quote.png" alt="">
                                    <p>
                                        “{{strip_tags($reviewss->review)}}“
                                    </p>
                                    <div class="name">-{{$reviewss->username}}</div>
                                    {{--                                <div class="designation">University Student</div>--}}

                                </div>
                            </div>
                        @empty
                        @endforelse

                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination swiper-pagination-white"></div>

                </div>
            </div>
        </div>
    </section>

    <style>
        .blog-slider {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
        }

        .blog-item {
            flex: 0 0 auto;
            width: 300px;
            scroll-snap-align: start;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .blog-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .blog-item h5 {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .blog-item p {
            font-size: 14px;
            color: #666;
            margin: 10px 0;
        }

        .blog-item .read-more {
            color: #f0a500;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .blog-item .read-more:hover {
            color: #333;
        }

    </style>
    <div class="container my-5">
        <h2 class="text-center">Recent Blog Posts</h2>
        <div class="blog-slider">
            <div class="blog-item">
                <img
                    src="https://www.sacredweaves.com/cdn/shop/articles/Celebrate_Ganpati_with_Exquisite_Banarasi_Sarees_from_Sacred_Weaves_400x.jpg?v=1724148296"
                    alt="Blog 1" class="img-fluid">
                <h5>Celebrate Ganpati with Exquisite Banarasi Sarees from Sacred Weaves</h5>
                <p>Ganesh Chaturthi is not just a festival; it's a celebration of culture, tradition, and the divine.
                    Make this Ganpati truly special...</p>
                <a href="#" class="read-more">Read more</a>
            </div>
            <div class="blog-item">
                <img
                    src="https://www.sacredweaves.com/cdn/shop/articles/Celebrate_Ganpati_with_Exquisite_Banarasi_Sarees_from_Sacred_Weaves_400x.jpg?v=1724148296"
                    alt="Blog 2" class="img-fluid">
                <h5>Embrace the elegance of Nayanthara’s style with our exquisite Tissue Banarasi Saree</h5>
                <p>Recently, the stunning actress Nayanthara graced Anant Ambani’s wedding function in a gorgeous Tissue
                    Banarasi saree...</p>
                <a href="#" class="read-more">Read more</a>
            </div>
            <div class="blog-item">
                <img
                    src="https://www.sacredweaves.com/cdn/shop/articles/Celebrate_Ganpati_with_Exquisite_Banarasi_Sarees_from_Sacred_Weaves_400x.jpg?v=1724148296"
                    alt="Blog 3" class="img-fluid">
                <h5>Sonakshi Sinha's Radiant Red Banarasi Silk Saree: A Bridal Marvel</h5>
                <p>Sonakshi Sinha recently captivated everyone with her choice of bridal ensemble - A stunning Red
                    Banarasi silk saree...</p>
                <a href="#" class="read-more">Read more</a>
            </div>
            <div class="blog-item">
                <img
                    src="https://www.sacredweaves.com/cdn/shop/articles/Celebrate_Ganpati_with_Exquisite_Banarasi_Sarees_from_Sacred_Weaves_400x.jpg?v=1724148296"
                    alt="Blog 3" class="img-fluid">
                <h5>Sonakshi Sinha's Radiant Red Banarasi Silk Saree: A Bridal Marvel</h5>
                <p>Sonakshi Sinha recently captivated everyone with her choice of bridal ensemble - A stunning Red
                    Banarasi silk saree...</p>
                <a href="#" class="read-more">Read more</a>
            </div>
            <div class="blog-item">
                <img
                    src="https://www.sacredweaves.com/cdn/shop/articles/Celebrate_Ganpati_with_Exquisite_Banarasi_Sarees_from_Sacred_Weaves_400x.jpg?v=1724148296"
                    alt="Blog 3" class="img-fluid">
                <h5>Sonakshi Sinha's Radiant Red Banarasi Silk Saree: A Bridal Marvel</h5>
                <p>Sonakshi Sinha recently captivated everyone with her choice of bridal ensemble - A stunning Red
                    Banarasi silk saree...</p>
                <a href="#" class="read-more">Read more</a>
            </div>
            <div class="blog-item">
                <img
                    src="https://www.sacredweaves.com/cdn/shop/articles/Celebrate_Ganpati_with_Exquisite_Banarasi_Sarees_from_Sacred_Weaves_400x.jpg?v=1724148296"
                    alt="Blog 3" class="img-fluid">
                <h5>Sonakshi Sinha's Radiant Red Banarasi Silk Saree: A Bridal Marvel</h5>
                <p>Sonakshi Sinha recently captivated everyone with her choice of bridal ensemble - A stunning Red
                    Banarasi silk saree...</p>
                <a href="#" class="read-more">Read more</a>
            </div>
            <!-- Add more blog items as needed -->
        </div>
    </div>


    <style>
        .location-map {
            background-color: #fff;
            padding: 40px 20px;
            text-align: center;
        }

        .location-map h2 {
            font-size: 24px;
            color: #8e2832;
            margin-bottom: 20px;
        }

        .map-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .store-image {
            max-width: 400px;
            width: 100%;
            height: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        iframe {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

    </style>
    <div class="location-map">
        <h2>Visit Our Store</h2>
        <div class="map-container">
            <img
                src="https://scontent.fvns4-1.fna.fbcdn.net/v/t39.30808-6/364721421_794361996030272_2192306155012732520_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=Tc3qI2FX9oEQ7kNvgGJ_gMB&_nc_ht=scontent.fvns4-1.fna&_nc_gid=ANrIXp2PLNImyn5Gg4AO-Dv&oh=00_AYD-JHKTQBUU2JjDD3lAJ8_kDS6soUnxujlNI4C5IGwDUg&oe=66CF6529"
                alt="Store Image" class="store-image">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3606.943430050021!2d82.98445087415786!3d25.30610462728321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398e320750768c1b%3A0x75845f711d2e2ab9!2sVandana%20Sarees%20-%20Best%20Banarasi%20Saree%20Shop!5e0!3m2!1sen!2sin!4v1724489344153!5m2!1sen!2sin"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>


    @if(!empty($instagram_posts))
        <div class="container mt-5">
            <h2>Instagram Posts</h2>
            <div class="row">
                @foreach($instagram_posts as $post)
                    <div class="col-md-4 mb-4">
                        <iframe src="{{ $post['permalink'] }}embed" width="400" height="480" frameborder="0"
                                scrolling="no" allowtransparency="true"></iframe>

                        {{--                        <div class="card">--}}
                        {{--                            @if(isset($post['media_type']) && $post['media_type'] == 'VIDEO')--}}
                        {{--                                <video controls autoplay muted loop class="card-img-top">--}}
                        {{--                                    <source src="{{ $post['video_url'] }}" type="video/mp4">--}}
                        {{--                                    Your browser does not support the video tag.--}}
                        {{--                                </video>--}}
                        {{--                            @else--}}
                        {{--                                <img src="{{ $post['media_url'] }}" class="card-img-top" alt="Instagram Post">--}}
                        {{--                            @endif--}}
                        {{--                        </div>--}}
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@stop
@section('script')
    <script>
        $('.collection-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: true,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });

    </script>


    <script>
        $(document).ready(function () {
            $('.customer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });
    </script>
@stop
