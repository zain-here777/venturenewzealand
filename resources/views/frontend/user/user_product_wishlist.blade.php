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
        top: 7px;
        position: unset;
    }
    .menu-item .menu-info{
        width: 100%;
        padding: 0 !important;
        margin: 0 !important;
        padding-top: 14px!important;
        display: flex;
        justify-content: space-between;
    }
    .member-wishlist-wrap .menu-item .menu-info{
        padding-right: 0 !important;

    }

    .companyname{
        color: #72bf44 !important;
    }
    .member-wishlist-wrap .menu-item .menu-info  h4.company-name {
        padding: 0 15px;
        border: 0;
        border-left: 1px solid #72bf44 !important;
        /* border-right: 1px solid #5d5d5d; */
    }
    .menu-item .menu-info h4 b{
        font-weight: 900 !important
    }
    @media (max-width: 1199px){
        .menu-item .menu-info{
            flex-wrap: wrap;
        }
        .menu-item .menu-info h4:first-of-type{
            width: 100%;
            margin-bottom: 10px
        }
        .member-wishlist-wrap .menu-item .menu-info  h4.company-name {
            border: 0 !important;
            padding: 0 !important;
        }
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
            <div class="member-menu mt-5">
                <div class="container">
                    @include('frontend.user.user_menu')
                </div>
            </div>
            <div class="container">
                <div class="member-wishlist-wrap">
                    <!-- <h1>{{__('Product Wishlist')}}</h1> -->
                    <div class="mw-box">
                        <div class="mw-grid golo-grid grid-4 ">
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
                                                <h4 class="companyname"><b>{{$menu['place']['name']}}</b></h4>
                                                <h4 class="company-name"><b>{{$menu['name']}}</b></h4>
                                                {{-- <p>{{$menu['description']}}</p> --}}
                                                <span class="price" style="color: red;font-weight: 700;">${{$menu['price']}}</span>
                                            </div>
                                        </a>
                                    </div>

                                <!-- </div> -->
                            @empty
                                No Wishlist
                            @endforelse
                        </div>
                    </div><!-- .mw-box -->
                </div><!-- .member-wrap -->

                @include('frontend.common.banner_ads')

            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop
