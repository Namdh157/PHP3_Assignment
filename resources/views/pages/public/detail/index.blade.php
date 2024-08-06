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
                                    <img id="product-zoom" src="{{ asset($product['image_thumbnail']) }}">
                                </figure>
                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    @foreach ($product['product_galleries'] as $item)
                                    <a class="product-gallery-item active" href="#">
                                        <img src="{{ asset($item['image']) }}" alt="product side">
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-details sticky-content">
                            <h1 class="product-title">{{$product['name']}}</h1>
                            <div class="product-price">
                                <span class="old-price"><span id="old-price">{{$product['product_variants'][0]['price_regular']}}</span> $</span>
                                <span class="new-price ms-3"><span id="new-price">{{$product['product_variants'][0]['price_sale']}}</span> $</span>
                            </div>
                            <div class="product-content">
                                <p>{{$product['description']}}</p>
                            </div>
                            <div class="details-filter-row">
                                <div class="details-row-size">
                                    <label for="size">Size:</label>
                                    <div class="select-custom">
                                        <select name="size" id="size" class="form-control" onchange="onChangeSize(event)">
                                            <option value="" selected="selected">Select a size</option>
                                            @foreach ($product['product_variants'] as $size)
                                            <option value="{{$size['variant_size']['id']}}">{{$size['variant_size']['size']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="details-row-color">
                                    <label for="color">Color:</label>
                                    <div class="select-custom">
                                        <select name="color" id="color" class="form-control" onchange="onChangeColor(event)">
                                            <option value="" selected="selected">Select a color</option>
                                            @foreach ($product['product_variants'] as $color)
                                            <option value="{{$color['variant_color']['id']}}">{{$color['variant_color']['color']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="details-filter-row gap-5">
                                <div class="details-row-qty">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" value="1" onchange="onChangeQty(event)" min="1" step="1" data-decimals="0" required>
                                    </div>
                                </div>
                                <div class="details-row-stock ms-3">
                                    Stock: <span id="stock"></span>
                                </div>
                            </div>

                            <div class="product-details-action">
                                <button onclick="addProductToCart()" class="btn-product btn-cart"><span>add to cart</span></button>

                                <div class="details-action-wrapper">
                                    <span>Brand: </span>
                                    <a href="#" class="ms-2">{{$product['brand']['name']}}</a>
                                </div>
                            </div>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#">{{$product['catalogue']['name']}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="accordion accordion-plus product-details-accordion" id="product-accordion">
                        <div class="card card-box card-sm">
                            <div class="card-header" id="product-desc-heading">
                                <h2 class="card-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#product-accordion-desc" aria-expanded="false" aria-controls="product-accordion-desc">
                                        Description
                                    </a>
                                </h2>
                            </div>
                            <div id="product-accordion-desc" class="collapse" aria-labelledby="product-desc-heading" data-parent="#product-accordion">
                                <div class="card-body">
                                    <div class="product-desc-content">
                                        {!! $product['content'] !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-box card-sm">
                            <div class="card-header" id="product-review-heading">
                                <h2 class="card-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#product-accordion-review" aria-expanded="false" aria-controls="product-accordion-review">
                                        Reviews ({{$comments->count()}})
                                    </a>
                                </h2>
                            </div>
                            <div id="product-accordion-review" class="collapse" aria-labelledby="product-review-heading" data-parent="#product-accordion">
                                <div class="card-body">
                                    <div class="reviews">
                                        @if ($comments->count() == 0)
                                        <div class="review">
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <h4><a href="#">No review</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @foreach ($comments as $key => $comment)
                                        <div class="review">
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <h4><a href="#">{{$comment->user_name}}</a></h4>
                                                    <span class="review-date">{{$comment->updated_at->diffForHumans()}}</span>
                                                </div>
                                                <div class="col">
                                                    <h4>Good, perfect size</h4>
                                                    <div class="review-content">
                                                        <p>{{$comment->content}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group">
                                    <label for="review-content">Your Review</label>
                                    <textarea class="form-control" name="content" id="review-content" rows="4"></textarea>
                                </div>
                                <button type="button" class="btn btn-primary rounded" onclick="addComment()">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="container">
            <div class="heading heading-center mb-3">
                <h2 class="title text-center mb-4">You May Also Like</h2>
                <div class="products">
                    <div class="row justify-content-center">
                        @foreach ($alsoLikeProducts as $item)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product product-7 text-center">
                                <figure class="product-media">
                                    <a href="{{ route('public.product.detail', $item->slug) }}">
                                        <img src="{{ asset($item->image_thumbnail) }}" alt="Product image product-thumbnail" class="product-image">
                                    </a>
                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart"><span>add to
                                                cart</span></a>
                                    </div>
                                </figure>

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#">{{ $item->catalogue->name }}</a>
                                    </div>
                                    <h3 class="product-title"><a href="{{ route('public.product.detail', $item->slug) }}">{{ $item->name }}</a>
                                    </h3>

                                    @if (empty($item->productVariants->min('price_sale')))
                                    <div class="product-price">
                                        <span class="new-price">Now
                                            {{ $item->productVariants->min('price_regular') }} $</span>
                                    </div>
                                    @else
                                    <div class="product-price">
                                        <span class="new-price">Now
                                            {{ $item->productVariants->min('price_sale') }} $</span>
                                        <span class="old-price">Was
                                            {{ $item->productVariants->min('price_regular') }} $</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection
<!-- config script -->
<script>
    const route = "{{ route('api.cart.create') }}"
</script>
<!-- handle script -->
@php
$variant = json_encode($product['product_variants']);
@endphp
<script>
    const variant = JSON.parse('{!!$variant!!}');
    const sizeMap = {};
    const colorMap = {};
    const stockMap = {};
    const priceMap = {};

    variant.forEach(v => {
        const color_id = v.variant_color.id;
        const size_id = v.variant_size.id;

        if (!(size_id in sizeMap)) sizeMap[size_id] = [];
        if (!(color_id in colorMap)) colorMap[color_id] = [];

        sizeMap[size_id].push(color_id);
        colorMap[color_id].push(size_id);
        stockMap[`${size_id}-${color_id}`] = v.stock;
        priceMap[`${size_id}-${color_id}`] = [v.price_regular, v.price_sale];
    })

    function onChangeSize(e) {
        const size_id = e.target.value;
        const color = document.querySelector('#color');
        const options = color.querySelectorAll('option');
        if (!size_id) {
            options.forEach(option => {
                option.style.display = 'block';
            })
            return;
        }
        options.forEach(option => {
            if (!option.value || sizeMap[size_id]?.includes(Number(option.value))) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        })
        if (isSelectedAll()) {
            const color_id = color.value;
            const stock = document.querySelector('#stock');
            const oldPrice = document.querySelector('#old-price');
            const newPrice = document.querySelector('#new-price');
            stock.innerText = stockMap[`${size_id}-${color_id}`];
            oldPrice.innerText = priceMap[`${size_id}-${color_id}`][0];
            newPrice.innerText = priceMap[`${size_id}-${color_id}`][1];
        }
    }

    function onChangeColor(e) {
        const color_id = e.target.value;
        const size = document.querySelector('#size');
        const options = size.querySelectorAll('option');
        if (!color_id) {
            options.forEach(option => {
                option.style.display = 'block';
            })
            return;
        }
        options.forEach(option => {
            if (!option.value || colorMap[color_id]?.includes(Number(option.value))) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        })
        if (isSelectedAll()) {
            const size_id = size.value;
            const stock = document.querySelector('#stock');
            const oldPrice = document.querySelector('#old-price');
            const newPrice = document.querySelector('#new-price');
            stock.innerText = stockMap[`${size_id}-${color_id}`];
            oldPrice.innerText = priceMap[`${size_id}-${color_id}`][0];
            newPrice.innerText = priceMap[`${size_id}-${color_id}`][1];
        }
    }

    function isSelectedAll() {
        const size = document.querySelector('#size');
        const color = document.querySelector('#color');
        return size.value && color.value;
    }

    function onChangeQty(e) {
        const qty = e.target.value;
        const stock = document.querySelector('#stock');

        if (isSelectedAll()) {
            if (qty < 1) {
                ToastCustom('Quantity must be greater than 0', 'error')
                e.target.value = 1;
            }
            if (qty > Number(stock.innerText)) {
                ToastCustom('Out of stock', 'error')
                e.target.value = stock.innerText;
            }
        } else {
            ToastCustom('Please select size and color', 'error')
            e.target.value = 1;
        }
    }

    function addProductToCart() {
        const product_id = "{{ $product['id'] }}";
        const color = document.querySelector('#color');
        const size = document.querySelector('#size');
        const qty = document.querySelector('#qty');
        const stock = document.querySelector('#stock');
        if (!size.value || !color.value) {
            ToastCustom('Please select size and color', 'error')
            return
        }

        const data = {
            size: size.value,
            color: color.value,
            quantity: qty.value,
            product_id: product_id
        }

        sendRequest(route, data, 'POST', (count) => {
            ToastCustom('Add product to cart successfully', 'success');  
            document.querySelector('#cart-count').innerText = count;
        })

    }

    function addComment() {
        const content = document.querySelector('#review-content').value;
        const product_id = "{{ $product['id'] }}";
        const data = {
            content: content,
            product_id: product_id
        }

        sendRequest("{{ route('api.comment.create') }}", data, 'POST', () => {
            ToastCustom('Add comment successfully', 'success')
            window.location.reload();
        })
    }
</script>