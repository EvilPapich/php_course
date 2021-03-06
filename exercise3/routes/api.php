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

Route::group(['prefix' => 'user'], function () {
  Route::post('/login', 'UserController@signIn');
});

Route::middleware('app.auth')->group(function () {
  Route::group(['prefix' => 'user'], function () {
    Route::get('/get', 'UserController@getUser');
  });

  Route::group(['prefix' => 'author'], function () {
    Route::get('/get', 'AuthorController@getAuthor');
  });

  Route::group(['prefix' => 'post'], function () {
    Route::get('/get/posts/recent', 'PostController@getRecentPosts');
    Route::post('/get/posts/recent', 'PostController@getRecentPostsWithParams');
    Route::get('/get/drafts', 'PostController@getDrafts');
    Route::post('/write/draft', 'PostController@writeDraft');
    Route::post('/write/post', 'PostController@writePost');
    Route::post('/edit/draft', 'PostController@editDraft');
    Route::post('/publish/draft', 'PostController@publishDraft');
    Route::post('/delete/draft', 'PostController@deleteDraft');
    Route::post('/rate/post', 'PostController@ratePost');
    Route::post('/write/post/comment', 'PostController@writeComment');
    Route::post('/rate/post/comment', 'PostController@rateComment');
    Route::post('/edit/post/comment', 'PostController@editComment');
    Route::post('/delete/post/comment', 'PostController@deleteComment');
  });
});