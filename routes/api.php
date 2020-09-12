<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register'); // site.com/api/auth/register
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{username}', 'UserController@show')->middleware('isAdminOrSelf');
    Route::post('users/{username}', 'UserController@update')->middleware('isAdminOrSelf');
});

Route::group(['prefix' => 'profiles'], function(){
    Route::post('{profile}/follow', 'ProfileController@follow')->name('follow')->middleware('auth:api');
    Route::delete('{profile}/follow', 'ProfileController@unfollow')->name('unfollow')->middleware('auth:api');;
    Route::get('{username}', 'ProfileController@show');
});

Route::group(['prefix' => 'posts'], function(){
    Route::post('/', 'PostController@store')->middleware('auth:api');
});

Route::group(['prefix' => 'stories'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('/', 'StoryController@store');
        Route::post('/markViewed', 'StoryController@markViewed');
    });
});
