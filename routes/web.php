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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/items/stories/{item}', 'ItemController@stories');

Route::resource('/items', 'ItemController');

Route::resource('/stories', 'StoryController');

Route::get('/getuser/{id}', 'UserController@getUserById');

Route::get('/search', 'SearchController@searchItems');