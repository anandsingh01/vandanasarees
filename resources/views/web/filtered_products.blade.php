{{--<div class="row justify-content-center" id="filteredProducts">--}}
{{--    --}}
@forelse($get_products as $key => $category_product)
    <div class="lazy-load-row hidden furniture_product_grid col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
        <div class="item_image">
            <div class="div_image">
                <img src="{{asset($category_product->photo)}}" alt="{{$category_product->title}}" loading="lazy">
            </div>
        </div>
        <div class="item_content">
            <h3 class="item_title"><a href="{{url('products/'.$category_product->slug)}}">{{$category_product->title}}</a></h3>
            <span class="item_price"> Rs. {{number_format($category_product->product_actual_price, 2)}}
                {{-- <del> Rs. {{$category_product->product_max_selling_price}}</del>--}}
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


                <a class="tooltips button quick-view-link11 bg_carparts_red
                                             custom_btn"
                   data-placement="top"
                   href="{{url('products/'.$category_product->slug)}}"
                   title="Quick View"
                   {{--                                               data-toggle="modal"--}}
                   {{--                                               id="one"--}}
                   {{--                                               data-target="#quickview_modal"--}}
                   {{--                                               data-backdrop="false"--}}
                   {{--                                               data-product-id="{{ $getProducts->id }}"--}}
                   style=""
                >
                    <i class="fal fa-search mr-2"></i> Quick View </a>
                {{--                                    <a class="tooltips button quick-view-link11 bg_carparts_red custom_btn"--}}
                {{--                                       data-placement="top"--}}
                {{--                                       title="Quick View"--}}
                {{--                                       data-toggle="modal"--}}
                {{--                                       id="one"--}}
                {{--                                       data-target="#quickview_modal"--}}
                {{--                                       data-backdrop="false"--}}
                {{--                                       data-product-id="{{ $category_product->id }}"--}}
                {{--                                       style=""--}}
                {{--                                    >--}}
                {{--                                        <i class="fal fa-search mr-2"></i> Quick View--}}
                {{--                                    </a>--}}
            </div>
        </div>
    </div>
@empty
@endforelse
{{--</div>--}}

{{--@forelse($get_products as $key => $get_product)--}}
{{--    <div class="col-6 col-md-4 col-lg-4">--}}
{{--        <div class="product product-7 text-center">--}}
{{--            <figure class="product-media">--}}
{{--                <a href="{{url('products/'.$get_product->slug)}}">--}}
{{--                    <img src="{{asset($get_product->photo)}}" alt="{{$get_product->title}}"--}}
{{--                         class="product-image">--}}
{{--                </a>--}}
{{--            </figure>--}}

{{--            <div class="product-body">--}}
{{--                <div class="product-cat">--}}
{{--                    <a href="{{url('products/'.$get_product->slug)}}">{{$get_product->get_brands->category_name ?? ''}}</a>--}}
{{--                </div>--}}
{{--                <h3 class="product-title"><a href="{{url('products/'.$get_product->slug)}}">{{$get_product->title}}</a></h3>--}}

{{--                <div class="product-price">--}}
{{--                    $ {{number_format($get_product->product_actual_price,2)}}--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@empty--}}
{{--@endforelse--}}
