var GL_BC = GL_BC || {};

(function ($) {
    "use strict";

    GL_BC = {
        init: function () {
            GL_BC.clickFilter();
            // GL_BC.categoryMap();
        },

        clickFilter: function () {
            $(document).on("click", "#wishFilterBtns .btnSearchCateogry" , function() {

                if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                } else {
                    $(this).addClass("active");
                }


                // CATEGORY
                var category_arr = [];
                var category_val = '';
                $('#wishFilterBtns .btnSearchCateogry.active').each(function(j) {
                    category_arr[j] = 'category[]='+$(this).attr('data-id');
                });

                if(category_arr.length > 0) {
                    category_val += category_arr.join('&');
                }

                var url = route_url+'/search-listing?';
                if(category_val != '') {
                    url += category_val;
                }
                window.location.href = encodeURI(url);
            });

            $(document).on('click', '.bc_filter', function (e) {
                // REGION
                var region_arr = [];
                var region_val = '';
                $('input[name="region[]"]:checked').each(function(i){
                    region_arr[i] = 'region[]='+$(this).val();
                });

                if(region_arr.length > 0) {
                    region_val += region_arr.join('&');
                }

                // CITY
                var city_arr = [];
                var city_val = '';
                $('input[name="city[]"]:checked').each(function(i){
                    city_arr[i] = 'city[]='+$(this).val();
                });

                if(city_arr.length > 0) {
                    city_val += city_arr.join('&');
                }

                // CATEGORY
                var category_arr = [];
                var category_val = '';
                $('input[name="category[]"]:checked').each(function(j) {
                    category_arr[j] = 'category[]='+$(this).val();
                });

                if(category_arr.length > 0) {
                    category_val += category_arr.join('&');
                }

                // SUB CATEGORY
                var place_type_arr = [];
                var place_type_val = '';
                $('input[name="place_type[]"]:checked').each(function(j) {
                    place_type_arr[j] = 'place_type[]='+$(this).val();
                });

                if(place_type_arr.length > 0) {
                    place_type_val += place_type_arr.join('&');
                }

                // Keywords
                var interest_arr = [];
                var interest_val = '';
                $('input[name="interest[]"]:checked').each(function(j) {
                    interest_arr[j] = 'interest[]='+$(this).val();
                });

                if(interest_arr.length > 0) {
                    interest_val += interest_arr.join('&');
                }

                var url = route_url+'/search-listing?';
                if(region_val != '') {
                    url += region_val;
                    if(city_val != '') {
                        url += '&'+city_val;
                    }
                }

                // if((region_val != '' || city_val != '') && (category_val != '' || place_type_val != '')) {
                //     url += '&';
                // }



                if((region_val != '' || city_val != '') && (category_val != '' || place_type_val != '' || interest_val != '')) {
                    url += '&';
                }

                if(category_val != '') {
                    url += category_val;
                    if(place_type_val != '') {
                        url += '&'+place_type_val;
                    }
                    if(interest_val != '') {
                        url += '&'+interest_val;
                    }
                }

                // if((region_val != '' || city_val != '') && (category_val != '' || place_type_val != '')) {
                //     url += '&';
                // }



                window.location.href = encodeURI(url);
                // $('#filterForm').submit();
            });
        },

        categoryMap: function () {
            var golo_create_markers = function (data, map) {
                var infowindow = new google.maps.InfoWindow();

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
                            html_category += `<a style="color: #666;"> ${value.categories[j]['name']}</a>`;
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
                                        </div>
                                        <div class="places-item__currency">${PRICE_RANGE[value.price_range]}</div>
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
                    if (value.categories[0].icon_map_marker) {
                        marker_options.icon = {
                            url: `/assets/images/icon-mapker.svg`
                        }
                    }
                    let marker = new google.maps.Marker(marker_options);
                    marker.addListener('click', function () {
                        infowindow.setContent(html_infowindow);
                        infowindow.open(map, this);
                    });
                }); // End each data
            };

            // call api get places
            let ajax_url = window.location.href;
            (ajax_url.indexOf('?') > -1) ? ajax_url += '&ajax=1' : ajax_url += '?ajax=1';

            $.ajax({
                dataType: 'json',
                url: ajax_url,
                beforeSend: function () {
                    console.log("before call api get places map");
                },
                success: function (response) {
                    let data = response.data;

                    console.log("data: ", data);

                    var golo_map_style_silver = [
                        {
                            "featureType": "landscape",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.icon",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "stylers": [
                                {
                                    "hue": "#00aaff"
                                },
                                {
                                    "saturation": -100
                                },
                                {
                                    "gamma": 2.15
                                },
                                {
                                    "lightness": 12
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "visibility": "on"
                                },
                                {
                                    "lightness": 24
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "lightness": 57
                                }
                            ]
                        }
                    ];
                    var golo_map_option = {
                        scrollwheel: false,
                        scroll: {x: $(window).scrollLeft(), y: $(window).scrollTop()},
                        zoom: 2,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        mapTypeControl: false,
                        fullscreenControl: true,
                        streetViewControl: true,
                        disableDefaultUI: false,
                        styles: golo_map_style_silver,
                        zoomControlOptions: {
                            position: google.maps.ControlPosition.RIGHT_CENTER
                        },
                        streetViewControlOptions: {
                            position: google.maps.ControlPosition.RIGHT_CENTER
                        },
                        fullscreenControlOptions: {
                            position: google.maps.ControlPosition.RIGHT_CENTER
                        }
                    };

                    if (data.city) {
                        golo_map_option.center = {lat: parseFloat(data.city.lat), lng: parseFloat(data.city.lng)};
                    } else {
                        console.log("khong co city: ", data.city);
                        golo_map_option.center = new google.maps.LatLng(0, 0);
                        golo_map_option.zoom = 2;
                        golo_map_option.minZoom = 0;
                    }

                    var map = new google.maps.Map(document.getElementById('place-map-filter'), golo_map_option);
                    golo_create_markers(data.places, map);

                },
            });


        }

    }

    GL_BC.init();

    // $(document).ready(function(){
    //     let region_num = 0;
    //     let region_num_str = "";
    //     let city_num = 0;
    //     let city_num_str = "";
    //     let cat_num = 0;
    //     let cat_num_str = "";
    //     let subcat_num = 0;
    //     let subcat_num_str = "";
    //     let interest_num = 0;
    //     let interest_num_str = "";
    //     $('input[name="region[]"]:checked').each(function(i){
    //         region_num += 1;
    //     });
    //     $('input[name="city[]"]:checked').each(function(i){
    //         city_num += 1;
    //     });
    //     $('input[name="category[]"]:checked').each(function(j) {
    //         cat_num += 1;
    //     });
    //     $('input[name="place_type[]"]:checked').each(function(j) {
    //         subcat_num += 1;
    //     });
    //     $('input[name="interest[]"]:checked').each(function(j) {
    //         interest_num += 1;
    //     });
    //     region_num_str = "(" + region_num + ")";
    //     city_num_str = "(" + city_num + ")";
    //     cat_num_str = "(" + cat_num + ")";
    //     subcat_num_str = "(" + subcat_num + ")";
    //     interest_num_str = "(" + interest_num + ")";
    //     $("#RegionSelNumber").html(region_num_str);
    //     $("#CitySelNumber").html(city_num_str);
    //     $("#CatSelNumber").html(cat_num_str);
    //     $("#SubcatSelNumber").html(subcat_num_str);
    //     $("#KeywordSelNumber").html(interest_num_str);
    // });

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

})(jQuery);
