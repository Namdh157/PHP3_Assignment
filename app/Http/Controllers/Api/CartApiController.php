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
                'data' => $cartItem
            ]);
        }

        $cartItem = CartItem::create($validateData);
        return response()->json([
            'success' => 'Cart item created successfully',
            'data' => $cartItem
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
