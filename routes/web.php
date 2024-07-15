<?php

use App\Http\Controllers\Auth\AuthController;
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


// Route::get('/login', function () {
//     return view('pages.public.auth.login');
// })->name('login.form');

// Route::post('/login', function () {
//     return view('pages.public.auth.login');
// })->name('login.handle');

// Route::get('/register', function () {
//     return view('pages.public.auth.register');
// })->name('register.form');

// Route::post('/register', function () {
//     return view('pages.public.auth.register');
// })->name('register.handle');

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
    return view('pages.public.home');
})->name('home');