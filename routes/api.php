<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function() {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('refresh', 'AuthController@refresh')->name('refresh');

    Route::get('/search', 'ProductSearchController@index')->name('search');
    Route::get('/search/{product_id}', 'ProductSearchController@show')->name('search_single');

    Route::post('users', 'UserController@store')->name('users.store');

    Route::group(['middleware' => ['jwtAuth']], function() {
        Route::prefix('users')->name('users.')->group(function() {
            Route::get('/', 'UserController@index')->name('index');
            Route::get('/{user}', 'UserController@show')->name('show');
            Route::match(['put', 'patch'], '/{user}', 'UserController@update')->name('update');
            Route::delete('/{user}', 'UserController@destroy')->name('destroy');
        });

        Route::name('products.')->group(function() {
            Route::resource('products', 'ProductController');
        });

        Route::name('photos.')->prefix('photos')->group(function() {
            Route::delete('/{id}', 'ProductPhotoController@remove')->name('remove');
        });

        Route::prefix('transactions')->name('transactions.')->group(function() {
            Route::get('/', 'TransactionController@index')->name('index');
            Route::post('/', 'TransactionController@store')->name('store');
            Route::get('/{transaction}', 'TransactionController@show')->name('show');
        });
    });
});
