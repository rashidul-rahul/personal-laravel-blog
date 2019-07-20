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

Route::get('/', 'PublicController@index')->name('index');
Route::get('post/{id}','PublicController@singlePost')->name('singlePost');
Route::get('about', 'PublicController@about')->name('about');
Route::get('contact', 'PublicController@contact')->name('contact');

Route::post('contact', 'PublicController@contactPost');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::prefix('user')->group(function (){
    Route::get('dashboard', 'UserController@dashboard')->name('userDashboard');
    Route::get('comments', 'UserController@comments')->name('userComments');
    Route::post('newComment', 'UserController@newComment')->name('newComment');
    Route::post('comments/{id}/delete', 'UserController@commentPost')->name('deleteComment');
    Route::get('profile', 'UserController@profile')->name('userProfile');
    Route::post('profile', 'UserController@profilePost')->name('userProfilePost');
});

Route::prefix('author')->group(function (){
    Route::get('dashboard', 'AuthorController@dashboard')->name('authorDashboard');
    Route::get('posts', 'AuthorController@posts')->name('authorPosts');
    Route::get('post/new', 'AuthorController@newPost')->name('newPost');
    Route::post('post/new', 'AuthorController@createPost')->name('createPost');
    Route::get('comments', 'AuthorController@comments')->name('authorComments');
    Route::get('post/edit/{id}', 'AuthorController@postEdit')->name('postEdit');
    Route::post('post/edit/{id}', 'AuthorController@postEditPost')->name('postEditPost');
    Route::post('post/delete/{id}', 'AuthorController@deletePost')->name('deletePost');
});

Route::prefix('admin')->group(function (){
   Route::get('dashboard', 'AdminController@dashboard')->name('adminDashboard');
   Route::get('users', 'AdminController@users')->name('adminUsers');
   Route::get('users/edit/{id}', 'AdminController@userEdit')->name('adminUsersEdit');
   Route::post('users/edit/{id}', 'AdminController@userEditPost')->name('adminUsersEditPost');
   Route::post('users/delete/{id}', 'AdminController@userDelete')->name('userDelete');
   Route::get('posts', 'AdminController@posts')->name('adminPosts');
   Route::get('posts/edit/{id}', 'AdminController@postEdit')->name('adminPostEdit');
   Route::post('posts/edit/{id}', 'AdminController@postEditPost')->name('adminPostEditPost');
   Route::post('posts/delete/{id}', 'AdminController@postDelete')->name('adminPostDelete');
   Route::get('comments', 'AdminController@comments')->name('adminComments');
   Route::post('comments/delete/{id}', 'AdminController@commentsDelete')->name('adminCommentsDelete');
});
