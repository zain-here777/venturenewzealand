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
    .sass('resources/sass/app.scss', 'public/css');


mix.styles([
    'resources/css/assets/libs/slick/slick-theme.css',
    'resources/css/assets/libs/slick/slick.css',
    'resources/css/assets/libs/quilljs/css/quill.bubble.css',
    'resources/css/assets/libs/quilljs/css/quill.core.css',
    'resources/css/assets/libs/quilljs/css/quill.snow.css',
    'resources/css/assets/libs/chosen/chosen.min.css',
    'resources/css/assets/libs/photoswipe/photoswipe.css',
    'resources/css/assets/libs/fontawesome-pro/css/fontawesome.css',
    'resources/css/assets/libs/photoswipe/default-skin/default-skin.css',
    'resources/css/assets/libs/lity/lity.min.css',
    'resources/css/assets/libs/gijgo/css/gijgo.min.css',
    'resources/css/assets/css/video.css'
], 'public/css/all.css');


mix.styles([
    'resources/css/admin/vendors/pnotify/dist/pnotify.css',
    'resources/css/admin/vendors/pnotify/dist/pnotify.buttons.css',
    'resources/css/admin/vendors/pnotify/dist/pnotify.nonblock.css'
], 'public/css/pnotifycss.css');


mix.styles([
    'resources/css/assets/css/style-rtl.css',
    'resources/css/assets/css/responsive-rtl.css',
    'resources/css/assets/css/custom-rtl.css',
], 'public/css/style_responsive_custom-rtl.css');

mix.styles([
    'resources/css/assets/css/style.css',
    'resources/css/assets/css/responsive.css',
    'resources/css/assets/css/custom.css',
], 'public/css/style_responsive_custom.css');


mix.styles([
    'resources/css/sweetalert.css',
    'resources/css/assets/css/toastr.css'
], 'public/css/sweetalert_toastr.css');





mix.scripts([
    'resources/css/assets/libs/jquery-1.12.4.js',
    'resources/css/assets/js/toastr.min.js',
    'resources/css/assets/libs/popper/popper.js',
    'resources/css/assets/libs/bootstrap/js/bootstrap.min.js',
    'resources/css/assets/libs/slick/slick.min.js',
    // 'resources/css/assets/libs/slick/jquery.zoom.min.js',
    // 'resources/css/assets/libs/isotope/isotope.pkgd.min.js',
    // 'resources/css/assets/libs/photoswipe/photoswipe.min.js',
    // 'resources/css/assets/libs/photoswipe/photoswipe-ui-default.min.js',
    // 'resources/css/assets/libs/lity/lity.min.js',
    // 'resources/css/assets/libs/quilljs/js/quill.core.js',
    // 'resources/css/assets/libs/quilljs/js/quill.js',
    // 'resources/css/assets/libs/gijgo/js/gijgo.min.js',
    // 'resources/css/assets/js/fil.js',
    // 'resources/css/assets/libs/chosen/chosen.jquery.min.js',
    // 'resources/css/assets/js/main.js',
    // 'resources/css/assets/js/custom.js',
    // 'resources/css/admin/vendors/datatables.net/js/jquery.dataTables.min.js',
    // 'resources/css/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
    // 'resources/css/admin/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
    // 'resources/css/admin/chosen/chosen.jquery.min.js',
    // 'resources/css/admin/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    // 'resources/js/sweetalert.min.js',
    // 'resources/css/admin/vendors/switchery/dist/switchery.min.js',
    // 'resources/css/admin/vendors/pnotify/dist/pnotify.js',
    // 'resources/css/admin/vendors/pnotify/dist/pnotify.buttons.js',
    // 'resources/css/admin/vendors/pnotify/dist/pnotify.nonblock.js',
    // 'resources/css/assets/libs/1_9_7_jquery.lazyload.js',
    // 'resources/css/assets/libs/customLazy.js',
    // 'resources/css/assets/js/template_frontend/page_template1.js',
    // 'resources/css/assets/js/template_frontend/page_template2.js',

], 'public/js/all.js');


mix.scripts([
    'resources/css/assets/libs/slick/jquery.zoom.min.js',
    'resources/css/assets/libs/isotope/isotope.pkgd.min.js',
    'resources/css/assets/libs/photoswipe/photoswipe.min.js',
    'resources/css/assets/libs/photoswipe/photoswipe-ui-default.min.js',
    'resources/css/assets/libs/lity/lity.min.js',
    'resources/css/assets/libs/quilljs/js/quill.core.js',
    'resources/css/assets/libs/quilljs/js/quill.js',
    'resources/css/assets/libs/gijgo/js/gijgo.min.js'

], 'public/js/libsjs.js');



mix.scripts([
   
    'resources/css/assets/js/fil.js',
    'resources/css/assets/libs/chosen/chosen.jquery.min.js',
    'resources/css/assets/js/main.js',
    'resources/css/assets/js/custom.js',

], 'public/js/fil_custom.js');


mix.scripts([
    
    'resources/css/admin/vendors/datatables.net/js/jquery.dataTables.min.js',
    'resources/css/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
    'resources/css/admin/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js',

], 'public/js/admin_vendor.js');


