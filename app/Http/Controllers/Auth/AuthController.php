<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('pages.public.auth.login', [
            'title'=>'Login'
        ]);
    }

    public function loginHandle(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:6'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(Auth::user()->role === User::TYPE_ADMIN) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . Auth::user()->name);
            }
            else {
                return redirect()->route('home')->with('success', 'Welcome back, ' . Auth::user()->name);
            }
        }

        return redirect()->back()->with('error', 'Email or password is incorrect');
    }

    public function registerForm()
    {
        return view('pages.public.auth.register',[
            'title'=>'Register'
        ]);
    }

    public function registerHandle(Request $request)
    {
        return view('pages.public.auth.register');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form')->with('success', 'You have been logged out');
    }

}
