@extends('layouts.web')
<?php
session_start();
?>
@section('css')
<style>
    .container {
        max-width: 90%;
    }
    .quantity_input input {
        width: 49%;
        border: none;
        padding: 0px;
        outline: none;
        font-size: 18px;
        font-weight: 600;
        text-align: center;
    }

    .cart_section{
        position: relative;
    }
    .home_watch .custom_btn {
        padding: 10px 20px;
    }
    .sticky_header{
        position:unset;
    }
    .watch_header + main {
        margin-top: 0px;
    }
    section.body_yield_div {
        background: #fbfbfb;
    }
    .d-for-mobile{
        display:none;
    }
    /*.d-for-desk{*/
    /*    display: block;*/
    /*}*/
    .section.content-start {
        padding: 5em 0;
    }
    @media (max-width: 767px) {
        section.cart_section.sec_ptb_140.clearfix {
            background: #fff;
        }
        .checkout_step a {
            font-size: 17px;
            padding: 5px 30px;
        }
        .cart_table .table {
            width: 100%;
        }
        .cart_product .item_image {
            width: 66px;
            margin-right: 10px;
        }
        .d-for-mobile{
            display:block;
        }
        .d-for-desk{
            display: none;
        }
        .quantity_input input{
            width:10%;
        }
        .quantity_input{
            height:35px;
        }
        .quantity_input.d-for-mobile form {
            width: 100%;
        }
        .quantity_input span {
            color: #ced9df;
            line-height: 1;
            cursor: pointer;
            font-size: 20px;
            margin: 0px 10px;
            transition: 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .cart_product .item_type p,  .item_type p,  {
            margin-bottom: 5px;
            font-size: 16px;
        }
        .cart_product span {
            font-size: 16px;
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


    <div class="card">
        <style>
            .title{
                margin-bottom: 5vh;
            }
            .card{
                margin: auto;
                max-width: 90%;
                width: 90%;
                box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                border-radius: 1rem;
                border: transparent;
            }
            @media(max-width:767px){
                .card{
                    margin: 3vh auto;
                }
            }
            .cart{
                background-color: #fff;
                padding: 4vh 5vh;
                border-bottom-left-radius: 1rem;
                border-top-left-radius: 1rem;
            }
            @media(max-width:767px){
                .cart{
                    padding: 4vh;
                    border-bottom-left-radius: unset;
                    border-top-right-radius: 1rem;
                }
            }
            .summary{
                background-color: #ddd;
                border-top-right-radius: 1rem;
                border-bottom-right-radius: 1rem;
                padding: 4vh;
                color: rgb(65, 65, 65);
            }
            @media(max-width:767px){
                .summary{
                    border-top-right-radius: unset;
                    border-bottom-left-radius: 1rem;
                }
            }
            .summary .col-2{
                padding: 0;
            }
            .summary .col-10
            {
                padding: 0;
            }
            .card .row{
                margin: 0;
            }
            .title b{
                font-size: 1.5rem;
            }
            .card .main{
                margin: 0;
                padding: 2vh 0;
                width: 100%;
            }
            .card .col-2, .col{
                padding: 0 1vh;
            }
            .card a{
                padding: 0 1vh;
            }
            .close {
                margin: 0 auto;
                font-size: 0.7rem;
                width: 25px;
                height: 25px;
                text-align: center;
                align-items: center;
                background-color: #FF9494;
                color: #000;
                padding: 5px;
                cursor: pointer;
            }
            .card img{
                width: 3.5rem;
            }
            .card .back-to-shop{
                margin-top: 4.5rem;
            }
            .card h5{
                margin-top: 4vh;
            }
            .card hr{
                margin-top: 1.25rem;
            }
            .card form{
                padding: 2vh 0;
            }
            .card select{
                border: 1px solid rgba(0, 0, 0, 0.137);
                padding: 1.5vh 1vh;
                margin-bottom: 4vh;
                outline: none;
                width: 100%;
                background-color: rgb(247, 247, 247);
            }
            .card input{
                border: 1px solid rgba(0, 0, 0, 0.137);
                padding: 1vh;
                margin-bottom: 4vh;
                outline: none;
                width: 100%;
                background-color: rgb(247, 247, 247);
            }
            input:focus::-webkit-input-placeholder
            {
                color:transparent;
            }
            .btn{
                color: white;
                width: 100%;
                font-size: 0.7rem;
                margin-top: 4vh;
                padding: 1vh;
                border-radius: 0;
            }
            .card .btn:focus{
                box-shadow: none;
                outline: none;
                box-shadow: none;
                color: white;
                -webkit-box-shadow: none;
                -webkit-user-select: none;
                transition: none;
            }
            .card .btn:hover{
                color: white;
            }

            #code{
                background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253) , rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
                background-repeat: no-repeat;
                background-position-x: 95%;
                background-position-y: center;
            }

            input#quantityInput28 {
                width: 50%;
            }
            span.input_number_decrement, .input_number_increment {
                border: 1px solid gray;
                cursor: pointer;
                padding: 5px;
            }

            a.custom_btn.py-2.btn.bg_success {
                border: unset;
                color: #333;
            }

        </style>

        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Shopping Cart</b></h4></div>
                        <div class="col align-self-center text-right text-muted">{{ $getAllCart->count() }} items</div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"> Image</th>
                        <th scope="col"> Details</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($getAllCart as $cartItem)
                        <tr class="border-top border-bottom">
                            <!-- Product Image -->
                            <td class="col-1">
                                <img class="img-fluid" src="{{ asset($cartItem->getProducts->photo) }}" alt="Product Image">
                            </td>

                            <!-- Product Details -->
                            <td class="col-3">
                                <div>{{ $cartItem->getProducts->title ?? 'Product Name' }}</div>
                                <div>Unit Price : Rs. {{ number_format($cartItem->getProducts->product_actual_price,2) ?? 'NA' }}</div>
                            </td>

                            <!-- Quantity Input -->
                            <td class="col-2">
                                <div class="quantity_input f2p_quantity">
                                    <form action="#">
                                        <span class="input_number_decrement" data-cartid="{{ $cartItem->id }}">–</span>
                                        <input class="input_number qty2" type="text"
                                               id="quantityInput2{{$cartItem->getProducts->id}}"
                                               value="{{$cartItem->cartqty}}" data-cartid="{{$cartItem->id}}" max="3" min="1">
                                        <span class="input_number_increment" data-cartid="{{ $cartItem->id }}">+</span>
                                    </form>
                                </div>
                            </td>

                            <!-- Subtotal -->
                            <td class="col-1">
                                Rs. <span id="total_price{{$cartItem->id}}">{{ $cartItem->subtotal }}</span>
                            </td>

                            <!-- Remove Button -->
                            <td class="col-1">
                                <div class="close remove-item" data-cartid="{{ $cartItem->id }}">&times;</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div class="back-to-shop"><a href="{{ url('/shop') }}">&leftarrow;</a><span class="text-muted">Back to shop</span></div>
            </div>

            <div class="col-md-4 summary">
                <div><h5><b>Summary</b></h5></div>
                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">ITEMS {{ $getAllCart->count() }}</div>
                    <div class="col text-right">Rs. <span id="subtotalamount">{{ number_format($getAllCart->sum('subtotal'),2) }}</span></div>
                </div>
                <div class="row">
                    <div class="col" style="padding-left:0;">SHIPPING</div>
                    <div class="col text-right"><span id="">Free Shipping</span></div>
                </div>
{{--                <form>--}}
{{--                    <div class="coupon_form">--}}
{{--                        <div class="form_item mb-0">--}}
{{--                            <input type="text" class="coupon" id="couponCode" placeholder="Coupon Code">--}}
{{--                        </div>--}}
{{--                        <button type="submit" id="applyCouponBtn" class="custom_btn bg_danger text-uppercase">Apply Coupon</button>--}}
{{--                        <span class="coupon_error" id="coupon_error"></span>--}}
{{--                    </div>--}}
{{--                </form>--}}
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL PRICE</div>
                    <div class="col text-right">Rs. <span id="final_amount">{{ number_format($getAllCart->sum('subtotal'),2) }}</span></div>
                </div>

