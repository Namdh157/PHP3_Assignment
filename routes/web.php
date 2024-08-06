<?php


use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\MailController;
use App\Http\Controllers\Public\PaymentController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\ProfileController;
use Illuminate\Support\Facades\Route;


// Route admin
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');
    Route::resource('catalogue', CatalogueController::class);
    Route::resource('brand', BrandController::class);
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
    Route::get('/cart', [CartController::class,'index'])->name('public.cart');
    Route::get('/checkout', [CartController::class,'checkout'])->name('public.checkout');
});

// Route public
Route::name('public.')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/product/detail/{slug}', [PublicProductController::class, 'detail'])->name('product.detail');
    Route::get('/allProduct', [PublicProductController::class, 'allProduct'])->name('allProduct');
});

Route::get('/checkout/handle/{id}', [PaymentController::class, 'checkout'])->name('public.checkout.handle');
Route::get('/checkout/result', [PaymentController::class, 'result'])->name('public.checkout.result');