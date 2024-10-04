@extends('layouts.web')
<?php
session_start();
$get_category = get_category();
$get_brands = get_brands();
?>
@section('css')
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
            background-image: url({{asset($sections->image)}});
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

@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();
    ?>


    <div class="overlay" id="overlay"></div>

    <section class="banner">

        <div class="container ">
            <h2>{{$sections->category_name}}</h2>
        </div>
    </section>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <button class="filter-btn" onclick="openFilter()">Filter</button>
            </div>
            <div>
                <span>{{count($sections->get_products ?? '')}} products</span>
            </div>
            <div>
                <select name="sortby" id="sortby2" class="form-control">

                    <option value="newarrivals">New Arrivals</option>
                    <option value="lowtohigh">Low To High</option>
                    <option value="hightolow">High To Low</option>
                </select>
            </div>
            <input type="hidden" name="section_id" id="section_id" value="{{$sections->id ?? ''}}">
        </div>



        <div class="row product-list">
            @forelse($sections->get_products as $getProducts)
                <div class="col-md-3 mt-3 product-desc">
                    <div class="product-item">
                        <a href="{{url('products/'.$getProducts->slug)}}">
                            <img src="{{asset($getProducts->photo)}}"
                                 alt="{{$getProducts->title}}">
                        </a>
                        <h3 class="product-title text-center">
                            <a href="{{url('products/'.$getProducts->slug)}}">{{$getProducts->title}}</a>
                        </h3>
                        <p class="product-price text-center">
                            <span class="currency-symbol">₹</span>
                            <span class="sale_price">{{ number_format($getProducts->product_actual_price ?? 0 , 2) }}</span>
                            <del class="product-price-strike">
                                <span class="currency-symbol">₹</span>
                                {{ number_format($getProducts->product_max_selling_price ?? 0, 2) }}
                            </del>
                            <br>
                            @if(!empty($getProducts->product_max_selling_price) && !empty($getProducts->product_actual_price))
                                @php
                                    $discount = (($getProducts->product_max_selling_price - $getProducts->product_actual_price) / $getProducts->product_max_selling_price) * 100;
                                @endphp
                                <span class="discount-percentage">{{ number_format($discount, 2) }}% OFF</span>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No products found.</p>
                </div>
            @endforelse
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
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                                <label class="form-check-label" for="category{{ $category->id }}">
                                    {{ $category->category_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

@stop
@section('script')

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
                    url: "{{url('/filter-by-price')}}",
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
                    url: "{{ url('getProductDetails') }}/" + productId,
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
    @include('inc.web.sidebar-script')
@stop


{{--    <main class="main">--}}

{{--        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-2">--}}
{{--                        <ol class="breadcrumb">--}}
{{--                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
{{--                            <li class="breadcrumb-item"><a href="{{url('/shop')}}">Shop</a></li>--}}
{{--                            <li class="breadcrumb-item">{{$category->category_name}}</li>--}}
{{--                        </ol>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-7"></div>--}}
{{--                    <div class="col-md-3">--}}
{{--                        <div class="toolbox" style="margin-bottom:0rem;">--}}


{{--                            <div class="toolbox-right">--}}

{{--                                <div class="toolbox-sort">--}}
{{--								<div >--}}
{{--									<div class="product-details-action" id="btnDIV" style=" max-width:160px;margin-top:30px;margin-right:5px;">--}}
{{--									<a href="javascript:void(0)" onclick="myFunction();" class="custom_btn" >Filter</a>--}}
{{--									</div>--}}
{{--								</div>--}}

{{--										<label for="sortby">Sort by:</label>--}}
{{--										<div class="select-custom">--}}
{{--											<select name="sortby" id="sortby2" class="form-control">--}}
{{--												<option value="reload" selected="selected">Default</option>--}}
{{--												<option value="newarrivals">New Arrivals</option>--}}
{{--												<option value="lowtohigh">Low To High</option>--}}
{{--												<option value="hightolow">High To Low</option--}}
{{--											</select>--}}
{{--										</div>--}}

{{--                                </div>--}}

{{--                            </div><!-- End .toolbox-right -->--}}
{{--                        </div><!-- End .toolbox -->--}}
{{--                    </div>--}}
{{--                </div>--}}


{{--            </div><!-- End .container -->--}}
{{--        </nav><!-- End .breadcrumb-nav -->--}}


{{--        <div class="page-content">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <aside class="col-lg-3">--}}

{{--                        @include('inc.web.shop-sidebar')--}}
{{--                        --}}{{--                        <hr>--}}
{{--                    </aside>--}}
{{--                    <div class="mainproductdiv col-lg-9">--}}

{{--                        <div class="products mb-3">--}}
{{--                            <div class="row justify-content-left" id="filteredProducts">--}}
{{--                                @forelse($get_products as $key => $get_product)--}}
{{--                                    @if(isset($get_product->getPrices) && $get_product->getPrices->isNotEmpty())--}}
{{--                                    <?php--}}
{{--//                                        print_r($get_product->getPrices[0]->image);die;--}}
{{--                                        ?>--}}
{{--                                <div class="col-6 col-md-3 col-lg-3">--}}
{{--                                    <div class="product product-7 text-center">--}}
{{--                                        <figure class="product-media" style="background-color:#ffffff">--}}
{{--                                            <a href="{{url('products/'.$get_product->slug)}}" class="imgStyle" style="height:260px;display: flex;justify-content: center;">--}}
{{--                                                @if(isset($get_product->getPrices[0]))--}}
{{--                                                    <img src="{{ asset($get_product->getPrices[0]->image) }}"--}}
{{--                                                         alt="{{ $get_product->title }}"--}}
{{--                                                        style="--}}
{{--																  display: block;--}}
{{--																  margin-top: auto;--}}
{{--																  margin-bottom: 0px;--}}
{{--																 " >--}}
{{--                                                @else--}}
{{--                                                    <!-- Handle the case where there are no prices for the product -->--}}
{{--                                                    <p>No product image available.</p>--}}
{{--                                                @endif--}}
{{--                                            </a>--}}
{{--                                        </figure>--}}

{{--                                        <div class="product-body">--}}
{{--                                            <h3 class="product-title"><a href="{{url('products/'.$get_product->slug)}}">{{$get_product->title}}</a></h3>--}}

{{--                                            <h3 class="product-title">--}}
{{--                                                <a href="{{url('products/'.$get_product->slug)}}">--}}
{{--                                                    {{$get_product->title}}--}}

{{--                                                </a>--}}
{{--                                            </h3>--}}

{{--                                            <div class="product-cat">--}}
{{--                                                @if($get_product->product_type == 'edt')--}}
{{--                                                    Eau De Toilette--}}
{{--                                                @elseif($get_product->product_type == 'edp')--}}
{{--                                                    Eau De Parfum--}}
{{--                                                @elseif($get_product->product_type == 'cologne')--}}
{{--                                                    Cologne--}}
{{--                                                @elseif($get_product->product_type == 'deodrant')--}}
{{--                                                    Deodrant--}}
{{--                                                @else--}}
{{--                                                    Other Perfume Type--}}
{{--                                                @endif ---}}
{{--                                                {{$get_product->section->category_name ?? ''}}--}}
{{--                                            </div>--}}

{{--											<div class="product-cat">--}}
{{--                                                <a href="{{url('products/'.$get_product->slug)}}">--}}
{{--                                                    {{$get_product->get_brands->category_name ?? ''}}--}}

{{--                                                </a>--}}
{{--                                            </div>--}}


{{--                                            <div class="product-cat">--}}
{{--                                                @if($get_product->product_type == 'edt')--}}
{{--                                                    Eau De Toilette--}}
{{--                                                @elseif($get_product->product_type == 'edp')--}}
{{--                                                    Eau De Parfum--}}
{{--                                                @elseif($get_product->product_type == 'cologne')--}}
{{--                                                    Cologne--}}
{{--                                                @elseif($get_product->product_type == 'deodrant')--}}
{{--                                                    Deodrant--}}
{{--                                                @else--}}
{{--                                                    Other Perfume Type--}}
{{--                                                @endif--}}
{{--                                                <br>--}}
{{--                                                <a href="{{url('products/'.$get_product->slug)}}">{{$get_product->get_brands->category_name ?? ''}}</a>--}}
{{--                                            </div>--}}

{{--                                            <div class="product-price">--}}
{{--                                                @if($get_product->getPrices->isNotEmpty())--}}
{{--                                                    @php $price = $get_product->getPrices[0]; @endphp--}}
{{--                                                    @if($price->flash_sale == 'yes')--}}
{{--                                                        $ {{$price->flash_price}}--}}
{{--                                                        <del class="del actual_price">--}}
{{--                                                            $ {{$price->price}}</del>--}}
{{--                                                    @else--}}
{{--                                                        $ {{$price->price}}--}}
{{--                                                    @endif--}}
{{--                                                @else--}}
{{--                                                    <!-- Handle the case when getPrices is empty or doesn't exist -->--}}
{{--                                                    Price not available--}}
{{--                                                @endif--}}
{{--                                            </div>--}}

{{--                                            <div class="product-price">--}}
{{--                                                --}}{{--                                                @if($get_product->getPrices[0]->flash_sale == 'yes')--}}
{{--                                                --}}{{--                                                    $ {{number_format($get_product->getPrices[0]->flash_price,2)}}--}}
{{--                                                --}}{{--                                                    <del class="del actual_price">$ {{number_format($get_product->product_actual_price,2)}}</del>--}}
{{--                                                --}}{{--                                                @else--}}
{{--                                                --}}{{--                                                    $ {{number_format($get_product->product_actual_price,2)}}--}}
{{--                                                --}}{{--                                                @endif--}}


{{--                                                <style>--}}
{{--                                                    .flash-sale-price{--}}
{{--                                                        font-family: 'Albert Sans', sans-serif !important;--}}
{{--                                                    }--}}
{{--                                                </style>--}}

{{--                                                @if ($get_product->getPrices->isNotEmpty())--}}
{{--                                                    @php $price = $get_product->getPrices[0]; @endphp--}}
{{--                                                    @if ($price->flash_sale == 'yes')--}}
{{--                                                        <span class="flash-sale-price">--}}
{{--                                                            $ {{$price->flash_price}}--}}
{{--                                                        </span>--}}
{{--                                                        <del class="del actual_price">--}}
{{--                                                            $ {{$price->price }}--}}
{{--                                                        </del>--}}

{{--                                                        @php--}}
{{--                                                            $percentageDifference = (($price->price - $price->flash_price) / $price->price) * 100;--}}
{{--                                                        @endphp--}}

{{--                                                        <p class="percent-off">--}}
{{--                                                            Upto   {{ round($percentageDifference) }}% off--}}
{{--                                                        </p>--}}
{{--                                                    @else--}}
{{--                                                        $ {{$price->price}}--}}
{{--                                                    @endif--}}
{{--                                                @else--}}
{{--                                                    <!-- Handle the case when getPrices is empty or doesn't exist -->--}}
{{--                                                    Price not available--}}
{{--                                                @endif--}}
{{--                                            </div>--}}


{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                    @endif--}}
{{--                                @empty--}}
{{--                                @endforelse--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div><!-- End .col-lg-9 -->--}}

{{--                </div><!-- End .row -->--}}
{{--            </div><!-- End .container -->--}}
{{--        </div><!-- End .page-content -->--}}
{{--    </main>--}}

<!-- End .main -->