mix.scripts([
   
    'resources/css/admin/chosen/chosen.jquery.min.js',
    'resources/css/admin/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    'resources/vendor/laravel-filemanager/js/stand-alone-button.js'
], 'public/js/colorpicker.js');


// mix.scripts([
//     'resources/js/sweetalert.min.js',
//     'resources/css/admin/vendors/switchery/dist/switchery.min.js',
//     'resources/css/admin/vendors/pnotify/dist/pnotify.js',
//     'resources/css/admin/vendors/pnotify/dist/pnotify.buttons.js',
//     'resources/css/admin/vendors/pnotify/dist/pnotify.nonblock.js',
// ], 'public/js/pnotify.js');


// mix.scripts([
   
//     'resources/css/assets/libs/1_9_7_jquery.lazyload.js',
//     'resources/css/assets/libs/customLazy.js',
//     'resources/css/assets/js/template_frontend/page_template1.js',

// ], 'public/js/lazyload.js');


// not mixed
mix.scripts([
    'resources/js/sweetalert.min.js',
    'resources/css/admin/vendors/switchery/dist/switchery.min.js',
    'resources/css/admin/vendors/pnotify/dist/pnotify.js',
    'resources/css/admin/vendors/pnotify/dist/pnotify.buttons.js',
    'resources/css/admin/vendors/pnotify/dist/pnotify.nonblock.js',
    'resources/css/assets/libs/1_9_7_jquery.lazyload.js',
    'resources/css/assets/libs/customLazy.js',
    'resources/css/assets/js/template_frontend/page_template1.js',

], 'public/js/pnotify_lazyload.js');


mix.scripts([
   
    'resources/css/assets/js/template_frontend/page_template_weather_check.js',
    'resources/css/assets/js/template_frontend/page_template2.js',

], 'public/js/page_template_weather_check.js');


mix.scripts([
   
    'resources/css/assets/js/template_frontend/page_template_weather.js',
    'resources/css/assets/js/template_frontend/page_template2.js',

], 'public/js/page_template_weather.js');



mix.styles([
    'resources/css/admin/vendors/bootstrap/dist/css/bootstrap.min.css',
    'resources/css/admin/vendors/font-awesome/css/font-awesome.min.css',
    'resources/css/admin/vendors/nprogress/nprogress.css',
    'resources/css/admin/vendors/iCheck/skins/flat/green.css',
    'resources/css/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
    'resources/css/admin/vendors/jqvmap/dist/jqvmap.min.css',
    'resources/css/admin/vendors/bootstrap-daterangepicker/daterangepicker.css',
    'resources/css/admin/vendors/switchery/dist/switchery.min.css',
    'resources/css/admin/vendors/pnotify/dist/pnotify.css',
    'resources/css/admin/vendors/pnotify/dist/pnotify.buttons.css',
    'resources/css/admin/vendors/pnotify/dist/pnotify.nonblock.css',
    'resources/css/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css',
    'resources/css/admin/chosen/chosen.min.css',
    'resources/css/admin/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css'
], 'public/css/admin-all.css');



mix.scripts([
    'resources/css/admin/vendors/jquery/dist/jquery.min.js',
    'resources/css/admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js',
    'resources/css/admin/vendors/fastclick/lib/fastclick.js',
    'resources/css/admin/vendors/nprogress/nprogress.js',
    'resources/css/admin/vendors/Chart.js/dist/Chart.min.js',
    'resources/css/admin/vendors/gauge.js/dist/gauge.min.js',
    'resources/css/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
    'resources/css/admin/vendors/iCheck/icheck.min.js',
    'resources/css/admin/vendors/skycons/skycons.js',
    'resources/css/admin/vendors/Flot/jquery.flot.js',
    'resources/css/admin/vendors/Flot/jquery.flot.pie.js',
    'resources/css/admin/vendors/Flot/jquery.flot.time.js',
    'resources/css/admin/vendors/Flot/jquery.flot.stack.js',
    'resources/css/admin/vendors/Flot/jquery.flot.resize.js',
    'resources/css/admin/vendors/flot.orderbars/js/jquery.flot.orderBars.js',
    'resources/css/admin/vendors/flot-spline/js/jquery.flot.spline.min.js',
    'resources/css/admin/vendors/flot.curvedlines/curvedLines.js',
    'resources/css/admin/vendors/DateJS/build/date.js',
    'resources/css/admin/vendors/jqvmap/dist/jquery.vmap.js',
    'resources/css/admin/vendors/jqvmap/dist/maps/jquery.vmap.world.js',
    'resources/css/admin/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js',
    'resources/css/admin/vendors/moment/min/moment.min.js',
    'resources/css/admin/vendors/bootstrap-daterangepicker/daterangepicker.js',
    'resources/css/admin/vendors/switchery/dist/switchery.min.js',
    'resources/css/admin/vendors/raphael/raphael.min.js',
    'resources/css/admin/vendors/morris.js/morris.min.js',
    'resources/css/admin/vendors/pnotify/dist/pnotify.js',
    'resources/css/admin/vendors/pnotify/dist/pnotify.buttons.js',
    'resources/css/admin/vendors/pnotify/dist/pnotify.nonblock.js',
    'resources/css/admin/vendors/datatables.net/js/jquery.dataTables.min.js',
    'resources/css/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js',
    'resources/css/admin/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js',


], 'public/js/admin-all.js');

