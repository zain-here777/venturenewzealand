@extends('frontend.layouts.template')
@php
    
    if($slug=='faqs'){
        $page_title_bg = "style='background-image:url(/assets/images/faq-image.png)'";
    }else if($slug='about-us'){
        $page_title_bg = "style='background-image:url(/assets/images/about-03.jpg)'";
    }else{
        $page_title_bg = "style='background-image:url(/assets/images/about-01.png)'";
    }

@endphp
@section('main')
    <main id="main" class="site-main">
        
        <div class="site-content">
        <div class="page-title page-title--small align-left mb-5 @if($blog_title_bg) background-image @endif"  {!! $page_title_bg !!}>
            <div class="container">
                <div class="page-title__content">
                    <h1 class="page-title__name">{{$post->title}}</h1>
                </div>
            </div>          
        </div><!-- .page-title -->
            <div class="container">

                {!! $post->content !!}

            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop