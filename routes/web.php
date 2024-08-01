<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\ProfileController;
use Illuminate\Support\Facades\Route;


// Route admin
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');
    Route::resource('catalogue', CatalogueController::class);
    Route::resource('product', ProductController::class);
    Route::resource('user', UserController::class);
    Route::resource('comment', CommentController::class);
    Route::resource('bill', BillController::class);
    Route::resource('voucher', VoucherController::class);
    Route::resource('banner', BannerController::class);
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

Route::get('/product/{slug}', function () {
    return view('pages.public.productDetail.index');
})->name('public.product.detail');
