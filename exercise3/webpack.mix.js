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
  .styles('resources/css/style.css', 'public/css/style.css')
  .sass('resources/sass/app.scss', 'public/css');

mix.styles('resources/css/start.css', 'public/css/start.css');

mix.styles('resources/css/login.css', 'public/css/login.css');

mix.js('resources/js/home.js', 'public/js/home.js')
  .styles('resources/css/home.css', 'public/css/home.css');
