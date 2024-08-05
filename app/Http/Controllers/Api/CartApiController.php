<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cartItems = $request->get('cartItems');

        if (empty($cartItems)) {
            return response()->json([
                'error' => 'Cart items can not be empty'
            ]);
        }
        // validate quantity
        foreach ($cartItems as $cartItem) {
            $cartItem['quantity'] = (int)$cartItem['quantity'];
            if ($cartItem['quantity'] < 1) {
                return response()->json([
                    'error' => 'Quantity must be greater than 0',
                    'data' => $cartItem
                ]);
            }
            if($cartItem['quantity'] > ProductVariant::find($cartItem['product_variant_id'])->stock){
                return response()->json([
                    'error' => 'Quantity must be less than or equal to product variant quantity',
                    'data' => $cartItem
                ]);
            }
        }
        // Update quantity
        foreach ($cartItems as $cartItem) {
            $update = CartItem::where('id', $cartItem['cart_id'])->update([
                'quantity' => $cartItem['quantity']
            ]);
            if (!$update) {
                return response()->json([
                    'error' => 'Can not update cart item',
                    'data' => $cartItem
                ]);
            }
            // Update stock
            $productVariant = ProductVariant::find($cartItem['product_variant_id']);
            $productVariant->stock -= $cartItem['quantity'];
        }
        return response()->json([
            'success' => 'Cart updated successfully',
            'data' => $cartItems
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = CartItem::where('id', $id)->delete();
        if (!$delete) {
            return response()->json([
                'error' => 'Can not delete cart item',
                'data' => $id
            ]);
        }
        return response()->json([
            'success' => 'Cart deleted successfully'
        ]);
    }
}
