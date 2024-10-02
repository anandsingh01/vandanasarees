@extends('layouts.web')
<?php
session_start();
$get_category = get_category();
$get_brands = get_brands();
?>
@section('css')
    <style>
        .pagination-wrapper {
            margin: 0 auto;
            width: 10%;
        }
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #000;
            border-color: #000;
        }
        .page-link{
            color:#000;
        }
        .sticky_header{
            position:unset;
        }
        .watch_header + main {
            margin-top: 0px;
        }
        .row.shoppagebtn {
            padding: 10px;
        }
        .maindiv .shoppagebtn a {
            padding: 5px;
            height:unset;
        }
        .div_image img {
            max-height: 300px;
            max-width: 100%;
        }

        .furniture_product_group1{
            padding:0;
            margin: 0;
        }
        .furniture_breadcrumb{
            min-height: 400px;
            padding: 50px 0px;
        }
        .f2_breadcrumb_nav_wrap {
            margin-top: 50px;
        }

        @media only screen and (min-width: 320px) and (max-width: 450px){

            .item_content {
                padding: 15px 0;
            }

            .div_image img {
                max-width: 100%;
                height: 100px;
            }

            .row.shoppagebtn{
                padding:0;
            }
            .furniture_product_grid .item_image {
                min-height: 150px;
                width: 100%;
            }
            .furniture_product_grid {
                padding: 10px;
            }
            .maindiv .shoppagebtn a {
                padding: 10px;
                height: unset;
                width: 100%;
                margin: 5px 0;
            }
            .maindiv .shoppagebtn a {
                height: unset;
                margin: 5px 0;
                padding: 5px !important;
                margin-bottom: 5px !important;
                width: 100% !important;
            }
            .furniture_product_group1  h3.item_title a {
                font-size: 24px;
                margin-top: 15px;
            }
            .furniture_product_group1 .watch_product_item .item_price {
                font-size: 14px;
            }
            .furniture_product_grid .item_price strong{
                color: #272727;
                font-size: 15px;
            }

            .option_select .nice-select{
                height:unset;
                line-height: unset;
            }
        }

    </style>

