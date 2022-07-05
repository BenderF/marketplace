<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('signup', [ApiAuthController::class, 'sign_up']);
Route::post('login', [ApiAuthController::class, 'login']);

Route::group(['prefix' => '/shop', 'middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::post('create-freeshop', [ShopController::class, 'createFreeShop']);
    Route::get('list', [ShopController::class, 'list']);
});

Route::group(['prefix' => '/product', 'middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::post('insert-product', [ProductController::class, 'insertProductIntoShop']);
});

