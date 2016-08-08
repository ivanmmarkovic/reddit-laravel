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

Route::get('/', [
    'uses' => 'PostsController@index',
    'as' => 'welcome'
]);

Route::get('users/create', [
    'uses' => 'UsersController@create',
    'as' => 'userscreate'
]);

Route::post('users', [
    'uses' => 'UsersController@store',
    'as' => 'usersstore'
]);

Route::get('users/{user}', [
    'uses' => 'UsersController@show',
    'as' => 'profile'
]);

Route::get('signin', [
    'uses' => 'UsersController@signin',
    'as' => 'signin'
]);

Route::post('signin', [
    'uses' => 'UsersController@signinprocess',
    'as' => 'signinprocess'
]);

Route::get('logout', [
    'uses' => 'UsersController@logout',
    'as' => 'logout'
]);

//###################################################

Route::get('posts/create', [
    'uses' => 'PostsController@create',
    'as' => 'postscreate',
    'middleware' => 'auth'
]);

Route::post('posts/store', [
    'uses' => 'PostsController@store',
    'as' => 'postsstore'
]);

Route::get('posts/{post}', [
    'uses' => 'PostsController@show',
    'as' => 'post'
]);

Route::get('posts/user/{user}', [
    'uses' => 'PostsController@postsuser',
    'as' => 'postsuser'
]);

Route::get('post/delete/{post}', [
    'uses' => 'PostsController@delete',
    'as' => 'postdelete'
]);

Route::post('vote', [
    'uses' => 'PostsController@vote',
    'as' => 'vote'
]);

//#####################################################

Route::post('comments/store/{post}', [
    'uses' => 'CommentsController@store',
    'as' => 'commentsstore',
    'middleware' => 'auth'
]);

Route::get('comments/user/{user}', [
    'uses' => 'CommentsController@commentsuser',
    'as' => 'commentsuser'
]);

Route::get('comments/delete/{comment}', [
    'uses' => 'CommentsController@delete',
    'as' => 'commentdelete'
]);
