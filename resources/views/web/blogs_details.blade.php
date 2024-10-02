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
            padding: 10rem 0;
        }
        .editor-content p, .editor-content p {
            color:#fff !important;
        }
    </style>
@stop
@section('body')
    <?php
    $get_cart = get_cart();
    $get_count = json_decode($get_cart);
    $getAllCart = getCartProducts();

    $get_shop_banner = \App\Models\BannerModel::where('display_area',6)->orderBy('id','DESC')->first();
//    print_r($get_shop_banner);die;
    ?>
    <main class="main">
        <div class="page-header text-center"
             style="background-image: url({{asset($all_blog->image_big)}})">
            <div class="container">
                <h1 class="page-title"><span>Blogs /  {{$all_blog->title}}</span></h1>
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
                <div class="row">
                    <div class="col-lg-9">
                        <article class="entry single-entry">
                            <figure class="entry-media">
                                <img src="{{asset($all_blog->image_big)}}" alt="image desc">
                            </figure><!-- End .entry-media -->

                            <div class="entry-body">
                                <div class="entry-meta">
                                    <span class="meta-separator">|</span>
                                    <a href="#">Admin </a>
                                </div><!-- End .entry-meta -->

                                <h2 class="entry-title">
                                    {{$all_blog->title}}
                                </h2><!-- End .entry-title -->


                                <div class="entry-content editor-content">
                                    <?php
                                    echo $all_blog->content;
                                    ?>
                                </div><!-- End .entry-content -->

                            </div><!-- End .entry-body -->

                        </article><!-- End .entry -->

                    </div><!-- End .col-lg-9 -->

{{--                    <aside class="col-lg-3">--}}
{{--                        <div class="sidebar">--}}
{{--                            <div class="widget widget-search">--}}
{{--                                <h3 class="widget-title">Search</h3><!-- End .widget-title -->--}}

{{--                                <form action="#">--}}
{{--                                    <label for="ws" class="sr-only">Search in blog</label>--}}
{{--                                    <input type="search" class="form-control" name="ws" id="ws" placeholder="Search in blog" required="">--}}
{{--                                    <button type="submit" class="btn"><i class="icon-search"></i><span class="sr-only">Search</span></button>--}}
{{--                                </form>--}}
{{--                            </div><!-- End .widget -->--}}

{{--                            <div class="widget widget-cats">--}}
{{--                                <h3 class="widget-title">Categories</h3><!-- End .widget-title -->--}}

{{--                                <ul>--}}
{{--                                    <li><a href="#">Lifestyle<span>3</span></a></li>--}}
{{--                                    <li><a href="#">Shopping<span>3</span></a></li>--}}
{{--                                    <li><a href="#">Fashion<span>1</span></a></li>--}}
{{--                                    <li><a href="#">Travel<span>3</span></a></li>--}}
{{--                                    <li><a href="#">Hobbies<span>2</span></a></li>--}}
{{--                                </ul>--}}
{{--                            </div><!-- End .widget -->--}}

{{--                            <div class="widget">--}}
{{--                                <h3 class="widget-title">Popular Posts</h3><!-- End .widget-title -->--}}

{{--                                <ul class="posts-list">--}}
{{--                                    <li>--}}
{{--                                        <figure>--}}
{{--                                            <a href="#">--}}
{{--                                                <img src="assets/images/blog/sidebar/post-1.jpg" alt="post">--}}
{{--                                            </a>--}}
{{--                                        </figure>--}}

{{--                                        <div>--}}
{{--                                            <span>Nov 22, 2018</span>--}}
{{--                                            <h4><a href="#">Aliquam tincidunt mauris eurisus.</a></h4>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <figure>--}}
{{--                                            <a href="#">--}}
{{--                                                <img src="assets/images/blog/sidebar/post-2.jpg" alt="post">--}}
{{--                                            </a>--}}
{{--                                        </figure>--}}

{{--                                        <div>--}}
{{--                                            <span>Nov 19, 2018</span>--}}
{{--                                            <h4><a href="#">Cras ornare tristique elit.</a></h4>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <figure>--}}
{{--                                            <a href="#">--}}
{{--                                                <img src="assets/images/blog/sidebar/post-3.jpg" alt="post">--}}
{{--                                            </a>--}}
{{--                                        </figure>--}}

{{--                                        <div>--}}
{{--                                            <span>Nov 12, 2018</span>--}}
{{--                                            <h4><a href="#">Vivamus vestibulum ntulla nec ante.</a></h4>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <figure>--}}
{{--                                            <a href="#">--}}
{{--                                                <img src="assets/images/blog/sidebar/post-4.jpg" alt="post">--}}
{{--                                            </a>--}}
{{--                                        </figure>--}}

{{--                                        <div>--}}
{{--                                            <span>Nov 25, 2018</span>--}}
{{--                                            <h4><a href="#">Donec quis dui at dolor  tempor interdum.</a></h4>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                </ul><!-- End .posts-list -->--}}
{{--                            </div><!-- End .widget -->--}}

{{--                            <div class="widget widget-banner-sidebar">--}}
{{--                                <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->--}}

{{--                                <div class="banner-sidebar">--}}
{{--                                    <a href="#">--}}
{{--                                        <img src="assets/images/blog/sidebar/banner.jpg" alt="banner">--}}
{{--                                    </a>--}}
{{--                                </div><!-- End .banner-ad -->--}}
{{--                            </div><!-- End .widget -->--}}

{{--                            <div class="widget">--}}
{{--                                <h3 class="widget-title">Browse Tags</h3><!-- End .widget-title -->--}}

{{--                                <div class="tagcloud">--}}
{{--                                    <a href="#">fashion</a>--}}
{{--                                    <a href="#">style</a>--}}
{{--                                    <a href="#">women</a>--}}
{{--                                    <a href="#">photography</a>--}}
{{--                                    <a href="#">travel</a>--}}
{{--                                    <a href="#">shopping</a>--}}
{{--                                    <a href="#">hobbies</a>--}}
{{--                                </div><!-- End .tagcloud -->--}}
{{--                            </div><!-- End .widget -->--}}

{{--                            <div class="widget widget-text">--}}
{{--                                <h3 class="widget-title">About Blog</h3><!-- End .widget-title -->--}}

{{--                                <div class="widget-text-content">--}}
{{--                                    <p>Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, pulvinar nunc sapien ornare nisl.</p>--}}
{{--                                </div><!-- End .widget-text-content -->--}}
{{--                            </div><!-- End .widget -->--}}
{{--                        </div><!-- End .sidebar sidebar-shop -->--}}
{{--                    </aside><!-- End .col-lg-3 -->--}}
                </div>
            </div>
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

