<?php

use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\ProductController;
use App\Models\Bill;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Catalogue;
use App\Models\Comment;
use App\Models\User;
use App\Models\Voucher;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


// admin
Route::prefix('admin')->middleware('auth.middleware')->name('admin.')->group(function () {
    Route::resource('catalogue', Catalogue::class);
    Route::resource('brand', Brand::class);
    Route::resource('product', ProductController::class);
    Route::resource('bill', Bill::class);
    Route::resource('cart', CartItem::class);
    Route::resource('comment', Comment::class);
    Route::resource('user', User::class);
    Route::resource('voucher', Voucher::class);

    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');
});

// Auth
Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'loginForm')->name('login.form');
    Route::post('/login', 'loginHandle')->name('login.handle');
    Route::get('/register', 'registerForm')->name('register.form');
    Route::post('/register', 'registerHandle')->name('register.handle');
    Route::get('/logout', 'logout')->name('logout');
});

// Public
Route::get('/', function () {
    return redirect('login');
})->name('home');