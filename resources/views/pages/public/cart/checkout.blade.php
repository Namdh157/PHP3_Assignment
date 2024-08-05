@extends('layouts.public')
@section('content')

<style>
    form {
        width: 100%;
    }
</style>

<main class="main">
    <div class="page-content mt-5">
        <div class="checkout">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="checkout-title">Billing Details</h2>
                        <div class="row">
                            <!-- Name -->
                            <div class="col-sm-6">
                                <label>Name *</label>
                                <input type="text" name="name" class="form-control" value="{{$user->name}}">
                            </div>
                            <!-- Phone -->
                            <div class="col-sm-6">
                                <label>Phone *</label>
                                <input type="text" name="phone_number" class="form-control" value="{{$user->phone_number}}">
                            </div>
                        </div>
                        <!-- Address -->
                        <div class="row">
                            <label>Address *</label>
                            <input type="text" name="address" class="form-control" placeholder="House number, Street name,..." value="{{$user->address}}">
                        </div>
                        <!-- Note -->
                        <div class="row">
                            <label>Order notes (optional)</label>
                            <textarea class="form-control" name="note" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                        </div>
                        <!-- Voucher -->
                        <div class="row">
                            <label>Voucher</label>
                            <form class="input-group px-0" onsubmit="checkVoucher(event)">
                                <input type="text" class="form-control mb-0" name="voucher">
                                <button type="submit" class="input-group-text">Check and apply</button>
                            </form>
                        </div>
                    </div>

                    <aside class="col-lg-3">
                        <div class="summary">
                            <h3 class="summary-title">Your Order</h3>

                            <table class="table table-summary">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($cartItems as $item)
                                    @php
                                    $cartTotal += ($item->productVariant->price_sale ?? 0) * $item->quantity;
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{route('public.product.detail',$item->productVariant->product->slug)}}">
                                                {{$item->productVariant->product->name}}
                                                <p class="mt-1 fs-6">{{$item->productVariant->variantColor->color . ' - ' .$item->productVariant->variantSize->size}}</p>
                                            </a>
                                        </td>
                                        <td>
                                            {{($item->productVariant->price_sale ?? 0) * $item->quantity}}$
                                        </td>
                                    </tr>
                                    @endforeach

                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>{{$cartTotal}}$</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping:</td>
                                        <td>Free shipping</td>
                                    </tr>
                                    <tr>
                                        <td>Voucher discount:</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input type="number" name="voucher_discount" class="form-control m-0 p-0 border-0 text-end bg-transparent" value="0" style="width: 80px" readonly>$
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input type="number" name="total" class="form-control m-0 p-0 border-0 text-end bg-transparent" value="{{$cartTotal}}" style="width: 80px" readonly>$
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="accordion-summary ms-2" id="accordion-payment">
                                <!-- Payment Method -->
                                <div class="accordion-summary" id="accordion-payment">
                                    @foreach ($paymentMethods as $key => $method)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method_{{$key}}" value="{{$key}}">
                                        <label class="form-check-label" for="payment_method_{{$key}}">
                                            {{$method}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary-2 btn-order btn-block" onclick="createBill()">
                                <span class="btn-text">Place Order</span>
                                <span class="btn-hover-text">Proceed to Checkout</span>
                            </button>
                        </div>
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
    const routeCreateBill = "{{route('api.bill.create')}}";
    const routeCheckVoucher = "{{route('api.voucher.check')}}";
    const routePayment = "{{route('public.checkout.handle', ':id')}}";
    const totalAmount = "{{$cartTotal}}";
    console.log(routePayment);
    
</script>
<!-- Handler script -->
<script>
    function onApplyVoucher(data) {
        const voucherDiscountElement = document.querySelector('input[name="voucher_discount"]');
        const totalElement = document.querySelector('input[name="total"]');
        const type = data.type;
        if (type == 'fixed') {
            let value = data.value;
            voucherDiscountElement.value = value;
            let total = (totalAmount - value).toFixed(2);
            totalElement.value = total < 0 ? 0 : total;
        } else if (type == 'percent') {
            let value = totalAmount * data.value / 100;
            voucherDiscountElement.value = value;
            let total = (totalAmount - value).toFixed(2);
            totalElement.value = total < 0 ? 0 : total;
        }
    }

    function checkVoucher(e) {
        e.preventDefault();
        const voucher = e.target.querySelector('input[name="voucher"]').value;
        const callBackSuccess = function(data) {
            onApplyVoucher(data);
            ToastCustom('Voucher apply success', 'success');
        }
        const callBackError = () => {
            console.log('error');
        }
        sendRequest(routeCheckVoucher, {
            voucher
        }, 'POST', callBackSuccess, callBackError);
    }

    function createBill() {
        const payload = {
            name: document.querySelector('input[name="name"]').value,
            phone_number: document.querySelector('input[name="phone_number"]').value,
            address: document.querySelector('input[name="address"]').value,
            note: document.querySelector('textarea[name="note"]').value,
            payment_method: document.querySelector('input[name="payment_method"]:checked')?.value,
            voucher: document.querySelector('input[name="voucher"]').value,
        };
        const callBackSuccess = (data) => {
            ToastCustom('Order success', 'success');
            if(payload.payment_method == 'cod'){
                window.location.href = "{{route('public.cart')}}";
                return;
            }
            window.location.href = routePayment.replace(':id', data.id);
        }
        const callBackError = () => {
            console.log('error');
        }
        sendRequest(routeCreateBill, payload, 'POST', callBackSuccess, callBackError);
    }


</script>
@endsection