<?php
use Carbon\Carbon;
?>

<div class ="row">
    <div class="col-lg-5 reservation_placeinfo row">
        <div>
            <div class="reservation_placelogo">
                <img src="{{getImageUrl($reservation->place->logo)}}" alt="logo"/>
            </div>
            <div class="reservation_placelocation">
                <div class="reservation_subdiv">
                    <div>{{$reservation->place->name}}</div>
                    <p>{{$reservation->place->city->name}}</p>
                </div>
                <div class="reservation_subdiv">
                    <p>Address</p>
                    @php
                        $address = explode(",", $reservation->place->address);
                        $adressLen = count($address) - 1;
                    @endphp
                    @foreach(explode(",", $reservation->place->address) as $index => $array)
                        @if($index !== $adressLen)
                        <div>
                        {{$array}},
                        </div>
                        @else
                        <div>
                        {{$array}}
                        </div>
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
        <div>
            <div class="reservation_placecontact">
                <div class="reservation_subdiv">
                    <p>Phone number</p>
                    <div>{{$reservation->place->phone_number}}</div>
                </div>
                <div class="reservation_subdiv">
                    <p>Email</p>
                    <div>{{$reservation->place->email}}</div>
                </div>
                <div class="reservation_subdiv">
                    <p>Website</p>
                    <div>{{$reservation->place->website}}</div>
                </div>
            </div>
            <div style="display: flex; gap:15px; align-items: center;">
                <div class="reservation_placelogo_under">
                    <img src="{{getImageUrl($reservation->place->logo)}}" alt="logo"/>
                </div>
                <div class="reservation_placethumb" style="background-image: url({{getImageUrl($reservation->place->thumb)}});">
                    {{-- <img src="{{getImageUrl($reservation->place->thumb)}}" alt="{{$reservation->place->name}}"> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 reservation_info">
        <div class="reservation_subdiv">
            <p>Reservation ID</p>
            <div>{{$reservation->id}}</div>
        </div>
        <div class="reservation_subdiv">
            <p>Date</p>
            <div>{{dateFormat($reservation->date)}}</div>
        </div>
        <div class="reservation_subdiv">
            <p>Time</p>
            <div>{{Carbon::parse($reservation->time)->format('h:i A')}}</div>
        </div>
        <div class="reservation_subdiv">
            <p>No. of Adult</p>
            <div>{{$reservation->numbber_of_adult}}</div>
        </div>
        <div class="reservation_subdiv">
            <p>No. of Child</p>
            <div>{{$reservation->numbber_of_children}}</div>
        </div>
    </div>
    <div class="col-lg-4 reservation_note">
        <div class="reservation_opernote">
            <p>Operator Note</p>
            <div>{{$reservation->place->needtobring}}</div>
        </div>
        <div class="reservation_usernote">
            <p>User note</p>
            <div>{{$user_info->user_note}}</div>
        </div>
    </div>
</div>
