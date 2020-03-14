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
    
    
    Route::get('/company/{uid?}/branches', 'BranchController@get')
        ->where('uid', '[a-z0-9]{32}');
    Route::post('/company/{uid?}/branch', 'BranchController@update')
        ->where('uid', '[a-z0-9]{32}');
    Route::delete('/company/{uid?}/branch', 'BranchController@delete')
        ->where('uid', '[a-z0-9]{32}');
    
    Route::get('branch/{uid?}', 'BranchController@getBranchByUid')
        ->where('uid', '[a-z0-9]{32}');
    Route::post('branch/{uid?}/hall', 'BranchController@updateHall')
        ->where('uid', '[a-z0-9]{32}');
    Route::delete('/branch/{uid?}/hall', 'BranchController@deleteHall')
        ->where('uid', '[a-z0-9]{32}');
    
    Route::get('company/{uid?}/groups', 'GroupController@getGroups')
        ->where('uid', '[a-z0-9]{32}');
    Route::get('company/{companyUid?}/group/{groupUid?}', 'GroupController@getGroup')
        ->where('companyUid', '[a-z0-9]{32}')
        ->where('groupUid', '[a-z0-9]{32}|new');
    Route::post('company/{companyUid?}/group', 'GroupController@saveGroup')
        ->where('companyUid', '[a-z0-9]{32}');
    Route::delete('company/{companyUid?}/group', 'GroupController@deleteGroup')
        ->where('companyUid', '[a-z0-9]{32}');
    
    Route::get('company/{uid?}/users', 'CompanyUserController@getUsers')
        ->where('uid', '[a-z0-9]{32}');
    
    
    Route::get('roles', 'RoleController@get');
    Route::post('role', 'RoleController@update');
    Route::delete('role', 'RoleController@delete');
    
});
//Route::get('timezones', function(){
//
//    return [
//        'name'=> 'Olalala',
//        'note'=> 'It\'s ok'
//    ];
//});






