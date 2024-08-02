<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('User Confirmation') }}</title>
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
                                    <img src="https://tecocraft.co.in/webdesign-work/venture/images/logo_2.png">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text_wrapper" style="text-align:center;padding: 60px 0 50px;">
                                    <h1 style="font-size:2.5rem;font-weight: 800;">{{ __('Kia Ora')}} {{$detail['name']}},<br />
                                        {{ __('Here are your booking details')}}:</h1>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding:0 15px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                                <div class="products_table">
                                    <table cellspacing="0" cellpadding="0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>
                                                    <h5
                                                        style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;">
                                                        {{ __('Category')}}</h5>
                                                </th>
                                                <th>
                                                    <h5
                                                        style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;">
                                                        {{ __('Oty')}}.</h5>
                                                </th>
                                                <th>
                                                    <h5 style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;"
                                                        align="left">{{ __('Date')}}</h5>
                                                </th>
                                                <th>
                                                    <h5 style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;"
                                                        align="left">{{ __('Time')}}</h5>
                                                </th>
                                                <th>
                                                    <h5 style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;"
                                                        align="left">{{ __('Sub Total')}}</h5>
                                                </th>
                                                <th>
                                                    <h5 style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;"
                                                        align="left">{{ __('Transaction Fee')}}</h5>
                                                </th>
                                                <th>
                                                    <h5 style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;"
                                                        align="left">{{ __('Order Status')}}</h5>
                                                </th>
                                                <th>
                                                    <h5 style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;"
                                                        align="left">{{ __('Payment Status')}}</h5>
                                                </th>
                                                <th>
                                                    <h5 style="margin:0;padding:20px;color: #73be45;font-weight: 800;font-size: 18px;"
                                                        align="left">{{ __('Total')}}</h5>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detail['cart_items'] as $cart_item)
                                            <tr style="background: #f5f5f5;">
                                                <td style="padding: 20px;border-top-left-radius: 33px;border-bottom-left-radius: 33px;font-weight: 800;"
                                                    align="left">{{$cart_item->place->name}}</td>
                                                <td style="padding: 20px;color:{{ $cart_item->place->categories[0]->color_code }}" align="center">
                                                    @if($cart_item->place->categories)
                                                    {{$cart_item->place->categories[0]->name}}
                                                    @else
                                                    N/A
                                                    @endif
                                                    <p>( {{ $cart_item->place->categories[0]->pricing_text }} )</p>
                                                </td>
                                                <td style="padding: 20px" align="center">
                                                    @if($cart_item->place->categories[0]->slug == 'stay')
                                                        {{$cart_item->getTotalNumberOfBooking()}} {{ __('Nights')}}
                                                    @elseif($cart_item->place->categories[0]->slug == 'rent')
                                                        {{$cart_item->getTotalNumberOfBooking()}} {{ __('Days')}}
                                                    @else
                                                        {{$cart_item->getTotalNumberOfBooking()}}
                                                        <p>({{ $cart_item->number_of_adult }} {{ __('Adults')}} + {{ $cart_item->number_of_children }} {{ __('Childrens')}} + {{ $cart_item->number_of_car }} {{ __('Vehicles')}})</p>
                                                    @endif
                                                </td>
                                                <td style="padding: 20px" align="left">
                                                    @if($cart_item->place->categories[0]->slug == 'stay' || $cart_item->place->categories[0]->slug == 'rent')
                                                    {{$cart_item->changeDateFormat()}} - {{ $cart_item->changeCheckoutDateFormat() }}
                                                    @else
                                                    {{$cart_item->changeDateFormat()}}
                                                    @endif
                                                </td>
                                                <td style="padding: 20px" align="left">{{$cart_item->changeTimeFormat()}}</td>
                                                <td style="padding: 20px;" align="left">${{$cart_item->totalPrice()}}</td>
                                                <td style="padding: 20px;" align="left">${{Config::get('app.stripe_user_charge')}}</td>
                                                <td style="padding: 20px;" align="left">
                                                    @if(isset($booking_data) && $booking_data->payment_intent_status == 'canceled')
                                                        Canceled
                                                    @else
                                                        @if(isset($cart_item->confirm_booking) && $cart_item->confirm_booking == 0)
                                                            Completed
                                                        @else
                                                            Pending
                                                        @endif
                                                    @endif
                                                </td>
                                                <td style="padding: 20px;" align="left">
                                                    @if(isset($booking_data) && $booking_data->payment_intent_status == 'canceled')
                                                        Canceled
                                                    @else
                                                        @if(isset($cart_item->confirm_booking) && $cart_item->confirm_booking == 0)
                                                            Paid
                                                        @else
                                                            Hold
                                                        @endif
                                                    @endif
                                                </td>
                                                <td style="padding: 20px;border-top-right-radius: 33px;border-bottom-right-radius: 33px;" align="left">${{$cart_item->totalPrice() + Config::get('app.stripe_user_charge')}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;padding: 60px 0 40px;text-align: center;font-size: 1.1rem;">
                                {{ __('Thanks for using Venture New Zealand!') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="lognin_section"
                                    style="position: relative;background-image: url('{{asset('assets/images/email/booking-imag.png')}}');background-position: bottom center;background-repeat: no-repeat;height: 370px;margin-top: 0px;background-size: 100%;">
                                    <a href="{{$setting['contact']}}" target="_blank"
                                        style="font-size: 1.5rem;background-color: #73be45;text-decoration: none;color: #fff;font-weight: 600;padding: 20px 60px;border-radius: 50px;display: block;width: fit-content;margin: auto;z-index: 11;">{{ __('Contact Us') }}</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 70px 10px 0;text-align: center;">
                                <p style="color: #505050;margin: 5px 0 28px;font-size: 1.1rem;width: 700px;">{{ __('If you require any support, feel free to contact the team at') }}
                                    <a href="mailto:{{$setting['contactus_email']}}"
                                        style="color: #505050;font-size: 1.1rem;">{{$setting['contactus_email']}}</a>
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
                                        target="_blank">{{ __('Terms and Conditions & Privacy Policy') }}</a>
                                    {{-- <a href="javascript:void(0)"
                                        style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: none;color:#000;"
                                        target="_blank">Privacy Policy</a> --}}
                                    <a href="{{$setting['contact']}}"
                                        style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: underline;color:#000;"
                                        target="_blank">{{ __('Contact') }}</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="footer_link">
                                    <p style="text-align:center;padding-top:30px;font-size: .9rem;">{{ __('Don’t want to receive these emails?') }}<br><a href="javascript:void(0)"
                                            style="color:#72bf44;">{{ __('Click here to unsubscribe.') }}</a></p>
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
