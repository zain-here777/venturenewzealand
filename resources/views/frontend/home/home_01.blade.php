@php
$img_home_banner = getImageUrl(setting('home_banner'));
$img_home_banner_app = getImageUrl(setting('home_banner_app'));
if (setting('home_banner')) {
$home_banner = "style=background-image:url({$img_home_banner})";
} else {
$home_banner = "style=background-image:url(/assets/images/top-banner.png)";
}
if (setting('home_banner_app')) {
$home_banner_app = "style=background-image:url({$img_home_banner_app})";
} else {
$home_banner_app = "style=background-image:url(/assets/images/banner-apps.jpg)";
}
@endphp
@extends('frontend.layouts.template')
@section('main')
@include('frontend.common.toastr-alert')
@include('frontend.common.new_user_plan')

<style>
    @font-face {
        font-family: 'Playlist';
        src: url('fonts/Playlist Script.otf');
        font-weight: normal;
    }

    .site-header {
        padding: 20px 0;
        background: transparent;
    }

    .site {
        justify-content: start;
    }

    .right-header__destinations a {
        color: #fff;
    }

    .account a {
        color: #fff;
    }

    .site-header.fixed .right-header__destinations a,
    .site-header.fixed .account a {
        color: #000;
    }

    .right-header__login a {
        color: #fff;
    }

    .site__menu>a i,
    .right-header .right-header__search i {
        color: #fff;
    }

    .cloudbar i,
    .cart-icon i {
        color: #FFF;
    }

    .notification_bar i,
    .notification_bar i:hover {
        font-size: 26px !important;
        vertical-align: middle;
        color: #fff;
    }

    header.fixed .cloudbar i,
    header.fixed .cloudbar i:hover,
    header.fixed .cart-icon i {
        color: #000;
    }

    .section-one {
        color: white;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .section-one h2 {
        font-size: 50px;
        color: white;
        font-weight: 800;
        margin-left: 13px;
    }
    .dollar-div{
        width: 250px;
        /* background-color: red; */
    }

    .sup-style {
       
        font-size: 25px !important;
        top: -20px;
        left: 10px;
    }

    .section-one h2 sub {
        font-size: 25px !important;
        bottom: 0;
       

    }

    .section-one h1 {
        font-size: 80px;
        color: white;
        font-weight: 800;
    }

    .section-one span {
        color: white;
        font-weight: bolder;
        font-size: 25px;
    }

    .section-one p {
        font-size: 14px;
        text-align: left;
    }

    .section-one sup {
        font-size: 20px;
    }

    .slider-container {
        overflow: hidden;
        width: 100%;
        max-width: 1024px;
        margin: auto;
        position: relative;
        margin-top: 50px;
    }

    .slider-wrapper {
        display: flex;
        transition: transform 0.5s ease;
    }

    .slide {
        min-width: 100%;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 60px;
        color: white;
        height: 300px;
        font-family: 'Playlist';
    }

    .slide img {
        height: 300px;
        position: relative;
    }

    .sign {
        font-family: 'Playlist' !important;
        transform: rotate(-10deg);
        text-align: left;
        white-space: nowrap;
        font-size: 50px !important;
        margin-left: -20px !important;
        font-weight: 400 !important;
    }

    .slide h3 {
        position: absolute;
    }

    .slide h3 {
        font-size: 40px;
        font-family: 'Playlist' !important;
    }

    .slide .overlay {
        height: 300px !important;
        background-color: red !important;
        position: absolute !important;
    }
    .main {
        padding: 30px 10px;
    }

    .navigation {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
    }

    .arrow i {
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 10px;
    }

    .land-button {
        padding: 10px;
        background-color: #72bf44;
        border-radius: 6px;
        color: white;
        outline: none;
        border: none;
        width: 100px;
        height: 39px;
        margin-top: 20px;
    }

    .land-button:hover {
        background-color: white;
        color: #72bf44;
        border: 1px solid #72bf44;
        outline: none;
        font-weight: 600;
    }

    .grid-container {
        display: grid;
        padding: 1px;
        grid-template-columns: 1fr 1fr 1fr;
        border-radius: 10px;
        margin-top: 50px;
        gap: 10px;
    }

    .grid-item {
        perspective: 1000px;
        height: 100px;
    }

    .grid-item img {
        height: 150px !important;
        background-position: center;
        background-size: cover;
        border-radius: 6px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        border-radius: 6px;
    }

    .flip-card-front {
        font-family: 'Playlist';
        font-size: 30px;
    }

    .flip-card-front,
    .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        box-sizing: border-box;
    }

    .flip-card-front .overlay {
        position: absolute;
        border-radius: 6px;
        opacity: 50%;
        height: 150px;
        width: 100%;
        z-index: 2;
    }

    .flip-card-back {
        background-color: #4054B2 !important;
        color: white !important;
    }

    .flip-card-back h1 {
        font-size: 15px;
        color: white !important;
    }

    .flip-card-back p {
        font-size: 12px;
        color: white !important;
    }

    .flip-card-back button {
        padding: 5px;
        background-color: transparent;
        border: 2px solid white;
        color: white;
        white-space: nowrap;
    }

    .overlay-one {
        background-color: red !important;
    }

    .overlay-two {
        background-color: skyblue;
    }

    .overlay-three {
        background-color: purple;
    }

    .overlay-four {
        background-color: orange;
    }

    .overlay-five {
        background-color: yellow;
    }

    .overlay-six {
        background-color: green;
    }

    .flip-card-front h3 {
        position: absolute;
        font-family: 'Playlist' !important;
        font-size: 30px;
        z-index: 5;
        color: white !important;
    }

    .flip-card-back {
        background-color: #f1f1f1;
        padding: 10px;
        transform: rotateY(180deg);
    }

    .site-banner__content {
        margin-top: -850px !important;
    }

    .place_thumb_price_2 {
        height: 58px !important;
        margin-top: 23px;
        font-size: 26px;
    }

    .site-banner.video_banner {
        position: relative;
        height: 1300px !important;
    }

    .section-one {
        margin-top: 200px;
    }

    .section-one h4 {
        font-size: 16px;
        color: white;
        text-align: left;
    }

    .map-heading {
        font-size: 24px;
        color: #72bf44;
        position: absolute;
        top: 70px;
       
       
    }
    .map-text {
        font-size: 12px;
        color: black;
        position: absolute;
        top: 110px;
    }

    .explore-div{
        display: flex;
        justify-content: left;
        line-height: 40px;
        padding: 0 9%;
    }
   

    @media(min-width:340px){
        .explore-div{
            padding: 0 11%;
        }
    }

    @media(min-width:360px){
        .explore-div{
            padding: 0 13%;
        }
    }

    @media(min-width:380px){
        .explore-div{
            padding: 0 15%;
        }
    }

    @media(min-width:400px){
        .explore-div{
            padding: 0 18%;
        }
    }


   


    @media (min-width:420px) {
        .grid-container {
            grid-template-columns: 1fr 1fr 1fr;

        }
       
        .flip-card-back {
            gap: 10px;
        }
        .grid-item {
            height: 140px;
        }
        .site-banner__content {
            margin-top: -800px !important;
        }
        .map-heading {
            font-size: 28px;
            color: #72bf44;
           
        }
        .flip-card-front h3 {
            font-size: 40px;
        }
        .map-text {
            font-size: 15px;
            color: black;
            padding-left: 10px;
            
        }
        .explore-div{
            display: flex;
            justify-content: center;
        }
    }

    @media (min-width:481px) {
        .map-heading {
            font-size: 28px;
            top: 100px;
        }
        .map-text {
            font-size: 15px;
            top: 150px;
        }
        .dollar-div{
        margin-top: 10px ;
    }
    }

    @media (min-width:541px) {
       
        .dollar-div{
        margin-top: 20px ;
    }
    }

    @media (min-width:768px) {
       
       .dollar-div{
       margin-top: 30px ;
   }
   }

    @media (min-width: 800px) {
        .section-one h2 {
            font-size: 68px;
        }
        .section-one span {
            font-size: 34px;
        }
        .grid-container {
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
            width: 100%;
        }
        .sign {
            font-size: 80px !important;
        }
        .section-one h2 sub {
            font-size: 40px !important;
        }
        .section-one h4 {
            font-size: 30px;
        }
        .section-one p {
            font-size: 18px;
        }
        .flip-card-back {
            gap: 5px;
        }
        .site-banner__content {
            margin-top: -800px !important;
        }
        .map-heading {
            font-size: 40px;
            white-space: nowrap;
            color: #72bf44;
            position: absolute;
            /* top: 50px; */
        }
        .map-text {
            font-size: 20px;
            color: black;
            position: absolute;
            padding-left: 0;
            padding-right: 10px;
            white-space: nowrap;
            /* top: 110px; */
        }
        .dollar-div{
       width: 350px;
       padding-left: 35px;
   }
   .sup-style{
    top: -30px;
   }
    }


    @media (min-width:992px) {
       .dollar-div{
        padding-left: 40px;
        width: 370px;
        margin-top: 40px;
        
       }
    }

    @media (min-width: 1024px) {
        .main {
            padding-left: 80px;
            padding-right: 80px;
        }
        .section-one {
            align-items: flex-start;
            margin-top: 0px;
            gap: 20px;
        }
        .section-one h2 {
            text-align: left;
        }
        .section-one p {
            text-align: left;
        }
        .slider-container {
            display: none;
        }
        .site-banner.video_banner {
            position: relative;
            height: 1500px !important;
        }
        .section-one p {
            width: 600px;
        }
        .section-one h4 {
            width: 600px;
            text-align: left;
        }
        .sign-hero {
            margin-top: -600px  !important ;
        }
        /* .map-heading .map-text {
        margin-left: 100px;
    } */
   
     .map-heading {
          
            top: 110px;
        }
        .map-text {
          
            top: 165px;
        }
 .dollar-div{
    margin-top: 0px;
 }
    }
