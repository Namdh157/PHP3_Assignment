@extends('layouts.public')

@section('content')
<style>
    #deal-bg{
        background-image: url("{{ asset('storage/images') }}/bg-1.jpg");
    }
</style>

<main class="main">
    <div class="intro-slider-container h-100">
        <!-- intro-slider owl-carousel owl-theme -->
        <div class="slide">
            <img class="d-block" src="{{ asset('storage/images/slider') }}/slide-1.jpg" alt="" id="anh">
            <div class="container intro-content carousel-caption d-none d-md-block">
                <h3 class="intro-subtitle text-white">You're Looking Good</h3><!-- End .h3 intro-subtitle -->
                <h1 class="intro-title text-white">New Lookbook</h1>
                <a href="#" class="btn btn-outline-white-4">
                    <span>Discover More</span>
                </a>
            </div>
        </div>
        <div class="controlBtn">
            <button class="carousel-control-prev" type="button" onclick="previousImg()">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" onclick="nextImg()">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div><!-- End .intro-slider-container -->
    <div class="pt-2 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="{{ asset('storage/images') }}/banners/banner-1.jpg" alt="Banner">
                        </a>

                        <div class="banner-content banner-content-center">
                            <h4 class="banner-subtitle text-white">New in</h4>
                            <!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white"><strong>Women’s</strong></h3>
                            <!-- End .banner-title -->
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-sm-6 -->

                <div class="col-sm-6">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="{{ asset('storage/images') }}/banners/banner-2.jpg" alt="Banner">
                        </a>

                        <div class="banner-content banner-content-center">
                            <h4 class="banner-subtitle text-white">New in</h4>
                            <!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white"><strong>Men’s</strong></h3>
                            <!-- End .banner-title -->
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-sm-6 -->
            </div><!-- End .row -->
            <hr class="mt-0 mb-0">
        </div><!-- End .container -->
    </div><!-- End .bg-gray -->

    <div class="mb-5"></div><!-- End .mb-5 -->
    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 class="title text-center mb-4">Trending</h2><!-- End .title -->
            <div class="products">
                <div class="row justify-content-center">
                    @foreach ($trendingProducts as $item)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <a href="{{route('public.product.detail',$item->slug)}}">
                                    <img src="{{$item->image_thumbnail}}" alt="Product image" class="product-image product-thumbnail">
                                </a>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->
    
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{$item->catalogue->name}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{route('public.product.detail',$item->slug)}}">{{$item->name}}</a></h3>
                                <!-- End .product-title -->
                                <div class="product-price">
                                    <span class="new-price">Now {{$item->productVariants->min('price_sale')}} $</span>
                                        <span class="old-price">Was {{$item->productVariants->min('price_regular')}} $</span>
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                    @endforeach
                </div><!-- End .row -->
            </div><!-- End .products -->
    
        </div><!-- End .heading -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- End .mb-5 -->

    <div class="deal bg-image pt-8 pb-8" id="deal-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="deal-content text-center">
                        <h4>Limited quantities. </h4>
                        <h2>Deal of the Day</h2>
                        <div class="deal-countdown" data-until="+10h"></div><!-- End .deal-countdown -->
                    </div><!-- End .deal-content -->
                    <div class="row deal-products">
                        @foreach ($dealProducts as $item)
                        <div class="col-6 deal-product text-center">
                            <figure class="product-media">
                                <a href="{{route('public.product.detail',$item->slug)}}">
                                    <img src="{{$item->image_thumbnail}}" alt="Product image" class="product-image product-thumbnail">
                                </a>

                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <h3 class="product-title"><a href="{{route('public.product.detail',$item->slug)}}">{{$item->name}}</a></h3>
                                <!-- End .product-title -->
                                <div class="product-price">
                                    <span class="new-price">Now {{$item->productVariants->min('price_sale')}} $</span>
                                    <span class="old-price">Was {{$item->productVariants->min('price_regular')}} $</span>
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                            <a href="{{route('public.product.detail',$item->slug)}}" class="action">shop now</a>
                        </div>
                        @endforeach
                    </div>
                </div><!-- End .col-lg-5 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .deal -->

    <div class="pt-4 pb-3" style="background-color: #a47d90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-truck"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Payment & Delivery</h3><!-- End .icon-box-title -->
                            <>Free shipping for orders over 500.000vnđ>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-rotate-left"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Return & Refund</h3><!-- End .icon-box-title -->
                            <p>Free 100% money back guarantee</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-unlock"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Secure Payment</h3><!-- End .icon-box-title -->
                            <p>100% secure payment</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-headphones"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Quality Support</h3><!-- End .icon-box-title -->
                            <p>Alway online feedback 24/7</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-3 col-sm-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .bg-light pt-2 pb-2 -->

    <div class="mb-6"></div><!-- End .mb-5 -->

    <div class="container">
        <h2 class="title text-center mb-4">New Arrivals</h2><!-- End .title text-center -->
        <div class="products">
            <div class="row justify-content-center">
                @foreach ($newArrivalProducts as $item)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product product-7 text-center">
                        <figure class="product-media">
                            <a href="{{route('public.product.detail',$item->slug)}}">
                                <img src="{{$item->image_thumbnail}}" alt="Product image" class="product-image product-thumbnail">
                            </a>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">{{$item->catalogue->name}}</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{route('public.product.detail',$item->slug)}}">{{$item->name}}</a></h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">Now {{$item->productVariants->min('price_sale')}} $</span>
                                    <span class="old-price">Was {{$item->productVariants->min('price_regular')}} $</span>
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                @endforeach
            </div><!-- End .row -->
        </div><!-- End .products -->

        <div class="more-container text-center mt-2">
            <a href="#" class="btn btn-outline-dark-2 btn-more"><span>show more</span></a>
        </div><!-- End .more-container -->
    </div><!-- End .container -->

    <div class="pb-3">
        <div class="container brands pt-5 pt-lg-7 ">

            <h2 class="title text-center mb-4">shop by brands</h2><!-- End .title text-center -->

            <div class="d-flex justify-content-around">
                <a href="#" class="brand">
                    <img src="{{ asset('storage/images') }}/brands/1.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('storage/images') }}/brands/2.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('storage/images') }}/brands/3.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('storage/images') }}/brands/4.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('storage/images') }}/brands/5.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('storage/images') }}/brands/6.png" alt="Brand Name">
                </a>

                <a href="#" class="brand">
                    <img src="{{ asset('storage/images') }}/brands/7.png" alt="Brand Name">
                </a>
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->

        <div class="mb-5 mb-lg-7"></div><!-- End .mb-5 -->

        <div class="container newsletter">
            <div class="row">
                <div class="col-lg-6 banner-overlay-div">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="{{ asset('storage/images') }}/banners/banner-3.jpg" alt="Banner">
                        </a>

                        <div class="banner-content banner-content-center">
                            <h4 class="banner-subtitle text-white">Limited time only.</h4>
                            <!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white">End of Season<br>save 50% off
                            </h3><!-- End .banner-title -->
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-lg-6 -->

                <div class="col-lg-6 d-flex align-items-stretch subscribe-div">
                    <div class="cta cta-box">
                        <div class="cta-content">
                            <h3 class="cta-title">Subscribe To Our Newsletter</h3><!-- End .cta-title -->
                            <p>Sign up now for <span class="primary-color">10% discount</span> on first order.
                                Customise my news:</p>

                            <form action="#">
                                <input type="email" class="form-control" placeholder="Enter your Email Address" aria-label="Email Adress" required>
                                <div class="text-center">
                                    <button class="btn btn-outline-dark-2" type="submit"><span>subscribe</span></i></button>
                                </div><!-- End .text-center -->
                            </form>
                        </div><!-- End .cta-content -->
                    </div><!-- End .cta -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .bg-gray -->

    <div class="mb-2"></div><!-- End .mb-5 -->

    <div class="container">
    </div><!-- End .container -->

    <div class="blog-posts mb-5">
        <div class="container">
            <h2 class="title text-center mb-4">From Our Blog</h2><!-- End .title text-center -->

            <div class="owl-carousel owl-simple mb-3" data-toggle="owl" data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
                <article class="entry">
                    <figure class="entry-media">
                        <a href="#">
                            <img src="{{ asset('storage/images') }}/products/1.jpg" alt="image desc">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Nov 22, 2018</a>, 1 Comments
                        </div><!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="single.html">Sed adipiscing ornare.</a>
                        </h3><!-- End .entry-title -->

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Read More</a>
                        </div><!-- End .entry-content -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->

                <article class="entry">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ asset('storage/images') }}/products/product-4.jpg" alt="image desc">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 12, 2018</a>, 0 Comments
                        </div><!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="single.html">Fusce lacinia arcuet nulla.</a>
                        </h3><!-- End .entry-title -->

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Read More</a>
                        </div><!-- End .entry-content -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->

                <article class="entry">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ asset('storage/images') }}/products/product-5-1.jpg" alt="image desc">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 19, 2018</a>, 2 Comments
                        </div><!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="single.html">Quisque volutpat mattis eros.</a>
                        </h3><!-- End .entry-title -->

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Read More</a>
                        </div><!-- End .entry-content -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .blog-posts -->
</main><!-- End .main -->
@endsection