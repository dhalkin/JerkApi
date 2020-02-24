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
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
    
    
});

Route::group([
    'middleware' => 'auth:api'
], function() {
    Route::get('timezones', 'CatalogController@timezones');
    
    Route::get('company', 'CompanyController@index');
    Route::post('company', 'CompanyController@storeCompany');
    
    Route::get('profile', 'ProfileController@index');
    Route::post('profile', 'ProfileController@storeProfile');
    
    Route::get('halls', 'HallController@index');
    Route::get('hall/{uniqueId?}', 'HallController@getHall')
        ->where('uniqueId', '[a-z0-9]{32}');
    Route::post('hall/create', 'HallController@createHall');
    Route::post('hall/{uniqueId?}', 'HallController@storeHall')
        ->where('uniqueId', '[a-z0-9]{32}');
    Route::post('hall/{uniqueId?}/update', 'HallController@updateHall')
        ->where('uniqueId', '[a-z0-9]{32}');
    
    Route::get('branches', 'BranchController@get');
    Route::post('branch', 'BranchController@update');
    Route::delete('branch', 'BranchController@delete');
});
//Route::get('timezones', function(){
//
//    return [
//        'name'=> 'Olalala',
//        'note'=> 'It\'s ok'
//    ];
//});






