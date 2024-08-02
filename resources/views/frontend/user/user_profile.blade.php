@extends('frontend.layouts.template')
@section('main')
<style>
.ui-pnotify.ui-pnotify-fade-normal.ui-pnotify.ui-pnotify-move{
    top: 55px !important;
    z-index: 100;
}

.ui-pnotify.company_pointer .ui-pnotify-text {
    padding: 3px 0 1px;
    line-height: 24px;
}

.ui-pnotify.company_pointer:before {
    display: block;
    content: ' ';
    height: 20px;
    width: 20px;
    background-color: #72BF44;
    border-left: 11px solid #fff;
    border-bottom: 11px solid #72bf44;
    border-right: 11px solid #fff;
    margin-left: 160px;
}

.my_company_menu.flash a {
    animation: color-change 2s infinite;
}

@keyframes color-change {
    0% { color: red; }
    20% { color: rgb(43, 0, 255); }
    40% { color: rgb(255, 94, 0); }
    60% { color: rgb(30, 0, 255); }
    80% { color: rgb(255, 149, 0); }
    100% { color: red; }
}
</style>
    <script src="https://js.stripe.com/v3/"></script>
    <main id="main" class="site-main">
        @if (isOperatorUser() && isUserHaveMembership() && Auth::user()->isUserProfileComplete())
            <div class="ui-pnotify company_pointer ui-pnotify-fade-normal ui-pnotify-in ui-pnotify-fade-in ui-pnotify-move"
                aria-live="assertive" aria-role="alertdialog"
                style="display: none; width: 300px; right: 36px; top: 55px; cursor: auto;">
                <div class="alert ui-pnotify-container alert-success ui-pnotify-shadow" role="alert" style="min-height: 16px;">
                    <div class="ui-pnotify-text text-center" aria-role="alert">Please add the company info in the "Company Info" menu first!</div>
                </div>
            </div>
        @endif

        <div class="site-content">

            <div class="user_booking_banner">
            </div>
            <div class="user_booking_main_div" style="position:relative;">
                <div class="container booking_intro_box row">
                    <div class="col-7 col-lg-9 row booing__box_mark_name" style="margin:0;">
                        <div class="col-lg-4 country_box_title">
                            <div>
                                <div class = "country_box_name">
                                    Profile
                                </div>
                                <div class = "country_box_nz">New Zealand</div>
                            </div>
                        </div>
                        <div class="col-lg-8 country_box_desc" >
                            <div class="booking_box_avatar">
                                <img src="{{ getUserAvatar(user()->avatar) }}"
                                        alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="booking_box_description">
                                <div class="booking_box_username">{{$user_info->name}}</div>
                                <div class="booking_box_useremail">{{$user_info->email}}</div>
                                <div class="booking_box_userphone">{{$user_info->phone_number}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-lg-3 booking_box_reward">
                        @if (!isOperatorUser())
                            @php
                                $balance = cleanDecimalZeros(App\Models\RewardPointTransaction::getBalance());
                            @endphp
                            <div class="rewards_section">
                                <h1>{{ __('Reward Points') }}</h1>
                                <div class="reward_points_sections">
                                    <p>{{ __('Point balance') }}</p>
                                    <h2>{{ $balance }}</h2>
                                </div>
                                <br>
                                <div class="reward_points_sections" style="margin-top: 15px;">
                                    @if (isUserHaveMembership())
                                        <a href="{{ route('reward_history') }}" class="link">{{ __('View all rewards') }}</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if (isOperatorUser() && !isUserAdmin())
                            <div class="operator-thumb">
                                @if($operator_place)
                                <img src="{{getImageUrl($operator_place->thumb)}}" alt="{{$operator_place->name}}">
                                @else
                                <img src="{{getImageUrl(Null)}}" alt="No thumb">
                                @endif
                            </div>
                            <div class="operator-category">
                                @if($operator_place)
                                <img src="{{getCategoryIcon($operator_place['categories'][0]['icon_map_marker'])}}"
                                            alt="{{$operator_place['categories'][0]['name']}}">
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="container profile_tab_div">
                    <div class="userinfo_tab">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                @if (isOperatorUser())
                                @php
                                    $book_url =  route('booking_list') . "?tab=calendar";
                                @endphp
                                @if(!isUserAdmin())
                                <a class="nav-item nav-link" id="nav-calendar-tab"  href="{{ $book_url }}" aria-controls="nav-calendar" aria-selected="true">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Calendar.svg') }}"></span>
                                        <span class="nav_title">Calendar</span>
                                    </div>
                                </a>
                                <a class="nav-item nav-link" id="nav-booking-tab"  href="{{ route('booking_list') }}" aria-controls="nav-booking" aria-selected="true">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Scheduled.svg') }}"></span>
                                        <span><img class="active_icon" src="{{ asset('assets/images/booking/Scheduled-white.svg') }}"></span>
                                        <span class="nav_title">Bookings</span>
                                    </div>
                                </a>
                                <a class="nav-item nav-link {{ Request::get('tab') ? 'active' : '' }}" id="nav-prize-tab" id="nav-prize-tab" data-toggle="tab" href="#nav-prize" role="tab" aria-controls="nav-prize" aria-selected="true">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Prizes.svg') }}"></span>
                                        <span><img class="active_icon" src="{{ asset('assets/images/booking/Prizes-white.svg') }}"></span>
                                        <span class="nav_title">Prizes</span>
                                    </div>
                                </a>
                                @endif
                                <a class="nav-item nav-link {{ Request::get('tab') ? '' : 'active' }}" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/User.svg') }}"></span>
                                        <span><img class="active_icon" src="{{ asset('assets/images/booking/User-white.svg') }}"></span>
                                        <span class="nav_title">Profile</span>
                                    </div>
                                </a>
                                @endif
                                @if(isUserUser())
                                <a class="nav-item nav-link {{ Request::is('user/profile') ? 'active' : '' }}" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/User.svg') }}"></span>
                                        <span><img class="active_icon" src="{{ asset('assets/images/booking/User-white.svg') }}"></span>
                                        <span class="nav_title">Profile</span>
                                    </div>
                                </a>
                                @endif
                                @if (isOperatorUser())
                                <a class="nav-item nav-link" id="nav-company-tab" href="{{ route('user_my_place') }}" aria-controls="nav-company" aria-selected="true">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Card.svg') }}"></span>
                                        <span class="nav_title">Company Info</span>
                                    </div>
                                </a>
                                @endif
                                @if(isUserUser())
                                <a class="nav-item nav-link" id="nav-interest-tab" data-toggle="tab" href="#nav-interest" role="tab" aria-controls="nav-interest" aria-selected="false">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Interest.svg') }}"></span>
                                        <span><img class="active_icon" src="{{ asset('assets/images/booking/Interest-white.svg') }}"></span>
                                        <span class="nav_title">Interests</span>
                                    </div>
                                </a>

                                <a class="nav-item nav-link {{ Request::is('user/place-favourites') ? 'active' : '' }}" id="nav-favourite-tab" data-toggle="tab" href="#nav-favourite" role="tab" aria-controls="nav-favourite" aria-selected="false">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Reservations.svg') }}"></span>
                                        <span><img class="active_icon" src="{{ asset('assets/images/booking/Reservations-white.svg') }}"></span>
                                        <span class="nav_title">Favourites</span>
                                    </div>
                                </a>
                                <a class="nav-item nav-link {{ Request::is('user/product-wishlist') ? 'active' : '' }}" id="nav-wishlist-tab" data-toggle="tab" href="#nav-wishlist" role="tab" aria-controls="nav-wishlist" aria-selected="false">
                                    <div style="display: flex; gap:10px;">
                                        <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Favouriet.svg') }}"></span>
                                        <span><img class="active_icon" src="{{ asset('assets/images/booking/Favouriet-white.svg') }}"></span>
                                        <span class="nav_title">Wishlist</span>
                                    </div>
                                </a>
                                @endif
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            @if(isOperatorUser() && !isUserAdmin())
                            <div class="tab-pane fade {{ Request::get('tab') ? 'show active' : '' }}" id="nav-prize" role="tabpanel" aria-labelledby="nav-prize-tab">
                                <div class="member-wrap">
                                    <h1 class="h1-headings">{{ __('Prizes') }}</h1>
                                </div>

                                <form id="update_prizes_frm" action="{{ route('prize_update') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if(Session::has('success'))
                                    <div id="prize-update-info">{{Session::get('success')}}</div>
                                    @endif
                                    <div class="form-group-content from-date">
                                        <label>{{ __('Date From')}} </label>
                                        <div class="custom-date-input">
                                            <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                            <input autocomplete="off" type="text" id="prize-from-date" name="date_from" class="datepicker_auto_select input-date" placeholder="{{ __('Date From') }}"required />
                                        </div>
                                    </div>
                                    <div class="form-group-content to-date">
                                        <label>{{ __('Date To')}} </label>
                                        <div class="custom-date-input">
                                            <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                            <input autocomplete="off" type="text" id="prize-to-date" name="date_to" class="datepicker_auto_select input-date" placeholder="{{ __('Date To') }}" required/>
                                        </div>
                                    </div>
                                    <div class="custom-select-drp">
                                        <label>{{ __('Product')}} </label>
                                        <select class="form-control" name="product_id" id="product_id" required>
                                            <option value="">{{ __('Select Product') }}</option>
                                            @if (!empty($products))
                                                @foreach ($products->products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="max-scan-div">
                                        <label>{{ __('Number of Scans')}} </label>
                                        <div>
                                            <input type="number" min="0" max="999" name="scan_no" id="scan_no_check" class="input"
                                                placeholder="{{ __('No. of Scans') }}" required/>
                                        </div>
                                    </div>
                                    <p>
                                        To increase direct bookings for your business, we have implemented a new strategy of offering prizes.
                                        By participating in our giveaway program, your business will be identified with a prominent icon on your profile page,
                                        letting potential customers know that you offer free giveaways.
                                        You have the flexibility to choose the number of scans required on your QR code before a user can receive a free ticket.
                                        This incentive-based approach is a proven method for building a loyal customer base and boosting sales.
                                    </p>
                                    <div class="text-center prize-update-btn">
                                        <button class="btn" type="submit" id="update_prizes">{{__('Update')}}</button>
                                    </div>

                                </form>
                            </div>
                            @endif
                            <div class="tab-pane fade {{ Request::is('user/profile') && !Request::get('tab') ? 'show active' : '' }}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="member-wrap">
                                    @include('frontend.common.box-alert')
                                    @if(user()->name == '' || user()->email == '' || user()->phone_number == '' || user()->stripe_account_id == '')
                                    <div class="alert alert-warning">
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <path fill="#f2d23d" fill-rule="nonzero" d="M11.732 9.96l1.762-1.762a.622.622 0 0 0 0-.88l-.881-.882a.623.623 0 0 0-.881 0L9.97 8.198l-1.761-1.76a.624.624 0 0 0-.883-.002l-.88.881a.622.622 0 0 0 0 .882l1.762 1.76-1.758 1.759a.622.622 0 0 0 0 .88l.88.882a.623.623 0 0 0 .882 0l1.757-1.758 1.77 1.771a.623.623 0 0 0 .883 0l.88-.88a.624.624 0 0 0 0-.882l-1.77-1.771zM9.967 0C4.462 0 0 4.462 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 8.098-8.098 8.098 8.098 0 0 1-8.098 8.098z"></path>
                                            </svg>
                                            Please complete all the information in your profile before pressing update.
                                        </p>
                                    </div>
                                    @endif

                                    <div class="row">
                                        <div class="input-grid col-lg-6 col-md-8 position-relative">
                                            <form class="member-profile form-underline form_first"
                                                action="{{ route('user_profile_update') }}" method="post"
                                                enctype="multipart/form-data"
                                                >
                                                @method('put')
                                                @csrf
                                                <h3>{{ __('Avatar') }}</h3>
                                                <div class="member-avatar">
                                                    <img id="member_avatar" src="{{ getUserAvatar(user()->avatar) }}"
                                                        alt="Member Avatar">
                                                    <label for="upload_new">
                                                        <input id="upload_new" type="file" name="avatar"
                                                            value="{{ __('Upload new') }}" accept="image/*">
                                                        {{ __('Upload new') }} <i class="las la-edit"></i>
                                                    </label>
                                                    @if ($errors->has('avatar'))
                                                        <small class="form-text text-danger golo-d-none"
                                                            style="display: inline;">{{ $errors->first('avatar') }}</small>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <h3>{{ __('Basic Information') }}</h3>
                                                    <div class="field-input">
                                                        <label for="name">{{ __('Full name') }} <i class="las la-edit" id="update-name" style="cursor: pointer"></i></label>
                                                        <input type="text" id="name" name="name" value="{{ user()->name }}"
                                                            placeholder="{{ __('Enter your name') }}">
                                                        @if ($errors->has('name'))

                                                            <small class="form-text text-danger golo-d-none"
                                                                style="display: inline;">{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="field-input">
                                                        <label for="email">{{ __('Email') }} <i class="las la-edit" id="update-email" style="cursor: pointer"></i></label>
                                                        <input type="email" id="email" name="email" value="{{ user()->email }}">
                                                        @if ($errors->has('email'))
                                                            <small class="form-text text-danger golo-d-none"
                                                                style="display: inline;">{{ $errors->first('email') }}</small>
                                                        @endif
                                                    </div>

                                                    <div class="field-input">
                                                        <label for="phone">{{ __('Phone') }} <i class="las la-edit" id="update-phone" style="cursor: pointer"></i></label>
                                                        <input type="text" id="phone" name="phone_number"
                                                            value="{{ user()->phone_number }}"
                                                            placeholder="{{ __('Enter phone number') }}">
                                                        @if ($errors->has('phone_number'))
                                                            <small class="form-text text-danger golo-d-none"
                                                                style="display: inline;">{{ $errors->first('phone_number') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="field-input">
                                                        <label for="address">{{ __('Address') }} </label>
                                                        <div class="address_input">
                                                            <input type="text" id="street" name="street"
                                                                value="{{ user()->street }}"
                                                                placeholder="{{ __('Enter Street') }}">
                                                            {{-- <i class="las la-edit" id="update-street" style="cursor: pointer"></i> --}}
                                                            @if ($errors->has('street'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('street') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="address_input">
                                                            <input type="text" id="suburb" name="suburb"
                                                                value="{{ user()->suburb }}"
                                                                placeholder="{{ __('Enter Suburb') }}">
                                                                {{-- <i class="las la-edit" id="update-suburb" style="cursor: pointer"></i> --}}
                                                            @if ($errors->has('suburb'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('suburb') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="address_input">
                                                            <input type="text" id="city" name="city"
                                                                value="{{ user()->city }}"
                                                                placeholder="{{ __('Enter City') }}">
                                                                {{-- <i class="las la-edit" id="update-city" style="cursor: pointer"></i> --}}
                                                            @if ($errors->has('city'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('city') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="address_input">
                                                            <input type="text" id="state" name="state"
                                                                value="{{ user()->state }}"
                                                                placeholder="{{ __('Enter State') }}">
                                                                {{-- <i class="las la-edit" id="update-state" style="cursor: pointer"></i> --}}
                                                            @if ($errors->has('state'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('state') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="address_input">
                                                            <input type="text" id="country" name="country"
                                                                value="{{ user()->country }}"
                                                                placeholder="{{ __('Enter Country') }}">
                                                                {{-- <i class="las la-edit" id="update-country" style="cursor: pointer"></i> --}}
                                                            @if ($errors->has('country'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('country') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="address_input">
                                                            <input type="text" id="postcode" name="postcode"
                                                                value="{{ user()->postcode }}"
                                                                placeholder="{{ __('Enter Postcode') }}">
                                                                {{-- <i class="las la-edit" id="update-postcode" style="cursor: pointer"></i> --}}
                                                            @if ($errors->has('postcode'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('postcode') }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    @if (isUserUser())
                                                        <h3>{{ __('Social Media') }}</h3>
                                                        <div class="field-input">
                                                            <label for="facebook">{{ __('Facebook') }}</label>
                                                            <input type="text" id="facebook" name="facebook"
                                                                value="{{ user()->facebook }}"
                                                                placeholder="{{ __('Enter facebook') }}">
                                                            @if ($errors->has('facebook'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('facebook') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="field-input">
                                                            <label for="instagram">{{ __('Instagram') }}</label>
                                                            <input type="text" id="instagram" name="instagram"
                                                                value="{{ user()->instagram }}"
                                                                placeholder="{{ __('Enter instagram') }}">
                                                            @if ($errors->has('instagram'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('instagram') }}</small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    @if (isOperatorUser())
                                                        <div class="field-input">
                                                            <label for="instagram">{{ __('Account Type') }}</label>
                                                            <p style="margin-top: 9px;">{{ __('Operator') }}</p>
                                                        </div>
                                                    @endif

                                                    @if (isOperatorUser())

                                                        @if ($stripe_account_connected)
                                                            <div class="field-input" style="margin-bottom: 20px;">
                                                                <label for="instagram">{{ __('Stripe Connect') }}</label>
                                                                <p style="margin-top: 9px;color:green;">{{ __('Connected!') }}</p>
                                                            </div>
                                                            @if ($stripe_connect_link_recreate)
                                                            <div class="field-input stripe-connect-btn">
                                                                <a href="{{ $stripe_connect_link_recreate }}"><img
                                                                        src="{{ asset('assets/images/re-connect_with_stripe.png') }}"
                                                                        class="stripe_img" /></a>
                                                            </div>
                                                            @endif
                                                        @else
                                                            @if ($stripe_connect_link_create)
                                                                <div class="field-input">
                                                                    <a href="{{ $stripe_connect_link_create }}"><img
                                                                            src="{{ asset('assets/images/connect_with_stripe.png') }}"
                                                                            class="stripe_img" /></a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <div class="field-submit">
                                                        <input type="submit" value="{{ __('Update') }}">
                                                    </div>
                                                </div>

                                            </form><!-- .member-profile -->
                                            <form class="member-password form-underline" action="{{ route('user_password_update') }}"
                                                method="post">
                                                @method('put')
                                                @csrf
                                                <h3>{{ __('Change Password') }}</h3>
                                                <div class="form-group">
                                                    <div class="field-input">
                                                        <label for="old_password">{{ __('Old password') }}</label>
                                                        <input type="password" name="old_password"
                                                            placeholder="{{ __('Enter old password') }}" id="old_password" required>
                                                    </div>
                                                    <div class="field-input">
                                                        <label for="new_password">{{ __('New password') }}</label>
                                                        <input type="password" name="password"
                                                            placeholder="{{ __('Enter new password') }}" id="new_password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="field-input">
                                                        <label for="re_new">{{ __('Re-new password') }}</label>
                                                        <input type="password" name="password_confirmation"
                                                            placeholder="{{ __('Enter new password') }}" id="re_new" required>
                                                    </div>
                                                    <div class="field-submit">
                                                        <input type="submit" value="{{ __('Save') }}">
                                                    </div>
                                                </div>
                                            </form><!-- .member-password -->

                                            @if (isUserUser())
                                            <form class="member-driver form-underline" action="{{ route('user_driver_update') }}"
                                                method="post"
                                                enctype="multipart/form-data"
                                            >
                                                @method('put')
                                                @csrf
                                                <h3>{{ __('Drivers License') }}</h3>
                                                <div class="row">
                                                    <div class="form-group col-lg-4">
                                                        <div class="field-input">
                                                            <label for="drv_lic_no">{{ __('Drivers License Number') }}</label>
                                                            <input type="text" name="drv_lic_no" value="{{ user()->drv_lic_no }}"
                                                                placeholder="{{ __('License number') }}" id="drv_lic_no" >
                                                        </div>
                                                        <div class="field-input">
                                                            <label for="drv_lic_exp">{{ __('Drivers License Expiry') }}</label>
                                                            <input type="text" name="drv_lic_exp" value="{{ user()->drv_lic_exp }}" onfocus="(this.type='date')"
                                                                id="drv_lic_exp" placeholder="Expiry Date">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-8">
                                                        <div class="field-input">
                                                            <label for="upload_driver" style="color: #72bf44;">
                                                                <input id="upload_driver" type="file" name="drv_lic_thumb"
                                                                    value="{{ __('Upload new') }}" accept="image/*">
                                                                {{ __('Upload new') }} <i class="las la-edit"></i>
                                                            </label>
                                                            <br/>
                                                            <img id="member_driver" src="{{ getUserDrvLicThumb(user()->drv_lic_thumb)}}">
                                                            @if ($errors->has('drv_lic_thumb'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('drv_lic_thumb') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="field-submit">
                                                            <input type="submit" value="{{ __('Update') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form><!-- .member-driver license -->

                                            <form class="member-passport form-underline" action="{{ route('user_passport_update') }}"
                                                method="post" enctype="multipart/form-data">
                                                @method('put')
                                                @csrf
                                                <h3>{{ __('Passport') }}</h3>
                                                <div class="row">
                                                    <div class="form-group col-lg-4">
                                                        <div class="field-input">
                                                            <label for="drv_lic_no">{{ __('Passport Number') }}</label>
                                                            <input type="text" name="passport_no" value="{{ user()->passport_no }}"
                                                                placeholder="{{ __('Passport number') }}" id="passport_no" >
                                                        </div>
                                                        <div class="field-input">
                                                            <label for="passport_exp">{{ __('Passport Expiry') }}</label>
                                                            <input type="text" name="passport_exp" value="{{ user()->passport_exp }}" onfocus="(this.type='date')"
                                                                id="passport_exp" placeholder="Expiry Date">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-8">
                                                        <div class="field-input">
                                                            <label for="upload_passport" style="color: #72bf44;">
                                                                <input id="upload_passport" type="file" name="passport_thumb"
                                                                    value="{{ __('Upload new') }}" accept="image/*">
                                                                {{ __('Upload new') }} <i class="las la-edit"></i>
                                                            </label>
                                                            <br/>
                                                            <img id="member_passport" src="{{ getUserPassportThumb(user()->passport_thumb)}}">
                                                            @if ($errors->has('passport_thumb'))
                                                                <small class="form-text text-danger golo-d-none"
                                                                    style="display: inline;">{{ $errors->first('passport_thumb') }}</small>
                                                            @endif
                                                        </div>
                                                        <div class="field-submit">
                                                            <input type="submit" value="{{ __('Update') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form><!-- .member-driver license -->
                                            @endif
                                        </div>
                                        <div class="col-lg-6 user_subscription">
                                            @if(isUserUser())
                                                <div class="col-lg-6 col-md-8">
                                                @if (isUserHaveMembership() && $user_subscription)
                                                    <h3>{{ __('Membership Status') }}</h3>
                                                    <div>
                                                        <p>{{ __('Join Date') }}</p>
                                                        <div style="color:#414141;">{{ dateFormat($user_subscription->purchase_date) }}</div>
                                                    </div>
                                                    <div>
                                                        <p>{{ __('Days Remaining') }}</p>
                                                        @php
                                                            $expDate = new DateTime(dateFormat(auth()->user()->subscription_valid_till));
                                                            $now = new DateTime();
                                                            $interval = $now->diff($expDate);
                                                        @endphp
                                                        <div style="color:#72bf44;">{{$interval->format('%a')}}</div>
                                                    </div>
                                                    <div>
                                                        <p>{{ __('Expiry Date') }}</p>
                                                        <div style="color:#3bb44a;">{{ dateFormat(auth()->user()->subscription_valid_till) }}</div>
                                                    </div>

                                                    <div>
                                                        <p>{{ __('Auto-renew membership') }}</p>
                                                        <input type="checkbox" class="js-switch membership_renew" name="membership_renew" data-id="{{auth()->user()->id}}" {{isChecked(1, auth()->user()->membership_renew)}} />
                                                        <p>
                                                            {{ __('Your credit card will be automatically charged the yearly membership fee of $29 on the renewal date.') }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p>{{ __('Auto-renew Date') }}</p>
                                                        <div style="color:#414141;">
                                                            {{ dateFormat(auth()->user()->subscription_valid_till) }}
                                                        </div>
                                                    </div>
                                                @endif



                                                @if (isUserHaveMembership() && $user_subscription && false)
                                                    <h3>{{ __('Your Subscription:') }}</h3>

                                                    <style>
                                                        .border-table,
                                                        .border-table th,
                                                        .border-table tr,
                                                        .border-table td {
                                                            border: 1px solid black;
                                                        }

                                                        .border-table td {
                                                            padding: 10px;
                                                            /* cellpadding */
                                                            min-width: 120px;
                                                            text-align: center;
                                                        }

                                                    </style>
                                                    <div class="custom-table">
                                                        <table class="border-table">
                                                            <tr>
                                                                <td>{{ __('Plan') }}</td>
                                                                <td>{{ __('Paid') }}</td>
                                                                <td>{{ __('Valid Till') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>{{ App\Models\UserSubscription::getSubscriptionPlanNameForUserType(auth()->user()->user_type) }}</b>
                                                                </td>
                                                                <td><b>${{ $user_subscription->price / 100 }}</b></td>
                                                                <td><b>{{ dateFormat(auth()->user()->subscription_valid_till) }}</b></td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                @endif

                                                @if (!isUserHaveMembership())
                                                    <h3>{{ __('Subscription Plan:') }}</h3>
                                                    <div>
                                                        <div>
                                                            <p>{{ __('Plan') }}</p>
                                                            <div>
                                                                {{ App\Models\UserSubscription::getSubscriptionPlanNameForUserType(auth()->user()->user_type) }}
                                                            </div>
                                                        </div>
                                                        <div style="padding-top: 20px">
                                                            <p>{{ __('Price:') }}</p>
                                                            <div style="color: #72bf44;">
                                                                ${{ App\Models\UserSubscription::getSubscriptionPriceForUserType(auth()->user()->user_type) }}
                                                            </div>
                                                        </div>
                                                        <div style="padding-top: 20px">
                                                            <p>{{ __('Days:') }}</p>
                                                            <div>
                                                                ${{ App\Models\UserSubscription::getSubscriptionDaysForUserType(auth()->user()->user_type) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <a class="btn" title="Add place" data-toggle="modal"
                                                                        data-target="#plan_feature" href="javascript:void(0);">
                                                                        <span>{{ __('Subscribe Now') }}</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                                </div>
                                            @endif

                                            @if(isOperatorUser())
                                                <div>
                                                    <h3>{{ __('Subscription Plan:') }}</h3>
                                                    <div>
                                                        <div>
                                                            <p>{{ __('Plan') }}</p>
                                                            <div>
                                                                {{ App\Models\UserSubscription::getSubscriptionPlanNameForUserType(auth()->user()->user_type) }}
                                                            </div>
                                                        </div>
                                                        <div style="padding-top: 20px">
                                                            <p>{{ __('Price:') }}</p>
                                                            <div style="color: #72bf44;">
                                                                ${{ App\Models\UserSubscription::getSubscriptionPriceForUserType(auth()->user()->user_type) }}
                                                                    /Month
                                                                {{-- {{ App\Models\UserSubscription::getSubscriptionDaysForUserType(auth()->user()->user_type) }} --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isUserUser())
                                            @include('frontend.common.banner_ads')
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @if(isUserUser())
                            <div class="tab-pane fade" id="nav-interest" role="tabpanel" aria-labelledby="nav-interest-tab">
                                <div class="member-wishlist-wrap">
                                    <div class="interest-title">
                                        <div>
                                            <h3>{{__('My Interests')}}</h3>
                                            <div>
                                                <p>{{__('Receive email notifications of new listings & offers that match your interests?')}}</p>
                                                <div>
                                                    <input type="checkbox" class="js-switch interest_mail" name="interest_mail" data-id="{{auth()->user()->id}}" {{isChecked(1, auth()->user()->interest_mail)}} />
                                                    <label for ="interest_mail">{{__('Turn this on/off at any stage')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="padding-top: 15px;">
                                            <p>{{__('Let us know about yourself so we can better match suggestions for you.')}}</p>
                                        </div>
                                    </div>
                                    <div class="interest-contents">
                                        @foreach($categories as $cat)
                                            <div class="interest-cat interest-{{$cat->slug}}">
                                                <div class="catSvg">
                                                    <img src="{{getCategoryMakerUrl($cat->icon_map_marker)}}" alt="{{$cat->name}}" >
                                                    <div></div>
                                                </div>
                                                <div class="interest-types">
                                                    @foreach ($interest_list as $list)
                                                        @if($list->category_id == $cat->id)
                                                            @php
                                                                $class_name = "";
                                                                foreach($user_interest as $inte){
                                                                    if($inte->interest_id == $list->id){
                                                                        $class_name = "active";
                                                                    }
                                                                }
                                                            @endphp
                                                            <button class="btn btnInterest {{$class_name}}"
                                                            data-id="{{$list->id}}" style="border:1px solid {{$cat->color_code}}">
                                                                {{$list->keyword}}
                                                            </button>
                                                        @endif

                                                    @endforeach
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade {{ Request::is('user/place-favourites') ? 'show active' : '' }}" id="nav-favourite" role="tabpanel" aria-labelledby="nav-favourite-tab">
                                <div class="member-wishlist-wrap">
                                    <!-- <h1>{{__('Place Followed')}}</h1> -->
                                    <div class="mw-box">
                                        <div class="wishlist-filter">
                                            <div>
                                                <h3>
                                                    {{__('My favourites')}}
                                                </h3>
                                            </div>
                                            <div id="wishFilterBtns">
                                                @include('frontend.user.wishFilterBtn')
                                                @foreach( $categories as $cat)
                                                    <button class="btn btnFavCateogry btnCat{{$cat->slug}}" data-id="{{$cat->slug}}" style="border:1px solid {{$cat->color_code}}">
                                                        <div>@include('frontend.user.svgImage')</div>
                                                        <span>{{$cat->name}}</span>
                                                    </button>
                                                @endforeach
                                                <p>
                                                    {{__('Let us know about yourself so we can better match suggestions for you.')}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mw-grid golo-grid grid-4 ">
                                            @forelse($places as $place)
                                            <div class="place-item layout-02 filterFavDiv divFavCat{{$place['categories'][0]['slug']}}">
                                                <div class="place-inner">
                                                    <div class="place-thumb">
                                                        <a class="entry-thumb" href="{{route('place_detail', $place->slug)}}">
                                                            <img  src="{{getImageUrl($place->thumb)}}" alt="{{$place->name}}">
                                                            <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;"></div>
                                                            <div class="row place_thumb_desription">
                                                                @php
                                                                    $logo = $place->logo != null ? getImageUrl($place->logo) : null;
                                                                @endphp

                                                                @if ($logo !== null)
                                                                    <div class="place_thumb_logo">
                                                                        <img src="{{$logo}}" alt="logo" class="custom-img-height">
                                                                    </div>
                                                                    <div class="place_thumb_price_1" style="background-color:{{$place['categories'][0]['color_code']}};">
                                                                        @if($place['categories'][0]['slug'] !== "see")
                                                                        <div>
                                                                            <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                                                <div class="treding_price_small">from</div>
                                                                                <div class="treding_price_big"> ${{ $place->getPlacePrice() }}</div>
                                                                                <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
                                                                            </div>
                                                                            <div style="color: #FEFEFE; font-size:12px;">
                                                                                @if ($place['categories'][0]['pricing_text'] !== null)
                                                                                    {{ $place['categories'][0]['pricing_text'] }}
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        @else
                                                                        <div class="treding_price_free" style="color: #FEFEFE; text-align:center;">Free</div>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div style="display:hidden;"></div>
                                                                    <div class="place_thumb_price_2" style="background-color:{{$place['categories'][0]['color_code']}};">
                                                                    @if($place['categories'][0]['slug'] !== "see")
                                                                        <div>
                                                                            <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                                                <div class="treding_price_small">from</div>
                                                                                <div class="treding_price_big">${{ $place->getPlacePrice() }} </div>
                                                                                <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
                                                                            </div>
                                                                            <div style="color: #FEFEFE; font-size:12px;">
                                                                                @if ($place['categories'][0]['pricing_text'] !== null)
                                                                                    {{ $place['categories'][0]['pricing_text'] }}
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        @else
                                                                        <div style="color: #FEFEFE;" class="treding_price_free">Free</div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </a>
                                                        <a data-tooltip="Favourite" data-position="left" href="#"
                                                            class="golo-add-to-wishlist btn-add-to-wishlist @if($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                                                            data-id="{{$place->id}}" data-color="{{$place['categories'][0]['color_code']}}" @if($place->wish_list_count) style="background-color:{{$place['categories'][0]['color_code']}};"@endif>
                                                            <span class="icon-heart">
                                                                @if($place->wish_list_count)
                                                                <i class="fas fa-bookmark"></i>
                                                                @else
                                                                <i class="far fa-bookmark"></i>
                                                                @endif
                                                            </span>
                                                        </a>
                                                        @if(isset($place['categories'][0]))
                                                        <a class="entry-category rosy-pink"
                                                            href="{{route('page_search_listing', ['category[]' => $place['categories'][0]['id']])}}">
                                                            <img src="{{getCategoryIcon($place['categories'][0]['icon_map_marker'],$place['categories'][0]['icon_map_marker'])}}"
                                                                alt="{{$place['categories'][0]['name']}}">
                                                            <!-- <span>{{$place['categories'][0]['name']}}</span> -->
                                                        </a>
                                                        @endif
                                                    </div>
                                                    <div class="entry-detail">
                                                        <h3 class="place-title">
                                                            <a>{{$place->name}}</a>
                                                        </h3>

                                                        <div class="entry-head">
                                                            <div class="place-type list-item">
                                                                @foreach($place['place_types'] as $type)
                                                                    <span>{{$type->name}}</span>
                                                                @endforeach
                                                            </div>
                                                            <div class="place-city">
                                                                <a href="{{route('page_search_listing', ['city[]' => $place['city']['id']])}}">{{$place['city']['name']}}</a>
                                                            </div>
                                                        </div>

                                                        <div class="entry-bottom">
                                                            <div class="place-preview">
                                                                <span class="count-reviews">({{$place->reviews_count}} {{__('reviews')}})</span>
                                                                <div class="place-rating">
                                                                    @if($place->reviews_count)
                                                                    <!-- {{number_format($place->avgReview, 1)}} -->
                                                                        @for($i = 0; $i < 5 - round($place->avgReview); $i++)
                                                                            <i class="far fa-star" style="color:#414141;"></i>
                                                                        @endfor
                                                                        @for($i = 0; $i < round($place->avgReview); $i++)
                                                                            <i class="fas fa-star" style="color:#febb02;"></i>
                                                                        @endfor
                                                                    @else
                                                                        @for($i = 0; $i < 5; $i++)
                                                                            <i class="far fa-star" style="color:#414141;"></i>
                                                                        @endfor
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="place-price">
                                                                <!-- <span>{{PRICE_RANGE[$place['price_range']]}}</span> -->
                                                            </div>
                                                        </div>
                                                        <a href="{{route('place_detail', $place->slug)}}" class="TrendingReadMoreButton" style="background-color:{{$place['categories'][0]['color_code']}};">
                                                           <div> Read More</div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                No Data
                                            @endforelse
                                        </div>
                                    </div><!-- .mw-box -->
                                </div><!-- .member-wrap -->
                            </div>
                            <div class="tab-pane fade {{ Request::is('user/product-wishlist') ? 'show active' : '' }}" id="nav-wishlist" role="tabpanel" aria-labelledby="nav-wishlist-tab">
                                <div class="member-wishlist-wrap">
                                    <div class="mw-box">
                                        <div class="wishlist-filter">
                                            <div>
                                                <h3>
                                                    {{__('My wishlists')}}
                                                </h3>
                                            </div>
                                            <div id="wishFilterBtns">
                                                @include('frontend.user.wishFilterBtn')
                                                @foreach( $categories as $cat)
                                                    <button class="btn btnWishCateogry btnCat{{$cat->slug}}" data-id="{{$cat->slug}}" style="border:1px solid {{$cat->color_code}}">
                                                        <div>@include('frontend.user.svgImage')</div>
                                                        <span>{{$cat->name}}</span>
                                                    </button>
                                                @endforeach
                                                <p>
                                                    {{__('Let us know about yourself so we can better match suggestions for youuu.')}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mw-grid golo-grid grid-4 ">
                                            @forelse($place_products as $menu)
                                            <div class="place-item layout-02 filterWishDiv divWishCat{{$menu->place['categories'][0]['slug']}}">
                                                <div class="place-inner">
                                                    <div class="place-thumb">
                                                        <a class="entry-thumb" href="{{route('place_detail', $menu->place->slug)}}">
                                                            <img src="{{$menu['thumb']}}" alt="{{$menu->name}}">
                                                            <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;"></div>
                                                            <div class="row place_thumb_desription">
                                                                @php
                                                                    $logo = $menu->place->logo != null ? getImageUrl($menu->place->logo) : null;
                                                                @endphp

                                                                @if ($logo !== null)
                                                                    <div class="place_thumb_logo">
                                                                        <img src="{{$logo}}" alt="logo" class="custom-img-height">
                                                                    </div>
                                                                    <div class="place_thumb_price_1" style="background-color:{{$menu->place['categories'][0]['color_code']}};">
                                                                        @if($menu->place['categories'][0]['slug'] !== "see")
                                                                        <div>
                                                                            <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                                                <div class="treding_price_big"> ${{ getRezdyPrice($menu) }}</div>
                                                                                <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
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
                                                            <img src="{{getCategoryIcon($menu->place['categories'][0]['icon_map_marker'],$menu->place['categories'][0]['icon_map_marker'])}}"
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
                                                        <h3 class="place-title">
                                                            <a>{{$menu['name']}}</a>
                                                        </h3>
                                                        {{-- <p class="product-description">
                                                            {{$menu->description}}
                                                        </p> --}}
                                                        {{-- <a href="{{route('place_detail', $menu->place->slug)}}" class="TrendingReadMoreButton" style="background-color:{{$menu->place['categories'][0]['color_code']}};">
                                                           <div> Read More</div>
                                                        </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                No Wishlist
                                            @endforelse
                                        </div>
                                    </div><!-- .mw-box -->
                                </div><!-- .member-wrap -->

                                @include('frontend.common.banner_ads')

                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="recent_view_place">
                    @if (!isOperatorUser())
                        @php
                            $balance = cleanDecimalZeros(App\Models\RewardPointTransaction::getBalance());
                        @endphp
                        <div class="trending trending-business recent-content">
                            <div class="container">
                                <h2 class="title title-border-bottom align-center">{{__('Recently Viewed')}}</h2>
                                <div class="slick-sliders">
                                    <div class="slick-slider trending-slider slider-pd30"  data-autoplay="true" data-item="4" data-arrows="true"
                                        data-itemScroll="1" data-dots="true" data-centerPadding="30" data-tabletitem="3"
                                        data-tabletscroll="2" data-smallpcscroll="3" data-smallpcitem="3" data-mobileitem="1"
                                        data-mobilescroll="1" data-mobilearrows="false">

                                        @foreach ($user_view_places as $user_view_place)
                                        <div class="place-item layout-02">
                                            <div class="place-inner">
                                                <div class="place-thumb">
                                                    <a class="entry-thumb" href="{{route('place_detail', $user_view_place->place->slug)}}">
                                                        <img src="{{getImageUrl($user_view_place->place->thumb)}}" alt="{{$user_view_place->place->name}}">
                                                        <div style="position: absolute; width: 100%; height: 100%; top: 0;background-color: rgb(0, 0, 0, 0.4); border-radius: 15px;"></div>
                                                        <div class="row place_thumb_desription">
                                                            @php
                                                                $logo = $user_view_place->place->logo != null ? getImageUrl($user_view_place->place->logo) : null;
                                                            @endphp

                                                            @if ($logo !== null)
                                                                <div class="place_thumb_logo">
                                                                    <img src="{{$logo}}" alt="logo" class="custom-img-height">
                                                                </div>
                                                                <div class="place_thumb_price_1" style="background-color:{{$user_view_place->place['categories'][0]['color_code']}};">
                                                                    @if($user_view_place->place['categories'][0]['slug'] !== "see")
                                                                    <div>
                                                                        <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                                            <div class="treding_price_small">from</div>
                                                                            <div class="treding_price_big"> ${{ $user_view_place->place->getPlacePrice() }}</div>
                                                                            <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
                                                                        </div>
                                                                        <div style="color: #FEFEFE; font-size:12px;">
                                                                            @if ($user_view_place->place['categories'][0]['pricing_text'] !== null)
                                                                                {{ $user_view_place->place['categories'][0]['pricing_text'] }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div style="color: #FEFEFE; font-size:28px; text-align:center;">Free</div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div style="display:hidden;"></div>
                                                                <div class="place_thumb_price_2" style="background-color:{{$user_view_place->place['categories'][0]['color_code']}};">
                                                                @if($user_view_place->place['categories'][0]['slug'] !== "see")
                                                                    <div>
                                                                        <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
                                                                            <div class="treding_price_small">from</div>
                                                                            <div class="treding_price_big">${{ $user_view_place->place->getPlacePrice() }} </div>
                                                                            <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
                                                                        </div>
                                                                        <div style="color: #FEFEFE; font-size:12px;">
                                                                            @if ($user_view_place->place['categories'][0]['pricing_text'] !== null)
                                                                                {{ $user_view_place->place['categories'][0]['pricing_text'] }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div style="color: #FEFEFE; font-size:28px;">Free</div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                    <a data-tooltip="Favourite" data-position="left" href="#"
                                                        class="golo-add-to-wishlist btn-add-to-wishlist @if($user_view_place->place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                                                        data-id="{{$user_view_place->place->id}}" data-color="{{$user_view_place->place['categories'][0]['color_code']}}" @if($user_view_place->place->wish_list_count) style="background-color:{{$user_view_place->place['categories'][0]['color_code']}};"@endif>
                                                        <span class="icon-heart">
                                                            @if($user_view_place->place->wish_list_count)
                                                            <i class="fas fa-bookmark"></i>
                                                            @else
                                                            <i class="far fa-bookmark"></i>
                                                            @endif
                                                        </span>
                                                    </a>
                                                    @if(isset($user_view_place->place['categories'][0]))
                                                    <a class="entry-category rosy-pink"
                                                        href="{{route('page_search_listing', ['category[]' => $user_view_place->place['categories'][0]['id']])}}">
                                                        <img src="{{getCategoryIcon($user_view_place->place['categories'][0]['icon_map_marker'],$user_view_place->place['categories'][0]['icon_map_marker'])}}"
                                                            alt="{{$user_view_place->place['categories'][0]['name']}}" >
                                                        <!-- <span>{{$user_view_place->place['categories'][0]['name']}}</span> -->
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="entry-detail">
                                                    <h3 class="place-title">
                                                        <a href="{{route('place_detail', $user_view_place->place->slug)}}">{{$user_view_place->place->name}}</a>
                                                    </h3>

                                                    <div class="entry-head">
                                                        <div class="place-type list-item">
                                                            @foreach($user_view_place->place['place_types'] as $type)
                                                                <span>{{$type->name}}</span>
                                                            @endforeach
                                                        </div>
                                                        <div class="place-city">
                                                            <a href="{{route('page_search_listing', ['city[]' => $user_view_place->place['city']['id']])}}">{{$user_view_place->place['city']['name']}}</a>
                                                        </div>
                                                    </div>

                                                    <div class="entry-bottom">
                                                        <div class="place-preview">
                                                            <span class="count-reviews">({{$user_view_place->place->reviews_count}} {{__('reviews')}})</span>
                                                            <div class="place-rating">
                                                                @if($user_view_place->place->reviews_count)
                                                                <!-- {{number_format($user_view_place->place->avgReview, 1)}} -->
                                                                    @for($i = 0; $i < 5 - round($user_view_place->place->avgReview); $i++)
                                                                        <i class="far fa-star" style="color:#414141;"></i>
                                                                    @endfor
                                                                    @for($i = 0; $i < round($user_view_place->place->avgReview); $i++)
                                                                        <i class="fas fa-star" style="color:#febb02;"></i>
                                                                    @endfor
                                                                @else
                                                                    @for($i = 0; $i < 5; $i++)
                                                                        <i class="far fa-star" style="color:#414141;"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="place-price">
                                                            <!-- <span>{{PRICE_RANGE[$user_view_place->place['price_range']]}}</span> -->
                                                        </div>
                                                    </div>
                                                    <a href="{{route('place_detail', $user_view_place->place->slug)}}" class="TrendingReadMoreButton" style="background-color:{{$user_view_place->place['categories'][0]['color_code']}};">
                                                    <div> Read More</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="place-slider__nav slick-nav trending_slick_nav">
                                        <div class="place-slider__prev slick-nav__prev">
                                            <i class="fas fa-caret-left"></i>
                                        </div><!-- .place-slider__prev -->
                                        <div class="place-slider__next slick-nav__next">
                                            <i class="fas fa-caret-right"></i>
                                        </div><!-- .place-slider__next -->
                                    </div><!-- .place-slider__nav -->
                                </div>
                            </div>
                        </div><!-- .trending -->
                    @endif
                </div>
            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->

    <div class="modal fade" id="cancel_subscription_warning" tabindex="-1" role="dialog"
        aria-labelledby="cancel_subscription_warning" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">{{ __('Are you sure?') }}</h2>
                    <button type="button" class="close close-btn-event-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body member-wrap mb-0">
                    {{ __('Are you sure, you want to cancel Subscription?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close-btn-event-modal" data-dismiss="modal">Close</button>
                    <a href="{{ route('cancel_subscription') }}" class="btn">{{ __('Cancel Subscription') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="plan_feature" tabindex="-1" role="dialog" aria-labelledby="plan_feature"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><img
                            src="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}"
                            alt="logo"></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body member-wrap mb-0">
                    @if (isOperatorUser())
                        @include('frontend.common.plan_modal_body_operator')
                    @else
                        @include('frontend.common.plan_modal_body_user')
                    @endif
                </div>
                {{-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn" data-dismiss="modal" data-toggle="modal"
                    data-target="#stripe_modal">Purchase Plan</button>
            </div> --}}
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="stripe_modal" tabindex="-1" role="dialog" aria-labelledby="stripe_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="payment-form" @if (isOperatorUser()) action="{{route('stripe_subscription')}}" @else
                action="{{route('stripe_charge')}}" @endif method="post">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><img
                            src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                            alt="logo"></h2>
                    <button type="button" class="close closefirstmodal" --}}
    {{-- data-dismiss="modal" aria-label="Close" --}}
    {{-- >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body member-wrap mb-0">
                    <h3>Pay with card
                        ${{App\Models\UserSubscription::getSubscriptionPriceForUserType(auth()->user()->user_type)}}
                    </h3>
                    <div class="card_info form-underline">
                        <div class="card-row">
                            <span class="visa"></span>
                            <span class="mastercard"></span>
                            <span class="amex"></span>
                            <span class="discover"></span>
                        </div>
                        <div class="fomr_field">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="field-input">
                                        <label for="email">Name on Card</label>
                                        <input type="text" id="card_name-stripe" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="field-input">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" value="{{auth()->user()->email}}"
                                            class="form-control" disabled>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6 col-md-6">
                        <div class="field-input">
                            <label for="cardname">Name on card</label>
                            <input type="text" id="cardname" name="name_on_card" value="">
                        </div>
                     </div> -->
                                <div class="col-lg-12 col-md-12">
                                    <div class="field-input">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <label for="info">Card Info</label>
                                            </div>
                                            <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-6 text-right">
                                    <label for="info">Expiry Date&nbsp;&nbsp;&nbsp;CVV&nbsp;</label>
                                </div> -->
                                        </div>
                                    </div>
                                    <div id="card-element">
                                        <!--Stripe.js injects the Card Element-->
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
    {{-- <div id="Warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure you want to cancel buying your subscription?</p>
                <button type="button" class="btn btn-danger confirmclosed">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Buy Now</button>
            </div>
        </div>
    </div>
</div> --}}

@stop
@push('scripts')
<script>
    $(document).ready(function () {
        @if (isOperatorUser() && isUserHaveMembership() && Auth::user()->isUserProfileComplete())
            $('body').on('click', '.account', function() {
                $('.company_pointer').remove();
            });

            // $('.my_company_menu').addClass('flash');
        @endif
    
        $('#update-name').on('click',function(){
            $('#name').focus();
        });

        $('#update-email').on('click',function(){
            $('#email').focus();
        });

        $('#update-phone').on('click',function(){
            $('#phone_number').focus();
        });
        // $('#update-street').on('click',function(){
        //     $('#street').focus();
        // });
        // $('#update-suburb').on('click',function(){
        //     $('#suburb').focus();
        // });
        // $('#update-city').on('click',function(){
        //     $('#city').focus();
        // });
        // $('#update-state').on('click',function(){
        //     $('#state').focus();
        // });
        // $('#update-country').on('click',function(){
        //     $('#country').focus();
        // });
        if ($(".js-switch")[0]) {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html, {
                    color: '#72bf44'
                });
            });
        }

    });

    function notify(noti_content, noti_type = 'success',) {
        /**
         * Type: success, info, danger
         */
        new PNotify({
            title: 'Notify!',
            text: noti_content,
            type: noti_type,
            styling: 'bootstrap3',
            delay: 3000
        });
    }

    $(document).on("change", ".interest_mail", function () {
        let user_id = $(this).attr('data-id');
        let interest_mail = $(this).is(':checked');

        let data_resp = callAPI({
            url: getUrlAPI('/user/interest-mail', 'api'),
            method: "put",
            body: {
                "user_id": user_id,
                "interest_mail": interest_mail ? 1 : 0
            }
        });
        data_resp.then(res => {
            if (res.code === 200) {
                notify(res.message);
            } else {
                console.log(res);
                notify('Error!', 'error');
            }
        });
    });

    $(document).on("change", ".membership_renew", function () {
        let user_id = $(this).attr('data-id');
        let membership_renew = $(this).is(':checked');

        let data_resp = callAPI({
            url: getUrlAPI('/user/membership-renew', 'api'),
            method: "put",
            body: {
                "user_id": user_id,
                "membership_renew": membership_renew ? 1 : 0
            }
        });
        data_resp.then(res => {
            if (res.code === 200) {
                notify(res.message);
            } else {
                console.log(res);
                notify('Error!', 'error');
            }
        });
    });
    // var btnContainer = document.getElementById("wishFilterBtns");
    // var btns = btnContainer.getElementsByClassName("btn");
    // for (var i = 0; i < btns.length; i++) {
    // btns[i].addEventListener("click", function(){
    //     if(this.className.spilt(" ").indexOf("active") > -1){
    //         this.removeClass("active;")
    //     } else {
    //         this.addClass("active");
    //     }
    // });
    $(document).on("click", "#wishFilterBtns .btnFavCateogry" , function() {

        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }

        if ($('#wishFilterBtns .btnFavCateogry.active').length == 0) {
            $('.filterFavDiv').removeClass('d-none');
        } else {
            $('.filterFavDiv').addClass('d-none');

            $('#wishFilterBtns .btnFavCateogry.active').each(function() {
                var category_slug = $(this).data('id');
                $('.divFavCat' + category_slug).removeClass('d-none');
            });
        }
    });

    $(document).on("click", "#wishFilterBtns .btnWishCateogry" , function() {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }

        if ($('#wishFilterBtns .btnWishCateogry.active').length == 0) {
            $('.filterWishDiv').removeClass('d-none');
        } else {
            $('.filterWishDiv').addClass('d-none');

            $('#wishFilterBtns .btnWishCateogry.active').each(function() {
                var category_slug = $(this).data('id');
                $('.divWishCat' + category_slug).removeClass('d-none');
            });
        }
    });

    $(document).on("click", ".btnInterest", function () {
        let interest_id = $(this).attr('data-id');
        let user_id = {{ Auth::user()->id }};
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            let data_resp = callAPI({
                url: getUrlAPI('/user/removeInterest', 'api'),
                method: "delete",
                body: {
                    "user_id": user_id,
                    "interest_id": interest_id
                }
            });
        } else {
            $(this).addClass("active");
            let data_resp = callAPI({
                url: getUrlAPI('/user/addInterest', 'api'),
                method: "post",
                body: {
                    "user_id": user_id,
                    "interest_id": interest_id
                }
            });

        }
        data_resp.then(res => {
            if (res.code === 200) {
                notify(res.message);
            } else {
                console.log(res);
                notify('Error!', 'error');
            }
        });
    });
    $("#prize-from-date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            firstDay: 1,
            minDate: '<?php echo  date('d-m-Y H:i:s');?>'
    });
    $("#prize-to-date").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            firstDay: 1,
            minDate: '<?php echo  date('d-m-Y H:i:s');?>'
    });

    setTimeout(function(){
        document.getElementById('prize-update-info').style.display = 'none';
    }, 5000);

</script>
@endpush
{{-- @push('scripts')

<script>
    $(document).ready(function () { //Dom Ready
        $('.closefirstmodal').on('click',function () {
            $('#Warning').modal('show').on('show.bs.modal', function () {

            });
        });
    $(document).on('click','.confirmclosed',function () {
            //ClosWaring Modal Confirm Close Button
                    $('#Warning').modal('hide'); //Hide Warning Modal
                    $('#stripe_modal').modal('hide'); //Hide Form Modal
                });
    });
    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/apikeys
    var stripe = Stripe('{{config("services.stripe.key")}}');

    const appearance = {
    // If you are planning to extensively customize rules, use the "none"
    // theme. This theme provides a minimal number of rules by default to avoid
    // interfering with your custom rule definitions.
    theme: 'none',

    rules: {
      '.Tab': {
        border: '1px solid #E0E6EB',
        boxShadow: '0px 1px 1px rgba(0, 0, 0, 0.03), 0px 3px 6px rgba(18, 42, 66, 0.02)',
      },

      '.Tab:hover': {
        color: 'var(--colorText)',
      },

      '.Tab--selected': {
        borderColor: '#E0E6EB',
        boxShadow: '0px 1px 1px rgba(0, 0, 0, 0.03), 0px 3px 6px rgba(18, 42, 66, 0.02), 0 0 0 2px var(--colorPrimary)',
      },

      '.Input--invalid': {
        boxShadow: '0 1px 1px 0 rgba(0, 0, 0, 0.07), 0 0 0 2px var(--colorDanger)',
      },

      // See all supported class names and selector syntax below
    }
  };

    var elements = stripe.elements({appearance});

    // Custom styling can be passed to options when creating an Element.
    var style = {
    base: {
        // Add your base input styles here. For example:
        fontSize: '14px',
        color: '#32325d',
    },
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
            event.preventDefault();

                // stripe.createPaymentMethod({
                //         type: 'card',
                //         card: card,
                //         billing_details: {
                //         name: 'Jenny Rosen',
                //         },
                //     })
                //     .then(function(result) {
                //         console.log('result:',result);
                //         // Handle result.error or result.paymentMethod
                //     });

                const card_name = document.getElementById('card_name-stripe').value;
                stripe.createToken(card,{name: card_name}).then(function(result) {
                    console.log("result",result);
                    if (result.error) {
                        toastr.error(result.error.message);
                    // Inform the customer that there was an error.
                    // let errorElement = document.getElementById('card-errors');
                    // errorElement.textContent = result.error.message;
                    } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                    }
                });


            });


            function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
          }

        function readUrl(input) {
            const imageTypes = ["image/jpg", "image/jpeg", "image/png"];
            var file_size = input.files[0].size;
            if (imageTypes.includes(input.files[0].type)  && file_size<2097152) {
                $("#member_avatar").show();
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview')
                            .attr('src', e.target.result)
                            .width(100)
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            } else {
                $('#image_preview')
                            .attr('src', '')
                            .width(100)
                $('#upload_new').val('');
                $('#upload_new').attr('src', '');
                toastr.error('Please uploaded file Must Be less than 2MB..!');
            }
        }
</script>
@endpush --}}
