<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends CommonController
{
    private $cartItems;
    public function index()
    {
        $this->cartItems = CartItem::where('user_id', Auth::user()->id)
            ->with(['productVariant.product', 'productVariant.variantColor', 'productVariant.variantSize'])
            ->get();

        return view('pages.public.cart.index', [
            'title' => 'Cart',
            'cartItems' => $this->cartItems,
            'cartTotal' => 0,
            ...$this->dataHeader

        ]);
    }
    public function checkout()
    {
        $this->cartItems = CartItem::where('user_id', Auth::user()->id)
            ->with(['productVariant.product', 'productVariant.variantColor', 'productVariant.variantSize'])
            ->get();
        if ($this->cartItems->isEmpty()) {
            return redirect()->route('public.cart')->with('error', 'Your cart is empty');
        }
        $paymentMethods = Bill::PAYMENT_METHOD;

        return view('pages.public.cart.checkout', [
            'title' => 'Checkout',
            'cartItems' => $this->cartItems,
            'cartTotal' => 0,
            'paymentMethods' => $paymentMethods,
            ...$this->dataHeader
        ]);
    }
}
