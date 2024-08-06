<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\CartItem;
use App\Models\CheckVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillApiController extends Controller
{
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'payment_method' => 'required'
        ]);
        if ($validate->fails()) {
            foreach ($validate->errors()->all() as $error) {
                return response()->json([
                    'error' => $error
                ]);
            }
        }

        $userId = $request->user()->id;
        $email = $request->user()->email;
        $name = $request->get('name');
        $phone_number = $request->get('phone_number');
        $address = $request->get('address');
        $note = $request->get('note');
        $payment_method = $request->get('payment_method');
        $voucher = $request->get('voucher');
        $discountAmount = 0;

        // Cart items
        $cartItems = CartItem::where('user_id', $userId)
            ->with(['productVariant.product', 'productVariant.variantColor', 'productVariant.variantSize'])
            ->get();
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += ($item->productVariant->price_sale ?? 0) * $item->quantity;
        }

        // VOucher and discount
        if ($voucher) {
            $voucherApiModel = new VoucherApiController();
            $checkVoucher = $voucherApiModel->checkVoucher($voucher);
            if ($checkVoucher['status']) {
                $voucher = $checkVoucher['data'];
                $type = $voucher->type;
                $discountAmount = ($type == 'fixed') ? $voucher->value : $cartTotal * $voucher->value / 100;
                // update voucher used
                $voucher->used++;
                $voucher->save();
            }
        }

        // Create bill
        $bill = new Bill();
        $bill->customer_id = $userId;
        $bill->customer_name = $name;
        $bill->customer_phone = $phone_number;
        $bill->customer_email = $email;
        $bill->customer_address = $address;
        $bill->customer_note = $note ?? '';
        $bill->payment_method = $payment_method;
        $bill->quantity = count($cartItems);
        $bill->total_discount = $discountAmount;
        $bill->total_price = $cartTotal - $discountAmount > 0 ? $cartTotal - $discountAmount : 0;

        if ($bill->save()) {
            // Create bill detail
            foreach ($cartItems as $item) {
                $billDetail = new BillDetail();
                $billDetail->bill_id = $bill->id;
                $billDetail->product_id = $item->productVariant->product_id;
                $billDetail->product_name = $item->productVariant->product->name;
                $billDetail->product_size = $item->productVariant->variantSize->size;
                $billDetail->product_color = $item->productVariant->variantColor->color;
                $billDetail->product_image_thumbnail = $item->productVariant->product->image_thumbnail;
                $billDetail->unit_price = $item->productVariant->price_sale ?? 0;
                $billDetail->quantity = $item->quantity;
                $billDetail->save();
            }
            // create check_voucher
            // if ($voucher) {
            //     $checkVoucherModel = new CheckVoucher();
            //     $checkVoucherModel->user_id = $userId;
            //     $checkVoucherModel->voucher_id = $voucher->id;
            //     $checkVoucherModel->bill_id = $bill->id;
            //     $checkVoucherModel->save();
            // }
            // Delete cart items
            CartItem::where('user_id', $userId)->delete();
            return response()->json([
                'success' => 'Create bill success',
                'data' => $bill
            ]);
        }
        return response()->json([
            'error' => 'Failed to create bill'
        ]);
    }
}
