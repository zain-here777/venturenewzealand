@extends('admin.layouts.template')
@section('main')
<div class="page-title">
    <div class="title_left">
        <h3>Bookings</h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">

                <table class="table table-striped table-bordered golo-datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>Booking at</th>
                            <th>Status</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{$booking->id}}</td>
                            @if(isset($booking->type) && $booking->type === \App\Models\Booking::TYPE_BOOKING_FORM)
                            @php
                            $booking_name = isset($booking['user']['name'])?$booking['user']['name']:'';
                            $booking_email =isset($booking['user']['email'])?$booking['user']['email']:'';
                            $booking_phone =isset($booking['user']['phone_number'])?$booking['user']['phone_number']:'';
                            @endphp
                            <td>{{$booking_name}}
                                <small>(UID:@if(isset($booking['user']['id'])){{$booking['user']['id']}}@endif)</small>
                            </td>
                            @elseif(isset($booking))
                            @php
                            $booking_name =isset($booking->name)?$booking->name:'';
                            $booking_email =isset($booking->email)?$booking->email:'';
                            $booking_phone =isset($booking->phone_number)?$booking->phone_number:'';
                            @endphp
                            <td>{{$booking_name}}</td>
                            @endif

                            @if(isset($booking['place']))
                            <td><a href="{{route('place_detail', $booking['place']['slug'])}}"
                                    target="_blank">{{$booking['place']['name']}}</a></td>
                            @else
                            <td><i>Place deleted</i></td>
                            @endif
                            <td>{{formatDate($booking->created_at, 'H:i d/m/Y')}}</td>
                            <td>
                                @if($booking->status === \App\Models\Booking::STATUS_PENDING)
                                <span class="status-pending">Pending</span>
                                @elseif($booking->status === \App\Models\Booking::STATUS_ACTIVE)
                                <span class="status-approved">Approved</span>
                                @else
                                <span class="status-cancel">Cancel</span>
                                @endif
                            </td>
                            <td class="golo-flex action">
                                @if(isset($booking['place']))
                                <button type="button" class="btn btn-primary btn-xs booking_detail"
                                    data-id="{{$booking->id}}" data-name="{{$booking_name}}"
                                    data-email="{{$booking_email}}" data-phone="{{$booking_phone}}"
                                    data-place="{{$booking['place']['name']}}"
                                    data-bookingdatetime="{{$booking->time}} {{formatDate($booking->date, 'd/m/Y')}}"
                                    data-bookingat="{{formatDate($booking->created_at, 'H:i d/m/Y')}}"
                                    data-status="{{STATUS[$booking->status]}}" data-message="{{$booking->message}}"
                                    data-adult="{{$booking->numbber_of_adult}}"
                                    data-children="{{$booking->numbber_of_children}}"
                                    data-type="{{$booking->type}}">Detail
                                </button>
                                @if($booking->status === \App\Models\Booking::STATUS_PENDING || $booking->status ===
                                \App\Models\Booking::STATUS_DEACTIVE)
                                <form class="d-inline" action="{{route('admin_booking_update_status')}}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{$booking->id}}">
                                    <input type="hidden" name="status" value="{{\App\Models\Booking::STATUS_ACTIVE}}">
                                    <button type="button" class="btn btn-success btn-xs booking_approve"
                                        data-id="{{$booking->id}}">Approve</button>
                                </form>
                                @endif
                                @if($booking->status === \App\Models\Booking::STATUS_PENDING || $booking->status ===
                                \App\Models\Booking::STATUS_ACTIVE)
                                <form class="d-inline" action="{{route('admin_booking_update_status')}}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{$booking->id}}">
                                    <input type="hidden" name="status" value="{{\App\Models\Booking::STATUS_DEACTIVE}}">
                                    <button type="button" class="btn btn-danger btn-xs booking_cancel">Cancel</button>
                                </form>
                                @endif
                                @else
                                <i>Place deleted</i>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@include('admin.booking.modal_booking_detail')
@stop

@push('scripts')
<script src="{{asset('admin/js/page_booking.js')}}"></script>
@endpush
