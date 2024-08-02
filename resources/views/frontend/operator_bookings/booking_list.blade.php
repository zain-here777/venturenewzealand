@extends('frontend.layouts.template')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/calender-main.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
<style type="text/css">
    .loader {
        width: 100%;
        height: 100%;
        top: 40%;
        left: 0%;
        position: absolute;
        display: none;
        opacity: 0.7;
        z-index: 99;
        text-align: center;
    }
    #show_loader {
        position: static!important;
        justify-content: center!important;
        align-items: center!important;
    }
    .loader2 {
        width: 100%;
        height: auto;
        top: 25%;
        left: 0%;
        position: absolute;
        display: none;
        opacity: 0.7;
        z-index: 99;
        text-align: center;
    }
    #show_loader2 {
        position: absolute !important;
        justify-content: center !important;
        align-items: center !important;
    }
    label.swal2-checkbox {
        align-items: baseline;
    }
    .fc-daygrid-day-frame.fc-scrollgrid-sync-inner {
        background: #f9fafb;
    }
    .fc-timegrid-slots {
        background: #f9fafb;
    }
    .fc-direction-ltr .fc-timegrid-slot-label-frame{
        margin-top: -54px;
    }
    td.fc-timegrid-slot.fc-timegrid-slot-label {
        height: 55px;
    }
    .fc .fc-scroller-liquid-absolute{
        padding-top: 20px;
    }
    #full-calender {
        padding: 25px;
    }
