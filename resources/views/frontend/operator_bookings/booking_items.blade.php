@extends('frontend.layouts.template')
@section('main')
    <style>
        .booking-btn .btn {
            width: 100%;
        }

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

    </style>
    <div id="show_loader" class="loader">
        <img id="loading-image" src="{{ getImageUrl('giphy.gif') }}" alt="Loading..." />
    </div>
    <main id="main" class="site-main">
        <div class="site-content">
            <div class="member-menu mt-5">
                <div class="container">
                    <div class="member-wrap cart-heading">
                        <h1>{{ __('Booking Details') }}</h1>
                    </div><!-- .member-wrap -->
                </div>
            </div>
            <div class="container">
                <!--booking details content-->
                <div class="row booking-content">
                    <div class="col-lg-8 booking-content-li">
                        <div class="booking-name">
                            <label>{{ __('Name') }} : <span>{{ $booking_order->name }}</span></label>
                            <label>{{ __('Email') }} : <span>{{ $booking_order->email }}</span></label>
                            <label>{{ __('Phone number') }} : <span>{{ $booking_order->phone_number }}</span></label>
                            <!-- <label>Payment Status : <span>{{ $booking_order->payment_intent_status }}</span></label> -->
                        </div>
                        <h1 class="booking-headings">{{ __('Products') }}</h1>
                        <div class="booking-history-con booking-details">
                            <div class="responsive-table">
                                <table class="table">
                                    <thead>
                                        <th></th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Vehicles') }}</th>
                                        <th>{{ __('Adults') }}</th>
                                        <th>{{ __('Childrens') }}</th>
                                        <th>{{ __('No. of room') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Booking Date & Time') }}</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $final_total = 0;
                                        @endphp
                                        @foreach ($booking_order_items as $item)
                                            @php
                                                $placeProduct = App\Models\PlaceProduct::query()
                                                    ->where('id', $item->place_product_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <img src="{{ getProductImageUrl($item->thumb) }}"
                                                        class="image-con" alt="payments">
                                                </td>
                                                <td><a href="{{ route('place_detail', $item->slug) }}" target="_blank">{{ $placeProduct->name }}</a></td>
                                                {{-- handle for stay and other category --}}
                                                @if(($item->no_of_room != null))
                                                    @php
                                                    $startDate  = \Carbon\Carbon::parse($item->booking_date);
                                                    $endDate    = \Carbon\Carbon::parse($item->checkout_date);
                                                    $diffDay = $startDate->diff($endDate)->d ?? 1;
                                                    $days = $diffDay + 1;
                                                    @endphp

                                                    <td>-</td>
                                                    <td>
                                                        {{$item->number_of_adult}}
                                                    </td>
                                                    <td>
                                                        {{$item->number_of_children}}
                                                    </td>
                                                    <td>
                                                        {{$item->no_of_room}} × {{$days}} Nights
                                                    </td>
                                                    <td>
                                                        @php
                                                        $total_price = $item->price;
                                                        $final_total = $final_total + $total_price;
                                                        @endphp
                                                        ${{$total_price}}
                                                    </td>
                                                @else
                                                <td>
                                                    @php
                                                    $total_car = ($item->number_of_car != NULL) ? $item->number_of_car : 0;
                                                    $car_unit_price = ($item->car_price != NULL) ? $item->car_price : 0;
                                                    $car_total_price = $total_car * $car_unit_price;
                                                    echo $total_car . ' x ' . '<span title="Online Payment">$' .
                                                        $car_unit_price . ' = $' . $car_total_price . '</span>';
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $total_adult = $item->number_of_adult;

                                                        //if (checkIfOnDiscount($placeProduct)) {
                                                            // $adult_unit_price = checkIfOnDiscount($placeProduct, true);
                                                            $adult_unit_price = $item->price;
                                                            $adult_total_price = $total_adult * $adult_unit_price;
                                                        //} else {
                                                            // $adult_unit_price = cleanDecimalZeros($placeProduct->price);
                                                            //$adult_unit_price = $item->price;
                                                            //$adult_total_price = $total_adult * $adult_unit_price;
                                                        //}

                                                        echo $total_adult . ' x ' . '<span title="Online Payment">$' . $adult_unit_price . ' = $' . $adult_total_price . '</span>';
                                                    @endphp
                                                </td>
                                                <td>

                                                    @php
                                                        $total_children = $item->number_of_children;

                                                        //if (checkIfOnChildDiscount($placeProduct)) {
                                                            //$child_unit_price = checkIfOnChildDiscount($placeProduct, true);
                                                            $child_unit_price = getRezdyPrice($item, $item->child_price, 'child');
                                                            $child_total_price = $total_children * $child_unit_price;
                                                        //} else {
                                                            //$child_unit_price = cleanDecimalZeros($placeProduct->child_price);
                                                            //$child_total_price = $total_children * $child_unit_price;
                                                        //}

                                                        echo $total_children . ' x ' . '<span title="Online Payment">$' . $child_unit_price . ' = $' . $child_total_price . '</span>';
                                                    @endphp

                                                </td>
                                                <td>-</td>
                                                @endif
                                                {{--  --}}

                                                {{-- <td>
                                                    @php
                                                        if ($placeProduct->online_payment_required == 1) {
                                                            echo '<span title="Online Payment">$' . ($adult_total_price + $child_total_price + $car_total_price) . '</span>';
                                                            $final_total = $final_total + $adult_total_price + $child_total_price + $car_total_price;
                                                        } else {
                                                            echo '<span title="Payment not required" style="color: orange;">$' . ($adult_total_price + $child_total_price + $car_total_price) . '</span><p style="font-size: 11px; color: orange;">Payment not required</p>';
                                                        }
                                                    @endphp
                                                </td> --}}
                                                <td>{{ dateFormat($item->booking_date) . ' ' . Carbon\Carbon::parse($item->booking_time)->format('h:i A') }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 booking-content-li">
                        <div class="order-summary">
                            <h2 class="small-text">{{ __('Booking Summary') }}</h2>
                            <div class="summary-flex">
                                <p>{{ __('Subtotal') }} :</p>
                                <span>${{ cleanDecimalZeros($booking_order->payable_amount) }}</span>
                            </div>
                            <hr class="border-dashed">
                            <div class="summary-flex final-total">
                                <p>{{ __('Total') }} :</p>
                                <span>${{ cleanDecimalZeros($booking_order->payable_amount) }}</span>
                            </div>
                        </div>
                        @if ($booking_order->payment_intent_status == 'pending')
                            <div class="text-center booking-btn">
                                <button class="btn unpaid" type="submit"
                                    title="Click here to confirm booking and proceed" id="confirm_btn"
                                    data-bookingid="{{ $booking_order->id }}"
                                    data-placeid={{ $booking_order->place_id }}>{{ __('Confirm booking') }}</button>
                            </div>
                            <div class="text-center booking-btn">
                                <button class="btn decline" type="submit"
                                    title="Click here to decline booking" id="decline_btn"
                                    data-bookingid="{{ $booking_order->id }}"
                                    data-placeid={{ $booking_order->place_id }} style="background-color:red;">{{ __('Decline booking') }}</button>
                            </div>
                        @endif
                    </div>
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
                    <button type="button" class="btn btn-default close-btn-event-modal"
                        data-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('cancel_subscription') }}"
                        class="btn">{{ __('Cancel Subscription') }}</a>
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
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                    {{-- <button type="button" class="btn" data-dismiss="modal" data-toggle="modal" data-target="#stripe_modal">Purchase Plan</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="stripe_modal" tabindex="-1" role="dialog" aria-labelledby="stripe_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="payment-form"
                    @if (isOperatorUser()) action="{{ route('stripe_subscription') }}"
        @else
            action="{{ route('stripe_charge') }}" @endif
                    method="post">
                    @csrf
                    <div class="modal-header">
                        <h2 class="modal-title" id="myModalLabel"><img
                                src="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}"
                                alt="logo"></h2>
                        <button type="button" class="close closefirstmodal" {{-- data-dismiss="modal" aria-label="Close" --}}>
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body member-wrap mb-0">
                        <h3>{{ __('Pay with card') }}
                            ${{ App\Models\UserSubscription::getSubscriptionPriceForUserType(auth()->user()->user_type) }}
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
                                            <input type="text" id="card_name-stripe" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="field-input">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input type="email" id="email" value="{{ auth()->user()->email }}"
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
                        <button type="button" class="btn btn-default closefirstmodal"
                            {{-- data-dismiss="modal" --}}>{{ __('Close') }}</button>
                        <button type="submit" class="btn">{{ __('Pay') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.unpaid', function() {
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
                                booking_id: bookingid,
                                place_id: placeid
                            },
                            success: function(data) {
                                $(".loader").css("display", "none");
                                if (data.status == true) {
                                    //location.reload();
                                    window.location = '/booking-list';
                                } else {
                                    toastr.error(data.message);
                                }
                            }
                        });
                    }
                })
            });

            $(document).on('click', '.decline', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to decline this booking?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0018',
                    confirmButtonText: 'Yes, decline it!',
                    cancelButtonColor: '#aaa',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.close();
                        var bookingid = $(this).attr('data-bookingid');
                        var placeid = $(this).attr('data-placeid');
                        $(".loader").css("display", "block");
                        $.ajax({
                            url: "{{ route('decline_booking') }}",
                            method: "POST",
                            data: {
                                booking_id: bookingid,
                                place_id: placeid
                            },
                            success: function(data) {
                                $(".loader").css("display", "none");
                                if (data.status == true) {
                                    //location.reload();
                                    window.location = '/booking-list';
                                } else {
                                    toastr.error(data.message);
                                }
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush
