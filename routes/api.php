<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:sanctum']], function() { 
    
    Route::prefix('stores')->group(function () {
        Route::get('/','StoreController@index');
        Route::get('/byUser','StoreController@byUser');
        Route::get('/byUser/all','StoreController@byUserAll');
        Route::get('/{id}','StoreController@show');
        Route::post('/','StoreController@store');
        Route::post('/filter','StoreController@filter');
        Route::post('/{id}','StoreController@update');
        Route::post('/delete/{id}','StoreController@destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/','ProductController@index');
        Route::get('/byUser','ProductController@byUser');
        Route::get('/byStore/{store_id}','ProductController@byStore');
        Route::get('/byCategory/{category_id}','ProductController@byCategory');
        Route::get('/byStoreUser','ProductController@byStoreUser');
        Route::get('/{id}','ProductController@show');
        Route::get('/relatedProducts/{id}','ProductController@relatedProducts');
        Route::post('/','ProductController@store');
        Route::post('/filter','ProductController@filter');
        Route::post('/{id}','ProductController@update');
        Route::post('/delete/{id}','ProductController@destroy');
    });

    Route::prefix('followers')->group(function () {
        Route::get('/check/{user_id}/{store_id}','FollowerController@check');
        Route::post('/','FollowerController@store');
        Route::post('/delete/{user_id}/{store_id}','FollowerController@destroy');
    });

    Route::prefix('tags')->group(function () {
        Route::get('/','TagController@index');
        Route::get('/all','TagController@all');
        Route::get('/byStore/{store_id}','TagController@byStore');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/','CategoryController@index');
        Route::get('/byStore/{store_id}/all','CategoryController@byStoreAll');
        Route::get('/byStore/{store_id}','CategoryController@byStore');
        Route::get('/{id}','CategoryController@show');
        Route::get('/all','CategoryController@all');
        Route::post('/','CategoryController@store');
        Route::post('/{id}','CategoryController@update');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/byStore','OrderController@storeByOrders');
        Route::get('/{store_id}','OrderController@index');
        Route::post('/','OrderController@store');
        Route::post('/generateTokenLink','OrderController@generateTokenLink');
    });
});

Route::prefix('orders')->group(function () {
    Route::get('/{token}/token','OrderController@showByToken');
});