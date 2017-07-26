<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

// ユーザ登録
Route::get('signup', 'Auth\AuthController@getRegister')->name('signup.get');
Route::post('signup', 'Auth\AuthController@postRegister')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\AuthController@getLogin')->name('login.get');
Route::post('login', 'Auth\AuthController@postLogin')->name('login.post');
Route::get('logout', 'Auth\AuthController@getLogout')->name('logout.get');

// ランキング
Route::get('ranking/want', 'RankingController@want')->name('ranking.want');
Route::get('ranking/read', 'RankingController@read')->name('ranking.read');

//ユーザー認証
Route::group(['middleware' => 'auth'], function () {
    Route::resource('items', 'ItemsController', ['only' => ['create', 'show']]);
    Route::post('want', 'ItemUserController@want')->name('item_user.want');
    Route::delete('want', 'ItemUserController@dont_want')->name('item_user.dont_want');
    Route::resource('users', 'UsersController', ['only' => ['show']]);
    
    Route::post('read', 'ItemUserController@read')->name('item_user.read');
    Route::delete('read', 'ItemUserController@dont_read')->name('item_user.dont_read');
    
    //フォロー
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::group(['prefix' => 'users/{id}'], function () { 
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        Route::get('itemlists', 'UsersController@itemlists')->name('users.itemlists');
    });
    
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    
    Route::post('reviews/{id}', 'ReviewsController@store')->name('reviews.store');
    //Route::resource('reviews', 'reviewsController', ['only' => 'destroy']);
    Route::delete('reviews/{id}', 'ReviewsController@destroy')->name('reviews.destroy');
});