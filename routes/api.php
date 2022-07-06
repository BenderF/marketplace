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
    Route::post('create-shop', [ShopController::class, 'createShop']);
    Route::get('list-shop', [ShopController::class, 'listUserShop']);
});

Route::group(['prefix' => '/product', 'middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::post('insert-product', [ProductController::class, 'insertProductIntoShop']);
    Route::post('delete-product', [ProductController::class, 'deleteProduct']);
    Route::post('list-shop-products', [ProductController::class, 'listShopProducts']);
});

Route::group(['prefix' => '/admin', 'middleware' => ['auth:sanctum', 'ability:admin']], function () {
    Route::get('list-all-shops', [ShopController::class, 'listAllShops']);
});

