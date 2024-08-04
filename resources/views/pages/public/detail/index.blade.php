@extends('layouts.public')
@section('content')
    <main class="main">
        <div class="page-content mt-5">
            <div class="container">
                <div class="product-details-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery product-gallery-vertical">
                                <div class="row">
                                    <figure class="product-main-image">
                                        <img id="product-zoom" src="{{ asset('storage/images') }}/products/1.jpg">
                                    </figure><!-- End .product-main-image -->

                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        <a class="product-gallery-item active" href="#">
                                            <img src="{{ asset('storage/images') }}/products/1-small.jpg"
                                                alt="product side">
                                        </a>

                                        <a class="product-gallery-item" href="#">
                                            <img src="{{ asset('storage/images') }}/products/2-small.jpg"
                                                alt="product cross">
                                        </a>

                                        <a class="product-gallery-item" href="#">
                                            <img src="{{ asset('storage/images') }}/products/3-small.jpg"
                                                alt="product with model">
                                        </a>

                                        <a class="product-gallery-item" href="#">
                                            <img src="{{ asset('storage/images') }}/products/4-small.jpg"
                                                alt="product back">
                                        </a>
                                    </div><!-- End .product-image-gallery -->
                                </div><!-- End .row -->
                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->

                        <div class="col-md-6">
                            <div class="product-details sticky-content">
                                <h1 class="product-title">{{$product->name}}</h1><!-- End .product-title -->
                                <div class="product-price">
                                    <span class="new-price">{{$product->productVariants->min('price_sale')}} $</span>
                                    <span class="old-price">{{$product->productVariants->min('price_regular')}} $</span>
                                </div><!-- End .product-price -->

                                <div class="product-content">
                                    <p>{{$product->description}}</p>
                                </div><!-- End .product-content -->
                                <div class="details-filter-row details-row-size">
                                    <label for="size">Size:</label>
                                    <div class="select-custom">
                                        <select name="size" id="size" class="form-control">
                                            <option value="#" selected="selected">Select a size</option>
                                            <option value="s">S</option>
                                            <option value="m">M</option>
                                            <option value="l">L</option>
                                            <option value="xl">XL</option>
                                        </select>
                                    </div><!-- End .select-custom -->

                                </div><!-- End .details-filter-row -->

                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" value="1"
                                            min="1" max="10" step="1" data-decimals="0" required>
                                    </div><!-- End .product-details-quantity -->
                                </div><!-- End .details-filter-row -->

                                <div class="product-details-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>

                                    <div class="details-action-wrapper">
                                        <span>Brand: </span>
                                        <a href="#" class="ms-2">{{$product->brand->name}}</a>
                                    </div><!-- End .details-action-wrapper -->
                                </div><!-- End .product-details-action -->

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a href="#">{{$product->catalogue->name}}</a>
                                    </div><!-- End .product-cat -->
                                </div><!-- End .product-details-footer -->


                            </div><!-- End .product-details -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                    <div class="row">
                        <div class="accordion accordion-plus product-details-accordion" id="product-accordion">
                            <div class="card card-box card-sm">
                                <div class="card-header" id="product-desc-heading">
                                    <h2 class="card-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            href="#product-accordion-desc" aria-expanded="false"
                                            aria-controls="product-accordion-desc">
                                            Description
                                        </a>
                                    </h2>
                                </div><!-- End .card-header -->
                                <div id="product-accordion-desc" class="collapse" aria-labelledby="product-desc-heading"
                                    data-parent="#product-accordion">
                                    <div class="card-body">
                                        <div class="product-desc-content">
                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.
                                                Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.
                                                Suspendisse urna viverra non, semper suscipit, posuere a, pede.
                                                Donec nec justo eget felis facilisis fermentum. Aliquam porttitor
                                                mauris sit amet orci.</p>
                                            <ul>
                                                <li>Nunc nec porttitor turpis. In eu risus enim. In vitae mollis
                                                    elit. </li>
                                                <li>Vivamus finibus vel mauris ut vehicula.</li>
                                                <li>Nullam a magna porttitor, dictum risus nec, faucibus sapien.
                                                </li>
                                            </ul>

                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.
                                                Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.
                                                Suspendisse urna viverra non, semper suscipit, posuere a, pede.</p>
                                        </div><!-- End .product-desc-content -->
                                    </div><!-- End .card-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .card -->
                            <div class="card card-box card-sm">
                                <div class="card-header" id="product-review-heading">
                                    <h2 class="card-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            href="#product-accordion-review" aria-expanded="false"
                                            aria-controls="product-accordion-review">
                                            Reviews (2)
                                        </a>
                                    </h2>
                                </div><!-- End .card-header -->
                                <div id="product-accordion-review" class="collapse"
                                    aria-labelledby="product-review-heading" data-parent="#product-accordion">
                                    <div class="card-body">
                                        <div class="reviews">
                                            <div class="review">
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <h4><a href="#">Samanta J.</a></h4>
                                                        <span class="review-date">6 days ago</span>
                                                    </div><!-- End .col -->
                                                    <div class="col">
                                                        <h4>Good, perfect size</h4>

                                                        <div class="review-content">
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                elit. Ducimus cum dolores assumenda asperiores
                                                                facilis porro reprehenderit animi culpa atque
                                                                blanditiis commodi perspiciatis doloremque,
                                                                possimus, explicabo, autem fugit beatae quae
                                                                voluptas!</p>
                                                        </div><!-- End .review-content -->
                                                    </div><!-- End .col-auto -->
                                                </div><!-- End .row -->
                                            </div><!-- End .review -->

                                            <div class="review">
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <h4><a href="#">John Doe</a></h4>
                                                        <span class="review-date">5 days ago</span>
                                                    </div><!-- End .col -->
                                                    <div class="col">
                                                        <h4>Very good</h4>

                                                        <div class="review-content">
                                                            <p>Sed, molestias, tempore? Ex dolor esse iure hic
                                                                veniam laborum blanditiis laudantium iste amet. Cum
                                                                non voluptate eos enim, ab cumque nam, modi, quas
                                                                iure illum repellendus, blanditiis perspiciatis
                                                                beatae!</p>
                                                        </div><!-- End .review-content -->
                                                    </div><!-- End .col-auto -->
                                                </div><!-- End .row -->
                                            </div><!-- End .review -->
                                        </div><!-- End .reviews -->
                                    </div><!-- End .card-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .card -->
                        </div><!-- End .accordion -->
                    </div>
                </div><!-- End .product-details-top -->

                <hr>
                <div class="container">
                    <div class="heading heading-center mb-3">
                        <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
                        <div class="products">
                            <div class="row justify-content-center">
                                @foreach ($alsoLikeProducts as $item)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <a href="{{ route('public.product.detail', $item->slug) }}">
                                                    <img src="{{ asset('') }}{{ $item->image_thumbnail }}" alt="Product image product-thumbnail"
                                                        class="product-image">
                                                </a>
                                                <div class="product-action">
                                                    <a href="#" class="btn-product btn-cart"><span>add to
                                                            cart</span></a>
                                                </div><!-- End .product-action -->
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="#">{{ $item->catalogue->name }}</a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a
                                                        href="{{ route('public.product.detail', $item->slug) }}">{{ $item->name }}</a>
                                                </h3>
                                                <!-- End .product-title -->
                                                <div class="product-price">
                                                    <span class="new-price">Now
                                                        {{ $item->productVariants->min('price_sale') }} $</span>
                                                    <span class="old-price">Was
                                                        {{ $item->productVariants->min('price_regular') }} $</span>
                                                </div><!-- End .product-price -->
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                                @endforeach
                            </div><!-- End .row -->
                        </div><!-- End .products -->
                    </div>
                </div>
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
