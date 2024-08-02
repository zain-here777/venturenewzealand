@extends('frontend.layouts.template')
@section('main')

<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
<main id="main" class="site-main country-04">
    <div class="country custom-padding-top">
        <div class="country_banner" style = "background-image:url({{getImageUrl($country->banner)}});">
        </div>
        <div class="country_detail">
            <div class="country_detail_description row container">
                <div class="col-lg-6 country_detail_videodiv" style="position:relative;">
                    @if($country->video)
                    <div class="country_detail_video" style="position:relative;">
                        <iframe  class="country_video" src="{{strpos($country->video, "watch?v=") != null ? str_replace("watch?v=","embed/", $country->video) : str_replace("youtu.be","youtube.com/embed", $country->video)}}" frameborder="0" allowfullscreen allow="autoplay"></iframe>
                    </div>
                    @else
                    <img src="{{getImageUrl($country->banner)}}" alt="{{$country->name}} Thumbnail">
                    @endif
                </div>
                <div class="col-lg-6 country_detail_about">
                    <div style="color:#2d2d2d;">
                        <p style="margin-bottom:20px;">About</p>
                        <div class="country_description">
                            @php
                                echo $country->about;
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="country_box_wrapper container">
                <div class="country__box mb-0 country__box--npd row">
                    <div class="col-7 col-lg-9 row country__box_mark_name" style="margin:0;">
                        <div class="col-lg-4 country_box_title">
                            <div>
                                <div class = "country_box_name">{{$country->name}}</div>
                                <div class = "country_box_nz">New Zealand</div>
                            </div>
                        </div>
                        <div class="col-lg-8 country_box_desc" >
                            <div class="country_box_description">
                                {{$country->description}}
                            </div>
                            <div class="country_box_website">
                                {{$country->website}}
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-lg-3 country_box_map" style="padding:0; background-color:#d2d2d2;">
                        <div class="country_box_map_image">
                            @php
                                if($country->countrymap){
                                    $mapurl = 'assets/images/countries/' . $country->countrymap;
                                } else {
                                    $mapurl = 'assets/images/DefaultCountryMap.svg';
                                }

                            @endphp
                            <img src="{{ asset($mapurl) }}"/>
                        </div>
                    </div>
                    <div class="country_box_category flex">
                        <img src="/uploads/categorymarker/See Banner.svg" />
                        <img src="/uploads/categorymarker/Play Banner.svg" />
                        <img src="/uploads/categorymarker/Eat Banner.svg" />
                        <img src="/uploads/categorymarker/Stay Banner.svg" />
                        <img src="/uploads/categorymarker/Rent Banner.svg" />
                        <img src="/uploads/categorymarker/Travel Banner.svg" />
                    </div>
                </div>
            </div>
        </div>

        <div class="country_cities">
            <div class="container">
                <h2 class="country_cities__title title title-border-bottom">{{$country->name}}{{__(' Towns/Cities')}}</h2>
                <div class="cities__content">
                    <div class="row" style="justify-content: center;">
                        @foreach($country_cities as $city)
                        <div class="col-lg-3 col-sm-4 col-6  cities__content_li">
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
                                        <img src="{{ asset($tilemapurl) }}"/>
                                    </div>
                                    <div class="cities__info row">
                                        <p class="cities__number">{{$city->places_count}} {{__('Places')}}</p>
                                    </div>
                                </div><!-- .cities__item -->
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div><!-- .cities__content -->
            </div>
        </div><!-- .cities -->

        <div class="country-trending trending-business">
            <div class="container">
                <h2 class="title title-border-bottom align-center">{{__('Highlights in ')}}{{$country->name}}</h2>
                <div class="slick-sliders">
                    <div class="slick-slider slider-pd30"  data-autoplay="true" data-item="4" data-arrows="true"
                        data-itemScroll="1" data-dots="true" data-centerPadding="30" data-tabletitem="3"
                        data-tabletscroll="2" data-smallpcscroll="3" data-smallpcitem="3" data-mobileitem="1"
                        data-mobilescroll="1" data-mobilearrows="false">

                        @foreach($country_trending_places as $place)
                        <div class="place-item layout-02">
                            <div class="place-inner">
                                <div class="place-thumb">
                                    <a class="entry-thumb" href="{{route('place_detail', $place->slug)}}">
                                        <img src="{{getImageUrl($place->thumb)}}" alt="{{$place->name}}">
                                        <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;"></div>
                                        <div class="row place_thumb_desription">
                                            @php
                                                $logo = $place->logo != null ? getImageUrl($place->logo) : null;
                                            @endphp

                                            @if ($logo !== null)
                                                <div class="place_thumb_logo col-sm-6 col-12">
                                                    <img src="{{$logo}}" alt="logo" class="custom-img-height">
                                                </div>
                                                <div class="place_thumb_price_1 col-sm-6 col-12" style="background-color:{{$place['categories'][0]['color_code']}};">
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
                                                <div class="place_thumb_price_2 col-sm-6 col-12" style="background-color:{{$place['categories'][0]['color_code']}};">
                                                @if($place['categories'][0]['slug'] !== "see")
                                                    <div>
                                                        <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                            <div class="treding_price_small">from</div>
                                                            <div class="treding_price_big"> {{ $place->getPlacePrice() }}</div>
                                                            <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
                                                        </div>
                                                        <div style="color: #FEFEFE;" class="treding_price_small">
                                                            @if ($place['categories'][0]['pricing_text'] !== null)
                                                                {{ $place['categories'][0]['pricing_text'] }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div style="color: #FEFEFE; font-size:28px;">Free</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    <a data-tooltip="Favourite" data-position="left" href="#"
                                        class="golo-add-to-wishlist btn-add-to-wishlist @if($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                                        data-id="{{$place->id}}" data-color="{{$place['categories'][0]['color_code']}}" @if($place->wish_list_count) style="background-color:{{$place['categories'][0]['color_code']}};"@endif>
                                        <span class="icon-heart">
                                            @if($place->wish_list_count)
                                            <i class="fas fa-bookmark"></i>
                                            @else
                                            <i class="far fa-bookmark"></i>
                                            @endif
                                        </span>
                                    </a>
                                    @if(isset($place['categories'][0]))
                                    <a class="entry-category rosy-pink"
                                        href="{{route('page_search_listing', ['category[]' => $place['categories'][0]['id']])}}">
                                        <img src="{{getCategoryIcon($place['categories'][0]['icon_map_marker'],$place['categories'][0]['icon_map_marker'])}}"
                                            alt="{{$place['categories'][0]['name']}}" >
                                        <!-- <span>{{$place['categories'][0]['name']}}</span> -->
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
                                                    @for($i = 0; $i < 5; $i++)
                                                        <i class="far fa-star" style="color:#414141;"></i>
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                        <div class="place-price">
                                            <!-- <span>{{PRICE_RANGE[$place['price_range']]}}</span> -->
                                        </div>
                                    </div>
                                    <a href="{{route('place_detail', $place->slug)}}" class="TrendingReadMoreButton" style="background-color:{{$place['categories'][0]['color_code']}};">
                                       <div> Read More</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    @if(count($country_trending_places) != 0)
                    <div class="place-slider__nav slick-nav trending_slick_nav">
                        <div class="place-slider__prev slick-nav__prev">
                            <i class="fas fa-caret-left"></i>
                        </div><!-- .place-slider__prev -->
                        <div class="place-slider__next slick-nav__next">
                            <i class="fas fa-caret-right"></i>
                        </div><!-- .place-slider__next -->
                    </div><!-- .place-slider__nav -->
                    @else
                    @endif
                </div>
            </div>
        </div><!-- .trending -->

        <div class="regions">
            <div class="container">
                <h2 class="regions__title title">{{__('Explore other Regions')}}</h2>
                <div class="slick-sliders">
                    <div class="slick-slider cities-slider slider-pd30"  data-autoplay="true" data-item="4" data-arrows="true"
                        data-itemScroll="1" data-dots="true" data-centerPadding="30" data-tabletitem="3"
                        data-tabletscroll="2" data-smallpcscroll="3" data-smallpcitem="3" data-mobileitem="1"
                        data-mobilescroll="1" data-mobilearrows="false">

                        @foreach($regions as $region)
                        <div class="regions__content_li">
                            <a href="{{route('region_detail', $region->slug)}}">
                                <div class="regions__item hover__box">
                                    <div class="regions__thumb hover__box__thumb">
                                        <img src="{{getImageUrl($region->banner)}}" alt="{{$region->name}}">
                                        <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;"></div>
                                    </div>
                                    @php
                                        if($region->countrymap_tile){
                                            $regionmapurl = 'assets/images/countries/' . $region->countrymap_tile;
                                        } else {
                                            $regionmapurl = 'assets/images/DefaultCountryMap_tile.svg';
                                        }

                                    @endphp
                                    <div class="region_map"><img src="{{asset($regionmapurl)}}"/></div>
                                    <h3 class="regions__capital">{{$region->name}}</h3>
                                    <div class="regions__info">
                                        <div style="display:flex; gap:5px;">
                                        <div class="cities_category"> <img src="/uploads/categorymarker/See Banner.svg" /></div>
                                        <div class="cities_category"> <img src="/uploads/categorymarker/Play Banner.svg" /></div>
                                        <div class="cities_category"> <img src="/uploads/categorymarker/Eat Banner.svg" /></div>
                                        <div class="cities_category"> <img src="/uploads/categorymarker/Stay Banner.svg" /></div>
                                        <div class="cities_category"> <img src="/uploads/categorymarker/Rent Banner.svg" /></div>
                                        </div>
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
        </div><!-- .explore-other-region -->
    </div>
</main>
@stop

@push('scripts')
<script src="{{asset('assets/js/page_country_detail.js')}}"></script>
@endpush
