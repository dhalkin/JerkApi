<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// unauthorized page
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// SPA routes, views by vue
Route::get('/{app_page}', 'HomeController@index')
    ->where('app_page', '^(home|company|branches|trainers|clients|profile)$');



