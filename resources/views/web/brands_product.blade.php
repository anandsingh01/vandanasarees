@extends('layouts.web')
<?php
session_start();
$get_category = get_category();
$get_brands = get_brands();
?>
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .input-group {
            padding: 0;
            justify-content: center;
        }
        .cart-bottom{
            display:block;
        }
        form {
            width: 100%;
        }
        .page-header {
            padding: 0rem 0;
        }
        del.del.actual_price {
            padding: 10px;
            color: maroon;
        }
        del.del.actual_price {
            padding: 10px;
            color: maroon;
            display: none;
        }
        .page-header h1 {
            color: #fff;
            background: unset !important;
            padding: 3em 0;
        }
        @media only screen and (max-width: 450px){
            .intro-content {
                margin-top: -5.9rem;
            }
            .intro-slide {
                min-height: 160px;
            }
            .intro-content .intro-title {
                margin-bottom: 1.7rem;
                font-size: 3em;
                letter-spacing: 0;
                font-weight: 600;
            }
            .icon-box {
                margin-top: 1.5rem;
            }

            .icon-box-card {
                background-color: transparent;
                padding: 1rem;
            }
            .custom-height img {
                height: 135px;
                object-fit: cover;
            }
            /**/
            img.product-image {
                height: 116px !important;
            }
            .heading .title {
                font-size: 2rem;
            }
        }



		.custom_btn{
			max-width:150px; padding: 8px 30px;
											border: 2px solid #327887;
											  background-color: white;
											  color: #327887;
											  transition:background-color 1s ;
		}
		.custom_btn:hover{
			background-color:  #327887;
			color: white;
		}



    </style>

@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();

    $get_shop_banner = \App\Models\Category::where('slug',$category->slug)->orderBy('id','DESC')->first();
//    print_r($get_shop_banner->banner_image);die;
    ?>
    <main class="main">
        <div class="page-header text-center"
             >
           
