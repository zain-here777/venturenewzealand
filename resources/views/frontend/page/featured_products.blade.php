@extends('frontend.layouts.template') @section('main')

<style>
    .btn{
        border-radius: 6px !important;
    }
</style>

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
                                    <div class = "country_box_name">Featured Products</div>
                                    <div class = "country_box_nz">New Zealand</div>
                                </div>
                            </div>
                            <div class="col-lg-8 country_box_desc" >
                                <div class="country_box_description">
                                    Find featured products right here.
                                </div>
                            </div>
                        </div>
                        <div class="col-5 col-lg-3 country_box_map" style="padding:0; background-color:#ffff;">
                            <div class="featured_map_image">
                                @php
                                    $mapurl = 'assets/images/Featured.png';
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

            <div class="archive-city" style="border-top:none ;">
                <div class="container">
                    <div class="filter-title">
                        <div>
                            <span class="result-count">
                                <span class="count">{{$place_products->total()}}</span>
                                {{__('Results')}}
                            </span>
                        </div>
                    </div>
                    <div class="main-primary">
                        <div class="top-area top-area-filter position-relative" style="display:flex; justify-content:space-between;">

                            <div id="wishFilterBtns">
                                @include('frontend.user.wishFilterBtn')
                                @foreach( $categories as $cat)
                                    <button class="btn btnSearchCateogry btnCat{{$cat->slug}} {{isActive($cat->id, $filter_category)}}" data-id="{{$cat->id}}" style="border:1px solid {{$cat->color_code}} ">
                                        <span>@include('frontend.user.svgImage')</span>
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
                                <a href="{{route('featured_products')}}" class="clear-filter2 btn" id="clearSearchFilter">
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
                                    <form class="filterForm" method="get" action="{{ route('featured_products') }}" id="search_form">
                                        <div id="accordion" class="filter-content">
                                            <div class="card filter-box">
                                                <div class="card-header btn" >
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
                                                <div class="card-header btn">
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
                                                <div class="card-header btn">
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
                                        </div>
                                        <div class="form-button align-center">
                                            <a href="#" class="btn">{{__('Apply')}}</a>
                                        </div>
                                    </form>
                                    @include('frontend.common.banner_ads')
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="area-places">
                                    @if($place_products->total())
                                        <div class="mw-box">
                                            <div class="row">
                                                @foreach($place_products as $menu)
                                                <div class="place-item layout-02 filterWishDiv divWishCat{{$menu->place['categories'][0]['slug']}} col-md-4 col-sm-6 col-6">
                                                    <div class="place-inner">
                                                        <div class="place-thumb">
                                                            <a class="entry-thumb" href="{{route('place_detail', $menu->place->slug)}}">

                                                                <img  src="{{$menu['thumb']}}" alt="{{$menu->name}}">
                                                                <div  style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;"></div>

                                                                <div class="row place_thumb_desription">
                                                                    @php
                                                                        $logo = $menu->place->logo != null ? getImageUrl($menu->place->logo) : null;
                                                                    @endphp

                                                                    @if ($logo !== null)
                                                                        <div class="place_thumb_logo exclude-class">

                                                                            <img  src="{{$logo}}" alt="logo" class="custom-img-height" style="  object-fit:contain  ">

                                                                        </div>
                                                                        <div class="place_thumb_price_1 exclude-class" style="background-color:{{$menu->place['categories'][0]['color_code']}}; border-radius:unset;">
                                                                            @if($menu->place['categories'][0]['slug'] !== "see")
                                                                            <div>
                                                                                <div class="exclude-class" style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                                                    <div class="treding_price_big exclude-class"> ${{ getRezdyPrice($menu) }}</div>
                                                                                    <div class="treding_price_small exclude-class" style="align-items: end; display: flex;">NZD</div>
                                                                                </div>
                                                                            </div>
                                                                            @else
                                                                            <div style="color: #FEFEFE; font-size:28px; text-align:center;">Free</div>
                                                                            @endif
                                                                        </div>
                                                                    @else
                                                                        <div style="display:hidden;"></div>
                                                                        <div class="place_thumb_price_2" style="background-color:{{$menu->place['categories'][0]['color_code']}};">
                                                                        @if($menu->place['categories'][0]['slug'] !== "see")
                                                                            <div>
                                                                                <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                                                    <div class="treding_price_big">${{ getRezdyPrice($menu) }} </div>
                                                                                    <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
                                                                                </div>
                                                                            </div>
                                                                            @else
                                                                            <div style="color: #FEFEFE; font-size:28px;">Free</div>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                            <a data-tooltip="Wishlist" data-position="left" href="#"
                                                                class="golo-add-to-wishlist btn-add-to-wishlist @if($menu->place_product_wishlist_count) remove_product_wishlist active @else @guest open-login @else add_product_wishlist @endguest @endif"
                                                                place-id="{{$menu['place_id']}}" product-id="{{$menu['id']}}"  data-color="{{$menu->place['categories'][0]['color_code']}}" tabindex="0"
                                                                @if($menu->place_product_wishlist_count) style="background-color:{{$menu->place['categories'][0]['color_code']}};" @endif>
                                                                <span class="icon-heart">
                                                                    @if($menu->place_product_wishlist_count)
                                                                    <i class="fas fa-heart" aria-hidden="true"></i>
                                                                    @else
                                                                    <i class="far fa-heart" aria-hidden="true"></i>
                                                                    @endif
                                                                </span>
                                                            </a>
                                                            @if(isset($menu->place['categories'][0]))
                                                            <a class="entry-category rosy-pink"
                                                                href="{{route('page_search_listing', ['category[]' => $menu->place['categories'][0]['id']])}}">
                                                                <img  src="{{getCategoryIcon($menu->place['categories'][0]['icon_map_marker'],$menu->place['categories'][0]['icon_map_marker'])}}"
                                                                    alt="{{$menu->place['categories'][0]['name']}}">
                                                            </a>
                                                            @endif
                                                        </div>
                                                        <div class="entry-detail">
                                                            <h4 class="product-title">
                                                                <a href="{{route('place_detail', $menu->place->slug)}}">
                                                                    <b>{{$menu->place->name}}</b>
                                                                </a>
                                                            </h4>
                                                            <p class="place-title">
                                                                <a>{{$menu['name']}}</a>
                                                            </p>
                                                            {{-- <p class="product-description">
                                                                {{$menu->description}}
                                                            </p> --}}
                                                            {{-- <a href="{{route('place_detail', $menu->place->slug)}}" class="TrendingReadMoreButton" style="background-color:{{$menu->place['categories'][0]['color_code']}};">
                                                               <div> Read More</div>
                                                            </a> --}}
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
                                    {{$place_products->render('frontend.common.pagination')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .archive-city -->
            <div class="container">
                @include('frontend.common.banner_ads')
            </div>


        </div>
        <!-- .site-content -->
    </main>
    <!-- .site-main -->
@stop
@push('scripts')
    {{-- <script src="{{ asset('assets/js/page_business_category.js') }}"></script> --}}
    <script>
        $(document).on('click', '#filter-div-show', function () {
            if($(this).hasClass('active')){
                $('.archive-city .filter-div').css('display', 'none');
                $(this).removeClass('active');
            }else{
                $('.archive-city .filter-div').css('display', 'block');
                $(this).addClass('active');
            }

        });

        $(document).on('click', '#filter-div-close', function () {
            $('.archive-city .filter-div').css('display', 'none');
            $('#filter-div-show').removeClass('active');
        });

        $(window).resize(function() {
            var width = $(window).width();
            if (width > 992){
                $('.archive-city .filter-div').css('display', 'flex');
            } else {
                $('.archive-city .filter-div').css('display', 'none');
            }
        });
        $(window).scroll(function (event) {
            var scroll = $(window).scrollTop();
            var width = $(window).width();
            if(width < 768){
                if(scroll>480){
                    $('.archive-city .filter-div').css('position', 'fixed');
                    $('.archive-city .filter-div').css('top', '80px');
                    $('.archive-city .filter-div').css('width', '90%');
                }else{
                    $('.archive-city .filter-div').css('position', 'absolute');
                    $('.archive-city .filter-div').css('top', '0');
                    $('.archive-city .filter-div').css('width', '100%');
                }
            }
        });

        $(document).on('click', '.bc_filter', function(e) {
            $('#search_form').submit();
        });

        $(document).on("click", "#wishFilterBtns .btnSearchCateogry" , function() {

        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }

        var category_arr = [];
        var category_val = '';
        $('#wishFilterBtns .btnSearchCateogry.active').each(function(j) {
            category_arr[j] = 'category[]='+$(this).attr('data-id');
        });

        if(category_arr.length > 0) {
            category_val += category_arr.join('&');
        }

        var url = route_url+'/featured-products?';
        if(category_val != '') {
            url += category_val;
        }
        window.location.href = encodeURI(url);
        });
        // $(document).ready(function() {
        //     $('.select2').select2();
        // });

        // $(document).on("change", "#search-region", function () {
        //     $('#search_form').submit();
        // });

        // $(document).on("change", "#search-city", function () {
        //     $('#search_form').submit();
        // });

        // $(document).on("change", "#search-category", function () {
        //     $('#search_form').submit();
        // });
    </script>
@endpush