</style>

{{-- <img src="{{ asset('images/homepage-placeholder-1.jpg') }}"/> --}}

<main id="main" class="exclude-class site-main">
    <div class="exclude-class site-banner video_banner">
        <div class="exclude-class video-foreground embed-responsive embed-responsive-16by9">
            @isset($home_page_video_link)

            <video class="lazy exclude-class" autoplay muted loop playsinline>
                <source src="/videos/old_new_finally_high_bitrate.mp4"  class="exclude-class" type="video/mp4">
                <source src="/videos/old_new_finally_high_bitrate.mp4"  class="exclude-class" type="video/mp4">
            </video>
            {{-- <video autoplay="" muted="false" id="myVideo" loop=""
                 playsinline>
                <source src="/videos/old_new_finally_high_bitrate" class="exclude-class" type="video/mp4">
            Your browser does not support HTML5 video.
            </video> --}}
            @else
            <video autoplay="" muted="false" id="myVideo" loop="" playsinline>
                <source src="{{ asset('videos/video1658750472.mp4') }}" class="exclude-class" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
            @endisset
        </div>
    </div><!-- .site-banner -->
    <div class="explore">
        <div class="main container">
            @guest
            <div class="site-banner__content sign-hero landing   ">
                <section class="section-one ">
                    <h2 id="sign-hero" class="sign">Sign Up Today</h2>
                    <h2 class="dollar-div"> <sup class="sup-style">$</sup> 39 <sub >Per Year</sub></h2>
                    <h4 class="be-vietnam-pro-bold ">Find Local Business, Book Trips,
                        Win Prizes, and Scan Your Way Around NZ</h4>
                    <p class="be-vietnam-pro-regular">Venture New Zealand is the first directory of its kind. Seperating New Zealands regions and districts and listing everything in one place to help consumers streamline their travel plans.</p>
                    <button class="land-button">Sign Up</button>
                </section>
                <!-- <div class="slider-container">
                    <div class="slider-wrapper">
                        <div class="slide" >
                        <img style="width: 100%;" src="/images/one.jpg"/>
                                <div class="overlay overlay-one">
                               
                                </div>
                                <h3>Eat</h3>
                        </div>
                        <div class="slide" style="background-color: lightblue;">Slide 2</div>
                        <div class="slide" style="background-color: lightgreen;">Slide 3</div>
                        <div class="slide" style="background-color: lightpink;">Slide 4</div>
                        <div class="slide" style="background-color: yellow;">Slide 5</div>
                    </div>
                    <div class="navigation">
                        <span class="arrow" id="prev" onclick="prevSlide()"> <i class="far fa-chevron-left"></i></span>
                        <span class="arrow" id="next" onclick="nextSlide()"><i class="far fa-chevron-right"></i></span>
                    </div>
                </div> -->
                <div class="grid-container">
                    <div class="grid-item">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img style="width: 100%;" src="/images/Eat-Image.png" />
                                <div class="overlay ">
                                </div>
                                <h3>Eat</h3>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img style="width: 100%;" src="/images/Play-Image.png" />
                                <div class="overlay ">
                                </div>
                                <h3>Play</h3>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item full-width">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img style="width: 100%;" src="/images/Stay-Image.png" />
                                <div class="overlay ">
                                </div>
                                <h3>Stay</h3>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img style="width: 100%;" src="/images/Travel-Image.png" />
                                <div class="overlay">
                                </div>
                                <h3>Travel</h3>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img style="width: 100%;" src="/images/Rent-Image.png" />
                                <div class="overlay ">
                                </div>
                                <h3>Rent</h3>
                            </div>
                        </div>
                    </div>
                    <div class="grid-item">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img style="width: 100%;" src="/images/See-Image.png" />
                                <div class="overlay">
                                </div>
                                <h3>See</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div  class="site-banner__content golo-ajax-search search-hero">
            <h1 id="login-hero"  class="site-banner__title">{{__('Discover amazing things to do everywhere you go!')}}</h1>
            <form action="{{route('page_search_listing')}}" class="site-banner__search">
                <div class="site-banner__search__field">
                    <span class="site-banner__search__icon">
                        <i class="la la-search la-24"></i>
                    </span><!-- .site-banner__search__icon -->
                    <input class="site-banner__search__input" type="text" name="keyword" placeholder="{{__('Type a district or location')}}" autocomplete="off">
                    <div class="search-result"></div>
                    <div class="golo-loading-effect"><span class="golo-dual-ring"></span></div>
                </div><!-- .site-banner__search__input -->
            </form><!-- .site-banner__search -->
        </div><!-- .site-banner__content -->
    </div>
    <div class="container explore_container">
        <div class="slick-sliders offset-item animate">
        </div>
        @endguest
    </div>
    </div><!-- .business-category -->
    <!-- Destination on Map -->
    <div class="destination_map">
        <div class="destination_map_img">
            <img src="{{asset('assets/images/nz.svg')}}" style=" position:absolute; margin-top:315px;" class="map_mobile_not_show" />
            <div style="position:absolute; left:3%; font-size:16px; color:#72bf44;" class="map_mobile_show map_northisland be-vietnam-pro-bold">North Island</div>
            <img src="{{asset('assets/images/North Island.svg')}}" style=" position:absolute; left:23%; " class="map_mobile_show map_northisland_img" />
            <img src="{{asset('assets/images/South Island.svg')}}" style="position:absolute; left:22%;" class="map_mobile_show map_southisland_img" />
