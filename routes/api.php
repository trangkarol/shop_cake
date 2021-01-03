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
Route::group(['namespace' => 'Api'], function () {
    Route::post('login', 'Auth\UserController@login')->name('login');
    Route::post('register', 'Auth\UserController@store')->name('register');
     
    // Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'Auth\UserController@show');
    // });
});
