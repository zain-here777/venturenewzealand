@extends('frontend.layouts.template')

@section('main')

<style>
    .btn{
        border-radius: 6px !important;
    }
    .country_description {
    max-height: 250px ; 
   overflow: hidden;

}

.show-more .country_description {
    max-height: none;
}

#toggle_button {
    display: block;
    margin-top: 10px;
    cursor: pointer;
    background-color: #72bf44;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 6px;
    outline: none;
}
.about-text{
    margin: 20px 0px;
    font-weight: bold;
}

@media (min-width: 1024px) {
    .country_description {
        max-height: none;
        overflow: visible;
    }
    #toggle_button {
        display: none;
    }
    .about-text{
        margin-top: 0;
        margin-bottom: 20px;
    }
}

</style>
    <main class="site-main normal_view">
        <div class="maps-wrap">
            <div class="maps-button">
                <a href="#" id="mapview_close">
                    @if (setting('style_rtl'))
                        <i class="la la-arrow-right la-24"></i>
                    @else
                        <i class="la la-arrow-left la-24"></i>
                    @endif
                    {{ __('Back to list') }}
                </a>
                <div class="field-select">
                    <select class="map_filter" id="category_id">
                        <option value="">{{ __('Show all') }}</option>
                        @foreach ($categories as $cat)
                            <option style="color: {{ $cat->color_code }}" value="{{ $cat->id }}">{{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <i class="la la-angle-down la-12"></i>
                </div>
                <input type="hidden" id="city_id" value="{{ $city->id }}">
            </div>
            <div id="maps-view"></div>
        </div>
        <div class="country_banner" style="background-image:url({{ getImageUrl($city->banner) }});">
        </div>
        <div class="country_detail">
            <div class="country_detail_description row container">
                <div class="col-lg-6 country_detail_videodiv" style="position:relative;">
                    @if ($city->video)
                        <div class="country_detail_video" style="position:relative;">
                            <iframe class="country_video"
                                src="{{ strpos($city->video, 'watch?v=') != null ? str_replace('watch?v=', 'embed/', $city->video) : str_replace('youtu.be', 'youtube.com/embed', $city->video) }}"
                                frameborder="0" allowfullscreen allow="autoplay"></iframe>
                        </div>
                    @else
                        <img src="{{ getImageUrl($city->thumb) }}" alt="{{ $city->name }} Thumbnail">
                    @endif
                </div>
                <div class="col-lg-6 ">
                    <div style="color:#2d2d2d;">
                        <p class="about-text" style="font-size:22px;">About</p>
                        <div id="country_description" class="country_description">
                            @php
                                echo $city->description;
                            @endphp
                        </div>
                        <button id="toggle_button">Read More</button>
                    </div>
                </div>
            </div>
            <div class="country_box_wrapper container">
                <div class="country__box mb-0 country__box--npd row">
                    <div class="col-7 col-lg-9 row country__box_mark_name" style="margin:0;">
                        <div class="col-lg-4 country_box_title">
                            <div>
                                <div class="country_box_name">{{ $city->name }}</div>
                                <div class="country_box_nz">{{ $city->country->name }}</div>
                            </div>

                        </div>
                        <div class="col-lg-8 country_box_desc">
                            <div class="country_box_description">
                                {{ $city->intro }}
                            </div>
                            <div class="country_box_website">
                                {{ $city->website }}
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-lg-3 country_box_map" style="padding:0; background-color:#d2d2d2;">
                        <div class="country_box_map_image">
                            @php
                                if ($city->map) {
                                    $mapurl = 'uploads/city/map/' . $city->map;
                                } else {
                                    $mapurl = 'assets/images/DefaultCityMap.svg';
                                }
                            @endphp
                            <img src="{{ asset($mapurl) }}" />
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
        <div class="city-content">
            <div class="city-content__tabtitle tabs custom-tab-main">
                <div class="container">
                    <div class="align-items-center position-relative">
                        <div class="wishlist-filter">
                            <div>
                                <a title="{{ $city->name }}"><span>{{ $city->name }}</span></a>
                            </div>
                            <div id="wishFilterBtns">
                                @include('frontend.user.wishFilterBtn')
                                @foreach ($categories as $cat)
                                    <button class="btn btnCityCateogry btnCat{{ $cat->slug }}"
                                        data-id="{{ $cat->slug }}" style="border:1px solid {{ $cat->color_code }}">
                                        <div>@include('frontend.user.svgImage')</div>
                                        <span>{{ $cat->name }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div><!-- .city-content__tabtitle__tablist -->
                        <div class="flex" style="justify-content: end; align-items: center;">
                            <div class="shop__meta">
                                <div class="shop__order site__order golo-nav-filter flex">
                                    <div class="golo-clear-filter btn" href="#"
                                        style="color:#fff; background-color:#72bf44;">
                                        <i class="la la-times"></i>
                                        <span>{{ __('Clear All') }}</span>
                                    </div>
                                    <div class="btn" style="background-color:#72bf44;">
                                        <a title="Filter" class="golo-filter-toggle " href="#" style="color:#fff;">
                                            <i class="fas fa-filter"></i>
                                            <span>{{ __('Filter') }}</span>
                                        </a>
                                    </div><!-- .shop__filter -->
                                </div><!-- .shop__order -->
                            </div><!-- .shop__meta -->
                            <a class="city-content__tabtitle__button btn btn-mapsview " title="{{ __('Map view') }}"
                                href="?view=map">
                                <i class="la la-map-marked-alt"></i>
                                <span>{{ __('Map view') }}</span>
                            </a><!-- .city-content__tabtitle__button -->
                        </div>
                    </div>
                </div>
            </div><!-- .city-content__tabtitle -->
            <div class="city-content__panels">
                <div class="container city-content__panel">
                    <div class="city_detail_div row position-relative">
                        <div class="golo-menu-filter col-lg-3">
                            <div id="golo-menu-filter-dismiss">
                                <i class="far fa-times"></i>
                            </div>
                            <div id="accordion_city">
                                <div class="card entry-filter">
                                    <div class="card-header">
                                        <a class="card-link collapsed" data-toggle="collapse" href="#collapseCate">
                                            {{ __('Categories') }}
                                        </a>
                                    </div>
                                    <div id="collapseCate" class="collapse" data-parent="#accordion_city">
                                        <ul class="card-body category filter-control">
                                            @foreach ($categories as $cat)
                                                <style>
                                                    .golo-menu-filter .card-body.category label.cateFilter_{{ $cat->id }}>input[type="checkbox"]+*::before {
                                                        border-color: {{ $cat->color_code }};
                                                    }

                                                    .golo-menu-filter .card-body.category label.cateFilter_{{ $cat->id }}>input[type="checkbox"]:checked+*::before {
                                                        background-color: {{ $cat->color_code }};
                                                        border-color: {{ $cat->color_code }};
                                                    }
                                                </style>
                                                <li class="category-check dropdown-item">
                                                    <label for="cate_{{ $cat->id }}"
                                                        class="cateFilter_{{ $cat->id }}"
                                                        style="color:{{ $cat->color_code }};">
                                                        <input type="checkbox" class="custom-checkbox input-control"
                                                            data-id="{{ $cat->slug }}" id="cate_{{ $cat->id }}"
                                                            name="categories" value="{{ $cat->id }}">
                                                        <span>{{ $cat->name }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="card entry-filter">
                                    <div class="card-header">
                                        <a class="card-link collapsed" data-toggle="collapse" href="#collapseSortby">
                                            {{ __('Sort By') }}
                                        </a>
                                    </div>
                                    <div id="collapseSortby" class="collapse" data-parent="#accordion_city">
                                        <ul class="card-body sort-by filter-control">
                                            <li class="dropdown-item" href="#"><a href="#"
                                                    data-sort="newest">{{ __('Newest') }}</a></li>
                                            <li class="dropdown-item" href="#"><a href="#"
                                                    data-sort="rating">{{ __('Average rating') }}</a></li>
                                            <li class="price-filter dropdown-item"><a href="#"
                                                    data-sort="price_asc">{{ __('Price: Low to high') }}</a></li>
                                            <li class="price-filter dropdown-item"><a href="#"
                                                    data-sort="price_desc">{{ __('Price: High to low') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card entry-filter">
                                    <div class="card-header">
                                        <a class="card-link collapsed" data-toggle="collapse" href="#collapsePrice">
                                            {{ __('Price Filter') }}
                                        </a>
                                    </div>
                                    <div id="collapsePrice" class="collapse" data-parent="#accordion_city">
                                        <ul class="card-body price filter-control">
                                            <li><a href="#" data-price="0"
                                                    class="dropdown-item">{{ __('Free') }}</a></li>
                                            <li><a href="#" data-price="1"
                                                    class="dropdown-item">{{ __('Low: $') }}</a></li>
                                            <li><a href="#" data-price="2"
                                                    class="dropdown-item">{{ __('Medium: $$') }}</a></li>
                                            <li><a href="#" data-price="3"
                                                    class="dropdown-item">{{ __('High: $$$') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card entry-filter">
                                    <div class="card-header">
                                        <a class="card-link collapsed" data-toggle="collapse" href="#collapseType">
                                            {{ __('Sub Categories') }}
                                        </a>
                                    </div>
                                    <div id="collapseType" class="collapse" data-parent="#accordion_city">
                                        <ul class="card-body type filter-control">
                                            @foreach ($place_types as $type)
                                                <li data-cat="{{ $type->category->slug }}"
                                                    class="placetype-check dropdown-item">
                                                    <input type="checkbox" class="custom-checkbox input-control"
                                                        id="type_{{ $type->id }}" name="types"
                                                        value="{{ $type->id }}" style="accent-color:#212529;">
                                                    <label for="type_{{ $type->id }}">{{ $type->name }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="card entry-filter">
                                    <div class="card-header">
                                        <a class="card-link collapsed" data-toggle="collapse" href="#collapseAmenity">
                                            {{ __('Amenities') }}
                                        </a>
                                    </div>
                                    <div id="collapseAmenity" class="collapse" data-parent="#accordion_city">
                                        <ul class="card-body amenities filter-control">
                                            @foreach ($amenities as $item)
                                                <li class="dropdown-item">
                                                    <input type="checkbox" class="custom-checkbox input-control"
                                                        id="amenities_{{ $item->id }}" name="amenities"
                                                        value="{{ $item->id }}" style="accent-color:#212529;">
                                                    <label
                                                        for="amenities_{{ $item->id }}">{{ $item->name }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="city_id" value="{{ $city->id }}">
                            <input type="hidden" name="category_id" value="">
                        </div>
                        <div class="city-content-wrap col-lg-12">
                            <div class="mw-box">
                                <div style="display: flex; justify-content:space-between" id="list_places">
                                    <div class="divPagination grid-cards row">
                                        @if (count($places))
                                            @foreach ($places as $place)
                                                <div
                                                style="display: flex; justify-content:space-between"
                                                    class="place-item layout-02 filterCityDiv divCityCat{{ $place['categories'][0]['slug'] }} col-md-4 col-sm-6 col-6 col-lg-3">

                                                    <div class="flip-card">
                                                        <div class="flip-card-inner">
                                                            <div class="card-front">
                                                                <div class="place-thumb">
                                                                    <div class="entry-thumb"
                                                                        href="{{ route('place_detail', $place->slug) }}">
                                                                        <img src="{{ getImageUrl($place->thumb) }}"
                                                                            alt="{{ $place->name }}">
                                                                        <div
                                                                            style="position: absolute; width: 100%; height: 100%; top: 0;background: transparent linear-gradient(180deg, #FEFEFE00 0%, #FEFEFE 100%) 0% 0% no-repeat padding-box;
                                                                            opacity: 0.7; border-radius: 15px;">
                                                                        </div>
                                                                        <div class="row place_thumb_desription">
                                                                            @php
                                                                                $logo = $place->logo != null ? getImageUrl($place->logo) : null;
                                                                            @endphp

                                                                            @if ($logo !== null)
                                                                                <div class="place_thumb_logo">
                                                                                    <img src="{{ $logo }}"
                                                                                        alt="logo"
                                                                                        class="custom-img-height">
                                                                                </div>
                                                                                <div class="place_thumb_price_1"
                                                                                    style="  background-color:{{ $place['categories'][0]['color_code'] }}; ">
                                                                                    @if ($place['categories'][0]['slug'] !== 'see')
                                                                                        <div style="border-radius: 6px;" >
                                                                                            <div
                                                                                                style="color: #FEFEFE; display:flex; border-radius: 6px; justify-content:space-around; padding:2px;">
                                                                                                <div
                                                                                                    class="treding_price_small">
                                                                                                    from</div>
                                                                                                <div
                                                                                                    class="treding_price_big">
                                                                                                    ${{ $place->getPlacePrice() }}
                                                                                                </div>
                                                                                                <div class="treding_price_small"
                                                                                                    style="align-items: end; display: flex;">
                                                                                                    NZD</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        <div
                                                                                            style="color: #FEFEFE; font-size:28px; text-align:center;">
                                                                                            Free</div>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="place-rating">
                                                                                    @if ($place->reviews_count)
                                                                                        <!-- {{ number_format($place->avgReview, 1) }} -->
                                                                                        @for ($i = 0; $i < 5 - round($place->avgReview); $i++)
                                                                                            <i class="far fa-star"
                                                                                                style="color:#f8f9fa;"></i>
                                                                                        @endfor
                                                                                        @for ($i = 0; $i < round($place->avgReview); $i++)
                                                                                            <i class="fas fa-star"
                                                                                                style="color:#febb02;"></i>
                                                                                        @endfor
                                                                                    @else
                                                                                        @for ($i = 0; $i < 5; $i++)
                                                                                            <i class="far fa-star"
                                                                                                style="color:#f8f9fa;"></i>
                                                                                        @endfor
                                                                                    @endif
                                                                                </div>
                                                                            @else
                                                                                <div class="place_thumb_price_2"
                                                                                    style="background-color:{{ $place['categories'][0]['color_code'] }};">
                                                                                    @if ($place['categories'][0]['slug'] !== 'see')
                                                                                        <div>
                                                                                            <div
                                                                                                style="color: #FEFEFE; display:flex; justify-content:space-around; padding:2px;">
                                                                                                <div
                                                                                                    class="treding_price_small">
                                                                                                    from</div>
                                                                                                <div
                                                                                                    class="treding_price_big">
                                                                                                    ${{ $place->getPlacePrice() }}
                                                                                                </div>
                                                                                                <div class="treding_price_small"
                                                                                                    style="align-items: end; display: flex;">
                                                                                                    NZD</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        <div style="color: #FEFEFE;"
                                                                                            class="trending_price_free">
                                                                                            Free</div>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="place-rating">
                                                                                    @if ($place->reviews_count)
                                                                                        <!-- {{ number_format($place->avgReview, 1) }} -->
                                                                                        @for ($i = 0; $i < 5 - round($place->avgReview); $i++)
                                                                                            <i class="far fa-star"
                                                                                                style="color:#f8f9fa;"></i>
                                                                                        @endfor
                                                                                        @for ($i = 0; $i < round($place->avgReview); $i++)
                                                                                            <i class="fas fa-star"
                                                                                                style="color:#febb02;"></i>
                                                                                        @endfor
                                                                                    @else
                                                                                        @for ($i = 0; $i < 5; $i++)
                                                                                            <i class="far fa-star"
                                                                                                style="color:#f8f9fa;"></i>
                                                                                        @endfor
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <a data-tooltip="Favourite" data-position="left"
                                                                        href="#"
                                                                        class="golo-add-to-wishlist btn-add-to-wishlist @if ($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                                                                        data-id="{{ $place->id }}"
                                                                        data-color="{{ $place['categories'][0]['color_code'] }}"
                                                                        style="@if ($place->wish_list_count) background-color:{{ $place['categories'][0]['color_code'] }}; @endif">
                                                                        <span class="icon-heart">
                                                                            @if ($place->wish_list_count)
                                                                                <i class="fas fa-bookmark"></i>
                                                                            @else
                                                                                <i class="far fa-bookmark"></i>
                                                                            @endif
                                                                        </span>
                                                                    </a>
                                                                    @if (isset($place['categories'][0]))
                                                                        <a class="entry-category rosy-pink"
                                                                            href="{{ route('page_search_listing', ['category[]' => $place['categories'][0]['id']]) }}">
                                                                            <img src="{{ getCategoryIcon($place['categories'][0]['icon_map_marker'], $place['categories'][0]['icon_map_marker']) }}"
                                                                                alt="{{ $place['categories'][0]['name'] }}">
                                                                            <!-- <span>{{ $place['categories'][0]['name'] }}</span> -->
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="card-back"
                                                                style="@switch($place['categories'][0]['name'])
                                                              @case('Play')
                                                                background-color: #3cadf1;
                                                                @break
                                                              @case('See')
                                                                background-color: #72c900;
                                                                @break
                                                              @case('Stay')
                                                                background-color: #af05cf;
                                                                @break
                                                              @case('Eat')
                                                                background-color: #e60707;
                                                                @break
                                                              @case('Rent')
                                                                background-color: #e5bf00;
                                                                @break
                                                              @case('Travel')
                                                                background-color: #d37802;
                                                                @break
                                                              @default
                                                                background-color: gray;
                                                            @endswitch">
                                                                <div class="entry-detail">
                                                                    <div class="d-flex justify-content-between">
                                                                        @switch($place['categories'][0]['name'])
                                                                            @case('Play')
                                                                                <img src="{{ asset('uploads/categorymarker/Play Light.svg') }}"
                                                                                    alt="Image" height="28px" width="28px">
                                                                            @break

                                                                            @case('See')
                                                                                <img src="{{ asset('uploads/categorymarker/See Light.svg') }}"
                                                                                    alt="Image" height="28px" width="28px">
                                                                            @break

                                                                            @case('Stay')
                                                                                <img src="{{ asset('uploads/categorymarker/Stay Light.svg') }}"
                                                                                    alt="Image" height="28px" width="28px">
                                                                            @break

                                                                            @case('Eat')
                                                                                <img src="{{ asset('uploads/categorymarker/Eat Light.svg') }}"
                                                                                    alt="Image" height="28px" width="28px">
                                                                            @break

                                                                            @case('Rent')
                                                                                <img src="{{ asset('uploads/categorymarker/Rent Light.svg') }}"
                                                                                    alt="Image" height="28px" width="28px">
                                                                            @break

                                                                            @case('Travel')
                                                                                <img src="{{ asset('uploads/categorymarker/Travel Light.svg') }}"
                                                                                    alt="Image" height="28px" width="28px">
                                                                            @break

                                                                            @default
                                                                        @endswitch

                                                                        {{-- </a> --}}
                                                                        <a data-tooltip="Favourite" data-position="left"
                                                                            href="#"
                                                                            class="golo-add-to-wishlist btn-add-to-wishlist @if ($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                                                                            data-id="{{ $place->id }}"
                                                                            data-color="{{ $place['categories'][0]['color_code'] }}"
                                                                            style="@if ($place->wish_list_count) background-color:{{ $place['categories'][0]['color_code'] }}; @endif">
                                                                            <span class="icon-heart">
                                                                                @if ($place->wish_list_count)
                                                                                    <i class="fas fa-bookmark"></i>
                                                                                @else
                                                                                    <i class="far fa-bookmark"></i>
                                                                                @endif
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="entry-head">
                                                                        <h3>
                                                                            {{ $place->name }}
                                                                        </h3>
                                                                        <div class="place-city">
                                                                            {{ $place['city']['name'] }}
                                                                        </div>
                                                                        <div class="place-type list-item">
                                                                            @foreach ($place['place_types'] as $type)
                                                                                <span>{{ $type->name }}</span>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="entry-body">
                                                                        <div class="text-light">
                                                                            @php
                                                                                echo $place->description;
                                                                            @endphp
                                                                        </div>
                                                                    </div>

                                                                    <div class="entry-bottom">
                                                                        <div class="place-preview">
                                                                            <span
                                                                                class="count-reviews">({{ $place->reviews_count }}
                                                                                {{ __('reviews') }})</span>
                                                                            <div class="place-rating">
                                                                                @if ($place->reviews_count)
                                                                                    <!-- {{ number_format($place->avgReview, 1) }} -->
                                                                                    @for ($i = 0; $i < 5 - round($place->avgReview); $i++)
                                                                                        <i class="far fa-star"
                                                                                            style="color:#f8f9fa;"></i>
                                                                                    @endfor
                                                                                    @for ($i = 0; $i < round($place->avgReview); $i++)
                                                                                        <i class="fas fa-star"
                                                                                            style="color:#febb02;"></i>
                                                                                    @endfor
                                                                                @else
                                                                                    @for ($i = 0; $i < 5; $i++)
                                                                                        <i class="far fa-star"
                                                                                            style="color:#f8f9fa;"></i>
                                                                                    @endfor
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="place-price">
                                                                            <!-- <span>{{ PRICE_RANGE[$place['price_range']] }}</span> -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="entry-but">
                                                                        <a href="{{ route('place_detail', $place->slug) }}"
                                                                            class="TrendingReadMoreButton"
                                                                            style="color:{{ $place['categories'][0]['color_code'] }};background-color:white; border-radius:6px">
                                                                            <div >Visit Page</div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="no_place_city">
                                                {{ __('No places') }}
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div><!-- .mw-box -->
                        </div><!-- .city-content-wrap -->
                    </div>
                </div>
            </div><!-- .city-content__panel -->
        </div><!-- .city-content -->

        <div class="other-city banner-dark">
            <div class="container">
                <h2 class="title title--while">{{ __('Explorer Other Cities') }}</h2>
                <div class="other-city__content">
                    @if (count($other_cities))
                        <div class="slick-sliders">
                            <div class="slick-slider cities-slider slider-pd30" data-autoplay="true" data-item="4"
                                data-arrows="true" data-itemScroll="1" data-dots="true" data-centerPadding="30"
                                data-tabletitem="3" data-tabletscroll="2" data-smallpcscroll="3" data-smallpcitem="3"
                                data-mobileitem="1" data-mobilescroll="1" data-mobilearrows="false">
                                @foreach ($other_cities as $city)
                                    <div class="cities__content_li">
                                        <a href="{{ route('city_detail', $city->slug) }}">
                                            <div class="cities__item hover__box">
                                                <div class="cities__thumb hover__box__thumb">
                                                    <img src="{{ getImageUrl($city->thumb) }}"
                                                        alt="{{ $city->name }}">
                                                    <div
                                                        style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;">
                                                    </div>
                                                </div>
                                                <div class="cities__capital_name">
                                                    <h3 class="cities__capital">{{ $city->name }}</h3>
                                                    <h4 class="cities__name">{{ $city['country']['name'] }}</h4>
                                                </div>
                                                <div class="cities_rotoruamap">
                                                    @php
                                                        if ($city->map_tile) {
                                                            $tilemapurl = 'uploads/city/map/' . $city->map_tile;
                                                        } else {
                                                            $tilemapurl = 'assets/images/DefaultCityMap_tile.svg';
                                                        }
                                                    @endphp
                                                    <img src="{{ asset($tilemapurl) }}" />
                                                </div>
                                                <div class="cities__info row">
                                                    <p class="cities__number">{{ $city->places_count }}
                                                        {{ __('Places') }}</p>
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
                    @else
                        <div>
                            {{ __('No cities') }}
                        </div>
                    @endif
                </div>
            </div>
        </div><!-- .other-city -->
    </main><!-- .site-main -->
@stop

@push('scripts')
    @if (setting('map_service', 'google_map') === 'google_map')
        <script src="{{ asset('assets/js/page_city_detail.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/page_city_detail_mapbox.js') }}"></script>
    @endif
@endpush
