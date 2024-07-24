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
use App\Http\Controllers\Public\ProfileController;
use Illuminate\Support\Facades\Route;


// Route admin
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
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

// Route không được phép truy cập khi đã đăng nhập
Route::middleware('auth.notlogged')->controller(AuthController::class)->group(function(){
    Route::get('/login', 'loginForm')->name('login.form');
    Route::post('/login', 'loginHandle')->name('login.handle');
    Route::get('/register', 'registerForm')->name('register.form');
    Route::post('/register', 'registerHandle')->name('register.handle');
});

// Route cần đăng nhập để thực hiện các chức năng
Route::middleware('auth.logged')->group(function(){
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

// Route public
Route::get('/', function () {
    return view('pages.public.home.index', [
        'title' => 'Home'
    ]);
})->name('home');

Route::get('/product/{slug}', function () {
    return view('pages.public.productDetail.index');
})->name('public.product.detail');
