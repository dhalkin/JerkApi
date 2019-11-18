const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/welcome.js', 'public/js')
    .sass('resources/sass/welcome.scss', 'public/css');

//mix.sass('resources/sass/paper-dashboard.scss', 'public/css');
mix.js('resources/js/non-auth-app.js', 'public/js');

mix.copy('resources/css/paper-dashboard.css', 'public/css/paper-dashboard.css')
    .copy('resources/css/montseratt.css', 'public/css/montseratt.css')
    .copy('resources/css/awesome.css', 'public/css/awesome.css')
    //.copy('resources/css/jquery.dataTables.min.css', 'public/css/jquery.dataTables.min.css')
    .copy('resources/fonts/fontawesome-webfont.woff2', 'public/fonts/fontawesome-webfont.woff2')
    .copy('resources/fonts/nucleo-icons.woff2', 'public/fonts/nucleo-icons.woff2');
