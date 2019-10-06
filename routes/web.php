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
    ->where('app_page', '^(home|company|branches|halls|trainers|customers|profile)$');

Route::get('/hall/{uniqueId}', 'HomeController@index')
    ->where('uniqueId', '[a-z0-9]{32}');

// switch language
Route::get('lang/{locale}', 'LocalizationController@index');

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


