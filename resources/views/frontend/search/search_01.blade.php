@extends('frontend.layouts.template')
@section('main')


    <main id="main" class="site-main">
    <div class="site-content">
        <div class="search-ads">
            <div class="search_banner">
            </div>
            <div class="country_box_wrapper container">
                <div class="country__box mb-0 country__box--npd row">
                    <div class="col-7 col-lg-9 row country__box_mark_name" style="margin:0;">
                        <div class="col-lg-4 country_box_title">
                            <div>
                                <div class = "country_box_name">Search Venture</div>
                                <div class = "country_box_nz">New Zealand</div>
                            </div>
                        </div>
                        <div class="col-lg-8 country_box_desc" >
                            <div class="country_box_description">
                                Find everything you need right here.
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-lg-3 country_box_map" style="padding:0; background-color:#d2d2d2;">
                        <div class="country_box_map_image">
                            @php
                                $mapurl = 'assets/images/NZ Satellite pins.png';
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

        <div class="archive-city" style="border-top:none">
            <div class="container">
                <div class="filter-title">
                    <div>
                        {{-- <span><i class="far fa-search"></i></span>
                        <span>Filter</span> --}}
                        <span class="result-count">
                            <span class="count">{{$places->total()}}</span>
                            {{__('Results')}}
                        </span>
                    </div>
                </div>
                <div class="main-primary">
                    <div class="top-area top-area-filter position-relative" style="display:flex; justify-content:space-between;">
                        <div id="wishFilterBtns">
                            @include('frontend.user.wishFilterBtn')
                            @foreach( $categories as $cat)
                                <button class="btn btnSearchCateogry btnCat{{$cat->slug}} {{isActive($cat->id, $filter_category)}}" data-id="{{$cat->id}}" style="border:1px solid {{$cat->color_code}}">
                                    <div>@include('frontend.user.svgImage')</div>
                                    <span>{{$cat->name}}</span>
                                </button>
                            @endforeach
                            <p>
                                {{__('Let us know about yourself so we can better match suggestions for you.')}}
                            </p>
                        </div>
                        <div>
                            <button class="filter-tablet-title btn" id="filter-div-show">
                                <span><i class="fas fa-filter"></i></span>
                                <span>Filter</span>
                            </button>
                            <a href="{{route('page_search_listing')}}" class="clear-filter2 btn" id="clearSearchFilter">
                                <i class="far fa-times"></i><span>Clear all</span>
                            </a>
                        </div>
                    </div>
                    <div class="row position-relative">
                        <div class="col-lg-3 filter-div">
                            <div class="filter-div-dismiss">
                                <div id="filter-div-close"><i class="far fa-times"></i></div>
                            </div>
                            <div class="archive-filter">
                                <form class="filterForm" id="filterForm">
                                    <div id="accordion" class="filter-content">
                                        <div class="card filter-box">
                                            <div class="card-header">
                                                <a class="card-link collapsed"
                                                    data-toggle="collapse"
                                                    href="#collapseRegion">
                                                    {{-- <span id="RegionSelNumber"></span> --}}
                                                    Region
                                                </a>
                                            </div>
                                            <div id="collapseRegion"
                                                class="filter-list collapse"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    @foreach($region as $reg)
                                                        <a class="dropdown-item" href="#">
                                                            <div class="field-check">
                                                                <label class="bc_filter" for="reg_{{$reg->id}}">
                                                                    <input type="checkbox" id="reg_{{$reg->id}}" name="region[]" value="{{$reg->id}}" {{isChecked($reg->id, $filter_region)}}>
                                                                    {{$reg->name}}
                                                                    <span class="checkmark"><i class="la la-check"></i></span>
                                                                </label>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if($filter_region)
                                        <div class="card filter-box">
                                            <div class="card-header">
                                                <a class="card-link collapsed"
                                                    data-toggle="collapse"
                                                    href="#collapseCity">
                                                    {{-- <span id="CitySelNumber"></span> --}}
                                                    Districts
                                                </a>
                                            </div>
                                            <div id="collapseCity"
                                                class="filter-list collapse"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    @foreach($cities as $city)
                                                    <a class="dropdown-item" href="#">
                                                        <div class="field-check">
                                                            <label class="bc_filter" for="city_{{$city->id}}">
                                                                <input type="checkbox" id="city_{{$city->id}}" name="city[]" value="{{$city->id}}" {{isChecked($city->id, $filter_city)}}>
                                                                {{$city->name}}
                                                                <span class="checkmark"><i class="la la-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="card filter-box">
                                            <div class="card-header">
                                                <a class="card-link collapsed"
                                                    data-toggle="collapse"
                                                    href="#collapseCat">
                                                    {{-- <span id="CatSelNumber"></span> --}}
                                                    Categories
                                                </a>
                                            </div>
                                            <div id="collapseCat"
                                                class="filter-list collapse"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    @foreach($categories as $cat)
                                                        <a class="dropdown-item" href="#">
                                                            <div class="field-check">
                                                                <label class="bc_filter cat_filter_{{$cat->id}}" for="cat_{{$cat->id}}" style="color: {{$cat->color_code}};">
                                                                    <input type="checkbox" data-color= "{{$cat->color_code}}" id="cat_{{$cat->id}}" name="category[]" value="{{$cat->id}}" {{isChecked($cat->id, $filter_category)}}>
                                                                    <style>
                                                                        .field-check label.cat_filter_{{$cat->id}}:before{
                                                                            border: solid 1px {{$cat->color_code}};
                                                                        }
                                                                        .field-check label.cat_filter_{{$cat->id}} input:checked~span{
                                                                            background-color: {{$cat->color_code}};
                                                                        }
                                                                    </style>
                                                                    {{$cat->name}}
                                                                    <span class="checkmark"><i class="la la-check"></i></span>
                                                                </label>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @if($filter_category)
                                        <div class="card filter-box">
                                            <div class="card-header">
                                                <a class="card-link collapsed"
                                                    data-toggle="collapse"
                                                    href="#collapseSubcat">
                                                    {{-- <span id="SubcatSelNumber"></span> --}}
                                                    {{__('Sub Categories')}}
                                                </a>
                                            </div>
                                            <div id="collapseSubcat"
                                                class="filter-list collapse"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    @foreach($place_types as $place_type)
                                                        <a class="dropdown-item" href="#">
                                                            <div class="field-check">
                                                                <label class="bc_filter" for="place_type_{{$place_type->id}}">
                                                                    <input type="checkbox" id="place_type_{{$place_type->id}}" name="place_type[]" value="{{$place_type->id}}" {{isChecked($place_type->id, $filter_place_type)}}>
                                                                    {{$place_type->name}}
                                                                    <span class="checkmark"><i class="la la-check"></i></span>
                                                                </label>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card filter-box">
                                            <div class="card-header">
                                                <a class="card-link collapsed"
                                                    data-toggle="collapse"
                                                    href="#collapseKeyword">
                                                    {{-- <span id="KeywordSelNumber"></span> --}}
                                                    {{__('Keywords')}}
                                                </a>
                                            </div>
                                            <div id="collapseKeyword"
                                                class="filter-list collapse"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    @foreach($interests as $interest)
                                                        <a class="dropdown-item" href="#">
                                                            <div class="field-check">
                                                                <label class="bc_filter" for="interest_{{$interest->id}}">
                                                                    <input type="checkbox" id="interest_{{$interest->id}}" name="interest[]" value="{{$interest->id}}" {{isChecked($interest->id, $filter_interest)}}>
                                                                    {{$interest->keyword}}
                                                                    <span class="checkmark"><i class="la la-check"></i></span>
                                                                </label>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-button align-center">
                                        <input type="hidden" name="keyword" value="{{$keyword}}">
                                        <a href="#" class="btn">{{__('Apply')}}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="area-places">
                                @if($places->total())
                                    <div class="mw-box">
                                        <div class="row">
                                            @foreach($places as $place)
                                                <div class="place-item layout-02 filterFavDiv divFavCat{{$place['categories'][0]['slug']}} col-md-4 col-sm-6 col-6">
                                                    
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
                                                                            style="color:{{ $place['categories'][0]['color_code'] }};background-color:white;border-radius:6px">
                                                                            <div>Visit Page</div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div><!-- .mw-box -->
                                @else
                                    <div class="p-3">
                                        <p>{{__('Nothing found!')}}</p>
                                        <p>{{__("We're sorry but we do not have any listings matching your search, try to change you search settings")}}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="pagination">
                                {{$places->render('frontend.common.pagination')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .archive-city -->
        @include('frontend.common.banner_ads')
    </div>
    </main><!-- .site-main -->
@stop

@push('scripts')
<script src="{{asset('assets/js/page_business_category.js')}}"></script>
@endpush
