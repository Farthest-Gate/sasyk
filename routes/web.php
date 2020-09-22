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

Route::get('/', 'HomeController@index')->name('home');
Route::post('/contact', 'ContactController@submit')->name('contact');

Route::get('/welcome', function () {
    return view('landing');
})->name('landing');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/invite', 'UserController@index')->name('invite-users');
Route::post('/send-invite', 'UserController@send_invite')->name('invite');
Route::get('/accept-invite', 'UserController@accept_invite')->name('accept-invite');



Route::get('/categories', 'CategoryController@index')->name('view-categories');
Route::post('/categories', 'CategoryController@create')->name('create-category');
Route::get('/category/{category_id}', 'CategoryController@view_category')->name('view-category');


Route::get('/posts/{post_id}', 'PostController@view_post')->name('view-post');
Route::get('/posts', 'PostController@index')->name('view-posts');
Route::get('/create-post', 'PostController@view_create_post')->name('create-post');
Route::get('/create-post/{post_id}', 'PostController@view_update_post')->name('update-post');
Route::post('/create-post', 'PostController@create_post');
Route::post('/upload-image', 'PostController@upload_image')->name('upload-image');
Route::get('/view-image', 'PostController@view_image')->name('view-image');


Route::get('/projects', 'ProjectController@index')->name('view-projects');
Route::post('/projects', 'ProjectController@create')->name('view-projects');
Route::get('/project/{project_id}', 'ProjectController@view_project')->name('view-project');

Route::get('/test', 'UserController@generate');


