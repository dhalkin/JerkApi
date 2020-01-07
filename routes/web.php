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

Route::post('login-again', 'Auth\LoginAgainController@login')->name('login-again');
Route::post('logout-again', 'Auth\LoginAgainController@logout');
Route::post('register-again', 'Auth\LoginAgainController@register');

// SPA routes, views by vue
Route::get('/app/{app_page}', 'HomeController@index')
    ->where('app_page', '^(company|halls|trainers|customers|profile)$');

// need that for link to the site, seems it will be the same for all entities
//Route::get('/hall/{uniqueId}', 'HomeController@index')
//    ->where('uniqueId', '[a-z0-9]{32}');

// switch language
Route::get('lang/{locale}', 'LocalizationController@index');

// Fresh start calendar schedule, public
Route::get('company/{uniqueId?}/public-schedule', 'ScheduleController@show')
    ->where('uniqueId', '[a-z0-9]{32}');
Route::post('fakelogin', 'FakeController@login')
    ->name('fakelogin');

Route::post('company/{uniqueId?}/events', 'ScheduleController@events')
    ->where('uniqueId', '[a-z0-9]{32}');

Route::post('company/{uniqueId?}/event-attempt', 'ScheduleController@attemptToJoin')
    ->where('uniqueId', '[a-z0-9]{32}');

Route::get('session', 'ScheduleController@session');


// Collect lang for SPA pages
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        $files = glob(resource_path('lang/' . $lang . '.json'));
        foreach ($files as $file) {
            $addStrings = json_decode(file_get_contents($file), true);
            foreach ($addStrings as $index => $string) {
                $strings[$index] = $string;
            }
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');


