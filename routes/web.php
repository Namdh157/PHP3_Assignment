<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Bill;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Comment;
use App\Models\Voucher;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\ProfileController;
use Illuminate\Support\Facades\Route;


// Route admin
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('catalogue', CatalogueController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('product', ProductController::class);
    Route::resource('bill', Bill::class);
    Route::resource('cart', CartItem::class);
    Route::resource('comment', Comment::class);
    Route::resource('user', UserController::class);
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
    Route::get('/profile', [ProfileController::class, 'index'])->name('public.profile');
});

// Route public
Route::get('/', function () {
    return view('pages.public.home.index', [
        'title' => 'Home'
    ]);
})->name('public.home');

Route::get('/product/detail/{slug}', [PublicProductController::class, 'detail'])->name('public.product.detail');

Route::get('/cart', function () {
    return view('pages.public.cart.index');
})->name('cart');

Route::get('/allproduct', function () {
    return view('pages.public.allProduct.index');
})->name('allproduct');

Route::get('/checkout', function () {
    return view('pages.public.checkout.index');
})->name('checkout');