</style>
@endsection
@section('main')

    
    <main id="main" class="site-main">
        <div class="site-content">
            <div class="user_booking_banner">
            </div>
            <div class="user_booking_main_div" style="position:relative;">
                <div class="container booking_intro_box row">
                    <div class="col-7 col-lg-9 row booing__box_mark_name" style="margin:0;">
                        <div class="col-lg-4 country_box_title">
                            <div>
                                <div class = "country_box_name">My Bookings</div>
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
                        @if(!isUserAdmin())
                        <div class="operator-thumb">
                            <img src="{{getImageUrl($operator_place->thumb)}}" alt="{{$operator_place->name}}">
                        </div>
                        <div class="operator-category">
                            <img src="{{getCategoryIcon($operator_place['categories'][0]['icon_map_marker'])}}"
                                        alt="{{$operator_place['categories'][0]['name']}}">
                        </div>
                        @endif
                    </div>
                </div>


                <div class="container booking_detail_tab_div">
                    <div class="booking_detail_tab">
                        <div>
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link {{ Request::get('tab') ? 'active' : '' }}" id="nav-calendar-tab" data-toggle="tab" href="#nav-calendar" role="tab" aria-controls="nav-calendar" aria-selected="false">
                                        <div style="display: flex; gap:10px;">
                                            <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Calendar.svg') }}"></span>
                                            <span><img class="active_icon" src="{{ asset('assets/images/booking/Calendar-white.svg') }}"></span>
                                            <span class="nav_title">Calendar</span>
                                        </div>
                                    </a>
                                    <a class="nav-item nav-link {{ Request::get('tab') ? '' : 'active' }}" id="nav-booking-tab" data-toggle="tab" href="#nav-booking" role="tab" aria-controls="nav-booking" aria-selected="true">
                                        <div style="display: flex; gap:10px;">
                                            <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Scheduled.svg') }}"></span>
                                            <span><img class="active_icon" src="{{ asset('assets/images/booking/Scheduled-white.svg') }}"></span>
                                            <span class="nav_title">Bookings</span>
                                        </div>
                                    </a>
                                    @php
                                        $profile_url =  route('user_profile') . "?tab=prize";
                                    @endphp
                                    <a class="nav-item nav-link" id="nav-prize-tab" href="{{ $profile_url }}" aria-controls="nav-profile" aria-selected="true">
                                        <div style="display: flex; gap:10px;">
                                            <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Prizes.svg') }}"></span>
                                            <span class="nav_title">Prizes</span>
                                        </div>
                                    </a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" href="{{ route('user_profile') }}" aria-controls="nav-profile" aria-selected="true">
                                        <div style="display: flex; gap:10px;">
                                            <span><img class="inactive_icon" src="{{ asset('assets/images/booking/User.svg') }}"></span>
                                            <span><img class="active_icon" src="{{ asset('assets/images/booking/User-white.svg') }}"></span>
                                            <span class="nav_title">Profile</span>
                                        </div>
                                    </a>
                                    <a class="nav-item nav-link" id="nav-company-tab" href="{{ route('user_my_place') }}" aria-controls="nav-company" aria-selected="true">
                                        <div style="display: flex; gap:10px;">
                                            <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Card.svg') }}"></span>
                                            <span class="nav_title">Company Info</span>
                                        </div>
                                    </a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade {{ Request::get('tab') ? 'show active' : '' }}" id="nav-calendar" role="tabpanel" aria-labelledby="nav-calendar-tab">
                                    <table id="UserCalendarTable" class="table" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="text-align: end">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <!--calender content-->
                                                    <div class="date-content-section">
                                                        <!--Full calader section-->
                                                        <div class="member-wrap cart-heading">
                                                            <h1 class="h1-headings">{{ __('My Calendar') }}</h1>
                                                        </div><!-- .member-wrap -->

                                                        <div class="row left-calender-grid">

                                                            <div class="col-xl-3 col-lg-4 col-md-4 left-calender-grid-li">
                                                                <div id="show_loader2" class="loader2">
                                                                    <img id="loading-image" src="{{getImageUrl('giphy.gif')}}" alt="Loading..." />
                                                                </div>
                                                                <div class="date-picker">
                                                                    <div class="calendar">
                                                                    </div>
                                                                    <button class="btn add-avail-show">Add Booking Availability</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-9 col-lg-8 col-md-8 left-calender-grid-li">
                                                                <div id="full-calender"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade {{ Request::get('tab') ? '' : 'show active' }}" id="nav-booking" role="tabpanel" aria-labelledby="nav-booking-tab">
                                    <div class="operator-booking-header">
                                        <div class="operator-booking-title">Confirmed</div>
                                        @php
                                            $next_end_date = date('Y-m-d', strtotime($arrDate[6]['date'] .' +1 day'));
                                            $pre_start_date = date('Y-m-d', strtotime($arrDate[0]['date'] .' -1 day'));
                                            $next_week_month = date('M',strtotime($next_end_date));
                                            $pre_week_month = date('M',strtotime($pre_start_date));
                                            $this_week_month = date('M', strtotime($arrDate[0]['date']));
                                        @endphp
                                        <p class="weekbar-mobile-title">
                                            {{$this_week_month}}
                                        </p>
                                        <div class="operator-booking-weekbar">
                                            <div class="operator-weekbar-pre" data-day = "{{$pre_start_date}}" data-month="{{$pre_week_month}}"
                                                data-color = "{{$operator_place['categories'][0]['color_code']}}">
                                                <i class="fas fa-caret-left"></i>
                                            </div>
                                            @foreach($arrDate as $day)
                                            <div class="operator-weekbar-day @if($day['date'] == date('Y-m-d')) active @endif" data-day="{{$day['date']}}">
                                                @php
                                                    $week_month = date('M',strtotime($day['date']));
                                                    $week_day = date('d', strtotime($day['date']));
                                                @endphp
                                                <div class="weekday-month">{{$week_month}}</div>
                                                <div class="weekday-day">{{$week_day}}</div>
                                                <div class="weekday-events" style="color:{{$operator_place['categories'][0]['color_code']}}">
                                                @for ($i = 0; $i < $day['events']; $i++)
                                                    <i class="fas fa-circle"></i>
                                                @endfor
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="operator-weekbar-next" data-day="{{$next_end_date}}" data-month="{{$next_week_month}}"
                                                data-color = "{{$operator_place['categories'][0]['color_code']}}">
                                                <i class="fas fa-caret-right"></i>
                                            </div>
                                        </div>
                                        <div class="operator-booking-button">
                                            <button class="btn ConfirmBtn active">
                                                <span><i class="fas fa-check-square"></i></span>
                                                <span>Confirmed</span>
                                            </button>
                                            <button class="btn toConfirmBtn">
                                                <span><i class="fas fa-question-square"></i></i></span>
                                                <span>To Confirm</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="booking-history-con">
                                        {{-- Confirmed --}}
                                        <div class="responsive-table operator-confirmed-table">
                                            <table class="table">
                                                <thead>
                                                        <tr>
                                                            <th>{{ __('Booking Slot Information') }}</th>
                                                            <th>{{ __('Booking ID') }}</th>
                                                            <th>{{ __('Name') }}</th>
                                                            <th>{{ __('No. of Pers') }}</th>
                                                            <th>{{ __('Price') }}</th>
                                                            <th>
                                                                <span>{{ __('Status') }}</span>
                                                            </th>
                                                            <th>{{ __('Manage') }}</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($arrBookingConfirmedData))
                                                    @foreach($arrBookingConfirmedData as $booking_order_byTime)
                                                    @foreach($booking_order_byTime as $booking_order_bySlot)
                                                        @php
                                                        $j = 0;
                                                        $currentPersonNo = 0;
                                                        foreach ($booking_order_bySlot as $booking_order) {
                                                            $currentPersonNo += $booking_order->number_of_adult;
                                                            $currentPersonNo += $booking_order->number_of_children;
                                                        }
                                                        @endphp
                                                            @foreach($booking_order_bySlot as $booking_order)
                                                        <tr>
                                                            @if ($j == 0)
                                                            <td rowspan="{{ count($booking_order_bySlot) }}" class="slot-td">
                                                                <div class="operator-booking-slot" style="border:1px solid {{$operator_place['categories'][0]['color_code']}}">
                                                                    <div class="slot-DateTime">
                                                                        <div>
                                                                            <p>Date</p>
                                                                            <div>{{$booking_order->booking_date}}</div>
                                                                        </div>
                                                                        <div>
                                                                            <p>Time</p>
                                                                            <div>{{$arrSlotInfo[$booking_order->booking_time][$booking_order->place_product_id]->start_time}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="slot-product">
                                                                        <p>Product</p>
                                                                        <div style="color:{{$operator_place['categories'][0]['color_code']}}">{{$arrSlotInfo[$booking_order->booking_time][$booking_order->place_product_id]->product_name}}</div>
                                                                    </div>
                                                                    <div class="slot-capacity">
                                                                        <div>
                                                                            <p>Capacity</p>
                                                                            <div>
                                                                                {{$currentPersonNo}}/{{$arrSlotInfo[$booking_order->booking_time][$booking_order->place_product_id]->max_booking_no}}
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <p>Vacancies</p>
                                                                            <div>
                                                                                @php
                                                                                    $vacancy = $arrSlotInfo[$booking_order->booking_time][$booking_order->place_product_id]->max_booking_no - $currentPersonNo;
                                                                                @endphp
                                                                                {{ $vacancy }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="slot-button">
                                                                        <button class="btn slot-detail" data-id="{{$arrSlotInfo[$booking_order->booking_time][$booking_order->place_product_id]->id}}"
                                                                            data-date="{{$booking_order->booking_date}}"><i class="fas fa-info-circle"></i>Details</button>
                                                                        {{-- <button class="btn slot-print"><i class="fas fa-print"></i>Print</button> --}}
                                                                    </div>

                                                                <div>
                                                            </td>
                                                            @endif
                                                            <td>{{$booking_order->id}}</td>
                                                            <td>{{$booking_order->name}}</td>
                                                            <td>
                                                                @php
                                                                    $bookingNum = $booking_order->number_of_adult + $booking_order->number_of_children;
                                                                @endphp
                                                                {{$bookingNum}}
                                                            </td>
                                                            <td>${{$booking_order->payable_amount}}</td>
                                                            <td>
                                                                @if($booking_order->payment_intent_status=='succeeded')
                                                                    <div style="text-transform: capitalize;" class="status paid">
                                                                        <span><i class="fas fa-check-square"></i></span>
                                                                        <span>{{$booking_order->payment_intent_status}}</span>
                                                                    </div> <!-- paid unpaid pending -->
                                                                @elseif($booking_order->payment_intent_status=='canceled')
                                                                    <div style="text-transform: capitalize;" class="status unpaid">
                                                                        <span><i class="fas fa-times-circle"></i></span>
                                                                        <span>{{$booking_order->payment_intent_status}}</span>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                            <a href="{{route('booking_items',$booking_order->id)}}" class="btn booking_submit_btn">{{ __('View') }}</a>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $j++;
                                                        @endphp
                                                        @endforeach
                                                        @endforeach
                                                    @endforeach
                                                    @else
                                                    <tr><td colspan="8" style="text-align:center;width:100%;display: table-cell;">{{ __('No Items') }}</td></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="pagination align-left">
                                            {{$booking_confirmed_orders->render('frontend.common.pagination')}}
                                        </div><!-- .pagination --> --}}
                                        {{-- To Confirmed --}}
                                        <div id="show_loader" class="loader">
                                            <img id="loading-image" src="{{getImageUrl('giphy.gif')}}" alt="Loading..." />
                                        </div>
                                        <div class="responsive-table operator-toConfirm-table d-none">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <!-- <th></th> -->
                                                        <th>{{ __('Booking ID') }}</th>
                                                        <th>{{ __('Booking Date and Time') }}</th>
                                                        <th>
                                                            <span>{{ __('Status') }}</span>
                                                        </th>
                                                        <th>{{ __('Price') }}</th>
                                                        <th>{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($get_to_confirm_order))
                                                        @foreach ($get_to_confirm_order as $booking_order)
                                                            <tr>
                                                                <td>{{ $booking_order->id }}</td>
                                                                <td>{{ dateTimeFormat($booking_order->created_at) }}</td>
                                                                <td>
                                                                    <span style="text-transform: capitalize;cursor: pointer;" title="Click here to confirm booking and proceed" class="status unpaid" data-bookingid="{{ $booking_order->id }}" data-placeid={{ $booking_order->place_id }}>{{ $booking_order->payment_intent_status }}</span>
                                                                </td>
                                                                <td>${{ $booking_order->payable_amount }}</td>
                                                                <td>
                                                                    <a href="{{ route('booking_items', $booking_order->id) }}"
                                                                        class="btn booking_submit_btn">{{ __('View') }}</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="8" style="text-align:center;width:100%;display: table-cell;">
                                                                {{ __('No Items') }}</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pagination align-left">
                                            {{ $get_to_confirm_order->render('frontend.common.pagination') }}
                                        </div><!-- .pagination -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="booking-slot-detail d-none">
                        <div class="booking-slot-detail-head">
                            <div style="color:#fff;">
                                <i class="fas fa-info-circle"></i>
                                <span>Booking Slot Details</span>
                            </div>
                            <button class="btn slot-detail-back">
                                <i class="fas fa-caret-left"></i>
                                <span>Back</span>
                            </button>
                        </div>
                        <div class="booking-slot-detail-body">
                        </div>
                    </div>
                    <div class="booking-availibility d-none">
                        <div class="booking-availibility-head">
                            <div style="color:#fff;">
                                <span><img src="{{ asset('assets/images/booking/Scheduled-white.svg') }}"></span>
                                <span>Availability</span>
                            </div>
                            <button class="btn slot-edit-back">
                                <i class="fas fa-caret-left"></i>
                                <span>Back</span>
                            </button>
                        </div>
                        <div class="booking-availibility-body">
                            {{-- <div class="booking_availibility_form"></div> --}}
                            <div class="member-wrap cart-heading">
                                <h1 class="h1-headings" id="booking-availibility-title">{{ __('Add Booking Availability') }}</h1>
                            </div>
                            <form id="add_booking_availibility_frm" method="post">
                                @csrf
                                <input type="hidden" name="category" value="{{$category}}">
                                <div class="row booking-ul">
                                    <div class="col-lg-3 col-md-5  p-0 d-flex">
                                        <div class="col-md-12 booking-li">
                                            <div class="booking-div">
                                                <div class="custom-select-drp">
                                                    <select class="form-control" name="product_id" id="product_id">
                                                        <option value="">{{ __('Select Product') }}</option>
                                                        @if($category !== 'eat')
                                                            @if (!empty($products))
                                                                @foreach ($products->products as $product)
                                                                    @if($product->product_code === '' || is_null($product->product_code))
                                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @else
                                                            <option value="{{ $operator_place->id }}">{{ __('Reservation') }}</option>
                                                        @endif
                                                    </select>
                                                    <label id="product_id-error" class="error" for="product_id" style="display: none;color:red;font-size:15px;">{{__('This select product')}}</label>
                                                </div>
                                                <div class="custom-check">
                                                    <input type="checkbox" id="recurring" name="is_recurring" value="1">
                                                    <label class="bc_filter" for="recurring">{{ __('Recurring')}}</label>
                                                </div>
                                                <div class="week-days">
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="Sunday" name="recurring_value[]" value="Sunday">
                                                        <label class="bc_filter" for="Sunday">{{ __('Sunday')}}</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="Monday" name="recurring_value[]" value="Monday">
                                                        <label class="bc_filter" for="Monday">{{ __('Monday')}}</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="Tuesday" name="recurring_value[]" value="Tuesday">
                                                        <label class="bc_filter" for="Tuesday">{{ __('Tuesday')}}</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="Wednesday" name="recurring_value[]"
                                                            value="Wednesday">
                                                        <label class="bc_filter" for="Wednesday">{{ __('Wednesday')}}</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="Thursday" name="recurring_value[]" value="Thursday">
                                                        <label class="bc_filter" for="Thursday">{{ __('Thursday')}}</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="Friday" name="recurring_value[]" value="Friday">
                                                        <label class="bc_filter" for="Friday">{{ __('Friday')}}</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="Saturday" name="recurring_value[]" value="Saturday">
                                                        <label class="bc_filter" for="Saturday">{{ __('Saturday')}}</label>
                                                    </div>
                                                    <label id="chk_option_error" class="error" for="chk_option_error" style="visibility:hidden;color:red;font-size:15px;">{{ __('Please select any one')}}</label>
                                                </div>
                                                <div class="form-group-content first-date">
                                                    <label>{{ __('Date')}} </label>
                                                    <div class="custom-date-input">
                                                        <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                                        <input autocomplete="off" type="text" id="select-date1" name="date" class="datepicker_auto_select input-date" />
                                                        <label id="date-error" class="error" for="date" style="display: none;color:red;font-size:15px;">{{ __('Please select date')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-7">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 col-md-6  booking-li second-div">
                                                <div class="booking-div">
                                                    <h5 class="bg-headings">{{ __('Available From')}}:</h5>
                                                    <div class="form-group-content">
                                                        <label>{{ __('Date')}} </label>
                                                        <div class="custom-date-input">
                                                            <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                                            <input autocomplete="off" type="text" id="select-date2" name="available_from" class="input-date" />
                                                            <label id="available_from-error" class="error" for="available_from" style="display: none;color:red;font-size:15px;">{{ __('Please select date')}}</label>
                                                        </div>
                                                    </div>
                                                    <h5 class="bg-headings mt-4">{{ __('Available To')}}:</h5>
                                                    <div class="form-group-content">
                                                        <label>{{ __('Date')}} </label>
                                                        <div class="custom-date-input">
                                                            <div class="custom-date-input">
                                                                <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                                                <input autocomplete="off" type="text" id="select-date3" name="available_to" class="input-date" />
                                                                <label id="available_to-error" class="error" for="available_to" style="display: none;color:red;font-size:15px;">{{ __('Please select date')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-8 booking-li first-div-li">
                                                <div class="booking-div">
                                                    <h5 class="bg-headings">{{ __('Time Slots')}}:</h5>
                                                    <div class="custom-check">
                                                        @if($category == 'stay')
                                                        <input checked onclick="return false;" type="checkbox" id="all-day" name="all_day" value="1"
                                                            class="check-all">
                                                        <label onclick="return false;" class="bc_filter" for="all-day">{{ __('All day')}}</label>
                                                        @else
                                                        <input type="checkbox" id="all-day" name="all_day" value="1"
                                                            class="check-all">
                                                        <label class="bc_filter" for="all-day">{{ __('All day')}}</label>
                                                        @endif
                                                    </div>
                                                    <div class="sloat-items-ul-div">
                                                        @if($category == 'stay')
                                                        <div class="sloat-items-ul all_day_checkbox">
                                                            <div class="sloat-items-li">
                                                                <div class="sloat-flex d-block">
                                                                    <div class="max-input-div">
                                                                        <input type="text" name="booking_note_check" id="booking_note_check" class="input"
                                                                            placeholder="{{ __('Enter Booking Note') }}" />
                                                                        <label id="booking_note_check-error" class="error" for="booking_note_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking note')}}</label>
                                                                    </div>
                                                                    <div class="max-input-div">
                                                                        <input type="number" min="0" max="999" name="max_booking_no_check" id="max_booking_no_check" class="input"
                                                                            placeholder="{{ __('Max Booking No.') }}" />
                                                                        <label id="max_booking_no_check-error" class="error" for="max_booking_no_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking number')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="sloat-items-ul all_day_checkbox" style="display: none;">
                                                            <div class="sloat-items-li">
                                                                <div class="sloat-flex d-block">
                                                                    <div class="max-input-div">
                                                                        <input type="text" name="booking_note_check" id="booking_note_check" class="input"
                                                                            placeholder="{{ __('Enter Booking Note') }}" />
                                                                        <label id="booking_note_check-error" class="error" for="booking_note_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking note')}}</label>
                                                                    </div>
                                                                    <div class="max-input-div">
                                                                        <input type="number" min="0" max="999" name="max_booking_no_check" id="max_booking_no_check" class="input"
                                                                            placeholder="{{ __('Max Booking No.') }}" />
                                                                        <label id="max_booking_no_check-error" class="error" for="max_booking_no_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking number')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sloat-items-ul timeslot_show">
                                                            <label>{{ __('Time 01')}}</label>
                                                            <div class="sloat-items-li">
                                                                <div class="sloat-flex">
                                                                    <div class="sloat-flex-div">
                                                                        <div class="sloat-items-grid">
                                                                            <div class="input-group date" id="timePicker">
                                                                                <input type="text" class="form-control timePicker" name="time_slot_val[0][start_time]" id="start_time">
                                                                                <span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span>
                                                                            </div>
                                                                            <label id="start_time-error" class="error" for="time_slot_val[0][start_time]" style="display: none;color:red;font-size:15px;">Please select start time</label>
                                                                            <span>To</span>

                                                                            <div class="input-group date" id="timePicker1">
                                                                                <input type="text" class="form-control timePicker" name="time_slot_val[0][end_time]" id="end_time">
                                                                                <span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span>
                                                                            </div>
                                                                            <label id="end_time-error" class="error" for="end_time" style="display: none;color:red;font-size:15px;">Please select end time</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="sloat-flex-div border-left">
                                                                        <div class="max-input-div">
                                                                            <input type="text" name="time_slot_val[0][booking_note]" id="booking_note" class="input"
                                                                                placeholder="{{__('Enter Booking Note')}}" />
                                                                            <label id="booking_note-error" class="error" for="booking_note" style="display: none;color:red;font-size:15px;">{{ __('Please add booking note') }}</label>
                                                                        </div>
                                                                        <div class="max-input-div">
                                                                            <input type="number" min="0" max="999" name="time_slot_val[0][max_booking_no]" id="max_booking_no" class="input"
                                                                                placeholder="{{__('Max Booking No.')}}" />
                                                                            <label id="max_booking_no-error" class="error" for="max_booking_no" style="display: none;color:red;font-size:15px;">{{ __('Please add booking number') }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @if($category != 'stay')
                                                    <a class="add-time-sloat">
                                                        <i class="la la-plus"></i>
                                                        {{__('Add Time Slot')}}
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 booking-li first-div-li">
                                                <div class="booking-div">
                                                    <h5 class="bg-headings">{{__('Booking Cut Off')}}</h5>
                                                    <div class="custom-select-drp">
                                                        <select class="form-control" name="booking_cut_off" id="booking_cut_off">
                                                            <option value="">{{__('Select Time Span')}}</option>
                                                            <option value="30 min">{{__('30 min')}}</option>
                                                            <option value="1 hour">{{__('1 hr')}}</option>
                                                            <option value="2 hour">{{__('2 hr')}}</option>
                                                            <option value="5 hour">{{__('5 hr')}}</option>
                                                            <option value="1 day">{{__('1 day')}}</option>
                                                            <option value="2 day">{{__('2 day')}}</option>
                                                            <option value="1 week">{{__('1 week')}}</option>
                                                        </select>
                                                        <label id="booking_cut_off-error" class="error" for="booking_cut_off" style="display: none;color:red;font-size:15px;">{{__('Please select booking cut off')}}</label>
                                                    </div>
                                                    <div class="custom-check">
                                                        <input type="checkbox" id="confirm-booking" name="confirm_booking" value="0"
                                                            class="confirm_booking">
                                                        <label class="bc_filter" for="confirm-booking">{{ __('Confirm Booking')}}</label>
                                                    </div>
                                                @if($category == 'stay')
                                                <div class="max-input-div">
                                                        <input type="number" min="0" max="999" name="max_adult_per_room" id="max_adult_per_room" class="input" placeholder="Max adult per room">
                                                        <label id="max_adult_per_room-error" class="error" for="max_adult_per_room" style="display: none;color:red;font-size:15px;">Please add max adult per room</label>
                                                    </div>
                                                    <div class="max-input-div">
                                                        <input type="number" min="0" max="999" name="max_child_per_room" id="max_child_per_room" class="input" placeholder="Max child per room">
                                                        <label id="max_child_per_room-error" class="error" for="max_child_per_room" style="display: none;color:red;font-size:15px;">Please add max child per room</label>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center booking-btn">
                                    <button class="btn" type="submit" id="add_booking_availibility">{{__('Add Booking')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .site-content -->
                {{-- in below condition 20 means 'Eat' category --}}
                {{-- @if(isset($products) && ($products->category[0] == 20))
                    <div class="member-menu mt-5">
                        <div class="container">
                        <div class="member-wrap cart-heading">
                            <h1 class="h1-headings">{{__('Reservations')}}</h1>
                        </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="booking-history">
                            <div class="booking-history-con">
                                <h1 style="color: #a1a2a1;font-size: 35px;font-family: sans-serif;font-weight: 400;">{{ __('Confirmed') }}</h1>
                                <div class="responsive-table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Reservation ID') }}</th>
                                                <th>{{ __('Reservation Date and Time') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($reservations))
                                                @foreach ($reservations as $reservation)
                                                    <tr>
                                                        <td>{{ $reservation->reservation_id }}</td>
                                                        <td>{{ $reservation->date.' '.$reservation->time }}</td>
                                                        <td>{{ $reservation->name }}</td>
                                                        <td>
                                                            @if($reservation->status==1)
                                                                <span style="text-transform: capitalize;" class="status paid">Confirmed</span>
                                                            @elseif($reservation->status==3)
                                                                <span style="text-transform: capitalize;" class="status unpaid">Canceled</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)"  class="reservation-action-info btn booking_submit_btn" data-reservation_id="{{ $reservation->reservation_id }}" data-user_id="{{ $reservation->id }}">{{ __('View') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" style="text-align:center;width:100%;display: table-cell;">
                                                        {{ __('No Items') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pagination align-left">
                                    {{$reservations->render('frontend.common.pagination')}}
                                </div>
                            </div>
                        </div>

                        <div class="booking-history">
                            <div class="booking-history-con">
                                <h1 style="color: #a1a2a1;font-size: 35px;font-family: sans-serif;font-weight: 400;">{{ __('To Confirm') }}</h1>
                                <div class="responsive-table" id="reservation-to-confirm">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Reservation ID') }}</th>
                                                <th>{{ __('Reservation Date and Time') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Contact') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($reservationsToConfirms))
                                                @foreach ($reservationsToConfirms as $reservationsToConfirm)
                                                    <tr>
                                                        <td>{{ $reservationsToConfirm->reservation_id }}</td>
                                                        <td>{{ $reservationsToConfirm->date.' '.$reservationsToConfirm->time }}</td>
                                                        <td>{{ $reservationsToConfirm->name }}</td>
                                                        <td>{{ $reservationsToConfirm->user_phone_number }}</td>
                                                        <td>
                                                            <div id="process{{$reservationsToConfirm->reservation_id}}" style="display:none">Please wait</div>
                                                            <a href="javascript:void(0)" class="reservation-action-info btn booking_submit_btn" data-reservation_id="{{ $reservationsToConfirm->reservation_id }}" data-user_id="{{ $reservationsToConfirm->id }}">{{ __('View') }}</a>
                                                            <a href="javascript:void(0)"  class="reservation-action-confirm btn" data-reservation_id="{{ $reservationsToConfirm->reservation_id }}" data-user_id="{{ $reservationsToConfirm->id }}">{{ __('Confirm') }}</a>
                                                            <a href="javascript:void(0)"  class="reservation-action-cancel btn btn-danger" data-reservation_id="{{ $reservationsToConfirm->reservation_id }}" data-user_id="{{ $reservationsToConfirm->id }}" style="background-color:red;">{{ __('Cancel') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" style="text-align:center;width:100%;display: table-cell;">
                                                        {{ __('No Items') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pagination align-left">
                                    {{$reservationsToConfirms->render('frontend.common.pagination')}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}
    </main><!-- .site-main -->

    <div class="modal fade" id="cancel_subscription_warning" tabindex="-1" role="dialog"
        aria-labelledby="cancel_subscription_warning" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">{{__('Are you sure?')}}</h2>
                    <button type="button" class="close close-btn-event-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body member-wrap mb-0">
                    {{__('Are you sure, you want to cancel Subscription?')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close-btn-event-modal" data-dismiss="modal">{{__('Close')}}</button>
                    <a href="{{ route('cancel_subscription') }}" class="btn">{{__('Cancel Subscription')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div id="show_loader" class="loader">
                <img id="loading-image-info" src="{{getImageUrl('giphy.gif')}}" alt="Loading..." />
            </div>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Bookings</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="responsive-table">
                    <table class="table">
                       <thead>
                          <tr>
                            <th>{{__('Booking ID') }}</th>
                            <th>{{__('Product') }}</th>
                            <th>{{__('User') }}</th>
                            <th>{{__('Price') }}</th>
                            <th>{{__('Booking Date and Time') }}</th>
                             <th><span>{{ __('Status') }}</span></th>
                          </tr>
                       </thead>
                       <tbody id="detail_view_body">
                          <tr>
                             <td>-</td>
                             <td>-</td>
                             <td>-</td>
                             <td>$00.00</td>
                             <td>00-00-0000 00:00</td>
                             <td>-</td>
                          </tr>
                       </tbody>
                    </table>
                </div>


                @if(isset($products['category'][0]) && $products['category'][0] == 20) {{-- here 20 = 'Eat' category --}}
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="modal-title">Reservations</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                               <thead>
                                  <tr>
                                    <th>{{__('Reservation ID') }}</th>
                                    <th>{{__('Name') }}</th>
                                    <th>{{__('Contact') }}</th>
                                    <th>{{__('Email') }}</th>
                                    <th>{{__('No. of Adult') }}</th>
                                    <th>{{__('No. of Child') }}</th>
                                    <th>{{__('Reservation On') }}</th>
                                    <th>{{__('Reservation For') }}</th>
                                  </tr>
                               </thead>
                               <tbody id="reservation_details">
                                  <tr>
                                     <td>-</td>
                                     <td>-</td>
                                     <td>-</td>
                                     <td>-</td>
                                     <td>-</td>
                                     <td>-</td>
                                     <td>-</td>
                                     <td>-</td>
                                  </tr>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="reservationInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div id="show_loader" class="loader">
                <img id="loading-image-info" src="{{getImageUrl('giphy.gif')}}" alt="Loading..." />
            </div>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Reservation Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="responsive-table">
                    <table class="table">
                       <tbody id="reservation_detail_view_body">
                        <tr>
                            <th>{{__('Reservation ID') }}</th>
                            <td></td>
                          </tr>
                       </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
          </div>
        </div>
      </div>

@endsection
@push('style')
<style>
i.event-title {
font-size: 15px!important;
}
.main-event-div {
    display: flex;
    justify-content: space-between;
}

</style>

@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment-all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/full-calender.js') }}"></script> --}}
    <script src="{{ asset('assets/js/calender-main.min.js') }}"></script>
    <script src="{{ asset('assets/js/full-calender-locales-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.js')}}"></script>
    {{-- <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.es-es.js" type="text/javascript"></script> --}}

    <script>
        var dateArray = [];
        ! function() {
        var today = moment();

        moment.locale("{{config('app.locale') == 'zh' ? 'zh-cn' : config('app.locale')}}");
        function CustomCalendar(selector, events,Dmon) {
            var currentDate = moment(Dmon);
            this.el = document.querySelector(selector);
            this.events = events;
            this.current = moment(currentDate).date(1);
            this.draw();
            var current = document.querySelector('.today');
            if (current) {
                var self = this;
                window.setTimeout(function() {
                    self.openDay(current);
                }, 500);
            }
        }

        CustomCalendar.prototype.draw = function() {
            //Create Header
            this.drawHeader();

            //Draw Month
            this.drawMonth();

            this.drawLegend();
        }

        CustomCalendar.prototype.drawHeader = function() {
            var self = this;
            if (!this.header) {
                //Create the header elements
                this.header = createElement('div', 'header');
                this.header.className = 'header';
                this.title = createElement('h1');
                var right = createElement('div', 'right');
                right.addEventListener('click', function() {
                    self.nextMonth();
                });
                var left = createElement('div', 'left');
                left.addEventListener('click', function() {
                    self.prevMonth();
                });
                //Append the Elements
                this.header.appendChild(this.title);
                this.header.appendChild(right);
                this.header.appendChild(left);
                this.el.appendChild(this.header);
            }

            this.title.innerHTML = this.current.format('MMMM YYYY');
        }

        CustomCalendar.prototype.drawMonth = function() {
            var self = this;
            dateArray = [];
            this.events.forEach(function(ev) {

            });

            if (this.month) {
                this.oldMonth = this.month;
                this.oldMonth.className = 'month out ' + (self.next ? 'next' : 'prev');
                this.oldMonth.addEventListener('webkitAnimationEnd', function() {
                    self.oldMonth.parentNode.removeChild(self.oldMonth);
                    self.month = createElement('div', 'month');
                    self.backFill();
                    self.currentMonth();
                    self.fowardFill();
                    self.el.appendChild(self.month);
                    window.setTimeout(function() {
                        self.month.className = 'month in ' + (self.next ? 'next' : 'prev');
                    }, 16);
                });
            } else {
                this.month = createElement('div', 'month');
                this.el.appendChild(this.month);
                this.backFill();
                this.currentMonth();
                this.fowardFill();
                this.month.className = 'month new';
            }
        }

        CustomCalendar.prototype.backFill = function() {
            var clone = this.current.clone();
            var dayOfWeek = clone.day();

            if (!dayOfWeek) { return; }

            clone.subtract('days', dayOfWeek + 1);

            for (var i = dayOfWeek; i > 0; i--) {
                this.drawDay(clone.add('days', 1));
            }
        }

        CustomCalendar.prototype.fowardFill = function() {
            var clone = this.current.clone().add('months', 1).subtract('days', 1);
            var dayOfWeek = clone.day();

            if (dayOfWeek === 6) { return; }

            for (var i = dayOfWeek; i < 6; i++) {
                this.drawDay(clone.add('days', 1));
            }
        }

        CustomCalendar.prototype.currentMonth = function() {
            var clone = this.current.clone();

            while (clone.month() === this.current.month()) {
                this.drawDay(clone);
                clone.add('days', 1);
            }
        }

        CustomCalendar.prototype.getWeek = function(day) {
            if (!this.week || day.day() === 0) {
                this.week = createElement('div', 'week');
                this.month.appendChild(this.week);
            }
        }

        CustomCalendar.prototype.drawDay = function(day) {
            var self = this;
            this.getWeek(day);
            //Outer Day
            var outer = createElement('div', this.getDayClass(day));
            outer.addEventListener('click', function() {
                // if (!this.classList.contains('disabled')) {
                self.openDay(this);
                //}
            });
            var dates = day.clone().date(day.format('DD')).toDate();
            var getday = (dates.getDate() < 10 ? '0' + dates.getDate() : dates.getDate());
            var getmonth = (dates.getMonth() + 1).toString().padStart(2, "0");
            var getyear = dates.getFullYear();
            var makedate = getyear+'-'+getmonth+'-'+getday;

            dateArray.push(makedate);

            outer.setAttribute("data-caldate",makedate);

            var name = createElement('div', 'day-name', day.format('ddd'));

            var number = createElement('div', 'day-number', day.format('DD'));

            var element = createElement('input');
            element.setAttribute("type","hidden");
            element.setAttribute("class","selected_date");
            element.setAttribute("value",makedate);

            //Events
            var events = createElement('div', 'day-events');
            this.drawEvents(day, events);

            outer.appendChild(name);
            outer.appendChild(number);
            number.appendChild(events);
            number.appendChild(element);
            this.week.appendChild(outer);
        }

        CustomCalendar.prototype.drawEvents = function(day, element) {

           // if (day.month() === this.current.month()) {

                var todaysEvents = this.events.reduce(function(memo, ev) {
                    if (ev.date.isSame(day, 'day')) {
                        memo.push(ev);
                    }
                    return memo;
                }, []);

                todaysEvents.forEach(function(ev) {
                    var evSpan = createElement('span', ev.color);
                    element.appendChild(evSpan);
                });
            //}
        }


        CustomCalendar.prototype.getDayClass = function(day) {
            classes = ['day'];
            if (day.month() !== this.current.month()) {
                classes.push('other');
            } else if (today.isSame(day, 'day')) {
                classes.push('today');
            }
            // if (day.isBefore(moment(), 'day')) {
            //   classes.push('disabled');
            // }
            return classes.join(' ');
        }

        CustomCalendar.prototype.openDay = function(el) {
            var details, arrow;
            var dayNumber = +el.querySelectorAll('.day-number')[0].innerText || +el.querySelectorAll('.day-number')[0].textContent;
            var day = this.current.clone().date(dayNumber);
            // renderCalendar(day.format('Y-MM-DD HH:mm:ss'));
            var currentOpened = document.querySelector('.details');


            //Check to see if there is an open detais box on the current row
            if (currentOpened && currentOpened.parentNode === el.parentNode) {
                details = currentOpened;
                arrow = document.querySelector('.arrow');
            } else {
                //Close the open events on differnt week row
                //currentOpened && currentOpened.parentNode.removeChild(currentOpened);
                if (currentOpened) {
                    currentOpened.addEventListener('webkitAnimationEnd', function() {
                        currentOpened.parentNode.removeChild(currentOpened);
                    });
                    currentOpened.addEventListener('oanimationend', function() {
                        currentOpened.parentNode.removeChild(currentOpened);
                    });
                    currentOpened.addEventListener('msAnimationEnd', function() {
                        currentOpened.parentNode.removeChild(currentOpened);
                    });
                    currentOpened.addEventListener('animationend', function() {
                        currentOpened.parentNode.removeChild(currentOpened);
                    });
                    currentOpened.className = 'details out';
                }

                //Create the Details Container
                details = createElement('div', 'details in');

                //Create the arrow
                var arrow = createElement('div', 'arrow');

                //Create the event wrapper

                details.appendChild(arrow);
                el.parentNode.appendChild(details);
            }

            var todaysEvents = this.events.reduce(function(memo, ev) {
                if (ev.date.isSame(day, 'day')) {
                    memo.push(ev);
                }
                return memo;
            }, []);

            this.renderEvents(todaysEvents, details);

            arrow.style.left = el.offsetLeft - el.parentNode.offsetLeft + 27 + 'px';
        }

        CustomCalendar.prototype.renderEvents = function(events, ele) {
            $(".day").on('click', function() {
                $(".day.active").removeClass("active");
                $(this).addClass("active");
                //$('.day.today').removeClass("today");
            });

            //Remove any events in the current details element
            var currentWrapper = ele.querySelector('.events');
            var wrapper = createElement('div', 'events in' + (currentWrapper ? ' new' : ''));

            events.forEach(function(ev) {
                var div = createElement('div', 'event');
                var square = createElement('div', 'event-category ' + ev.color);
                var span = createElement('span', '', ev.eventName);

                div.appendChild(square);
                div.appendChild(span);
                wrapper.appendChild(div);
            });

            if (!events.length) {
                var div = createElement('div', 'event empty');
                var span = createElement('span', '', 'No Events');

                div.appendChild(span);
                wrapper.appendChild(div);
            }

            if (currentWrapper) {
                currentWrapper.className = 'events out';
                currentWrapper.addEventListener('webkitAnimationEnd', function() {
                    currentWrapper.parentNode.removeChild(currentWrapper);
                    ele.appendChild(wrapper);
                });
                currentWrapper.addEventListener('oanimationend', function() {
                    currentWrapper.parentNode.removeChild(currentWrapper);
                    ele.appendChild(wrapper);
                });
                currentWrapper.addEventListener('msAnimationEnd', function() {
                    currentWrapper.parentNode.removeChild(currentWrapper);
                    ele.appendChild(wrapper);
                });
                currentWrapper.addEventListener('animationend', function() {
                    currentWrapper.parentNode.removeChild(currentWrapper);
                    ele.appendChild(wrapper);
                });
            } else {
                ele.appendChild(wrapper);
            }
        }

        CustomCalendar.prototype.drawLegend = function() {
            var legend = createElement('div', 'legend');
            var calendars = this.events.map(function(e) {
                return e.calendar + '|' + e.color;
            }).reduce(function(memo, e) {
                if (memo.indexOf(e) === -1) {
                    memo.push(e);
                }
                return memo;
            }, []).forEach(function(e) {
                var parts = e.split('|');
                var entry = createElement('span', 'entry ' + parts[1], parts[0]);
                legend.appendChild(entry);
            });
            this.el.appendChild(legend);
        }

        CustomCalendar.prototype.nextMonth = function(gotoDate = true,setdate = false) {
            this.current.add('months', 1);
            this.next = true;
            if(gotoDate){
                //setMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                this.draw();
                date = moment(this.current.format('Y-MM-DD HH:mm:ss')).format('YYYY-MM-DD');
                calendarObj.gotoDate(date);
                calendarObj.render();
                setNextPrevMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                calendarObj.render();
            }else{
                //setMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                this.draw();
                setNextPrevMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                this.draw();
            }
        }

        CustomCalendar.prototype.prevMonth = function(gotoDate = true,setdate = false) {
            this.current.subtract('months', 1);
            this.next = false;

            if(gotoDate){
                //setMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                this.draw();
                date = moment(this.current.format('Y-MM-DD HH:mm:ss')).format('YYYY-MM-DD');
                calendarObj.gotoDate(date);
                calendarObj.render();
                setNextPrevMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                calendarObj.render();
            }else{
                //setMonthData(this.current.format('Y-MM-DD'),this.current.endOf('month').format('YYYY-MM-D'));
                this.draw();
                setNextPrevMonthData(this.current.format('Y-MM-DD'),this.current.endOf('month').format('YYYY-MM-D'));
                this.draw();
            }
        }

        window.Calendar = CustomCalendar;
        var data = [];
        CustomCalendar = new Calendar('.calendar', data,new Date().toISOString().slice(0, 10));
        function createElement(tagName, className, innerText) {
            var ele = document.createElement(tagName);
            if (className) {
                ele.className = className;
            }
            if (innerText) {
                ele.innderText = ele.textContent = innerText;
            }
            return ele;
        }
        }();

        let cdata = [];

        // set calendar for curent month
        setMonthData(new Date().toISOString().slice(0, 10));

        function setMonthData(date=null,startFrom=null) {
            var firstdate = dateArray[0];
            var lastdate = dateArray[dateArray.length - 1];
            console.log(date+' || '+firstdate+' || '+lastdate)
            $.ajax({
                dataType: 'json',
                url: "{{route('get-operator-booking-by-month')}}",
                method: "post",
                data: {'date':date,'firstdate' : firstdate,'lastdate':lastdate},
                async: true,
                success: function (res) {
                    console.log('res month: '+res);
                    if(res.status == true){
                        cdata = res.data;
                        setCalendar(res.data,date);
                        if(startFrom != null){
                            $("[data-caldate='" + startFrom +"']:not(.today)").addClass('active');
                        }
                    }else{
                    }
                }
            });
            return true;
        }

        function setNextPrevMonthData(date=null,startFrom=null) {
            $(".loader2").css("display", "block");
            setTimeout(function(){
                var firstdate = dateArray[0];
                var lastdate = dateArray[dateArray.length - 1];
                console.log(date+' || '+firstdate+' || '+lastdate);
                $.ajax({
                    dataType: 'json',
                    url: "{{route('get-operator-booking-by-month')}}",
                    method: "post",
                    data: {'date':date,'firstdate' : firstdate,'lastdate':lastdate},
                    async: true,
                    success: function (res) {
                        if(res.status == true){
                            cdata = res.data;
                            $(".loader2").css("display", "none");
                            setCalendar(res.data,date);
                            if(startFrom != null){
                                $("[data-caldate='" + startFrom +"']:not(.today)").addClass('active');
                            }
                        }else{
                        }
                    }
                });
                return true;
            },3000);
        }

        function setCalendar(res,Mdate) {
            var data = res.map((event)=>{
                return {eventName:`${event.title}`,date:moment(`${event.start}`),color:'green'};
            });
            if($(".calendar").html() != "") {
                $(".calendar").html('');
            }
            CustomCalendar = new Calendar('.calendar', data,Mdate);
        }


        function syncDate(date,type){
            var str = date;
            var dateobj = moment(str);
            var selectedDate = dateobj.format('YYYY-MM-D');
            var selectedDatePrev = dateobj.endOf('month').format('YYYY-MM-D');
            var selectedDateNext = dateobj.startOf('month').format('YYYY-MM-D');
            if(type == 'prev' && selectedDate == selectedDatePrev){
                CustomCalendar.prevMonth(false,selectedDate);
            }else if(type == 'next' && selectedDate == selectedDateNext){
                CustomCalendar.nextMonth(false,selectedDate);
            }
            $(".day.active").removeClass("active");
            $("[data-caldate='" + selectedDate +"']").addClass('active');

        }
        $(document).on("click", ".day" , function() {
            var dayNumber = this.querySelectorAll('.day-number')[0].innerText || +el.querySelectorAll('.day-number')[0].textContent;
            var day = CustomCalendar.current.clone().date(dayNumber);
            selectedDate = moment($(this).find('input').val(), 'YYYY-MM-D').format('Y-MM-DD HH:mm:ss');
            renderCalendar(selectedDate);
            // renderCalendar(day.format('Y-MM-DD HH:mm:ss'));
            $(".day.active").removeClass("active");
            $(this).addClass("active");
        });

        // full calendar

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
                .userAgent)) {
            initialViews = 'timeGridDay';
        } else {
            initialViews = 'timeGridDay';
        }

        var calendarEl = document.getElementById('full-calender');
        var today = moment().day();
        fCalDate = today;

        var calendarObj = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: '',
                center: 'prev,title,next',
                right: 'timeGridDay'
            },
            slotEventOverlap:false,
            customButtons: {
                prev: {
                    text: '<',
                    click: function() {
                        calendarObj.prev();
                        let selectedDate =calendarObj.getDate().toISOString();
                        syncDate(selectedDate,'prev');
                    }
                },
                next: {
                    text: '>',
                    click: function() {
                        calendarObj.next();
                        let selectedDate =calendarObj.getDate();
                        syncDate(selectedDate,'next');
                    }
                }
            },
            locale:'{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
            initialView: initialViews,
            editable: true,
            selectable: true,
            unselectAuto: true,
            eventOverlap: false,
            slotDuration: '00:30',
            allDaySlot: true,
            eventStartEditable: false,
            eventDurationEditable: false,
            slotLabelInterval: "01:00",
            longPressDelay: 0,
            // eventClick: function(info) {
            //     info.jsEvent.preventDefault();
            //     alert('Event: ' + info.event.extendedProps.date);
            //     console.log(info);

            // },
            eventContent: function(arg, createElement) {
                var innerText = arg.event.title;
                var innerproductCode = arg.event.product_code;

                let htmldata = `<div class="main-event-div">
                    <i class="event-title">${innerText}</i>`;
                    console.log(arg.event.extendedProps.id);
                    if(arg.event.extendedProps.id != 0){
                        htmldata+=`<div class="btns-group">`;

                            if(arg.event.extendedProps.isReservation == 1){
                                htmldata+=`<a href="javascript:void(0)" class="action-info text-white" data-place_id="${arg.event.extendedProps.place_id}" data-date="${arg.event.extendedProps.date}" data-start_time=${arg.event.extendedProps.start_time} data-end_time=${arg.event.extendedProps.end_time}  data-time="${arg.timeText}" data-product_id="${arg.event.extendedProps.product_id}" data-all_day="${arg.event.extendedProps.all_day}" data-id="${arg.event.extendedProps.id}"><i class="las la-info-circle"></i></a>`;
                            }
                            else if(arg.event.title == 'Rezdy Integration') {
                                htmldata+=`<span>The rezdy schedule cannot be changed</span>`;
                            }
                            else{
                                htmldata+=`<a href="javascript:void(0)" class="action-info text-white"  data-date="${arg.event.extendedProps.date}" data-start_time=${arg.event.extendedProps.start_time} data-end_time=${arg.event.extendedProps.end_time}  data-time="${arg.timeText}" data-product_id="${arg.event.extendedProps.product_id}" data-all_day="${arg.event.extendedProps.all_day}" data-id="${arg.event.extendedProps.id}"><i class="las la-info-circle"></i></a>`;

                                htmldata+=`<a href="#" class="action-edit text-white" data-booking_availibility_id="${arg.event.extendedProps.booking_availibility_id}" data-show_edit_option="${arg.event.extendedProps.show_edit_option}" data-date="${arg.event.extendedProps.date}" data-product_id="${arg.event.extendedProps.product_id}" data-all_day="${arg.event.extendedProps.all_day}" data-id="${arg.event.extendedProps.id}"><i class="la la-edit"></i></a>`;

                                htmldata+=`<a href="#" class="action-delete text-white" data-recurring="${arg.event.extendedProps.recurring}" data-date="${arg.event.extendedProps.date}" data-all_day="${arg.event.extendedProps.all_day}" data-id="${arg.event.extendedProps.id}"><i class="la la-close"></i></a>`;
                            }

                        htmldata+=`</div>`;
                    }
                htmldata+=`</div>`;
                return {
                    html: htmldata
                }
            },
            events: {
                url: "{{route('get-operator-booking-by-day')}}"
            },
        });

        calendarObj.render();

        // full calendar load by day
        function renderCalendar(date){
            let new_date = moment(date).format('DD-MM-YYYY');
            date = moment(date).format('YYYY-MM-DD');
            $(".datepicker_auto_select").val(new_date);
            calendarObj.gotoDate(date);
            calendarObj.render();
        }

        $(document).on('click','.action-delete',function(e){
            // e.stopPropagation();
            var allday = $(this).attr('data-all_day');
            var id = $(this).attr('data-id');
            var date = $(this).attr('data-date');
            var is_recurring = $(this).attr('data-recurring')??0;
            if(allday == 'true'){
                let htlmData = `<ul class="text-left">
                        <li class="mt-2"><i class="las la-exclamation"></i><span class="text-danger">Warning</span>, if you have bookings already made for this time slot, by deleting you ensure no future bookings will be made, but it is your responsibility to contact existing bookings to organise refunds or rescheduling as you wish</li>
                        <li class="mt-2"><i class="las la-exclamation"></i><span class="text-danger">Warning</span>, pending confirmations for this booking will be deleted if there are any</li>
                    </ul>`
                    if(is_recurring == 1){
                        htlmData+= `</br></br>
                        <label for="delete_all_slots" class="m-0">
                        <input type="checkbox" value="1" id="delete_all_slots">
                        <span class="swal2-label">If you want delete all <span class="text-danger">recurring timeslots</span> related to this booking then please select this check box.</span>
                        </label>`;
                    }
                Swal.fire({
                    title: 'Are you sure?',
                    html:htlmData,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'

                    //
                }).then((result) => {
                    const recurring_all_delete = $("#delete_all_slots").prop('checked') == true ?? false;
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('delete_all_day_booking')}}",
                            type:"POST",
                            data: {id:id,date:date,allday:allday,recurring_all_delete},
                            dataType : "JSON",
                            success:function(result){
                                date = moment().format('YYYY-MM-DD');
                                setMonthData(date);
                                if(result.status == true){
                                    Swal.fire(result.message, '', 'success')
                                }else{
                                    Swal.fire(result.message, '', 'danger')
                                }
                            }
                        })
                    }
                })
            }else{
                let htlmData = `<ul class="text-left">
                        <li class="mt-2"><i class="las la-exclamation"></i><span class="text-danger">Warning</span>, if you have bookings already made for this time slot, by deleting you ensure no future bookings will be made, but it is your responsibility to contact existing bookings to organise refunds or rescheduling as you wish</li>
                        <li class="mt-2"><i class="las la-exclamation"></i><span class="text-danger">Warning</span>, pending confirmations for this booking will be deleted if there are any</li>
                    </ul>`
                    if(is_recurring == 1){
                        htlmData+= `</br></br>
                        <label for="delete_all_slots" class="m-0">
                        <input type="checkbox" value="1" id="delete_all_slots">
                        <span class="swal2-label">If you want delete all <span class="text-danger">recurring timeslots</span> related to this booking then please select this check box.</span>
                        </label>`;
                    }
                Swal.fire({
                    title: 'Are you sure?',
                    html:htlmData,
                    // html: 'Warning, you have bookings already made for this time slot, by deleting you ensure no new bookings will be made, but you must contact them yourself to arrange refunds',
                    icon: 'warning',
                    input: 'checkbox',
                    inputPlaceholder: 'If you want delete all timeslots related to this date then please select this check box.',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    const recurring_all_delete = $("#delete_all_slots").prop('checked') == true ?? false;
                    if (result.isConfirmed) {
                        if (result.value) {

                            $.ajax({
                                url: "{{route('delete_all_day_booking')}}",
                                type:"POST",
                                data: {id:id,date:date,allday:allday,alldelete:result.value,recurring_all_delete},
                                dataType : "JSON",
                                success:function(result){
                                    date = moment().format('YYYY-MM-DD');
                                    setMonthData(date);
                                    if(result.status == true){
                                        Swal.fire(result.message, '', 'success')
                                    }else{
                                        Swal.fire(result.message, '', 'danger')
                                    }
                                }
                            })
                        } else {
                            $.ajax({
                                url: "{{route('delete_all_day_booking')}}",
                                type:"POST",
                                data: {id:id,date:date,allday:allday,recurring_all_delete},
                                dataType : "JSON",
                                success:function(result){
                                    date = moment().format('YYYY-MM-DD');
                                    setMonthData(date);
                                    if(result.status == true){
                                        Swal.fire(result.message, '', 'success')
                                    }else{
                                        Swal.fire(result.message, '', 'danger')
                                    }
                                }
                            })
                        }
                    }
                })
            }
        })

        $(document).on('click', '.action-info', function(e) {
            // e.stopPropagation();
            $("#infoModal").modal('show');
            var allday = $(this).attr('data-all_day');
            var id = $(this).attr('data-product_id');
            var date = $(this).attr('data-date');
            var start_time = $(this).attr('data-start_time');
            var end_time = $(this).attr('data-end_time');

            $(".loader").css("display", "flex");
            $.ajax({
                type: "POST",
                url: "{{route('get_all_booking_data_by_time')}}",
                data: {id,date,allday,start_time,end_time},
                dataType: "JSON",
                success: function (response) {
                    $(".loader").css("display", "none");
                    if(response.status == true){
                        $("#detail_view_body").html(response.data.html);
                        $("#reservation_details").html(response.data.html_reservation);
                    }else{
                        toastr.error(response.data.message);
                    }
                }
            });

        });

    </script>

<script>
    $( document ).ready(function() {
        var firstOpen = true;
        var time;

        $(document).on('click','.unpaid',function(){

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to confirm this booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#72bf44',
                confirmButtonText: 'Yes, confirm it!',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.close();
                    var bookingid = $(this).attr('data-bookingid');
                    var placeid = $(this).attr('data-placeid');
                    $(".loader").css("display", "block");
                    $.ajax({
                        url: "{{ route('confirm_booking') }}",
                        method: "POST",
                        data: {
                            booking_id:bookingid,
                            place_id:placeid
                        },
                        success: function(data) {
                            $(".loader").css("display", "none");
                            if(data.status == true){
                                location.reload();
                            }else{
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            })
        });

        $('#timePicker').datetimepicker({
            format: "hh:mm A",
            allowInputToggle: true
        });

        $('#timePicker1').datetimepicker({
            format: "hh:mm A",
            allowInputToggle: true
        }).on('dp.change',function(){
            var starttime = $('#start_time').val();
            var startdt = moment(starttime, ["hh:mm A"]).format("HH:mm");
            var endtime = $('#end_time').val();
            var endtimedt = moment(endtime, ["hh:mm A"]).format("HH:mm");
            if(starttime != ''){
                $('#start_time-error').css('display','none');
                if(startdt > endtimedt){
                    toastr.warning("End Time must be greater than Start time");
                    $(this).val('');
                    return false;
                }
            }else{
                $('#start_time-error').css('display','block');
                $('#start_time').focus();
                $(this).val('');
                return false;
            }
        });

        $('.booking_note').on("keypress", function(evt){
            var words = this.value.split(/\s+/);
            var numWords = words.length;
            var maxWords = 10;
            if(numWords > maxWords){
            evt.preventDefault();
            }
        });

        $('.booking_note_check').on("keypress", function(evt){
            var words = this.value.split(/\s+/);
            var numWords = words.length;
            var maxWords = 10;
            if(numWords > maxWords){
            evt.preventDefault();
            }
        });

        $(".day").on('click', function() {
            $(".day.active").removeClass("active");
            $(this).addClass("active");
            $('.day.today').removeClass("today");
            //renderCalendar();
        })

        var i=0;
        $(document).on('click',".add-time-sloat",function() {
            var divlength = $('.timeslot_show').length + 1;
            var divcount = $('.timeslot_show').length;
            i++;
            //$(this).prev().append('<div class="sloat-items-ul timeslot_show appended-timeslot"><label>Time 0'+divlength+'</label><div class="sloat-items-li"><a href="javascript:;" class="remove-sloat"><i class="la la-times"></i></a><div class="sloat-flex"><div class="sloat-flex-div"><div class="sloat-items-grid"><div class="sloat-items"><input type="time" id="start_time_'+i+'" name="time_slot_val['+i+'][start_time]" class="custom-time-picker" /></div> <span>To</span><div class="sloat-items"><input type="time" id="end_time_'+i+'" name="time_slot_val['+i+'][end_time]" class="custom-time-picker" /></div></div></div><div class="sloat-flex-div border-left"><div class="max-input-div"><input type="text" class="input booking_note" name="time_slot_val['+i+'][booking_note]" placeholder="Enter Booking Note" /></div><div class="max-input-div"><input type="number" min="0" max="999" class="input" name="time_slot_val['+i+'][max_booking_no]" placeholder="Max Booking No." /></div></div></div></div></div>');
            if($('.timeslot_show').length > 1){
                $(this).prev().append('<div class="sloat-items-ul timeslot_show appended-timeslot"><label>Time 0'+divlength+'</label><div class="sloat-items-li"><a href="javascript:;" class="remove-sloat"><i class="la la-times"></i></a><div class="sloat-flex"><div class="sloat-flex-div"><div class="sloat-items-grid"><div class="input-group date" id="timePicker_'+divlength+'"><input type="text" class="form-control timePicker" name="time_slot_val['+divcount+'][start_time]" id="start_time_'+divcount+'" required><span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span></div><span>To</span><div class="input-group date" id="timePicker1_'+divlength+'"><input type="text" class="form-control timePicker" name="time_slot_val['+divcount+'][end_time]" id="end_time_'+divcount+'" required><span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span></div></div></div><div class="sloat-flex-div border-left"><div class="max-input-div"><input type="text" class="input booking_note" name="time_slot_val['+divcount+'][booking_note]" placeholder="Enter Booking Note" required/></div><div class="max-input-div"><input type="number" min="0" max="999" class="input" name="time_slot_val['+divcount+'][max_booking_no]" placeholder="Max Booking No." required/></div></div></div></div></div>');
            }else{
                $(this).prev().append('<div class="sloat-items-ul timeslot_show appended-timeslot"><label>Time 0'+divlength+'</label><div class="sloat-items-li"><a href="javascript:;" class="remove-sloat"><i class="la la-times"></i></a><div class="sloat-flex"><div class="sloat-flex-div"><div class="sloat-items-grid"><div class="input-group date" id="timePicker_'+divlength+'"><input type="text" class="form-control timePicker" name="time_slot_val['+i+'][start_time]" id="start_time_'+i+'" required><span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span></div><span>To</span><div class="input-group date" id="timePicker1_'+divlength+'"><input type="text" class="form-control timePicker" name="time_slot_val['+i+'][end_time]" id="end_time_'+i+'" required><span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span></div></div></div><div class="sloat-flex-div border-left"><div class="max-input-div"><input type="text" class="input booking_note" name="time_slot_val['+i+'][booking_note]" placeholder="Enter Booking Note" required/></div><div class="max-input-div"><input type="number" min="0" max="999" class="input" name="time_slot_val['+i+'][max_booking_no]" placeholder="Max Booking No." required/></div></div></div></div></div>');
            }


            $('.booking_note').on("keypress", function(evt){
                var words = this.value.split(/\s+/);
                var numWords = words.length;
                var maxWords = 10;
                if(numWords > maxWords){
                evt.preventDefault();
                }
            });

            $('#timePicker_'+divlength).datetimepicker({
                format: "hh:mm A",
                allowInputToggle: true
            })

            $('#timePicker1_'+divlength).datetimepicker({
                format: "hh:mm A",
                allowInputToggle: true
            })
        });
        $(document).on('click','.remove-sloat',function() {
            $(this).parent().prev().parent().remove()
        });
        let datedata = null;

        // event edit handler
        $(document.body).on('click', '.action-edit' ,function(event){
            event.preventDefault();
            $('.booking_detail_tab').addClass('d-none');
            $('.booking-availibility').removeClass('d-none');
            $('#booking-availibility-title').html('Add Booking Availability');
            datedata = $(this).data('date');
            let slot_id = $(this).data('id');
            let all_day = $(this).data('all_day');
            let show_edit_option = $(this).data('show_edit_option');
            let booking_availibility_id = $(this).data('booking_availibility_id');
            // alert(show_edit_option == true);
            let edit_product_id = $(this).data('product_id');
            var update_all = 0;
            // $("#product_id").val($(this).data('product_id')).trigger('change');
            if(show_edit_option == true){
                let htlmData = `<ul class="text-left">
                        <li class="mt-2"><i class="las la-exclamation"></i><span class="text-danger">Warning</span>, pending confirmations for this booking will be deleted if there are any</li>
                    </ul>`;
                Swal.fire({
                    html:htlmData,
                    icon: 'warning',
                    input: 'checkbox',
                    inputPlaceholder: 'If you want edit all timeslots related to this recurring slot then please select this check box.',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(result.value){
                            update_all = 1;
                        }
                        editProductAvailability(edit_product_id,slot_id,all_day,booking_availibility_id,update_all);
                        $('#booking_cut_off').focus();
                    }
                })
            }else{
                editProductAvailability(edit_product_id,slot_id,all_day,booking_availibility_id,update_all);
                $('#booking_cut_off').focus();
            }
            // editProductAvailability(edit_product_id,slot_id,all_day);
            $("#product_id").attr("style", "pointer-events: none;");
        });
        function editProductAvailability(product_id,slot_id=null,all_day=null,booking_availibility_id = null, update_all = null){
            $.ajax({
                url: "{{route('load_booking_data')}}",
                method: "POST",
                async: false,
                data: {
                    product_id,
                    date:datedata,
                    slot_id:slot_id,
                    all_day:all_day,
                    booking_availibility_id,
                    update_all,
                },
                success: function (data) {
                    $('.booking-availibility').html(data);
                }
            });
            $("#product_id").attr("style", "pointer-events: none;");
            datedata = null;
        }

        // event delete handler
        $(document.body).on('click', '.action-delete' ,function(event){
            event.preventDefault();
        });

        $(document).on('click', '#add_availability_btn' ,function(event){
            reqData = {product_id:null,date:null,mode:0};
            $.ajax({
                url: "{{route('load_booking_data')}}",
                method: "POST",
                async: false,
                data: reqData,
                success: function (data) {
                    $('.booking-availibility').html(data);
                }
            });
            datedata = null;

        });

        // $(document).on('change','#product_id',function(){ // remove edit mode on product selection
        //     var productid = $(this).val();
        //     $.ajax({
        //         url: "{{route('load_booking_data')}}",
        //         method: "POST",
        //         async: false,
        //         data: {product_id:productid,date:datedata},
        //         success: function (data) {
        //             $('.booking-availibility').html(data);
        //         }
        //     });
        //     datedata = null;
        // });

        $(document).on('submit','#add_booking_availibility_frm',function (event) {
            // e.stopPropagation();
            event.preventDefault();
            if($('#product_id').val() == ''){
                $('#product_id-error').css('display','block');
                $('#product_id').focus();
                return;
            }else{
                $('#product_id-error').css('display','none');
            }
            if(!$("#edit_mode").val()){
                if($("#recurring").prop('checked') == false){
                    if($('#select-date1').val() == ''){
                        $('#date-error').css('display','block');
                        $('#select-date1').focus();
                        return;
                    }else{
                        $('#date-error').css('display','none');
                    }
                }else{
                    var fields = $("input[name='recurring_value[]']").serializeArray();
                    if (fields.length === 0)
                    {
                        document.getElementById("chk_option_error").style.visibility = "visible";
                        return false;
                    }
                    else
                    {
                        document.getElementById("chk_option_error").style.visibility = "hidden";
                    }
                    $('#date-error').css('display','none');
                    if($('#select-date2').val() == ''){
                        $('#available_from-error').css('display','block');
                        $('#available_from').focus();
                        return;
                    }else{
                        $('#available_from-error').css('display','none');

                    }
                    if($('#select-date3').val() == ''){
                        $('#available_to-error').css('display','block');
                        $('#available_to').focus();
                        return;
                    }else{
                        $('#available_to-error').css('display','none');
                    }
                }

                if($("#all-day").prop('checked') == false){
                    if($('#start_time').val() == ''){
                        $('#start_time-error').css('display','block');
                        $('#start_time').focus();
                        return;
                    }else{
                        $('#start_time-error').css('display','none');
                    }

                    if($('#end_time').val() == ''){
                        $('#end_time-error').css('display','block');
                        $('#end_time').focus();
                        return;
                    }else{
                        $('#end_time-error').css('display','none');
                    }

                    if($('#booking_note').val() == ''){
                        $('#booking_note-error').css('display','block');
                        return;
                    }else{
                        $('#booking_note-error').css('display','none');
                    }

                    if($('#max_booking_no').val() == ''){
                        $('#max_booking_no-error').css('display','block');
                        return;
                    }else{
                        $('#max_booking_no-error').css('display','none');
                    }
                }else{
                    if($('#booking_note_check').val() == ''){
                        $('#booking_note_check-error').css('display','block');
                        return;
                    }else{
                        $('#booking_note_check-error').css('display','none');
                    }

                    if($('#max_booking_no_check').val() == ''){
                        $('#max_booking_no_check-error').css('display','block');
                        return;
                    }else{
                        $('#max_booking_no_check-error').css('display','none');
                    }
                }
            }else{
                if($("#all_day_field").val() == 0){
                    if($('#start_time').val() == ''){
                        $('#start_time-error').css('display','block');
                        $('#start_time').focus();
                        return;
                    }else{
                        $('#start_time-error').css('display','none');
                    }

                    if($('#end_time').val() == ''){
                        $('#end_time-error').css('display','block');
                        $('#end_time').focus();
                        return;
                    }else{
                        $('#end_time-error').css('display','none');
                    }

                    if($('#booking_note').val() == ''){
                        $('#booking_note-error').css('display','block');
                        return;
                    }else{
                        $('#booking_note-error').css('display','none');
                    }

                    if($('#max_booking_no').val() == ''){
                        $('#max_booking_no-error').css('display','block');
                        return;
                    }else{
                        $('#max_booking_no-error').css('display','none');
                    }
                }else{
                    if($('#booking_note_check').val() == ''){
                        $('#booking_note_check-error').css('display','block');
                        return;
                    }else{
                        $('#booking_note_check-error').css('display','none');
                    }

                    if($('#max_booking_no_check').val() == ''){
                        $('#max_booking_no_check-error').css('display','block');
                        return;
                    }else{
                        $('#max_booking_no_check-error').css('display','none');
                    }
                }
                if($('#select-date1').val() == ''){
                    $('#date-error').css('display','block');
                    $('#select-date1').focus();
                    return;
                }else{
                    $('#date-error').css('display','none');
                }
            }

            if($('#booking_cut_off').val() == ''){
                $('#booking_cut_off-error').css('display','block');
                return;
            }else{
                $('#booking_cut_off-error').css('display','none');
            }
            if($('#max_child_per_room').val() == ''){
                $('#max_child_per_room-error').css('display','block');
                return;
            }else{
                $('#max_child_per_room-error').css('display','none');
            }
            if($('#max_adult_per_room').val() == ''){
                $('#max_adult_per_room-error').css('display','block');
                return;
            }else{
                $('#max_adult_per_room-error').css('display','none');
            }

            var formdata = $('#add_booking_availibility_frm').serializeArray();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                url: "{{route('add_booking_availibility')}}",
                method: "post",
                data: formdata,
                success: function (data) {
                    if(data.status == true){
                        toastr.success(data.message);
                        location.reload();
                    }else{
                        toastr.error(data.message);
                    }
                }
            });

        });
    });
    $(function() {

        $(".second-div.booking-li").hide()
        $(".week-days").hide()
        $(document).on('click','#recurring',function() {
            if ($(this).is(':checked')) {
                $(".second-div.booking-li").show();
                $(".col-xl-9.booking-li.first-div-li").removeClass('col-xl-9').addClass("col-xl-6");
                $(".week-days").show()
                $(".first-date").hide()
                $('#select-date1').val('');
                // $('#select-date2').val('');
                // $('#select-date3').val('');
            } else {
                $(".col-xl-6.booking-li.first-div-li").removeClass("col-xl-6").addClass('col-xl-9');
                $(".second-div.booking-li").hide()
                $(".week-days").hide()
                $(".first-date").show()
                $('#select-date1').val('');
            }
        });
        $(document).on('click','.check-all',function() {
            if ($(this).is(':checked')) {
                $(".sloat-items-grid").hide();
                $(".sloat-flex").addClass('d-block');
                $(".sloat-items-ul > label").hide();
                $(".remove-sloat").hide();
                $(".add-time-sloat").hide();
                $(".sloat-flex-div:last-child").removeClass('border-left');
                $('.appended-timeslot').hide();
                $('.all_day_checkbox').css('display','block');
                $('.timeslot_show').css('display','none');
            } else {
                $(".sloat-items-grid").show();
                $(".sloat-flex").removeClass('d-block');
                $(".sloat-items-ul > label").show();
                $(".remove-sloat").show();
                $(".add-time-sloat").show();
                $(".sloat-flex-div:last-child").addClass('border-left');
                $('.appended-timeslot').show();
                $('.all_day_checkbox').css('display','none');
                $('.timeslot_show').css('display','block');
            }
        });

        $('.optionBox').on('click', '.remove', function() {
            $(this).parent().remove();
        });


        $("#select-date1").datepicker({
            locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
            format: 'dd-mm-yyyy',
            autoclose: true,
            firstDay: 1,
            minDate: '<?php echo  date('d-m-Y H:i:s');?>',
        });
        $("#select-date2").datepicker({
            locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
            format: 'dd-mm-yyyy',
            autoclose: true,
            firstDay: 1,
            minDate: '<?php echo  date('d-m-Y H:i:s');?>'
        });
        $("#select-date3").datepicker({
            locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
            format: 'dd-mm-yyyy',
            autoclose: true,
            firstDay: 1,
            minDate: '<?php echo  date('d-m-Y H:i:s');?>'
        });
    });

    $(document).on('click', '.reservation-action-info', function(e) {
        // e.stopPropagation();
        $("#reservationInfoModal").modal('show');
        var reservation_id = $(this).attr('data-reservation_id');
        var user_id = $(this).attr('data-user_id');

        $(".loader").css("display", "flex");
        $.ajax({
            type: "POST",
            url: "{{route('get.reservation.details.at.operator')}}",
            data: { reservation_id: reservation_id, user_id: user_id },
            dataType: "JSON",
            success: function (response) {
                $(".loader").css("display", "none");
                if(response.status == true){
                    $("#reservation_detail_view_body").html(response.data.html);
                }else{
                    toastr.error(response.data.message);
                }
            }
        });

    });

    $(document).on('click', '.reservation-action-confirm', function(e) {

        Swal.fire({
                title: 'Are you sure?',
                text: "You want to confirm this reservation?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#72bf44',
                confirmButtonText: 'Yes, confirm it!',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.close();
                    var reservation_id = $(this).attr('data-reservation_id');
                    var user_id = $(this).attr('data-user_id');

                    $(".loader").css("display", "flex");
                    $.ajax({
                        type: "POST",
                        url: "{{route('get.reservation.confirm')}}",
                        data: { reservation_id: reservation_id, user_id: user_id },
                        dataType: "JSON",
                        beforeSend: function() {
                            $("#process"+reservation_id).show();
                            document.getElementById('reservation-to-confirm').style.pointerEvents = 'none';
                        },
                        success: function (response) {
                            $("#process"+reservation_id).hide();
                            $(".loader").css("display", "none");

                            //document.getElementById('reservation-to-confirm').style.pointerEvents = 'auto';
                            if(response.status == true){
                                toastr.success(response.data.message);
                                setTimeout(function(){ location.reload(); }, 3000);
                            }else{
                                toastr.error(response.data.message);
                            }
                        }
                    });
                }
            })
    });

    $(document).on('click', '.reservation-action-cancel', function(e) {

        Swal.fire({
                title: 'Are you sure?',
                text: "You want to cancel this reservation?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#72bf44',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.close();
                    var reservation_id = $(this).attr('data-reservation_id');
                    var user_id = $(this).attr('data-user_id');

                    $(".loader").css("display", "flex");
                    $.ajax({
                        type: "POST",
                        url: "{{route('get.reservation.cancel')}}",
                        data: { reservation_id: reservation_id, user_id: user_id },
                        dataType: "JSON",
                        beforeSend: function() {
                            $("#process"+reservation_id).show();
                            document.getElementById('reservation-to-confirm').style.pointerEvents = 'none';
                        },
                        success: function (response) {
                            $("#process"+reservation_id).hide();
                            $(".loader").css("display", "none");

                            if(response.status == true){
                                toastr.success(response.data.message);
                                setTimeout(function(){ location.reload(); }, 3000);
                            }else{
                                toastr.error(response.data.message);
                            }
                        }
                    });
                }
            })
    });
    $(document).on('click', '.ConfirmBtn', function(e) {
        if(!$(this).hasClass('active')){
            $(this).addClass('active');
            $('.toConfirmBtn').removeClass('active');
            $('.operator-toConfirm-table').addClass('d-none');
            $('.operator-confirmed-table').removeClass('d-none');
            $('.operator-booking-title').html('Confirmed');
            $('.operator-booking-weekbar').removeClass('d-none');

        }

    });
    $(document).on('click', '.toConfirmBtn', function(e) {
        if(!$(this).hasClass('active')){
            $(this).addClass('active');
            $('.ConfirmBtn').removeClass('active');
            $('.operator-toConfirm-table').removeClass('d-none');
            $('.operator-confirmed-table').addClass('d-none');
            $('.operator-booking-title').html('To Confirm');
            $('.operator-booking-weekbar').addClass('d-none');
        }

    });
    $(document).on('click', '.operator-weekbar-day', function(e) {
        if(!$(this).hasClass('active')){
            $('.operator-weekbar-day').removeClass('active');
            $(this).addClass('active');
        }
        let date = $(this).attr('data-day');
        $.ajax({
                url: `${app_url}/booking-get-confirmList`,
                type: 'POST',
                data: {
                    'date': date,
                },
                beforeSend: function () {
                    $(".operator-confirmed-table tbody").html('<div class="col-md-12 text-center">Loading...</div>');
                },
                success: function (data) {
                    $(".operator-confirmed-table tbody").html(data);
                },
                error: function (e) {
                    console.log(e);
                }
            });

    });
    $(document).on('click', '.operator-weekbar-pre', function(e) {

        let start_date = $(this).attr('data-day');
        let color = $(this).attr('data-color');
        let month = $(this).attr('data-month');
        $('.weekbar-mobile-title').html(month);
        $.ajax({
                url: `${app_url}/booking-get-previous-week`,
                type: 'POST',
                data: {
                    'date': start_date,
                    'color': color,
                },
                beforeSend: function () {
                    $(".operator-booking-weekbar").html('<div class="col-md-12 text-center">Loading...</div>');
                },
                success: function (data) {
                    $(".operator-booking-weekbar").html(data);
                },
                error: function (e) {
                    console.log(e);
                }
            });
    });

    $(document).on('click', '.operator-weekbar-next', function(e) {
        let end_date = $(this).attr('data-day');
        let color = $(this).attr('data-color');
        let month = $(this).attr('data-month');
        $('.weekbar-mobile-title').html(month);
        $.ajax({
                url: `${app_url}/booking-get-next-week`,
                type: 'POST',
                data: {
                    'date': end_date,
                    'color': color,
                },
                beforeSend: function () {
                    $(".operator-booking-weekbar").html('<div class="col-md-12 text-center">Loading...</div>');
                },
                success: function (data) {
                    $(".operator-booking-weekbar").html(data);
                },
                error: function (e) {
                    console.log(e);
                }
            });
    });

    $(document).on('click', '.slot-button .slot-detail', function(e) {
        let date = $(this).attr('data-date');
        let slot_id = $(this).attr('data-id');
        $('.booking_detail_tab').addClass('d-none');
        $('.booking-slot-detail').removeClass('d-none');
        $.ajax({
                url: `${app_url}/booking-slot-detail`,
                type: 'POST',
                data: {
                    'date': date,
                    'slot_id': slot_id,
                },
                beforeSend: function () {
                    $(".booking-slot-detail-body").html('<div class="col-md-12 text-center">Loading...</div>');
                },
                success: function (data) {
                    $(".booking-slot-detail-body").html(data);
                },
                error: function (e) {
                    console.log(e);
                }
            });
    });
    $(document).on('click', '.slot-detail-back', function(e) {
        $('.booking_detail_tab').removeClass('d-none');
        $('.booking-slot-detail').addClass('d-none');
    });
    $(document).on('click', '.add-avail-show', function(e) {
        $('.booking_detail_tab').addClass('d-none');
        $('.booking-availibility').removeClass('d-none');
        $('#booking-availibility-title').html('Add Booking Availability');
    });
    $(document).on('click', '.slot-edit-back', function(e) {
        $('.booking_detail_tab').removeClass('d-none');
        $('.booking-availibility').addClass('d-none');
    });
    $(document).on('click', '.slot-edit-btn', function(e) {
        $('.booking-slot-detail').addClass('d-none');
        $('.booking-availibility').removeClass('d-none');
        $('#booking-availibility-title').html('Edit Booking Availability');
    });


    </script>


@endpush
