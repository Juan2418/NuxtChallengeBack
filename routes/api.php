<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user()->with('articles');
//});

Route::group(['prefix' => 'auth', 'as' => 'auth'], function () {
    Route::post('/login', 'auth\LoginController@login');
    Route::middleware('auth:api')->get('/user', 'auth\LoginController@user');
    Route::post('/register', 'auth\LoginController@register');
    Route::middleware('auth:api')->post('/logout', 'auth\LoginController@logout');
});

Route::group(['prefix' => 'articles', 'as' => 'articles'], function () {
    Route::middleware('auth:api')->get('/', 'ArticleController@index');
    Route::middleware('auth:api')->get('/{article}', 'ArticleController@get');
});
