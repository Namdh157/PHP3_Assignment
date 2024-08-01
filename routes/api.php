<?php

use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\api\CatalogueApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth.admin')->group(function () {
    Route::patch('product/update-status', [ProductApiController::class, 'updateStatus'])
        ->name('api.product.updateStatus');
    Route::delete('product/delete-many', [ProductApiController::class, 'deleteMany'])
        ->name('api.product.deleteMany');

    //catalogues
    Route::patch('catalogue/update-status', [CatalogueApiController::class, 'updateStatus'])
        ->name('api.catalogue.updateStatus');
    Route::delete('catalogue/delete-many', [CatalogueApiController::class, 'deleteMany'])
        ->name('api.catalogue.deleteMany');
    
    //brands
    Route::patch('brand/update-status', [BrandApiController::class, 'updateStatus'])
        ->name('api.brand.updateStatus');
    Route::delete('brand/delete-many', [BrandApiController::class, 'deleteMany'])
        ->name('api.brand.deleteMany');

    //users
    Route::patch('user/update-status', [UserApiController::class, 'updateStatus'])
        ->name('api.user.updateStatus');
    Route::delete('user/delete-many', [UserApiController::class, 'deleteMany'])
        ->name('api.user.deleteMany');

});
