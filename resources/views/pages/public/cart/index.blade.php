@extends('layouts.public')

@section('content')

<main class="main">
    <div class="page-content mt-5">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <!-- Left -->
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
                                <tr class="cart-item" data-variant-id="{{$item->productVariant->id}}">
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
                                            </h3>
                                        </div>
                                    </td>
                                    <td class="price-col">
                                        <div class="d-flex align-items-center">
                                            <input type="number" name="price" class="form-control m-0 p-0 border-0 text-end bg-transparent" value="{{$item->productVariant->price_sale ?? 0}}" style="width: 80px" readonly>$
                                        </div>
                                    </td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity mx-auto">
                                            <input type="number" name="quantity" class="form-control text-center" value="{{$item->quantity}}" min="1" step="1" data-decimals="0" onchange="onChangeQuantity(this)">
                                        </div>
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
                        </table>
                    </div>

                    <!-- Right -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3>

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td><span id="sub-total">{{$cartTotal}}</span>$</td>
                                    </tr>
                                    <tr class="summary-shipping">
                                        <td>Shipping:</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="free-shipping" name="shipping" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="free-shipping">Free Shipping:</label>
                                            </div>
                                        </td>
                                        <td>0.00$</td>
                                    </tr>

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td><span id="cart-total">{{$cartTotal}}</span>$</td>
                                    </tr>
                                </tbody>
                            </table>

                            <a href="{{ route('public.checkout')}}" onclick="toCheckout(event)" class="btn btn-outline-primary-2 btn-order btn-block w-100">PROCEED TO CHECKOUT</a>
                        </div>

                        <a href="{{ route('public.allProduct')}}" class="btn btn-outline-dark-2 btn-block mb-3 w-100"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('script')
<!-- Config script -->
<script>
    const routeDelete = "{{ route('api.cart.destroy', ':cartId') }}";
    const routeUpdateCart = "{{ route('api.cart.update', ':cartId') }}";
</script>
<!-- Handler script -->
<script>
    function onChangeQuantity(input) {
        onUpdateItemTotal(input.closest('tr'));
        onUpdateCartTotal();
    }

    function onRemoveCartItem(button) {
        if (!confirm('Are you sure to remove this item?')) {
            return;
        }
        const cartId = button.getAttribute('data-cart-id');
        url = routeDelete.replace(':cartId', cartId);

        sendRequest(url, {}, 'DELETE', (data) => {
            button.closest('tr').remove();
            onUpdateCartTotal();
        });
    }

    function onUpdateItemTotal(tr) {
        const price = tr.querySelector('input[name="price"]').value;
        const quantity = tr.querySelector('input[name="quantity"]').value;
        const itemTotal = tr.querySelector('input[name="item-total"]');
        itemTotal.value = (price * quantity).toFixed(2);
    }

    function onUpdateCartTotal() {
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

    function toCheckout(e) {
        e.preventDefault();
        if (confirm('Are you sure to checkout?')) {
            const callBackSuccess = () => {
                const url = e.target.href;
                window.location.href = url;
            }
            const callBackError = () => {
                console.log('Update cart error');
            }
            updateCartItem(callBackSuccess, callBackError);
        }
    }

    function updateCartItem(callBackSuccess, callBackError) {
        const cartItems = document.querySelectorAll('tr.cart-item');
        const payload = [];
        cartItems.forEach(item => {
            const cartId = item.querySelector('button').getAttribute('data-cart-id');
            const quantity = item.querySelector('input[name="quantity"]').value;
            payload.push({
                cart_id: cartId,
                product_variant_id: item.getAttribute('data-variant-id'),
                quantity: quantity
            });
        });

        sendRequest(routeUpdateCart, {
            cartItems: payload
        }, 'PUT', callBackSuccess, callBackError);
    }
</script>
@endsection