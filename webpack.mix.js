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

mix.js('resources/js/main.js', 'public/js')
    .js('resources/js/profile.js', 'public/js')
    .js('resources/js/material-dashboard.js', 'public/js')
    .css('resources/css/material-dashboard.css', 'public/css')
    .sourceMaps();
