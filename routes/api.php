<?php

use Illuminate\Http\Request;

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
/**
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::resource('buyers','Buyer\BuyerController',['only'=>['index','show']]);

/**
 * Categories
 */
Route::resource('categories','Categories\CategoryController',['except'=>['create','edit']]);
/**
 * Products
 */
Route::resource('Products','Products\ProductController',['only'=>['index','show']]);
/**
 * Transactions
 */
Route::resource('Transactions','Transactions\TransactionController',['only'=>['index','show']]);
/**
 * Sellers
 */
Route::resource('sellers','Sellers\SellerController',['only'=>['index','show']]);
/**
 * Users
 */
Route::resource('users','Users\UserController',['except'=>'create','edit']);