@extends('frontend.layouts.template')
@section('main')
@include('frontend.common.toastr-alert')
<main id="main" class="site-main listing-main">
    <div class="edit-profile-page">
        <div class="top-main-heading">
            <div class="container">
                <h2 class="headings">
                    @if(isRoute('place_edit'))
                    <i class="la la-edit"></i>
                    {{__('Edit Company Info')}}
                    @else
                    <i class="la la-edit"></i>
                    {{__('Add Company Info')}}
                    @endif
                </h2>
            </div>
        </div>
        <div class="container">
            <div class="d-flex profile-flex">
                <div class="listing-nav">
                    <div class="listing-menu nav-scroll">
                        <ul>
                            <li class="active">
                                <a href="#genaral" title="Genaral">
                                    <span class="icon"><i class="la la-cog"></i></span>
                                    <span>{{__('General')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#interest" title="Keywords">
                                    <span class="icon"><i class="fal fa-thumbs-up"></i></span>
                                    <span>{{__('Keywords')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#amenities" title="Amenities">
                                    <span class="icon"><i class="la la-wifi"></i></span>
                                    <span>{{__('Amenities')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#location" title="Location">
                                    <span class="icon"><i class="la la-map-marker"></i></span>
                                    <span>{{__('Location')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#contact" title="Contact info">
                                    <span class="icon"><i class="la la-phone"></i></span>
                                    <span>{{__('Contact info')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#bookinglink" title="Booking Info">
                                    <span class="icon"><i class="la la-phone"></i></span>
                                    <span>{{__('Booking Info')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#social" title="Social network">
                                    <span class="icon"><i class="la la-link"></i></span>
                                    <span>{{__('Social network')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#open" title="Open hourses">
                                    <span class="icon"><i class="la la-business-time"></i></span>
                                    <span>{{__('Open hours')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#product" title="Products">
                                    <span class="icon"><i class="la la-business-time"></i></span>
                                    <span>{{__('Products')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#media" title="Media">
                                    <span class="icon"><i class="la la-image"></i></span>
                                    <span>{{__('Media')}}</span>
                                </a>
                            </li>
                            @if($place)
                            <li>
                                <a href="#qrcode" title="QR Code">
                                    <span class="icon"><i class="la la-image"></i></span>
                                    <span>{{__('QR Code')}}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div><!-- .listing-nav -->

                <div class="listing-content site-content">
                    <form class="upload-form" id="new_place" action="{{route('place_create')}}" method="POST"
                        enctype="multipart/form-data">
                        @if(isRoute('place_edit'))
                        @method('PUT')
                        @endif
                        @csrf
                        <div class="listing-box" id="genaral">
                            <h3>{{__('General')}}</h3>
                            <div class="field-inline">
                                <div class="field-group field-input place_input">
                                    <label for="place_name">{{__('Company Name')}} ({{$language_default['code']}}) *</label>
                                    <input type="text" id="place_name" name="{{$language_default['code']}}[name]"
                                        value="{{$place['name'] ?? ''}}" required placeholder="{{__('What the name of place')}}">
                                </div>
                                <div class="field-group field-select">
                                    <label for="price_range">{{__('Price Range')}}</label>
                                    <div class="custom-dropdown">
                                    <select id="price_range" name="price_range">
                                        @foreach(PRICE_RANGE as $key => $price)
                                        <option value="{{$key}}" {{isSelected($key, $place['price_range'] ?? '' )}}>
                                            {{$price}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="field-group">
                                <label for="description">{{__('Description')}} ({{$language_default['code']}}) *</label>
                                <textarea class="form-control" id="description" name="{{$language_default['code']}}[description]"
                                    rows="5">{{$place['description'] ?? ''}}</textarea>
                            </div>
                            <div class="field-group">
                                <label for="needtobring">{{__('What you need to bring')}} ({{$language_default['code']}})</label>
                                <textarea class="form-control" id="needtobring" name="{{$language_default['code']}}[needtobring]"
                                    rows="5">{{$place['needtobring'] ?? ''}}</textarea>
                            </div>
                            <div class="row">
                            <div class="field-group field-select col-md-4 custom-margin mb-0">
                                <label for="lis_category">{{__('Category')}} *</label>
                                <select class="select2" id="lis_category" name="category[]"
                                    data-placeholder="{{__('Select Category')}}" required style="width: 100% !important;">
                                    @foreach($categories as $cat)
                                    <option value="{{$cat['id']}}" {{isSelected($cat['id'], $place['category'] ?? '' )}}
                                        data-label="{{$cat['slug']}}">
                                        {{$cat['name']}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="field-group field-select col-md-8 custom-margin mb-0">
                                <label for="lis_place_type">{{__('Sub Category')}} *</label>
                                <select class="select2" id="lis_place_type" name="place_type[]"
                                    data-placeholder="{{__('Select Sub Category')}}" multiple="multiple" required
                                    style="width: 100% !important;">
                                    @foreach($place_types as $cat)
                                    <optgroup label="{{$cat['name']}}">
                                        @foreach($cat['place_type'] as $type)
                                        <option value="{{$type['id']}}" {{isSelected($type['id'], $place['place_type'] ?? '' )}}>
                                            {{$type['name']}}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>

                            </div>
                            </div>


                        </div><!-- .listing-box -->
                        <div class="listing-box" id="interest">
                            <h3>{{__('Keywords')}}</h3>
                            <div class="field-group field-select custom-margin mb-0">
                                <label for="lis_interest">{{__('Keyword')}} *</label>
                                <select class="select2" id="lis_interest" name="interest[]"
                                    data-placeholder="{{__('Select Keywords')}}" multiple="multiple" size="4"
                                    style="width: 100% !important;">
                                    @foreach($interests as $interest)
                                    <optgroup label="{{$interest['name']}}">
                                        @foreach($interest['interest'] as $key)
                                        <option value="{{$key['id']}}" {{isSelected($key['id'], $place_keyword ?? '' )}}>
                                            {{$key['keyword']}}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- .listing-box -->
                        <div class="listing-box" id="amenities">
                            <h3>{{__('Amenities')}}</h3>
                            <div class="field-group field-check m-0">
                                @foreach($amenities as $item)
                                <div class="custom-checkbox">
                                    <input type="checkbox" name="amenities[]" id="amenities_{{$item['id']}}" value="{{$item['id']}}"
                                        {{isChecked($item['id'], $place['amenities'] ?? '' )}}>
                                    <label for="amenities_{{$item['id']}}">{{$item['name']}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div><!-- .listing-box -->
                        <div class="listing-box" id="location">
                            <h3>{{__('Location')}}</h3>
                            <div class="row location-ul">
                                <div class="col-md-6 location-li">
                                    <div class="field-group">
                                        <label for="place_address">{{__('Full Address')}}*</label>
                                        <input type="text" id="pac-input" placeholder="{{__('Full Address')}}"
                                            value="{{$place['address'] ?? ''}}" name="address" autocomplete="off" required />
                                    </div>
                                    <div class="field-group field-select">
                                        <label for="place_address">{{__('Region')}}*</label>
                                        <div class="custom-dropdown">
                                            <select name="country_id" class="custom-select" id="select_country" required>
                                                <option value="">{{__('Select region')}}</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country['id']}}" {{isSelected($country['id'], $place['country_id']
                                                    ?? '' )}}>{{$country['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field-group field-select">
                                        <label for="place_address">{{__('District')}} *</label>
                                        <div class="custom-dropdown">
                                            <select name="city_id" class="custom-select" id="select_city" required>
                                                <option value="">{{__('Select District')}}</option>
                                                @foreach($cities as $city)
                                                <option value="{{$city['id']}}" {{isSelected($city['id'], $place['city_id'] ?? '' )}}>
                                                    {{$city['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 location-li">
                                    <div class="field-group field-maps">
                                        <div class="field-inline">
                                            <label for="pac-input">{{__('Place Location at Google Map')}}</label>
                                        </div>
                                        <div class="field-map">
                                            <input type="hidden" name="category_name" id="category_name" value="demo">
                                            <input type="hidden" id="place_lat" name="lat" value="{{$place['lat'] ?? ''}}">
                                            <input type="hidden" id="place_lng" name="lng" value="{{$place['lng'] ?? ''}}">
                                            <input type="hidden" id="place_icon_marker"
                                                value="{{getImageUrl($categories[0]['icon_map_marker'])}}">
                                            <div id="map"></div>
                                            <div id="geocoder" class="geocoder"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div><!-- .listing-box -->
                        <div class="listing-box" id="contact">
                            <h3>Contact Info</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <label for="place_email">{{__('Email')}} *</label>
                                        <input type="email" id="place_email" value="{{$place['email'] ?? ''}}"
                                         name="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <label for="place_website">{{__('Website')}}</label>
                                        <input type="text" id="place_website" value="{{$place['website'] ?? ''}}"
                                            placeholder="{{__('Your website url')}}" name="website">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-group">
                                        <label for="place_number">{{__('Phone number')}}</label>
                                        <input type="tel" id="place_number" value="{{$place['phone_number'] ?? ''}}"
                                            placeholder="{{__('Your phone number')}}" name="phone_number">
                                    </div>
                                    <div class="form-group field-check d-block m-0">
                                        <div class="custom-checkbox mb-0">
                                        <input type="checkbox" id="hide_info" name="hide_info" value="1" @if(isset($place->hide_info) &&
                                        $place->hide_info==1) checked @endif
                                        >
                                        <label for="hide_info" class="label-check">Contact Info Not Required:</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .listing-box -->
                        <div class="listing-box" id="bookinglink">
                            <h3>Booking Info</h3>
                            <div class="field-group mb-0">
                                <label for="place_email">{{__('Booking Type')}}</label>
                                <div class="social_list1">
                                    <div class="field-inline field-3col social_item">
                                        <div class="field-group field-select">
                                            <div class="custom-dropdown">
                                            <select name="booking_type" id="booking_type">
                                                @if(isset($place['booking_type']))
                                                <!-- <option {{isSelected($place['booking_type'],App\Models\Booking::TYPE_AFFILIATE)}}
                                                    value="{{App\Models\Booking::TYPE_AFFILIATE}}">Booking Link</option> -->
                                                <option {{isSelected($place['booking_type'],App\Models\Booking::TYPE_BOOKING_FORM)}}
                                                    value="{{App\Models\Booking::TYPE_BOOKING_FORM}}">Reservation Form</option>
                                                <option {{isSelected($place['booking_type'],App\Models\Booking::TYPE_CONTACT_FORM)}}
                                                    value="{{App\Models\Booking::TYPE_CONTACT_FORM}}">Enquiry Form</option>
                                                @else
                                                <!-- <option {{isSelected('',App\Models\Booking::TYPE_AFFILIATE)}}
                                                    value="{{App\Models\Booking::TYPE_AFFILIATE}}">Booking Link</option> -->
                                                <option {{isSelected('',App\Models\Booking::TYPE_BOOKING_FORM)}}
                                                    value="{{App\Models\Booking::TYPE_BOOKING_FORM}}">Reservation Form</option>
                                                <option {{isSelected('',App\Models\Booking::TYPE_CONTACT_FORM)}}
                                                    value="{{App\Models\Booking::TYPE_CONTACT_FORM}}">Enquiry Form</option>
                                                @endif
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label id="place_booking_link_lbl" for="place_booking_link">{{__('Booking Link')}}</label>
                                <input type="text" id="place_booking_link" value="{{$place['link_bookingcom'] ?? ''}}"
                                    placeholder="{{__('External Booking Link')}}" name="link_bookingcom">

                                <label class="info-label" id="place_booking_link_warning">Booking/Enquiry Email will be sent on
                                    Contact Info -> Email</label>
                            </div>
                        </div><!-- .listing-box -->
                        <div class="listing-box" id="social">
                            <h3>{{__('Social Networks')}}</h3>
                            <div class="field-group mb-0">


                                <div class="social_list">
                                    @if(isset($place['social']))
                                    @foreach($place['social'] as $key => $social)
                                    <div class="field-inline d-block field-3col social_item">
                                        <div class="flex-block d-grid">
                                            <div class="field-group field-select">
                                                <label for="place_socials">{{__('Social Networks')}}</label>
                                                <div class="custom-dropdown">
                                                    <select name="social[{{$key}}][name]" id="place_socials">
                                                        <option value="">{{__('Select network')}}</option>
                                                        @foreach(SOCIAL_LIST as $k => $value)
                                                        <option value="{{$k}}" {{isSelected($k, $social['name'])}}>{{$value['name']}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field-group field-input">
                                                <label for="place_socials">{{__('Social URL')}}</label>
                                                <input type="text" name="social[{{$key}}][url]" value="{{$social['url']}}"
                                                    placeholder="{{__('Enter URL include http or www')}}">
                                            </div>
                                            <a href="#" class="social_item_remove first-remove-icon">
                                                <i class="la la-trash-alt"></i>
                                            </a>
                                        </div>

                                    </div>
                                    @endforeach
                                    @else
                                    <div class="field-inline field-3col social_item">
                                        <div class="field-group field-select">
                                            <div class="custom-dropdown">
                                                <select name="social[0][name]" id="place_socials">
                                                    <option value="">{{__('Select network')}}</option>
                                                    @foreach(SOCIAL_LIST as $value)
                                                    <option value="{{$value['name']}}">{{$value['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field-group field-input full-width-input">
                                            <input type="text" name="social[0][url]"
                                                placeholder="{{__('Enter URL include http or www')}}">
                                        </div>
                                        <a href="#" class="social_item_remove pt-2">
                                            <i class="la la-trash-alt"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>

                                <a href="#social" id="social_addmore" class="add-social btn">
                                    <i class="la la-plus la-24"></i>
                                    <span>{{__('Add more')}}</span>
                                </a>
                            </div>
                        </div><!-- .listing-box -->

                        <div class="listing-box" id="open">
                            <h3>{{__('Opening Hours')}}</h3>
                            <div class="group-field custom_group-field" id="time-opening">
                                @if(isset($place->opening_hour))
                                @foreach($place['opening_hour'] as $index => $opening_hour)
                                <div class="field-inline field-3col d-block  openinghour_item">
                                    <div class="flex-block d-grid">
                                    <div class="field-group field-input">
                                        <input type="text" class="form-control valid" name="opening_hour[{{$index}}][title]"
                                            value="{{$opening_hour['title']}}">
                                    </div>
                                    <div class="field-group field-input">
                                        <input type="text" class="form-control" name="opening_hour[{{$index}}][value]"
                                            value="{{$opening_hour['value']}}">
                                    </div>
                                    <a href="#" class="openinghour_item_remove">
                                        <i class="la la-trash-alt"></i>
                                    </a>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                @foreach(DAYS as $key => $value)
                                <div class="place-fields-wrap">
                                    <div class="place-fields place-time-opening row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 place-fields-li">
                                            <div class="form-group">
                                                <input type="text" class="form-control valid" name="opening_hour[{{$key}}][title]"
                                                    value="{{$value}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 place-fields-li">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="opening_hour[{{$key}}][value]"
                                                    placeholder="{{$value == " Ex: Sunday" ? "Closed" : "Ex: 9:00 AM - 5:00 PM" }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>

                            <a href="#open" class="add-social btn mt-2" id="openinghour_addmore">
                                <i class="la la-plus la-24"></i>
                                <span>{{__('Add more')}}</span>
                            </a>
                        </div><!-- .listing-box -->

                        <!-- 1 -->
                        <style>
                            .product-upload-preview .preview {
                                width: 100%;
                                height: 275px;
                            }
                        </style>
                        <div class="listing-box" id="product">
                            <h3>{{__('Products')}}</h3>
                            <div id="menu_list">
                                @if(isset($place->products))
                                @foreach($place->products as $key => $menu)
                                <div class="row form-group menu_item" id="menu_item_{{$key}}">
                                    <input type="hidden" name="menu[{{$key}}][menu_item_id]" id="product_id" value="{{$menu['id']}}" />

                                    <div class="col-xl-3 col-lg-4 col-md-4  list_box_li_first">
                                        <div class="field-group field-file product-upload-preview">
                                            <label for="product_thumb_image_{{$key}}" class="preview">
                                                <!-- <input type="file" data-sr-id="{{$key}}" id="product_thumb_image_{{$key}}" name="menu[{{$key}}][thumb]" class="upload-file product_thumb_image">   -->
                                                <input type="file" data-sr-id="{{$key}}" max-size="5242880"
                                                    id="product_thumb_image_{{$key}}" class="upload-file product_thumb_image">
                                                <input type="hidden" id="product_thumb_hidden_image_{{$key}}"
                                                    name="menu[{{$key}}][thumb]" value="{{$menu['thumb']}}">
                                                <img class="product_thumb_preview" id="product_thumb_preview_{{$key}}"
                                                    src="{{$menu['thumb']}}" alt="" />
                                                    <div class="upload-text text-center">
                                                        <i class="la la-cloud-upload-alt"></i>
                                                        <p>
                                                            Drag and drop here <br>
                                                                    or<br>
                                                            <b> Browse Files</b><br>
                                                            Maximum file size: 1 MB

                                                    </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-xl-9 col-lg-8 col-md-8 list_box_li_second">
                                        <div class="row">
                                            <div class="col-md-12 form-group-margin">
                                                <div class="form-group">
                                                    <label>Name</label>

                                                    <input type="text" class="form-control" name="menu[{{$key}}][name]"
                                                        value="{{$menu['name']}}" placeholder="Product name"
                                                        data-rule-required="true">
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group-margin">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    {{-- <input type="text" class="form-control" name="menu[{{$key}}][description]"
                                                        value="{{$menu['description']}}" placeholder="Product description"
                                                        data-rule-required="true"> --}}
                                                    <textarea class="form-control" id="product_description" name="menu[{{$key}}][description]"
                                                    placeholder="Product description"
                                                    data-rule-required="true">{{$menu['description']}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 hidecarprice addhiddenclass" style="display: {{ ($place->categories[0] && $place->categories[0]->name == 'travel' && $place->slug == 'sealink') ? 'block' : 'none'}}">
                                                <div class="form-group">
                                                    <label>
                                                        Vehicle Price
                                                    </label>
                                                    <input type="text" class="form-control car-price-placeholder"
                                                        name="menu[{{$key}}][car_price]" value="{{$menu['car_price']}}"
                                                        placeholder="" data-rule-min="1"
                                                        data-rule-number="true">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 hidecardisc addhiddenclass" style="display: {{ ($place->categories[0] && $place->categories[0]->name == 'travel' && $place->slug == 'sealink') ? 'block' : 'none'}}">
                                                <div class="form-group">
                                                    <label>Vehicle Discounted Amount</label>
                                                    <input type="text" class="form-control"
                                                        name="menu[{{$key}}][car_discount_price]"
                                                        value="{{$menu['car_discount_price']}}" placeholder="Discount $"
                                                        id="car_discount_price_{{$key}}" data-rule-number="true">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="form-group">
                                                    <label class="pricelabel">
                                                        {{-- Adult Price --}}
                                                        {{isset($place->categories[0])?$place->categories[0]->getPriceTextPlaceHolderForAdult().' Price':'Adult Price'}}
                                                    </label>
                                                    <input type="text" class="form-control adult-price-placeholder"
                                                        name="menu[{{$key}}][price]" value="{{$menu['price']}}"
                                                        placeholder="{{isset($place->categories[0])?$place->categories[0]->getPriceTextPlaceHolderForAdult():''}}"
                                                        data-rule-number="true" data-rule-min="1">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="form-group">
                                                    <label>Discounted Amount</label>
                                                    <input type="text" class="form-control"
                                                        name="menu[{{$key}}][discount_percentage]"
                                                        value="{{$menu['discount_percentage'] ?? '0.00'}}" placeholder="Discount $"
                                                        data-rule-number="true"
                                                        id="price_discounted_amount_{{$key}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 addhiddenclass">
                                                <div class="form-group">
                                                    <label>
                                                        Child Price
                                                    </label>
                                                    <input type="text" class="form-control child-price-placeholder"
                                                        name="menu[{{$key}}][child_price]" value="{{$menu['child_price']}}"
                                                        placeholder="{{isset($place->categories[0])?$place->categories[0]->getPriceTextPlaceHolderForChild():''}}"
                                                        data-rule-number="true"
                                                        data-rule-greaterThan="#child_discount_price_{{$key}}"
                                                        data-msg-greaterThan='Child price must be greater then child discount'>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 addhiddenclass">
                                                <div class="form-group">
                                                    <label>Child Discounted Amount</label>
                                                    <input type="text" class="form-control"
                                                        name="menu[{{$key}}][child_discount_price]"
                                                        value="{{$menu['child_discount_price'] ?? '0.00'}}" placeholder="Discount $"
                                                        id="child_discount_price_{{$key}}" data-rule-number="true">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                                <div class="form-group">
                                                    <label>Discount Start Date</label>
                                                    <input type="date" class="form-control"
                                                        name="menu[{{$key}}][discount_start_date]"
                                                        value="{{$menu['discount_start_date_formatted']}}" placeholder="Start Date">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                                <div class="form-group">
                                                    <label>Discount End Date</label>
                                                    <input type="date" class="form-control" name="menu[{{$key}}][discount_end_date]"
                                                        value="{{$menu['discount_end_date_formatted']}}" placeholder="End Date">
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-6 col-sm-6 form-group-margin">
                                                <div class="form-group">
                                                    <label>Product Code</label>
                                                    <input class="form-control" name="menu[{{$key}}][product_code]" id="menu[{{$key}}]"
                                                        value="{{$menu['product_code']}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 form-group-margin text-right list_box_li_third">
                                                <label>Rezdy Integration</label>
                                                <a  href="javascript:void(0)" class="btn add-social inteRezdy" data-id="{{$menu['id']}}" data-key="{{$key}}">
                                                    <i class="la la-plus la-24"></i>Update
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                                <div class="featured_input">
                                                    <div class="field-group field-check m-0">
                                                        <div class="custom-checkbox mb-0">
                                                        <input class="featured_checkbox" type="checkbox"
                                                        name="menu[{{$key}}][featured]" id="featured_{{$key}}" value="1" {{
                                                        ($menu['featured']==1 ? 'checked' : '' ) }}>
                                                            <label for="featured_{{$key}}" class="text-right mb-0 mt-2">
                                                            Feature
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                                <div class="featured_input">
                                                    <div class="field-group field-check m-0">
                                                        <div class="custom-checkbox mb-0">
                                                            <input type="checkbox" name="menu[{{$key}}][online_payment_required]"
                                                            id="online_payment_{{$key}}" value="1" {{
                                                            ($menu['online_payment_required']==1 ? 'checked' : '' ) }}>
                                                            <label for="online_payment_{{$key}}" class="text-right mb-0 mt-2 payment-label">
                                                                Online Payment Required
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                                <div class="">
                                                    <div class="field-group d-flex mb-0">
                                                        <label for="color_code_{{$key}}"
                                                            class="text-right mb-0 payment-label">
                                                            <input style="width: 40px; height:20px; border-bottom:none" type="color" name="menu[{{$key}}][color_code]"
                                                                id="color_code_{{$key}}" value="{{$menu['color_code']?? '#FFA800'}}"> {{__('Color Code')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 text-right list_box_li_third">
                                        <!-- <button type="button" class="btn btn-danger menu_item_remove" id="{{$key}}">X</button> -->
                                        <a href="javascript:void(0);" class="menu_item_remove mt-3" id="{{$key}}">
                                            <i class="la la-trash-alt"></i>Delete product
                                        </a>
                                    </div>
                                </div>
                                <div class="sepration"></div>
                                @endforeach
                                @else
                                <!-- <div class="row form-group menu_item" id="menu_item_0">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-3  list_box_li_first">
                                        <div class="field-group field-file product-upload-preview">
                                            <label for="product_thumb_image_0" class="preview">
                                                <input type="file" data-sr-id="0" id="product_thumb_image_0"
                                                    class="upload-file product_thumb_image">
                                                <input type="hidden" id="product_thumb_hidden_image_0" name="menu[0][thumb]"
                                                    value="">
                                                <img class="product_thumb_preview" id="product_thumb_preview_0"
                                                    src="https://via.placeholder.com/300x300?text=VentureNZ" alt="" />
                                                <i class="la la-cloud-upload-alt"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-md-8 col-sm-8 col-8 list_box_li_second">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="menu[0][name]"
                                                        placeholder="Product name" data-rule-required="true">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" name="menu[0][description]"
                                                        placeholder="Product description" data-rule-required="true" data-rule-required="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-1  list_box_li_third">
                                        <a href="javascript:void(0);" class="menu_item_remove pt-2" id="0">
                                            <i class="la la-trash-alt"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row date-content">
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="form-group">
                                                    <label>Adult Price</label>
                                                    <input type="text" class="form-control" name="menu[0][price]"
                                                        placeholder="Product price" data-rule-required="true"
                                                        data-rule-number="true"
                                                        data-rule-greaterThan="#discounted_amount_0"
                                                        data-msg-greaterThan='Price must be greater then discount'
                                                        >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="form-group">
                                                    <label>Discounted Amount</label>
                                                    <input type="text" class="form-control" id="discounted_amount_0"
                                                        name="menu[0][discount_percentage]" value="" placeholder="Discount $"
                                                        data-rule-required="true" data-rule-number="true">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="form-group">
                                                    <label>Child Price</label>
                                                    <input type="text" class="form-control" name="menu[0][child_price]"
                                                        placeholder="Product price"
                                                        data-rule-number="true"
                                                        data-rule-greaterThan="#child_discount_price_0"
                                                        data-msg-greaterThan='Child price must be greater then child discount'
                                                        >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="form-group">
                                                    <label>Child Discounted Amount</label>
                                                    <input type="text" class="form-control" name="menu[0][child_discount_price]"
                                                        value="" placeholder="Discount $" id="child_discount_price_0"
                                                        data-rule-required="true" data-rule-number="true">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                                <div class="form-group">
                                                    <label>Discount Start Date</label>
                                                    <input type="date" class="form-control" name="menu[0][discount_start_date]"
                                                        value="" placeholder="Start Date">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6 date_input">
                                                <div class="form-group">
                                                    <label>Discount End Date</label>
                                                    <input type="date" class="form-control" name="menu[0][discount_end_date]"
                                                        value="" placeholder="End Date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row date-content">
                                            <div class="col-lg-3 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="featured_input">
                                                    <div class="field-group field-check mb-0">
                                                        <label for="featured_0" class="text-right mb-0 mt-2">
                                                            <input class="featured_checkbox" type="checkbox"
                                                                name="menu[0][featured]" id="featured_0" value="1">Feature
                                                            <span class="checkmark">
                                                                <i class="la la-check"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 form-group-margin col-6">
                                                <div class="featured_input">
                                                    <div class="field-group field-check mb-0">
                                                        <label for="online_payment_0" class="text-right mb-0 mt-2 payment-label">
                                                            <input type="checkbox" name="menu[0][online_payment_required]"
                                                                id="online_payment_0" value="1">Online Payment Required
                                                            <span class="checkmark">
                                                                <i class="la la-check"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                @endif
                                <!--  -->
                            </div>

                            <button type="button" class="btn add-social" id="menu_addmore"><i class="la la-plus la-24"></i> Add
                                more</button>
                            <span class="error-msg-max-pro" id="error-msg-max-pro"></span>
                        </div>
                        <!-- 1 -->

                        <div class="listing-box" id="media">
                            <h3>Media</h3>
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="field-group field-file">
                                        <div class="thumbnail-image-con mb-4">
                                            <label for="thumb_image">{{__('Upload Thumb Image')}} *</label>
                                            <label for="thumb_image" class="preview w-100">
                                                @if(isset($place) && isset($place['thumb']))
                                                <input type="file" id="thumb_image" name="thumb" class="upload-file">
                                                @else
                                                <input type="file" id="thumb_image" name="thumb" class="upload-file" required>
                                                @endif
                                                <img id="thumb_preview" src="{{isset($place['thumb']) ? getImageUrl($place['thumb']) : ''}}"
                                                    alt="" />
                                                    <div class="upload-text text-center">
                                                        <i class="la la-cloud-upload-alt"></i>
                                                        <p>
                                                            Drag and drop here <br>
                                                                    or<br>
                                                            <b> Browse Files</b><br>
                                                            Maximum file size: 1 MB

                                                    </div>
                                            </label>
                                        </div>
                                        <div class="thumbnail-image-con">
                                            <label for="logo_image">{{__('Upload Logo Image')}} *</label>
                                            <label for="logo_image" class="preview w-100">
                                                @if(isset($place) && isset($place['logo']))
                                                <input type="file" id="logo_image" name="logo" class="upload-file">
                                                @else
                                                <input  type="file" id="logo_image" name="logo" class="upload-file" required>
                                                @endif
                                                <img id="logo_preview" src="{{isset($place['logo']) ? getImageUrl($place['logo']) : ''}}"
                                                    alt="" />
                                                <div class="upload-text text-center">
                                                        <i class="la la-cloud-upload-alt"></i>
                                                        <p id="logo_addText">
                                                            Drag and drop here <br>
                                                                    or<br>
                                                            <b> Browse Files</b><br>
                                                            Maximum file size: 1 MB
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <div class="field-group field-file">
                                        <label for="gallery_img">{{__('Upload Gallery Images')}}</label>

                                        <label for="gallery" class="preview w-100">
                                            <input type="file" id="gallery" class="upload-file">
                                            <div class="upload-text text-center">
                                                <i class="la la-cloud-upload-alt"></i>
                                                <p>
                                                    Drag and drop here <br>
                                                            or<br>
                                                    <b> Browse Files</b><br>
                                                    Maximum file size: 1 MB
                                            </div>
                                        </label>

                                        <div id="gallery_preview" class="mt-4 gallery_grid">
                                            @if(isset($place) && isset($place['gallery']))
                                            @foreach($place['gallery'] as $gallery)
                                            <div class="media-thumb-wrap">
                                                <figure class="media-thumb">
                                                    <img src="{{getImageUrl($gallery)}}">
                                                    <div class="media-item-actions">
                                                        <a class="icon icon-delete" href="javascript:void(0)">
                                                            <i class="la la-times"></i>
                                                        </a>
                                                        <input type="hidden" name="gallery[]" value="{{$gallery}}">
                                                        <span class="icon icon-loader"><i class="fa fa-spinner fa-spin"></i></span>
                                                    </div>
                                                </figure>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <label for="place_video">{{__('Video Url')}}</label>
                                        <input type="text" id="place_video" name="video" value="{{$place['video'] ?? ''}}"
                                            placeholder="{{__('Youtube, Vimeo video url')}}">
                                    </div>
                                </div>
                            </div>
                        </div><!-- .listing-box -->

                        @if(isset($place))
                        <div class="listing-box" id="qrcode">
                            <h3>QR Code</h3>
                            <div class="field-group">
                                @if(isset($place) && !empty($place['reward_link']))
                                <div class="qr-div">
                                <img src="{{$place && $place['reward_link'] ? getQRCodeImageUrl($place['reward_link']) : ''}}" alt="Qr Code Image" />
                                 <span style="float: right"><a download
                                            href="{{getQRCodeImageUrl($place['reward_link'])}}" class="btn add-social"><i class="la la-download"></i> Download QR Code</a> <a
                                            data-toggle="modal" data-target="#print_qr_code" href="javascript:void(0)" class="btn add-social"><i class="la la-print"></i>Print QR
                                            Code</a></span>

                                </div>
                                <!-- <a href="{{url('/reward/'.$place['reward_link'] )}}">Reward</a> -->
                                <!-- <div class="field-note">{{__('Download')}}.</div> -->
                                @else
                                <a href="javascript:location.reload(true)">Reload to Generate QR Code</a>
                                @endif
                            </div>
                        </div><!-- .listing-box -->
                        @endif

                        <div class="field-group field-submit">
                            <input type="hidden" name="place_id" value="{{$place['id'] ?? ''}}">
                            @guest
                            <a href="#" class="btn btn-login open-login">{{__('Login to submit')}}</a>
                            @else
                            @if(isRoute('place_edit'))
                            <input class="btn" type="submit" value="{{__('Update')}}">
                            @else
                            <input class="btn" type="submit" value="{{__('Submit')}}">
                            @endif
                            @endguest
                        </div>
                    </form>
                </div><!-- .listing-content -->
            </div>
        </div>
    </div>
</main><!-- .site-main -->
@if($place)
<div class="modal fade" id="print_qr_code" tabindex="-1" role="dialog" aria-labelledby="print_qr_code"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel">Print QR Code</h2>
                <button type="button" class="close close-btn-event-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body member-wrap mb-0" id="printThis">
                <div class="qr-logo" style="text-align: center;padding: 20px;">
                    <img style="width: 44%;margin-bottom: 20px;"
                        src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                        alt="logo"><br>
                    <img style="width: 38%;margin: 5px;"
                        src="{{isset($place['reward_link']) ? getQRCodeImageUrl($place['reward_link']) : ''}}" alt="" />
                    <p style="margin: 10px;font-size: 16px;">{{isset($place->name) ? $place->name : ''}}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-btn-event-modal" data-dismiss="modal">Close</button>
                <button type="button" class="btn" onclick="printModal()">Print</button>
            </div>
        </div>
    </div>
</div>
@endif
@stop
@push('style')
<link rel="stylesheet" href="{{asset('assets/select2/css/select2.min.css')}}">
<style>
    .listing-box .form-group.row .form-group {
        display: block;
        margin-bottom: 7px;
    }

    .listing-box .form-group.row .form-group label {
        margin: 0;
        display: block;
        text-transform: capitalize;
    }

    .listing-box .date-content {
        margin-top: 0;
    }

    .listing-box .date-content .form-group-margin {
        margin-bottom: 7px;
    }

    .featured_input .field-check label {
        margin-top: 0 !important;
    }

    .error {
        color: red !important;
    }
</style>
@endpush
@push('scripts')
<script>
    var PRICING_TEXT=@json($PRICING_TEXT);
    var gv_is_limited_products = '{{setting(App\Models\Place::DB_SETTING_KEY_IS_PLACE_PRODUCTS_LIMITED_FOR_OPERATOR)}}';
    var gv_max_product_allowed = '{{setting(App\Models\Place::DB_SETTING_KEY_PLACE_PRODUCTS_LIMIT_FOR_OPERATOR)}}';
    var gv_not_limited = '{{App\Models\Place::NOT_LIMITED}}';
    var gv_limited= '{{App\Models\Place::LIMITED}}';
    var gv_is_limited_featured_products = '{{setting(App\Models\Place::DB_SETTING_KEY_IS_PLACE_FEATURED_PRODUCTS_LIMITED_FOR_OPERATOR)}}';
    var gv_max_featured_product_allowed = '{{setting(App\Models\Place::DB_SETTING_KEY_PLACE_FEATURED_PRODUCTS_LIMIT_FOR_OPERATOR)}}';
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
<script src="{{asset('assets/select2/js/select2.full.min.js')}}"></script>
@if(setting('map_service', 'google_map') === 'google_map')
<script src="{{asset('assets/js/page_place_new.js')}}"></script>
@else
<script src="{{asset('assets/js/page_place_new_mapbox.js')}}"></script>
@endif

<script>
    $.validator.addMethod("greaterThan",
    function (value, element, param) {
          var $otherElement = $(param);
          var curVal = parseInt(value, 10);
          var otherVal = parseInt($otherElement.val(), 10);

          if (otherVal == 0) {
            return true;
          }

          return this.optional(element) || (curVal > otherVal);
        });

        // $.validator.addMethod("checkCode", function(value, element, param) {

        // }, 'This field is required');
    // $.validator.addMethod('filesize', function (value, element, param) { //add  for 1mb validation
    //     return this.optional(element) || (element.files[0].size <= param * 1000000)
    //     }, 'File size must be less than {0} MB');
    //         $("#new_place").validate({
    // });
    $("#new_place").validate({
    });
    //Initialize Select2 Elements
        $('.select2').select2()

        function printModal() {
            let ele = document.getElementById("printThis");
            var mywindow = window.open('','_blank');
            mywindow.document.write(ele.innerHTML);

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.onafterprint = mywindow.close;

            window.onfocus = function(){
                $('#print_qr_code').modal('hide');
            }

        }//printModal()

        // $(document).on('keyup','.car-price-placeholder',function(){
        //     var value = $(this).val();
        //     if(value == '' && value == 0){
        //         $('.adult-price-placeholder').attr('data-rule-required','true');
        //     }else{
        //         $('.adult-price-placeholder').removeAttr('data-rule-required');
        //         $('label.error').remove();
        //     }
        // });

    $(document).on("change", "#booking_type", function (event) {
            let selectedValue = this.value;
            if(selectedValue=={{App\Models\Booking::TYPE_AFFILIATE}}){
                $('#place_booking_link').show();
                $('#place_booking_link_lbl').show();
                $('#place_booking_link_warning').hide();
            }
            else{
                $('#place_booking_link').hide();
                $('#place_booking_link_lbl').hide();
                $('#place_booking_link_warning').show();
            }
        });
        $('#booking_type').trigger('change');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $(document).on("change", "#lis_category", function (event) {

        //     let selectedValues = $('#lis_category').val();
        //     if(selectedValues){

        //         let selectedValuesText = selectedValues.join();

        //         $.ajax({
        //             url: "{{ route('get_sub_category') }}",
        //             type: "POST",
        //             data: { category_ids : selectedValues },
        //             dataType: 'json',
        //             success: function(result)
        //             {
        //                 if (result.status == true) {

        //                     let data = result.data;

        //                     let options = "";
        //                     $('#lis_subcategory').empty();
        //                     data.forEach(element => {
        //                         options +=  '<option value="'+element.id+'">'+element.name+'</option>';
        //                     });

        //                     $('#lis_subcategory').append(options);
        //                     $('#lis_subcategory').trigger("chosen:updated");
        //                 }//if
        //             },
        //             error: function () {
        //             }
        //         });

        //         $.ajax({
        //             url: "{{ route('get_place_types') }}",
        //             type: "POST",
        //             data: { category_ids : selectedValues },
        //             dataType: 'json',
        //             success: function(result)
        //             {
        //                 if (result.status == true) {

        //                     let data = result.data;

        //                     console.log("data---",data);

        //                     let options = "";

        //                     let oldPlaceTypeSelected = $('#lis_place_type').val();
        //                     console.log("oldPlaceTypeSelected--",oldPlaceTypeSelected);

        //                     $('#lis_place_type').empty();
        //                     data.forEach(element => {

        //                         options +=  '<optgroup label="'+element.name+'">';

        //                         element.place_type.forEach(element => {
        //                             if(oldPlaceTypeSelected.includes(element.id)){
        //                                 options +=  '<option value="'+element.id+'" selected>'+element.name+'</option>';
        //                             }else{
        //                                 options +=  '<option value="'+element.id+'">'+element.name+'</option>';
        //                             }

        //                         });

        //                         options +=  '</optgroup>';

        //                     });

        //                     $('#lis_place_type').append(options);
        //                     $('#lis_place_type').trigger("chosen:updated");
        //                 }//if
        //             },
        //             error: function () {
        //             }
        //         });

        //     }


        // });
       function rezdyUpdate(code, id) {
            $.ajax({
                url: '{{ route('integration_rezdy') }}',
                type: 'POST',
                data: {
                    value: code,
                    id: id
                },
                success: function(response) {
                    if (response.success === true) {
                        Tost(response.message, 'success');
                    }
                    else {
                        Tost(response.message, 'error');
                    }
                }
            });
        }

        $( document ).ready(function() {
            $('.inteRezdy').click(function() {
                // Get the product code input value
                var productId = $(this).data('id');
                var key = $(this).data('key');
                var productCode = $("#menu\\[" + key + "\\]").val();
                rezdyUpdate(productCode, productId);
            });

            let selectedValuesCount = $('#lis_category').val();
            if(selectedValuesCount != null){
                getSubcategory();
                getKeyword();
            }
            $('#lis_category').on('change',function(){
                getSubcategory();
                getKeyword();
            });

            function getSubcategory() {
                let oldPlaceTypeSelected = '';
                if($('#lis_place_type').val()){
                    oldPlaceTypeSelected = '['+ $('#lis_place_type').val()+ ']  ';
                }
                // let selectedValues = $('#lis_category').val();
               let selectedValues=$("#lis_category").select2().find(":selected").val();
               //var categorylabel = $("#lis_category").select2().find(":selected").data('label');
                if(selectedValues){
                    $.ajax({
                        url: "{{ route('get_sub_category') }}",
                        type: "POST",
                        data: { category_ids : selectedValues },
                        dataType: 'json',
                        success: function(result)
                        {
                            if (result.status == true) {
                                let data = result.data;
                                let options = "";
                                $('#lis_place_type').empty();
                                // console.log("oldPlaceTypeSelected--",oldPlaceTypeSelected);
                                // $.each(data, function(index,value){
                                    // options +=  '<optgroup label="'+value['name']+'">';
                                    // if(value['place_type'] !== ''){
                                    //     value['place_type'].forEach(element => {

                                    //         if(oldPlaceTypeSelected.indexOf(element.id) !== -1){
                                    //             options +=  '<option value="'+element.id+'" selected>'+element.name+'</option>';
                                    //         }else{
                                    //             options +=  '<option value="'+element.id+'">'+element.name+'</option>';
                                    //         }
                                    //     });
                                    // }
                                    // options +=  '</optgroup>';
                                // });
                                     data.map(function(data){
                                                if(oldPlaceTypeSelected.indexOf(data.id) !== -1){
                                                options +=  '<option value="'+data.id+'" selected>'+data.name+'</option>';
                                            }else{
                                                options +=  '<option value="'+data.id+'">'+data.name+'</option>';
                                            }
                                     })


                                //

                                const label = $("#lis_category").select2().find(":selected").data("label");
                                $('#category_name').val(label);
                                var placename = $('#place_name').val();
                                if(label == 'travel' && placename == 'Sealink'){
                                    $('.hidecarprice').attr("style", "display: block !important");
                                    $('.hidecardisc').attr("style", "display: block !important");
                                }else{
                                    $('.hidecarprice').attr("style", "display: none !important");
                                    $('.hidecardisc').attr("style", "display: none !important");
                                }
                                const placeHolderForAdult = PRICING_TEXT[label]['adult'];
                                const placeHolderForChild = PRICING_TEXT[label]['child'];

                                var pricelabel = '';
                                var childhide = '';
                                if(label == 'stay'){
                                    pricelabel = 'Price Per Night';
                                    childhide = 'd-none';
                                    $('.addhiddenclass').removeClass('d-block');
                                }else if(label == 'rent'){
                                    pricelabel = 'Price Per Day';
                                    childhide = 'd-none';
                                    $('.addhiddenclass').removeClass('d-block');
                                }else{
                                    pricelabel = 'Adult Price';
                                    childhide = 'd-block';
                                }

                                $('.addhiddenclass').addClass(childhide);
                                $('.pricelabel').text(pricelabel);
                                $('.child-price-placeholder').attr('placeholder',placeHolderForChild);
                                $('.adult-price-placeholder').attr('placeholder',placeHolderForAdult);
                                $('#lis_place_type').append(options);
                                $('#lis_place_type').trigger("chosen:updated");
                            }
                        },
                        error: function () {
                        }
                    });
                    if(selectedValues == "11"){
                        $( "#logo_image" ).prop( "disabled", true );
                        $('#logo_preview').hide();
                        $('#logo_addText').html('You cannot add logo!');
                    } else{
                        $( "#logo_image" ).prop( "disabled", false );
                        $('#logo_preview').show();
                        $('#logo_addText').html('Drag and drop here <br>or<br><b> Browse Files</b><br>Maximum file size: 1 MB');
                    }
                }else{
                    $('#lis_place_type').html('');
                    $('#lis_place_type').val('');
                    $('#lis_place_type').empty();
                    $('#lis_place_type').append('');
                    $('#lis_place_type').trigger("chosen:updated");
                }
            }

            function getKeyword() {
                let oldKeywordSelected = '';
                if($('#lis_interest').val()){
                    oldKeywordSelected = '['+ $('#lis_interest').val()+ ']  ';
                }
                // let selectedValues = $('#lis_category').val();
               let selectedValues=$("#lis_category").select2().find(":selected").val();
               //var categorylabel = $("#lis_category").select2().find(":selected").data('label');

                if(selectedValues){
                    $.ajax({
                        url: "{{ route('get_keyword') }}",
                        type: "POST",
                        data: { category_ids : selectedValues },
                        dataType: 'json',
                        success: function(result)
                        {
                            if (result.status == true) {
                                let data = result.data;
                                let options = "";
                                $('#lis_interest').empty();
                                     data.map(function(data){
                                                if(oldKeywordSelected.indexOf(data.id) !== -1){
                                                options +=  '<option value="'+data.id+'" selected>'+data.keyword+'</option>';
                                            }else{
                                                options +=  '<option value="'+data.id+'">'+data.keyword+'</option>';
                                            }
                                     })
                                $('#lis_interest').append(options);

                                $('#lis_interest').trigger("chosen:updated");
                            }
                        },
                        error: function () {
                        }
                    });
                }else{
                    $('#lis_interest').html('');
                    $('#lis_interest').val('');
                    $('#lis_interest').empty();
                    $('#lis_interest').append('');
                    $('#lis_interest').trigger("chosen:updated");
                }
            }
        });

        $("#lis_interest").select2({
             maximumSelectionLength: 4
        });

</script>
@endpush
