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


Route::get('/stories/user/{user}', 'StoryController@getUserStories');

Route::prefix('/items')->group(function() {
    Route::get('/stories/{item}', 'ItemController@stories');

    Route::get('/declutter/{item}', 'ItemController@declutter');

    Route::get('/check/{item}', 'ItemController@checkDeclutter');

    Route::get('/undoDeclutter/{item}', 'ItemController@undoDeclutter');
});

Route::resource('/items', 'ItemController');


Route::resource('/stories', 'StoryController');


Route::prefix('/profile')->group(function() {
    Route::get('/edit','UserController@edit');

    Route::get('/{id}/follow', 'UserController@toggleFollow');

    Route::get('/followers', 'UserController@getFollowers');

    Route::get('/followings', 'UserController@getFollowings');

    Route::get('/visibility', 'UserController@toggleVisibility');

    Route::get('/{id}/checkLogIn', 'UserController@checkLogIn');

    Route::get('/{id}/check', 'UserController@checkFollow');

    Route::get('/{id}', 'UserController@profile');

    Route::patch('', 'UserController@update');

});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'SearchController@searchItems');

Route::post('/searchUser', 'UserController@searchUsers');

Route::get('/getuser/{id}', 'UserController@getUserById');

Route::delete('/deleteUser/{user}', 'UserController@destroy');

Route::get('/cost/{user}', 'UserController@averageCost');

Route::get('/admin', 'UserController@showAdmin')->middleware('admin');

Route::get('/top', 'ItemController@top');

Route::get('/timeline/stories', 'StoryController@getFolloweeStories');



Route::get('/changePassword','UserController@showChangePasswordForm');

Route::post('/changePassword','UserController@changePassword');


Route::resource('/categories', 'CategoryController');



