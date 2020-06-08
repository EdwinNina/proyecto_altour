const mix = require('laravel-mix');

mix.styles([
   'resources/assets/plantilla/css/materialdesignicons.min.css',
   'resources/assets/plantilla/css/vendor.bundle.base.css',
   'resources/assets/plantilla/css/style.css'
], 'public/css/plantilla.css')

.scripts([
   'resources/assets/plantilla/js/vendor.bundle.base.js',
   'resources/assets/plantilla/js/off-canvas.js',
   'resources/assets/plantilla/js/hoverable-collapse.js',
   'resources/assets/plantilla/js/misc.js',
   'resources/assets/plantilla/js/dashboard.js',
   'resources/assets/plantilla/js/todolist.js',
], 'public/js/plantilla.js')

.js(['resources/js/app.js'], 'public/js/app.js')
.sass('resources/sass/app.scss', 'public/css');;
