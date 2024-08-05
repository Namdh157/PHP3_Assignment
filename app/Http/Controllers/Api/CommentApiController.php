<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new Comment();
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

    public function create(Request $request)
    {
        $validateData = $request->validate([
            'product_id' => 'required',
            'content' => 'required',
        ]);
        $validateData['user_id'] = auth()->id();

        $create = $this->model->create($validateData);
        if(!$create){
            return response()->json([
                'error' => 'Failed to create comment'
            ]);
        }
        return response()->json([
            'success' => 'Create comment success',
            'data' => $create
        ]);
    }

}
