const mix = require('laravel-mix');
mix.webpackConfig({
    resolve: {
        alias: {
            jquery: "jquery/src/jquery"
        }
    }
});
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

mix.sourceMaps(false,'inline-source-map')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/dashboard.js', 'public/js')
    .js('resources/js/public.js', 'public/js')
    .js('resources/js/script.js', 'public/js')
    .js('resources/js/employees.js', 'public/js')
    .js('resources/js/reports.js', 'public/js')
    .js('resources/js/notifications.js', 'public/js')
    .js('resources/js/rewards.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/dashboard.scss', 'public/css')
    .sass('resources/sass/styles.scss', 'public/css')
    .sass('resources/sass/full_calendar.scss', 'public/css');
