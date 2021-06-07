const mix = require('laravel-mix');
let source = 'public/app/src/';
let build = 'public/app/build/';

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js(source + 'app.js', build)
    .js(source + 'projects.js', build)
    .js(source + 'tasks.js', build)
    .js(source + 'subtasks.js', build)
    .js(source + 'changePassword.js', build)
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
