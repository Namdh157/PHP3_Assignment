@extends('layouts.public')

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset(`storage/images/page-header-bg.jpg`) }}')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <div class="page-content mt-5">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($cartItems as $item)
                                @php
                                $cartTotal += ($item->productVariant->price_sale ?? 0) * $item->quantity;
                                @endphp
                                <tr>
                                    <td class="product-col px-3">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="{{route('public.product.detail',$item->productVariant->product->slug)}}">
                                                    <img src="{{ asset($item->productVariant->product->image_thumbnail) }}" alt="Product image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="{{route('public.product.detail',$item->productVariant->product->slug)}}">
                                                    {{$item->productVariant->product->name}}
                                                    <p class="mt-1 fs-6">{{$item->productVariant->variantColor->color . ' - ' .$item->productVariant->variantSize->size}}</p>
                                                </a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">
                                        <div class="d-flex align-items-center">
                                            <input type="number" name="price" class="form-control m-0 p-0 border-0 text-end bg-transparent" value="{{$item->productVariant->price_sale ?? 0}}" style="width: 80px" readonly>$
                                        </div>
                                    </td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity mx-auto">
                                            <input type="number" name="quantity" class="form-control text-center" value="{{$item->quantity}}" min="1" step="1" data-decimals="0" onchange="onChangeQuantity(this)">
                                        </div><!-- End .cart-product-quantity -->
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="number" name="item-total" class="form-control m-0 p-0 border-0 text-end bg-transparent" value="{{($item->productVariant->price_sale ?? 0) * $item->quantity}}" style="width: 80px" readonly>$
                                        </div>
                                    </td>
                                    <td class="remove-col text-center"><button class="btn-remove mx-auto" onclick="onRemoveCartItem(this)" data-cart-id="{{$item->id}}">x</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->
                    </div><!-- End .col-lg-9 -->

                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td><span id="sub-total">{{$cartTotal}}</span>$</td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr class="summary-shipping">
                                        <td>Shipping:</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="free-shipping" name="shipping" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="free-shipping">Free Shipping:</label>
                                            </div><!-- End .custom-control -->
                                        </td>
                                        <td>0.00$</td>
                                    </tr><!-- End .summary-shipping-row -->

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td><span id="cart-total">{{$cartTotal}}</span>$</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a href="{{ route('public.checkout')}}" class="btn btn-outline-primary-2 btn-order btn-block w-100">PROCEED TO CHECKOUT</a>
                        </div><!-- End .summary -->

                        <a href="{{ route('public.allProduct')}}" class="btn btn-outline-dark-2 btn-block mb-3 w-100"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

<!-- <form id="remove-item-form">
    @csrf
</form> -->
@endsection

@section('script')
<!-- Config script -->
<script>
    const routeDelete = "{{ route('api.cart.destroy', ':cartId') }}";
</script>
<!-- Handler script -->
<script>
    function onChangeQuantity(input) {
        updateItemTotal(input.closest('tr'));
        updateCartTotal();
    }

    function onRemoveCartItem(button) {
        if (!confirm('Are you sure to remove this item?')) {
            return;
        }
        const cartId = button.getAttribute('data-cart-id');
        url = routeDelete.replace(':cartId', cartId);

        sendRequest(url, {}, 'DELETE', (data) => {
            button.closest('tr').remove();
            updateCartTotal();
        });
    }

    function updateItemTotal(tr) {
        const price = tr.querySelector('input[name="price"]').value;
        const quantity = tr.querySelector('input[name="quantity"]').value;
        const itemTotal = tr.querySelector('input[name="item-total"]');
        itemTotal.value = (price * quantity).toFixed(2);
    }

    function updateCartTotal() {
        const cartTotal = document.getElementById('cart-total');
        const subTotal = document.getElementById('sub-total');
        const itemTotals = document.getElementsByName('item-total');
        let total = 0;
        itemTotals.forEach(itemTotal => {
            total = parseFloat(total) + parseFloat(itemTotal.value);
            total = total.toFixed(2);
        });

        cartTotal.innerText = total;
        subTotal.innerText = total;
    }
</script>
@endsection