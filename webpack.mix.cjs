const mix = require('laravel-mix');

mix.js('resources/js/common.js', 'public/js')
    .js('resources/js/home.js', 'public/js')
    .js('resources/js/weather.js', 'public/js')
    .js('resources/js/weather-records.js', 'public/js')
    .sass('resources/scss/style.scss', 'public/css')
    .setPublicPath('public');
