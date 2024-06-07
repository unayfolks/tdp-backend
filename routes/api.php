<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CustomerController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

/**
 * @method "PUT"
 */

Route::put('/merchant/edit/profil/{id}', [MerchantController::class, 'UpdateProfil']);
Route::post('/merchant/add/menu', [MerchantController::class, 'AddMenu']);
Route::post('/merchant/get/menu/{id}', [MerchantController::class, 'GetMenu']);
Route::put('/merchant/update/menu/{id}', [MerchantController::class, 'UpdateMenu']);
Route::post('/merchant/get/order/{id}', [MerchantController::class, 'GetOrder']);

Route::get('/customer/get/menu', [CustomerController::class, 'GetMenu'] );
Route::post('/customer/add/trx', [CustomerController::class, 'AddTrx'] );
Route::post('/customer/get/order/{id}', [CustomerController::class, 'GetOrder']);