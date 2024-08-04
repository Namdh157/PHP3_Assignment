<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandApiController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Brand();
    }
    public function updateStatus(Request $request)
    {
        $checkedIds = json_decode($request->get('checkedIds'), true);
        if (empty($checkedIds)) {
            return response()->json([
                'error' => 'No brand selected'
            ]);
        }
        $is_active = $request->get('is_active');
        if ($is_active === null) {
            return response()->json([
                'error' => 'No status selected'
            ]);
        }
        $update = $this->model->whereIn('id', $checkedIds)->update(['is_active' => $is_active]);
        if (!$update) {
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
        if (empty($checkedIds)) {
            return response()->json([
                'error' => 'No brand selected'
            ]);
        }
        $delete = $this->model->whereIn('id', $checkedIds)->delete();
        if (!$delete) {
            return response()->json([
                'error' => 'Failed to delete brand'
            ]);
        }
        return response()->json([
            'success' => 'Delete brand success',
            'data' => $delete
        ]);
    }
    public function showMore(Request $request)
    {
        $offset = $request->get('offset');
        $brands = $this->model->withCount('products')
            ->has('products')
            ->offset($offset)
            ->take(5)
            ->get();

        if ($brands->isEmpty()) {
            return response()->json([
                'error' => 'No more catalogue'
            ]);
        }
        return response()->json([
            'success' => 'Get more catalogue success',
            'data' => $brands
        ]);
    }
}
