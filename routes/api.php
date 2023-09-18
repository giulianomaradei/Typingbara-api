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
Route::group(['prefix' => 'user'], function() {
    Route::get('/leaderboard'      , 'UserController@getLeaderboard');
});

Route::group(['middleware' => 'auth:sanctum'], function() { 

    Route::group(['prefix' => 'user'], function() {
        Route::get('/'                 , 'UserController@getUser');
        Route::get('/{id}'             , 'UserController@getById');
        Route::post('/result/{id}'     , 'UserController@addTestResult');
    });

});

Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
});

Route::group(['prefix' => 'game'], function() {
    Route::post('/', 'GameController@create');
    Route::post('/connect/{id}', 'GameController@connectGame');
});

