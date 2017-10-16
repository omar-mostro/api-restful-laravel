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

 
// Buyers
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['show', 'index']]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only'=>['index']]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only'=>['index']]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only'=>['index']]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only'=>['index']]);

//Categories
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

//Prducts
Route::resource('products', 'Product\ProductController', ['only' => ['show', 'index']]);

//Transactions
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['show', 'index']]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only'=>['index']]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only'=>['index']]);

// Sellers
Route::resource('sellers', 'Seller\SellerController', ['only' => ['show', 'index']]);

//Users
Route::resource('users', 'User\UserController',['except' => ['create', 'edit']]);


