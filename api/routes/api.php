<?php

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

// ---- Logged out user routes
Route::group(["namespace" => "Api"], function() {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@signup')->name('signup');
});

// ---- Auth user routes
Route::middleware('auth:api')->group(function () {

    Route::group(["namespace" => "Api"], function() {
        Route::get('user', 'AuthController@checkAuth')->name('check-auth');
        Route::post('logout', 'AuthController@logout')->name('logout');

        Route::apiResource('conversations', 'ConversationController')->name('conversation');
        Route::apiResource('messages', 'MessageController')->name('message');
        Route::apiResource('users', 'UserController')->name('user');
    });

});