<div class="explore-div">
<div class="map-heading be-vietnam-pro-bold">Explore New Zealand</div>
<div class="map-text ">See what is available throughout New Zealand.<br />Select a region to explore!</div>
</div>
            <div style="position: absolute; left:3%; font-size:16px; color:#72bf44;" class="map_mobile_show map_northisland be-vietnam-pro-bold">North Island</div>
            <div style="position: absolute; left:3%; font-size:16px; color:#72bf44;" class="map_mobile_show map_southisland be-vietnam-pro-bold">South Island</div>
            @php
            $i = 1;
            @endphp
            @foreach ($arrLocations as $location)
            <div class="{{ $location['class'] }} {{ strpos($location['type'], 'top') === false  ? 'flex' : '' }}">
                @if ($location['type'] == 'right')
                <div class="btn-group">
                    <a style="border-radius: 6px 0px 0px 6px!important;" class="btn btn-secondary btn-sm" type="button" href="{{ route('region_detail', $location['slug']) }}">
                        @if (strpos($location['name'], '-') === false)
                        {{ $location['name'] }}
                        @else
                        {{ substr($location['name'], 0, strpos($location['name'], '-')) }}
                        @endif
                    </a>
                    <button type="button" style="border-radius: 0px 6px 6px 0px!important; " class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($location['cities'] as $city)
                        <a class="dropdown-item" href="{{ route('city_detail', $city->slug) }}">
                            {{ $city->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="destination_map_dropdown_pointer_horizontal flex">
                    <div class="pointer_horizontal" style="background-color:#72bf44"></div>
                    <a href="{{ route('region_detail', $location['slug']) }}">
                        <div style="width:11px; height:11px; background-color:#72bf44; border-radius:50%;"></div>
                    </a>
                </div>
                @elseif ($location['type'] == 'left')
                <div class="destination_map_dropdown_pointer_horizontal flex">
                    <a href="{{ route('region_detail', $location['slug']) }}">
                        <div style="width:11px; height:11px; background-color:#72bf44; border-radius:50%;"></div>
                    </a>
                    <div class="pointer_horizontal" style="background-color:#72bf44"></div>
                </div>
                <div class="btn-group">
                    <a style="border-radius: 6px 0px 0px 6px!important;" class="btn btn-secondary btn-sm" type="button" href="{{ route('region_detail', $location['slug']) }}">
                        @if (strpos($location['name'], '-') === false)
                        {{ $location['name'] }}
                        @else
                        {{ substr($location['name'], 0, strpos($location['name'], '-')) }}
                        @endif
                    </a>
                    <button style="border-radius: 0px 6px 6px 0px!important; " type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($location['cities'] as $city)
                        <a class="dropdown-item" href="{{ route('city_detail', $city->slug) }}">
                            {{ $city->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @elseif ($location['type'] == 'top-right')
                <div class="btn-group">
                    <a style="border-radius: 6px 0px 0px 6px!important;" class="btn btn-secondary btn-sm" type="button" href="{{ route('region_detail', $location['slug']) }}">
                        @if (strpos($location['name'], '-') === false)
                        {{ $location['name'] }}
                        @else
                        {{ substr($location['name'], 0, strpos($location['name'], '-')) }}
                        @endif
                    </a>
                    <button style="border-radius: 0px 6px 6px 0px!important; " type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($location['cities'] as $city)
                        <a class="dropdown-item" href="{{ route('city_detail', $city->slug) }}">
                            {{ $city->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="destination_map_dropdown_pointer_vertical" style="margin-left:45px;">
                    <div class="pointer_vertical" style="background-color:#72bf44"></div>
                    <a href="{{ route('region_detail', $location['slug']) }}" style="width: 11px; display: block; margin: auto;">
                        <div style="width:11px; height:11px; background-color:#72bf44; border-radius:50%;"></div>
                    </a>
                </div>
                @else
                <div class="btn-group">
                    <a style="border-radius: 6px 0px 0px 6px!important;" class="btn btn-secondary btn-sm" type="button" href="{{ route('region_detail', $location['slug']) }}">
                        @if (strpos($location['name'], '-') === false)
                        {{ $location['name'] }}
                        @else
                        {{ substr($location['name'], 0, strpos($location['name'], '-')) }}
                        @endif
                    </a>
                    <button style="border-radius: 0px 6px 6px 0px!important; " type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($location['cities'] as $city)
                        <a class="dropdown-item" href="{{ route('city_detail', $city->slug) }}">
                            {{ $city->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="destination_map_dropdown_pointer_vertical" style="width: 50%; margin: 0;">
                    <div class="pointer_vertical" style="background-color:#72bf44"></div>
                    <a href="{{ route('region_detail', $location['slug']) }}" style="width: 11px; display: block; margin: auto;">
                        <div style="width:11px; height:11px; background-color:#72bf44; border-radius:50%;"></div>
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div class="trending trending-business">
        <div class="container">
            <h2 class="title title-border-bottom align-center">{{__('Highlights in New Zealand')}}</h2>
            <div class="slick-sliders">
                <div class="slick-slider trending-slider slider-pd30" data-autoplay="true" data-item="4" data-arrows="true" data-itemScroll="1" data-dots="true" data-centerPadding="30" data-tabletitem="3" data-tabletscroll="2" data-smallpcscroll="3" data-smallpcitem="3" data-mobileitem="1" data-mobilescroll="1" data-mobilearrows="false">

                    @foreach($trending_places as $place)
                    <div class="place-item layout-02">
                        <div class="place-inner">
                            <div class="place-thumb">
                                <a class="entry-thumb" href="{{route('place_detail', $place->slug)}}">
                                    <img src="{{getImageUrl($place->thumb)}}" alt="{{$place->name}}">
                                    <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); "></div>
                                    <div style="height: 80px;" class="row place_thumb_desription">
                                        @php
                                        $logo = $place->logo != null ? getImageUrl($place->logo) : null;
                                        @endphp

                                        @if ($logo !== null)
                                        <div class="place_thumb_logo">
                                            <img src="{{$logo}}" alt="logo" class="custom-img-height">
                                        </div>
                                        <div class="place_thumb_price_1" style="background-color:{{$place['categories'][0]['color_code']}};">
                                            @if($place['categories'][0]['slug'] !== "see")
                                            <div>
                                                <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                    <div class="treding_price_small">from</div>
                                                    <div class="treding_price_big"> {{ $place->getPlacePrice() }}</div>
                                                    <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
                                                </div>
                                                <div style="color: #FEFEFE; font-size:12px;">
                                                    @if ($place['categories'][0]['pricing_text'] !== null)
                                                    {{ $place['categories'][0]['pricing_text'] }}
                                                    @endif
                                                </div>
                                            </div>
                                            @else
                                            <div style="color: #FEFEFE; font-size:28px; text-align:center;">Free</div>
                                            @endif
                                        </div>
                                        @else
                                        <div style="display:hidden;"></div>
                                        <div class="place_thumb_price_2" style="background-color:{{$place['categories'][0]['color_code']}};">
                                            @if($place['categories'][0]['slug'] !== "see")
                                            <div>
                                                <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                    <div class="treding_price_small">from</div>
                                                    <div class="treding_price_big">{{ $place->getPlacePrice() }} </div>
                                                    <div class="treding_price_small">NZD</div>
                                                </div>
                                                <div style="color: #FEFEFE; font-size:12px;">
                                                    @if ($place['categories'][0]['pricing_text'] !== null)
                                                    {{ $place['categories'][0]['pricing_text'] }}
                                                    @endif
                                                </div>
                                            </div>
                                            @else
                                            <div  style="color: #FEFEFE; font-size:28px">Free</div>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </a>
                                <a data-tooltip="Favourite" data-position="left" href="#" class="golo-add-to-wishlist btn-add-to-wishlist @if($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif" data-id="{{$place->id}}" data-color="{{$place['categories'][0]['color_code']}}" @if($place->wish_list_count) style="background-color:{{$place['categories'][0]['color_code']}};" @endif>
                                    <span class="icon-heart">
                                        @if($place->wish_list_count)
                                        <i class="fas fa-bookmark"></i>
                                        @else
                                        <i class="far fa-bookmark"></i>
                                        @endif
                                    </span>
                                </a>
                                @if(isset($place['categories'][0]))
                                <a class="entry-category rosy-pink" href="{{route('page_search_listing', ['category[]' => $place['categories'][0]['id']])}}">
                                    <img src="{{getCategoryIcon($place['categories'][0]['icon_map_marker'],$place['categories'][0]['icon_map_marker'])}}" alt="{{$place['categories'][0]['name']}}">
                                </a>
                                @endif
                            </div>
                            <div class="entry-detail">
                                <h3 class="place-title">
                                    <a href="{{route('place_detail', $place->slug)}}">{{$place->name}}</a>
                                </h3>

                                <div class="entry-head">
                                    <div class="place-type list-item">
                                        @foreach($place['place_types'] as $type)
                                        <span>{{$type->name}}</span>
                                        @endforeach
                                    </div>
                                    <div class="place-city">
                                        <a href="{{route('page_search_listing', ['city[]' => $place['city']['id']])}}">{{$place['city']['name']}}</a>
                                    </div>
                                </div>

                                <div class="entry-bottom">
                                    <div class="place-preview">
                                        <span class="count-reviews">({{$place->reviews_count}} {{__('reviews')}})</span>
                                        <div class="place-rating">
                                            @if($place->reviews_count)
                                            <!-- {{number_format($place->avgReview, 1)}} -->
                                            @for($i = 0; $i < 5 - round($place->avgReview); $i++)
                                                <i class="far fa-star" style="color:#414141;"></i>
                                                @endfor
                                                @for($i = 0; $i < round($place->avgReview); $i++)
                                                    <i class="fas fa-star" style="color:#febb02;"></i>
                                                    @endfor
                                                    @else
                                                    @for($i = 0; $i < 5; $i++) <i class="far fa-star" style="color:#414141;"></i>
                                                        @endfor
                                                        @endif
                                        </div>
                                    </div>
                                    <div class="place-price">
                                    </div>
                                </div>
                                <a href="{{route('place_detail', $place->slug)}}" class="TrendingReadMoreButton " style="background-color:{{$place['categories'][0]['color_code']}}; border-radius:6px ; height:40px">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="place-slider__nav slick-nav trending_slick_nav">
                    <div class="place-slider__prev slick-nav__prev">
                        <i class="fas fa-caret-left"></i>
                    </div><!-- .place-slider__prev -->
                    <div class="place-slider__next slick-nav__next">
                        <i class="fas fa-caret-right"></i>
                    </div><!-- .place-slider__next -->
                </div><!-- .place-slider__nav -->
            </div>
        </div>
    </div><!-- .trending -->

    <div class="cities">
        <div class="container">
            <h2 class="cities__title title title-border-bottom align-center">{{__('Popular Districts')}}</h2>
            <div class="slick-sliders">
                <div class="slick-slider cities-slider slider-pd30" data-autoplay="true" data-item="4" data-arrows="true" data-itemScroll="1" data-dots="true" data-centerPadding="30" data-tabletitem="3" data-tabletscroll="2" data-smallpcscroll="3" data-smallpcitem="3" data-mobileitem="1" data-mobilescroll="1" data-mobilearrows="false">
                    @foreach($popular_cities as $city)
                    <div class="cities__content_li">
                        <a href="{{route('city_detail', $city->slug)}}">
                            <div class="cities__item hover__box">
                                <div class="cities__thumb hover__box__thumb">
                                    <img src="{{getImageUrl($city->thumb)}}" alt="{{$city->name}}">
                                    <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;"></div>
                                </div>
                                <div class="cities__capital_name">
                                    <h3 class="cities__capital">{{$city->name}}</h3>
                                    <h4 class="cities__name">{{$city['country']['name']}}</h4>
                                </div>
                                <div class="cities_rotoruamap">
                                    @php
                                    if($city->map_tile){
                                    $tilemapurl = 'uploads/city/map/' . $city->map_tile;
                                    } else {
                                    $tilemapurl = 'assets/images/DefaultCityMap_tile.svg';
                                    }
                                    @endphp
                                    <img src="{{ asset($tilemapurl) }}" />
                                </div>
                                <div class="cities__info">
                                    <p class="cities__number">{{$city->places_count}} {{__('Places')}}</p>
                                </div>
                            </div><!-- .cities__item -->
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="place-slider__nav slick-nav cities_slick_nav">
                    <div class="place-slider__prev slick-nav__prev">
                        <i class="fas fa-caret-left"></i>
                    </div><!-- .place-slider__prev -->
                    <div class="place-slider__next slick-nav__next">
                        <i class="fas fa-caret-right"></i>
                    </div><!-- .place-slider__next -->
                </div><!-- .place-slider__nav -->
            </div>
        </div>
    </div><!-- .cities -->

    <!-- Competition section -->
    @if($competition!=null)
    <div class="competition_wrapper">
        @if($competition->background_image)
        <img src="{{asset('uploads/'.$competition->background_image)}}" class="ftbg">
        @endif
        <div class="container">
            <div class="competition_inside">
                <h2 class="title title-border-bottom align-center">{{ __('Participate in competitions to win awesome prizes!') }}
                </h2>
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="comp_title">
                            <div class="competition_banner">
                                <h2>{{$competition->title}}</h2>
                            </div>
                            <p>{{$competition->description}}</p>
                            <div class="box-div">
                                <div class="title_inside">
                                    <p class="small_title"><b>Entry Fee Points:</b>
                                        {{cleanDecimalZeros($competition->entry_fee_points)}}
                                    </p>
                                </div>
                                <a href="{{ route('competition_details') }}" class="btn">View more details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="comp_imagebg">
                            <img src="assets/images/vector.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="banner-apps" {{$home_banner_app}}>
        <div class="container">
            <div class="banner-apps__content p-0">
                <h2 class="banner-apps__title">{{__('Venture New Zealand app coming soon!')}}</h2>
                <p class="banner-apps__desc">{{__('Enjoy the wonder of discovery!')}}</p>
                <div class="banner-apps__download">
                    <a title="App Store" href="#" class="banner-apps__download__iphone"><img src="{{asset('assets/images/assets/app-store.png')}}" alt="App Store"></a>
                    <a title="Google Play" href="#" class="banner-apps__download__android"><img src="{{asset('assets/images/assets/google-play.png')}}" alt="Google Play"></a>
                </div>
            </div>
        </div>
    </div><!-- .banner-apps -->

    <!--hilighted product-->
    @if(count($highlightedProducts) > 0)
    <section class="highlighted-slider">
        <div class="container">
            <h2 class="cities__title title">Popular Products</h2>
            <div class="position-relative">
                <div class="explore-slider2 slider-pd30 slick-slider slick-dotted">
                    @foreach($highlightedProducts as $k=> $product)
                    @php
                    $slugurl = $product->product->place->slug??null;
                    $slugurl = $slugurl == null ? '#' : route('place_detail', $product->product->place->slug);
                    @endphp
                    <div class="place-item layout-02">
                        <div class="place-inner">
                            <div class="place-thumb">
                                <a class="entry-thumb" href="{{$slugurl}}" tabindex="0"><img src="{{$product->product->thumb}}" alt="{{$product->product->name}}"></a>
                                <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4);"></div>
                            </div>
                            <div class="entry-detail">
                                <div class="entry-head">
                                    <div class="place-type list-item">
                                        <span>{{$product->product->place->name?? '-'}}</span>
                                    </div>
                                    <h3 class="place-title"><a href="{{$slugurl}}" tabindex="0">{{$product->product->name}}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="explore-slider__nav slick-nav"></div>
            </div>
        </div>
    </section>
    @endif


    <div class="news">
        <div class="container">
            <h2 class="news__title title title--more">
                {{__('Related stories')}}
                <a href="{{route('post_list_all')}}" title="{{__('View more')}}">
                    {{__('View more')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="10" viewBox="0 0 6 10">
                        <path fill="#72bf44" fill-rule="nonzero" d="M5.356 4.64L.862.148A.503.503 0 1 0 .148.86l4.137 4.135L.148 9.132a.504.504 0 1 0 .715.713l4.493-4.492a.509.509 0 0 0 0-.713z" />
                    </svg>
                </a>
            </h2>
            <div class="news__content">
                <div class="row">
                    @foreach($blog_posts as $post)
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6 news__content_li">
                        <article class="post hover__box">
                            <div class="post__thumb hover__box__thumb">
                                <a title="{{$post->title}}" href="{{route('post_detail', [$post->slug, $post->id])}}"><img src="{{getImageUrl($post->thumb)}}" alt="{{$post->title}}"></a>
                            </div>
                            <div class="post__info">
                                <ul class="post__category">
                                    @foreach($post['categories'] as $cat)
                                    <li><a title="{{$cat->name}}" href="{{route('post_list', $cat->slug)}}">{{$cat->name}}</a></li>
                                    @endforeach
                                </ul>
                                <h3 class="post__title"><a title="{{$post->title}}" href="{{route('post_detail', [$post->slug, $post->id])}}">{{$post->title}}</a>
                                </h3>
                            </div>
                        </article>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div><!-- .news -->
</main><!-- .site-main -->


@stop


@push('scripts')
<script src="{{ asset('assets/js/page_home.js') }}"></script>
@endpush