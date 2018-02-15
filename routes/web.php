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

Route::get('/', 'HomeController@landing');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/items/stories/{item}', 'ItemController@stories');

Route::get('/items/declutter/{item}', 'ItemController@declutter');

Route::get('/items/check/{item}', 'ItemController@checkDeclutter');

Route::get('/items/undoDeclutter/{item}', 'ItemController@undoDeclutter');

Route::resource('/items', 'ItemController');

Route::get('/stories/user/{user}', 'StoryController@getUserStories');

Route::resource('/stories', 'StoryController');

Route::get('/getuser/{id}', 'UserController@getUserById');

Route::get('/search', 'SearchController@searchItems');

Route::post('/searchUser', 'UserController@searchUsers');

Route::get('/profile/edit','UserController@edit');

Route::get('/profile/{id}/follow', 'UserController@toggleFollow');

Route::get('/profile/followers', 'UserController@getFollowers');

Route::get('/profile/followings', 'UserController@getFollowings');

Route::get('/profile/visibility', 'UserController@toggleVisibility');

Route::get('/profile/{id}/checkLogIn', 'UserController@checkLogIn');

Route::get('/profile/{id}/check', 'UserController@checkFollow');

Route::get('/profile/{id}', 'UserController@profile');

Route::patch('/profile', 'UserController@update');

Route::get('/changePassword','UserController@showChangePasswordForm');

Route::post('/changePassword','UserController@changePassword');

Route::resource('/categories', 'CategoryController');

Route::get('/admin', 'UserController@showAdmin')->middleware('admin');

Route::get('/top', 'ItemController@top');

Route::get('/timeline/stories', 'ItemController@getFolloweeStories');

Route::delete('/deleteUser/{user}', 'UserController@destroy');


Route::get('/cost/{user}', 'UserController@averageCost');

