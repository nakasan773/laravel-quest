<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'UsersController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//追記（ログイン認証を通ったユーザのみがその内部のルーティングにアクセスできる

//フォロー機能
Route::group(['prefix' => 'users/{id}'], function () {
    Route::get('followings', 'UsersController@followings')->name('followings');
    Route::get('followers', 'UsersController@followers')->name('followers');
    //退会機能
    Route::get('delete_confirm', 'UsersController@confirm')->name('delete_confirm');
    //パスワード変更
    Route::get('user_password_edit', 'UsersController@editPassword')->name('user_password_edit');
});

Route::resource('rest','RestappController', ['only' => ['index', 'show', 'create', 'store', 'destroy']]); //追記

Route::group(['middleware' => 'auth'], function () {
    Route::put('users', 'UsersController@rename')->name('rename');//追記
});
    
//フォロー機能
Route::group(['prefix' => 'users/{id}'], function () {
    Route::post('follow', 'UserFollowController@store')->name('follow');
    Route::delete('unfollow', 'UserFollowController@destroy')->name('unfollow');
});
    
    Route::resource('movies', 'MoviesController', ['only' => ['create', 'store', 'destroy']
    ]);
    
//退会機能
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'destroy']]);
   
});

//パスワード変更
Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/user/password/edit', 'UserController@editPassword')->name('user.password.edit');
    Route::post('/user/password/', 'UserController@updatePassword')->name('user.password.update');
});