{{--                @if(Auth::check())--}}
{{--                <button class="btn">CHECKOUT</button>--}}

                    @if(Auth::check())
                        <a href="{{url('checkout')}}" class="custom_btn btn py-2 bg_success dark-pink">Proceed to Checkout</a>
                    @else
                        <a href="{{url('/guest-checkout')}}" class="custom_btn py-2 btn bg_success dark-pink">Proceed to Checkout</a>
                    @endif

            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.input_number_increment', function () {
                const cartId = $(this).data('cartid');
                // Instead of using the input field ID, use the data-cartid attribute
                const inputField = $('input[data-cartid="' + cartId + '"]');

                let currentQuantity = parseInt(inputField.val(), 10);

                // Get max quantity
                const maxQuantity = parseInt(inputField.attr('max'), 10) || Infinity;

                // Increment quantity and update value
                if (currentQuantity < maxQuantity) {
                    currentQuantity++;
                    inputField.val(currentQuantity).trigger('change'); // Trigger change event
                }
            });
            $(document).on('click', '.input_number_decrement', function () {
                const cartId = $(this).data('cartid');
                // Use the correct selector to target the input field using the data-cartid attribute
                const inputField = $('input[data-cartid="' + cartId + '"]');

                let currentQuantity = parseInt(inputField.val(), 10);

                // Get min quantity
                const minQuantity = parseInt(inputField.attr('min'), 10) || 1;

                // Decrement quantity and update value
                if (currentQuantity > minQuantity) {
                    currentQuantity--;
                    inputField.val(currentQuantity).trigger('change'); // Trigger change event
                }
            });

            // Handle quantity input field change
            $('.qty2').on('change', function () {
                const cartId = $(this).data('cartid');
                const quantityInput = $(this);
                let quantity = parseInt(quantityInput.val(), 10);

                // Get min and max values
                const minQuantity = parseInt(quantityInput.attr('min'), 10) || 1;
                const maxQuantity = parseInt(quantityInput.attr('max'), 10) || Infinity;

                // Validate the input value
                if (isNaN(quantity) || quantity < minQuantity) {
                    quantity = minQuantity;
                } else if (quantity > maxQuantity) {
                    quantity = maxQuantity;
                }

                // Update the input field with valid value
                quantityInput.val(quantity);

                // Send AJAX request to update the cart
                $.ajax({
                    url: '{{ url('updateCart') }}',
                    method: 'POST',
                    data: {
                        cartId: cartId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        const updatedSubtotal = response.updatedSubtotal;
                        const sum_of_subtotal = response.sum_of_subtotal;

                        $('#total_price' + cartId).html(updatedSubtotal);
                        $('#subtotalamount').text(sum_of_subtotal);
                        $('#final_amount').text(sum_of_subtotal);
                    },
                    error: function (xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });

            // Delete cart item function
            $('.remove-item').on('click', function () {
                const cartId = $(this).data('cartid');
                deleteConfirmation2(cartId);
            });

            function deleteConfirmation2(cartId) {
                $.ajax({
                    type: 'get',
                    url: "{{url('delete-from-cart/')}}/" + cartId,
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                            location.reload();
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });
            }

            // Apply coupon function
            $('#applyCouponBtn').on('click', function (event) {
                event.preventDefault();
                const couponCode = $('#couponCode').val();
                alert(couponCode);

                $.ajax({
                    url: '{{ route('cart.apply_coupon') }}',
                    type: 'POST',
                    data: {
                        coupon_code: couponCode,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            $('#final_amount').text('Rs. ' + response.discounted_total);
                        } else {
                            $('#coupon_error').text(response.message);
                            swal("Error!", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>
@stop

