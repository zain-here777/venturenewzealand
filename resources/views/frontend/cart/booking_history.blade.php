@extends('frontend.layouts.template')
@section('main') <style>
    .booking-tabs{
        border-radius: 0;
    }
</style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/calender-main.min.css') }}" />
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
                    </div>
                </div>


                <div class="container booking_detail_tab_div">
                    <div class="booking_detail_tab">
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill booking-tabs " id="nav-tab" role="tablist">
                                        <a  class="nav-item nav-link active exclude-class2" id="nav-new-booking-tab" data-toggle="tab" href="#nav-new-booking" role="tab" aria-controls="nav-new-booking" aria-selected="true">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Scheduled.svg') }}"></span>
                                                <span><img class="active_icon" src="{{ asset('assets/images/booking/Scheduled-white.svg') }}"></span>
                                                <span class="nav_title">New Bookings</span>
                                            </div>
                                        </a>
                                        <a class="nav-item nav-link exclude-class2" id="nav-reservation-tab" data-toggle="tab" href="#nav-reservation" role="tab" aria-controls="nav-reservation" aria-selected="false">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Reservations.svg') }}"></span>
                                                <span><img class="active_icon" src="{{ asset('assets/images/booking/Reservations-white.svg') }}"></span>
                                                <span class="nav_title">Reservations</span>
                                            </div>
                                        </a>
                                        <a class="nav-item nav-link exclude-class2" id="nav-calendar-tab" data-toggle="tab" href="#nav-calendar" role="tab" aria-controls="nav-calendar" aria-selected="false">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Calendar.svg') }}"></span>
                                                <span><img class="active_icon" src="{{ asset('assets/images/booking/Calendar-white.svg') }}"></span>
                                                <span class="nav_title">My Calendar</span>
                                            </div>
                                        </a>
                                        <a class="nav-item nav-link exclude-class2" id="nav-old-booking-tab" data-toggle="tab" href="#nav-old-booking" role="tab" aria-controls="nav-old-booking" aria-selected="false">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Expired.svg') }}"></span>
                                                <span><img class="active_icon" src="{{ asset('assets/images/booking/Expired-white.svg') }}"></span>
                                                <span class="nav_title">Old Bookings</span>
                                            </div>
                                        </a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-new-booking" role="tabpanel" aria-labelledby="nav-new-booking-tab">
                                        <table id="UserNewBookingTable" class="table" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="category_th exclude-class3">{{__('Category')}}</th>
                                                    <th class="operator_th exclude-class3">{{__('Operator / Activity')}}</th>
                                                    <th class="date-time_th exclude-class3">{{__('Booking Date / Time')}}</th>
                                                    <th class="status_th exclude-class3">
                                                    <span class="exclude-class3">{{__('Status')}}</span>
                                                    </th>
                                                    <th class="directions_th exclude-class3">{{__('Directions')}}</th>
                                                    <th class="details_th exclude-class3">{{__('Details')}}</th>
                                        <th class="details_th exclude-class3 exclude-class3">{{__('Details')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if(count($booking_orders))
                                                    @foreach($booking_orders as $booking_order)
                                                        @php
                                                            $now = strtotime(date("Y-m-d h:i A"));
                                                            $bookingTimeDate = strtotime(dateFormat($booking_order->booking_date) .' '. Carbon\Carbon::parse($booking_order->booking_time)->format('h:i A'));
                                                        @endphp
                                                        @if( $bookingTimeDate >= $now)
                                                            <tr>
                                                                <td class="category_td">
                                                                    <div class="booking_table_category">
                                                                        @if (isset($arrCategory[trim($booking_order->place_category,'[""]')]['marker']))
                                                                        <img src="{{getCategoryIcon($arrCategory[trim($booking_order->place_category,'[""]')]['marker'])}}"
                                                                        >
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="operator_td">
                                                                    <div class="booking_table_activity">
                                                                        <div class="booking_place_thumb">
                                                                            <img src="{{getImageUrl($booking_order->place_thumb)}}" alt="{{$booking_order->name}}">
                                                                            <div class="booking_logo">
                                                                                @php
                                                                                    $logo = $booking_order->place_logo != null ? getImageUrl($booking_order->place_logo) : null;
                                                                                @endphp
                                                                                @if ($logo !== null)
                                                                                    <img src="{{$logo}}" alt="logo"/>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="booking_place_description">
                                                                            <div>
                                                                                <div class="booking_place_name">{{$booking_order->place_name}}</div>
                                                                                <div class="booking_place_cityname">
                                                                                    @if (isset($arrCities[$booking_order->place_city_id]))
                                                                                        {{ $arrCities[$booking_order->place_city_id] }}
                                                                                    @endif
                                                                                </div>
                                                                                <div class="booking_place_type">
                                                                                    @if($booking_order->place_type)
                                                                                        @php
                                                                                        $arrPlacetypeinput = explode('","', trim($booking_order->place_type, '[""]'));
                                                                                        @endphp
                                                                                        @foreach($arrPlacetypeinput as $index)
                                                                                            {{ $arrPlacetype[$index] }}
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="date-time_td">
                                                                    <div class="ckeck_inout_date">
                                                                        <p style="color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};">Check In:</p>
                                                                        <p>{{dateFormat($booking_order->booking_date) .' '. Carbon\Carbon::parse($booking_order->booking_time)->format('h:i A')}}</p>
                                                                    </div>
                                                                </td>
                                                                <td class="status_td">
                                                                    @if($booking_order->payment_intent_status=='succeeded')
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status paid">
                                                                            <span class="booking_status_icon"><i class="fas fa-check-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                    @elseif($booking_order->payment_intent_status=='pending')
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                            <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                    @else
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                            <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                    @endif
                                                                </td>
                                                                <td class="directions_td">
                                                                    <div>
                                                                        @php
                                                                            $google_map_url = "https://maps.google.com/?q=" . $booking_order->place_lat
                                                                                . "," . $booking_order->place_lng
                                                                                ."&ll=" . $booking_order->place_lat . "," . $booking_order->place_lng
                                                                                ."&z=16";
                                                                        @endphp
                                                                        <a class="booking_direction" target="_blank" href="{{$google_map_url}}"
                                                                        style="color: #FEFEFE; background-color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};">
                                                                            <span class="booking_direction_icon"><i class="fas fa-location-arrow"></i></span>
                                                                            <span class="booking_direction_letter">Directions</span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td class="details_td">
                                                                    <div class="status_inner_details">
                                                                        @if($booking_order->payment_intent_status=='succeeded')
                                                                            <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status paid">
                                                                                <span class="booking_status_icon"><i class="fas fa-check-square"></i></span>
                                                                                <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                            </p> <!-- paid unpaid pending -->
                                                                        @elseif($booking_order->payment_intent_status=='pending')
                                                                            <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                                <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                                <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                            </p> <!-- paid unpaid pending -->
                                                                        @else
                                                                            <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                                <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                                <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                            </p> <!-- paid unpaid pending -->
                                                                        @endif
                                                                    </div>
                                                                    <a href="{{route('booking_details',$booking_order->id)}}" class="btn booking_submit_btn" style="background-color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};">
                                                                        <span class="booking_view_icon"><i class="fas fa-exclamation"></i></span>
                                                                        <span class="booking_view_letter">{{__('View Details')}}</span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <tr><td colspan="8" style="text-align:center;width:100%;display: table-cell;">{{__('No Items')}}</td></tr>
                                                 @endif
                                            </tbody>
                                        </table>
                                        <button id="user_newbooking_print"><i class="fas fa-print"></i>{{__('  Print')}}</button>
                                    </div>
                                    <div class="tab-pane fade" id="nav-reservation" role="tabpanel" aria-labelledby="nav-reservation-tab" style="position: relative;">
                                        <table id="UserReservationTable" class="table" cellspacing="0">
                                            <thead>
                                                <tr>

                                                    <th class="category_th  exclude-class3">{{__('Category')}}</th>

                                                    <th class="operator_th exclude-class3">{{__('Operator / Activity')}}</th>
                                                    <th class="date-time_th exclude-class3">{{__('Booking Date / Time')}}</th>
                                                    <th class="status_th exclude-class3">
                                                    <span>{{__('Status')}}</span>
                                                    </th>
                                                    <th class="directions_th exclude-class3">{{__('Directions')}}</th>
                                                    <th class="details_th exclude-class3">{{__('Details')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($reservations))
                                                @foreach($reservations as $reservation)
                                                    <tr>
                                                        <td class="category_td">
                                                            <div class="booking_table_category">
                                                                @if (isset($arrCategory[trim($reservation->place_category,'[""]')]['marker']))
                                                                <img src="{{getCategoryIcon($arrCategory[trim($reservation->place_category,'[""]')]['marker'])}}"
                                                                 >
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="operator_td">
                                                            <div class="booking_table_activity">
                                                                <div class="booking_place_thumb">
                                                                    <img src="{{getImageUrl($reservation->place_thumb)}}" alt="{{$reservation->name}}">
                                                                    <div class="booking_logo">
                                                                        @php
                                                                            $logo = $reservation->place_logo != null ? getImageUrl($reservation->place_logo) : null;
                                                                        @endphp
                                                                        @if ($logo !== null)
                                                                            <img src="{{$logo}}" alt="logo"/>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="booking_place_description">
                                                                    <div>
                                                                        <div class="booking_place_name">{{$reservation->place_name}}</div>
                                                                        <div class="booking_place_cityname">
                                                                            @if (isset($arrCities[$reservation->place_city_id]))
                                                                                {{ $arrCities[$reservation->place_city_id] }}
                                                                            @endif
                                                                        </div>
                                                                        <div class="booking_place_type">
                                                                            @if($reservation->place_type)
                                                                                @php
                                                                                $arrPlacetypeinput = explode('","', trim($reservation->place_type, '[""]'));
                                                                                @endphp
                                                                                @foreach($arrPlacetypeinput as $index)
                                                                                    {{ $arrPlacetype[$index] }}
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="date-time_td">
                                                            <div class="ckeck_inout_date">
                                                                <p style="color: {{$arrCategory[trim($reservation->place_category,'[""]')]['color']}};">Check In:</p>
                                                                <p>{{dateFormat($reservation->date) .' '. Carbon\Carbon::parse($reservation->time)->format('h:i A')}}</p>
                                                            </div>
                                                        </td>
                                                        <td class="status_td">
                                                            @if($reservation->booking_status == 1)
                                                                <p style="text-transform: capitalize; color:#72bf44;" class="status paid">
                                                                    <span class="booking_status_icon"><i class="fas fa-check-square"></i></span>
                                                                    <span class="booking_status_letter">Confirmed</span>
                                                                </p>
                                                            @elseif($reservation->booking_status == 2)
                                                                <p style="text-transform: capitalize;" class="status pending">
                                                                    <span class="booking_status_icon"><i class="fas fa-question-square"></i></span>
                                                                    <span class="booking_status_letter">Pending</span>
                                                                </p>
                                                            @else
                                                                <p style="text-transform: capitalize; color:#AC1111; color: #FEFEFE;" class="status unpaid">
                                                                    <span class="booking_status_icon"><i class="fas fa-times"></i></span>
                                                                    <span class="booking_status_letter">Canceled</span>
                                                                </p>
                                                            @endif
                                                        </td>
                                                        <td class="directions_td">
                                                            @php
                                                                $google_map_url = "https://maps.google.com/?q=" . $reservation->place_lat
                                                                    . "," . $reservation->place_lng
                                                                    ."&ll=" . $reservation->place_lat . "," . $reservation->place_lng
                                                                    ."&z=16";
                                                            @endphp
                                                            <a class="booking_direction" target="_blank" href="{{$google_map_url}}"
                                                            style="color: #FEFEFE; background-color: {{$arrCategory[trim($reservation->place_category,'[""]')]['color']}};">
                                                                <span class="booking_direction_icon"><i class="fas fa-location-arrow"></i></span>
                                                                <span class="booking_direction_letter">Directions</span>
                                                            </a>
                                                        </td>
                                                        <td class="details_td">
                                                            <div class="status_inner_details">
                                                                @if($reservation->booking_status == 1)
                                                                    <p style="text-transform: capitalize; color:#72bf44;" class="status paid">
                                                                        <span class="booking_status_icon"><i class="fas fa-check-square"></i></span>
                                                                        <span class="booking_status_letter">Confirmed</span>
                                                                    </p>
                                                                @elseif($reservation->booking_status == 2)
                                                                    <p style="text-transform: capitalize;" class="status pending">
                                                                        <span class="booking_status_icon"><i class="fas fa-question-square"></i></span>
                                                                        <span class="booking_status_letter">Pending</span>
                                                                    </p>
                                                                @else
                                                                    <p style="text-transform: capitalize; color:#AC1111; color: #FEFEFE;" class="status unpaid">
                                                                        <span class="booking_status_icon"><i class="fas fa-times"></i></span>
                                                                        <span class="booking_status_letter">Canceled</span>
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <a href="javascript:void(0)" class="action-info btn booking_submit_btn" data-reservation_id="{{$reservation->id}}" data-user_id="{{$reservation->user_id}}" data-date="{{$reservation->date}}" data-time="{{$reservation->time}}">
                                                                <span class="booking_view_icon"><i class="fas fa-exclamation"></i></span>
                                                                <span class="booking_view_letter">{{__('View Details')}}</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <table id="UserReservationTable_detail" class="table d-none" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="category_th exclude-class3">{{__('Category')}}</th>
                                                    <th class="operator_th exclude-class3">{{__('Operator / Activity')}}</th>
                                                    <th class="date-time_th exclude-class3">{{__('Booking Date / Time')}}</th>
                                                    <th class="status_th exclude-class3">
                                                    <span>{{__('Status')}}</span>
                                                    </th>
                                                    <th class="directions_th exclude-class3">{{__('Directions')}}</th>

                                                    <th class="details_th exclude-class3">{{__('Details')}}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6">
                                                        <div id="reservation_detail">
                                                            <div class="reservation_detail_title">
                                                                <h3>Reservation Details</h3>
                                                                <button type="button" class="close" aria-label="Close" id="reservation_detail_close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div id="reservation_detail_content">

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-calendar" role="tabpanel" aria-labelledby="nav-calendar-tab">
                                        <table id="UserCalendarTable" class="table" cellspacing="0">
                                            <thead>
                                                <tr>

                                                    <th class="exclude-class3" style="text-align: end">Details</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        @if($isMembership)
                                                        <!--calender content-->
                                                            <div class="date-content-section">
                                                                <!--Full calader section-->
                                                                <div id="calendar_grid_div" class="row left-calender-grid">
                                                                    <div id="date-picker_div" class="col-xl-3 col-lg-4 col-md-6 left-calender-grid-li">
                                                                        <div class="date-picker">
                                                                            <div class="calendar"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="full-calendar_div" class="col-xl-9 col-lg-8 col-md-6 left-calender-grid-li">
                                                                        <div id="full-calender"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="date-picker_toggle">
                                                                    <button id="date-picker_hide"><i class="fas fa-caret-left"></i>{{__('  Hide')}}</button>
                                                                    <button id="date-picker_show"><i class="fas fa-caret-right"></i>{{__('  Show')}}</button>
                                                                </div>
                                                                {{-- <select id="selPeriod">
                                                                    <option value="day">Day</option>
                                                                    <option value="week">Week</option>
                                                                    <option value="month">Month</option>
                                                                </select> --}}
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table id="UserReservationTable_detail_calendar" class="table d-none" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="exclude-class3" style="text-align: end ">Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div id="reservation_detail">
                                                            <div class="reservation_detail_title">
                                                                <h3>Reservation Details</h3>
                                                                <button type="button" class="close" aria-label="Close" id="reservation_detail_close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div id="reservation_detail_content">

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-old-booking" role="tabpanel" aria-labelledby="nav-old-booking-tab">
                                        <table id="UserOldBookingTable" class="table" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="category_th exclude-class3">{{__('Category')}}</th>
                                                    <th class="operator_th exclude-class3">{{__('Operator / Activity')}}</th>
                                                    <th class="date-time_th exclude-class3">{{__('Booking Date / Time')}}</th>
                                                    <th class="status_th exclude-class3">
                                                    <span>{{__('Status')}}</span>
                                                    </th>
                                                    <th class="directions_th exclude-class3">{{__('Directions')}}</th>
                                                    <th class="details_th exclude-class3">{{__('Details')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($booking_orders))
                                                    @foreach($booking_orders as $booking_order)
                                                        @php
                                                            $now = strtotime(date("Y-m-d h:i A"));
                                                            $bookingTimeDate = strtotime(dateFormat($booking_order->booking_date) .' '. Carbon\Carbon::parse($booking_order->booking_time)->format('h:i A'));
                                                        @endphp
                                                        @if( $bookingTimeDate < $now)
                                                            <tr>
                                                                <td class="category_td">
                                                                    <div class="booking_table_category">
                                                                        @if (isset($arrCategory[trim($booking_order->place_category,'[""]')]['marker']))
                                                                        <img src="{{getCategoryIcon($arrCategory[trim($booking_order->place_category,'[""]')]['marker'])}}"
                                                                        >
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="operator_td">
                                                                    <div class="booking_table_activity">
                                                                        <div class="booking_place_thumb">
                                                                            <img src="{{getImageUrl($booking_order->place_thumb)}}" alt="{{$booking_order->name}}">
                                                                            <div class="booking_logo">
                                                                                @php
                                                                                    $logo = $booking_order->place_logo != null ? getImageUrl($booking_order->place_logo) : null;
                                                                                @endphp
                                                                                @if ($logo !== null)
                                                                                    <img src="{{$logo}}" alt="logo"/>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="booking_place_description">
                                                                            <div>
                                                                                <div class="booking_place_name">{{$booking_order->place_name}}</div>
                                                                                <div class="booking_place_cityname">
                                                                                    @if (isset($arrCities[$booking_order->place_city_id]))
                                                                                        {{ $arrCities[$booking_order->place_city_id] }}
                                                                                    @endif
                                                                                </div>
                                                                                <div class="booking_place_type">
                                                                                    @if($booking_order->place_type)
                                                                                        @php
                                                                                        $arrPlacetypeinput = explode('","', trim($booking_order->place_type, '[""]'));
                                                                                        @endphp
                                                                                        @foreach($arrPlacetypeinput as $index)
                                                                                            {{ $arrPlacetype[$index] }}
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="date-time_td">
                                                                    <div class="ckeck_inout_date">
                                                                        <p style="color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};">Check In:</p>
                                                                        <p>{{dateFormat($booking_order->booking_date) .' '. Carbon\Carbon::parse($booking_order->booking_time)->format('h:i A')}}</p>
                                                                    </div>
                                                                </td>
                                                                <td class="status_td">
                                                                    @if($booking_order->payment_intent_status=='succeeded')
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status paid">
                                                                            <span class="booking_status_icon"><i class="fas fa-check-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                        @elseif($booking_order->payment_intent_status=='pending')
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                            <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                        @else
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                            <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                    @endif
                                                                </td>
                                                                <td class="directions_td">
                                                                    @php
                                                                        $google_map_url = "https://maps.google.com/?q=" . $booking_order->place_lat
                                                                            . "," . $booking_order->place_lng
                                                                            ."&ll=" . $booking_order->place_lat . "," . $booking_order->place_lng
                                                                            ."&z=16";
                                                                    @endphp
                                                                    <a class="booking_direction" target="_blank" href="{{$google_map_url}}"
                                                                    style="color: #FEFEFE; background-color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};">
                                                                        <span class="booking_direction_icon"><i class="fas fa-location-arrow"></i></span>
                                                                        <span class="booking_direction_letter">Directions</span>
                                                                    </a>
                                                                </td>
                                                                <td class="details_td">
                                                                    <div class="status_inner_details">
                                                                        @if($booking_order->payment_intent_status=='succeeded')
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status paid">
                                                                            <span class="booking_status_icon"><i class="fas fa-check-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                        @elseif($booking_order->payment_intent_status=='pending')
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                            <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                        @else
                                                                        <p style="text-transform: capitalize; color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};" class="status unpaid">
                                                                            <span class="booking_status_icon"><i class="fas fa-square"></i></span>
                                                                            <span class="booking_status_letter">{{$booking_order->payment_intent_status}}</span>
                                                                        </p> <!-- paid unpaid pending -->
                                                                    @endif
                                                                    </div>
                                                                    <a href="{{route('booking_details',$booking_order->id)}}" class="btn booking_submit_btn" style="background-color: {{$arrCategory[trim($booking_order->place_category,'[""]')]['color']}};">
                                                                        <span class="booking_view_icon"><i class="fas fa-exclamation"></i></span>
                                                                        <span class="booking_view_letter">{{__('View Details')}}</span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <tr><td colspan="8" style="text-align:center;width:100%;display: table-cell;">{{__('No Items')}}</td></tr>
                                                 @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
    <div class="modal fade" id="cancel_subscription_warning" tabindex="-1" role="dialog" aria-labelledby="cancel_subscription_warning" aria-hidden="true">
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
            <a href="{{route('cancel_subscription')}}" class="btn">{{__('Cancel Subscription')}}</a>
          </div>
        </div>
      </div>
    </div>

    {{-- <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <tbody id="detail_view_body">
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
    </div> --}}

@stop
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/full-calender.js') }}"></script> --}}
    <script src="{{ asset('assets/js/calender-main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment-all.min.js') }}"></script>

    @if($isMembership)
    <script>
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
                    // var list;
                    // list = document.querySelectorAll(".day");
                    // for (var i = 0; i < list.length; ++i) {
                    //     list[i].classList.add('cf');
                    // }
                    self.nextMonth();

                });

                var left = createElement('div', 'left');
                left.addEventListener('click', function() {
                    // $(".day").on('click', function() {
                    //     $(".day.active").removeClass("active");
                    //     $(this).addClass("active")
                    // })
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

            this.events.forEach(function(ev) {
                //ev.date = self.current.clone().date(Math.random() * (29 - 1) + 1);
                //ev.date = moment();
                //console.log("ev.date ===>",ev.date)
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
                        // var list;
                        // list = document.querySelectorAll(".day");
                        // for (var i = 0; i < list.length; ++i) {
                        //     document.querySelector('.day.active').classList.remove('active');
                        //     list[i].classList.add('active');
                        // }

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
            var getday = dates.getDate();
            var getmonth = (dates.getMonth() + 1).toString().padStart(2, "0");
            var getyear = dates.getFullYear();
            var makedate = getyear+'-'+getmonth+'-'+getday;
            outer.setAttribute("data-caldate",makedate);

            //Day Name
            var name = createElement('div', 'day-name', day.format('ddd'));

            //Day Number
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

            if (day.month() === this.current.month()) {

                var todaysEvents = this.events.reduce(function(memo, ev) {
                    if (ev.date.isSame(day, 'day')) {
                        memo.push(ev);
                    }
                    return memo;
                }, []);

                todaysEvents.forEach(function(ev) {
                    var evSpan = createElement('span', ev.color);
                    evSpan.style = `background-color:${ev.color}`;
                    element.appendChild(evSpan);
                });
            }
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
                //var getdate = $('.day.active input').attr('value');
            });
            // console.log('$(this)');
            // alert($(this).find('.selected_date').val());

            // renderCalendar(this.currentDate);

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
            this.draw();
            if(gotoDate){
                setMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                this.draw();
                date = moment(this.current.format('Y-MM-DD HH:mm:ss')).format('YYYY-MM-DD');
                calendarObj.gotoDate(date);
                calendarObj.render();
            }else{
                setMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                this.draw();
            }
        }

        CustomCalendar.prototype.prevMonth = function(gotoDate = true,setdate = false) {
            this.current.subtract('months', 1);
            this.next = false;
            this.draw();
            if(gotoDate){
                setMonthData(this.current.format('Y-MM-DD'),this.current.startOf('month').format('YYYY-MM-D'));
                this.draw();
                date = moment(this.current.format('Y-MM-DD HH:mm:ss')).format('YYYY-MM-DD');
                calendarObj.gotoDate(date);
                calendarObj.render();
            }else{
                setMonthData(this.current.format('Y-MM-DD'),this.current.endOf('month').format('YYYY-MM-D'));
                this.draw();
            }
        }

        window.Calendar = CustomCalendar;

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


        function syncDate(date,type){
            var str = date;
            var dateobj = moment(str);
            var selectedDate = dateobj.format('YYYY-MM-D');
            var selectedDatePrev = dateobj.endOf('month').format('YYYY-MM-D');
            var selectedDateNext = dateobj.startOf('month').format('YYYY-MM-D');
            console.log(selectedDate);
            console.log(selectedDatePrev);
            console.log(selectedDateNext);
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
            renderCalendar(day.format('Y-MM-DD HH:mm:ss'));
            $(".day.active").removeClass("active");
            $(this).addClass("active");
        });

        // set calendar for curent month
        setMonthData(new Date().toISOString().slice(0, 10));

        function setMonthData(date=null,startFrom=null) {
            $.ajax({
                dataType: 'json',
                url: "{{route('get-booking-by-month')}}",
                method: "post",
                data: {'date' : date},
                async: true,
                success: function (res) {
                    if(res.status == true){
                        cdata = res.data;
                        setCalendar(res.data,date);
                        if(startFrom != null){
                            $("[data-caldate='" + startFrom +"']").addClass('active');
                        }
                    }else{
                    }
                }
            });
            return true;
        }

        function setCalendar(res, Mdate) {
            var data = res.map((event)=>{
                return {eventName:`${event.title}`,date:moment(`${event.start}`),color:`${event.color}`};
            });
           if($(".calendar").html() != "") {
             $(".calendar").html('');
            }
           CustomCalendar = new Calendar('.calendar', data, Mdate);
        }

        // function setDayData(date=null) {
        //     $.ajax({
        //         dataType: 'json',
        //         url: "{{route('get-booking-by-day')}}",
        //         method: "post",
        //         data: {'date' : date},
        //         async: true,
        //         success: function (res) {
        //             if(res.status == true){
        //                 cdata = res.data;
        //             }else{
        //             }
        //         }
        //     });
        //     return true;
        // }


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
                right: ''
            },
            slotEventOverlap:false,
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
            slotLabelInterval: "00:30",
            longPressDelay: 0,
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
            eventContent: function(arg) {

                /* return {
                    html: arg.event.title
                }; */
                let htmldata = `<div class="main-event-div">`;
                    // <i class="event-title">${arg.event.title}</i>
                    if(arg.event.extendedProps.isReservation == 1 && arg.event.extendedProps.reservationData.id != 0){
                        htmldata+=`
                        <div class="calendar-booking-info">
                            <div class="calendar-booking-cat">
                                <img src="${arg.event.extendedProps.category}"/>
                                <div class="calendar-booking-loc">
                                    <div>${arg.event.extendedProps.place_name}</div>
                                    <p>${arg.event.extendedProps.city_name}</p>
                                </div>
                            </div>
                            <div class="btns-group booking-info-icon">
                                <a class="booking_direction" target="_blank" href="${arg.event.extendedProps.google_map_url}"
                                    style="background-color: #FEFEFE; color:${arg.event.extendedProps.color_code};" title="Direction">
                                    <i class="fas fa-location-arrow"></i>
                                </a>
                                <a href="javascript:void(0)" class="action-info-calendar btn" data-title="${arg.event.title}"
                                style="background-color: #FEFEFE; color:${arg.event.extendedProps.color_code};"
                                title="View Details"
                                data-user_id="${arg.event.extendedProps.reservationData.user_id}"
                                data-place_id="${arg.event.extendedProps.reservationData.place_id}"
                                data-reservation_id="${arg.event.extendedProps.reservationData.reservation_id}"
                                data-date="${arg.event.extendedProps.reservationData.date}"
                                data-time="${arg.event.extendedProps.reservationData.time}"
                                data-address="${arg.event.extendedProps.reservationData.address}">
                                <i class="fas fa-exclamation"></i>
                                </a>
                            </div>
                        </div>
                        `;
                    }
                    if(!arg.event.extendedProps.isReservation){
                        htmldata+=`
                        <div class="calendar-booking-info">
                            <div class="calendar-booking-cat">
                                <img src="${arg.event.extendedProps.category}"/>
                                <div class="calendar-booking-loc">
                                    <div>${arg.event.extendedProps.place_name}</div>
                                    <p>${arg.event.extendedProps.city_name}</p>
                                </div>
                            </div>
                            <div class="btns-group booking-info-icon">
                                <a class="booking_direction" target="_blank" href="${arg.event.extendedProps.google_map_url}"
                                    style="background-color: #FEFEFE; color:${arg.event.extendedProps.color_code};" title="Direction">
                                    <i class="fas fa-location-arrow"></i>
                                </a>
                                <a href="${arg.event.extendedProps.detail_url}" class="btn"
                                style="background-color: #FEFEFE; color:${arg.event.extendedProps.color_code};"
                                title="View Details">
                                <i class="fas fa-exclamation"></i>
                                </a>
                            </div>
                        </div>
                        `;
                    }

                htmldata+=`</div>`;

                return {
                    html: htmldata
                }
            },
            events: {
                url: "{{route('get-booking-by-day')}}"
            }
        });
        console.log('cdata');
        console.log(cdata);
        calendarObj.render();

        function renderCalendar(date){

            let dataevents= [
                {
                title  : 'event1',
                start  : '2022-04-20 10:00:00'
                },
                {
                title  : 'event2',
                start  : '2022-04-23 11:00:00',
                },
                {
                title  : 'event3',
                start  : '2022-04-24 12:00:00',
                }
            ];
            date = moment(date).format('YYYY-MM-DD');
            calendarObj.gotoDate(date);
            calendarObj.render();
        }

        $(document).ready(function () {
            $('#UserNewBookingTable').DataTable({
                "dom": 'tpB',
                "pageLength": 4,
                "ordering": false,
                language: {
                    paginate: {
                    next: '<i class="fas fa-caret-right"></i>',
                    previous: '<i class="fas fa-caret-left"></i>'
                    }
                },
                buttons: [
                    {
                        extend: 'print',
                        title: 'New Bookings',
                        className: "print_newbooking_user",
                        filename: 'New Bookings',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                        }
                    }
                ]
            });
            $('#UserReservationTable').DataTable({
                "dom": 'tp',
                "pageLength": 4,
                "ordering": false,
                language: {
                    paginate: {
                    next: '<i class="fas fa-caret-right"></i>',
                    previous: '<i class="fas fa-caret-left"></i>'
                    }
                }
            });
            $('#UserOldBookingTable').DataTable({
                "dom": 'tp',
                "pageLength": 4,
                "ordering": false,
                language: {
                    paginate: {
                    next: '<i class="fas fa-caret-right"></i>',
                    previous: '<i class="fas fa-caret-left"></i>'
                    }
                }
            });
            $('.dataTables_length').addClass('bs-select');
        });

        $(document).on('click', '.action-info', function(e) {
            // e.stopPropagation();
            $("#UserReservationTable_wrapper").addClass('d-none');
            $("#UserReservationTable_detail").removeClass('d-none');
            $("#UserReservationTable_detail").addClass('show');
            // $("#infoModal").modal('show');
            var reservation_id = $(this).attr('data-reservation_id');
            var user_id = $(this).attr('data-user_id');
            var date = $(this).attr('data-date');
            var time = $(this).attr('data-time');

            $(".loader").css("display", "flex");
            $.ajax({
                type: "POST",
                url: "{{route('get.reservation.details')}}",
                data: { reservation_id: reservation_id, user_id: user_id, date: date, time: time },
                dataType: "JSON",
                success: function (response) {
                    $(".loader").css("display", "none");
                    if(response.status == true){
                        $(".show #reservation_detail_content").html(response.data.html);
                    }else{
                        toastr.error(response.data.message);
                    }
                }
            });

        });

        $(document).on('click', '.action-info-calendar', function(e) {
            // e.stopPropagation();
            $("#UserCalendarTable").addClass('d-none');
            $("#UserReservationTable_detail_calendar").removeClass('d-none');
            $("#UserReservationTable_detail_calendar").addClass('show');
            // $("#infoModal").modal('show');
            var reservation_id = $(this).attr('data-reservation_id');
            var user_id = $(this).attr('data-user_id');
            var date = $(this).attr('data-date');
            var time = $(this).attr('data-time');

            $(".loader").css("display", "flex");
            $.ajax({
                type: "POST",
                url: "{{route('get.reservation.details')}}",
                data: { reservation_id: reservation_id, user_id: user_id, date: date, time: time },
                dataType: "JSON",
                success: function (response) {
                    $(".loader").css("display", "none");
                    if(response.status == true){
                        $(".show #reservation_detail_content").html(response.data.html);
                    }else{
                        toastr.error(response.data.message);
                    }
                }
            });

        });

        $(document).on('click', '#reservation_detail_close', function(e) {
            // e.stopPropagation();
            if($("#UserReservationTable_detail").hasClass('show')){
                $("#UserReservationTable_detail").addClass('d-none');
                $("#UserReservationTable_detail").removeClass('show');
                $("#UserReservationTable_wrapper").removeClass('d-none');
            }
            if($("#UserReservationTable_detail_calendar").hasClass('show')){
                $("#UserReservationTable_detail_calendar").addClass('d-none');
                $("#UserReservationTable_detail_calendar").removeClass('show');
                $("#UserCalendarTable").removeClass('d-none');
            }
        });

        // $(document).on('change', '#selPeriod', function(e) {
        //     var period = $('#selPeriod').val();
        //     if (period == 'day') {
        //         $('.fc-timeGridDay-button').trigger('click');
        //     } else if (period == 'week') {
        //         $('.fc-timeGridWeek-button').trigger('click');
        //     } else {
        //         $('.fc-dayGridMonth-button').trigger('click');
        //     }
        // });
        $(document).on('click', '#user_newbooking_print', function(e) {
                $('.print_newbooking_user').trigger('click');
        });

        $(document).on('click', '#date-picker_hide', function(e) {
            $('#date-picker_hide').hide();
            $('#date-picker_show').show();
            $('#date-picker_div').hide();
            $('#calendar_grid_div').addClass('new-calender-grid');
            $('.fc-daygrid-body').addClass('new-calender-event-width');
            $('.fc .fc-scrollgrid-section-body table').addClass('new-calender-event-width');
            $('.fc-timegrid-body').addClass('new-calender-event-width');
            $('.fc-col-header').addClass('new-calender-event-width');
        });

        $(document).on('click', '#date-picker_show', function(e) {
            $('#date-picker_show').hide();
            $('#date-picker_hide').show();
            $('#date-picker_div').show();
            $('#calendar_grid_div').removeClass('new-calender-grid');
            $('.fc-daygrid-body').removeClass('new-calender-event-width');
            $('.fc .fc-scrollgrid-section-body table').removeClass('new-calender-event-width');
            $('.fc-timegrid-body').removeClass('new-calender-event-width');
            $('.fc-col-header').removeClass('new-calender-event-width');
        });

    </script>
    @endif
@endpush
