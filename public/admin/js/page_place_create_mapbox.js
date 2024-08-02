$('input[type=text]').on('keydown', function (e) {
    if (e.which === 13) {
        e.preventDefault();
    }
});

var customerBox = $('.place_create_menu').offset().top;
$(window).scroll(function () {
    if ($(window).scrollTop() >= customerBox) {
        $('.place_create_menu').addClass('scroll-top');
    } else {
        $('.place_create_menu').removeClass('scroll-top');
    }
});

$('.cb_openday').change(function (event) {
    console.log("checkbox_day:", event.currentTarget);
});

$('#social_addmore').click(function () {
    let social_list = $('#social_list');
    let social_item = $('.social_item').length;
    social_list.append(`
                <div class="row form-group social_item" id="social_item_${social_item}">
                    <div class="col-md-5">
                        <select class="form-control" name="social[${social_item}][name]">
                            <option value="Facebook">Facebook</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Youtube">Youtube</option>
                            <option value="Twitter">Twitter</option>
                            <option value="Pinterest">Pinterest</option>
                            <option value="Snapchat">Snapchat</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="social[${social_item}][url]" placeholder="Enter URL include http or www">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger social_item_remove" id="${social_item}">X</button>
                    </div>
                </div>
            `);
});

$(document).on("click", ".social_item_remove", function (event) {
    let id = event.currentTarget.getAttribute('id');
    $(`#social_item_${id}`).remove();
});

// Menu event
$('#menu_addmore').click(function () {
    let social_list = $('#menu_list');
    let social_item = $('.menu_item').length;
    social_list.append(`
        <div class="row form-group menu_item" id="menu_item_${social_item}">
            <div class="col-md-2">
                <div class="lfm" data-input="thumbnail_${social_item}" data-preview="holder_${social_item}">
                    <div class="menu_thumb_preview" id="holder_${social_item}">
                        <img src="https://via.placeholder.com/105x87?text=select" alt="" style="width: 100%;height: 87px;object-fit: cover">
                    </div>
                    <input id="thumbnail_${social_item}" class="form-control" type="hidden" name="menu[${social_item}][thumb]">
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" name="menu[${social_item}][name]" value="" placeholder="Menu name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" name="menu[${social_item}][price]" value="" placeholder="Menu price">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="menu[${social_item}][description]" value="" placeholder="Menu description">
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger menu_item_remove" id="${social_item}">X</button>
            </div>
        </div>
    `);
});

$(document).on("click", ".menu_item_remove", function (event) {
    let id = event.currentTarget.getAttribute('id');
    $(`#menu_item_${id}`).remove();
});

// Faq event
$('#faq_addmore').click(function () {
    let social_list = $('#faq_list');
    let social_item = $('.faq_item').length;
    social_list.append(`
        <div class="row form-group faq_item" id="faq_item_${social_item}">
            <div class="col-md-11">
                <div class="form-group">
                    <input type="text" class="form-control" name="faq[${social_item}][question]" value="" placeholder="Enter question">
                </div>
                <div class="form-group">
                    <textarea type="text" class="form-control" name="faq[${social_item}][answer]" placeholder="Enter answer"></textarea>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger faq_item_remove" id="${social_item}">X</button>
            </div>
        </div>
    `);
});

$(document).on("click", ".faq_item_remove", function (event) {
    let id = event.currentTarget.getAttribute('id');
    $(`#faq_item_${id}`).remove();
});



$('#openinghour_addmore').click(function () {
    let openinghour_list = $('#openinghour_list');
    let openinghour_item = $('.openinghour_item').length;

    console.log('openinghour_item: ', openinghour_item)

    openinghour_list.append(`
                <div class="row form-group social_item" id="openinghour_item_${openinghour_item}">
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="" name="opening_hour[${openinghour_item}][title]" placeholder="Enter valute: Exp: Monday" ">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="opening_hour[${openinghour_item}][value]" placeholder="enter value. Exp: 9:00 - 21:00">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger openinghour_item_remove" data-id="${openinghour_item}">X</button>
                    </div>
                </div>
            `);
});

$(document).on("click", ".openinghour_item_remove", function (event) {
    let id = event.currentTarget.getAttribute('data-id');
    $(`#openinghour_item_${id}`).remove();
});

$('#thumb').change(function () {
    previewUploadImage(this, 'preview_thumb')
});

