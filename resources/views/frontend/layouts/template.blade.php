<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="exclude-class">

<head>
    <!-- Google Tag Manager -->
    <script src="{{ asset('assets/js/template_frontend/head1.js') }}"></script>
    <!-- End Google Tag Manager -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @if(config('app.env') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-MFTCTE7NF0"></script>
        <script src="{{ asset('assets/js/template_frontend/head2.js') }}"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
    @endif
    <meta charset="utf-8">
    {!! SEO::generate() !!}
    <meta name="facebook-domain-verification" content="crt7ue3ib307wmp8mqxxs9diwmtrot"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/jost/stylesheet.css') }}"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/slick/slick-theme.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/quilljs/css/quill.bubble.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/quilljs/css/quill.core.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/quilljs/css/quill.snow.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/chosen/chosen.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/photoswipe/photoswipe.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/fontawesome-pro/css/fontawesome.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/photoswipe/default-skin/default-skin.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/lity/lity.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/gijgo/css/gijgo.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/video.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chatbox.css') }}"/>

    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @yield('style')
    {{--dataTables--}}
    <link href="{{asset('/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/chosen/chosen.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    {{-- Pnotify --}}
    <link href="{{asset('/admin/vendors/pnotify/dist/pnotify.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/vendors/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/vendors/pnotify/dist/pnotify.nonblock.css')}}" rel="stylesheet">

    @if (setting('style_rtl'))
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style-rtl.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive-rtl.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-rtl.css?v=1.0') }}"/>
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}"/>
    @endif
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.css') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('/admin/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <link rel="icon" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <link href="{{ asset('assets/css/veitnamFont.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/js/template_frontend/head3.js') }}"></script>
    @stack('style')
</head>
<style>
    /* .cross_button{
        background-color: white;
        border:1px solid #72BF44;
        color: #72BF44;
        border-radius: 6px;

    }
    .cross_button:hover{
        background-color: #72BF44;
        border:1px solid #72BF44;
        color: white;
    } */
    .btn {
        border-radius: 6px;
    }

    @media (min-width: 480px) {
        .cross_button {
            margin-top: -45px;
            margin-right: -8px;
        }
    }

</style>

