@extends('frontend.layouts.template')
@php
$contact_title_bg = "style='background-image:url(images/contact-01.png)'";
@endphp
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
                                <div class = "country_box_name">Near me</div>
                                <div class = "country_box_nz">New Zealand</div>
                            </div>
                        </div>
                        <div class="col-lg-8 country_box_desc" >
                            <div class="country_box_description">
                                Places near you.
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-lg-3 country_box_map" style="padding:0; background-color:#d2d2d2;">
                        <div class="featured_map_image">
                            @php
                                $mapurl = 'assets/images/Near me.png';
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
        </div><!-- .page-title -->


        <div class="container near-me-content">

            <div class="row search-container ml-0 mr-0 mb-4 mt-0">

                <div class="flex near-me-btndiv">
                    <div class="near-me-category">Category</div>
                    <div id="wishFilterBtns">
                        @include('frontend.user.wishFilterBtn')
                        @foreach( $categories as $cat)
                            <button class="btn btnSearchCateogry btnCat{{$cat->slug}}" data-id="{{$cat->id}}" style="border:1px solid {{$cat->color_code}}">
                                <span>@include('frontend.user.svgImage')</span>
                                <span>{{$cat->name}}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="search-sub-category">Sub Category:</label>
                                <select class="form-control select2" id="search-sub-category" name="search-sub-category" data-placeholder="{{__('Select Sub Category')}}">
                                <option value="0">All</option>

                                </select>
                            </div>
                        </div> -->


            </div>

            <div id="map" class="maps-wrap-info" style="min-height: 650px;">
            </div>

            @include('frontend.common.banner_ads')
        </div>
        </div><!-- .site-content -->
</main><!-- .site-main -->

@stop

@push('scripts')
<script>
    var map;
        function initMap(lat,lng) {

            if((lat=="" || lng=="") || (lat==undefined || lng==undefined)){
                lat = -41.276825;
                lng = 174.777969;
            }

            const myLatLng = { lat: lat, lng: lng };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: myLatLng,
            });

            const remove_poi = [
                    {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                    }
                ]
            map.setOptions({styles: remove_poi})

            // new google.maps.Marker({
            //     position: myLatLng,
            //     map,
            //     // title: "Hello World!",
            // });

            // new google.maps.Marker({
            //     position: { lat: -42.276825, lng: 174.777969 },
            //     map
            // });

            // new google.maps.Marker({
            //     position: { lat: -42.276825, lng: 173.777969 },
            //     map
            // });
        }
        initMap();
</script>

<script>
    var category = [];
    $('#wishFilterBtns .btnSearchCateogry').each(function() {
                var category_slug = $(this).data('id');
                category.push(category_slug);
    });
    $(document).on("click", "#wishFilterBtns .btnSearchCateogry" , function() {

        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }
        if ($('#wishFilterBtns .btnSearchCateogry.active').length == 0) {
            category = [];
            $('#wishFilterBtns .btnSearchCateogry').each(function() {
                var category_slug = $(this).data('id');
                category.push(category_slug);
            });
        } else {
            category = [];
            $('#wishFilterBtns .btnSearchCateogry.active').each(function() {
                var category_slug = $(this).data('id');
                category.push(category_slug);
            });
        }
        initMap("","");
        getLocation();
    });
    function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                initMap("","");
                console.error("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;

            // console.log('lat lng ---',lat,lng);
            getNearByPlaces(lat,lng);
            initMap(lat,lng);
        }

        getLocation();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getNearByPlaces(lat,lng){
            // let category = $("#search-category").val();
            // console.log(category);
            //let subcategory = $("#search-sub-category").val();
            $.ajax({
                url: "{{ route('near_by_places') }}",
                type: "POST",
                data: {lat:lat,lng:lng,category:category},
                dataType: 'json',
                success: function(result)
                {
                    if (result.status == true) {
                        const places = result.data;
                        // console.log('places-----',places) ;
                        if(places){
                            golo_create_markers(places, map,category);
                        }
                    }//if
                },
                error: function () {
                }
            });
        }


        var golo_create_markers = function (data, map,category) {
                var infowindow = new google.maps.InfoWindow();
                // console.log("data",data);
                $.each(data, function (i, value) {

                    let html_review = '';
                    let html_category = '';
                    if (value.avg_review.length) {
                        html_review = `
                            ${value.avg_review[0]['aggregate']} <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="#DDD" fill-rule="evenodd" d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/></svg>
                            `;
                    }

                    if (value.categories) {
                        for (var j = 0; j < value.categories.length; j++) {
                            html_category += `<a style="color: #000;font-size:16px;font-weight:bold"> ${value.categories[j]['name']}</a>`;
                        }
                    }

                    var html_infowindow = `
                        <div id='infowindow'>
                            <div class="places-item" data-title="${value.name}" data-lat="-33.796864" data-lng="150.620614" data-index="${i}">
                                <a href="/place/${value.slug}"><img src="/uploads/${value.thumb}" alt=""></a>
                                <div class="places-item__info">
                                    <span class="places-item__category">${html_category}</span>
                                    <a href="/place/${value.slug}"><h3>${value.name}</h3></a>
                                    <div class="places-item__meta">
                                        <div class="places-item__reviews">
                                            <span class="places-item__number">
                                                ${html_review}
                                                <span class="places-item__count">(${value.reviews_count} reviews)</span>
                                            </span>
                                            <img src="{{asset('assets/images/favicon.png')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;

                    let marker_options = {
                        position: {lat: parseFloat(value.lat), lng: parseFloat(value.lng)},
                        map: map,
                        draggable: false,
                        animation: google.maps.Animation.DROP
                    };
                    let catImage=[];
                    if(category>0)
                    {
                      catImage=value.categories.filter((data) => data.id==category)
                    }
                    else
                    {
                        catImage=value.categories;
                    }
                    // console.log("category type of",typeof category)
                    // console.log("category",category)
                    // console.log("catImage type of",typeof catImage)
                    // console.log("catImage",catImage)
                    if (catImage.length>0 && catImage[0].icon_map_marker) {
                        // marker_options.icon = {
                        //     path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                        //     strokeColor: "red",
                        //     scale: 3
                        // }
                        marker_options.icon = {
                            url: `/category/map-pin/${catImage[0].id}`
                        }
                        // marker_options.icon = {
                        //     url: `/uploads/${value.categories[0].icon_map_marker}`
                        // }
                    }
                    let marker = new google.maps.Marker(marker_options);
                    marker.addListener('click', function () {
                        infowindow.setContent(html_infowindow);
                        infowindow.open(map, this);
                    });
                }); // End each data

            };
</script>

<script>
    $(document).ready(function() {
            $('.select2').select2();
        });

        $(document).on("change", "#search-category", function () {


            // let category = $(this).val();

            // console.log('category val:',category);


            $.ajax({
                url: "{{ route('get_subcategories_for_category') }}",
                type: "POST",
                data: {category:category},
                dataType: 'json',
                success: function(result)
                {
                    if (result.status == true) {
                        let place_types = result.data;
                        // console.log('place_types:',place_types);


                        let options = "<option value='0'>All</option>";
                        place_types.forEach(element => {
                            options += "<optgroup label='"+element['name']+"'>";

                            element['place_type'].forEach(place_type => {
                                options += "<option value='"+place_type['id']+" >"+place_type['name']+"</option>";
                            });
                            options += "</optgroup>";
                        });

                        $('#search-sub-category').html(options);

                    }//if
                },
                error: function () {
                }
            });

        });

        $(document).on("change", "#search-sub-category", function () {
            initMap("","");
            getLocation();
        });
</script>
@endpush
