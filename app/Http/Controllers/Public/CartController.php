<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)
            ->with(['productVariant.product', 'productVariant.variantColor', 'productVariant.variantSize'])
            ->get();

            return view('pages.public.cart.index', [
            'title' => 'Cart',
            'cartItems' => $cartItems,
            'cartTotal' => 0
        ]);
    }
}
