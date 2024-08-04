<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogueApiController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new Catalogue();
    }
    public function updateStatus(Request $request) {
        $checkedIds = json_decode($request->get('checkedIds'), true);
        if(empty($checkedIds)){
            return response()->json([
                'error' => 'No catalogue selected'
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
    public function deleteMany(Request $request) {
        $checkedIds = json_decode($request->get('checkedIds'), true);
        if(empty($checkedIds)){
            return response()->json([
                'error' => 'No catalogue selected'
            ]);
        }
        $delete = $this->model->whereIn('id', $checkedIds)->delete();
        if(!$delete){
            return response()->json([
                'error' => 'Failed to delete catalogue'
            ]);
        }
        return response()->json([
            'success' => 'Delete catalogue success',
            'data' => $delete
        ]);
    }
    public function showMore(Request $request) {
        $offset = $request->get('offset');
        $catalogues = Catalogue::withCount('products')
            ->has('products')
            ->offset($offset)
            ->take(5)
            ->get();
        if($catalogues->isEmpty()){
            return response()->json([
                'error' => 'No more catalogue'
            ]);
        }
        return response()->json([
            'success' => 'Get more catalogue success',
            'data' => $catalogues
        ]);
    }
}
