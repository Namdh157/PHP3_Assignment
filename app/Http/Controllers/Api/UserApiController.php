<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }
    public function deleteMany(Request $request)
    {
        $checkedIds = json_decode($request->get('checkedIds'), true);
        if (empty($checkedIds)) {
            return response()->json([
                'error' => 'No user selected'
            ]);
        }
        $delete = $this->model->whereIn('id', $checkedIds)->delete();
        if (!$delete) {
            return response()->json([
                'error' => 'Failed to delete user'
            ]);
        }
        return response()->json([
            'success' => 'Delete user success',
            'data' => $delete
        ]);
    }
    public function updateRole()
    {
        $id = request()->get('id');
        $role = request()->get('role');
        $user = $this->model->find($id);
        if (!$user) {
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
    public function updateInfor(Request $request)
    {
        // Validate
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone_number' => 'required',
            'address' => 'required',
        ]);
        if ($validate->fails()) {
            foreach ($validate->errors()->all() as $error) {
                return response()->json([
                    'error' => $error
                ]);
            }
        }

        $user = User::find(Auth::user()->id);
        if (!$user) {
            return response()->json([
                'error' => 'User not found'
            ]);
        }
        $update = $user->update($request->all());
        if (!$update) {
            return response()->json([
                'error' => 'Failed to update user'
            ]);
        }
        return response()->json([
            'success' => 'Update user success',
            'data' => $update
        ]);
    }

    public function updateAvatar(Request $request)
    {
        // Validate
        $validate = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validate->fails()) {
            foreach ($validate->errors()->all() as $error) {
                return response()->json([
                    'error' => $error
                ]);
            }
        }

        $user = User::find(Auth::user()->id);
        if (!$user) {
            return response()->json([
                'error' => 'User not found'
            ]);
        }
        $file = $request->file('avatar');
        $imagePath = $this->uploadImage($file);
        if($imagePath == false){
            return response()->json([
                'error' => 'Failed to upload image'
            ]);
        }
        $user->image = $imagePath;
        $user->save();
        return response()->json([
            'success' => 'Update avatar success',
            'data' => $user
        ]);
    }
    public function changePassword(Request $request)
    {
        // Validate
        $validate = Validator::make($request->all(), [
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validate->fails()) {
            foreach ($validate->errors()->all() as $error) {
                return response()->json([
                    'error' => $error
                ]);
            }
        }

        $user = User::find(Auth::user()->id);
        if (!$user) {
            return response()->json([
                'error' => 'User not found'
            ]);
        }
        if (!password_verify($request->current_password, $user->password)) {
            return response()->json([
                'error' => 'Old password is incorrect'
            ]);
        }
        $user->password = bcrypt($request->new_password);
        $user->save();
        return response()->json([
            'success' => 'Change password success',
            'data' => $user
        ]);
    }
}
