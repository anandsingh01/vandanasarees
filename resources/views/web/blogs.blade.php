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
        .page-header h1{
            padding: 1em 0;
            background-color: unset;
        }
        .page-header {
            padding: 5rem 0;
        }
    </style>
@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();

    $get_shop_banner = \App\Models\BannerModel::where('display_area',7)->orderBy('id','DESC')->first();
//    print_r($get_shop_banner);die;
    ?>
    <main class="main">
        <div class="page-header text-center"
             style="background-image: url({{asset($get_shop_banner->banner)}})"
        >
            <div class="container">
                <h1 class="page-title"><span>Blogs</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/blogs')}}">Blogs</a></li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                


                        <div class="entry-container max-col-3" data-layout="fitRows" >

                            @forelse($all_blogs as $key => $all_blog)
                            <div class="entry-item lifestyle shopping col-sm-6 col-lg-4" >
                                <article class="entry entry-grid text-center">
                                    <figure class="entry-media">
                                        <a href="{{url('blog-details/'.$all_blog->title_slug)}}">
                                            <img src="{{asset($all_blog->image_big)}}" alt="image desc">
                                        </a>
                                    </figure><!-- End .entry-media -->

                                    <div class="entry-body">
                                        <h2 class="entry-title">
                                            <a href="{{url('blog-details/'.$all_blog->title_slug)}}">
                                                {{$all_blog->title}}</a>
                                        </h2>


                                        <div class="entry-content">
                                            <p>{{Str::limit(strip_tags($all_blog->content), 20)}}</p>
                                            <a href="{{url('blog-details/'.$all_blog->title_slug)}}" class="read-more">Continue Reading</a>
                                        </div><!-- End .entry-content -->
                                    </div><!-- End .entry-body -->
                                </article><!-- End .entry -->
                            </div>
                            @empty
                            @endforelse


                        </div><!-- End .entry-container -->

                    
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->


@stop
@section('js')
    <!-- Add this script tag within your HTML body or in a separate JavaScript file -->
    <script>
        $(document).ready(function() {
            $('.category-checkbox, .brand-checkbox, .producttype-checkbox, .productsize-checkbox').change(function() {
                updateFilteredProducts();
            });

            function updateFilteredProducts() {
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

                var selectedProductTypes = $('.producttype-checkbox:checked')
                    .map(function() {
                        return $(this).attr('id');
                    })
                    .get();

                var selectedProductSizes = $('.productsize-checkbox:checked')
                    .map(function() {
                        return $(this).attr('id');
                    })
                    .get();

                $.ajax({
                    url: "{{url('/filter')}}", // Change this to your Laravel route for filtering
                    method: 'GET',
                    data: {
                        categories: selectedCategories,
                        brands: selectedBrands,
                        productTypes: selectedProductTypes,
                        productSizes: selectedProductSizes
                    },
                    success: function(response) {
                        $('#filteredProducts').html(response); // Update the content of the container
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });


        $('#sortby2').on('change', function() {
            const selectedValue = $(this).val();

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

@stop

