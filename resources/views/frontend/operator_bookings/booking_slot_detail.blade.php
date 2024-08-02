<button class="btn slot-edit-btn">
    <i class="fas fa-pen"></i>
    <span>Edit</span>
</button>
<div class="booking-slot-title">
    <div class="booking-slot-time_product">
        @php
            $time = date('ga',strtotime($booking_confirmed_slots->start_time));
            $weekday = date('l',strtotime($select_date));
            $date = date('F d, Y',strtotime($select_date));
        @endphp
        <div>Booking - {{$time}} - {{$weekday}} {{$date}}</div>
        <div style="color: {{$operator_place['categories'][0]['color_code']}}">
            {{$booking_confirmed_slots->product_name}}
        </div>
    </div>
    <div>
        <div class="booking-slot-capacity">
            <p>Capacity</p>
            <div>
                @php
                    $currentPersonNum = 0;
                    foreach ($booking_confirmed_orders as $booking_order) {
                        $currentPersonNum += $booking_order->number_of_adult;
                        $currentPersonNum += $booking_order->number_of_children;
                    }
                    $vacan = $booking_confirmed_slots->max_booking_no - $currentPersonNum;
                @endphp
                {{$currentPersonNum}}/{{$booking_confirmed_slots->max_booking_no}}
            </div>
        </div>
        <div class="booking-slot-vacan">
            <p>Vacancies</p>
            <div>
                {{$vacan}}
            </div>
        </div>
    </div>
</div>
<div class="booking-slot-table">
    <table>
        <thead>
            <tr>
                <th class="id_td"><span>{{ __('Booking ID') }}</span><span>{{ __('ID') }}</span></th>
                <th>{{ __('Name') }}</th>
                <th class="per_td"><span>{{ __('No. of Pers') }}</span><span>{{ __('No.') }}</span></th>
                <th class="price_td">{{ __('Price') }}</th>
                <th>
                    <span>{{ __('Status') }}</span>
                </th>
                <th class="mng_td"><span>{{ __('Manage') }}</span><span>{{ __('Mng') }}</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking_confirmed_orders as $booking_order)
            <tr>
                <td>{{$booking_order->id}}</td>
                <td>{{$booking_order->name}}</td>
                <td>
                    @php
                        $bookingNum = $booking_order->number_of_adult + $booking_order->number_of_children;
                    @endphp
                    {{$bookingNum}}
                </td>
                <td class="price_td">${{$booking_order->payable_amount}}</td>
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
                <a href="{{route('booking_items',$booking_order->id)}}" class="btn booking_submit_btn">
                    <span><i class="fas fa-info"></i></span>
                    <span>{{ __('View') }}</span>
                </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
