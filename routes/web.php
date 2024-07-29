<?php

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



Route::post('/register', function () {
    return view('pages.public.auth.register');
})->name('register.hadle');

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
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'loginForm')->name('login.form');
    Route::post('/login', 'loginHandle')->name('login.handle');
    Route::get('/register', 'registerForm')->name('register.form');
    Route::post('/register', 'registerHandle')->name('register.handle');
    Route::get('/logout', 'logout')->name('logout');
});

Route::prefix('admin')->middleware('auth.middleware')->group(function () {
    Route::get('/', function () {
        return view('pages.admin.dashboard.index');
    })->name('admin.dashboard');
});

Route::get('/', function () {
    return view('pages.public.home.index');
})->name('home');

Route::get('/detail', function () {
    return view('pages.public.productDetail.index');
})->name('detail');

Route::get('/cart', function () {
    return view('pages.public.cart.index');
})->name('cart');

Route::get('/allproduct', function () {
    return view('pages.public.allProduct.index');
})->name('allproduct');

Route::get('/checkout', function () {
    return view('pages.public.checkout.index');
})->name('checkout');
