@extends('frontend.layouts.template')
@section('main')
<style>
    .menu-item{display: block;width: 100% !important;margin: 0;}
    .menu-item img{
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 15px;
    -moz-border-radius: 15px;
    -webkit-border-radius: 15px;
    -ms-border-radius: 15px;
    -o-border-radius: 15px;
    }
    .menu-item .golo-add-to-wishlist{
        right: 10px;
        top: 10px;
        background: #fff;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        line-height: 42px;
        text-align: center;
    }
    .menu-item .price{
        right: 0 !important;
        top: 10px;
    }
    .menu-item .price b{
        font-size: 22px;
        color: #f00;
        font-weight: 700;
        font-family: "Roboto";
    }
    .menu-item .menu-info{
        width: 100%;
        padding: 0 !important;
        margin: 0 !important;
        padding-top: 14px!important;
    }
    @media (max-width: 767px){
        .menu-item img{height: 170px;}
        .golo-grid{
            grid-template-columns: repeat(2, 1fr);
            grid-column-gap: 10px;
            grid-row-gap: 10px;
        }
    }
    @media(max-width: 575px){
        .golo-grid {
            grid-template-columns: repeat(1, 1fr);
            grid-column-gap: 10px;
            grid-row-gap: 10px;
        }
    }
</style>
    <main id="main" class="site-main">
        <div class="site-content">
        <div class="page-title page-title--small align-left">
            <div class="container">
                <div class="page-title__content">
                    <h1 class="page-title__name">Featured Products</h1>
                    <p class="page-title__slogan"></p>
                </div>
            </div>
        </div><!-- .page-title -->
            <div class="container">
            <form style="width:100%;" method="get" action="{{route('featured_products')}}" id="search_form">
            <div class="row align-items-center mb-4 mt-0">
                        <div class="col-md-4 m-0">
                            <div class="form-group align-items-center m-0">
                                <label for="search-region" class="mr-1">Region:</label>
                                <select class="form-control select2" id="search-region" name="search_region">
                                <option value="0">All</option>
                                    @foreach($search_regions as $region)
                                        @if($filter_region==$region->id)
                                            <option selected value="{{$region->id}}">{{$region->name}}</option>
                                        @else
                                            <option value="{{$region->id}}">{{$region->name}}</option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 m-0">
                            <div class="form-group align-items-center m-0">
                                <label for="search-city" class="mr-1">{{__('District')}}:</label>
                                <select class="form-control select2" id="search-city" name="search_city" data-placeholder="{{__('Select City')}}">
                                <option value="0">All</option>
                                    @foreach($search_cities as $region)
                                        <optgroup label="{{$region['name']}}">
                                            @foreach($region['cities'] as $city)
                                                @if($filter_city==$city->id)
                                                    <option selected value="{{$city['id']}}" >{{$city['name']}}</option>
                                                @else
                                                    <option value="{{$city['id']}}" >{{$city['name']}}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-4 m-0">
                            <div class="form-group align-items-center m-0">
                                <label for="search-category" class="mr-1">Category:</label>
                                <select class="form-control select2" id="search-category" name="search_category">
                                <option value="0">All</option>
                                    @foreach($search_categories as $category)
                                        <option value="{{$category->id}}" @if($filter_category==$category->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>
                    </form>
                <div class="member-wishlist-wrap">
                    <!-- <h1>{{__('Product Wishlist')}}</h1> -->
                    <div class="mw-box">
                        <div class="mw-grid golo-grid grid-4 feature_product">
                            @forelse($place_products as $menu)
                                <!-- <div class="grid-item"> -->

                                    <div class="menu-item">
                                        <a data-tooltip="Wishlist" data-position="left" href="#" class="golo-add-to-wishlist btn-add-to-wishlist @if($menu->place_product_wishlist_count) remove_product_wishlist active @else @guest open-login @else add_product_wishlist @endguest @endif" place-id="{{$menu['place_id']}}" product-id="{{$menu['id']}}" tabindex="0">
                                            <span class="icon-heart">
                                                <i class="la la-heart-o" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                        <img src="{{$menu['thumb']}}" alt="Product Image">
                                        <a href="{{route('place_detail', $menu->place->slug)}}">
                                            <div class="menu-info">
                                            <div>
                                                <h2>{{$menu->place['name']}}</h2>
                                                <h4>{{$menu['name']}}</h4>
                                                <!-- <p>{{$menu['description']}}</p> -->
                                                @if(checkIfOnDiscount($menu))
                                                    <h6>Save ${{cleanDecimalZeros($menu['discount_percentage'])}}</h6>
                                                @endif
                                            </div>
                                                <!-- <span class="price">${{$menu['price']}}</span>-->

                                                <span class="price text-center">Now <br/>
                                                <b>
                                                    @if(checkIfOnDiscount($menu))
                                                        ${{checkIfOnDiscount($menu,true)}}
                                                    @else
                                                        ${{cleanDecimalZeros($menu['price'])}}
                                                    @endif
                                                </b>

                                                </span>
                                            </div>
                                        </a>
                                    </div>

                                <!-- </div> -->
                            @empty
                                No Featured Products
                            @endforelse
                        </div>
                    </div><!-- .mw-box -->
                    <div class="pagination align-left">
                        {{$place_products->appends(["country_id" => $filter_region, "city_id" => $filter_city])->render('frontend.common.pagination')}}
                    </div><!-- .pagination -->
                </div><!-- .member-wrap -->

                @include('frontend.common.banner_ads')

            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        $(document).on("change", "#search-region", function () {
            $('#search_form').submit();
        });

        $(document).on("change", "#search-city", function () {
            $('#search_form').submit();
        });

        $(document).on("change", "#search-category", function () {
            $('#search_form').submit();
        });
    </script>
@endpush
