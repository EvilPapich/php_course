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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'login'], function () {
  Route::post('/', 'UserController@signIn');
});

Route::middleware('app.auth')->group(function () {
  Route::group(['prefix' => 'post'], function () {
    Route::get('/recent', 'PostController@getRecentPosts');
  });
});