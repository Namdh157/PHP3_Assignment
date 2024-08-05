<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('pages.auth.login', [
            'title'=>'Login'
        ]);
    }

    public function loginHandle(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        if($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all())->with('error', 'All fields are not valid');
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->has('remember'))) {
            if(Auth::user()->role === User::ROLE[1]) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . Auth::user()->name);
            }
            else {
                return redirect()->route('public.home')->with('success', 'Welcome back, ' . Auth::user()->name);
            }
        }

        return redirect()->back()->with('error', 'Email or password is incorrect')->withInput($request->all());
    }

    public function registerForm()
    {
        return view('pages.auth.register',[
            'title'=>'Register'
        ]);
    }

    public function registerHandle(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        if($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors())->withInput($request->all())->with('error', 'Register failed');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,        
        ]);
        if(!$user) {
            return redirect()->back()->with('error', 'Register failed');
        }

        Auth::login($user);
        return redirect()->route('public.home')->with('success', "Welcome, {$user->name}");
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form')->with('success', 'You have been logged out');
    }

}
