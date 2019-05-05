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
Route::patch('/updatepasswordAndroid/{id}','UserController@updatePassword');

//=================================Employee=============================//
Route::delete('/employee/{id}','EmployeeController@destroy');
Route::get('/employee','EmployeeController@index');
Route::post('/user','UserController@store');
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
    Route::post('/loginAndroid','AuthController@loginAndroid'); 
    //android & desktop platform
});
//=========================================================================//


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
Route::get('/sparepartkurang','SparepartController@checkSparepartStock'); //cek sparepart yang stoknya kurang dari stok minimal
//Android
Route::patch('/sparepartAndroid/{id}','SparepartController@updateSparepartAndroid');
Route::post('/gambarsparepartAndroid','SparepartController@updateSparepartAndroidPicture'); 

Route::get('/sparepartstokterdikit','SparepartController@sortStockTerdikit');
Route::get('/sparepartstokterbanyak','SparepartController@sortStockTerbanyak');
Route::get('/sparepartpricetermahal','SparepartController@sortPriceTermahal');
Route::get('/sparepartpricetermurah','SparepartController@sortPriceTermurah');
//=========================================================================/


//==================================SPAREPART TYPE==============================/
Route::get('/spareparttype','SparepartTypeController@index');
Route::post('/spareparttype','SparepartTypeController@store');
Route::patch('/spareparttype/{id}','SparepartTypeController@update');
Route::delete('/spareparttype/{id}','SparepartTypeController@destroy');
Route::get('/spareparttype/{id}','SparepartTypeController@show');
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
Route::patch('/branches/{id}','BranchController@update');
Route::get('/branches/{id}','BranchController@show');
Route::delete('/branches/{id}','BranchController@destroy');
//=========================================================================/

//==================================Customer=================================/
Route::get('/customer','CustomerController@index');
Route::post('/customer','CustomerController@store');
Route::patch('/customer/{id}','CustomerController@update');
Route::get('/customer/{id}','CustomerController@show');
Route::delete('/customer/{id}','CustomerController@destroy');
//=========================================================================/

//==================================Role=================================/
Route::get('/roles','RoleController@index');
Route::post('/roles','RoleController@store');
Route::patch('/roles/{id}','RoleController@update');
Route::get('/roles/{id}','RoleController@show');
Route::delete('/roles/{id}','RoleController@destroy');
//=========================================================================/

//==================================Sales=================================/
Route::get('/sales','SalesController@index');
Route::post('/sales','SalesController@store');
Route::patch('/sales/{id}','SalesController@update');
Route::get('/sales/{id}','SalesController@show');
Route::delete('/sales/{id}','SalesController@destroy');
//=========================================================================/

//===========================SparepartProcurement==========================/
Route::get('/sparepartprocurement','SparepartProcurementController@index');
Route::post('/sparepartprocurement','SparepartProcurementController@store');
Route::patch('/sparepartprocurement/{id}','SparepartProcurementController@update');
Route::get('/sparepartprocurement/{id}','SparepartProcurementController@show');
Route::delete('/sparepartprocurement/{id}','SparepartProcurementController@destroy');
Route::patch('/procurementverif/{id}','SparepartController@sparepartVerification');

Route::post('/procurementAndroid','SparepartProcurementController@storeProcurementAndroid');
Route::patch('/procurementAndroid/{id}','SparepartProcurementController@updateAndroid');
//=========================================================================/

//========================SparepartDetailProcurement=======================/
Route::post('/procurementDetailAndroid','SparepartProcurementDetailController@storeDetailProcurementAndroid');
Route::get('/procurementDetailAndroid/{id}','SparepartProcurementDetailController@showUsingIdSparepart');
Route::patch('/procurementDetailAndroid/{id}','SparepartProcurementDetailController@verifAndroid');
//=========================================================================/

//=============================MotorcycleBrand=============================/
Route::get('/motorcyclebrand','MotorcycleBrandController@index');
Route::post('/motorcyclebrand','MotorcycleBrandController@store');
Route::patch('/motorcyclebrand/{id}','MotorcycleBrandController@update');
Route::get('/motorcyclebrand/{id}','MotorcycleBrandController@show');
Route::delete('/motorcyclebrand/{id}','MotorcycleBrandController@destroy');
//=========================================================================/

//=============================MotorcycleType=============================/
Route::get('/motorcycletype','MotorcycleTypeController@index');
Route::post('/motorcycletype','MotorcycleTypeController@store');
Route::patch('/motorcycletype/{id}','MotorcycleTypeController@update');
Route::get('/motorcycletype/{id}','MotorcycleTypeController@show');
Route::delete('/motorcycletype/{id}','MotorcycleTypeController@destroy');
//=========================================================================/

//==============================Transactions==============================/
Route::get('/transaction','TransactionController@index');
Route::post('/transaction','TransactionController@store');
Route::patch('/transaction/{id}','TransactionController@update');
Route::get('/transaction/{id}','TransactionController@show');
Route::delete('/transaction/{id}','TransactionController@destroy');

Route::post('/transactionAndroid','TransactionController@storeAndroid');
//=========================================================================/


//====================TransactionDetailSparepartAndroid=====================/
Route::get('/spareparttransaction','SparepartTransactionController@index');
Route::post('/spareparttransaction','SparepartTransactionController@store');
Route::patch('/spareparttransaction/{id}','SparepartTransactionController@update');
Route::get('/spareparttransaction/{id}','SparepartTransactionController@show');
Route::delete('/spareparttransaction/{id}','SparepartTransactionController@destroy');
//=========================================================================/

//====================TransactionDetailServiceAndroid=====================/
Route::get('/servicetransaction','ServiceTransactionController@index');
Route::post('/servicetransaction','ServiceTransactionController@store');
Route::patch('/servicetransaction/{id}','ServiceTransactionController@update');
Route::get('/servicetransaction/{id}','ServiceTransactionController@show');
Route::delete('/servicetransaction/{id}','ServiceTransactionController@destroy');
//=========================================================================/

//=================================TOKEN==================================/
Route::post('/authenticate', 'TokenController@authenticate');
Route::get('/whoami', 'TokenController@validateToken');
//=========================================================================/

//=================================HISTORY=================================/
Route::get('/historysparepart','HistorySparepartController@index');
//=========================================================================/