<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        * {
            margin: 0;
            font-family: sans-serif;
        }

        table {
            border-collapse: collapse !important;
        }
    </style>
</head>

<body>
    <table width="670px" style="margin: auto">
        <thead>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td>
                                <div class="logo" style="text-align:center;padding: 50px 0 0;">
                                    <img src="{{asset('assets/images/email/logo_2.png')}}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text_wrapper" style="text-align:center;padding: 60px 30px 30px;">
                                    <h1 style="font-size:2.5rem;font-weight: 800;">Kia Ora, you have received a booking
                                        from Venture New Zealand!</h1>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin: auto auto 40px;width: 100%;">
                                    <tr>
                                        <td style="vertical-align: top;width: 150px;">
                                            <p
                                                style="margin:0;padding-top:5px;color: #73be45;font-weight: 700;text-align: right;">
                                                Name</p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin:0 0 10px; background: #f5f5f5;padding: 9px 9px;border-radius: 4px;margin-left: 7px;color: #525252;">
                                                {{$detail['name']}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;width: 150px;">
                                            <p
                                                style="margin:0;padding-top:5px;color: #73be45;font-weight: 700;text-align: right;">
                                                Email Address</p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin:0 0 10px; background: #f5f5f5;padding: 9px 9px;border-radius: 4px;margin-left: 7px;color: #525252;">
                                                {{$detail['email']}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;width: 150px;">
                                            <p
                                                style="margin:0;padding-top:5px;color: #73be45;font-weight: 700;text-align: right;">
                                                Contact Number</p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin:0 0 10px; background: #f5f5f5;padding: 9px 9px;border-radius: 4px;margin-left: 7px;color: #525252;">
                                                {{$setting['contactus_phone']}}</p>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td style="vertical-align: top;width: 150px;">
                                            <p
                                                style="margin:0;padding-top:5px;color: #73be45;font-weight: 700;text-align: right;">
                                                Date and Time</p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin:0 0 10px; background: #f5f5f5;padding: 9px 9px;border-radius: 4px;margin-left: 7px;color: #525252;">
                                                {{$detail['date_and_time']}}</p>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td style="vertical-align: top;width: 150px;">
                                            <p
                                                style="margin:0;padding-top:5px;color: #73be45;font-weight: 700;text-align: right;">
                                                Attendees</p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin:0 0 10px; background: #f5f5f5;padding: 9px 9px;border-radius: 4px;margin-left: 7px;color: #525252;">
                                                {{ (isset($detail['cars']) && $detail['cars'] != '') ? $detail['cars'] : '0' }}Vehicles, {{$detail['adults']}}Adults, {{$detail['childrens']}}Children </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;width: 150px;">
                                            <p
                                                style="margin:0;padding-top:5px;color: #73be45;font-weight: 700;text-align: right;">
                                                Booked at</p>
                                        </td>
                                        <td>
                                            <p
                                                style="margin:0 0 10px; background: #f5f5f5;padding: 9px 9px;border-radius: 4px;margin-left: 7px;color: #525252;">
                                                {{$detail['booked_at']}}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding:0 15px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                                <h3
                                    style="color: #73be45;margin-top: 0; margin-bottom: 15px;font-size: 20px;font-weight: 600;">
                                    Booking Summary</h3>
                                <div class="products_table">
                                    <table cellspacing="0" border="1" cellpadding="0"
                                        style="width: 100%;border-color: #ddd;">
                                        <thead>
                                            <tr>
                                                <th style="width:50px;border-right: none;"></th>
                                                <th style="border-right: none;border-left: none;" align="left">
                                                    <h5>Product</h5>
                                                </th>
                                                <th style="border-right: none;border-left: none;">
                                                    <h5>Vehicles</h5>
                                                </th>
                                                <th style="border-right: none;border-left: none;">
                                                    <h5>Adults</h5>
                                                </th>
                                                <th style="border-right: none;border-left: none;">
                                                    <h5>Childrens</h5>
                                                </th>

                                                <th style="border-right: none;border-left: none;">
                                                    <h5>Price</h5>
                                                </th>
                                                <th style="border-right: none;border-left: none;">
                                                    <h5>{{ __('Order Status')}}</h5>
                                                </th>
                                                <th style="border-right: none;border-left: none;">
                                                    <h5>{{ __('Payment Status')}}</h5>
                                                </th>
                                                <th style="border-left: none;">
                                                    <h5>Booking Date & Time</h5>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detail['cart_items'] as $cart_item)
                                            <tr>
                                                <td
                                                    style="border: none;border-left: 1px solid #ddd;border-bottom: 1px solid #ddd;">
                                                    <div class="img_box">
                                                        <span
                                                            style="width: 30px;height: 30px;background-color: #ddd;display: block;margin: 10px auto;"></span>
                                                    </div>
                                                </td>
                                                <td style="border: none;border-bottom: 1px solid #ddd;" align="left">
                                                    {{$cart_item->product_name}}</td>
                                                <td style="border: none;border-bottom: 1px solid #ddd;" align="center">
                                                    {{$cart_item->number_of_car}}
                                                </td>
                                                <td style="border: none;border-bottom: 1px solid #ddd;" align="center">
                                                    @if($cart_item->place->categories[0]->slug == 'stay')
                                                    {{$cart_item->number_of_adult}} Nights
                                                    @elseif($cart_item->place->categories[0]->slug == 'rent')
                                                    {{$cart_item->number_of_adult}} Days
                                                    @else
                                                    {{$cart_item->number_of_adult}}
                                                    @endif
                                                </td>
                                                <td style="border: none;border-bottom: 1px solid #ddd;" align="center">
                                                    {{$cart_item->number_of_children}}
                                                </td>

                                                <td style="border: none;border-bottom: 1px solid #ddd;" align="center">
                                                    {{-- $@if(checkIfOnDiscount($cart_item->place_product))
                                                    {{checkIfOnDiscount($cart_item->place_product,true)}}
                                                    @else
                                                    {{cleanDecimalZeros(getRezdyPrice($cart_item->place_product))}}
                                                    @endif --}}
                                                    @php
                                                        $total = 0;
                                                        $total_adult = $cart_item->number_of_adult;
                                                        $total_child = $cart_item->number_of_children;
                                                        $total_car = $cart_item->number_of_car;

                                                        // CHECK DISCOUNT FOR ADULTS
                                                        if (checkIfOnDiscount($cart_item->place_product)) {
                                                            $adult_unit_price = checkIfOnDiscount($cart_item->place_product, true);
                                                            $adult_total_price = $total_adult * $adult_unit_price;
                                                        } else {
                                                            $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cart_item->place_product));
                                                            $adult_total_price = $total_adult * $adult_unit_price;
                                                        }

                                                        // CHECK DISCOUNT FOR CHILDREN
                                                        if (checkIfOnChildDiscount($cart_item->place_product)) {
                                                            $child_unit_price = checkIfOnChildDiscount($cart_item->place_product, true);
                                                            $child_total_price = $total_child * $child_unit_price;
                                                        } else {
                                                            $child_unit_price = cleanDecimalZeros(getRezdyPrice($cart_item->place_product, $cart_item->place_product->child_price, 'child'));
                                                            $child_total_price = $total_child * $child_unit_price;
                                                        }

                                                        if (checkIfOnCarDiscount($cart_item->place_product)) {
                                                            $car_unit_price = checkIfOnCarDiscount($cart_item->place_product, true);
                                                            $car_total_price = $total_car * $car_unit_price;
                                                        } else {
                                                            $car_unit_price = cleanDecimalZeros($cart_item->place_product->car_price);
                                                            $car_total_price = $total_car * $car_unit_price;
                                                        }

                                                        $total = $total + $adult_total_price + $child_total_price + $car_total_price;

                                                        echo '$'.$total;
                                                    @endphp
                                                </td>
                                                <td style="border: none;border-bottom: 1px solid #ddd;" align="center">
                                                    @if(isset($cart_item->confirm_booking) && $cart_item->confirm_booking == 1)
                                                        Completed
                                                    @else
                                                        Pending
                                                    @endif
                                                </td>
                                                <td style="border: none;border-bottom: 1px solid #ddd;" align="center">
                                                    @if(isset($cart_item->confirm_booking) && $cart_item->confirm_booking == 1)
                                                        Paid
                                                    @else
                                                        Hold
                                                    @endif
                                                </td>
                                                <td style="border: none;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd"
                                                    align="center">
                                                    @if($cart_item->place->categories[0]->slug == 'stay')
                                                    {{dateFormat($cart_item->booking_date)}} - {{ dateFormat($cart_item->checkout_date) }}
                                                    @elseif($cart_item->place->categories[0]->slug == 'rent')
                                                    {{dateFormat($cart_item->booking_date)}} - {{ dateFormat($cart_item->checkout_date) }}
                                                    @else
                                                    {{dateFormat($cart_item->booking_date)}}
                                                    {{date('h:i A',strtotime($cart_item->booking_time))}}
                                                    @endif
                                                    </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding: 0 15px 40px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                                <table style="margin-left: auto;border: 1px solid #ddd;width:100%">
                                    <tr>
                                        <td colspan="2"
                                            style="padding: 5px;text-align:center;margin-top: 0;margin-bottom: 0;font-size: 17px;font-weight: 600;border-bottom: 1px solid #ddd;background: #eee;">
                                            <h3 style="margin: 0;color: #73be45;">Summary Details</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;" align="right">
                                            <span
                                                style="padding-right: 5px;max-width: 200px;width: 100%;display: inline-block;"><b>Subtotal:</b></span>
                                        </td>
                                        <td style="padding: 5px;width: 70px;">
                                            <span class="name">${{$detail['sub_total']}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;" align="right">
                                            <span
                                                style="padding-right: 5px;max-width: 200px;width: 100%;display: inline-block;"><b>Transaction
                                                    Charge:</b></span>
                                        </td>
                                        <td style="padding: 5px;width: 70px;">
                                            <span class="name">- ${{($detail['transaction_charge'] + Config::get('app.stripe_operator_charge'))}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;" align="right">
                                            <span
                                                style="padding-right: 5px;max-width: 200px;width: 100%;display: inline-block;"><b>Total:</b></span>
                                        </td>
                                        <td style="padding: 5px;width: 70px;">
                                            <span class="name">${{($detail['sub_total'] - $detail['transaction_charge'] - Config::get('app.stripe_operator_charge'))}}</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="lognin_section"
                                    style="position: relative;background-image: url({{asset('assets/images/email/booking.png')}});background-position: bottom center;background-repeat: no-repeat;height: 370px;margin-top: 0px;background-size: 100%;">
                                    <a href="{{$setting['contact']}}" target="_blank"
                                        style="font-size: 1.5rem;background-color: #73be45;text-decoration: none;color: #fff;font-weight: 600;padding: 20px 60px;border-radius: 50px;display: block;width: fit-content;margin: auto;z-index: 11;">Contact
                                        Us</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 30px 10px 0;text-align: center;">
                                <h5
                                    style="font-size: 2.5rem;font-weight: 800;padding-bottom: 5px;color: #72bf44;margin:0">
                                    Need any extra help?</h5>
                                <p style="color: #505050;margin: 5px 0 68px;font-size: 1.1rem;">If you need more support
                                    to get you moving along, feel free to contact the Venture New Zealand team.</p>
                                <p style="color: #505050;font-size: 1.1rem;margin-bottom: 50px;">
                                    Call us on <a href="tel:{{$setting['contactus_phone']}}"
                                        style="color: #72bf44;font-weight: 700;">{{$setting['contactus_phone']}}</a> or
                                    send an email to <a href="mailto:{{$setting['contactus_technical_email']}}"
                                        style="color: #72bf44;font-weight: 700;">{{$setting['contactus_technical_email']}}</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="social_icons" style="text-align: center;padding: 30px 0;">
                                    <a href="{{$setting['facebook_url']}}"
                                        style="text-decoration: none;padding: 0 10px;" target="_blank">
                                        <img src="{{asset("assets/images/email/FB.png")}}">
                                    </a>
                                    <a href="{{$setting['instagram_url']}}"
                                        style="text-decoration: none;padding: 0 10px;" target="_blank">
                                        <img src="{{asset("assets/images/email/IG.png")}}">
                                    </a>
                                    <a href="{{$setting['youtube_url']}}" style="text-decoration: none;padding: 0 10px;"
                                        target="_blank">
                                        <img src="{{asset("assets/images/email/YT.png")}}">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="links">
                                    <a href="{{$setting['page_terms_and_conditions']}}"
                                        style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: underline;color:#000;"
                                        target="_blank">Terms and Conditions & Privacy Policy</a>
                                    <a href="{{$setting['contact']}}"
                                        style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: underline;color:#000;"
                                        target="_blank">Contact</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="footer_link">
                                    <p style="text-align:center;padding-top:30px;font-size: .9rem;">Don’t want to
                                        receive these emails?<br><a href="javascript:void(0)"
                                            style="color:#72bf44;">Click here to unsubscribe.</a></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table width="100%">
                    </table>
                </td>
            </tr>
        </thead>
    </table>

</body>

</html>
