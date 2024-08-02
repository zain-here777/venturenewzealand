<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NC9L3JG');</script>
<!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coming Soon 2</title>

    <!-- Style CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/fonts/jost/stylesheet.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/line-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}"/>

    <!-- jQuery -->
    <script src="js/jquery-1.12.4.js"></script>
    <script src="libs/popper/popper.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="libs/slick/slick.min.js"></script>
    <script src="libs/slick/jquery.zoom.min.js"></script>
    <script src="libs/isotope/isotope.pkgd.min.js"></script>
    <script src="libs/quilljs/js/quill.core.js"></script>
    <script src="libs/quilljs/js/quill.js"></script>
    <script src="libs/chosen/chosen.jquery.min.js"></script>
    <!-- orther script -->
    <script src="js/main.js"></script>
</head>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NC9L3JG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@yield('main')

</html>