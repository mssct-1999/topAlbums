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

mix.js([
    'resources/js/app.js',
    'resources/js/albums.js',
    'resources/js/helpers.js'
    ],'public/js')
    .js('resources/js/home.js','public/js/home.js')
    .js('resources/js/admin.js','public/js/admin.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/dark-app.scss','public/css')
    mix.disableNotifications();