<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    public function count()
    {
        $count = CartItem::where('user_id', auth()->id())->count();
        return response()->json([
            'success' => 'Cart count fetched successfully',
            'data' => $count
        ]);
    }

    public function store(Request $request) {
        $color = $request->get('color');
        $size = $request->get('size');
        if($color == null || $size == null) {
            return response()->json([
                'error' => 'Color and size are required'
            ]);
        }
        
    }
    public function create(Request $request)
    {
        $validateData = $request->validate([
            'product_id' => 'required',
            'size' => 'required',
            'color' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);
        $validateData['user_id'] = auth()->id();
        $productVariant_id = ProductVariant::where('product_id', $validateData['product_id'])
            ->where('size_id', $validateData['size'])
            ->where('color_id', $validateData['color'])
            ->first();
        if(!$productVariant_id) {
            return response()->json([
                'error' => 'Product variant not found'
            ]);
        }
        $validateData['product_variant_id'] = $productVariant_id->id;
        
        $cartItem = CartItem::where('user_id', $validateData['user_id'])
            ->where('product_variant_id', $validateData['product_variant_id'])
            ->first();

        if($cartItem) {
            $cartItem->quantity += $validateData['quantity'];
            $cartItem->save();
            return response()->json([
                'success' => 'Cart item updated successfully',
                'data' => CartItem::where('user_id', $validateData['user_id'])->count()
            ]);
        }

        // Add to cart
        $cartItem = CartItem::create($validateData);
        if (!$cartItem) {
            return response()->json([
                'error' => 'Can not add to cart'
            ]);
        }
        return response()->json([
            'success' => 'Cart item added successfully',
            'data' => CartItem::where('user_id', $validateData['user_id'])->count()
        ]);
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
