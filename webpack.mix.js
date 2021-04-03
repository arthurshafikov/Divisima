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

// Client 
mix.js('resources/js/app.js','public/assets/app.js')
    .sass('resources/sass/app.scss', 'public/assets/app.css');

mix.styles([
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/css/flaticon.css',
    'resources/assets/css/slicknav.min.css',
    'resources/assets/css/jquery-ui.min.css',
    'resources/assets/css/owl.carousel.min.css',
    'resources/assets/css/animate.css',
    'resources/assets/css/style.css',
    'resources/assets/css/preloader.css',
    'resources/assets/libs/fancybox/jquery.fancybox.min.css',
    'resources/assets/libs/selectric/selectric.css',
], 'public/assets/main.css');

mix.scripts([
    'resources/assets/js/jquery-3.2.1.min.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/jquery.slicknav.min.js',
    'resources/assets/js/owl.carousel.min.js',
    'resources/assets/js/jquery.nicescroll.min.js',
    'resources/assets/js/jquery.zoom.min.js',
    'resources/assets/js/jquery-ui.min.js',
    'resources/assets/js/main.js',
    'resources/assets/libs/fancybox/jquery.fancybox.min.js',
    'resources/assets/libs/selectric/jquery.selectric.min.js',
], 'public/assets/all.js');


// Admin
mix.styles([
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/admin/css/styles.css',
    'resources/assets/css/preloader.css',

    //libs
    'resources/assets/libs/summernote/summernote-lite.min.css',
    'resources/assets/libs/fancybox/jquery.fancybox.min.css',
], 'public/admin/assets/main.css');

mix.scripts([
    'resources/assets/js/jquery-3.2.1.min.js',
    'resources/assets/admin/js/scripts.js',

    //libs
    'resources/assets/libs/summernote/summernote-lite.min.js',
    'resources/assets/admin/js/summernote-editor.js',
    'resources/assets/libs/fancybox/jquery.fancybox.min.js',

    'resources/assets/admin/libs/chart-area.js',
    'resources/assets/admin/libs/chart-bar.js',
], 'public/admin/assets/all.js');

mix.copy('resources/assets/libs/summernote/summernote-lite.min.js.map','public/admin/assets/summernote-lite.min.js.map');
mix.copyDirectory('resources/assets/libs/summernote/font','public/admin/assets/font');
mix.copyDirectory('resources/assets/libs/summernote/lang','public/admin/assets/lang');