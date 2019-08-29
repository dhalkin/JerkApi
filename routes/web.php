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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'HomeController@userprofile')->name('profile');

Route::get('/studios', 'HomeController@studios')->name('studios');

Route::get('/branches', 'HomeController@branches')->name('branches');

Route::get('/trainers', 'HomeController@trainers')->name('trainers');
