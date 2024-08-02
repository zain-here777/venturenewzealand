@extends('frontend.layouts.template')
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


                <div class="container booking_detail_tab_div">
                    <div class="booking_detail_tab">
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        @php
                                            $book_url =  route('booking_list') . "?tab=calendar";
                                            $profile_url =  route('user_profile') . "?tab=prize";
                                        @endphp
                                        @if(!isUserAdmin())
                                        <a class="nav-item nav-link" id="nav-calendar-tab" href="{{ $book_url }}" aria-controls="nav-calendar" aria-selected="false">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Calendar.svg') }}"></span>
                                                <span><img class="active_icon" src="{{ asset('assets/images/booking/Calendar-white.svg') }}"></span>
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
                                        <a class="nav-item nav-link" id="nav-prize-tab" href="{{ $profile_url }}" aria-controls="nav-profile" aria-selected="true">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Prizes.svg') }}"></span>
                                                <span class="nav_title">Prizes</span>
                                            </div>
                                        </a>
                                        @endif
                                        <a class="nav-item nav-link" id="nav-profile-tab" href="{{ route('user_profile') }}" aria-controls="nav-profile" aria-selected="true">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/User.svg') }}"></span>
                                                <span><img class="active_icon" src="{{ asset('assets/images/booking/User-white.svg') }}"></span>
                                                <span class="nav_title">Profile</span>
                                            </div>
                                        </a>
                                        <a class="nav-item nav-link active" id="nav-company-tab" data-toggle="tab" href="#nav-companyInfo" role="tab" aria-controls="nav-company" aria-selected="true">
                                            <div style="display: flex; gap:10px;">
                                                <span><img class="inactive_icon" src="{{ asset('assets/images/booking/Card.svg') }}"></span>
                                                <span class="nav_title">Company Info</span>
                                            </div>
                                        </a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-companyInfo" role="tabpanel" aria-labelledby="nav-calendar-tab">
                                        <div class="member-place-wrap">
                                            <div class="member-place-top flex-inline">
                                                <!-- <h1>{{__('Place')}}</h1> -->
                                            </div><!-- .member-place-top -->
                                            @include('frontend.common.box-alert')
                                            <div class="member-filter">
                                                <div class="mf-left">
                                                    <form id="my_place_filter" action="" method="GET">
                                                        @if(request()->get('keyword'))
                                                            <input type="hidden" name="keyword" value="{{ (request()->get('keyword')) ? request()->get('keyword') : '' }}">
                                                        @endif
                                                        <div class="field-select">
                                                            <select class="my_place_filter" name="city_id">
                                                                <option value="">{{__('All districts')}}</option>
                                                                @foreach($cities as $city)
                                                                    <option value="{{$city->id}}" {{isSelected($city->id, $filter['city'])}}>{{$city->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <i class="la la-angle-down"></i>
                                                        </div>
                                                        <div class="field-select">
                                                            <select class="my_place_filter" name="category_id">
                                                                <option value="0">{{__('All categories')}}</option>
                                                                @foreach($categories as $cat)
                                                                    <option value="{{$cat->id}}" {{isSelected($cat->id, $filter['category'])}}>{{$cat->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <i class="la la-angle-down"></i>
                                                        </div>
                                                    </form>
                                                </div><!-- .mf-left -->
                                                <div class="mf-right">
                                                    <form action="" class="site__search__form" method="GET">
                                                        <div class="site__search__field">
                                                                <span class="site__search__icon">
                                                                    <i class="la la-search"></i>
                                                                </span><!-- .site__search__icon -->
                                                                @if(request()->get('city_id'))
                                                                <input type="hidden" name="city_id" value="{{ (request()->get('city_id')) ? request()->get('city_id') : '' }}">
                                                                @endif
                                                                @if(request()->get('category_id'))
                                                                <input type="hidden" name="category_id" value="{{ (request()->get('category_id')) ? request()->get('category_id') : '' }}">
                                                                @endif
                                                            <input class="site__search__input" type="text" name="keyword" value="{{$filter['keyword']}}" placeholder="{{__('Search')}}">
                                                        </div><!-- .search__input -->
                                                    </form><!-- .search__form -->

                                                    <a href="{{route('user_my_place')}}"><u>{{__('Clear Filter')}}</u></a>

                                                </div><!-- .mf-right -->
                                            </div><!-- .member-filter -->

                                            @if(count($places) == 0)
                                                <div class="text-right">
                                                    <a class="btn btn-default" href="{{ route('place_addnew') }}">{{ __('Add Company Information') }}</a>
                                                </div>
                                            @endif

                                            <table class="member-place-list table-responsive">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Thumb')}}</th>
                                                    <th>{{__('Place name')}}</th>
                                                    <th>{{__('District')}}</th>
                                                    <th>{{__('Category')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($places))
                                                    @foreach($places as $place)
                                                        <tr>
                                                            <td data-title=""></td>
                                                            <td data-title="ID">{{$place->id}}</td>
                                                            <td data-title="Thumb"><img src="{{getImageUrl($place->thumb)}}" alt="{{$place->name}}"></td>
                                                            <td data-title="Place name"><b>{{$place->name}}</b></td>
                                                            <td data-title="City">{{$place['city']['name']}}</td>
                                                            <td data-title="Category">
                                                                @foreach($place->categories as $cat)
                                                                    {{$cat->name}}
                                                                @endforeach
                                                            </td>
                                                            <td data-title="Status" class="{{STATUS[$place->status]}}">{{STATUS[$place->status]}}</td>
                                                            <td data-title="" class="place-action">
                                                                <a href="{{route('place_edit', $place->slug)}}" class="edit" title="{{__('Edit')}}"><i class="las la-edit"></i></a>
                                                                <a href="{{route('place_detail', $place->slug)}}" class="view" title="{{__('View')}}"><i class="la la-eye"></i></a>
                                                                @if($place->status !== \App\Models\Place::STATUS_DELETE)
                                                                    <a href="{{route('user_my_place_delete')}}" class="delete" title="{{__('Delete')}}" onclick="event.preventDefault(); if (confirm('are you sure?')) {document.getElementById('delete_my_place_form_{{$place->id}}').submit();}">
                                                                        <i class="la la-trash-alt"></i>
                                                                        <form class="d-none" id="delete_my_place_form_{{$place->id}}" action="{{route('user_my_place_delete')}}" method="POST">
                                                                            @method('delete')
                                                                            @csrf
                                                                            <input type="hidden" name="place_id" value="{{$place->id}}">
                                                                        </form>
                                                                    </a>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" class="text-center">
                                                            {{__('No item found')}}
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                            <div class="pagination align-left">
                                                {{$places->appends(["city_id" => $filter['city'], "category_id" => $filter['category'], "keyword" => $filter['keyword']])->render('frontend.common.pagination')}}
                                            </div><!-- .pagination -->
                                        </div><!-- .member-place-wrap -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop

@push('scripts')
    <script>
        $('.my_place_filter').change(function () {
            $('#my_place_filter').submit();
        });
    </script>
@endpush

