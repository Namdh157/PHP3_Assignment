<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new User();
    }
    public function deleteMany(Request $request) {
        $checkedIds = json_decode($request->get('checkedIds'), true);
        if(empty($checkedIds)){
            return response()->json([
                'error' => 'No user selected'
            ]);
        }
        $delete = $this->model->whereIn('id', $checkedIds)->delete();
        if(!$delete){
            return response()->json([
                'error' => 'Failed to delete user'
            ]);
        }
        return response()->json([
            'success' => 'Delete user success',
            'data' => $delete
        ]);
    }
}