$('#select_country').change(function () {
    let country_id = $(this).val();
    let select_city = $('#select_city');
    let data_resp = callAPI({
        url: getUrlAPI(`${app_url}/cities/${country_id}`, 'full'),
        method: "GET"
    });
    data_resp.then(res => {
        let html = '';
        res.forEach(function (value, index) {
            html += `<option value="${value.id}">${value.name}</option>`;
        });
        select_city.find('option').remove();
        select_city.append(html);
    });
});

$('#gallery').change(function () {
    var form_data = new FormData();
    form_data.append('image', this.files[0]);
    form_data.append('_token', CSRF_TOKEN);
    $.ajax({
        url: getUrlAPI('/upload-image', 'api'),
        data: form_data,
        type: 'POST',
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.fail) {
                alert(res.errors['image']);
            } else {
                if (res.code === 200) {
                    let html = `
                                <div class="col-sm-2 media-thumb-wrap">
                                    <figure class="media-thumb">
                                        <img src="/uploads/${res.file_name}">
                                        <div class="media-item-actions">
                                            <a class="icon icon-delete" data-filename="${res.file_name}" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16">
                                                    <g fill="#5D5D5D" fill-rule="nonzero">
                                                        <path d="M14.964 2.32h-4.036V0H4.105v2.32H.07v1.387h1.37l.924 12.25H12.67l.925-12.25h1.369V2.319zm-9.471-.933H9.54v.932H5.493v-.932zm5.89 13.183H3.65L2.83 3.707h9.374l-.82 10.863z"></path>
                                                        <path d="M6.961 6.076h1.11v6.126h-1.11zM4.834 6.076h1.11v6.126h-1.11zM9.089 6.076h1.11v6.126h-1.11z"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                            <input type="hidden" name="gallery[]" value="${res.file_name}">
                                            <span class="icon icon-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                                        </div>
                                    </figure>
                                </div>
                            `;
                    $('#place_gallery_thumbs').append(html);
                }
            }
        },
        error: function (xhr, status, error) {
            alert('An error occurred!');
            console.log(xhr.responseText);
        }
    });
});

$(document).on("click", ".icon-delete", function (event) {
    event.preventDefault();
    let thumbnail = $(this).closest('.media-thumb-wrap');
    thumbnail.remove();
});

$('input[name=booking_type]').change(function () {
    let booking_type = $(this).val();

    console.log("booking_type: ", booking_type);

    if (booking_type == 3) {
        console.log("showwww");
        $('#booking_affiliate_link').show();
    } else {
        $('#booking_affiliate_link').hide();
    }
});

$(function () {
    $("#place_gallery_thumbs").sortable().disableSelection();
});

function placeMap() {
    let place_lat = parseFloat($('#place_lat').val()) || -33.8688;
    let place_lng = parseFloat($('#place_lng').val()) || 151.2195;
    let place_icon_marker = $('#place_icon_marker').val();

    var map_location = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
        center: [place_lng, place_lat], // starting position [lng, lat]
        zoom: 12 // starting zoom
    });

    var marker_location = new mapboxgl.Marker()
        .setLngLat([place_lng, place_lat])
        .addTo(map_location);

    var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    });

    geocoder.addTo(map_location);


    controlMarker();

    function controlMarker() {
        // This event listener will call addMarker() when the map is clicked.
        map_location.on('click', function(event) {
            if( jQuery('body .lock-marker').length == 0 ) {
                var lngLat = marker_location.getLngLat();
                marker_location.setLngLat(event.lngLat).addTo(map_location);
                $( '#place_lat' ).val(lngLat.lat);
                $( '#place_lng' ).val(lngLat.lng);
            }
        });
        
        function onDragEnd() {
            var lngLat = marker_location.getLngLat();
            marker_location.setLngLat([lngLat.lng, lngLat.lat]);
            $( '#place_lat' ).val(lngLat.lat);
            $( '#place_lng' ).val(lngLat.lng);
        }
         
        marker_location.on('dragend', onDragEnd);
    }

    geocoder.on('result', function(ev) {
        $( '#place_lat' ).val(ev.result.geometry['coordinates'][1]);
        $( '#place_lng' ).val(ev.result.geometry['coordinates'][0]);
        jQuery( '.mapboxgl-marker:last-child' ).remove();
    });
}
