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
                    <button class="btn slot-detail" data-id = "{{$arrSlotInfo[$booking_order->booking_time][$booking_order->place_product_id]->id}}"
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
                </div>  <!-- paid unpaid pending -->
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
