@extends('frontend.layouts.template')
@section('main')

<!-- AddToAny BEGIN -->
{{-- <div class="main-icon-div">
    <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" style="left:0px; top:150px;">
        <a class="share">
            <img src="{{asset('assets/images/socialmedia/share.svg')}}" border="0" alt="facebook" width="30px"
                height="30px">
        </a>
    </div>
    <div class="share-buttons">
        <a class="a2a_button_facebook a2a_button">
            <img src="{{asset('assets/images/socialmedia/facebook.png')}}" border="0" alt="facebook" width="27"
                height="27">
        </a>
        <a class="a2a_button_whatsapp a2a_button">
            <img src="{{asset('assets/images/socialmedia/whatsapp.png')}}" border="0" alt="whatsapp" width="27"
                height="27">
        </a>
        <a class="a2a_button_facebook_messenger a2a_button">
            <img src="{{asset('assets/images/socialmedia/messenger.png')}}" border="0" alt="messenger" width="27"
                height="27">
        </a>
    </div>
</div> --}}

<script async src="https://static.addtoany.com/menu/page.js"></script>

<style>
.cart-modal .field-select .input-border,
.cart-modal .form-underline .input-border:focus {
    border-color: {{$place->categories[0]->color_code}} !important;
}

.cart-modal .field-select .input-border:focus {
    border: 1px solid {{$place->categories[0]->color_code}} !important;
}
{}
</style>

