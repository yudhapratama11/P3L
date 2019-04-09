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

//=================================USER & LOGIN=============================//
Route::get('/user','UserController@index');
Route::post('/user','UserController@store');
Route::get('/user/{id}','UserController@show');
Route::post('/updatepasswordAndroid/{id}','UserController@updatePassword');

Route::delete('/employee/{id}','EmployeeController@destroy');
Route::get('/employee','EmployeeController@index');
Route::get('/employee/{id}','EmployeeController@show');
Route::patch('/employee/{id}','EmployeeController@update');

//menampilkan user yang sedang login
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/authenticatedUser','UserController@getAuthenticatedUser');
    Route::post('/updatepassword','UserController@updatePassword');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login','AuthController@login'); //web platform
    Route::post('/logout','AuthController@logout'); //web platform
     //android & desktop platform
});
//=========================================================================//
Route::post('/loginAndroid','AndroidAuthController@login');

//==================================SUPPLIER===============================//
Route::get('/supplier','SupplierController@index');
Route::post('/supplier','SupplierController@store');
Route::patch('/supplier/{id}','SupplierController@update');
Route::delete('/supplier/{id}','SupplierController@destroy');
Route::get('/supplier/{id}','SupplierController@show');
//=========================================================================//

//==================================SPAREPART==============================/
Route::post('/sparepart/{id}','SparepartController@updateSparepart');
Route::get('/sparepart','SparepartController@index');
Route::post('/sparepart','SparepartController@store');
Route::delete('/sparepart/{id}','SparepartController@destroy');
Route::get('/sparepart/{id}','SparepartController@show');
Route::patch('/sparepartAndroid/{id}','SparepartController@updateSparepartAndroid');
Route::post('/gambarsparepartAndroid','SparepartController@updateSparepartAndroidPicture');
Route::get('/sparepartkurang','SparepartController@checkSparepartStock'); //cek sparepart yang stoknya kurang dari stok minimal
//=========================================================================/

//==================================SERVICE================================/
Route::get('/service','ServiceController@index');
Route::post('/service','ServiceController@store');
Route::patch('/service/{id}','ServiceController@update');
Route::delete('/service/{id}','ServiceController@destroy');
Route::get('/service/{id}','ServiceController@show');
//=========================================================================/

//==================================BRANCH=================================/
Route::get('/branches','BranchController@index');
Route::post('/branches','BranchController@store');
Route::post('/branches/{id}','BranchController@update');
Route::get('/branches/{id}','BranchController@show');
Route::delete('/branches/{id}','BranchController@destroy');
//=========================================================================/

Route::get('/roles','RoleController@index');
Route::post('/roles','RoleController@store');
Route::patch('/roles/{id}','RoleController@update');
Route::get('/roles/{id}','RoleController@show');
Route::delete('/roles/{id}','RoleController@destroy');
//=========================================================================/

Route::get('/spareparttype','SparepartTypeController@index');
Route::post('/spareparttype','SparepartTypeController@store');
// Route::patch('/roles/{id}','RoleController@update');
// Route::get('/roles/{id}','RoleController@show');
// Route::delete('/roles/{id}','RoleController@destroy');