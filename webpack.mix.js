const mix = require('laravel-mix');

mix.options({
        postCss: [
            require('autoprefixer'),
        ],
    });

// main app
mix.js('resources/js/main.js', 'public/js/main.js');

// calendar app
mix.js('resources/js/schedule.js', 'public/js');

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/welcome.js', 'public/js');

//mix.sass('resources/assets/sass/paper-dashboard.scss', 'public/css');

mix.copyDirectory('resources/css', 'public/css');
mix.copyDirectory('resources/fonts', 'public/fonts');
mix.copyDirectory('resources/static', 'public/static');
