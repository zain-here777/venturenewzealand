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
            <div class="container booking_detail_main_div_padding">
                <div class="booking_detail_main_div">
                    <div class="booking_detail_main_div_header">
                        <div class="booking_detail_main_div_title">
                            <span><i class="fas fa-exclamation"></i></span>
                            <span>{{__('    Booking Details')}}</span>
                        </div>
                        <div class="booking_detail_main_div_header_button">
                            <a href="{{ route('booking_history') }}">
                                <i class="fas fa-caret-left"></i>
                                <span style="margin-left: 5px;">{{__('  Back to My Bookings')}}</span>
                                <span style="margin-left: 5px;">{{__('  Back')}}</span>
                            </a>
                        </div>
                    </div>
                    <div class="booking_detail_main_div_content">
                        <div class="booking_detail_main_div_userinfo row">
                            <div class="col-lg-3 col-md-6 booking_detail_main_div_userbasic">
                                <div style="color: #72bf44;" class="booking_detail_main_div_subtitle">{{__('Basic Information')}} </div>
                                <div class="booking_detail_basicinfo_content">
                                    <div class="booking_detail_basicinfo_subcontent">
                                        <p>
                                            {{__('Full Name')}}
                                        </p>
                                        <div>
                                            {{$user_info->name}}
                                        </div>
                                    </div>
                                    <div class="booking_detail_basicinfo_subcontent">
                                        <p>
                                            {{__('Phone Number')}}
                                        </p>
                                        <div>
                                            {{$booking_order->phone_number}}
                                        </div>
                                    </div>
                                    <div class="booking_detail_basicinfo_subcontent">
                                        <p>
                                            {{__('Email')}}
                                        </p>
                                        <div>
                                            {{$booking_order->email}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-5 col-md-6 booking_detail_main_div_usernote">
                                <div style="color: #72bf44;" class="booking_detail_main_div_subtitle">
                                    {{$user_info->name}}{{__(' Notes')}}
                                </div>
                                <p style="font-style: italic;">{{__('What the operator needs to know')}}</p>
                                <p>
                                    @if($user_info->user_note == null)
                                        {{__('Please type your note!')}}
                                    @else
                                        {{$user_info->user_note}}
                                    @endif
                                </p>
                                <div class="booking_detail_add_usernote">
                                    <a id="open_usernote_modal" style="background-color: #72bf44; color: #FEFEFE;">
                                        <i class="fas fa-pen"></i>{{__('  Edit')}}
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 booking_detail_main_div_bookingsummary">
                                <div class="booking_detail_main_div_subtitle">
                                    {{__('Booking Summary')}}
                                </div>
                                <div>
                                    <div class="subSummary">
                                        <p>{{__('Subtotal:')}}</p>
                                        <span style="color: {{$booking_order->booking_order_items['0']->place->categories[0]->color_code}}">
                                            ${{cleanDecimalZeros($booking_order->payable_amount)}}
                                        </span>
                                    </div>
                                    <div class="subSummary" style="border-bottom: 1px solid #707070;">
                                        <p>{{ __('Transaction Fee') }} :</p>
                                        <span style="color: {{$booking_order->booking_order_items['0']->place->categories[0]->color_code}}">
                                            ${{ Config::get('app.stripe_user_charge') }}
                                        </span>
                                    </div>
                                    <div class="subSummary">
                                        <p style="font-weight: bold;">{{__('Total:')}}</p>
                                        <span style="color: {{$booking_order->booking_order_items['0']->place->categories[0]->color_code}}; font-weight: bold;">
                                            ${{number_format(cleanDecimalZeros($booking_order->payable_amount) + 0.30,2)}}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="booking_detail_main_div_product">
                            <div class="booking_detail_main_div_productinfo">
                                <div class="booking_detail_main_div_subtitle">{{__('Products:')}}</div>
                                    @php
                                        $final_total = 0;
                                    @endphp

                                    @foreach($booking_order->booking_order_items as $item)

                                    @if($item->place_product)

                                        @php
                                        $placeProduct =
                                        App\Models\PlaceProduct::query()->where('id',$item->place_product_id)->first();
                                        @endphp

                                        <div class="row">
                                            <div class="col-md-3 col-sm-2 col-2 booking_detail_img">
                                                <div class="booking_detail_cat">
                                                    <img src="{{ getCategoryIcon($item->place->categories[0]->icon_map_marker) }}"
                                                    alt="category">
                                                </div>
                                                <div class="booking_detail_thumb">
                                                    <img src="{{ getProductImageUrl($item->place_product->thumb) }}"
                                                     alt="payments">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-9 col-9 booking_detail_con">
                                                <div class="booking_detail_prodata">
                                                    <div class="booking_detail_place" style="color: {{ $item->place->categories[0]->color_code }};">
                                                        {{$item->place->name}}
                                                    </div>
                                                    <div class="booking_detail_product" style="color: {{ $item->place->categories[0]->color_code }};">
                                                        {{$item->place_product->name}}
                                                    </div>
                                                    <div class="booking_detail_proDescription_tablet">
                                                        {{$item->place_product->description}}
                                                    </div>
                                                    <div class="booking_detail_time">
                                                        <span>{{__('Booking Date & Time:')}}</span>
                                                        <span style="color: {{ $item->place->categories[0]->color_code }};">
                                                            @php
                                                                echo dateFormat($item->booking_date) .' '. Carbon\Carbon::parse($item->booking_time)->format('h:i A');
                                                            @endphp
                                                        </span>
                                                    </div>
                                                    <div class="booking_detail_adultPrice">
                                                        <span>{{__('Adult:')}}</span>
                                                        <span title="Online Payment" style="color: {{ $item->place->categories[0]->color_code }}; font-weight:bold;">
                                                            @php
                                                            $total_adult = $item->number_of_adult;
                                                            $adult_unit_price = $item->price;
                                                            $adult_total_price = $total_adult * $adult_unit_price;
                                                                echo '$' . $adult_unit_price;
                                                            @endphp
                                                        </span>
                                                        <span style="padding-left: 15px;">
                                                            @php
                                                            if($item->place->categories[0]->slug == 'stay'){
                                                                echo '(x' . $total_adult . ' (Nights))';
                                                            }elseif($item->place->categories[0]->slug == 'rent'){
                                                                echo '(x' . $total_adult . ' (Days))';
                                                            }else{
                                                                echo '(x' . $total_adult . ')';
                                                            }
                                                            @endphp
                                                        </span>
                                                    </div>
                                                    <div class="booking_detail_childPrice">
                                                        <span>{{__('Child:')}}</span>
                                                        <span title="Online Payment" style="color: {{ $item->place->categories[0]->color_code }}; font-weight:bold;">
                                                            @php
                                                            $total_children = $item->number_of_children;
                                                            $child_unit_price = getRezdyPrice($item, $item->child_price, 'child');
                                                            $child_total_price = $total_children * $child_unit_price;
                                                            echo '$' . $child_unit_price;
                                                            @endphp
                                                        </span>
                                                        <span style="padding-left: 15px;">
                                                            {{__('(x')}}{{$total_children}}{{__(')')}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 booking_detail_proDescription">
                                                {{$item->place_product->description}}
                                            </div>
                                            <div class="col-lg-2 booking_detail_subTotal">
                                                @php
                                                    $total_car = ($item->number_of_car != NULL) ? $item->number_of_car : 0;
                                                    $car_unit_price = ($item->car_price != NULL) ? $item->car_price : 0;
                                                    $car_total_price = $total_car * $car_unit_price;
                                                @endphp
                                                <span>{{__('Subtotal:')}}</span>
                                                <span style="color: {{ $item->place->categories[0]->color_code }}; font-weight: bold;" >
                                                    @php
                                                        if($placeProduct->online_payment_required == 1) {
                                                        echo '<span title="Online Payment">$' . ($adult_total_price +
                                                            $child_total_price + $car_total_price) . '</span>';
                                                        $final_total = $final_total + $adult_total_price + $child_total_price + $car_total_price;
                                                        } else {
                                                        echo '<span title="Payment not required" style="color: orange;">$' .
                                                            ($adult_total_price + $child_total_price + $car_total_price) . '</span>
                                                        <p style="font-size: 11px; color: orange;">Payment not required</p>';
                                                        }
                                                    @endphp
                                                </span>
                                            </div>
                                        </div>
                                        <div class="booking_detail_main_div_productinfo_tablet row">
                                            <div class="col-md-6">
                                                <div class="booking_detail_time_tablet">
                                                    <span>{{__('Booking Date & Time:')}}</span>
                                                    <span style="color: {{ $item->place->categories[0]->color_code }};">
                                                        @php
                                                            echo dateFormat($item->booking_date) .' '. Carbon\Carbon::parse($item->booking_time)->format('h:i A');
                                                        @endphp
                                                    </span>
                                                </div>
                                                <div class="booking_detail_adultPrice_tablet">
                                                    <span>{{__('Adult:')}}</span>
                                                    <span title="Online Payment" style="color: {{ $item->place->categories[0]->color_code }}; font-weight:bold;">
                                                        @php
                                                        $total_adult = $item->number_of_adult;
                                                        $adult_unit_price = $item->price;
                                                        $adult_total_price = $total_adult * $adult_unit_price;
                                                            echo '$' . $adult_unit_price;
                                                        @endphp
                                                    </span>
                                                    <span style="padding-left: 15px;">
                                                        @php
                                                        if($item->place->categories[0]->slug == 'stay'){
                                                            echo '(x' . $total_adult . ' (Nights))';
                                                        }elseif($item->place->categories[0]->slug == 'rent'){
                                                            echo '(x' . $total_adult . ' (Days))';
                                                        }else{
                                                            echo '(x' . $total_adult . ')';
                                                        }
                                                        @endphp
                                                    </span>
                                                </div>
                                                <div class="booking_detail_childPrice_tablet">
                                                    <span>{{__('Child:')}}</span>
                                                    <span title="Online Payment" style="color: {{ $item->place->categories[0]->color_code }}; font-weight:bold;">
                                                        @php
                                                        $total_children = $item->number_of_children;
                                                        $child_unit_price = getRezdyPrice($item, $item->child_price, 'child');
                                                        $child_total_price = $total_children * $child_unit_price;
                                                        echo '$' . $child_unit_price;
                                                        @endphp
                                                    </span>
                                                    <span style="padding-left: 15px;">
                                                        {{__('(x')}}{{$total_children}}{{__(')')}}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="booking_detail_subTotal_tablet">
                                                    @php
                                                        $total_car = ($item->number_of_car != NULL) ? $item->number_of_car : 0;
                                                        $car_unit_price = ($item->car_price != NULL) ? $item->car_price : 0;
                                                        $car_total_price = $total_car * $car_unit_price;
                                                    @endphp
                                                    <span>{{__('Subtotal:')}}</span>
                                                    <span style="color: {{ $item->place->categories[0]->color_code }}; font-weight: bold;">
                                                        @php
                                                            if($placeProduct->online_payment_required == 1) {
                                                            echo '<span title="Online Payment">$' . ($adult_total_price +
                                                                $child_total_price + $car_total_price) . '</span>';
                                                            $final_total = $final_total + $adult_total_price + $child_total_price + $car_total_price;
                                                            } else {
                                                            echo '<span title="Payment not required" style="color: orange;">$' .
                                                                ($adult_total_price + $child_total_price + $car_total_price) . '</span>
                                                            <p style="font-size: 11px; color: orange;">Payment not required</p>';
                                                            }
                                                        @endphp
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                            </div>
                            <div class="booking_detail_main_div_bookingsummary_tablet">
                                <div class="booking_detail_main_div_subtitle">
                                    {{__('Booking Summary')}}
                                </div>
                                <div>
                                    <div class="subSummary">
                                        <p>{{__('Subtotal:')}}</p>
                                        <span style="color: {{$booking_order->booking_order_items['0']->place->categories[0]->color_code}}">
                                            ${{cleanDecimalZeros($booking_order->payable_amount)}}
                                        </span>
                                    </div>
                                    <div class="subSummary" style="border-bottom: 1px solid #707070;">
                                        <p>{{ __('Transaction Fee') }} :</p>
                                        <span style="color: {{$booking_order->booking_order_items['0']->place->categories[0]->color_code}}">
                                            ${{ Config::get('app.stripe_user_charge') }}
                                        </span>
                                    </div>
                                    <div class="subSummary">
                                        <p style="font-weight: bold;">{{__('Total:')}}</p>
                                        <span style="color: {{$booking_order->booking_order_items['0']->place->categories[0]->color_code}}; font-weight: bold;">
                                            ${{number_format(cleanDecimalZeros($booking_order->payable_amount) + 0.30,2)}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="booking_detail_main_div_needtoknow">
                                <div class="booking_detail_main_div_subtitle">
                                    {{$operator->name}}{{__(' Notes')}}
                                </div>
                                <div>
                                    <p style="font-style: italic;">{{__('What the user needs to know')}}</p>
                                    <p>
                                        @if($user_info->user_note == null)
                                            {{__('No note!')}}
                                        @else
                                            {{$booking_order->booking_order_items['0']->place->needtobring}}
                                        @endif
                                    </p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .site-content -->
</main><!-- .site-main -->


<div class="modal fade" id="add_user_note_modal" tabindex="-1" role="dialog"
    aria-labelledby="add_user_note_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel">{{ __('User Note') }}</h2>
                <button type="button" class="close close-btn-event-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('booking_usernote') }}" method="post" enctype="multipart/form-data" data-parsley-validate>
                @method('put')
                @csrf
                <div class="modal-body" style="padding: 10px 0;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_note">Type here.
                                    </label>
                                @php
                                if($user_info->user_note != null) {
                                    $usernote_val = $user_info->user_note;
                                } else {
                                    $usernote_val = "";
                                }
                                @endphp
                                <textarea class="form-control" name="user_note" id="user_note" rows="10">{{ $usernote_val }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="submit_edit_country">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                <button type="button" class="btn btn-default close-btn-event-modal" data-dismiss="modal">{{ __('Close') }}</button>
                <a href="{{route('cancel_subscription')}}" class="btn">{{ __('Cancel Subscription') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="plan_feature" tabindex="-1" role="dialog" aria-labelledby="plan_feature" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel"><img
                        src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                        alt="logo"></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body member-wrap mb-0">

                @if(isOperatorUser())
                @include('frontend.common.plan_modal_body_operator')
                @else
                @include('frontend.common.plan_modal_body_user')
                @endif

            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                {{-- <button type="button" class="btn" data-dismiss="modal" data-toggle="modal"
                    data-target="#stripe_modal">Purchase Plan</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stripe_modal" tabindex="-1" role="dialog" aria-labelledby="stripe_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="payment-form" @if(isOperatorUser()) action="{{route('stripe_subscription')}}" @else
                action="{{route('stripe_charge')}}" @endif method="post">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><img
                            src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                            alt="logo"></h2>
                    <button type="button" class="close closefirstmodal" {{-- data-dismiss="modal" aria-label="Close"
                        --}}>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body member-wrap mb-0">
                    <h3>{{ __('Pay with card') }}
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
                                        <label for="email">{{ __('Name on Card') }}</label>
                                        <input type="text" id="card_name-stripe" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="field-input">
                                        <label for="email">{{ __('Email') }}</label>
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
                                                <label for="info">{{ __('Card Info') }}</label>
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
                    <button type="button" class="btn btn-default closefirstmodal" {{-- data-dismiss="modal"
                        --}}>{{ __('Close') }}</button>
                    <button type="submit" class="btn">{{ __('Pay') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@push('scripts')
    <script>
        $(document).on('click', '#open_usernote_modal', function(e) {
            // e.stopPropagation();
            $("#add_user_note_modal").modal('show');
        });

    </script>
@endpush
