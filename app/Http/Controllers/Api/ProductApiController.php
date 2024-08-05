<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new Product();
    }

    
    /**
     * Summary of updateStatus
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
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


    /**
     * Summary of deleteMany
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
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

    public function stock(Request $request)
    {
        $product_id = $request->get('product_id');
        $size = $request->get('size');
        $color = $request->get('color');
        $stock = $this->model->getStock($product_id, $size, $color);
        return response()->json([
            'success' => 'Stock fetched successfully',
            'data' => $stock
        ]);
    }
}
