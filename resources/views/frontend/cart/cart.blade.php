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
                            <div class = "country_box_name">Shopping Cart</div>
                            <div class = "country_box_nz">New Zealand</div>
                        </div>
                    </div>
                    <div class="col-lg-8 country_box_desc" >
                        <!-- <div class="booking_box_avatar">
                            <img src="{{ getUserAvatar(user()->avatar) }}"
                                    alt="{{ Auth::user()->name }}">
                        </div> -->
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
                        <div class="cart-content">
                            <div class="cart-header" style="border-bottom-left-radius: 0px !important; border-bottom-right-radius: 0px !important;">
                                <div>
                                    <i class="fas fa-shopping-cart"></i>
                                    <div>{{ __('Shopping Cart') }}</div>
                                </div>
                            </div>
                            <div class="cart-body" style="border-top-left-radius: 0px !important; border-top-right-radius: 0px !important;">
                                @if($errors->any())
                                <div class="alert alert-danger p-2 m-0" role="alert">
                                    {{$errors->first()}}
                                </div>
                                @endif

                                <div class="clear-div">
                                    <div class="cart-body-ttl">
                                        {{ __('Shopping Cart List') }}
                                    </div>
                                    @if(count($cartItems))
                                    <a href="javascript:;" onclick="cartClearAll()">
                                        <i class="far fa-times"></i>
                                        Clear All
                                    </a>
                                    @endif
                                </div>
                                <div class="cart-table responsive-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>{{__('Category')}}</th>
                                                <th style="padding-left: 130px;">{{__('Operator')}}</th>
                                                <th>{{__('Booking Date/Time')}}</th>
                                                <th>{{__('Booking Details')}}</th>
                                                <th style="text-align: center;">{{__('Total')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </tr>
                                        </thead>
                                        @csrf
                                        @php
                                        $final_total = 0;
                                        @endphp
                                        @if(count($cartItems))
                                        @foreach($cartItems as $cartItem)
                                        <tr>
                                            <td class="cart-cat-td">
                                                <img src="{{getCategoryMakerUrl($cartItem->place->categories[0]->icon_map_marker)}}" alt="{{$cartItem->place->categories[0]->name}}">
                                            </td>
                                            <td class="cart-product-td">
                                                <div class="position-relative">
                                                    <a href="{{route('place_detail',['slug'=>$cartItem->place->slug])}}">
                                                        <img src="{{ getProductImageUrl($cartItem->place_product->thumb) }}"
                                                            alt="Product Image" class="tbl-img  responsive-image" />
                                                        {{-- <div class="cart-logo-div">
                                                            @php
                                                                $logo = $cartItem->place->logo != null ? getImageUrl($cartItem->place->logo) : null;
                                                            @endphp
                                                            @if ($logo !== null)
                                                            <img src="{{$logo}}" alt="logo" class="cart-logo">
                                                            @endif
                                                        </div> --}}
                                                    </a>
                                                    <div style="display: grid;">
                                                        <p class="cart-placename">
                                                            <a href="{{route('place_detail',['slug'=>$cartItem->place->slug])}}">{{$cartItem->place->translateOrDefault()->name ??'-'}}</a>
                                                        </p>
                                                        <p class="cart-cityname">
                                                            {{$cartItem->place_product->place->city->name}}
                                                        </p>
                                                        <p class="cart-pricingText" style="color: #72BF44;">( {{ $cartItem->place->categories[0]->pricing_text }} )</p>
                                                        <div class="cart-date-tablet">
                                                            <p>Booking Date/Time:</p>
                                                            <p>
                                                                @php
                                                                // if($cartItem->place->categories[0]->slug == 'stay' || $cartItem->place->categories[0]->slug == 'rent'){
                                                                //     if($cartItem->checkout_date != NULL){
                                                                //         echo dateFormat($cartItem->booking_date) .' - '. dateFormat($cartItem->checkout_date);
                                                                //     }else{
                                                                //         echo dateFormat($cartItem->booking_date);
                                                                //     }
                                                                // }else{
                                                                    echo dateFormat($cartItem->booking_date) .' '. Carbon\Carbon::parse($cartItem->booking_time)->format('h:i A');
                                                                //}
                                                                @endphp
                                                            </p>
                                                        </div>
                                                        <div class="cart-bookingnote" style="color: #72BF44;">
                                                            {{$cartItem->booking_note}}
                                                        </div>
                                                    </div>
                                                    <div class="cart-price-tablet">
                                                        <div class="cart-detail-tablet">
                                                            @if(($cartItem->place->categories->first()->slug == 'stay'))
                                                                @php
                                                                $startDate  = \Carbon\Carbon::parse($cartItem->booking_date);
                                                                $endDate    = \Carbon\Carbon::parse($cartItem->checkout_date);
                                                                $diffDay = $startDate->diff($endDate)->d ?? 1;
                                                                $days = $diffDay + 1;
                                                                if(checkIfOnDiscount($cartItem->place_product)) {
                                                                $adult_unit_price = checkIfOnDiscount($cartItem->place_product,true);
                                                                $adult_total_price = $cartItem->no_of_room * $adult_unit_price * $days;
                                                                } else {
                                                                $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                                                                $adult_total_price = $cartItem->no_of_room * $adult_unit_price * $days;
                                                                }

                                                                @endphp
                                                                <div>
                                                                    <div>Adults:{{$cartItem->number_of_adult ?? '-'}}</div>
                                                                    <div>Children:{{$cartItem->number_of_children ?? '-'}}</div>
                                                                    <div>{{$cartItem->no_of_room}} Rooms × {{$days}} Nights</div>
                                                                    <div>Price: ${{$adult_total_price}}</div>
                                                                </div>
                                                            @else

                                                                <div>
                                                                    @php
                                                                    $total_car = ($cartItem->number_of_car != NULL) ? $cartItem->number_of_car : 0;

                                                                    if(checkIfOnChildDiscount($cartItem->place_product)) {
                                                                    $car_unit_price = checkIfOnCarDiscount($cartItem->place_product,true);
                                                                    $car_total_price = $total_car * $car_unit_price;
                                                                    } else {
                                                                    $car_unit_price = cleanDecimalZeros($cartItem->place_product->car_price);
                                                                    $car_total_price = $total_car * $car_unit_price;
                                                                    }
                                                                    if($total_car > 0) {
                                                                    echo 'Vehicle: '. '<span title="Online Payment" style="color:' . $cartItem->place->categories[0]->color_code . '">$' . $car_unit_price . '</span>' . '      (x' . $total_car . ')' ;
                                                                    }
                                                                    @endphp
                                                                </div>
                                                                <div>
                                                                    @php
                                                                    $total_adult = $cartItem->number_of_adult;

                                                                    if(checkIfOnDiscount($cartItem->place_product)) {
                                                                    $adult_unit_price = checkIfOnDiscount($cartItem->place_product,true);
                                                                    $adult_total_price = $total_adult * $adult_unit_price;
                                                                    } else {
                                                                    $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                                                                    $adult_total_price = $total_adult * $adult_unit_price;
                                                                    }
                                                                    if($total_adult > 0) {
                                                                        if($cartItem->place->categories[0]->slug == 'stay'){
                                                                            echo $total_adult . ' (Nights) x ' . '<span title="Online Payment">$' . $adult_unit_price . ' =
                                                                            $' . $adult_total_price . '</span>';
                                                                        }elseif($cartItem->place->categories[0]->slug == 'rent'){
                                                                            echo $total_adult . ' (Days) x ' . '<span title="Online Payment">$' . $adult_unit_price . ' =
                                                                            $' . $adult_total_price . '</span>';
                                                                        }else{
                                                                            echo 'Adult: ' . '<span title="Online Payment" style="color:' . $cartItem->place->categories[0]->color_code . '">$' . $adult_unit_price . '</span>' . '      (x' . $total_adult . ')';
                                                                        }
                                                                    }
                                                                    @endphp
                                                                </div>
                                                                <div>
                                                                    @php
                                                                    $total_children = $cartItem->number_of_children;

                                                                    if(checkIfOnChildDiscount($cartItem->place_product)) {
                                                                    $child_unit_price = checkIfOnChildDiscount($cartItem->place_product,true);
                                                                    $child_total_price = $total_children * $child_unit_price;
                                                                    } else {
                                                                    $child_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child'));
                                                                    $child_total_price = $total_children * $child_unit_price;
                                                                    }
                                                                    if($total_children > 0) {
                                                                    echo 'Child: ' . '<span title="Online Payment" style="color:' . $cartItem->place->categories[0]->color_code . '">$' . $child_unit_price . '</span>' . '      (x' . $total_children . ')';
                                                                    }
                                                                    @endphp
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="cart-total-tablet">
                                                            @php
                                                            if($cartItem->place_product->online_payment_required == 1) {
                                                            echo '<span>Subtotal:</span><span title="Online Payment">$' . ($adult_total_price + $child_total_price + $car_total_price) .
                                                                '</span>';

                                                            } else {
                                                            echo '<span>Subtotal:</span><span title="Payment not required" style="color: orange;">$' . ($adult_total_price
                                                                + $child_total_price + + $car_total_price) . '</span>
                                                            <p style="font-size: 11px; color: orange;">Payment not required</p>';
                                                            }
                                                            @endphp
                                                        </div>
                                                    </div>
                                                    <a class="position-absolute remove-cart-tablet btn remove-btn" href="javascript:;" onclick="removeItem({{$cartItem->id}})" class="btn remove-btn"><i
                                                        class="la la-trash"></i>
                                                </div>
                                            </td>
                                            <td class="cart-date-td">
                                                @php
                                                // if($cartItem->place->categories[0]->slug == 'stay' || $cartItem->place->categories[0]->slug == 'rent'){
                                                //     if($cartItem->checkout_date != NULL){
                                                //         echo dateFormat($cartItem->booking_date) .' - '. dateFormat($cartItem->checkout_date);
                                                //     }else{
                                                //         echo dateFormat($cartItem->booking_date);
                                                //     }
                                                // }else{
                                                    echo dateFormat($cartItem->booking_date) .' '. Carbon\Carbon::parse($cartItem->booking_time)->format('h:i A');
                                                //}
                                                @endphp
                                            </td>
                                            <td class="cart-detail-td">
                                                @if(($cartItem->place->categories->first()->slug == 'stay'))
                                                    @php
                                                    $startDate  = \Carbon\Carbon::parse($cartItem->booking_date);
                                                    $endDate    = \Carbon\Carbon::parse($cartItem->checkout_date);
                                                    $diffDay = $startDate->diff($endDate)->d ?? 1;
                                                    $days = $diffDay + 1;
                                                    if(checkIfOnDiscount($cartItem->place_product)) {
                                                    $adult_unit_price = checkIfOnDiscount($cartItem->place_product,true);
                                                    $adult_total_price = $cartItem->no_of_room * $adult_unit_price * $days;
                                                    } else {
                                                    $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                                                    $adult_total_price = $cartItem->no_of_room * $adult_unit_price * $days;
                                                    }
                                                    $final_total = $final_total + $adult_total_price;
                                                    @endphp
                                                    <div>
                                                        <div>Adults:{{$cartItem->number_of_adult ?? '-'}}</div>
                                                        <div>Children:{{$cartItem->number_of_children ?? '-'}}</div>
                                                        <div>{{$cartItem->no_of_room}} Rooms × {{$days}} Nights</div>
                                                        <div>Price: ${{$adult_total_price}}</div>
                                                    </div>
                                                @else
                                                    <div>
                                                        @php
                                                        $total_car = ($cartItem->number_of_car != NULL) ? $cartItem->number_of_car : 0;

                                                        if(checkIfOnChildDiscount($cartItem->place_product)) {
                                                        $car_unit_price = checkIfOnCarDiscount($cartItem->place_product,true);
                                                        $car_total_price = $total_car * $car_unit_price;
                                                        } else {
                                                        $car_unit_price = cleanDecimalZeros($cartItem->place_product->car_price);
                                                        $car_total_price = $total_car * $car_unit_price;
                                                        }
                                                        if($total_car > 0) {
                                                        echo 'Vehicle: '. '<span title="Online Payment" style="color:' . $cartItem->place->categories[0]->color_code . '">$' . $car_unit_price . '</span>' . '      (x' . $total_car . ')' ;
                                                        }
                                                        @endphp
                                                    </div>
                                                    <div>
                                                        @php
                                                        $total_adult = $cartItem->number_of_adult;

                                                        if(checkIfOnDiscount($cartItem->place_product)) {
                                                        $adult_unit_price = checkIfOnDiscount($cartItem->place_product,true);
                                                        $adult_total_price = $total_adult * $adult_unit_price;
                                                        } else {
                                                        $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                                                        $adult_total_price = $total_adult * $adult_unit_price;
                                                        }
                                                        if($total_adult > 0) {
                                                            if($cartItem->place->categories[0]->slug == 'stay'){
                                                                echo $total_adult . ' (Nights) x ' . '<span title="Online Payment">$' . $adult_unit_price . ' =
                                                                $' . $adult_total_price . '</span>';
                                                            }elseif($cartItem->place->categories[0]->slug == 'rent'){
                                                                echo $total_adult . ' (Days) x ' . '<span title="Online Payment">$' . $adult_unit_price . ' =
                                                                $' . $adult_total_price . '</span>';
                                                            }else{
                                                                echo 'Adult: ' . '<span title="Online Payment" style="color:' . $cartItem->place->categories[0]->color_code . '">$' . $adult_unit_price . '</span>' . '      (x' . $total_adult . ')';
                                                            }
                                                        }
                                                        @endphp
                                                    </div>
                                                    <div>
                                                        @php
                                                        $total_children = $cartItem->number_of_children;

                                                        if(checkIfOnChildDiscount($cartItem->place_product)) {
                                                        $child_unit_price = checkIfOnChildDiscount($cartItem->place_product,true);
                                                        $child_total_price = $total_children * $child_unit_price;
                                                        } else {
                                                        $child_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child'));
                                                        $child_total_price = $total_children * $child_unit_price;
                                                        }
                                                        if($total_children > 0) {
                                                        echo 'Child: ' . '<span title="Online Payment" style="color:' . $cartItem->place->categories[0]->color_code . '">$' . $child_unit_price . '</span>' . '      (x' . $total_children . ')';
                                                        }
                                                        @endphp
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="cart-subtotal-td" style="text-align: center;">
                                                @php
                                                if($cartItem->place_product->online_payment_required == 1) {
                                                echo '<span title="Online Payment">$' . ($adult_total_price + $child_total_price + $car_total_price) .
                                                    '</span>';
                                                $final_total = $final_total + $adult_total_price + $child_total_price + + $car_total_price;
                                                } else {
                                                echo '<span title="Payment not required" style="color: orange;">$' . ($adult_total_price
                                                    + $child_total_price + + $car_total_price) . '</span>
                                                <p style="font-size: 11px; color: orange;">Payment not required</p>';
                                                }
                                                @endphp
                                            </td>
                                            <td class="cart-action-td">
                                                <a href="javascript:;" onclick="removeItem({{$cartItem->id}})" class="btn remove-btn"><i
                                                        class="la la-trash"></i>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" style="text-align:center;width:100%;display: table-cell;">No Items</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="cart-total">
                                    <div class="d-inline-block text-center">
                                        <p>Total : <span style="color: #72BF44;">${{$final_total}}</span></p>
                                        @if(count($cartItems))
                                        <a href="{{route('booking_summary')}}" type="submit" class="btn booking_submit_btn">Book Now</a>
                                        @endif
                                    </div>
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
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function removeItem(itemId) {
            swal({
                title: "Are you sure you want to delete item?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            }, function() {
                var token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{route('remove_item_from_cart')}}",
                    method: "post",
                    data: {'token':token,'item_id': itemId},
                    dataType: 'json',
                    success: function(result) {

                        swal({
                            title: "Deleted!",
                            text: "Item has been deleted from cart.",
                            type: "success"
                        }, function() {
                            if(result.status === true) {
                                if(result.count) {
                                    $('#cart_icon_count').html(result.count);
                                }
                                Tost(result.message, 'success');
                            } else {
                                Tost(result.message, 'error');
                            }
                            location.reload();
                        });
                    }
                });
            });
        }

        function cartClearAll(){
            swal({
                title: "Are you sure you want to clear cart items?",
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, clear it!",
                closeOnConfirm: false
            }, function() {
                var token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{route('clear_item_from_cart')}}",
                    method: "post",
                    data: {'token':token},
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        swal({
                            title: "Cleared!",
                            text: "Item has been clear from cart.",
                            type: "success"
                        }, function() {
                            Tost(result.message, 'success');
                            location.reload();
                        });
                    }
                });

            });

        }
</script>
@endpush
