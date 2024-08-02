(function ($) {
    'use strict';

    $('input[type=text]').on('keydown', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });

    /**
     * Event click add more social
     */
    $('#social_addmore').click(function (event) {
        event.preventDefault();
        let social_list = $('.social_list');
        let social_item = $('.social_item').length;
        if (social_item <= 6) {
            social_list.append(`
                    <div class="field-inline field-3col  d-block social_item">
                             <div class="flex-block d-grid">
                                <div class="field-group field-select col-md-6">
                                    <div class="custom-dropdown">
                                        <select name="social[${social_item}][name]" id="place_socials">
                                            <option value="">Select network</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Instagram">Instagram</option>
                                            <option value="Youtube">Youtube</option>
                                            <option value="Twitter">Twitter</option>
                                            <option value="Pinterest">Pinterest</option>
                                            <option value="Snapchat">Snapchat</option>
                                        </select>
                                </div>
                            </div>
                            <div class="field-group field-input col-md-6">
                                <input type="text" name="social[${social_item}][url]" placeholder="Enter URL include http or www">
                            </div>
                             <a href="#" class="social_item_remove">
                                <i class="la la-trash-alt"></i>
                            </a>
                        </div>

                    </div>
                `);
        }
    });
    $(document).on("click", ".social_item_remove", function (event) {
        event.preventDefault();
        $(this).parents('.field-3col').remove();
    });

    // ---------------- START
    // Menu event
    $('#menu_addmore').click(function () {
        let social_list = $('#menu_list');
        let social_item = $('.menu_item').length;
        const label = $("#lis_category option:selected").data('label');
        const placeHolderForAdult = PRICING_TEXT[label]['adult'];
        const placeHolderForChild = PRICING_TEXT[label]['child'];
        let is_limited_products = gv_is_limited_products; //Global Variable
        let max_product_allowed = gv_max_product_allowed; //Global Variable
        var placename = $('#place_name').val();
        if (is_limited_products == gv_limited && (social_item >= max_product_allowed)) {
            $('#menu_addmore').attr('disabled', 'true');
            $('#error-msg-max-pro').html('Products limit reached, Maximum ' + max_product_allowed + ' products are allowed!');
            return;
        }
        var pricelabel = '';
        var hidechield = '';
        if(label == 'stay'){
            pricelabel = 'Price Per Night';
            hidechield = 'd-none';
        }else if(label == 'rent'){
            pricelabel = 'Price Per Day';
            hidechield = 'd-none';
        }else{
            pricelabel = 'Adult Price';
            hidechield = 'd-block';
        }
        if(label == 'travel' && placename == 'Sealink'){
            social_list.append(`
                <div class="row form-group menu_item create" id="menu_item_${social_item}">
                    <div class="col-12 text-right">
                        <!-- <button type="button" class="btn btn-danger menu_item_remove" id="${social_item}">X</button> -->
                        <a href="javascript:void(0);" class="menu_item_remove pt-2" id="${social_item}"><i class="la la-trash-alt"></i></a>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-4 list_box_li_first">
                        <div class="field-group field-file product-upload-preview">
                            <label for="product_thumb_image_${social_item}" class="preview">
                            <input type="file" data-sr-id="${social_item}" id="product_thumb_image_${social_item}" class="upload-file product_thumb_image">
                            <input type="hidden" id="product_thumb_hidden_image_${social_item}" name="menu[${social_item}][thumb]" value="">
                                <img class="product_thumb_preview" id="product_thumb_preview_${social_item}" src="https://via.placeholder.com/300x300?text=VentureNZ" alt=""/>
                                <i class="la la-cloud-upload-alt"></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 col-md-8list_box_li_second">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][name]" value="" placeholder="Product name" data-rule-required="true">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][description]" value="" placeholder="Product description" data-rule-required="true">
                                </div>
                            </div>
                        </div>
                
                        <div class="row date-content">
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 hidecarprice addhiddenclass ${hidechield}">
                                <div class="form-group">
                                    <label>Vehicle Price</label>
                                    <input type="text" class="form-control car-price-placeholder" name="menu[${social_item}][car_price]" value="" placeholder=""
                                    data-rule-number="true" data-rule-min="1">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 hidecardisc addhiddenclass ${hidechield}">
                                <div class="form-group">
                                    <label>Vehicle Discounted Amount</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][car_discount_price]" value="" placeholder="Discount $"
                                    id="car_discount_price_${social_item}"
                                    data-rule-number="true">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="form-group">
                                    <label class="pricelabel">${pricelabel}</label>
                                    <input type="text" class="form-control adult-price-placeholder" name="menu[${social_item}][price]" value="0.00" placeholder="${placeHolderForAdult}"
                                    data-rule-number="true" data-rule-min="1">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="form-group">
                                    <label>Discounted Amount</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][discount_percentage]" value="0.00" placeholder="Discount $"
                                    data-rule-number="true"
                                    id="price_discounted_amount_${social_item}"
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 addhiddenclass ${hidechield}">
                                <div class="form-group">
                                    <label>Child Price</label>
                                    <input type="text" class="form-control child-price-placeholder" name="menu[${social_item}][child_price]" value="0.00" placeholder="${placeHolderForChild}"
                                    data-rule-number="true"
                                    data-rule-greaterThan="#child_discount_price_${social_item}"
                                    data-msg-greaterThan='Child price must be greater then child discount'
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 addhiddenclass ${hidechield}">
                                <div class="form-group">
                                    <label>Child Discounted Amount</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][child_discount_price]" value="0.00" placeholder="Discount $"
                                    id="child_discount_price_${social_item}"
                                    data-rule-number="true">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                <div class="form-group">
                                    <label>Discount Start Date</label>
                                    <input type="date" class="form-control" name="menu[${social_item}][discount_start_date]" value="" placeholder="Start Date">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                <div class="form-group">
                                    <label>Discount End Date</label>
                                    <input type="date" class="form-control" name="menu[${social_item}][discount_end_date]" value="" placeholder="End Date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row  date-content">
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="featured_input">
                                    <div class="field-group field-check mb-0">
                                        <label for="featured_${social_item}" class="text-right mb-0 mt-2">
                                            <input class="featured_checkbox" type="checkbox" name="menu[${social_item}][featured]" id="featured_${social_item}" value="1">Feature
                                            <span class="checkmark">
                                                <i class="la la-check"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="featured_input">
                                    <div class="field-group field-check mb-0">
                                        <label for="online_payment_${social_item}" class="text-right mb-0 mt-2 payment-label">
                                            <input type="checkbox" name="menu[${social_item}][online_payment_required]" id="online_payment_${social_item}" value="1">Online Payment Required
                                            <span class="checkmark">
                                                <i class="la la-check"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="">
                                    <div class="field-group d-flex mb-0">
                                        <label for=color_code_${social_item}"
                                            class="text-right mb-0 payment-label">
                                            <input style="width: 40px; height:20px; border-bottom:none" type="color" name="menu[${social_item}][color_code]"
                                                id="color_code_{{$key}}" value="#72bf44"> Color Code
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }else{
            social_list.append(`
                <div class="row form-group menu_item create" id="menu_item_${social_item}">
                    <div class="col-12 text-right">
                        <!-- <button type="button" class="btn btn-danger menu_item_remove" id="${social_item}">X</button> -->
                        <a href="javascript:void(0);" class="menu_item_remove pt-2" id="${social_item}"><i class="la la-trash-alt"></i></a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 list_box_li_first">
                        <div class="field-group field-file product-upload-preview">
                            <label for="product_thumb_image_${social_item}" class="preview">
                            <input type="file" data-sr-id="${social_item}" id="product_thumb_image_${social_item}" class="upload-file product_thumb_image">
                            <input type="hidden" id="product_thumb_hidden_image_${social_item}" name="menu[${social_item}][thumb]" value="">
                                <img class="product_thumb_preview" id="product_thumb_preview_${social_item}" src="https://via.placeholder.com/300x300?text=VentureNZ" alt=""/>
                                <i class="la la-cloud-upload-alt"></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 col-md-8list_box_li_second">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][name]" value="" placeholder="Product name" data-rule-required="true">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][description]" value="" placeholder="Product description" data-rule-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="row date-content">
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="form-group">
                                    <label class="pricelabel">${pricelabel}</label>
                                    <input type="text" class="form-control adult-price-placeholder" name="menu[${social_item}][price]" value="0.00" placeholder="${placeHolderForAdult}"
                                    data-rule-required="true" data-rule-number="true"
                                    data-rule-greaterThan="#price_discounted_amount_${social_item}"
                                    data-msg-greaterThan='Price must be greater then discount'
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="form-group">
                                    <label>Discounted Amount</label>
                                    <input type="text" class="form-control" name="menu[${social_item}][discount_percentage]" value="0.00" placeholder="Discount $"
                                    data-rule-required="true"
                                    data-rule-number="true"
                                    id="price_discounted_amount_${social_item}"
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 addhiddenclass ${hidechield}">
                            <div class="form-group">
                                <label>Child Price</label>
                                <input type="text" class="form-control child-price-placeholder" name="menu[${social_item}][child_price]" value="0.00" placeholder="${placeHolderForChild}"
                                data-rule-number="true"
                                data-rule-greaterThan="#child_discount_price_${social_item}"
                                data-msg-greaterThan='Child price must be greater then child discount'
                                >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 addhiddenclass ${hidechield}">
                            <div class="form-group">
                                <label>Child Discounted Amount</label>
                                <input type="text" class="form-control" name="menu[${social_item}][child_discount_price]" value="0.00" placeholder="Discount $"
                                id="child_discount_price_${social_item}"
                                data-rule-number="true"

                                >
                            </div>
                        </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                <div class="form-group">
                                    <label>Discount Start Date</label>
                                    <input type="date" class="form-control" name="menu[${social_item}][discount_start_date]" value="" placeholder="Start Date">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                <div class="form-group">
                                    <label>Discount End Date</label>
                                    <input type="date" class="form-control" name="menu[${social_item}][discount_end_date]" value="" placeholder="End Date">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row  date-content">

                            <div class="col-lg-3 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="featured_input">
                                    <div class="field-group field-check mb-0">
                                        <label for="featured_${social_item}" class="text-right mb-0 mt-2">
                                            <input class="featured_checkbox" type="checkbox" name="menu[${social_item}][featured]" id="featured_${social_item}" value="1">Feature
                                            <span class="checkmark">
                                                <i class="la la-check"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="featured_input">
                                    <div class="field-group field-check mb-0">
                                        <label for="online_payment_${social_item}" class="text-right mb-0 mt-2 payment-label">
                                            <input type="checkbox" name="menu[${social_item}][online_payment_required]" id="online_payment_${social_item}" value="1">Online Payment Required
                                            <span class="checkmark">
                                                <i class="la la-check"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group-margin col-6">
                                <div class="">
                                    <div class="field-group d-flex mb-0">
                                        <label for=color_code_${social_item}"
                                            class="text-right mb-0 payment-label">
                                            <input style="width: 40px; height:20px; border-bottom:none" type="color" name="menu[${social_item}][color_code]"
                                                id="color_code_{{$key}}" value="#72bf44"> Color Code
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            `);

            // $.validator.addMethod("checkCode", function(value, element, param) {
            //     console.log()
            // }, 'This field is required');
        }

    });

    $(document).on("click", ".menu_item_remove", function (event) {
        let id = event.currentTarget.getAttribute('id');
        $(`#menu_item_${id}`).remove();
        $('#menu_addmore').attr('disabled', false);
        $('#error-msg-max-pro').html('');
    });

    $(document).on("click", ".featured_checkbox", function (event) {
        let featuredCount = $('input.featured_checkbox:checked').length;
        if (featuredCount > gv_max_featured_product_allowed && gv_is_limited_featured_products == 1) {
            if ($(this).is(':checked')) {
                event.preventDefault();
            }
            Tost('Only ' + gv_max_featured_product_allowed + ' product allowed to be featured!', 'error');
        }
    });

    // Show thumbnail preview
    $(document).on('change', '.product_thumb_image', function () {
        let srId = $(this).attr('data-sr-id');
        previewUploadImageMod(this, '#product_thumb_preview_' + srId);

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
                console.log("image upload res", res);

                if (res.fail) {
                    alert(res.errors['image']);
                } else {
                    if (res.code === 200) {
                        // previewUploadImageMod(this, '#product_thumb_preview_'+srId);

                        let element_id = '#product_thumb_preview_' + srId;
                        $(`${element_id}`).attr('src', `/uploads/${res.file_name}`);

                        let element_hidden_id = '#product_thumb_hidden_image_' + srId;
                        $(`${element_hidden_id}`).attr('value', `/uploads/${res.file_name}`);


                        let html = `
                                <div class="media-thumb-wrap">
                                    <figure class="media-thumb">
                                        <img src="/uploads/${res.file_name}">
                                        <div class="media-item-actions">
                                            <a class="icon icon-delete" data-filename="${res.file_name}" href="javascript:void(0)">
                                                <i class="la la-times"></i>
                                            </a>
                                            <input type="hidden" name="gallery[]" value="${res.file_name}">
                                            <span class="icon icon-loader"><i class="fa fa-spinner fa-spin"></i></span>
                                        </div>
                                    </figure>
                                </div>
                            `;
                        // $('#gallery_preview').append(html);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseJSON);
                alert(xhr.responseJSON.message);
            }
        });

    });


    // Show thumbnail preview
    // $(document).on('change', '.product_thumb_image', function() {
    //     let srId = $(this).attr('data-sr-id');
    //     previewUploadImageMod(this, '#product_thumb_preview_'+srId);
    // });

    // ================ END





    /**
     * Event select country => show list city
     */
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

    /**
     * Upload gallery
     */
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
                console.log("res");

                if (res.fail) {
                    alert(res.errors['image']);
                } else {
                    if (res.code === 200) {
                        let html = `
                                <div class="media-thumb-wrap">
                                    <figure class="media-thumb">
                                        <img src="/uploads/${res.file_name}">
                                        <div class="media-item-actions">
                                            <a class="icon icon-delete" data-filename="${res.file_name}" href="javascript:void(0)">
                                                <i class="la la-times"></i>
                                            </a>
                                            <input type="hidden" name="gallery[]" value="${res.file_name}">
                                            <span class="icon icon-loader"><i class="fa fa-spinner fa-spin"></i></span>
                                        </div>
                                    </figure>
                                </div>
                            `;
                        $('#gallery_preview').append(html);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseJSON);
                alert(xhr.responseJSON.message);
            }
        });
    });

    // Delete preview gallery
    $(document).on("click", ".icon-delete", function (event) {
        event.preventDefault();
        let thumbnail = $(this).closest('.media-thumb-wrap');
        thumbnail.remove();
    });

    // Show thumbnail preview
    $('#thumb_image').change(function () {
        previewUploadImage(this, 'thumb_preview')
    });

    // Show logo preview
    $('#logo_image').change(function () {
        previewUploadImage(this, 'logo_preview')
    });

    // Add more opening hour
    $('#openinghour_addmore').click(function () {
        event.preventDefault();
        let openinghour_list = $('#time-opening');
        let openinghour_item = $('.openinghour_item').length;
        openinghour_list.append(`
                <div class="field-inline field-3col d-block social_item">
                     <div class="flex-block d-grid">
                        <div class="field-group field-input">
                            <input type="text" class="form-control valid" name="opening_hour[${openinghour_item}][title]" placeholder="Enter day open">
                        </div>
                        <div class="field-group field-input">
                            <input type="text" class="form-control" name="opening_hour[${openinghour_item}][value]" placeholder="Enter time open">
                        </div>
                        <a href="#" class="openinghour_item_remove">
                        <i class="la la-trash-alt"></i>
                        </a>
                    </div>
                </div>
            `);
    });
    $(document).on("click", ".openinghour_item_remove", function (event) {
        event.preventDefault();
        $(this).parents('.field-3col').remove();
    });

})(jQuery);

