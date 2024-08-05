<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherApiController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Voucher();
    }
    
    public function updateStatus(Request $request)
    {
        $checkedIds = json_decode($request->get('checkedIds'), true);
        if(empty($checkedIds)){
            return response()->json([
                'error' => 'No product selected'
            ]);
        }
        $is_active = $request->get('is_active');
        if($is_active === null){
            return response()->json([
                'error' => 'No status selected'
            ]);
        }
        $update = $this->model->whereIn('id', $checkedIds)->update(['is_active' => $is_active]);
        if(!$update){
            return response()->json([
                'error' => 'Failed to update status'
            ]);
        }
        return response()->json([
            'success' => 'Update status success',
            'data' => $update
        ]);
    }
    public function deleteMany(Request $request)
    {
        $checkedIds = json_decode($request->get('checkedIds'), true);
        if(empty($checkedIds)){
            return response()->json([
                'error' => 'No product selected'
            ]);
        }
        $delete = $this->model->whereIn('id', $checkedIds)->delete();
        if(!$delete){
            return response()->json([
                'error' => 'Failed to delete product'
            ]);
        }
        return response()->json([
            'success' => 'Delete product success',
            'data' => $delete
        ]);
    }

    public function check(Request $request){
        $code = $request->get('voucher');
        $checkVoucher = $this->checkVoucher($code);
        if(!$checkVoucher['status']){
            return response()->json([
                'error' => $checkVoucher['message']
            ]);
        }

        return response()->json([
            'success' => 'Voucher found',
            'data' => $checkVoucher['data']
        ]);
    }

    public function checkVoucher($code){
        if(!$code){
            return [
                'status' => 0,
                'message' => 'Voucher not found'
            ];
        }
        $voucher = $this->model->where('code', $code)->where('is_active', true)->first();
        if(!$voucher){
            return [
                'status' => 0,
                'message' => 'Voucher not found'
            ];
        }
        // Check if user has used this voucher
        $user = auth()->user();
        $used = CheckVoucher::where('user_id', $user->id)->where('voucher_id', $voucher->id)->first();
        if($used){
            return [
                'status' => 0,
                'message' => 'Voucher has been used'
            ];
        }
        // Check if voucher start date, end date (Y-m-d -> timestamp to compare)
        $now = time();
        $start = strtotime($voucher->start_at);
        $end = strtotime($voucher->end_at);
        if($now < $start){
            return [
                'status' => 0,
                'message' => 'Voucher has not started yet'
            ];
        }
        if($now > $end){
            return [
                'status' => 0,
                'message' => 'Voucher has expired'
            ];
        }
        return [
            'status' => 1,
            'data' => $voucher
        ];
    }
}
