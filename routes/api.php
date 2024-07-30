<?php

use App\Http\Controllers\api\CatalogueApiController;
use App\Http\Controllers\Api\ProductApiController;
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
});
