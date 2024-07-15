<?php

use App\Http\Controllers\Admin\ProductController;
use App\Models\Bill;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Catalogue;
use App\Models\Comment;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', function () {
    return view('pages.public.auth.login');
})->name('login.form');

Route::post('/login', function () {
    return view('pages.public.auth.login');
})->name('login.handle');

Route::get('/register', function () {
    return view('pages.public.auth.register');
})->name('register.form');

Route::post('/register', function () {
    return view('pages.public.auth.register');
})->name('register.hadle');

// admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('catalogue', Catalogue::class);
    Route::resource('brand', Brand::class);
    Route::resource('product', ProductController::class);
    Route::resource('bill', Bill::class);
    Route::resource('cart', CartItem::class);
    Route::resource('comment', Comment::class);
    Route::resource('user', User::class);
    Route::resource('voucher', Voucher::class);
});