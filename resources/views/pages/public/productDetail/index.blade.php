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
                                            <img src="{{ asset('storage/images') }}/products/1-small.jpg" alt="product side">
                                        </a>

                                        <a class="product-gallery-item" href="#" >
                                            <img src="{{ asset('storage/images') }}/products/2-small.jpg" alt="product cross">
                                        </a>

                                        <a class="product-gallery-item" href="#">
                                            <img src="{{ asset('storage/images') }}/products/3-small.jpg" alt="product with model">
                                        </a>

                                        <a class="product-gallery-item" href="#" >
                                            <img src="{{ asset('storage/images') }}/products/4-small.jpg" alt="product back">
                                        </a>
                                    </div><!-- End .product-image-gallery -->
                                </div><!-- End .row -->
                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->

                        <div class="col-md-6">
                            <div class="product-details sticky-content">
                                <h1 class="product-title">Brown faux fur longline coat</h1><!-- End .product-title -->
                                <div class="product-price">
                                    <span class="new-price">1.900.000vnđ</span>
                                    <span class="old-price">3.100.000vnđ</span>
                                </div><!-- End .product-price -->

                                <div class="product-content">
                                    <p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus
                                        libero eu augue. Morbi purus libero, faucibus adipiscing. Sed lectus. </p>
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
                                        <a href="#" class="ms-2">Yody</a>
                                    </div><!-- End .details-action-wrapper -->
                                </div><!-- End .product-details-action -->

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a href="#">Women</a>
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
                                <div id="product-accordion-desc" class="collapse"
                                    aria-labelledby="product-desc-heading" data-parent="#product-accordion">
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
                                <div class="card-header" id="product-info-heading">
                                    <h2 class="card-title">
                                        <a role="button" data-toggle="collapse" href="#product-accordion-info"
                                            aria-expanded="true" aria-controls="product-accordion-info">
                                            Additional Information
                                        </a>
                                    </h2>
                                </div><!-- End .card-header -->
                                <div id="product-accordion-info" class="collapse show"
                                    aria-labelledby="product-info-heading" data-parent="#product-accordion">
                                    <div class="card-body">
                                        <div class="product-desc-content">
                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.
                                                Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.
                                                Suspendisse urna viverra non, semper suscipit, posuere a, pede.
                                                Donec nec justo eget felis facilisis fermentum. Aliquam porttitor
                                                mauris sit amet orci. </p>

                                            <h3>Fabric & care</h3>
                                            <ul>
                                                <li>100% Polyester</li>
                                                <li>Do not iron</li>
                                                <li>Do not wash</li>
                                                <li>Do not bleach</li>
                                                <li>Do not tumble dry</li>
                                                <li>Professional dry clean only</li>
                                            </ul>

                                            <h3>Size</h3>
                                            <p>S, M, L, XL</p>
                                        </div><!-- End .product-desc-content -->
                                    </div><!-- End .card-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .card -->

                            <div class="card card-box card-sm">
                                <div class="card-header" id="product-shipping-heading">
                                    <h2 class="card-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            href="#product-accordion-shipping" aria-expanded="false"
                                            aria-controls="product-accordion-shipping">
                                            Shipping & Returns
                                        </a>
                                    </h2>
                                </div><!-- End .card-header -->
                                <div id="product-accordion-shipping" class="collapse"
                                    aria-labelledby="product-shipping-heading" data-parent="#product-accordion">
                                    <div class="card-body">
                                        <div class="product-desc-content">
                                            <p>We deliver to over 100 countries around the world. For full details
                                                of the delivery options we offer, please view our <a
                                                    href="#">Delivery information</a><br>
                                                We hope you’ll love every purchase, but if you ever need to return
                                                an item you can do so within a month of receipt. For full details of
                                                how to make a return, please view our <a href="#">Returns
                                                    information</a></p>
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

                <hr class="mt-3 mb-5">

                <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":4,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>
                    <div class="product product-7">
                        <figure class="product-media">
                            <span class="product-label label-new">New</span>
                            <a href="{{ route('detail') }}">
                                <img src="{{ asset('storage/images') }}/products/product-4.jpg" alt="Product image"
                                    class="product-image">
                            </a>

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Women</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{ route('detail') }}">Brown paperbag waist <br>pencil
                                    skirt</a>
                            </h3><!-- End .product-title -->
                            <div class="product-price">
                                600.000vnđ
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product product-7">
                        <figure class="product-media">
                            <span class="product-label label-out">Out of Stock</span>
                            <a href="{{ route('detail') }}">
                                <img src="{{ asset('storage/images') }}/products/product-4.jpg" alt="Product image"
                                    class="product-image">
                            </a>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Jackets</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{ route('detail') }}">Khaki utility boiler jumpsuit</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="out-price">1.200.000vnđ</span>
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product product-7">
                        <figure class="product-media">
                            <span class="product-label label-top">Top</span>
                            <a href="{{ route('detail') }}">
                                <img src="{{ asset('storage/images') }}/products/product-4.jpg" alt="Product image"
                                    class="product-image">
                            </a>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Shoes</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{ route('detail') }}">Light brown studded Wide fit
                                    wedges</a></h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                1.100.000vnđ
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product product-7">
                        <figure class="product-media">
                            <a href="{{ route('detail') }}">
                                <img src="{{ asset('storage/images') }}/products/product-4.jpg" alt="Product image"
                                    class="product-image">
                            </a>

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Jumpers</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{ route('detail') }}">Yellow button front tea top</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                560.000vnđ
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product product-7">
                        <figure class="product-media">
                            <a href="{{ route('detail') }}">
                                <img src="{{ asset('storage/images') }}/products/product-4.jpg" alt="Product image"
                                    class="product-image">
                            </a>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Jeans</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="{{ route('detail') }}">Blue utility pinafore denim
                                    dress</a></h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                760.000vnđ
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .owl-carosel -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