<img src="{{asset($get_shop_banner->banner_image)}}" class="bannerimg" style="width:100%;height:200px"/>
           
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item">{{$category->category_name}}</li>
                        </ol>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3">
                        <div class="toolbox" style="margin-bottom:0rem;">

                            <div class="toolbox-right">
                                <div class="toolbox-sort">
									<div >
										<div class="product-details-action" id="btnDIV" style=" max-width:160px;margin-top:30px;margin-right:5px;">
											<a href="javascript:void(0)" onclick="myFunction();" class="custom_btn" >Filter</a>
										</div>
									</div>
                                    <label for="sortby">Sort by:</label>
                                    <div class="select-custom">
                                        <select name="sortby" id="sortby2" class="form-control">
                                            <option value="reload" selected="selected">Default</option>
                                            <option value="newarrivals">New Arrivals</option>
                                            <!--option value="lowtohigh">Low To High</option>
                                            <option value="hightolow">High To Low</option-->
                                        </select>
                                    </div>
                                </div>

                            </div><!-- End .toolbox-right -->
                        </div><!-- End .toolbox -->
                    </div>
                </div>



            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->
        <div class="page-content">
            <div class="container">

                <div class="row">

                    <aside class="col-lg-3">
                        @include('inc.web.shop-sidebar')
                        {{--                        <hr>--}}
                    </aside>
                    <div class="col-lg-9">


                        <div class="products mb-3">
                            <div class="row justify-content-left" id="filteredProducts">
                                @forelse($get_products as $key => $get_product)
                                    @if(isset($get_product->getPrices) && $get_product->getPrices->isNotEmpty())
                                <div class="col-6 col-md-3 col-lg-3">
                                    <div class="product product-7 text-center">
                                        <figure class="product-media" style="background-color:#ffffff">
                                            <a href="{{url('products/'.$get_product->slug)}}"  class="imgStyle" style="height:260px;display: flex;justify-content: center;">
{{--                                                <img src="{{asset($get_product->photo)}}" alt="{{$get_product->title}}"--}}
{{--                                                     class="product-image">--}}
                                                @if(isset($get_product->getPrices[0]))
                                                    <img src="{{ asset($get_product->getPrices[0]->image) }}"
                                                         alt="{{ $get_product->title }}"
                                                         style="
																  display: block;
																  margin-top: auto;
																  margin-bottom: 0px;
																 ">
                                                @else
                                                    <!-- Handle the case where there are no prices for the product -->
                                                    <p>No product image available.</p>
                                                @endif
                                            </a>
                                        </figure>

                                        <div class="product-body">
{{--                                            <h3 class="product-title">--}}
{{--                                                <a href="{{url('products/'.$get_product->slug)}}">--}}
{{--                                                    {{$get_product->title}}--}}
{{--                                                </a>--}}
{{--                                            </h3>--}}
{{--                                            <div class="product-cat">--}}
{{--                                                <br>--}}
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

                                            <h3 class="product-title">
                                                <a href="{{url('products/'.$get_product->slug)}}">
                                                    {{$get_product->title}}

                                                </a>
                                            </h3>

                                            <div class="product-cat">
                                                @if($get_product->product_type == 'edt')
                                                    Eau De Toilette
                                                @elseif($get_product->product_type == 'edp')
                                                    Eau De Parfum
                                                @elseif($get_product->product_type == 'cologne')
                                                    Cologne
                                                @elseif($get_product->product_type == 'deodrant')
                                                    Deodrant
                                                @else
                                                    Other Perfume Type
                                                @endif -
                                                {{$get_product->section->category_name ?? ''}}
                                            </div>


                                            <div class="product-cat">
                                                <a href="{{url('products/'.$get_product->slug)}}">
                                                    {{$get_product->get_brands->category_name ?? ''}}

                                                </a>
                                            </div>

                                            <div class="product-price">
                                                {{--                                                @if($get_product->getPrices[0]->flash_sale == 'yes')--}}
                                                {{--                                                    $ {{number_format($get_product->getPrices[0]->flash_price,2)}}--}}
                                                {{--                                                    <del class="del actual_price">$ {{number_format($get_product->product_actual_price,2)}}</del>--}}
                                                {{--                                                @else--}}
                                                {{--                                                    $ {{number_format($get_product->product_actual_price,2)}}--}}
                                                {{--                                                @endif--}}


                                                <style>
                                                    .flash-sale-price{
                                                        font-family: 'Albert Sans', sans-serif !important;
                                                    }
                                                </style>

                                                @if ($get_product->getPrices->isNotEmpty())
                                                    @php $price = $get_product->getPrices[0]; @endphp
                                                    @if ($price->flash_sale == 'yes')
                                                        <span class="flash-sale-price">
                                                            $ {{$price->flash_price}}
                                                        </span>
                                                        <del class="del actual_price">
                                                            $ {{$price->price }}
                                                        </del>

                                                        @php
                                                            $percentageDifference = (($price->price - $price->flash_price) / $price->price) * 100;
                                                        @endphp

                                                        <p class="percent-off">
                                                            Upto   {{ round($percentageDifference) }}% off
                                                        </p>
                                                    @else
                                                        $ {{$price->price}}
                                                    @endif
                                                @else
                                                    <!-- Handle the case when getPrices is empty or doesn't exist -->
                                                    Price not available
                                                @endif
                                            </div>

                                            {{--                                            <div class="product-price">--}}
{{--                                                @if($get_product->getPrices[0]->flash_sale == 'yes')--}}
{{--                                                    $ {{number_format($get_product->getPrices[0]->flash_price,2)}}--}}
{{--                                                    <del class="del actual_price">$ {{number_format($get_product->product_actual_price,2)}}</del>--}}
{{--                                                @else--}}
{{--                                                    $ {{number_format($get_product->product_actual_price,2)}}--}}
{{--                                                @endif--}}

{{--                                                @if($get_product->getPrices->isNotEmpty())--}}
{{--                                                    @php $price = $get_product->getPrices[0]; @endphp--}}
{{--                                                    @if($price->flash_sale == 'yes')--}}
{{--                                                        $ {{$price->flash_price}}--}}
{{--                                                        <del class="del actual_price">$ {{$price->price}}</del>--}}
{{--                                                    @else--}}
{{--                                                        $ {{$price->price}}--}}
{{--                                                    @endif--}}
{{--                                                @else--}}
{{--                                                    <!-- Handle the case when getPrices is empty or doesn't exist -->--}}
{{--                                                    Price not available--}}
{{--                                                @endif--}}
{{--                                                --}}
{{--                                                --}}
{{--                                            </div>--}}

                                        </div>
                                    </div>
                                </div>
                                    @endif
                                @empty
                                @endforelse
                            </div>
                        </div>

                    </div><!-- End .col-lg-9 -->


                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

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
@section('js')
    @include('inc.web.sidebar-script')
@stop



