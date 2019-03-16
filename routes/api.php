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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('user/{name?}', function ($name = null) {
//     return $name;
// });

// Route::post('register','Auth/RegisterController@create');



Route::group([
    'prefix' => 'auth'
], function () {

    Route::get('gethost', 'API\MyConstant@getHostDomain');


    Route::post('login', 'API\UserController@login');
    Route::post('register', 'API\UserController@register');

    Route::post('insert_gift','API\GiftController@insertNewGift');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'API\UserController@logout');
        Route::get('user', 'API\UserController@user');
        Route::post('requestgift', 'API\GiftController@requestGift');
        Route::get('getLuckyPerson', 'API\GiftController@luckyPerson');

        // API handle customer
        Route::post('customer_update', 'API\CustomerController@updateInfo');

        // API Handle contract
        Route::post('createContractRetailer', 'API\ContractController@createContractRetailer');
        Route::post('updateImageContract', 'API\ContractController@updateImage');

        // API Handle Report
        Route::post('getReport', 'API\ReportController@getReport');

        // API Handle gift
        Route::get('getListGift', 'API\GiftController@getListGift');

        // API for ADMIN
        Route::post('admin_insert_customer_one', 'API\CustomerController@insertCustomerManual');
        Route::post('admin_insert_customer_file', 'API\CustomerController@insertDataViaFile');


    });
});
