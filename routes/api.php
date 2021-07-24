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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'App\Http\Controllers\AuthenticationController@login');
Route::post('auth/multiple-data', 'App\Http\Controllers\AuthenticationController@getData');
Route::get('auth/get-data/{id}', 'App\Http\Controllers\AuthenticationController@getFormData');
Route::get('auth/delete-step/{id}', 'App\Http\Controllers\AuthenticationController@deleteData');
Route::get('auth/get-table', 'App\Http\Controllers\AuthenticationController@getTableData');
Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('auth/user', 'App\Http\Controllers\AuthenticationController@user');
});
Route::group(['middleware' => 'jwt.refresh'], function(){
  Route::get('auth/refresh', 'AuthenticationController@refresh');
});

Route::post('auth/test', function (Request $request) {
    return "test";
});