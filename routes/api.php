<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user','UserController@index');
Route::post('/user','UserController@store');
Route::get('/branches','BranchController@index');
Route::post('/branches','BranchController@store');



Route::get('/user','UserController@getAuthenticatedUser'); //menampilkan user yang sedang login

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login','AuthController@login');
    Route::post('/logout','AuthController@logout');
    //Route::post('/me','AuthController@me');
});