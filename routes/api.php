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
    Route::post('login', 'API\UserController@login');
    Route::post('signup', 'API\UserController@signup');
    Route::post('insert_gift','API\GiftController@insertNewGift');
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'API\UserController@logout');
        Route::get('user', 'API\UserController@user');
        Route::post('requestgift', 'API\GiftController@requestgift');
        Route::get('getlist', 'API\GiftController@luckypersonal');

        Route::post('admin_insert_customer', 'API\CustomerController@insertCustomer');
        Route::post('customer_update', 'API\CustomerController@updateInfo');

        Route::post('retailer_info', 'API\RetailerController@retailer');
        Route::post('retailer_upload', 'API\RetailerController@upload_image');
    });
});