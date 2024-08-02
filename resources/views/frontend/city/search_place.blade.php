<div
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