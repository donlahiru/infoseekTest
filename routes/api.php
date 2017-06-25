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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->get('customers', [
        'as'   => 'customers.get',
        'uses' => 'App\Http\Controllers\Api\ApiCustomersController@index'
    ]);

    $api->get('customers/{id}', [
        'as'   => 'customer.get',
        'uses' => 'App\Http\Controllers\Api\ApiCustomersController@show'
    ]);

    $api->post('customers/create', [
        'as'   => 'customer.create',
        'uses' => 'App\Http\Controllers\Api\ApiCustomersController@store'
    ]);

    $api->post('customers/update/{id}', [
        'as'   => 'customer.update',
        'uses' => 'App\Http\Controllers\Api\ApiCustomersController@update'
    ]);

    $api->post('customers/delete/{id}', [
        'as'   => 'customer.update',
        'uses' => 'App\Http\Controllers\Api\ApiCustomersController@destroy'
    ]);

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