<!-- AddToAny END -->
<main id="main" class="site-main place-04">
    <div class="place custom-padding-top">
        <div class="place_wrapper">
            @php
                if(isset($place->gallery)){
                    $banner_url =  $place->gallery[0];
                } else {
                    $banner_url = $place->thumb;
                }
            @endphp
            <div class="country_banner" style = "background-image:url({{getImageUrl($banner_url)}});">
            </div>
            <div class="country_detail">
                <div class="country_detail_description row container">
                    <div class="col-lg-6 country_detail_videodiv" style="position:relative;">
                        @if($place->video)
                        <div class="country_detail_video" style="position:relative;">
                            <iframe  class="country_video" src="{{strpos($place->video, "watch?v=") != null ? str_replace("watch?v=","embed/", $place->video) : str_replace("youtu.be","youtube.com/embed", $place->video)}}"
                                frameborder="0" allowfullscreen allow="autoplay"></iframe>
                        </div>
                        @else
                        <img src="{{getImageUrl($place->thumb)}}" alt="{{$place->name}} Thumbnail">
                        @endif
                    </div>
                    <div class="col-lg-6 country_detail_about">
                        <div style="color:#2d2d2d;">
                            <p style="font-size:22px; margin-bottom:20px;">About</p>
                            <div class="country_description">
                                @php
                                    echo $place->description;
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
                <div class="country_box_wrapper container">
                    <div class="country__box mb-0 country__box--npd row">
                        <div class="col-lg-9 row country__box_mark_name" style="margin:0;">
                            <div class="col-md-4 country_box_title logo_wrapper">
                                @if($place->categories[0]->slug != 'see')
                                    <div class="place-gallery d-flex">
                                        @php
                                            $logo = $place->logo != null ? getImageUrl($place->logo) : asset('uploads/' . setting('logo_white'));
                                        @endphp
                                            <img src="{{$logo}}" alt="logo" class="custom-img-width">
                                    </div><!-- .place-item__photo -->
                                @endif
                                @foreach($categories as $cat)
                                    <div class="place_detail_category">
                                        <img src="{{getCategoryMakerUrl($cat->icon_map_marker)}}" alt="{{$cat->name}}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-8 country_box_desc position-relative" >
                                <h1 style="color:{{$place['categories'][0]['color_code']}}">
                                    <span class="place_name">{{$place->name}}</span>
                                    <ul class="place__breadcrumbs breadcrumbs">
                                        <li><a title="{{$city->name}}"
                                                href="{{route('city_detail', $city->slug)}}" style="color:{{$place['categories'][0]['color_code']}}">{{$city->name}}</a></li>
                                    </ul>
                                </h1>
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
                                            @for($i = 0; $i < 5; $i++)
                                                <i class="far fa-star" style="color:#414141;"></i>
                                            @endfor
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 country_box_map" style="padding:0; background-color:{{$place['categories'][0]['color_code']}};">
                            <div>
                                @if($place['categories'][0]['slug'] != 'see')
                                    @if($place['categories'][0]['slug'] != 'eat')
                                    <div style="color: #FEFEFE; justify-content: center; display:flex; gap: 2px;">
                                        <div class="treding_price_small">from</div>
                                        <div class="treding_price_big" style="margin: 0 5px;">${{ $place->getPlacePrice() }} </div>
                                        <div class="treding_price_small" style="display: flex; align-items: end;">NZD</div>
                                    </div>
                                    <div style="justify-content: center; display: flex;">
                                        <a class="place_detail_book" id="book_now_link" style="cursor: pointer; color:{{$place['categories'][0]['color_code']}}; background-color:white; font-weight:bold;">Book now</a>
                                    </div>
                                    @else
                                    <div style="color: #FEFEFE; width:140px; text-align:center; margin-bottom:10px; margin-top:10px;">
                                        {{__('Save 10% on your meal when you make a reservation')}}
                                    </div>
                                    <div style="justify-content: center; display: flex;">
                                        <a class="place_detail_book add_reservation_btn" href="javascript:;" data-toggle="modal" data-target="#reservation_model" data-id="{{$place['id']}}" data-category="{{$place['categories'][0]['slug']}}" style="cursor: pointer; color:{{$place['categories'][0]['color_code']}}; background-color:white; font-weight:bold;">Reserve a table!</a>
                                    </div>
                                    @endif

                                @else
                                <div style="font-size:40px; color: white;justify-self: center;">
                                    {{__('Free')}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-lg-12 pleace_left_space pleace_two_space_content p-0">
                <div class="place__left p-0">
                    <div class="place__left_ul">
                        <div class="container row" id="book_now_target" style="margin:auto;">
                            @if($place['categories'][0]['slug'] != 'see')
                            <div class="place__box place__box-hightlight col-lg-6 border-0">
                                <div class="place__box place__box-map products_box-map products_box-map_new p-0 border-0">

                                            <div class="custom-border">
                                                <h3 class="place__title--additional">
                                                    {{ __('Products') }}
                                                </h3>
                                                @if(!$place->products->isEmpty())
                                                    @php
                                                    $isPlaceOperatorHaveStripeConnect = false;
                                                    if(App\Models\Place::isPlaceOperatorHaveStripeConnect($place->id))
                                                    {
                                                    $isPlaceOperatorHaveStripeConnect = true;
                                                    }
                                                    @endphp
                                                <div class="menu-tab">
                                                    <div class="menu-wrap active" id="diner">
                                                        <div class="custom-after">

                                                            <div>
                                                                @foreach($place->products as $menu)
                                                                    <div class="menu-item-ul">
                                                                        <div class="menu_title_main menu_card">
                                                                            <img src="{{$menu['thumb']}}" alt="Product Image">
                                                                            <div class="menu_title_main_con">
                                                                                <h4 style="color:{{$place['categories'][0]['color_code']}}">{{$menu['name']}}</h4>
                                                                                <p>{{$menu['description']}}</p>
                                                                                <div class="d-flex cutom_flex_div_user">
                                                                                <div class="price_main">
                                                                                    {{-- <p>
                                                                                        <label>Adult: <span class="color-green">$900</span> <del>$1000</del></label>
                                                                                    </p>
                                                                                    <p>
                                                                                        <label>Child: <span class="color-green">$600</span> <del>$800</del></label>
                                                                                    </p> --}}
                                                                                    {{-- <div class="price-details"> --}}

                                                                                        <p>
                                                                                            @if($menu->car_price != ''  && $menu->car_price != NULL)
                                                                                                <label>{{ __('Vehicle') }}</label>
                                                                                            @else
                                                                                            <label>
                                                                                                @isset($place->categories[0])
                                                                                                {{$place->categories[0]->getPriceText()}}:
                                                                                                @endisset

                                                                                                @if($menu->car_price != '' && $menu->car_price != NULL && $place->categories[0]->slug != 'stay')
                                                                                                    @if(checkIfOnCarDiscount($menu,true))
                                                                                                        <span style="color: {{$place['categories'][0]['color_code']}}">${{checkIfOnCarDiscount($menu,true)}} </span>
                                                                                                    @else
                                                                                                        <span style="color: {{$place['categories'][0]['color_code']}}">${{cleanDecimalZeros($menu['car_price'])}} </span>
                                                                                                    @endif
                                                                                                @else
                                                                                                    @if(checkIfOnDiscount($menu,true))
                                                                                                        <span style="color: {{$place['categories'][0]['color_code']}}">${{checkIfOnDiscount($menu,true)}} </span>
                                                                                                    @else
                                                                                                        <span style="color: {{$place['categories'][0]['color_code']}}">${{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}} </span>
                                                                                                    @endif
                                                                                                @endif

                                                                                                {{-- @if($menu->car_price != NULL && $menu->car_discount_price != NULL && checkIfOnCarDiscount($menu) && $place->categories[0]->slug != 'stay')
                                                                                                    <span class="color-green">${{ checkIfOnCarDiscount($menu,true) }} </span><del>${{cleanDecimalZeros($menu['car_price']) }}</del>
                                                                                                @elseif(checkIfOnDiscount($menu) && $menu->discount_percentage != NULL && getRezdyPrice($menu->price != NULL)
                                                                                                    <span class="color-green">${{checkIfOnDiscount($menu,true)}} </span><del>${{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}}</del>
                                                                                                @endif --}}
                                                                                            </label>
                                                                                            @endif
                                                                                        </p>
                                                                                        <p>
                                                                                            {{-- @if(isset($menu) && $menu['child_price']!=NULL && false) --}}
                                                                                            @if(isset($menu) && $menu['child_price']!=NULL)
                                                                                                {{-- <label>{{ __('Child') }}:  <span class="color-green">${{cleanDecimalZeros(getRezdyPrice($menu, $menu['child_price'], 'child'))}}</span> @if(checkIfOnChildDiscount($menu))  <del>${{checkIfOnChildDiscount($menu,true)}}</del>@endif</label> --}}

                                                                                                <label>{{ __('Child') }}:
                                                                                                @if(checkIfOnChildDiscount($menu))
                                                                                                    <span style="color: {{$place['categories'][0]['color_code']}}">${{checkIfOnChildDiscount($menu,true)}}
                                                                                                @else
                                                                                                    <span style="color: {{$place['categories'][0]['color_code']}}">${{cleanDecimalZeros(getRezdyPrice($menu, $menu['child_price'], 'child'))}} </span>
                                                                                                @endif
                                                                                                </label>
                                                                                            @endif
                                                                                        </p>

                                                                                        {{-- <div class="price-flex"> --}}
                                                                                            {{-- <div class="price-h4"> --}}
                                                                                                {{-- <span>{{ __('RRP') }}</span> --}}
                                                                                                {{-- <p>
                                                                                                @if($menu->car_price != '' && $menu->car_price != NULL && $place->categories[0]->slug != 'stay')
                                                                                                <span class="color-green">${{cleanDecimalZeros($menu['car_price']) }} 1</span>
                                                                                                @else
                                                                                                <span class="color-green">${{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}} 2</span>
                                                                                                @endif
                                                                                                </p> --}}
                                                                                            {{-- </div> --}}
                                                                                            {{-- @if($menu->car_price != NULL && $menu->car_discount_price != NULL && checkIfOnCarDiscount($menu) && $place->categories[0]->slug != 'stay')
                                                                                            <div class="menu-dicount">
                                                                                                <div class="price-details text-center red">
                                                                                                    <span>{{ __('Now') }}</span>
                                                                                                    <span class="color-green">${{checkIfOnCarDiscount($menu,true)}} 3</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            @elseif(checkIfOnDiscount($menu) && $menu->discount_percentage != NULL && getRezdyPrice($menu->price != NULL)
                                                                                            <div class="menu-dicount">
                                                                                                <div class="price-details text-center red">
                                                                                                    <span>{{ __('Now') }}</span>
                                                                                                    <span class="color-green">${{checkIfOnDiscount($menu,true)}} 4</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            @endif --}}
                                                                                        {{-- </div> --}}
                                                                                    {{-- </div> --}}

                                                                                    {{-- @if(isset($menu) && $menu['child_price']!=NULL && false)
                                                                                    <div class="price-details">
                                                                                        <span>{{ __('Child') }}</span>
                                                                                        <div class="price-flex">
                                                                                            <div class="price-h4">
                                                                                                <span>{{ __('RRP') }}</span>
                                                                                                <span class="color-green">${{cleanDecimalZeros(getRezdyPrice($menu, $menu['child_price'], 'child'))}} 5</span>
                                                                                            </div>
                                                                                            @if(checkIfOnChildDiscount($menu))
                                                                                            <div class="menu-dicount">
                                                                                                <div class="price-details text-center red">
                                                                                                    <span>{{ __('Now') }}</span>
                                                                                                    <span class="color-green">${{checkIfOnChildDiscount($menu,true)}} 6</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    @endif --}}
                                                                                </div>
                                                                                <!--cart button-->
                                                                                @if(isUserUser() || !auth()->user())
                                                                                    @if($isPlaceOperatorHaveStripeConnect && isset($menu) && $menu->count()>0)
                                                                                    @php
                                                                                    $slotAvailibility =  $menu->bookingAvailibilities[0]->all_day ?? 1;
                                                                                    @endphp
                                                                                    <div class="price-details-btn cart-btn @guest open-login @endguest">
                                                                                        {{-- @if($place->categories[0]->slug != 'eat') --}}
                                                                                        <a style="background-color: {{$place['categories'][0]['color_code']}}" data-max_adult_per_room="{{$menu->bookingAvailibilities[0]->max_adult_per_room ?? 0}}" data-max_child_per_room="{{$menu->bookingAvailibilities[0]->max_child_per_room ?? 0}}"  data-name="{{$menu['name']}}" data-id="{{$menu['id']}}" data-category="{{$place['categories'][0]['slug']}}" data-slot="{{$slotAvailibility}}"
                                                                                        data-carprice="@if(checkIfOnCarDiscount($menu)) ${{checkIfOnCarDiscount($menu,true)}} @else ${{cleanDecimalZeros($menu['car_price'])}} @endif"
                                                                                        data-price="@if(checkIfOnDiscount($menu)) ${{checkIfOnDiscount($menu,true)}} @else ${{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}} @endif"
                                                                                        data-child_price="@if(checkIfOnChildDiscount($menu)) ${{checkIfOnChildDiscount($menu,true)}} @else ${{cleanDecimalZeros(getRezdyPrice($menu, $menu['child_price'], 'child'))}} @endif"
                                                                                        href="javascript:;" class="btn {{ (\Auth::user())?'add_to_cart_btn':'' }}  @isset($category_slug) category-{{$category_slug}} @endisset" {{ (\Auth::user()) ? '
                                                                                        data-toggle="modal" data-target="#cart-model"':'' }} >
                                                                                            <!-- <i class="la la-plus"> </i> --> {{ __('Add To Cart') }}
                                                                                        </a>
                                                                                        {{-- @else
                                                                                            @if($place->booking_type !== \App\Models\Booking::TYPE_CONTACT_FORM)
                                                                                                @guest()
                                                                                                    <button class="btn btn-login open-login" style="height: 40px; border-radius: 20px; background-color:{{$place['categories'][0]['color_code']}};color:white; margin-top:20px;">{{__('Make a reservation')}}</button>
                                                                                                @else
                                                                                                    <a href="javascript:;" class="btn" data-id="{{$place['id']}}" data-category="{{$place['categories'][0]['slug']}}" data-toggle="modal" data-target="#reservation_model" style="height: 40px; border-radius: 20px; background-color:{{$place['categories'][0]['color_code']}}; color:white; margin-top:20px;">
                                                                                                        {{__('Make a reservation')}}
                                                                                                    </a>
                                                                                                @endguest
                                                                                            @elseif($place->booking_type === \App\Models\Booking::TYPE_CONTACT_FORM)
                                                                                                <a href="javascript:;" class="btn" data-toggle="modal" data-target="#inquiry_model" style="background-color:{{$place['categories'][0]['color_code']}};color:white;">
                                                                                                    {{__('Send me a message')}}
                                                                                                </a>
                                                                                            @endif
                                                                                        @endif --}}
                                                                                    </div>
                                                                                    @else
                                                                                    <!-- No stripe connect message here -->
                                                                                    <p title="Reason : Operator account is pending payment verification." class="not-available"
                                                                                        style="color:orange;text-align: center;">{{ __('Not Available for Booking') }}</p>
                                                                                    @endif
                                                                                @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="position-btn">
                                                                                <a href="#"
                                                                                    class="golo-add-to-wishlist btn-add-to-wishlist @if($menu->place_product_wishlist_count) remove_product_wishlist active @else @guest open-login @else add_product_wishlist @endguest @endif"
                                                                                    place-id="{{$menu['place_id']}}" product-id="{{$menu['id']}}" data-color="{{$place['categories'][0]['color_code']}}"
                                                                                    tabindex="0" data-tooltip="Wishlist" data-position="right" @if($menu->place_product_wishlist_count) style="background-color:{{$place['categories'][0]['color_code']}};" @endif>
                                                                                    <span class="icon-heart">
                                                                                        @if($menu->place_product_wishlist_count)
                                                                                        <i class="fas fa-heart" aria-hidden="true"></i>
                                                                                        @else
                                                                                        <i class="far fa-heart" aria-hidden="true"></i>
                                                                                        @endif
                                                                                    </span>
                                                                                </a>
                                                                                {{-- <img src="{{$menu['thumb']}}" alt="Product Image"> --}}

                                                                            </div>
                                                                            {{-- <div class="menu-info d-flex align-items-center">



                                                                                <!-- <span class="price">${{$menu['price']}}</span> -->
                                                                            </div> --}}

                                                                            {{-- <div class="price-details">
                                                                                @if($menu->car_price != ''  && $menu->car_price != NULL)
                                                                                <span>{{ __('Vehicle') }}</span>
                                                                                @else
                                                                                <span>
                                                                                    @isset($place->categories[0])
                                                                                    {{$place->categories[0]->getPriceText()}}
                                                                                    @endisset</span>
                                                                                @endif

                                                                                <div class="price-flex">
                                                                                    <div class="price-h4">
                                                                                        <span>{{ __('RRP') }}</span>
                                                                                        @if($menu->car_price != '' && $menu->car_price != NULL && $place->categories[0]->slug != 'stay')
                                                                                        <h4>${{cleanDecimalZeros($menu['car_price']) }}</h4>
                                                                                        @else
                                                                                        <h4>${{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}}</h4>
                                                                                        @endif

                                                                                    </div>
                                                                                    @if($menu->car_price != NULL && $menu->car_discount_price != NULL && checkIfOnCarDiscount($menu) && $place->categories[0]->slug != 'stay')
                                                                                    <div class="menu-dicount">
                                                                                        <div class="price-details text-center red">
                                                                                            <span>{{ __('Now') }}</span>
                                                                                            <h4>${{checkIfOnCarDiscount($menu,true)}}</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    @elseif(checkIfOnDiscount($menu) && $menu->discount_percentage != NULL && getRezdyPrice($menu->price != NULL)
                                                                                    <div class="menu-dicount">
                                                                                        <div class="price-details text-center red">
                                                                                            <span>{{ __('Now') }}</span>
                                                                                            <h4>${{checkIfOnDiscount($menu,true)}}</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div> --}}

                                                                            {{-- @if(isset($menu) && $menu['child_price']!=NULL && false)
                                                                            <div class="price-details">
                                                                                <span>{{ __('Child') }}</span>
                                                                                <div class="price-flex">
                                                                                    <div class="price-h4">
                                                                                        <span>{{ __('RRP') }}</span>
                                                                                        <h4>${{cleanDecimalZeros(getRezdyPrice($menu, $menu['child_price'], 'child'))}}</h4>
                                                                                    </div>
                                                                                    @if(checkIfOnChildDiscount($menu))
                                                                                    <div class="menu-dicount">
                                                                                        <div class="price-details text-center red">
                                                                                            <span>{{ __('Now') }}</span>
                                                                                            <h4>${{checkIfOnChildDiscount($menu,true)}}</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            @endif --}}


                                                                        </div>


                                                                    {{-- @if($menu['booking_link']) --}}
                                                                    <!-- <div class="price-details-btn">
                                                                                        {{-- <a target="_blank" href="{{$menu['booking_link']}}" class="btn">Book Now</a> --}}
                                                                                    </div>                                                       -->
                                                                    {{-- @endif --}}

                                                                    {{-- <!--cart button-->
                                                                    @if(isUserUser() || !auth()->user())
                                                                    @if($isPlaceOperatorHaveStripeConnect && isset($menu) && $menu->count()>0)
                                                                    @php
                                                                    $slotAvailibility =  $menu->bookingAvailibilities[0]->all_day ?? 1;
                                                                    @endphp
                                                                    <div class="price-details-btn cart-btn @guest open-login @endguest">
                                                                        @if($place->categories[0]->slug != 'eat')
                                                                        <a style="background-color: {{$place['categories'][0]['color_code']}}" data-max_adult_per_room="{{$menu->bookingAvailibilities[0]->max_adult_per_room ?? 0}}" data-max_child_per_room="{{$menu->bookingAvailibilities[0]->max_child_per_room ?? 0}}"  data-name="{{$menu['name']}}" data-id="{{$menu['id']}}" data-slot="{{$slotAvailibility}}"
                                                                        data-carprice="@if(checkIfOnCarDiscount($menu)) ${{checkIfOnCarDiscount($menu,true)}} @else ${{cleanDecimalZeros($menu['car_price'])}} @endif"
                                                                        data-price="@if(checkIfOnDiscount($menu)) ${{checkIfOnDiscount($menu,true)}} @else ${{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}} @endif"
                                                                        data-child_price="@if(checkIfOnChildDiscount($menu)) ${{checkIfOnChildDiscount($menu,true)}} @else ${{cleanDecimalZeros(getRezdyPrice($menu, $menu['child_price'], 'child'))}} @endif"
                                                                        href="javascript:;" class="btn {{ (\Auth::user())?'add_to_cart_btn':'' }}" {{ (\Auth::user()) ? '
                                                                        data-toggle="modal" data-target="#cart-model"':'' }} >
                                                                            <!-- <i class="la la-plus"> </i> --> <span style="font-size: 14px;">{{ __('Add To Cart') }}</span>
                                                                        </a>
                                                                        @endif
                                                                    </div>
                                                                    @else
                                                                    <!-- No stripe connect message here -->
                                                                    <p title="Reason : Operator account is pending payment verification." class="not-available"
                                                                        style="color:orange;text-align: center;">{{ __('Not Available for Booking') }}</p>
                                                                    @endif
                                                                    @endif --}}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <a href="#" class="menu-more">{{ __('Show more') }}</a>
                                                    </div>
                                                </div>

                                    @endif
                                </div>
                            </div><!-- .place__box -->
                            </div>
                            <div class="place__box place__box-overview border-0 col-lg-6">

                                <div class="place__box_amenities">
                                    <h3>{{__('Amenities')}}</h3>
                                    @if(isset($amenities))
                                        <div class="place__box place__box-hightlight border-0">
                                            <div class="hightlight-grid">
                                                @foreach($amenities as $key => $item)
                                                @if($key < 4)
                                                    <div class="place__amenities">
                                                        <div style="background-color: {{$place['categories'][0]['color_code']}}" class="place__amenities_image">
                                                            <img src="{{getImageUrl($item->icon)}}" alt="{{$item->name}}">
                                                        </div>
                                                        <span>{{$item->name}}</span>
                                                    </div>
                                                @endif
                                                @endforeach
                                                @if(count($amenities) > 4)
                                                <div class="place__amenities m-0">
                                                    <div style="background-color: {{$place['categories'][0]['color_code']}}" class="place__amenities_image">
                                                            <a class="open-popup" href="#show-amenities" style="color:#FEFEFE;">+{{count($amenities) - 4}}</a>
                                                    </div>
                                                    <span>View More</span>
                                                </div>
                                                @endif
                                                <div class="popup-wrap" id="show-amenities">
                                                    <div class="popup-bg popupbg-close"></div>
                                                    <div class="popup-middle">
                                                        <a title="Close" href="#" class="popup-close">
                                                            <i class="la la-times la-24"></i>
                                                        </a><!-- .popup-close -->
                                                        <h3>{{__('Amenities')}}</h3>
                                                        <div class="popup-content">
                                                            <div class="hightlight-flex">
                                                                @foreach($amenities as $key => $item)
                                                                <div class="place__amenities" >
                                                                    <img style="background-color: {{$place['categories'][0]['color_code']}}" src="{{getImageUrl($item->icon)}}" alt="{{$item->name}}">
                                                                    <span>{{$item->name}}</span>
                                                                </div>
                                                                @endforeach
                                                            </div><!-- .hightlight-flex -->
                                                        </div><!-- .popup-content -->
                                                    </div><!-- .popup-middle -->
                                                </div><!-- .popup-wrap -->
                                            </div>
                                        </div>
                                    @endif
                                    <a href="#" class="show-more" title="{{__('Show more')}}">{{__('Show more')}}</a>
                                </div>
                                @if ($place->needtobring)
                                    <div class="place__box_description">
                                        <h3>{{__('What you need to know! ')}}</h3>
                                        <div class="place__desc pb-0" style="min-height:50px; margin-bottom:30px;">
                                            {!! $place->needtobring !!}
                                        </div><!-- .place__desc -->
                                    </div>
                                @endif
                                @else
                                <div></div>


                            </div>
                        @endif                      <!-- .place__box -->
                        </div>
            </div><!-- .place__left -->

            <div class="place__box--place_slides" style="background-color:#f2f2f2;">
                <div style="margin:auto; padding-bottom:100px;">
                    <div style="width:95%; margin:auto;">
                        <div class="slick-sliders">
                            <div class="slick-slider photoswipe place__box--place_slider" data-item="4" data-arrows="true" data-itemScroll="1" data-dots="true"
                                data-infinite="true" data-centerMode="false" data-centerPadding="0" data-tabletitem="2" data-mobileitem="1">
                                @if(isset($place->gallery))
                                {{-- <img class="place-cover-slider-placeholder-img"
                                    src="https://via.placeholder.com/1280x500?text=VentureNZ"> --}}
                                @foreach($place->gallery as $gallery)
                                <div class="place-slider__item photoswipe-item">
                                    <a href="{{getImageUrl($gallery)}}" target="_blank" data-height="900" data-width="1200" data-caption="{{$gallery}}">
                                        <img class="place-cover-slider-imgs" width="1920" height="200" style="display: none;" src="{{getImageUrl($gallery)}}" alt="{{$gallery}}">
                                    </a>
                                </div>
                                @endforeach
                                @else
                                <div class="place-slider__item"><a href="#"><img src="https://via.placeholder.com/1280x500?text=VentureNZ" alt="slider no image"></a></div>
                                @endif
                            </div>
                            <div class="place-slider__nav slick-nav explore_slick_nav">
                                        <div class="place-slider__prev slick-nav__prev slick-arrow" style="display: block;">
                                            <i class="fas fa-caret-left"></i>
                                        </div>
                                        <div class="place-slider__next slick-nav__next slick-arrow" style="display: block;">
                                            <i class="fas fa-caret-right"></i>
                                        </div>
                            </div>
                            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                                <!-- Background of PhotoSwipe.
                                        It's a separate element as animating opacity is faster than rgba(). -->
                                <div class="pswp__bg"></div>
                                <!-- Slides wrapper with overflow:hidden. -->
                                <div class="pswp__scroll-wrap">
                                    <!-- Container that holds slides.
                                            PhotoSwipe keeps only 3 of them in the DOM to save memory.
                                            Don't modify these 3 pswp__item elements, data is added later on. -->
                                    <div class="pswp__container">
                                        <div class="pswp__item"></div>
                                        <div class="pswp__item"></div>
                                        <div class="pswp__item"></div>
                                    </div>

                                    <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                    <div class="pswp__ui pswp__ui--hidden">
                                        <div class="pswp__top-bar">
                                            <!--  Controls are self-explanatory. Order can be changed. -->
                                            <div class="pswp__counter"></div>
                                            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                            <button class="pswp__button pswp__button--share" title="Share"></button>
                                            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                            <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                            <!-- element will get class pswp__preloader--active when preloader is running -->
                                            <div class="pswp__preloader">
                                                <div class="pswp__preloader__icn">
                                                    <div class="pswp__preloader__cut">
                                                        <div class="pswp__preloader__donut"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                            <div class="pswp__share-tooltip"></div>
                                        </div>
                                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                                        </button>
                                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                                        </button>
                                        <div class="pswp__caption">
                                            <div class="pswp__caption__center"></div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .pswp -->
                        </div><!-- .place-slider -->
                    </div>
                </div>
            </div>
            <div class="place__box place__box--reviews reviews--new-con col-lg-8 m-auto border-0">
                    <div class="container">
                        <h3 class="place__title--reviews d-flex align-items-center">
                            {{__('Review')}} ({{count($reviews)}})
                            <div class="ml-auto ratting-content">
                                @if(isset($reviews))
                                <span class="place__reviews__number"> {{$review_score_avg}}
                                    <i class="la la-star"></i>
                                </span>
                                @endif
                            </div>
                        </h3>

                        <ul class="place__comments">
                            @foreach($reviews as $review)
                            <li>
                                <div class="place__author">
                                    <div class="place__author__avatar">
                                        <a title="Nitithorn" href="#"><img
                                                src="{{getUserAvatar($review['user']['avatar'])}}" alt=""></a>
                                    </div>
                                    <div class="place__author__info">
                                        <div class="d-flex mb-2">
                                            <h4>
                                                <a title="Nitithorn" href="#">{{$review['user']['name']}}</a>
                                            </h4>
                                            <div class="place__author__star">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12">
                                                    <path fill="#DDD" fill-rule="evenodd"
                                                        d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12">
                                                    <path fill="#DDD" fill-rule="evenodd"
                                                        d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12">
                                                    <path fill="#DDD" fill-rule="evenodd"
                                                        d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12">
                                                    <path fill="#DDD" fill-rule="evenodd"
                                                        d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    viewBox="0 0 12 12">
                                                    <path fill="#DDD" fill-rule="evenodd"
                                                        d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                </svg>
                                                @php
                                                $width = $review->score * 20;
                                                $review_width = "style='width:{$width}%'";
                                                @endphp
                                                <span {!! $review_width !!}>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#72bf44" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#72bf44" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#72bf44" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#72bf44" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#72bf44" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="place__comments__content">
                                            <p>{{$review->comment}}</p>
                                        </div>
                                        <time>{{formatDate($review->created_at, 'd/m/Y')}}</time>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        @guest
                        <div class="login-for-review account logged-out">
                            <a href="#" class="btn-login open-login">{{__('Login')}}</a>
                            <span>{{__('to review')}}</span>
                        </div>
                        @else
                        <div class="review-form">

                            <form id="submit_review">
                                @csrf
                                <div class="d-flex review-flex">
                                    <img class="author-avatar" src="{{getUserAvatar(user()->avatar)}}" alt="">
                                    <div>
                                        <h3>{{__('Write a review')}}</h3>
                                        <div class="rate">
                                            <div class="stars">
                                                <a href="#" class="star-item" data-value="1" title="star-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#DDD" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                </a>
                                                <a href="#" class="star-item" data-value="2" title="star-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#DDD" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                </a>
                                                <a href="#" class="star-item" data-value="3" title="star-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#DDD" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                </a>
                                                <a href="#" class="star-item" data-value="4" title="star-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#DDD" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                </a>
                                                <a href="#" class="star-item" data-value="5" title="star-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        viewBox="0 0 12 12">
                                                        <path fill="#DDD" fill-rule="evenodd"
                                                            d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="field-textarea">
                                    <textarea name="comment" placeholder="{{ __('Write a review') }}"></textarea>
                                </div>
                                <div class="row">
                                    <p class="form-text text-danger" id="review_error"></p>
                                </div>
                                <div class="field-submit">
                                    <input type="hidden" name="score" value="">
                                    <input type="hidden" name="place_id" value="{{$place->id}}">
                                    <button type="submit" class="btn" id="btn_submit_review" style="background-color:{{$place['categories'][0]['color_code']}}">{{__('Submit')}}</button>
                                </div>
                            </form>
                        </div>
                        @endguest
                    </div>
                </div><!-- .place__box -->
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 m-auto contact-li-right p-0">
            <div class="sidebar sidebar--shop sidebar--border">
                <div class="widget-reservation-mini">
                    @if($place->booking_type === \App\Models\Booking::TYPE_AFFILIATE)
                    <h3>{{__('Booking online')}}</h3>
                    <a href="#" class="open-wg btn">{{__('Book now')}}</a>
                    @elseif($place->booking_type === \App\Models\Booking::TYPE_BOOKING_FORM)
                    {{-- <h3>{{__('Make a reservation')}}</h3>
                    <a href="#" class="open-wg btn">{{__('Book now')}}</a> --}}
                    @elseif($place->booking_type === \App\Models\Booking::TYPE_CONTACT_FORM)
                    <h3>{{__('Send me a message')}}</h3>
                    <a href="#" class="open-wg btn">{{__('Send')}}</a>
                    @else
                    <h3>{{__('Banner Ads')}}</h3>
                    <a href="#" class="open-wg btn">{{__('View')}}</a>
                    @endif
                </div>

                @if($place->booking_link)
                <!-- <aside class="widget widget-shadow widget-booking">
                                <h3>{{__('Online Booking')}}</h3>
                                <a href="{{$place->booking_link}}" class="btn" target="_blank" rel="nofollow">{{__('Book now')}} <i class="las la-external-link-alt"></i></a>
                            </aside> -->
                <!-- .widget -->
                @endif

            {{--
                @if($place->booking_type === \App\Models\Booking::TYPE_AFFILIATE)
                <aside class="widget widget-shadow widget-booking">
                    <h3>{{__('Booking online')}}</h3>
                    <a href="{{$place->link_bookingcom}}" class="btn" target="_blank" rel="nofollow">{{__('Book now')}} <i class="las la-external-link-alt"></i></a>
                    <!-- <p class="note">{{__('By Booking.com')}}</p> -->
                </aside>
                @elseif($place->booking_type === \App\Models\Booking::TYPE_BOOKING_FORM)
                {{-- <aside class="widget widget-shadow widget-reservation d-block">
                    <h3>{{__('Make a reservation')}}</h3>
                    <form action="#" method="POST" class="form-underline" id="booking_form">
                        @csrf
                        <div class="field-select has-sub ¸¸¸¸">
                            <span class="sl-icon"><i class="la la-user-friends"></i></span>
                            <input type="text" placeholder="Guest *" readonly>
                            <i class="la la-angle-down"></i>
                            <div class="field-sub">
                                <ul>
                                    <li>
                                        <span>{{__('Adults')}} {{$place->categories[0]->getPriceText()}}</span>
                                        <div class="shop-details__quantity">
                                            <span class="minus">
                                                <i class="la la-minus"></i>
                                            </span>
                                            <input type="number" name="numbber_of_adult" value="0"
                                                class="qty number_adults">
                                            <span class="plus">
                                                <i class="la la-plus"></i>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <span>{{__('Childrens')}} {{$place->categories[0]->getPriceText()}}</span>
                                        <div class="shop-details__quantity">
                                            <span class="minus">
                                                <i class="la la-minus"></i>
                                            </span>
                                            <input type="number" name="numbber_of_children" value="0"
                                                class="qty number_childrens">
                                            <span class="plus">
                                                <i class="la la-plus"></i>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="field-select field-date">
                            <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                            <input type="text" id="date-picker" name="date" class="date-picker-input" placeholder="Date *" autocomplete="off">
                            <i class="la la-angle-down"></i>
                        </div>
                        <div class="field-select has-sub field-time slot_div" id="slot_div">
                            <span class="sl-icon"><i class="la la-clock"></i></span>
                            <input type="text" name="time" placeholder="Time" readonly>
                            <i class="la la-angle-down"></i>
                            <div class="field-sub">
                                <ul>
                                    <li><a href="#">12:00 AM</a></li>
                                    <li><a href="#">12:30 AM</a></li>
                                    <li><a href="#">1:00 AM</a></li>
                                    <li><a href="#">1:30 AM</a></li>
                                    <li><a href="#">2:00 AM</a></li>
                                    <li><a href="#">2:30 AM</a></li>
                                    <li><a href="#">3:00 AM</a></li>
                                    <li><a href="#">3:30 AM</a></li>
                                    <li><a href="#">4:00 AM</a></li>
                                    <li><a href="#">4:30 AM</a></li>
                                    <li><a href="#">5:00 AM</a></li>
                                    <li><a href="#">5:30 AM</a></li>
                                    <li><a href="#">6:00 AM</a></li>
                                    <li><a href="#">6:30 AM</a></li>
                                    <li><a href="#">7:00 AM</a></li>
                                    <li><a href="#">7:30 AM</a></li>
                                    <li><a href="#">8:00 AM</a></li>
                                    <li><a href="#">8:30 AM</a></li>
                                    <li><a href="#">9:00 AM</a></li>
                                    <li><a href="#">9:30 AM</a></li>
                                    <li><a href="#">10:00 AM</a></li>
                                    <li><a href="#">10:30 AM</a></li>
                                    <li><a href="#">11:00 AM</a></li>
                                    <li><a href="#">11:30 AM</a></li>
                                    <li><a href="#">12:00 PM</a></li>
                                    <li><a href="#">12:30 PM</a></li>
                                    <li><a href="#">1:00 PM</a></li>
                                    <li><a href="#">1:30 PM</a></li>
                                    <li><a href="#">2:00 PM</a></li>
                                    <li><a href="#">2:30 PM</a></li>
                                    <li><a href="#">3:00 PM</a></li>
                                    <li><a href="#">3:30 PM</a></li>
                                    <li><a href="#">4:00 PM</a></li>
                                    <li><a href="#">4:30 PM</a></li>
                                    <li><a href="#">5:00 PM</a></li>
                                    <li><a href="#">5:30 PM</a></li>
                                    <li><a href="#">6:00 PM</a></li>
                                    <li><a href="#">6:30 PM</a></li>
                                    <li><a href="#">7:00 PM</a></li>
                                    <li><a href="#">7:30 PM</a></li>
                                    <li><a href="#">8:00 PM</a></li>
                                    <li><a href="#">8:30 PM</a></li>
                                    <li><a href="#">9:00 PM</a></li>
                                    <li><a href="#">9:30 PM</a></li>
                                    <li><a href="#">10:00 PM</a></li>
                                    <li><a href="#">10:30 PM</a></li>
                                    <li><a href="#">11:00 PM</a></li>
                                    <li><a href="#">11:30 PM</a></li>
                                </ul>
                            </div>
                        </div>

                        <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_BOOKING_FORM}}">
                        <input type="hidden" name="place_id" value="{{$place->id}}">
                        @guest()
                        <button class="btn btn-login open-login">{{__('Send')}}</button>
                        @else
                        <button class="btn booking_submit_btn">{{__('Send')}}</button>
                        @endguest
                        <p class="note">{{__("You won't be charged yet")}}</p>

                        <div class="alert alert-success alert_booking booking_success">
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill="#20D706" fill-rule="nonzero"
                                        d="M9.967 0C4.462 0 0 4.463 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 0-16.196 8.098 8.098 0 0 1 8.098 8.098 8.098 8.098 0 0 1-8.098 8.098zm3.917-12.338a.868.868 0 0 0-1.208.337l-3.342 6.003-1.862-2.266c-.337-.388-.784-.589-1.207-.336-.424.253-.6.863-.325 1.255l2.59 3.152c.194.252.415.403.646.446l.002.003.024.002c.052.008.835.152 1.172-.45l3.836-6.891a.939.939 0 0 0-.326-1.255z">
                                    </path>
                                </svg>
                                {{__('You successfully created your booking.')}}
                            </p>
                        </div>
                        <div class="alert alert-error alert_booking booking_error">
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill="#FF2D55" fill-rule="nonzero"
                                        d="M11.732 9.96l1.762-1.762a.622.622 0 0 0 0-.88l-.881-.882a.623.623 0 0 0-.881 0L9.97 8.198l-1.761-1.76a.624.624 0 0 0-.883-.002l-.88.881a.622.622 0 0 0 0 .882l1.762 1.76-1.758 1.759a.622.622 0 0 0 0 .88l.88.882a.623.623 0 0 0 .882 0l1.757-1.758 1.77 1.771a.623.623 0 0 0 .883 0l.88-.88a.624.624 0 0 0 0-.882l-1.77-1.771zM9.967 0C4.462 0 0 4.462 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 8.098-8.098 8.098 8.098 0 0 1-8.098 8.098z">
                                    </path>
                                </svg>
                                {{__('An error occurred. Please try again.')}}
                            </p>
                        </div>
                    </form>
                </aside>
                @elseif($place->booking_type === \App\Models\Booking::TYPE_CONTACT_FORM)
                <aside class="widget widget-shadow widget-booking-form">
                    <h3>{{__('Send us a message')}}</h3>
                    <form class="form-underline" id="booking_submit_form" action="" method="post">
                        @csrf
                        <div class="field-input">
                            <input type="text" id="name" name="name" placeholder="{{ __('Enter your name') }} *" required>
                        </div>
                        <div class="field-input">
                            <input type="text" id="email" name="email" placeholder="{{ __('Enter your email') }} *" required>
                        </div>
                        <div class="field-input">
                            <input type="text" id="phone_number" name="phone_number" placeholder="{{ __('Enter your phone') }}">
                        </div>
                        <div class="field-input">
                            <textarea type="text" id="message" name="message"
                                placeholder="{{ __('Enter your message') }}"></textarea>
                        </div>
                        <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_CONTACT_FORM}}">
                        <input type="hidden" name="place_id" value="{{$place->id}}">
                        <button class="btn booking_submit_btn">{{__('Send')}}</button>

                        <div class="alert alert-success alert_booking booking_success">
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill="#20D706" fill-rule="nonzero"
                                        d="M9.967 0C4.462 0 0 4.463 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 0-16.196 8.098 8.098 0 0 1 8.098 8.098 8.098 8.098 0 0 1-8.098 8.098zm3.917-12.338a.868.868 0 0 0-1.208.337l-3.342 6.003-1.862-2.266c-.337-.388-.784-.589-1.207-.336-.424.253-.6.863-.325 1.255l2.59 3.152c.194.252.415.403.646.446l.002.003.024.002c.052.008.835.152 1.172-.45l3.836-6.891a.939.939 0 0 0-.326-1.255z">
                                    </path>
                                </svg>
                                {{__('You successfully created your booking.')}}
                            </p>
                        </div>
                        <div class="alert alert-error alert_booking booking_error">
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill="#FF2D55" fill-rule="nonzero"
                                        d="M11.732 9.96l1.762-1.762a.622.622 0 0 0 0-.88l-.881-.882a.623.623 0 0 0-.881 0L9.97 8.198l-1.761-1.76a.624.624 0 0 0-.883-.002l-.88.881a.622.622 0 0 0 0 .882l1.762 1.76-1.758 1.759a.622.622 0 0 0 0 .88l.88.882a.623.623 0 0 0 .882 0l1.757-1.758 1.77 1.771a.623.623 0 0 0 .883 0l.88-.88a.624.624 0 0 0 0-.882l-1.77-1.771zM9.967 0C4.462 0 0 4.462 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 8.098-8.098 8.098 8.098 0 0 1-8.098 8.098z">
                                    </path>
                                </svg>
                                {{__('An error occurred. Please try again.')}}
                            </p>
                        </div>

                    </form>
                </aside><!-- .widget-reservation -->
                @else
                <aside class="sidebar--shop__item widget widget--ads">
                    @if(setting('ads_sidebar_banner_image'))
                    <a title="Ads" href="{{setting('ads_sidebar_banner_link')}}" target="_blank" rel="nofollow"><img
                            src="{{asset('uploads/' . setting('ads_sidebar_banner_image'))}}"
                            alt="banner ads golo"></a>
                    <!-- <aside class="widget widget-shadow widget-reservation">
                                <h3>{{__('Make a reservation')}}</h3>
                                <form action="#" method="POST" class="form-underline" id="booking_form">
                                    @csrf
                                    <div class="field-select has-sub field-guest">
                                        <span class="sl-icon"><i class="la la-user-friends"></i></span>
                                        <input type="text" placeholder="Guest *" readonly>
                                        <i class="la la-angle-down"></i>
                                        <div class="field-sub">
                                            <ul>
                                                <li>
                                                    <span>{{__('Adults')}}</span>
                                                    <div class="shop-details__quantity">
                                                    <span class="minus">
                                                        <i class="la la-minus"></i>
                                                    </span>
                                                        <input type="number" name="numbber_of_adult" value="0" class="qty number_adults">
                                                        <span class="plus">
                                                        <i class="la la-plus"></i>
                                                    </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>{{__('Childrens')}}</span>
                                                    <div class="shop-details__quantity">
                                                    <span class="minus">
                                                        <i class="la la-minus"></i>
                                                    </span>
                                                        <input type="number" name="numbber_of_children" value="0" class="qty number_childrens">
                                                        <span class="plus">
                                                        <i class="la la-plus"></i>
                                                    </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="field-select field-date">
                                        <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                        <input type="text" name="date" placeholder="Date *" class="datepicker" autocomplete="off">
                                        <i class="la la-angle-down"></i>
                                    </div>
                                    <div class="field-select has-sub field-time">
                                        <span class="sl-icon"><i class="la la-clock"></i></span>
                                        <input type="text" name="time" placeholder="Time" readonly>
                                        <i class="la la-angle-down"></i>
                                        <div class="field-sub">
                                            <ul>
                                                <li><a href="#">12:00 AM</a></li>
                                                <li><a href="#">12:30 AM</a></li>
                                                <li><a href="#">1:00 AM</a></li>
                                                <li><a href="#">1:30 AM</a></li>
                                                <li><a href="#">2:00 AM</a></li>
                                                <li><a href="#">2:30 AM</a></li>
                                                <li><a href="#">3:00 AM</a></li>
                                                <li><a href="#">3:30 AM</a></li>
                                                <li><a href="#">4:00 AM</a></li>
                                                <li><a href="#">4:30 AM</a></li>
                                                <li><a href="#">5:00 AM</a></li>
                                                <li><a href="#">5:30 AM</a></li>
                                                <li><a href="#">6:00 AM</a></li>
                                                <li><a href="#">6:30 AM</a></li>
                                                <li><a href="#">7:00 AM</a></li>
                                                <li><a href="#">7:30 AM</a></li>
                                                <li><a href="#">8:00 AM</a></li>
                                                <li><a href="#">8:30 AM</a></li>
                                                <li><a href="#">9:00 AM</a></li>
                                                <li><a href="#">9:30 AM</a></li>
                                                <li><a href="#">10:00 AM</a></li>
                                                <li><a href="#">10:30 AM</a></li>
                                                <li><a href="#">11:00 AM</a></li>
                                                <li><a href="#">11:30 AM</a></li>
                                                <li><a href="#">12:00 PM</a></li>
                                                <li><a href="#">12:30 PM</a></li>
                                                <li><a href="#">1:00 PM</a></li>
                                                <li><a href="#">1:30 PM</a></li>
                                                <li><a href="#">2:00 PM</a></li>
                                                <li><a href="#">2:30 PM</a></li>
                                                <li><a href="#">3:00 PM</a></li>
                                                <li><a href="#">3:30 PM</a></li>
                                                <li><a href="#">4:00 PM</a></li>
                                                <li><a href="#">4:30 PM</a></li>
                                                <li><a href="#">5:00 PM</a></li>
                                                <li><a href="#">5:30 PM</a></li>
                                                <li><a href="#">6:00 PM</a></li>
                                                <li><a href="#">6:30 PM</a></li>
                                                <li><a href="#">7:00 PM</a></li>
                                                <li><a href="#">7:30 PM</a></li>
                                                <li><a href="#">8:00 PM</a></li>
                                                <li><a href="#">8:30 PM</a></li>
                                                <li><a href="#">9:00 PM</a></li>
                                                <li><a href="#">9:30 PM</a></li>
                                                <li><a href="#">10:00 PM</a></li>
                                                <li><a href="#">10:30 PM</a></li>
                                                <li><a href="#">11:00 PM</a></li>
                                                <li><a href="#">11:30 PM</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_BOOKING_FORM}}">
                                    <input type="hidden" name="place_id" value="{{$place->id}}">
                                    @guest()
                                        <button class="btn btn-login open-login">{{__('Send')}}</button>
                                    @else
                                        <button class="btn booking_submit_btn">{{__('Send')}}</button>
                                    @endguest
                                    <p class="note">{{__("You won't be charged yet")}}</p>

                                    <div class="alert alert-success alert_booking booking_success">
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <path fill="#20D706" fill-rule="nonzero" d="M9.967 0C4.462 0 0 4.463 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 0-16.196 8.098 8.098 0 0 1 8.098 8.098 8.098 8.098 0 0 1-8.098 8.098zm3.917-12.338a.868.868 0 0 0-1.208.337l-3.342 6.003-1.862-2.266c-.337-.388-.784-.589-1.207-.336-.424.253-.6.863-.325 1.255l2.59 3.152c.194.252.415.403.646.446l.002.003.024.002c.052.008.835.152 1.172-.45l3.836-6.891a.939.939 0 0 0-.326-1.255z"></path>
                                            </svg>
                                            {{__('You successfully created your booking.')}}
                                        </p>
                                    </div>
                                    <div class="alert alert-error alert_booking booking_error">
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <path fill="#FF2D55" fill-rule="nonzero"
                                                        d="M11.732 9.96l1.762-1.762a.622.622 0 0 0 0-.88l-.881-.882a.623.623 0 0 0-.881 0L9.97 8.198l-1.761-1.76a.624.624 0 0 0-.883-.002l-.88.881a.622.622 0 0 0 0 .882l1.762 1.76-1.758 1.759a.622.622 0 0 0 0 .88l.88.882a.623.623 0 0 0 .882 0l1.757-1.758 1.77 1.771a.623.623 0 0 0 .883 0l.88-.88a.624.624 0 0 0 0-.882l-1.77-1.771zM9.967 0C4.462 0 0 4.462 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 8.098-8.098 8.098 8.098 0 0 1-8.098 8.098z"></path>
                                            </svg>
                                            {{__('An error occurred. Please try again.')}}
                                        </p>
                                    </div>
                                </form>
                            </aside>.widget-reservation -->
                    @endif
                </aside>
                @endif
            --}}
            </div><!-- .sidebar -->

                    <div class="contact_map_section poistion-relative">
                        <div class="contact_sidebar_map">
                            <div class="contact-sidebar" style="width:100%; background-color:{{$place['categories'][0]['color_code']}}">
                                <div class="container row map_address">
                                    <div class="col-lg-6" style="padding-left:30px;">
                                        <h3 class="place__title--additional color-green text-center mb-3">
                                            {{__('Location & Maps')}}
                                        </h3>
                                        <div class="address text-center pt-2">
                                            <i class="la la-map-marker"></i>
                                            {{$place->address}}
                                        </div>
                                        <a href="https://maps.google.com/?q={{$place->address}}" title="{{__('Direction')}}" target="_blank"
                                                rel="nofollow" style="color:{{$place['categories'][0]['color_code']}};background-color:white;">{{__('Directions')}}</a>
                                        @php
                                        $have_opening_hour = false;
                                        foreach ($place->opening_hour as $opening):
                                        if ($opening['title'] && $opening['value']):
                                        $have_opening_hour = true;
                                        endif;
                                        endforeach
                                        @endphp
                                        @if($have_opening_hour)

                                        <div class="place__box place__box-open" style="margin-top:30px;">
                                            <h3 class="place__title--additional color-green text-center">
                                                {{__('Opening Hours')}}
                                            </h3>
                                            <div style="display:flex" class="pt-2">
                                                <div>
                                                    <i class="fas fa-clock" style="color:white; margin-right:10px;"></i>
                                                </div>
                                                <div>
                                                    @if(isUserHaveMembership() || true)
                                                    <div class="open-table">
                                                        <ul>
                                                            @foreach($place->opening_hour as $opening)
                                                            @if($opening['title'] && $opening['value'])
                                                            <li>
                                                                <div class="day" style="width:85px;">{{$opening['title']}}</div>
                                                                <div class="time" align="right">{{$opening['value']}}</div>
                                                            </li>
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @else
                                                    <div class="featured_hide_img">
                                                        <img src="../assets/images/blurimg1.jpg" class="img-fluid" />
                                                        <div class="membership_info">
                                                            @guest
                                                            <p>{{ __('Please login to view this information') }}</p>
                                                            <a href="javascript:void(0);" class="btn open-signup">{{ __('Join Now') }}</a>
                                                            @else
                                                            @if(!isUserHaveMembership())
                                                            <p>{{ __('Purchase membership plan to view this information') }}</p>
                                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#plan_feature"
                                                                class="btn">{{ __('Subscribe Now') }}</a>
                                                            @endif
                                                            @endguest
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- isUserHaveMembership -->
                                        </div><!-- .place__box -->
                                        @endif
                                    </div>
                                    <div class="col-lg-6 row">
                                        @if($place['categories'][0]['slug'] != 'see')
                                        <div class="col-sm-8" style="padding-left:30px;">
                                            <h3 class="place__title--additional color-green text-center mb-3">
                                                {{__('Contact Information')}}
                                            </h3>
                                            @if($place->categories[0]->slug != 'see')
                                                @if($place->hide_info==0)

                                                <div class="place__box pt-2">

                                                    @if(isUserHaveMembership() || true)
                                                    <ul class="place__contact">
                                                        @if($place->phone_number)
                                                        <li>
                                                            <div>
                                                                <i class="la la-phone color-green"></i>
                                                            </div>
                                                            <div>
                                                                <a href="tel:{{$place->phone_number}}" rel="nofollow">{{$place->phone_number}}</a>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @if($place->website)
                                                        <?php $websiteurl = strpos($place->website, "https") === 0 || strpos($place->website, "http") === 0 ? $place->website : '//'.$place->website; ?>
                                                        <li>
                                                            <div>
                                                                <i class="la la-globe color-green"></i>
                                                            </div>
                                                            <div>
                                                                <a href="{{$websiteurl}}" target="_blank" rel="nofollow">{{$place->website}}</a>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @if($place->email)
                                                        <li>
                                                            <div>
                                                                <i class="la la-envelope color-green"></i>
                                                            </div>
                                                            <div>
                                                                <a href="mailto:{{$place->email}}" rel="nofollow">{{$place->email}}</a>
                                                            </div>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                    {{-- <div style="margin-top: 30px;">
                                                        <h3 class="place__title--additional color-green text-center mb-3">
                                                            {{__('Social Media')}}
                                                        </h3>
                                                        @if($place->social)
                                                            @foreach($place->social as $social)
                                                                @if($social['name'] && $social['url'])
                                                                    @if(substr($social['url'], 0, 3) === "www")
                                                                        <a href="//{{$social['url']}}" title="{{$social['url']}}" rel="nofollow" target="_blank"><i class="fab fa-{{SOCIAL_LIST[$social['name']]['name']}} map_social_icon"></i></a>
                                                                    @elseif(filter_var($social['url'],FILTER_VALIDATE_URL) === false)
                                                                        <a href="{{SOCIAL_LIST[$social['name']]['base_url'] . $social['url']}}"
                                                                        title="{{$social['url']}}" rel="nofollow" target="_blank"><i class="fab fa-{{SOCIAL_LIST[$social['name']]['name']}} map_social_icon"></i></a>
                                                                    @else
                                                                        <a href="{{$social['url']}}" title="{{$social['url']}}" rel="nofollow" target="_blank"><i class="fab fa-{{SOCIAL_LIST[$social['name']]['name']}} map_social_icon"></i></a>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div> --}}
                                                    @else
                                                    <div class="featured_hide_img">
                                                        <img src="../assets/images/blurimg2.jpg" class="img-fluid" />
                                                        <div class="membership_info">
                                                            @guest
                                                            <p>{{ __('Please login to view this information') }}</p>
                                                            <a href="javascript:void(0);" class="btn open-signup">{{ __('Join Now') }}</a>
                                                            @else
                                                            @if(!isUserHaveMembership())
                                                            <p>{{ __('Purchase membership plan to view this information') }}</p>
                                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#plan_feature"
                                                                class="btn">{{ __('Subscribe Now') }}</a>
                                                            @endif
                                                            @endguest
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <!-- isUserHaveMembership -->
                                                </div><!-- .place__box -->

                                                @endif
                                            @endif
                                        </div>
                                        @else
                                        @endif
                                        @if($place->categories[0]->slug != 'see')
                                        <div class="col-sm-4" style="padding-left:30px;">
                                            <h3 style="color:white">{{__('Got questions?')}}</h3>
                                            {{-- @if($place->booking_type === \App\Models\Booking::TYPE_BOOKING_FORM) --}}
                                            @if($place['categories'][0]['slug'] == 'eat' && $place->booking_type !== \App\Models\Booking::TYPE_CONTACT_FORM)
                                            @guest()
                                            <button class="btn btn-login open-login" style="width: 172px; height: 40px; border-radius: 20px; color:{{$place['categories'][0]['color_code']}};background-color:white; margin-top:20px;">{{__('Make a reservation')}}</button>
                                            @else
                                            <a href="javascript:;" class="btn add_reservation_btn" data-id="{{$place['id']}}" data-category="{{$place['categories'][0]['slug']}}" data-toggle="modal" data-target="#reservation_model" style="width: 172px; height: 40px; border-radius: 20px; color:{{$place['categories'][0]['color_code']}};background-color:white; margin-top:20px;">
                                                {{__('Make a reservation')}}
                                            </a>
                                            @endguest
                                            @elseif($place->booking_type === \App\Models\Booking::TYPE_CONTACT_FORM)
                                            <a href="javascript:;" class="btn" data-toggle="modal" data-target="#inquiry_model" style="color:{{$place['categories'][0]['color_code']}};background-color:white;">
                                                {{__('Send me a message')}}
                                            </a>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="place__box place__box-map border-0 p-0">
                        {{-- @if(isUserHaveMembership()) --}}
                        <div class="maps">
                            <div id="golo-place-map"></div>

                            <input type="hidden" id="place_lat" value="{{$place->lat}}">
                            <input type="hidden" id="place_lng" value="{{$place->lng}}">
                            {{--
                            <!-- <input type="hidden" id="place_icon_marker" value="{{getImageUrl($categories[0]['icon_map_marker'])}}"> -->
                            --}}
                            <input type="hidden" id="place_icon_marker"
                                value="{{getCategoryMakerUrl($categories[0]['id'])}}.png">
                        </div>
                        {{-- @else --}}
                        <!-- <div class="featured_hide_img">
                                        <img src="../assets/images/blurimg3.jpg" class="img-fluid"/>
                                        <div class="membership_info"> -->
                        {{-- @guest --}}
                        <!-- <p>Please login to view this information</p>
                                                <a href="javascript:void(0);" class="btn open-signup">Join Now</a> -->
                        {{-- @else --}}
                        {{-- @if(!isUserHaveMembership()) --}}
                        <!-- <p>Purchase membership plan to view this information</p>
                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#plan_feature" class="btn">Subscribe Now</a>                                  -->
                        {{-- @endif --}}
                        {{-- @endguest --}}
                        <!-- </div>
                                    </div> -->
                        {{-- @endif --}}
                        <!-- isUserHaveMembership -->
                    </div><!-- .place__box -->
                </div>

        </div>
    </div>
    </div><!-- .place -->

    <!--add to cart modal -->
    {{-- @if($place->categories[0]->slug != 'eat') --}}
        @if($place->categories[0]->slug != 'stay')
            <div class="modal fade cart-modal p-0" id="cart-model" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered" role="document">
                    <div class="modal-content" style="border:1px solid {{$place->categories[0]->color_code}}; padding: 0; width: 320px;">
                        <div class="modal-header" style="background-color:{{$place->categories[0]->color_code}}">
                            {{-- <div class="cart-modal-carticon">
                                @php
                                    $carturl = 'assets/images/cart/' . $place->categories[0]->slug . '.svg';
                                @endphp
                                <img style="width:100%; height:auto; filter:drop-shadow(2px 2px 0px white); mask: url(#mask-element);"
                                    src="{{ asset($carturl) }}" alt="{{$place->categories[0]->name}}"
                                >
                            </div> --}}
                            <div class="cart-modal-title" style="display: flex; margin: auto; justify-content: space-between;">
                                <h3>{{__('Add To Cart')}}</h3>
                                {{-- <div class="cart-modal-price">
                                    <h3 class="ml-auto"><span id="cart_product_price"></span></h3>
                                    <input type="hidden" id="modal_cart_product_price" value="0" />
                                    <input type="hidden" id="modal_cart_product_child_price" value="0" />
                                </div> --}}
                            </div>
                            {{-- <a class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a> --}}
                        </div>
                        <input type="hidden"  value="0"  id="max_child_per_room">
                        <input type="hidden"  value="0"  id="max_adult_per_room">
                        <div class="d-block cart-modal-form">
                            <aside class="widget-shadow widget-reservation mb-0 d-block" style="padding: 20px">
                                <div class="top-booking-details d-block" style="margin-bottom: 10px; padding-bottom: 10px">
                                    <div>
                                        <label class="place-name">{{$place->name}}</label>
                                    </div>
                                    <div>
                                        <label style="color:{{$place->categories[0]->color_code}}; width:100%"><span id="cart_product_name"></span></label>
                                    </div>
                                </div>
                                <form action="#" method="POST" class="form-underline" id="add_to_cart_form" style="color:{{$place->categories[0]->color_code}}">
                                    @csrf
                                    <input type="hidden" name="all_day" value="0" id="all_day_slot">
                                    <input type="hidden" name="category" id="category" value="{{ $place->categories[0]->slug }}">
                                    <!-- @if($place->categories[0]->slug != 'stay' && $place->categories[0]->slug != 'rent')
                                    @endif -->
                                    
                                    {{-- @if($place->categories[0]->slug == 'stay')
                                    <span>Nights</span>
                                    @elseif($place->categories[0]->slug == 'rent')
                                    <span>Days</span>
                                    @endif --}}
                                <!-- @if($place->categories[0]->slug != 'stay' && $place->categories[0]->slug != 'rent')
                                    @else
                                    @endif  -->
                                    <label class="field_desc">Date</label>
                                    <div class="field-select field-date">
                                        {{-- <input type="text" min="{{ date('Y-m-d') }}" name="date" class="cart_datepicker" placeholder="Date *"
                                            autocomplete="off"> --}}
                                        <div class="calendar-wrapper">
                                            <input type="text" id="txtBookingDate" class="input-border" placeholder="Date" name="date" autocomplete="off">
                                            <div class="loading-wrapper hidden">
                                                <img src="{{ asset('assets/images/loading.gif') }}">
                                            </div>
                                            <div id="divBookingDateCalendar"></div>
                                        </div>
                                        <!-- <input type="text" name="date" placeholder="Date *" class="datepicker" autocomplete="off"> -->
                                        <i class="la la-calendar-alt"></i>
                                        <span style="color:red;display:none;" class="dateerror">{{ __('Please select date') }}</span>
                                    </div>

                                    <!-- @if($place->categories[0]->slug != 'stay' && $place->categories[0]->slug != 'rent')
                                    @endif -->
                                    <label class="field_desc">Time</label>
                                    <div class="field-select has-sub field-time slot_div">
                                        <input id="slot_time" type="text" name="time" placeholder="Time" readonly class="input-border">
                                        <i class="la la-clock"></i>
                                        <div class="field-sub">
                                            <ul id="slot_availability">
                                            </ul>
                                        </div>
                                        <span style="color:red;display:none;" class="timeerror">{{ __('Please select time') }}</span>
                                    </div>

                                    <label class="field_desc">Guest *</label>
                                    <div id="divFieldSeats" class="hidden"><span></span> seats available</div>

                                    <div class="field-select has-sub field-guest">
                                        <input type="text" placeholder="No. of Guests" id="guest_num" readonly class="input-border">

                                        <i class="la la-angle-down"></i>
                                        <div class="field-sub">
                                            <ul>
                                                @if($place->categories[0]->slug == 'travel' && $place->slug == 'sealink')
                                                    <li class="car-price-hide">
                                                        <span>{{__('Vehicles')}}</span>
                                                        <div class="shop-details__quantity">
                                                            <span class="minus car-minus">
                                                                <i class="la la-minus"></i>
                                                            </span>
                                                            <input type="number" name="number_of_car" value="0"
                                                                class="qty number_car" id="number_of_car" readonly>
                                                            <span class="plus car-plus">
                                                                <i class="la la-plus"></i>
                                                            </span>
                                                        </div>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span>{{__('Adults')}} @if($place->categories[0]->slug == 'stay' || $place->categories[0]->slug == 'rent') {{$place->categories[0]->getPriceText()}}@endif</span>
                                                    <div class="shop-details__quantity">
                                                        <span class="minus adults-minus">
                                                            <i class="la la-minus"></i>
                                                        </span>
                                                        <input type="number" name="number_of_adult" value="1"
                                                            class="qty number_adults" id="number_of_adult" readonly>
                                                        <span class="plus adults-plus">
                                                            <i class="la la-plus"></i>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>{{__('Childrens')}} @if($place->categories[0]->slug == 'stay' || $place->categories[0]->slug == 'rent') {{$place->categories[0]->getPriceText()}}@endif</span>
                                                    <div class="shop-details__quantity">
                                                        <span class="minus child-minus">
                                                            <i class="la la-minus"></i>
                                                        </span>
                                                        <input type="number" name="number_of_children" value="0"
                                                            class="qty number_childrens" id="number_of_children" readonly>
                                                        <span class="plus child-plus">
                                                            <i class="la la-plus"></i>
                                                        </span>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                        <span style="color:red;display:none;" class="adulterror">{{ __('Please enter number of adult') }}</span>
                                    </div>

                                    <input type="hidden" id="cart_place_product_id" name="place_product_id" value="">
                                    <input type="hidden" name="place_id" value="{{$place->id}}">
                                    @guest()
                                    <button class="btn btn-login open-login" style="background-color: {{$place->categories[0]->color_code}}">{{__('Add to Cart')}}</button>
                                    @else
                                    <button class="btn add_to_cart_submit_btn" style="background-color: {{$place->categories[0]->color_code}}">{{__('Add to Cart')}}</button>
                                    @endguest
                                    <!-- <p class="note">{{__("You won't be charged yet")}}</p> -->
                                    @if(isset($menu) && !empty($menu))
                                    <input type="hidden" id="menuid" value="{{ $menu['id'] }}">
                                    <input type="hidden" id="adultprice"
                                        value="@if(checkIfOnDiscount($menu)){{checkIfOnDiscount($menu,true)}}@else{{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}}@endif">
                                    <input type="hidden" id="carprice"
                                        value="@if(checkIfOnCarDiscount($menu)){{checkIfOnCarDiscount($menu,true)}}@else{{cleanDecimalZeros($menu['car_price'])}}@endif">
                                    <input type="hidden" id="childprice"
                                        value="@if(checkIfOnChildDiscount($menu)){{checkIfOnChildDiscount($menu,true)}}@else{{checkIfOnChildDiscount($menu['child_price'])}}@endif">
                                    <input type="hidden" id="newprice"
                                        value="@if(checkIfOnDiscount($menu)){{checkIfOnDiscount($menu,true)}}@else{{cleanDecimalZeros(getRezdyPrice($menu, $menu['price']))}}@endif">
                                    @endif
                                </form>
                            </aside><!-- .widget-reservation -->
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade cart-modal p-0" id="cart-model" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered" role="document">
                    <div class="modal-content" style="border:1px solid {{$place->categories[0]->color_code}}">
                        <div class="modal-header" style="background-color:{{$place->categories[0]->color_code}}">
                            {{-- <div class="cart-modal-carticon">
                                @php
                                    $carturl = 'assets/images/cart/' . $place->categories[0]->slug . '.svg';
                                @endphp
                                <img style="width:100%; height:auto; filter:drop-shadow(2px 2px 0px white); mask: url(#mask-element);"
                                    src="{{ asset($carturl) }}" alt="{{$place->categories[0]->name}}"
                                >
                            </div> --}}
                            <div class="cart-modal-title" style="display: flex; margin: auto; justify-content: space-between;">
                                <h3>{{__('Add To Cart')}}</h3>
                                {{-- <div class="cart-modal-price">
                                    <h3 class="ml-auto"><span id="cart_product_price"></span></h3>
                                    <input type="hidden" id="modal_cart_product_price" value="0" />
                                    <input type="hidden" id="modal_cart_product_child_price" value="0" />
                                </div> --}}
                            </div>
                            {{-- <a class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a> --}}
                        </div>
                        <input type="hidden"  value="0"  id="max_child_per_room">
                        <input type="hidden"  value="0"  id="max_adult_per_room">
                        <div class="d-block cart-modal-form">
                            <aside class="widget-shadow widget-reservation mb-0 d-block">
                                <div class="top-booking-details d-block" style="margin-bottom: 10px; padding-bottom: 10px">
                                    <div>
                                        <label class="place-name">{{$place->name}}</label>
                                    </div>
                                    <div>
                                        <label style="color:{{$place->categories[0]->color_code}}; width: 100%"><span id="cart_product_name"></span></label>
                                    </div>
                                </div>
                                <form action="#" method="POST" class="form-underline" id="add_to_cart_form" style="color:{{$place->categories[0]->color_code}}">
                                    @csrf
                                    <input type="hidden" name="all_day" value="0" id="all_day_slot">
                                    <input type="hidden" name="category" id="category" value="{{ $place->categories[0]->slug }}">
                                    <!-- @if($place->categories[0]->slug != 'stay' && $place->categories[0]->slug != 'rent')
                                    @endif -->
                                    <div class="number-input position-relative field-select">
                                        <label class="field_desc">Number of room :</label>
                                        <input type="number" style="margin-bottom:0px;"  min="1" value="1" max="999" name="no_of_room" id="no_of_room"
                                            class="input input-border" placeholder="Rooms">
                                    </div>
                                    <span style="color:red;display:none; text-align: left;" class="no_of_room_err">{{ __('Please add number of room') }}</span>

                                    <label class="field_desc">Guest * :</label>
                                    <div class="field-select has-sub field-guest">
                                        <span class="sl-icon"><i class="la la-user-friends"></i></span>
                                        <input type="text" placeholder="Guest *" id="guest_num" readonly class="input-border">

                                        <i class="la la-angle-down"></i>
                                        <div class="field-sub">
                                            <ul>
                                                <li>
                                                    <span>{{__('Adults')}} @if($place->categories[0]->slug == 'stay' || $place->categories[0]->slug == 'rent') {{$place->categories[0]->getPriceText()}}@endif</span>
                                                    <div class="stay_shop_details_quantity">
                                                        <span class="minus adults-minus">
                                                            <i class="la la-minus"></i>
                                                        </span>
                                                        <input type="number" name="number_of_adult" value="1" class="qty stay_number_adults" id="stay_number_adults" readonly>
                                                        <span class="plus adults-plus">
                                                            <i class="la la-plus"></i>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>{{__('Childrens')}} @if($place->categories[0]->slug == 'stay' || $place->categories[0]->slug == 'rent') {{$place->categories[0]->getPriceText()}}@endif</span>
                                                    <div class="stay_shop_details_quantity">
                                                        <span class="minus child-minus">
                                                            <i class="la la-minus"></i>
                                                        </span>
                                                        <input type="number" name="number_of_children" value="0"
                                                            class="qty stay_number_childrens" id="stay_number_childrens" readonly>
                                                        <span class="plus child-plus">
                                                            <i class="la la-plus"></i>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <span style="color:red;display:none;" class="adulterror">{{ __('Please enter number of adult') }}</span>
                                    </div>
                                    <input type="hidden" name="date" id="check_in_date">
                                    <input type="hidden" name="checkout_date" id="check_out_date">
                                    <label class="field_desc">Date :</label>
                                    <div class="field-select field-date">
                                        {{-- <span class="sl-icon"><i class="la la-calendar-alt"></i></span> --}}
                                        <input id="date_range_picker" type="text" min="{{ date('Y-m-d') }}" name="date_range" placeholder="{{$place->categories[0]->slug == 'stay' ? 'Select check in date' : 'Select date'}}"
                                            autocomplete="off" class="input-border">
                                        <!-- <input type="text" name="date" placeholder="Date *" class="datepicker" autocomplete="off"> -->
                                        <i class="la la-calendar-alt"></i>
                                        <span style="color:red;display:none; text-align: left;" class="checkout_dateerror">{{ __('Please select date range') }}</span>
                                    </div>
                                    <input type="hidden" id="cart_place_product_id" name="place_product_id" value="">
                                    <input type="hidden" name="place_id" value="{{$place->id}}">
                                    @guest()
                                    <button class="btn btn-login open-login" style="background-color: {{$place->categories[0]->color_code}}">{{__('Add')}}</button>
                                    @else
                                    <button class="btn add_to_cart_submit_btn" style="background-color: {{$place->categories[0]->color_code}}">{{__('Add')}}</button>
                                    @endguest
                                    <!-- <p class="note">{{__("You won't be charged yet")}}</p> -->
                                    <input type="hidden" id="pernightprice" value="-">
                                </form>
                            </aside><!-- .widget-reservation -->
                        </div>
                    </div>
                </div>
            </div>
        @endif
    {{-- @endif --}}
    <!--  -->
    @if($place->categories[0]->slug == 'eat')
    <!-- reservation_model -->
    <div class="modal fade cart-modal p-0" id="reservation_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content" style="border-color:{{$place->categories[0]->color_code}}">
                <div class="modal-header"  style="background-color:{{$place->categories[0]->color_code}}">
                    {{-- <div class="cart-modal-carticon">
                        @php
                            $carturl = 'assets/images/cart/' . $place->categories[0]->slug . '.svg';
                        @endphp
                        <img style="width:100%; height:auto; filter:drop-shadow(2px 2px 0px white); mask: url(#mask-element);"
                            src="{{ asset($carturl) }}" alt="{{$place->categories[0]->name}}"
                        >
                    </div> --}}
                    <div class="cart-modal-title" style="display: flex; margin: auto; justify-content: space-between;">
                        <h3>{{__('Make a reservation')}}</h3>
                        {{-- <div class="cart-modal-price">
                            <h3 class="ml-auto"><span id="cart_product_price"></span></h3>
                            <input type="hidden" id="modal_cart_product_price" value="0" />
                            <input type="hidden" id="modal_cart_product_child_price" value="0" />
                        </div> --}}
                    </div>
                    {{-- <a class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a> --}}
                </div>
                <div class="d-block cart-modal-form">
                   <aside class="widget-shadow widget-reservation d-block">
                        <div class="top-booking-details d-block" style="margin-bottom: 10px; padding-bottom: 10px">
                            <div>
                                <label class="place-name">{{$place->name}}</label>
                            </div>
                        </div>
                        <form action="#" method="POST" class="form-underline" id="booking_form">
                            @csrf
                            <label class="field_desc">Date</label>
                            <div class="field-select field-date">
                                {{-- <span class="sl-icon"><i class="la la-calendar-alt"></i></span> --}}
                                <input type="text" id="date-picker-reservation" data-place="{{$place['id']}}" data-category="{{$place['categories'][0]['slug']}}" class="date-picker-input input-border" name="date" placeholder="Date *" autocomplete="off">
                                <i class="la la-calendar-alt"></i>
                            </div>
                            <label class="field_desc">Time</label>
                            <div class="field-select has-sub field-time slot_div_res" id="slot_div_res">
                                {{-- <span class="sl-icon"><i class="la la-clock"></i></span> --}}
                                <input type="text" name="time" id="slot_time" placeholder="Time" readonly class="input-border">
                                <i class="la la-clock"></i>
                                <div class="field-sub">
                                    <ul id="slot_availability">
                                        {{-- <li><a href="#">8:00 AM</a></li>
                                        <li><a href="#">8:30 AM</a></li>
                                        <li><a href="#">9:00 AM</a></li>
                                        <li><a href="#">9:30 AM</a></li>
                                        <li><a href="#">10:00 AM</a></li>
                                        <li><a href="#">10:30 AM</a></li>
                                        <li><a href="#">11:00 AM</a></li>
                                        <li><a href="#">11:30 AM</a></li>
                                        <li><a href="#">12:00 PM</a></li>
                                        <li><a href="#">12:30 PM</a></li>
                                        <li><a href="#">1:00 PM</a></li>
                                        <li><a href="#">1:30 PM</a></li>
                                        <li><a href="#">2:00 PM</a></li>
                                        <li><a href="#">2:30 PM</a></li>
                                        <li><a href="#">3:00 PM</a></li>
                                        <li><a href="#">3:30 PM</a></li>
                                        <li><a href="#">4:00 PM</a></li>
                                        <li><a href="#">4:30 PM</a></li>
                                        <li><a href="#">5:00 PM</a></li>
                                        <li><a href="#">5:30 PM</a></li>
                                        <li><a href="#">6:00 PM</a></li>
                                        <li><a href="#">6:30 PM</a></li>
                                        <li><a href="#">7:00 PM</a></li>
                                        <li><a href="#">7:30 PM</a></li>
                                        <li><a href="#">8:00 PM</a></li>
                                        <li><a href="#">8:30 PM</a></li>
                                        <li><a href="#">9:00 PM</a></li>
                                        <li><a href="#">9:30 PM</a></li>
                                        <li><a href="#">10:00 PM</a></li> --}}
                                    </ul>
                                </div>
                            </div>

                            <label class="field_desc">Guest *</label>
                            <div class="field-select has-sub field-guest">
                                <span class="sl-icon"><i class="la la-user-friends"></i></span>
                                <input type="text" placeholder="Guest *" id="guest_num" readonly="" class="input-border">
                                <i class="la la-angle-down"></i>
                                <div class="field-sub active">
                                    <ul>
                                        <li>
                                            <span>Adults </span>
                                            <div class="shop-details__quantity_reservation">
                                                <span class="minus adults-minus">
                                                    <i class="la la-minus"></i>
                                                </span>
                                                <input type="number" name="numbber_of_adult" value="1" class="qty number_adults count_adults" id="number_of_adult" readonly="">
                                                <span class="plus adults-plus">
                                                    <i class="la la-plus"></i>
                                                </span>
                                            </div>
                                        </li>
                                        <li>
                                            <span>Childrens </span>
                                            <div class="shop-details__quantity_reservation">
                                                <span class="minus adults-minus">
                                                    <i class="la la-minus"></i>
                                                </span>
                                                <input type="number" name="numbber_of_children" value="0" class="qty number_adults count_children" id="number_of_children" readonly="">
                                                <span class="plus adults-plus">
                                                    <i class="la la-plus"></i>
                                                </span>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <span style="color:red;display:none;" class="adulterror">Please enter number of adult</span>
                            </div>
                            <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_BOOKING_FORM}}">
                            <input type="hidden" name="place_id" value="{{$place->id}}">
                            @guest()
                            <button class="btn btn-login open-login" style="background-color:{{$place->categories[0]->color_code}}">{{__('Send')}}</button>
                            @else
                            <button class="btn booking_submit_btn" style="background-color:{{$place->categories[0]->color_code}}">{{__('Send')}}</button>
                            @endguest
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- inquiry_model -->
    <div class="modal fade cart-modal p-0" id="inquiry_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content input-border" style="overflow:hidden">
                <div class="modal-header" style="background-color:#f2f2f2;">
                    <h3 style="color:{{$place->categories[0]->color_code}}">{{__('Send us a message')}}</h3>
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:{{$place->categories[0]->color_code}};">&times;</span>
                    </a>
                </div>
                <div class="d-block" style="background-color:#f2f2f2;">
                    <aside class="widget-shadow widget-booking-form">
                        <form class="form-underline" id="booking_submit_form" action="" method="post">
                            @csrf
                            <div class="form-group mb-2 ml-0 mr-0" style="background-color:#fff; padding: 0 15px; flex-wrap: nowrap;">
                                <label style="color:{{$place->categories[0]->color_code}}; display: flex;
                                    align-items: center;">Name:</label>
                                <input class="mb-0 ml-2" type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-2 ml-0 mr-0" style="background-color:#fff; padding: 0 15px; flex-wrap: nowrap;">
                                <label style="color:{{$place->categories[0]->color_code}}; display: flex;
                                    align-items: center;">Email:</label>
                                <input class="mb-0 ml-2" type="text" id="email" name="email" required>
                            </div>
                            {{-- <div class="form-group mb-2 ml-0 mr-0" style="background-color:#fff; padding: 0 15px; flex-wrap: nowrap;">
                                <label style="color:{{$place->categories[0]->color_code}}; display: flex;
                                    align-items: center; width:min-content;">Phone Number:</label>
                                <input class="mb-0 ml-2" type="text" id="phone_number" name="phone_number" >
                            </div> --}}
                            <div class="field-input" style="background-color:#fff; padding: 0 15px;">
                                <p class="pt-2" style="color:{{$place->categories[0]->color_code}}; text-align:left;">Message:</p>
                                <textarea type="text" id="message" name="message"
                                   ></textarea>
                            </div>
                            <div class="form-group" style="margin: 10px 0 10px 0; justify-content: center;">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                            <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_CONTACT_FORM}}">
                            <input type="hidden" name="place_id" value="{{$place->id}}">
                            <button class="btn booking_submit_btn" style="background-color:{{$place->categories[0]->color_code}}">{{__('Send')}}</button>

                            <div class="alert alert-success alert_booking booking_success">
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <path fill="#20D706" fill-rule="nonzero"
                                            d="M9.967 0C4.462 0 0 4.463 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 0-16.196 8.098 8.098 0 0 1 8.098 8.098 8.098 8.098 0 0 1-8.098 8.098zm3.917-12.338a.868.868 0 0 0-1.208.337l-3.342 6.003-1.862-2.266c-.337-.388-.784-.589-1.207-.336-.424.253-.6.863-.325 1.255l2.59 3.152c.194.252.415.403.646.446l.002.003.024.002c.052.008.835.152 1.172-.45l3.836-6.891a.939.939 0 0 0-.326-1.255z">
                                        </path>
                                    </svg>
                                    {{__('You successfully created your booking.')}}
                                </p>
                            </div>
                            <div class="alert alert-error alert_booking booking_error">
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <path fill="#FF2D55" fill-rule="nonzero"
                                            d="M11.732 9.96l1.762-1.762a.622.622 0 0 0 0-.88l-.881-.882a.623.623 0 0 0-.881 0L9.97 8.198l-1.761-1.76a.624.624 0 0 0-.883-.002l-.88.881a.622.622 0 0 0 0 .882l1.762 1.76-1.758 1.759a.622.622 0 0 0 0 .88l.88.882a.623.623 0 0 0 .882 0l1.757-1.758 1.77 1.771a.623.623 0 0 0 .883 0l.88-.88a.624.624 0 0 0 0-.882l-1.77-1.771zM9.967 0C4.462 0 0 4.462 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 8.098-8.098 8.098 8.098 0 0 1-8.098 8.098z">
                                        </path>
                                    </svg>
                                    {{__('An error occurred. Please try again.')}}
                                </p>
                            </div>

                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    </div>
    </div>

    @if(!$similar_places->isEmpty())
    <div class="similar-places">
        <div class="container">
            <h2 class="similar-places__title title">{{__('Similar places')}}</h2>
            <div class="similar-places__content">
                <div class="row">
                    @foreach($similar_places as $place)
                    <div class="col-lg-3 col-md-6">
                        @include('frontend.common.place_item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div><!-- .similar-places -->
    @endif
    @if(auth()->user())
    @if(isOperatorUser())
    @include('frontend.common.operator-plan-modal')
    @else
    @include('frontend.common.user-plan-modal')
    @endif
    @endif
</main><!-- .site-main -->
@stop

@push('scripts')
<script src="{{asset('assets/js/page_place_detail.js')}}"></script>
@if(setting('map_service', 'google_map') === 'google_map')
<script src="{{asset('assets/js/page_place_detail_googlemap.js')}}"></script>
@else
<script src="{{asset('assets/js/page_place_detail_mapbox.js')}}"></script>
@endif
<script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/calendar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cart-modal.css')}}" />

<script src="{{ asset('assets/js/calendar.js') }}"></script>

<script>
    var slotSeats = [];

    function showCalendarLoading() {
        $('.calendar-wrapper .loading-wrapper').removeClass('hidden');
        $('.calendar-wrapper .loading-wrapper').width($('#divBookingDateCalendar').width());
        $('.calendar-wrapper .loading-wrapper').height($('#divBookingDateCalendar').height());
    }

    function hideCalendarLoading() {
        $('.calendar-wrapper .loading-wrapper').addClass('hidden');
    }

    function setData(calendar, year, month) {
        var firstdate = year + '-' + (month + 1) + '-1';
        var lastdate = year + '-' + (month + 2) + '-1';

        if (month == 11) {
            lastdate = (year + 1) + '-1-1';
        } else if (month == 12) {
            firstdate = (year + 1) + '-1-1';
            lastdate = (year + 1) + '-2-1';
        }

        var date = firstdate;
        var product_id = $("#menuid").val();

        showCalendarLoading();
        $.ajax({
            dataType: 'json',
            url: "{{route('get-operator-booking-by-month')}}",
            method: "post",
            data: {
                'date': date,
                'firstdate': firstdate,
                'lastdate': lastdate,
                'product_id': product_id
            },
            async: true,
            success: function (res) {
                hideCalendarLoading();
                var new_data = [];

                if(res.status == true){
                    cdata = res.data;
                    var arrAvailabilityInfo = [];

                    for (let i = 0; i < cdata.length; i++) {
                        const booking_info = cdata[i];

                        var arrStartInfo = booking_info.start.split(' ');
                        if (arrAvailabilityInfo[arrStartInfo[0]] == undefined) {
                            arrAvailabilityInfo[arrStartInfo[0]] = [];
                        }
                        arrAvailabilityInfo[arrStartInfo[0]].push(arrStartInfo[1]);
                    }

                    for (var info_date in arrAvailabilityInfo) {
                        const slot_list = arrAvailabilityInfo[info_date];
                        new_data.push({
                            date: info_date,
                            value: slot_list.join('\n')
                        });
                    }

                    calendar.setData(new_data);
                }else{
                }
            },
            error: function(res) {
                hideCalendarLoading();
            }
        });
        // var new_data = [{
        //     date: year + '-' + (month + 1) + '-' + (date - 1),
        //     value: ' '
        // }, {
        //     date: year + '-' + (month + 1) + '-' + date,
        //     value: ' '
        // }, {
        //     date: new Date(year, month, date + 1),
        //     value: ' '
        // }];
    }

    $(document).ready(function () {
        // picker
        $('#divBookingDateCalendar').calendar({
            trigger: '#txtBookingDate',
            zIndex: 999,
            data: null,
            onSelected: function (calendar, view, date, data) {
                var year = date.getFullYear();
                var month = date.getMonth();

                if (view === 'month') {
                    setData(calendar, year, month);
                    return;
                }

                $('#slot_time').val('');
                setTimeslots([]);
                $('#divFieldSeats').addClass('hidden');

                var day = date.getDate();
                var event_date = (month + 1) + '/' + day + '/' + year;

                var p_id = $("#menuid").val();
                var category = $('#category').val();
                var payload = {
                    id: p_id,
                    category: category,
                    date: event_date,
                }

                $.ajax({
                    dataType: 'json',
                    url: "{{route('product-availability')}}",
                    method: "post",
                    data: payload,
                    success: function (data) {
                        if(data.status === "error") {
                            setTimeslots(timeSlots);
                            return;
                        }
                        if (data.code === 200) {
                            console.log(data);
                            timeSlots = data.data.slot_availibility;
                            setTimeslots(timeSlots);

                            if (data.data.slot_seats) {
                                slotSeats = data.data.slot_seats;
                            } else {
                                slotSeats = [];
                            }
                        }
                    },
                    error: function (e) {
                        setTimeslots(timeSlots);
                    }
                });
            },
            onChangeMonth: function(calendar, year, month) {
                setData(calendar, year, month);
            },
            onOpen: function(calendar) {
                var booking_date = new Date($('#txtBookingDate').val());

                if (isNaN(booking_date.getFullYear())) {
                    booking_date = calendar.options.date;
                    var year = booking_date.getFullYear();
                    var month = booking_date.getMonth();
                    setData(calendar, year, month);
                }                
            }
        });
        
        $('.place-share').removeClass('d-none');
        /*get dynamiv height*/
        // var getheight = $(".custom-gallery img").height();
        //     console.log(getheight)

        // if(getheight >= 200){
        //     $(".custom-gallery").addClass("max-height");
        //     // $(".custom-gallery").removeClass("max-height");

        // }
        // else{
        //     $(".custom-gallery").addClass("min-height");
        //     // $(".custom-gallery").removeClass("max-height");

        // }
        $("#book_now_link").click(function() {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#book_now_target").offset().top
            }, 800);
        });

        $('[data-toggle="tooltip"]').tooltip()
        $(document).on('click','.copyToClipboard',function(){
            navigator.clipboard.writeText('{{url()->current()}}');
            toastr.success('Link copied');
            // notify('copy link successfully.')
        });
        /*share icon js*/
        $(document).on('click', '.share', function () {
            $(this).parent().next().find('.a2a_button').toggleClass('hidden show') ;
            $(this).parent().next().toggleClass('hidden show') ;
        })
        var timeSlots = [];
        let DateEnabled = [];
        function setTimeslots(timeSlots) {
            let HTML ='';
            if(timeSlots[0] == true){
                $("#all_day_slot").val(1);
                $(".slot_div").addClass('d-none');
            }else{
                $("#all_day_slot").val(0);
                $(".slot_div").removeClass('d-none');
            }
            if (timeSlots != true) {
                if (timeSlots.length > 0) {
                    var addedValues = []; // store added values
                    $.each(timeSlots, function (indexInArray, valueOfElement) {
                        if (addedValues.indexOf(valueOfElement) === -1) { // check if value is not already present
                            HTML += `<li><a href="#">${valueOfElement}</a></li>`;
                            addedValues.push(valueOfElement); // add value to the addedValues array
                        }
                    });
                } else {
                    HTML += `<li class"text-center">No slot found</li>`;
                }
            }
            console.log(HTML);
            $("#slot_availability").html(HTML);
        }

        $(document).on('click', '#slot_availability li a', function(event) {
            event.preventDefault();
            var slot_time = $(this).html();
            $("#slot_time").val(slot_time);
            if (slotSeats[slot_time]) {
                $('#divFieldSeats span').html(slotSeats[slot_time]);
                $('#divFieldSeats').removeClass('hidden');
            } else {
                $('#divFieldSeats').addClass('hidden');
            }
        });

        function getAvailability(id, category){
            timeSlots = [];
            $.ajax({
                dataType: 'json',
                url: "{{route('product-availability')}}",
                method: "post",
                data: {id, category},
                success: function (data) {
                    if(data.status === "error") {
                        DateEnabled = [];
                        setTimeslots(timeSlots);
                        return;
                    }
                    if (data.code === 200) {
                        console.log(data);
                        DateEnabled = data.data.availibile_dates;
                        timeSlots = data.data.slot_availibility;
                        setTimeslots(timeSlots);
                    }
                },
                error: function (e) {
                    DateEnabled = [];
                    setTimeslots(timeSlots);
                }
            });
        }
        $(document).on('click', '.add_to_cart_btn', function () {
            $("#date_range_picker").val('');
            $("#check_in_date").val('');
            $("#checkout_date").val('');
            $(".field-time").removeClass('active');
            $("#slot_time").val('');
            $(".cart_datepicker").val('');
            $("#guest_num").val('');
            $("#stay_number_adults").val(0);
            $("#stay_number_childrens").val(0);
            $(".input-border").val('');
                    
            $("#txtBookingDate").val('');
            $('#divFieldSeats').addClass('hidden');
            $("#divBookingDateCalendar").css('display', 'none');

            let max_child_per_room =  $(this).attr('data-max_child_per_room')
            let max_adult_per_room =  $(this).attr('data-max_adult_per_room')
            $("#max_child_per_room").val(max_child_per_room);
            $("#max_adult_per_room").val(max_adult_per_room);
            // if($(this).attr('data-slot') == 1){
            //     $("#all_day_slot").val(1);
            //     $(".slot_div").addClass('d-none');
            // }else{
            //     $("#all_day_slot").val(0)
            //     $(".slot_div").removeClass('d-none');
            // }
            getAvailability($(this).attr('data-id'), $(this).attr('data-category'));
            enabled = ['Monday', 'Tuesday', 'Wednesday'];
            const name = $(this).attr('data-name');
            const price = $(this).attr('data-price');
            const carprice = $(this).attr('data-carprice');
            const child_price = $(this).attr('data-child_price');
            const place_product_id = $(this).attr('data-id');
            $('#cart_product_name').html(name);

            $('#modal_cart_product_child_price').val(child_price.replace('$','').trim());
            $('#cart_place_product_id').val(place_product_id);

            $("#menuid").val(place_product_id);
            var adultprice = price.replace('$','');
            $("#adultprice").val(adultprice.trim());
            var car_price = carprice.replace('$','').trim();
            //if(car_price != ''){
            $("#carprice").val(car_price);
            // }else{
            //     $("#carprice").val(0);
            // }

            if(car_price == 0){
                $('#number_of_adult').val(1);
                $('#number_of_car').val(0);
                $('.car-price-hide').hide();
                $('#cart_product_price').html(price);
                $('#modal_cart_product_price').val(price.replace('$','').trim());
            }else{
                $('#number_of_car').val(1);
                $('#number_of_adult').val(0);
                $('.car-price-hide').show();
                $('#cart_product_price').html(carprice);
                $('#modal_cart_product_price').val(carprice.replace('$','').trim());
            }
            var childprice = child_price.replace('$','').trim();
            if(childprice != ''){
                $("#childprice").val(childprice);
            }else{
                $("#childprice").val(0);
            }

            $("#newprice").val('');
            // $('#number_of_adult').val(1);
            $('#number_of_children').val(0);
            //$('#number_of_car').val(0);
            $("#cart-model").modal('show');
        });

        $(document).on('click', '.add_reservation_btn', function () {
            $(".input-border").val('');
            $('#number_of_adult').val(0);
            $('#number_of_children').val(0);
            getAvailability($(this).attr('data-id'), $(this).attr('data-category'));
        });

            /*on click dropdown js */
        let endDAtee = '2022-05-18';
        $(".cart_datepicker").datepicker({
            locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
            format: 'dd-mm-yyyy',
            autoclose: true,
            minDate: '<?php echo  date('d-m-Y H:i:s');?>',
            disableDates:  function (date) {
                date = date.getFullYear()  + "-" + (date.getMonth()+1) + "-" + date.getDate();
                if (DateEnabled.indexOf(date) == -1 ) {
                    return false;
                } else {
                    return true;
                }
            },
        });
        $('#date_range_picker').daterangepicker({
            language:'{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
            autoApply: true,
            minDate:new Date(),
            locale: {
                format: 'DD-MM-YYYY'
            },
        },
        function(start, end, label) {
        });

        $('#date_range_picker').on('apply.daterangepicker', (e, picker) => {
            console.log('ps',picker.startDate); // contains the selected start date
            console.log('ps',picker.endDate); // contains the selected end date
            $("#check_in_date").val(picker.startDate.format('DD-MM-YYYY'));
            $("#check_out_date").val(picker.endDate.format('DD-MM-YYYY'));
            stayPricecalculation();
        });


        $(".cart_datepicker").on("change",function(){
            var eventdate = $(this).val();
            var p_id = $("#menuid").val();
            var category = $('#category').val();
            if($('#category').val() == 'stay'){
                let checkinVal = $('.cart_datepicker').val();
                let checkoutVal = $('.checkout_datepicker').val();
                let checkInDate = new Date(checkinVal);
                let checkOutDate = new Date(checkoutVal);
                if(checkInDate > checkOutDate){
                    toastr.error('Checkout date should be greater than checkin date');
                    $(".checkout_datepicker").val("");
                    return false;
                }
            }
            getTimeSlots(p_id, category, eventdate);
        });

        $("#date-picker-reservation").on("change",function(){
            var eventdate = $(this).val();
            var p_id = $(this).attr('data-place');
            var category =$(this).attr('data-category');
            getTimeSlots(p_id, category, eventdate);
        });

        function getTimeSlots(id, category, date){
            timeSlots = [];
            const parts = date.split('/');
            parts[0] = parts[0].replace(/^0+/, "");
            parts[1] = parts[1].replace(/^0+/, "");
            var formattedDate = parts[2] + "-" + parts[0] + "-" + parts[1];
            $('#slot_time').val('');
            setTimeslots([]);
            $('#divFieldSeats').addClass('hidden');

            // if (!DateEnabled.includes(formattedDate)) {
            //     setTimeslots([]); // or any other action you want to perform when data is not enabled
            //     return;
            // }
            $.ajax({
                dataType: 'json',
                url: "{{route('product-availability')}}",
                method: "post",
                data: {id, category, date},
                success: function (data) {
                    if(data.status === "error") {
                        setTimeslots(timeSlots);
                        return;
                    }
                    if (data.code === 200) {
                        console.log(data);
                        timeSlots = data.data.slot_availibility;
                        setTimeslots(timeSlots);

                        if (data.data.slot_seats) {
                            slotSeats = data.data.slot_seats;
                        } else {
                            slotSeats = [];
                        }
                    }
                },
                error: function (e) {
                    setTimeslots(timeSlots);
                }
            });
        }

        $('#add_to_cart_form').submit(function (event) {
            event.preventDefault();
            let $form = $(this);
            let formData = getFormData($form);
            //if($('#category').val() != 'stay' && $('#category').val() != 'rent'){
                if (formData.number_of_adult == "0" && $('#category').val() == 'travel' && formData.number_of_car == "0") {
                    //alert("Please enter number of adult");
                    $('.adulterror').css('display','block');
                    return;
                }else{
                    $('.adulterror').css('display','none');
                }
            //}

            if($('#category').val() == 'stay'){
                if (!formData.date || !formData.checkout_date) {
                    $('.checkout_dateerror').css('display','block');
                    return;
                }else{
                    $('.checkout_dateerror').css('display','none');
                }
                if (!formData.no_of_room) {
                    $('.no_of_room_err').css('display','block');
                    return;
                }else{
                    $('.no_of_room_err').css('display','none');
                }
            }else{

                if (!formData.date) {
                    //alert("Please select date");
                    $('.dateerror').css('display','block');
                    return;
                }else{
                    $('.dateerror').css('display','none');
                }
                //if($('#category').val() != 'stay' && $('#category').val() != 'rent'){
                    if (!formData.time && formData.all_day == 0) {
                        $('.timeerror').css('display','block');
                        return;
                    }else{
                        $('.timeerror').css('display','none');
                    }
                //}
            }


            // call api
            $.ajax({
                dataType: 'json',
                url: "{{route('add_to_cart')}}",
                method: "post",
                data: formData,
                beforeSend: function () {
                    console.log(formData);
                    $('.add_to_cart_submit_btn').html('Sending...').prop('disabled', true);
                },
                success: function (data) {
                    console.log("data :-",data);
                    $('.add_to_cart_submit_btn').html('Send').prop('disabled', false);
                    if(data.status === false) {
                        Tost(data.message,'error');
                        return;
                    }
                    if(data.status === 'error') {
                        Tost(data.message,'error');
                        return;
                    }

                    if (data.code === 200) {
                        if(data.data.count){
                            $('#cart_icon_count').html(data.data.count);
                        }
                        $('#cart-model').modal('toggle');
                        $("#date_range_picker").val('');
                        $("#check_in_date").val('');
                        $("#checkout_date").val('');
                        Tost(data.message,'success');
                        $form.trigger("reset");
                    }

                },
                error: function (e) {
                    $('.add_to_cart_submit_btn').html('Send').prop('disabled', false);
                    $('.booking_success').hide();
                    $('.booking_error').show();
                    if (e.status === 401) {
                        Tost(e.responseJSON.message,'error');
                    }
                }
            });

        });

        $('input[name="daterange').daterangepicker({
            autoApply: true,
            minDate:new Date(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        }, function(start, end, label) {
            var diff = start.diff(end, 'days'); // returns correct number
            var total = 0;
            if($('#category').val() == 'stay'){
                var days = Math.abs(diff);
                const nightPrice = parseFloat($('#adultprice').val());
                total = (days * nightPrice);
            }else if($('#category').val() == 'rent'){
                var days = Math.abs(diff) + 1;
                const dayprice = parseFloat($('#adultprice').val());
                total = (days * dayprice);
            }
            $('#cart_product_price').text('$' + total);
        });

        $(".date-picker-input").datepicker({
            locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
            format: 'dd-mm-yyyy',
            startDate: '+1d',
            disableDates:  function (date) {
                const currentDate = new Date();
                return date > currentDate ? true : false;
            }
        });
        $('.field-time').on('click', function (e) {
            $(this).toggleClass('active')
            $(".field-guest  .field-sub").removeClass('active');

        });
        $('.field-guest input').on('click', function (e) {
            $(this).next().next().toggleClass('active');
            $('.field-time .field-sub').removeClass('active');
        });

        $(document).mouseup(function (e) {
            var container = $(".field-select");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.find('.field-sub').removeClass('active');
            }
        });

        $('.place-cover-slider-imgs').css('display','block');
        $('.place-cover-slider-placeholder-img').css('display','none');
        // $(".photoswipe").slick('slickNext');
        $(". place__box--place_slider").slick(
            {
            arrows: true,
            dots: true,
            accessibility: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 5000,
            slidesToShow: 3,
            slidesToScroll: 1,
            // responsive: [{
            //         breakpoint: 600,
            //         settings: {
            //             slidesToShow: 2,
            //             slidesToScroll: 1
            //         }
            //     },
            //     {
            //         breakpoint: 480,
            //         settings: {
            //             slidesToShow: 1,
            //             slidesToScroll: 1
            //         }
            //     }
            // ]
        });

    });

    /*  [reservation Quantity ]- - - - - - - - - - - - - - - - - - - - */
        $('.shop-details__quantity_reservation').each(function () {
            var adultsminus = $(this).find('.adults-minus'),
                adultsplus = $(this).find('.adults-plus');
            adultsminus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                if (qty.val() == 0) {
                    qty.val(0);
                } else {
                    qty.val((parseInt(qty.val(), 10) - 1));
                }
            });
            adultsplus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                qty.val((parseInt(qty.val(), 10) + 1));
            });

            var childminus = $(this).find('.child-minus'),
                childplus = $(this).find('.child-plus');
            childminus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                if (qty.val() == 0) {
                    qty.val(0);
                } else {
                    qty.val((parseInt(qty.val(), 10) - 1));
                }
            });
            childplus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                qty.val((parseInt(qty.val(), 10) + 1));
            });

            var carminus = $(this).find('.car-minus'),
                carplus = $(this).find('.car-plus');

            carminus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                if (qty.val() == 0) {
                    qty.val(0);
                } else {
                    qty.val((parseInt(qty.val(), 10) - 1));
                }
            });
            carplus.on('click', function () {
                var qty = $(this).parent().find('.qty');
                qty.val((parseInt(qty.val(), 10) + 1));
            });
        });

        $('.shop-details__quantity_reservation span').on('click', function (e) {
            e.preventDefault();
            var text = [];
            if ($('.count_adults').val() > 0) {
                text.push('Adults ' + $('.count_adults').val());
            }
            if ($('.count_children').val() > 0) {
                text.push(' Childrens ' + $('.count_children').val());
            }
            $(this).parents('.field-guest').find('input[type="text"]').val(text.toString());
        });
    /*  [reservation Quantity  end]- - - - - - - - - - - - - - - - - - - - */


    // stay_shop_details_quantity
    $('.stay_shop_details_quantity').each(function () {
        let adultsminus = $(this).find('.adults-minus'),
        adultsplus = $(this).find('.adults-plus');
        adultsminus.on('click', function () {
            var qty = $(this).parent().find('.qty');
            if (qty.val() == 0) {
                qty.val(0);
            } else {
                qty.val((parseInt(qty.val(), 10) - 1));
            }
        });
        adultsplus.on('click', function () {
            var qty = $(this).parent().find('.qty');
            qty.val((parseInt(qty.val(), 10) + 1));
        });

        var childminus = $(this).find('.child-minus'),
            childplus = $(this).find('.child-plus');
        childminus.on('click', function () {
            var qty = $(this).parent().find('.qty');
            if (qty.val() == 0) {
                qty.val(0);
            } else {
                qty.val((parseInt(qty.val(), 10) - 1));
            }
        });
        childplus.on('click', function () {
            var qty = $(this).parent().find('.qty');
            qty.val((parseInt(qty.val(), 10) + 1));
        });

    });

    function showMaxLimitWarning(){
        let no_of_room =  $("#no_of_room").val();
        let max_adults_per_room_count_input = $('.stay_number_adults').val();
        let max_child_per_room_count_input = $('.stay_number_childrens').val();
        let max_adult_per_room_count =  $("#max_adult_per_room").val()*no_of_room;
        let max_child_per_room_count =  $("#max_child_per_room").val()*no_of_room;
        console.log(max_adults_per_room_count_input,max_child_per_room_count_input,max_adult_per_room_count,max_child_per_room_count);
        if(max_adults_per_room_count_input > max_adult_per_room_count || max_child_per_room_count_input > max_child_per_room_count){
            toastr.warning(`You can add max ${max_adult_per_room_count} adult and ${max_child_per_room_count} child per room, Add one more room for add other members.`);
        }
    }
    $('.stay_shop_details_quantity span').on('click', function (e) {
        e.preventDefault();
        var text = [];
        showMaxLimitWarning();
        if ($('.stay_number_adults').val() > 0) {
            text.push('Adults ' + $('.stay_number_adults').val());
        }
        if ($('.stay_number_childrens').val() > 0) {
            text.push(' Childrens ' + $('.stay_number_childrens').val());
        }
        $(this).parents('.field-guest').find('input[type="text"]').val(text.toString());
    });
    $('#no_of_room').on('keyup change', function () {
        if($(this).val() == 0){
            // toastr.error('Invalid input');
            return false;
        }
        if($(this).val() > 999){
            // toastr.error('Invalid input');
            return false;
        }
        if($(this).val() > 0){
            showMaxLimitWarning();
        }
        stayPricecalculation();
    });



    function daycal(){
        try {
            var startDate  = $('#check_in_date').val();
            var endDate   = $('#check_out_date').val();
            console.log('=============diff>',startDate,endDate);
            if(endDate == '' || endDate == ''){
                return 1;
            }else{
                newstartDate = moment(startDate, 'DD-MM-YYYY');
                newendDate = moment(endDate, 'DD-MM-YYYY');
                const diffInDays = newendDate.diff(newstartDate, 'days') ?? 1;
                return diffInDays+1;
            }
        } catch (error) {
            return 1;
        }
    }
    function stayPricecalculation() {
        let days = daycal();
        let numberOfRooms = $("#no_of_room").val();
        let pricePerNight =   $("#modal_cart_product_price").val();
        console.log(pricePerNight,numberOfRooms,days);
        total = Number(pricePerNight*numberOfRooms*days).toFixed(2);
        $('#cart_product_price').text('$' + total);
    }
</script>
@endpush
