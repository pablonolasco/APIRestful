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
Route::resource('buyers.transactions','Buyer\BuyerTransactionController',['only'=>['index']]);
Route::resource('buyers.products','Buyer\BuyerProductController',['only'=>['index']]);
Route::resource('buyers.sellers','Buyer\BuyerSellerController',['only'=>['index']]);
Route::resource('buyers.categories','Buyer\BuyerCategoryController',['only'=>['index']]);
/**
 * Categories
 */
Route::resource('categories','Categories\CategoryController',['except'=>['create','edit']]);
Route::resource('categories.products','Categories\CategoryProductController',['only'=>['index']]);
Route::resource('categories.sellers','Categories\CategorySellerController',['only'=>['index']]);
Route::resource('categories.transactions','Categories\CategoryTransactionController',['only'=>['index']]);
Route::resource('categories.buyers','Categories\CategoryBuyerController',['only'=>['index']]);
/**
 * Products
 */
Route::resource('products','Products\ProductController',['only'=>['index','show']]);
/**
 * Transactions
 */
Route::resource('transactions','Transactions\TransactionController',['only'=>['index','show']]);
Route::resource('transactions.categories','Transactions\TransactionsCategoryController',['only'=>['index']]);
Route::resource('transactions.sellers','Transactions\TransactionsSellerController',['only'=>['index']]);
/**
 * Sellers
 */
Route::resource('sellers','Sellers\SellerController',['only'=>['index','show']]);
Route::resource('sellers.transactions','Sellers\SellerTransactionController',['only'=>['index']]);
Route::resource('sellers.categories','Sellers\SellerCategoryController',['only'=>['index']]);
Route::resource('sellers.buyers','Sellers\SellerBuyerController',['only'=>['index']]);
Route::resource('sellers.products','Sellers\SellerProductController',['except'=>['create','show','edit']]);

/**
 * Users
 */
Route::resource('users','Users\UserController',['except'=>['create','edit']]);