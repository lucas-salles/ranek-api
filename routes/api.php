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
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');

    Route::group(['middleware' => ['jwtAuth']], function() {
        Route::name('users.')->group(function() {
            Route::resource('users', 'UserController');
        });

        Route::name('products.')->group(function() {
            Route::resource('products', 'ProductController');
        });

        Route::name('photos.')->prefix('photos')->group(function() {
            Route::delete('/{id}', 'ProductPhotoController@remove');
        });
    });
});