/**
 * Google map
 */
// function placeMap() {
let place_lat = parseFloat($('#place_lat').val()) || -33.8688;
let place_lng = parseFloat($('#place_lng').val()) || 151.2195;

let map = new google.maps.Map(document.getElementById('map'), {
    center: { lat: place_lat, lng: place_lng },
    zoom: 16,
    mapTypeId: 'roadmap',
    mapTypeControl: false,
    fullscreenControl: true,
    streetViewControl: false,
    disableDefaultUI: false,
});

// Create marker by lat,lng
let latLng = new google.maps.LatLng(place_lat, place_lng);
new google.maps.Marker({
    position: latLng,
    map: map,
    draggable: true
});

// Create the search box and link it to the UI element.
let input = document.getElementById('pac-input');
let searchBox = new google.maps.places.SearchBox(input);
// map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

// Bias the SearchBox results towards current map's viewport.
map.addListener('bounds_changed', function () {
    searchBox.setBounds(map.getBounds());
});

let markers = [];
// Listen for the event fired when the user selects a prediction and retrieve
// more details for that place.
searchBox.addListener('places_changed', function () {
    let places = searchBox.getPlaces();

    if (places.length === 0) {
        return;
    }

    // Clear out the old markers.
    markers.forEach(function (marker) {
        marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    let bounds = new google.maps.LatLngBounds();
    places.forEach(function (place) {
        if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
        }

        // Create a marker for each place.
        markers.push(new google.maps.Marker({
            map: map,
            title: place.name,
            position: place.geometry.location
        }));

        if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
        } else {
            bounds.extend(place.geometry.location);
        }

        $('#place_address').val(place.formatted_address);
        $('#place_lat').val(place.geometry.location.lat());
        $('#place_lng').val(place.geometry.location.lng());

    });
    map.fitBounds(bounds);
});
// }
