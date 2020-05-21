const mix = require('laravel-mix');

mix.styles([
   'resources/assets/plantilla/css/all.min.css',
   'resources/assets/plantilla/css/bootstrap.min.css',
   'resources/assets/plantilla/css/ruang-admin.min.css'
], 'public/css/plantilla.css')

.scripts([
   'resources/assets/plantilla/js/jquery.min.js',
   'resources/assets/plantilla/js/jquery.easing.min.js',
   'resources/assets/plantilla/js/bootstrap.min.js',
   'resources/assets/plantilla/js/ruang-admin.min.js',
   'resources/assets/plantilla/js/sweetalert2.js',
], 'public/js/plantilla.js')

.js(['resources/js/app.js'], 'public/js/app.js')
.sass('resources/sass/app.scss', 'public/css');;