<body dir="{{ !setting('style_rtl') ?: 'rtl' }}" class="exclude-class">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NC9L3JG" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="wrapper" class="exclude-class">
    <div class="html-marquee" style="top:-48px;">

        <div class="time_marquee">
            @foreach ($city_weathers as $city)
                <div class="marquee_value">
                    <div class="zone_image"><img src="{{ $city->icon_url }}"></div>
                    <div class="text">
                        <p class="city_name1">{{ $city->city_name }}</p>
                        <p class="temp">{{ $city->temprature_phrase }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <header id="header" class="site-header exclude-class" style="top:0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-7 col-4 p-0">
                    <div class="site">
                        <div class="site__menu">
                            <a title="Menu Icon" href="#" class="site__menu__icon">
                                <i class="la la-bars la-24"></i>
                            </a>
                            <div class="popup-background"></div>
                            <div class="popup popup--left">
                                <a title="Close" href="#" class="popup__close cross_button">
                                    <i class="la la-times la-24"></i>
                                </a>  <!-- .popup__close -->


                                <input type="hidden" id="LoginOrSingup">
                                <input type="hidden" id="social_url_hidden" value="">
                                <div class="popup__content">


                                    @guest
                                        <div class="popup__user popup__box open-form">
                                            <a title="Login" href="#" class="login-dialog" data-toggle="modal"
                                               onclick="userTypePopup('Login')">{{ __('Login') }}</a>
                                            <!-- <a title="Sign Up" class="signin-dialog" href="#" data-toggle="modal"
                                                    onclick="userTypePopup('singUp')">{{ __('Join Now') }}</a> -->

                                            <img
                                                style="position:absolute ; top:10px ; left:20px ; z-index: 2 ;border-radius:1px ; margin-bottom:10px ; margin-top:5px; height:30px;"
                                                src="/images/favicon.png" alt="">

                                        </div>
                                    @else
                                        <div class="account">
                                            <a href="#" title="{{ Auth::user()->name }}">
                                                <img src="{{ getUserAvatar(user()->avatar) }}"
                                                     alt="{{ Auth::user()->name }}">
                                                <!-- <span>



                                                                                                                {{ Auth::user()->name }}
                                                <i class="la la-angle-down la-12"></i>
                                            </span> -->
                                            </a>


                                            <div style="margin-top: 20px;" class="account-sub">


                                                <ul>
                                                    <li class="{{ isActiveMenu('user_profile') }}"><a
                                                            class="be-vietnam-pro-bold"
                                                            href="{{ route('user_profile') }}">{{ __('Profile') }}</a>
                                                    </li>
                                                    @if (isUserHaveMembership() && isUserUser())
                                                        <li class="{{ isActiveMenu('competition_details') }}"><a
                                                                class="be-vietnam-pro-bold"
                                                                href="{{ route('competition_details') }}">{{ __('Competitions') }}</a>
                                                        </li>
                                                    @endif
                                                    <li class="{{ isActiveMenu('featured_products') }}"><a
                                                            class="be-vietnam-pro-bold"
                                                            href="{{ route('featured_products') }}">{{ __('Featured') }}</a>
                                                    </li>
                                                    @if (isUserHaveMembership() && isUserUser())
                                                        <li class="{{ isActiveMenu('near_by') }}"><a
                                                                class="be-vietnam-pro-bold"
                                                                href="{{ route('near_by') }}">{{ __('Near Me') }}</a>
                                                        </li>
                                                    @endif

                                                    @if (isOperatorUser())
                                                        <li class="my_company_menu {{ isActiveMenu('user_my_place') }}">
                                                            <a
                                                                class="be-vietnam-pro-bold"
                                                                href="{{ route('user_my_place') }}">{{ __('My Company') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (!isOperatorUser())
                                                        <li class="{{ isActiveMenu('user_wishlist') }}">
                                                            <a
                                                                class="be-vietnam-pro-bold"
                                                                href="{{ route('user_wishlist') }}">{{ __('Favourites') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (!isOperatorUser())
                                                        <li class="{{ isActiveMenu('user_product_wishlist') }}"><a
                                                                class="be-vietnam-pro-bold"
                                                                href="{{ route('user_product_wishlist') }}">{{ __('Wishlist') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (!isOperatorUser())
                                                        <li class="{{ isActiveMenu('booking_history') }}"><a
                                                                class="be-vietnam-pro-bold"
                                                                href="{{ route('booking_history') }}">{{ __('My Bookings') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (isOperatorUser() && !isUserAdmin())
                                                        <li class="{{ isActiveMenu('booking_list') }}"><a
                                                                class="be-vietnam-pro-bold"
                                                                href="{{ route('booking_list') }}">{{ __('Bookings') }}</a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="be-vietnam-pro-bold" href="{{ route('logout') }}"
                                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                                        <form class="d-none" id="logout-form"
                                                              action="{{ route('logout') }}" method="POST">

                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- .account -->

                                    @endguest

                                    <div class="popup__destinations popup__box">
                                        <ul class="menu-arrow">
                                            <li>
                                                <a class="be-vietnam-pro-bold" title="Destinations"
                                                   href="#">{{ __('Destinations') }}</a>

                                                <ul class="sub-menu">
                                                    <!-- Mobile/Responsive -->
                                                    @foreach ($regions as $region)
                                                        <li>
                                                            <a href="{{ route('region_detail', $region->slug) }}"
                                                               title="{{ $region->name }}"
                                                               class="dropdown_city_show be-vietnam-pro-semibold">
                                                                {{ $region->name }}
                                                                <i class="la la-angle-down la-12"></i>
                                                            </a>
                                                            <ul class="dropdown">
                                                                @foreach ($destinations as $city)
                                                                    @if ($city->country_id == $region->id)
                                                                        <li class="subs"><a
                                                                                href="{{ route('city_detail', $city->slug) }}"
                                                                                title="{{ $city->name }}">{{ $city->name }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>


                                        <!-- <ul class="menu-arrow">
                                            <li>
                                                <a title="Destinations" href="#">{{ __('Destinations') }}</a>
                                                <ul class="sub-menu">
                                                    @foreach ($destinations as $city)
                                            <li><a href="{{ route('city_detail', $city->slug) }}" title="{{ $city->name }}">{{ $city->name }}</a></li>





                                        @endforeach
                                        </ul>
                                    </li>
                                </ul> -->
                                    </div>

                                    <div class="popup__menu popup__box">
                                        <ul class="menu-arrow">
                                            @if (isOperatorUser())
                                                @if (checkPlaceCreateLimit())
                                                    <li>
                                                        <a title="Company Info"
                                                           href="{{ route('place_addnew') }}">Company
                                                            Info</a>
                                                    </li>
                                                @endif
                                                {{-- <li class="{{ isActiveMenu('user_my_place') }}">
                                                    <a href="{{ route('user_my_place') }}">
                                                        {{ __('My Company') }}
                                                    </a>
                                                </li> --}}
                                            @endif
                                            <li>
                                                <a class="be-vietnam-pro-bold" title="Home" href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li><a class="be-vietnam-pro-bold" title="Blog"
                                                   href="{{ route('post_list_all') }}">Blog</a></li>
                                            <li><a class="be-vietnam-pro-bold" title="Contacts"
                                                   href="{{ route('page_contact') }}">Contact</a>
                                            </li>
                                            @guest
                                                <li>
                                                    <a class="be-vietnam-pro-bold" title="how it works"
                                                       href="{{ route('how_it_works_user') }}">
                                                        {{ __('How it Works') }}</a>
                                                </li>
                                                <div style="display: flex; justify-content:center">
                                                    <a title="Sign Up" class="signin-dialog btn" href="#"
                                                       data-toggle="modal"
                                                       onclick="userTypePopup('singUp')">{{ __('Join Now') }}</a>
                                                </div>
                                            @endguest
                                        </ul>
                                    </div><!-- .popup__menu -->
                                </div><!-- .popup__content -->
                                <!-- Mobile/Responsive -->
                                @if (isOperatorUser())
                                    <!-- <div class="popup__button popup__box">
                                        <a class="btn" href="{{ route('place_addnew') }}">
                                            <i class="la la-plus la-24"></i>
                                            <span>{{ __('Add place') }}</span>
                                        </a>
                                    </div> -->
                                    <!-- .popup__button -->
                                @endif

                            </div><!-- .popup -->
                        </div><!-- .site__menu -->
                        <div class="site__brand exlude-class">
                            <!-- Conditions added to separate home page and other pages header view -->
                            @if (isRoute('home'))
                                <a title="Logo" href="{{ route('home') }}"
                                   class="site__brand__logo white_logo exclude-class"><img class="exclude-class"
                                                                                           src="{{ asset(setting('logo_white') ? 'uploads/' . setting('logo_white') : 'assets/images/assets/logo.png') }}"
                                                                                           alt="logo"></a>
                            @endif
                            <a title="Logo" href="{{ route('home') }}"
                               class="site__brand__logo black_logo exclude-class"
                               @unless(isRoute('home')) style="display:block" @endunless><img class="exclude-class"
                                                                                              src="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}"
                                                                                              alt="logo"></a>
                        </div><!-- .site__brand -->

                        @unless(isRoute('home'))
                            @if (setting('template', '01') == '01')
                                <div class="site__search golo-ajax-search">
                                    <a title="Close" href="#" class="search__close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             viewBox="0 0 16 16">
                                            <path fill="#5D5D5D" fill-rule="nonzero"
                                                  d="M9.3 8.302l6.157-6.156a.706.706 0 1 0-.999-.999L8.302 7.304 2.146 1.148a.706.706 0 1 0-.999.999l6.157 6.156-6.156 6.155a.706.706 0 0 0 .998.999L8.302 9.3l6.156 6.156a.706.706 0 1 0 .998-.999L9.301 8.302z"/>
                                        </svg>
                                    </a><!-- .search__close -->
                                    <form action="{{ route('search') }}" class="site__search__form" method="GET">
                                        <div class="site__search__field">
                                                <span class="site__search__icon">
                                                    <i class="la la-search la-24"></i>
                                                </span><!-- .site__search__icon -->
                                            <input class="site__search__input" type="text" name="keyword"
                                                   placeholder="{{ __('Search places ...') }}" autocomplete="off">
                                            <div class="search-result"></div>
                                            <div class="golo-loading-effect"><span class="golo-loading"></span></div>
                                        </div><!-- .search__input -->
                                    </form><!-- .search__form -->
                                </div><!-- .site__search -->
                            @else
                                <div class="site__search layout-02">
                                    <a title="Close" href="#" class="search__close">
                                        <i class="la la-times"></i>
                                    </a><!-- .search__close -->
                                    <form action="{{ route('page_search_listing') }}"
                                          class="site-banner__search layout-02">
                                        <div class="field-input">
                                            <label for="input_search">{{ __('Find') }}</label>
                                            <input class="site-banner__search__input open-suggestion" id="input_search"
                                                   type="text" name="keyword" placeholder="Ex: fastfood, beer"
                                                   autocomplete="off">
                                            <input type="hidden" name="category[]" id="category_id">
                                            <div class="search-suggestions category-suggestion">
                                                <ul>
                                                    <li><a href="#"><span>{{ __('Loading...') }}</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .site-banner__search__input -->
                                        <div class="field-input">
                                            <label for="location_search">{{ __('Where') }}</label>
                                            <input class="site-banner__search__input open-suggestion"
                                                   id="location_search" type="text" name="city_name"
                                                   placeholder="Your city" autocomplete="off">
                                            <input type="hidden" id="city_id">
                                            <div class="search-suggestions location-suggestion">
                                                <ul>
                                                    <li><a href="#"><span>{{ __('Loading...') }}</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .site-banner__search__input -->
                                        <div class="field-submit">
                                            <button><i class="las la-search la-24-black"></i></button>
                                        </div>
                                    </form><!-- .site-banner__search -->
                                </div>
                            @endif
                        @endunless

                    </div><!-- .site -->
                </div><!-- .col-md-6 -->


                <div class="col-xl-6 col-lg-6 col-md-5 col-8 p-0">
                    <div class="right-header align-right">
                        {{-- <div class="right-header__languages @if (Route::currentRouteName() != 'home') greenbg @endif">
                            <a href="#">
                                <img src="{{ flagImageUrl(\Illuminate\Support\Facades\App::getLocale()) }}">
                                @if (count($languages) > 1)
                                    <i class="fill-down-arrow"></i>
                                @endif
                            </a>
                            @if (count($languages) > 1)
                                <ul>
                                    @foreach ($languages as $language)
                                        @if (\Illuminate\Support\Facades\App::getLocale() !== $language->code)
                                            <li><a href="{{ route('change_language', $language->code) }}"
                                                    title="{{ $language->name }}"><img
                                                        src="{{ flagImageUrl($language->code) }}">{{ $language->name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div> --}}
                        @guest
                            <div
                                class="right-header__login custom-header-hover be-vietnam-pro-medium">
                                <a title="Featured" href="{{ route('how_it_works_user') }}">
                                    {{ __('How it Works') }}
                                </a>
                            </div>
                        @endguest

                        <div class="right-header__login custom-header-hover be-vietnam-pro-medium">
                            <a title="Featured" href="{{ route('featured_products') }}">
                                {{ __('Featured') }}
                            </a>
                        </div>

                        @if (isUserHaveMembership() && isUserUser())
                            <div class="right-header__login custom-header-hover be-vietnam-pro-medium">
                                <a title="Near Me" href="{{ route('near_by') }}">
                                    {{ __('Near Me') }}
                                </a>
                            </div>
                        @endif
                        <div class="right-header__destinations custom-header-hover be-vietnam-pro-medium">
                            <a title="Destinations" href="#" class="menu_title">
                                {{ __('Destinations') }}
                                <i class="la la-angle-down la-12"></i>
                            </a>
                            <div class="drop_menu">
                                <ul class="menu-arrow">
                                    <ul class="sub-menu">
                                        <!-- Desktop -->
                                        @foreach ($regions as $region)
                                            <li class="open_subdown">
                                                <a class="dropdown_city_show be-vietnam-pro-semibold"
                                                   title="{{ $region->name }}"
                                                   href="{{ route('region_detail', $region->slug) }}">
                                                    {{ $region->name }}
                                                    <i class="la la-angle-up la-12"></i>
                                                </a>
                                                <ul class="dropdown">
                                                    @foreach ($destinations as $city)
                                                        @if ($city->country_id == $region->id)
                                                            <li class="subs"><a
                                                                    href="{{ route('city_detail', $city->slug) }}"
                                                                    title="{{ $city->name }}">{{ $city->name }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </ul>
                            </div>
                        </div>
                        @guest
                            @if (Route::currentRouteName())
                                <div class="right-header__login custom-header-hover">
                                    {{-- <a href="#" onclick="userTypePopup('Login')">{{ __('Login') }}</a> --}}
                                    <a href="#" onclick="userTypePopup('Login')">{{ __('Login') }}</a>
                                </div><!-- .right-header__login -->
                            @endif


                            {{-- <div class="modal custom-modal popup-form" id="LoginSingUpModel" tabindex="-1"
                            aria-labelledby="faceBookLabel" aria-hidden="true"> --}}
                            <div class="popup popup-form custom-dialog modal" id="LoginSingUpModel" tabindex="-1"
                                 aria-labelledby="faceBookLabel" aria-hidden="true">
                                <div class="d-flex align-items-center h-100">
                                    <div class="dialog-wrapper">
                                        <img
                                            src="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}"
                                            alt="logo" class="modal-logo">
                                        <a title="Close" href="#" class="popup__close" data-dismiss="modal"
                                           aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 16 16">
                                                <path fill="#5D5D5D" fill-rule="nonzero"
                                                      d="M9.3 8.302l6.157-6.156a.706.706 0 1 0-.999-.999L8.302 7.304 2.146 1.148a.706.706 0 1 0-.999.999l6.157 6.156-6.156 6.155a.706.706 0 0 0 .998.999L8.302 9.3l6.156 6.156a.706.706 0 1 0 .998-.999L9.301 8.302z"/>
                                            </svg>
                                        </a><!-- .popup__close -->
                                        <ul class="choose-form">
                                            <li class="nav-login exclude-class2"><a title="Log In"
                                                                                    class="font-weight-bold exclude-class2"
                                                                                    href="#login">{{ __('Login') }}</a>
                                            </li>
                                            <li class="nav-signup exclude-class2"><a title="{{ __('Sign Up') }}"
                                                                                     class="font-weight-bold exclude-class2"
                                                                                     href="#register">{{ __('Sign Up') }}</a>
                                            </li>
                                        </ul>
                                        <div class="popup-content">

                                            <form class="form-log form-content" id="login"
                                                  action="{{ route('login') }}" method="POST">
                                                @csrf
                                                {{-- <div class="choose-more">{{__('Continue with')}}
                                                    <div class="social_btns">
                                                        <a title="Facebook" class="fb btn-fb"
                                                            id="singup_facebook_singup" data-social="facebook">

                                                            <div class="fb-content">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                                    height="32" viewBox="0 0 32 32" version="1">
                                                                    <path fill="#FEFEFE"
                                                                        d="M32 30a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h28a2 2 0 0 1 2 2v28z" />
                                                                    <path fill="#4267b2"
                                                                        d="M22 32V20h4l1-5h-5v-2c0-2 1.002-3 3-3h2V5h-4c-3.675 0-6 2.881-6 7v3h-4v5h4v12h5z" />
                                                                </svg>

                                                                <p>Sign in with Facebook</p>
                                                            </div>
                                                        </a>
                                                        <a title="Google" class="gg btn-google"
                                                            id="singup_google_singup" data-social="google">
                                                            <div class="google-content">

                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 48 48" width="48px" height="48px">
                                                                    <path fill="#FFC107"
                                                                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                                                                    <path fill="#FF3D00"
                                                                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                                                                    <path fill="#4CAF50"
                                                                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                                                                    <path fill="#1976D2"
                                                                        d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                                                                </svg>

                                                                <p>Sign in with Google</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <p class="choose-or"><span>{{__('Or')}}</span></p> --}}
                                                <small class="form-text text-danger golo-d-none"
                                                       id="login_error">error!</small>
                                                <div class="form_field">
                                                    <div class="field-input">
                                                        <input type="text" id="email" name="email"
                                                               placeholder="{{ __('Email Address') }}" required>
                                                    </div>
                                                    <div class="field-input">
                                                        <input type="password" id="password" name="password"
                                                               placeholder="{{ __('Password') }}" required>
                                                    </div>
                                                </div>

                                                <div class="choose-form mb-0">
                                                    <a title="{{ __('Forgot password') }}" class="forgot_pass"
                                                       href="#forgot_password">{{ __('Forgot password') }}</a>
                                                </div>
                                                <button type="submit" class="gl-button btn button w-100"
                                                        id="submit_login">{{ __('Login') }}</button>
                                            </form>

                                            <form class="form-sign form-content" id="register"
                                                  action="{{ route('register') }}" method="post">
                                                @csrf
                                                {{-- <p class="choose-or"><span>{{__('Or')}}</span></p> --}}
                                                <small class="form-text text-danger golo-d-none"
                                                       id="register_error">error!</small>
                                                <small class="form-text text-success golo-d-none"
                                                       id="register_success"></small>
                                                <div class="form_field">
                                                    <div class="field-input">
                                                        <input type="text" id="register_name" name="name"
                                                               placeholder="{{ __('Full Name') }}" required>
                                                    </div>
                                                    <div class="field-input">
                                                        <input type="email" id="register_email" name="email"
                                                               placeholder="{{ __('Email Address') }}" required>
                                                    </div>
                                                    <div class="field-input">
                                                        <input type="password" id="register_password" name="password"
                                                               placeholder="{{ __('Password') }}" required>
                                                    </div>
                                                    <div class="field-input">
                                                        <input type="password" id="register_password_confirmation"
                                                               name="password_confirmation"
                                                               placeholder="{{ __('Confirm Password') }}"
                                                               required>
                                                    </div>
                                                    <input type="hidden" id="user_type" name="user_type" value="">
                                                    <input type="hidden" id="user_plan_type" name="user_plan_type"
                                                           value="">
                                                    <input type="hidden" id="user_plan_price" name="user_plan_price"
                                                           value="">
                                                </div>
                                                <p class="usertype_div_alert">Please select user type.</p>
                                                <div class="signup_usertype">
                                                    <p class="font-weight-bold">Sign up As</p>
                                                    <div class="d-flex">
                                                        <div class="signup_user usertype_div">
                                                            <div class="flex">
                                                                <div class="font-weight-bold" style="line-height: 24px">
                                                                    User<br/><span
                                                                        style="color: #72BF44; font-size:16px;"
                                                                        id="user_plan_type_text"></span></div>
                                                                <div class="check_box rounded-circle"></div>
                                                            </div>
                                                            <p>I want to plan my travels around New Zealand.</p>
                                                        </div>
                                                        <div class="signup_operator usertype_div">
                                                            <div class="flex">
                                                                <div class="font-weight-bold">Operator</div>
                                                                <div class="check_box rounded-circle"></div>
                                                            </div>
                                                            <p>I want to list my business and products.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2" style="margin-left: 0px;">

                                                    <div class="form-group" style="margin-left: 0px;">
                                                        {!! NoCaptcha::renderJs() !!}
                                                        {!! NoCaptcha::display() !!}
                                                    </div>

                                                </div>
                                                <div class="field-check">
                                                    <label for="accept_all">
                                                        <input type="checkbox" id="accept_all" name="All_user_accept">
                                                        {{ __('Accept the') }} <a title="Terms"
                                                                                  href="{{ route('page_terms_and_conditions') }}">{{ __('Terms and Conditions & Privacy Policy') }}</a>
                                                        <span class="checkmark">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="8"
                                                                     height="6"
                                                                     viewBox="0 0 8 6">
                                                                    <path fill="#FFF" fill-rule="nonzero"
                                                                          d="M2.166 4.444L.768 3.047 0 3.815 1.844 5.66l.002-.002.337.337L7.389.788 6.605.005z"/>
                                                                </svg>
                                                            </span>
                                                    </label>
                                                    <label for="accept_operator" class="operator_check d-none">
                                                        <input type="checkbox" id="accept_operator"
                                                               name="Operator_user_accept">
                                                        {{ __(' I confirm that my business is part of tourism and hospitality.') }}
                                                        <span class="checkmark">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="8"
                                                                     height="6"
                                                                     viewBox="0 0 8 6">
                                                                    <path fill="#FFF" fill-rule="nonzero"
                                                                          d="M2.166 4.444L.768 3.047 0 3.815 1.844 5.66l.002-.002.337.337L7.389.788 6.605.005z"/>
                                                                </svg>
                                                            </span>
                                                    </label>
                                                </div>
                                                <button type="submit" class="gl-button btn button w-100"
                                                        id="submit_register">{{ __('Sign Up') }}</button>
                                            </form>

                                            <form class="form-forgotpass form-content" id="forgot_password"
                                                  action="{{ route('api_user_forgot_password') }}" method="POST">
                                                @csrf
                                                <p class="choose-or">
                                                    <span>{{ __('Lost your password? Please enter your email address. You will receive a link to create a new password via email.') }}</span>
                                                </p>
                                                <small class="form-text text-danger golo-d-none"
                                                       id="fp_error">error!</small>
                                                <small class="form-text text-success golo-d-none"
                                                       id="fp_success">error!</small>
                                                <div class="field-input">
                                                    <input type="text" id="email" name="email"
                                                           placeholder="Email Address" required>
                                                </div>
                                                <button type="submit" class="gl-button btn button w-100"
                                                        id="submit_forgot_password">{{ __('Forgot password') }}</button>
                                            </form>
                                            <div class="social_signin">
                                                <div style="text-align: center;">Or continue with</div>
                                                <div class="col-md-12 row-block">
                                                    <a class="google_signin" href="{{ url('auth/google') }}">
                                                        <span> <img style="width:25px; height:25px;"
                                                                    src="{{ asset('assets/images/google-logo.svg') }}"></span>
                                                        <strong style="line-height: 25px;">Google</strong>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- .popup-form -->

                            <!--Facebook login -->
                            <div class="modal custom-modal popup-form" id="UserTypeSelectPopUp" tabindex="-1"
                                 aria-labelledby="faceBookLabel" aria-hidden="true">
                                <div class="model-overlay"></div>
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <img src="{{ asset('assets/images/favicon.png') }}" alt="logo">
                                        <span aria-hidden="true" class="close" data-dismiss="modal"
                                              aria-label="Close">&times;</span>
                                        <div class="modal-body">
                                            <h5>{{ __('Please select a account') }}</h5>
                                            <div class="d-flex flex-checkbox">
                                                <div class="custom-checkbox" onclick="Userselection('User')">
                                                    <a href="javascript:;" class="d-block user_type_user">User</a>

                                                </div>
                                                <span>OR</span>
                                                <div class="custom-checkbox" onclick="Userselection('Operator')">
                                                    <a href="javascript:;"
                                                       class="d-block user_type_operator">Operator</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Google login -->
                            {{-- <div class="modal custom-modal popup-form" id="GoogleBtn" tabindex="-1"
                                aria-labelledby="GoogleBtnLabel" aria-hidden="true">
                                <div class="model-overlay"></div>
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <span aria-hidden="true" class="close" data-dismiss="modal"
                                            aria-label="Close">&times;</span>
                                        <div class="modal-body">
                                            <h5>{{__('Continue with')}}</h5>
                                            <div class="d-flex flex-checkbox">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="styled-checkbox-3" />
                                                    <label for="styled-checkbox-3">User</label>
                                                </div>
                                                <span>OR</span>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="styled-checkbox-4" />
                                                    <label for="styled-checkbox-4">Operator</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        @else
                            <div class="account">
                                <a href="#" title="{{ Auth::user()->name }}">
                                    <img src="{{ getUserAvatar(user()->avatar) }}"
                                         alt="{{ Auth::user()->name }}">
                                    <span>

                                            <i class="la la-angle-down la-12"></i>
                                        </span>
                                </a>
                                <div class="account-sub be-vietnam-pro-bold">
                                    <ul>
                                        <li class="{{ isActiveMenu('user_profile') }}"><a
                                                href="{{ route('user_profile') }}">{{ __('Profile') }}</a></li>
                                        @if (isOperatorUser() && checkPlaceCreateLimit())
                                            <li class="{{ isActiveMenu('place_addnew') }}"><a
                                                    href="{{ route('place_addnew') }}">{{ __('Company Info') }}</a>
                                            </li>
                                        @endif
                                        @if (isUserHaveMembership() && isUserUser())
                                            <li class="{{ isActiveMenu('competition_details') }}"><a
                                                    href="{{ route('competition_details') }}">{{ __('Competitions') }}</a>
                                            </li>
                                        @endif
                                        @if (user()->isAdmin())
                                            <li class="{{ isActiveMenu('admin_dashboard') }}"><a
                                                    href="{{ route('admin_dashboard') }}" target="_blank"
                                                    rel="nofollow">{{ __('Dashboard') }}</a></li>
                                        @endif

                                        @if (isOperatorUser())
                                            <li class="my_company_menu {{ isActiveMenu('user_my_place') }}"><a
                                                    href="{{ route('user_my_place') }}">{{ __('My Company') }}</a>
                                            </li>
                                        @endif
                                        @if (!isOperatorUser())
                                            <li class="{{ isActiveMenu('user_wishlist') }}"><a
                                                    href="{{ route('user_wishlist') }}">{{ __('Favourites') }}</a>
                                            </li>
                                        @endif
                                        @if (!isOperatorUser())
                                            <li class="{{ isActiveMenu('user_product_wishlist') }}">
                                                <a
                                                    href="{{ route('user_product_wishlist') }}">{{ __('Wishlist') }}</a>
                                            </li>
                                        @endif
                                        @if (!isOperatorUser())
                                            <li class="{{ isActiveMenu('booking_history') }}"><a
                                                    href="{{ route('booking_history') }}">{{ __('My Bookings') }}</a>
                                            </li>
                                        @endif
                                        @if (isOperatorUser() && !isUserAdmin())
                                            <li class="{{ isActiveMenu('booking_list') }}"><a
                                                    href="{{ route('booking_list') }}">{{ __('Bookings') }}</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                            <form class="d-none" id="logout-form"
                                                  action="{{ route('logout') }}" method="POST">

                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- .account -->

                            @php
                                $webNotifications = getWebNotifications();
                            @endphp
                            <div class="notification_bar">
                                <a class="text-light" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-bell"></i>
                                    @if ($webNotifications['unread_count'] != 0)
                                        <span class="badger_count">{{ $webNotifications['unread_count'] }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="head text-light bg-dark">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-12">
                                                <span>Notifications</span>
                                                <a href="{{ route('markasread') }}"
                                                   class="float-right text-light">Mark
                                                    all as read</a>
                                            </div>
                                        </div>
                                    </li>
                                    <div class="notification_scrollable">
                                        @forelse($webNotifications['notifications'] as $webNotification)
                                            @if (isset($webNotification->place))
                                                <li
                                                    class="notification-box @if (isNumberEven($loop->index + 1))  @endif">
                                                    <div class="row">
                                                        @if($webNotification->redirect_to != null)

                                                            <div class="col-lg-3 col-sm-3 col-3 text-center p-0">
                                                                <a
                                                                    href="{{ route($webNotification['redirect_to']) }}">
                                                                    <img
                                                                        src="{{ getProductImageUrl($webNotification->image) }}"
                                                                        class="w-50 rounded-circle"/>
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-8 col-sm-8 col-8">
                                                                <a
                                                                    href="{{ route($webNotification['redirect_to']) }}">
                                                                    <strong>{{ $webNotification->title }}</strong>
                                                                    <p>{{ $webNotification->body }}</p>
                                                                </a>
                                                                {{-- <small>{{dateTimeFormat($webNotification->created_at)}}</small> --}}
                                                            </div>
                                                        @else
                                                            <div class="col-lg-3 col-sm-3 col-3 text-center p-0">
                                                                <a
                                                                    href="{{ route('place_detail', ['slug' => $webNotification->place->slug]) }}">
                                                                    <img
                                                                        src="{{ getProductImageUrl($webNotification->image) }}"
                                                                        class="w-50 rounded-circle"/>
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-8 col-sm-8 col-8">
                                                                <a
                                                                    href="{{ route('place_detail', ['slug' => $webNotification->place->slug]) }}">
                                                                    <strong>{{ $webNotification->title }}</strong>
                                                                    <p>{{ $webNotification->body }}</p>
                                                                </a>
                                                                {{-- <small>{{dateTimeFormat($webNotification->created_at)}}</small> --}}
                                                            </div>

                                                        @endif

                                                    </div>
                                                </li>
                                            @endif
                                        @empty
                                            <div class="zero_notifications">
                                                <h3 title="{{ $webNotifications['reason'] }}">
                                                    {{ $webNotifications['message'] }}
                                                </h3>
                                            </div>
                                        @endforelse
                                    </div>
                                    <!-- <div class="zero_notifications">
                                                                                                <h3>No Notifications</h3>
                                                                                            </div> -->
                                    <!-- <li class="footer bg-dark text-center">
                                                                                                <a href="" class="text-light">View All</a>
                                                                                            </li> -->
                                </ul>
                            </div>
                            <div class="cloudbar">
                                <a href="javascript:void(0);" class="cloud_icon"><i
                                        class="la la-cloud-meatball"></i></a>
                            </div>

                            @if (isUserUser())
                                <div class="cart-icon">
                                    <a href="{{ route('cart') }}" class="cloud_icon"><i
                                            class="la la-shopping-basket"></i></a>
                                    <span id="cart_icon_count"
                                          class="badger_count">{{ App\Models\Cart::getMyCartItemsCount() }}</span>
                                </div>
                            @endif

                        @endguest
                        <div class="right-header__search">
                            <a title="Search" href="#" class="search-open">
                                <i class="la la-search la-24"></i>
                            </a>
                        </div>

                        <!-- Desktop -->
                        @if (isOperatorUser())
                            <!-- <div class="right-header__button btn">
                                    <a title="Add place" href="{{ route('place_addnew') }}">
                                        <i class="la la-plus la-24"></i>
                                        <span>{{ __('Add place') }}</span>
                                    </a>
                                </div> -->
                            <!-- .right-header__button -->
                        @endif


                    </div><!-- .right-header -->
                </div><!-- .col-md-6 -->
            </div><!-- .row -->


        </div><!-- .container-fluid -->
    </header><!-- .site-header -->

    @yield('main')

    <footer id="footer" class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="footer-grid justify-content-center">
                    <div class="footer-li">
                        <div class="footer__top__info">
                            <a title="Logo" href="#" class="footer__top__info__logo"><img
                                    src="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}"
                                    alt="logo"></a>
                            <!-- <a title="Logo" href="#" class="footer__top__info__logo"><img src="assets/images/logo.png" alt="logo"></a> -->
                            <p class="footer__top__info__desc">
                                {{ __('Discover amazing things to do everywhere you go.') }}
                            </p>
                            <div class="footer__top__info__app">
                                <a title="App Store" href="#" class="banner-apps__download__iphone"><img
                                        src="{{ asset('assets/images/assets/app-store.png') }}"
                                        alt="App Store"></a>
                                <a title="Google Play" href="#" class="banner-apps__download__android"><img
                                        src="{{ asset('assets/images/assets/google-play.png') }}"
                                        alt="Google Play"></a>
                            </div>
                        </div>
                    </div>
                    <div class="footer-li">
                        <aside class="footer__top__nav">
                            <h3>{{ __('Company') }}</h3>
                            <ul>
                                <li><a
                                        href="{{ route('post_detail', ['about-us', 10]) }}">{{ __('About Us') }}</a>
                                </li>
                                <li><a href="{{ route('post_list_all') }}">{{ __('Blog') }}</a></li>
                                <li><a href="{{ route('post_detail', ['faqs', 11]) }}">{{ __('Faqs') }}</a>
                                </li>
                                <li><a href="{{ route('page_contact') }}">{{ __('Contact') }}</a></li>
                                <li><a
                                        href="{{ route('page_terms_and_conditions') }}">{{ __('Terms and
                                            Conditions') }}</a>
                                </li>
                            </ul>
                        </aside>
                    </div>
                    <div class="footer-li">
                        <aside class="footer__top__nav footer__top__nav--contact">
                            <h3>{{ __('Contact Us') }}</h3>
                            <ul>
                                <li>
                                    <p>Email : <span>{{ setting('contactus_email') }}</span>
                                    </p>
                                </li>
                                <li>
                                    <p class="anchor-phone">
                                        Phone : <span>{{ setting('contactus_phone') }}</span>
                                    </p>
                                </li>
                                <li>
                                    <h3 class="mb-3 mt-4 d-block">Technical support</h3>
                                    <p>
                                        Email : <span
                                            class="ml-1">{{ setting('contactus_technical_email') }}</span>
                                    </p>
                                </li>
                            </ul>
                            <!-- <p>{{ __('Phone: 1 (00) 832 2342') }}</p> -->
                            <ul class="d-flex">
                                @if (setting('facebook_url') != '')
                                    <li class="d-inline-block">
                                        <a title="Facebook" href="{{ setting('facebook_url') }}"
                                           target="_blank">
                                            <i class="la la-facebook la-24"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- <li>
                                    <a title="Twitter" href="#">
                                        <i class="la la-twitter la-24"></i>
                                    </a>
                                </li> --}}

                                @if (setting('youtube_url') != '')
                                    <li class="d-inline-block">
                                        <a title="Youtube" href="{{ setting('youtube_url') }}" target="_blank">
                                            <i class="la la-youtube la-24"></i>
                                        </a>
                                    </li>
                                @endif

                                @if (setting('instagram_url') != '')
                                    <li class="d-inline-block">
                                        <a title="Instagram" href="{{ setting('instagram_url') }}"
                                           target="_blank">
                                            <i class="la la-instagram la-24"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </aside>

                    </div>
                    <div class="footer-li last">
                        <aside class="footer__top__nav">
                            <h3>{{ __('GET THE LATEST!') }}</h3>
                            <!-- <form> -->
                            <div class="newleter-content">
                                <p class="text-left">Sign Up to Our Newsletter</p>
                                <div class="newleter-input">
                                    <input id="nl_fullname" type="text" placeholder="Full Name">
                                </div>
                                <div class="newleter-input">
                                    <input id="nl_email" type="email" placeholder="Your Email">
                                </div>
                                <button type="button" onclick="newsletterSubscribe()" class="subscribe btn">SIGN
                                    UP
                                </button>
                            </div>
                            <!-- </form> -->
                        </aside>
                    </div>

                </div>
            </div><!-- .top-footer -->
            <div class="footer__bottom">
                <p class="footer__bottom__copyright">{{ now()->year }} &copy; <a href="{{ url('/') }}"
                                                                                 target="_blank">{{ env('APP_NAME') }}</a>. {{ __('All rights reserved.') }}
                </p>
            </div><!-- .top-footer -->
        </div><!-- .container -->
        @auth
            @include('frontend.chatbot.chatbot')
        @endauth
    </footer><!-- site-footer -->
</div><!-- #wrapper -->

<!-- Return to Top -->
<a href="javascript:" id="return-to-top" style="z-index:20;"><i class="la la-angle-up"></i></a>


<script src="{{ asset('assets/libs/jquery-1.12.4.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/libs/slick/slick.min.js') }}"></script>
@yield('scripts')
<script src="{{ asset('assets/libs/slick/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('assets/libs/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/libs/photoswipe/photoswipe.min.js') }}"></script>
<script src="{{ asset('assets/libs/photoswipe/photoswipe-ui-default.min.js') }}"></script>
<script src="{{ asset('assets/libs/lity/lity.min.js') }}"></script>
<script src="{{ asset('assets/libs/quilljs/js/quill.core.js') }}"></script>
<script src="{{ asset('assets/libs/quilljs/js/quill.js') }}"></script>
<script src="{{ asset('assets/libs/gijgo/js/gijgo.min.js') }}"></script>
<script src="{{ asset('assets/js/'.str_replace("_", "-", app()->getLocale()).'.js') }}"></script>
<script src="{{ asset('assets/js/fil.js') }}"></script>
<script src="{{ asset('assets/libs/chosen/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js?v=1.4') }}"></script>
<script src="{{ asset('assets/js/custom.js?v=1.4') }}"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ setting('goolge_map_api_key', 'AIzaSyChF3sdB-cc8qJCaWcdOqTUvz4QYPIVxlQ') }}&libraries=places&language={{ \Illuminate\Support\Facades\App::getLocale() }}">
</script>
<script src='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css' rel='stylesheet'/>
{{--dataTables--}}
<script src="{{asset('/admin/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('/admin/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script
    src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=e8cgxme8kbsc3u65sf2y8iixj1z0mzqlejahfw9hp9yoi1to"></script>
<script src="{{asset('admin/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('admin/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<!-- Load the `mapbox-gl-geocoder` plugin. -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js">
</script>
<link rel="stylesheet"
      href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css"
      type="text/css">

<!-- Promise polyfill script is required -->
<!-- to use Mapbox GL Geocoder in IE 11. -->
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.2.0/dist/confetti.browser.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
{{-- switchery --}}
<script src="{{ asset('/admin/vendors/switchery/dist/switchery.min.js') }}"></script>
{{-- Pnotify --}}
<script src="{{asset('/admin/vendors/pnotify/dist/pnotify.js')}}"></script>
<script src="{{asset('/admin/vendors/pnotify/dist/pnotify.buttons.js')}}"></script>
<script src="{{asset('/admin/vendors/pnotify/dist/pnotify.nonblock.js')}}"></script>
{{-- lazy loading --}}
<script src="{{ asset('assets/libs/1_9_7_jquery.lazyload.js') }}"></script>
<script src="{{ asset('assets/libs/customLazy.js') }}"></script>
<script src="{{asset('assets/libs/chatbox.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

{{-- Templte --}}
<script src="{{ asset('assets/js/template_frontend/page_template1.js') }}"></script>
@if(auth()->check())
    <script src="{{ asset('assets/js/template_frontend/page_template_weather_check.js')}}"></script>
@else
    <script src="{{ asset('assets/js/template_frontend/page_template_weather.js')}}"></script>
@endif
<script src="{{ asset('assets/js/template_frontend/page_template2.js') }}"></script>

@php
    $show_plan_modal = false;
    if (auth()->user()
        && auth()->user()->subscription_valid_till == null
        && auth()->user()->isOperator()
    ) {
        $show_plan_modal = true;
    }

    if (Session::get('paid')) {
        if (auth()->user()
            && auth()->user()->subscription_valid_till == null
            && auth()->user()->isUser() &&
            Session::get('alreadyUser')
        ) {
            $show_plan_modal = true;
        }
    }
@endphp
@if ($show_plan_modal)
    @include('frontend.common.user-and-operator-plan-modal')
@endif

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
@stack('scripts')
</body>

{{-- NOT WORKING ANYMORE --}}
{{--pageimprove.io/:1--}}
{{--Failed to load resource: net::ERR_NAME_NOT_RESOLVED--}}
{{--<script>--}}
{{--    ;(function() {--}}
{{--        var script = document.createElement('script');--}}
{{--        script.id = '458e6dce-9cea-4405-82de-f814f6db51cc';--}}
{{--        script.type = 'module';--}}
{{--        script.src = 'https://pageimprove.io';--}}
{{--        document.head.appendChild(script);--}}
{{--    })()--}}
{{--</script>--}}

</html>
