@forelse($get_products as $getProducts)
    <div class="col-md-3 mt-3 product-desc">
        <div class="product-item">

            <a href="{{url('products/'.$getProducts->slug)}}">
                <img src="{{asset($getProducts->photo)}}"
                     alt="{{ $getProducts->title }}">
            </a>
            <h3 class="product-title text-center">
                <a href="{{url('products/'.$getProducts->slug)}}">{{ $getProducts->title }}</a>
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
    <p>No products found</p>
@endforelse
