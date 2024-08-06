@extends('layouts.public')

@section('content')
<style>
    #deal-bg {
        background-image: url("{{ asset('storage/images') }}/bg-1.jpg");
    }
</style>

<main class="main">
    <div class="intro-slider-container h-100">
        <!-- intro-slider owl-carousel owl-theme -->
        @if ($slideBanner)
        <div class="slide">
            <img class="d-block object-fit-{{$slideBanner->object_fit}} mx-auto" src="{{$slideBanner->bannerImages[0]->url}}" {{'style=width:'.$slideBanner->width.'px;height:'.$slideBanner->height.'px;'}} alt="" id="slide-image">
            <div class="container intro-content carousel-caption d-none d-md-block">
                <h3 class="intro-subtitle text-white">You're Looking Good</h3>
                <h1 class="intro-title text-white">New Lookbook</h1>
                <a href="#" class="btn btn-outline-white-4">
                    <span>Discover More</span>
                </a>
            </div>
        </div>
        <div class="controlBtn">
            <button class="carousel-control-prev" type="button" onclick="prevSlide()">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" onclick="nextSlide()">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        @endif
    </div>
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

                            <h3 class="banner-title text-white"><strong>Women’s</strong></h3>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="{{ asset('storage/images') }}/banners/banner-2.jpg" alt="Banner">
                        </a>

                        <div class="banner-content banner-content-center">
                            <h4 class="banner-subtitle text-white">New in</h4>

                            <h3 class="banner-title text-white"><strong>Men’s</strong></h3>

                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-0 mb-0">
        </div>
    </div>

    <div class="mb-5"></div>
    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 class="title text-center mb-4">Trending</h2>
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
                                    <a href="{{route('public.product.detail',$item->slug)}}" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div>
                            </figure>

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="{{route('public.product.detail',$item->slug)}}">{{$item->catalogue->name}}</a>
                                </div>
                                <h3 class="product-title"><a href="{{route('public.product.detail',$item->slug)}}">{{$item->name}}</a></h3>

                                <div class="product-price">
                                    <span class="new-price">Now {{$item->productVariants->min('price_sale')}} $</span>
                                    <span class="old-price">Was {{$item->productVariants->min('price_regular')}} $</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="mb-5"></div>

    <div class="deal bg-image pt-8 pb-8" id="deal-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="deal-content text-center">
                        <h4>Limited quantities. </h4>
                        <h2>Deal of the Day</h2>
                        <div class="deal-countdown" data-until="+10h"></div>
                    </div>
                    <div class="row deal-products">
                        @foreach ($dealProducts as $item)
                        <div class="col-6 deal-product text-center">
                            <figure class="product-media">
                                <a href="{{route('public.product.detail',$item->slug)}}">
                                    <img src="{{$item->image_thumbnail}}" alt="Product image" class="product-image product-thumbnail">
                                </a>

                            </figure>

                            <div class="product-body">
                                <h3 class="product-title"><a href="{{route('public.product.detail',$item->slug)}}">{{$item->name}}</a></h3>

                                <div class="product-price">
                                    <span class="new-price">Now {{$item->productVariants->min('price_sale')}} $</span>
                                    <span class="old-price">Was {{$item->productVariants->min('price_regular')}} $</span>
                                </div>
                            </div>
                            <a href="{{route('public.product.detail',$item->slug)}}" class="action">shop now</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4 pb-3" style="background-color: #a47d90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-truck"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Payment & Delivery</h3>
                            <>Free shipping for orders over 500.000vnđ>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-rotate-left"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Return & Refund</h3>
                            <p>Free 100% money back guarantee</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-unlock"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Secure Payment</h3>
                            <p>100% secure payment</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon">
                            <i class="icon-headphones"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Quality Support</h3>
                            <p>Alway online feedback 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6"></div>

    <div class="container">
        <h2 class="title text-center mb-4">New Arrivals</h2>
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
                                <a href="{{route('public.product.detail',$item->slug)}}" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div>
                        </figure>

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="{{route('public.product.detail',$item->slug)}}">{{$item->catalogue->name}}</a>
                            </div>
                            <h3 class="product-title"><a href="{{route('public.product.detail',$item->slug)}}">{{$item->name}}</a></h3>

                            <div class="product-price">
                                <span class="new-price">Now {{$item->productVariants->min('price_sale')}} $</span>
                                <span class="old-price">Was {{$item->productVariants->min('price_regular')}} $</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="more-container text-center mt-2">
            <a href="#" class="btn btn-outline-dark-2 btn-more"><span>show more</span></a>
        </div>
    </div>

    <div class="pb-3">
        <div class="container brands pt-5 pt-lg-7 ">

            <h2 class="title text-center mb-4">shop by brands</h2>

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
            </div>
        </div>

        <div class="mb-5 mb-lg-7"></div>

        <div class="container newsletter">
            <div class="row">
                <div class="col-lg-6 banner-overlay-div">
                    <div class="banner banner-overlay">
                        <a href="#">
                            <img src="{{ asset('storage/images') }}/banners/banner-3.jpg" alt="Banner">
                        </a>

                        <div class="banner-content banner-content-center">
                            <h4 class="banner-subtitle text-white">Limited time only.</h4>

                            <h3 class="banner-title text-white">End of Season<br>save 50% off
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-flex align-items-stretch subscribe-div">
                    <div class="cta cta-box">
                        <div class="cta-content">
                            <h3 class="cta-title">Subscribe To Our Newsletter</h3>
                            <p>Sign up now for <span class="primary-color">10% discount</span> on first order.
                                Customise my news:</p>

                            <form action="#">
                                <input type="email" class="form-control" placeholder="Enter your Email Address" aria-label="Email Adress" required>
                                <div class="text-center">
                                    <button class="btn btn-outline-dark-2" type="submit"><span>subscribe</span></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2"></div>

    <div class="container">
    </div>

    <div class="blog-posts mb-5">
        <div class="container">
            <h2 class="title text-center mb-4">From Our Blog</h2>

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
                    </figure>

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Nov 22, 2018</a>, 1 Comments
                        </div>

                        <h3 class="entry-title">
                            <a href="single.html">Sed adipiscing ornare.</a>
                        </h3>

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Read More</a>
                        </div>
                    </div>
                </article>

                <article class="entry">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ asset('storage/images') }}/products/product-4.jpg" alt="image desc">
                        </a>
                    </figure>

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 12, 2018</a>, 0 Comments
                        </div>

                        <h3 class="entry-title">
                            <a href="single.html">Fusce lacinia arcuet nulla.</a>
                        </h3>

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Read More</a>
                        </div>
                    </div>
                </article>

                <article class="entry">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ asset('storage/images') }}/products/product-5-1.jpg" alt="image desc">
                        </a>
                    </figure>

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 19, 2018</a>, 2 Comments
                        </div>

                        <h3 class="entry-title">
                            <a href="single.html">Quisque volutpat mattis eros.</a>
                        </h3>

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Read More</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
@if ($slideBanner)
<script>
    const slideData = JSON.parse(`@json($slideBanner->bannerImages)`);
    let currentSlide = 0;
    const imageSlide = document.getElementById('slide-image');

    function prevSlide() {
        currentSlide--;
        if (currentSlide < 0) {
            currentSlide = slideData.length - 1;
        }
        imageSlide.src = slideData[currentSlide].url;
    }

    function nextSlide() {
        currentSlide++;
        if (currentSlide >= slideData.length) {
            currentSlide = 0;
        }
        imageSlide.src = slideData[currentSlide].url;
    }
</script>
@endif
@endsection