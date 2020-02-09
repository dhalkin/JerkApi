const mix = require('laravel-mix');

// mix.webpackConfig({
//     module: {
//         rules: [{
//             test: /node_modules(\/|\\)(lightgallery\.js|lg-[a-z0-9]+\.js)(\/|\\).+\.js$/,
//             use: [{
//                 loader: 'babel-loader',
//                 options: mix.config.babel()
//             }]
//         }]
//     }
// });

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.

 {sassOptions: {
        outputStyle: 'nested',
    },
    implementation: require('node-sass')}
 |
 */
//mix.sass('resources', 'output', { implementation: require('node-sass') });
// mix.sass('resources/assets/sass/paper-dashboard.scss', 'public/css', {
//     implementation: require('node-sass')
// });
//mix.sass('resources/assets/sass/demo.scss', 'public/css', {
    //implementation: require('node-sass')
//});

mix.js('resources/js/main.js', 'public/js/main.js');

//mix.js('resources/js/schedule.js', 'public/js');

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/welcome.js', 'public/js')
    .sass('resources/sass/welcome.scss', 'public/css');

//mix.sass('resources/sass/paper-dashboard.scss', 'public/css');
//mix.js('resources/js/non-auth-app.js', 'public/js');

mix.copyDirectory('resources/css', 'public/css');
mix.copyDirectory('resources/fonts', 'public/fonts');
mix.copyDirectory('resources/static', 'public/static');
