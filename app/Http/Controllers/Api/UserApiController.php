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
    public function updateRole() {
        $id = request()->get('id');
        $role = request()->get('role');
        $user = $this->model->find($id);
        if(!$user){
            return response()->json([
                'error' => 'User not found'
            ]);
        }
        $user->role = $role;
        $user->save();
        return response()->json([
            'success' => 'Update role success',
            'data' => $user
        ]);
    }
}