@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();
    ?>

    <div class="maindiv">
        <!-- sidebar mobile menu & sidebar cart - start
           ================================================== -->
{{--        <div class="sidebar-menu-wrapper">--}}
{{--            @include('inc.web.shop-sidebar')--}}
{{--        </div>--}}
        <!-- sidebar mobile menu & sidebar cart - end
           ================================================== -->
        <!-- breadcrumb_section - start
           ================================================== -->
        <section class="breadcrumb_section furniture_breadcrumb deco_wrap d-flex align-items-center clearfix" data-bg-color="#f4f2f2">
            <div class="container-fluid prl_90">
                <h1 class="f2_page_title mb-0 text-uppercase">{{$category->category_name ?? 'Shop'}}</h1>
            </div>
{{--            <div class="deco_image">--}}
{{--                <img src="{{asset($category->image)}}" alt="image_not_found">--}}
{{--            </div>--}}
        </section>
        <div class="container-fluid prl_90">
            <div class="f2_breadcrumb_nav_wrap">
                <ul class="ce_breadcrumb_nav ul_li clearfix">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>{{$category->category_name ?? 'Shop'}}</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb_section - end
           ================================================== -->
        <!-- product_section - start
           ================================================== -->
        <section class="product_section sec_ptb_50 clearfix">
            <div class="container-fluid prl_90">
                <div class="f2_filter_bar mb_30">

                    <div class="option_select d-flex align-items-center mb-0">
                        <form action="#">

                            <input type="hidden"
                                   name="category_id"
                                   id="category_id"
                                   value="0"  />

                            <select name="sortby" id="sortby2" class="form-control">
                                <option value="reload" selected="selected">Default</option>
                                <option value="newarrivals">New Arrivals</option>
                                <option value="lowtohigh">Low To High</option>
                                <option value="hightolow">High To Low</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div id="filteredProducts" class="furniture_product_group1 row">
                    @forelse($get_products as $key => $category_product)
                        <div class="furniture_product_grid col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                            <div class="item_image">
                                <div class="div_image">
                                    <img src="{{asset($category_product->photo)}}" alt="{{$category_product->title}}">
                                </div>
                            </div>
                            <div class="item_content">
                                <h3 class="item_title"><a href="{{url('products/'.$category_product->slug)}}">{{$category_product->title}}</a></h3>
                                <span class="item_price"> Rs. {{number_format($category_product->product_actual_price, 2)}}
{{--                                    <del> Rs. {{$category_product->product_max_selling_price}}</del>--}}
                                </span>
                            </div>

                            <div class="row shoppagebtn">
                                <div class="col-md-12 col-12">

                                    <a href="#"
                                       data-size="{{ $category_product->size }}"
                                       data-id="{{ $category_product->id }}"
                                       data-id="{{ $category_product->id }}"
                                       data-price="{{ $category_product->product_actual_price }}"
                                       data-product_name="{{ $category_product->title }}"
                                       data-qty="1"
                                       data-msp="{{ $category_product->product_max_selling_price }}"
                                       data-image="{{ $category_product->photo }}"
                                       data-variation_product_id="{{ $category_product->product_id }}"
                                       data-flash_sale="{{ $category_product->flash_sale }}"
                                       data-flash_price="{{ $category_product->flash_price }}"
                                       class="btn-cart custom_btn bg_carparts_red"
                                       style="" id="addToCartButton"
                                    ><i class="fal fa-shopping-basket mr-2"></i> Add to Cart</a>


                                    <a class="tooltips button quick-view-link11 bg_carparts_red custom_btn"
                                       data-placement="top"
                                       title="Quick View"
                                       data-toggle="modal"
                                       id="one"
                                       data-target="#quickview_modal"
                                       data-backdrop="false"
                                       data-product-id="{{ $category_product->id }}"
                                       style=""
                                    >
                                        <i class="fal fa-search mr-2"></i> Quick View </a>
                                </div>
                            </div>
                        </div>

                    @empty

                        <h5 class="text-center">You will get something awesome very soon. </h5>
                    @endforelse
                </div>
                <div class="load_more text-center clearfix">
                    @if ($get_products->hasPages())
                        <div class="pagination-wrapper">
                            {{ $get_products->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </section>
        <div class="sidebar-menu-wrapper">
            <div class="filter_sidebar">
                <button type="button" class="close_btn mb_50"><i class="fal fa-times"></i></button>
                <div class="fs_widget fs_category_list">
                    <h3 class="fs_widget_title text-uppercase">Top Categories</h3>
                    <ul class="ul_li_block clearfix">
                        @forelse($get_category as $get_categories)
                            <li><a href="{{url('shop/'.$get_categories->slug)}}">
                                    <span><i class="fab fa-black-tie"></i></span>{{$get_categories->category_name}}</a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                <div class="fs_widget fs_price_list">
                    <h3 class="fs_widget_title text-uppercase">Price filter</h3>
                    <form action="#">
                        <ul class="ul_li_block clearfix">
                            <li>
                                <input id="fs_price_1" type="radio" name="fs_price_wroup" checked>
                                <label for="fs_price_1">$25 - $100</label>
                            </li>
                            <li>
                                <input id="fs_price_2" type="radio" name="fs_price_wroup">
                                <label for="fs_price_2">$100 - $200</label>
                            </li>
                            <li>
                                <input id="fs_price_3" type="radio" name="fs_price_wroup">
                                <label for="fs_price_3">$200 - $300</label>
                            </li>
                            <li>
                                <input id="fs_price_4" type="radio" name="fs_price_wroup">
                                <label for="fs_price_4">$400 - $500</label>
                            </li>
                            <li>
                                <input id="fs_price_5" type="radio" name="fs_price_wroup">
                                <label for="fs_price_5">$500 - $1000</label>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="fs_widget fs_size_list">
                    <h3 class="fs_widget_title text-uppercase">Size filter</h3>
                    <form action="#">
                        <ul class="ul_li clearfix">
                            <li>
                                <label for="fs_size_1"><input id="fs_size_1" type="radio" name="fs_size_group">XS</label>
                            </li>
                            <li>
                                <label for="fs_size_2"><input id="fs_size_2" type="radio" name="fs_size_group">S</label>
                            </li>
                            <li>
                                <label for="fs_size_3"><input id="fs_size_3" type="radio" name="fs_size_group">M</label>
                            </li>
                            <li>
                                <label for="fs_size_4"><input id="fs_size_4" type="radio" name="fs_size_group">L</label>
                            </li>
                            <li>
                                <label for="fs_size_5"><input id="fs_size_5" type="radio" name="fs_size_group">XL</label>
                            </li>
                            <li>
                                <label for="fs_size_6"><input id="fs_size_6" type="radio" name="fs_size_group">XXL</label>
                            </li>
                        </ul>
                    </form>
                </div>

            </div>
        </div>
        <!-- product_section - end
           ================================================== -->
    </div>

{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>--}}

    <script>
        $(document).ready(function(){
            $("#sortby2").change(function () {
                var end = this.value;
                if(end=='reload'){
                    location.reload();
                }
            });
            if(screen.width > 768){

            }else{
                //alert("hello");

                $(".imgStyle").css("height", "210px");
                $(".bannerimg").css("height", "100px");
            }

        });
    </script>


@stop
@section('script')

    <script>
        $('#sortby2').on('change', function() {
            const selectedValue = $(this).val();
            console.log(selectedValue);
            var selectedCategories = $('.category-checkbox:checked')
                .map(function() {
                    return $(this).attr('id').replace('cat-', '');
                })
                .get();

            var selectedBrands = $('.brand-checkbox:checked')
                .map(function() {
                    return $(this).attr('id').replace('brand-', '');
                })
                .get();

            var category_id = $('#category_id').val();

            $.ajax({
                url: "{{url('/filter-by-price')}}", // Change this to your Laravel route for filtering
                method: 'GET',
                data: {
                    categories: selectedCategories,
                    brands: selectedBrands,
                    category_id: category_id,
                    sortby: selectedValue // Pass the selected sorting value
                },
                success: function(response) {
                    $('#filteredProducts').html(response); // Update the content of the container
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>


    <script>
        $('.button').click(function(){
            var buttonId = $(this).attr('id');
            $('#modal-container').removeAttr('class').addClass(buttonId);
            $('body').addClass('modal-active');
        })

        $('#modal-container').click(function(){
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
{{--												<!--option value="lowtohigh">Low To High</option>--}}
{{--												<option value="hightolow">High To Low</option-->--}}
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


