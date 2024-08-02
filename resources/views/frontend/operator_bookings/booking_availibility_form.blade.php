<div class="member-wrap cart-heading d-flex justify-content-between align-items-center">
    <h1 class="h1-headings">@if($date != null || $editData == 1) {{ __('Edit Booking Availability') }} @else  {{ __('Add Booking Availability') }} @endif</h1>
    @if($date != null || $editData == 1)
    <button class="btn" id="add_availability_btn"> Add Booking </button>
    @endif
</div><!-- .member-wrap -->
@php
$category = $products->categories()->first()->slug ?? null;
@endphp
<form id="add_booking_availibility_frm" method="post">
    @csrf
    <input type="hidden" name="booking_availibility_id" id="booking_availibility_id" value="{{(isset($bookingdata) && $bookingdata != null) ? $bookingdata->id : 0}}">
    <input type="hidden" name="editform" id="editform" value="{{$editData == 1 ? true : false}}">
    <input type="hidden" name="editmode" id="edit_mode" value="{{$date == null ? false : true}}">
    <input type="hidden" name="all_day_field" id="all_day_field" value="{{(isset($bookingdata) && $bookingdata != null) ? $bookingdata->all_day??0 : 0}}">
    <input type="hidden" name="is_recurring_field" id="is_recurring_field" value="{{(isset($bookingdata) && $bookingdata != null) ? $bookingdata->is_recurring??0 : 0}}">
    <div class="row booking-ul">
        <div class="col-lg-3 col-md-5  p-0 d-flex">
            <div class="col-md-12 booking-li">
                <div class="booking-div">
                    <div class="custom-select-drp">
                        <select class="form-control" name="product_id" id="product_id">
                            <option value="">{{ __('Select Product') }}</option>
                            @if (!empty($products))
                                @foreach ($products->products as $product)
                                    <option value="{{ $product->id }}" {{ ($product_id == $product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <label id="product_id-error" class="error" for="product_id" style="display: none;color:red;font-size:15px;">{{ __('Please select product')}}</label>
                    </div>
                    @if($date == null)
                        <div class="custom-check">
                            <input type="checkbox" id="recurring" name="is_recurring" value="1" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1) ? 'checked' : '' }}>
                            <label class="bc_filter" for="recurring">{{ __('Recurring')}}</label>
                        </div>

                        @if(!empty($bookingdata) && $bookingdata->is_recurring == 1 && $bookingdata->recurring_value != '')
                        <?php $recurringval = json_decode($bookingdata->recurring_value); ?>
                        @endif
                        <div class="week-days" style="{{ (!empty($bookingdata) && $bookingdata->is_recurring == 1) ? 'display:block;' : 'display:none;' }}">
                            <div class="custom-check">
                                <input type="checkbox" id="Sunday" name="recurring_value[]" value="Sunday" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1 && in_array('Sunday',$recurringval)) ? 'checked' : '' }}>
                                <label class="bc_filter" for="Sunday">{{ __('Sunday')}}</label>
                            </div>
                            <div class="custom-check">
                                <input type="checkbox" id="Monday" name="recurring_value[]" value="Monday" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1 && in_array('Monday',$recurringval)) ? 'checked' : '' }}>
                                <label class="bc_filter" for="Monday">{{ __('Monday')}}</label>
                            </div>
                            <div class="custom-check">
                                <input type="checkbox" id="Tuesday" name="recurring_value[]" value="Tuesday" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1 && in_array('Tuesday',$recurringval)) ? 'checked' : '' }}>
                                <label class="bc_filter" for="Tuesday">{{ __('Tuesday')}}</label>
                            </div>
                            <div class="custom-check">
                                <input type="checkbox" id="Wednesday" name="recurring_value[]" value="Wednesday" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1 && in_array('Wednesday',$recurringval)) ? 'checked' : '' }}>
                                <label class="bc_filter" for="Wednesday">{{ __('Wednesday')}}</label>
                            </div>
                            <div class="custom-check">
                                <input type="checkbox" id="Thursday" name="recurring_value[]" value="Thursday" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1 && in_array('Thursday',$recurringval)) ? 'checked' : '' }}>
                                <label class="bc_filter" for="Thursday">{{ __('Thursday')}}</label>
                            </div>
                            <div class="custom-check">
                                <input type="checkbox" id="Friday" name="recurring_value[]" value="Friday" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1 && in_array('Friday',$recurringval)) ? 'checked' : '' }}>
                                <label class="bc_filter" for="Friday">{{ __('Friday')}}</label>
                            </div>
                            <div class="custom-check">
                                <input type="checkbox" id="Saturday" name="recurring_value[]" value="Saturday" {{ (!empty($bookingdata) && $bookingdata->is_recurring == 1 && in_array('Saturday',$recurringval)) ? 'checked' : '' }}>
                                <label class="bc_filter" for="Saturday">{{ __('Saturday')}}</label>
                            </div>
                            <label id="chk_option_error" class="error" for="chk_option_error" style="visibility:hidden;color:red;font-size:15px;">{{ __('Please select any one')}}</label>
                        </div>
                    @endif

                    @if($date == null)
                        <div class="form-group-content first-date" style="{{ (!empty($bookingdata) && $bookingdata->is_recurring == 1) ? 'display:none;' : 'display:block;' }}">
                            <label>{{ __('Date')}} </label>
                            <div class="custom-date-input">
                                @php
                                    $dateData = (!empty($bookingdata) && $bookingdata->is_recurring != 1)  ? date('d-m-Y',strtotime($bookingdata->date)) : "";
                                @endphp
                                <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                <input readonly autocomplete="off" type="text" id="select-date1" name="date" class="datepicker_auto_select input-date" value="{{$dateData}}"/>
                                <label id="date-error" class="error" for="date" style="display: none;color:red;font-size:15px;">{{ __('Please select date')}}</label>
                            </div>
                        </div>
                    @else
                        <div class="form-group-content first-date">
                            <label>{{ __('Date')}} </label>
                            <div class="custom-date-input">
                                <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                <input readonly  autocomplete="off" type="text" id="select-date1" name="date" class="input-date" value="{{date('d-m-Y',strtotime($date))}}"/>
                                <label id="date-error" class="error" for="date" style="display: none;color:red;font-size:15px;">{{ __('Please select date')}}</label>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-7">
            <div class="row">
                @if($date == null)
                    <div class="col-xl-3 col-lg-6 col-md-6  booking-li second-div" style="{{ (!empty($bookingdata) && $bookingdata->is_recurring == 1) ? 'display:block' : 'display:none' }}">
                        <div class="booking-div">
                            <h5 class="bg-headings">{{ __('Available From')}}:</h5>
                            <div class="form-group-content">
                                <label>Date </label>
                                <div class="custom-date-input">
                                    <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                    <input autocomplete="off" type="text" id="select-date2" name="available_from" class="input-date" value="{{ (!empty($bookingdata) &&  $bookingdata->is_recurring == 1) ? date('d-m-Y',strtotime($bookingdata->available_from)) : '' }}"/>
                                    <label id="available_from-error" class="error" for="available_from" style="display: none;color:red;font-size:15px;">{{ __('Please select date')}}</label>
                                </div>
                            </div>
                            <h5 class="bg-headings mt-4">{{ __('Available To')}}:</h5>
                            <div class="form-group-content">
                                <label>{{ __('Date')}} </label>
                                <div class="custom-date-input">
                                    <div class="custom-date-input">
                                        <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                        <input autocomplete="off" type="text" id="select-date3" name="available_to" class="input-date" value="{{ (!empty($bookingdata) && $bookingdata->is_recurring == 1) ? date('d-m-Y',strtotime($bookingdata->available_to)) : '' }}"/>
                                        <label id="available_to-error" class="error" for="available_to" style="display: none;color:red;font-size:15px;">{{ __('Please select date')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!empty($bookingdata) && $bookingdata->is_recurring == 1)
                    <div class="col-xl-6 col-lg-8 booking-li first-div-li">
                    @else
                    <div class="col-xl-9 col-lg-8 booking-li first-div-li">
                    @endif
                @else
                    <div class="col-xl-9 col-lg-8 booking-li first-div-li">
                @endif
                    <div class="booking-div">
                        <h5 class="bg-headings">{{ __('Time Slots')}}:</h5>
                        @if($date == null)
                        <div class="custom-check">
                            @if($category == 'stay')
                            <input checked onclick="return false;" type="checkbox" id="all-day" name="all_day" value="1" class="check-all" {{ ((!empty($bookingdata)) && $bookingdata->all_day == 1) ? 'checked' : '' }}>
                            <label class="bc_filter" onclick="return false;" for="all-day">{{ __('All day')}}</label>
                            @else
                            <input type="checkbox" id="all-day" name="all_day" value="1" class="check-all" {{ ((!empty($bookingdata)) && $bookingdata->all_day == 1) ? 'checked' : '' }}>
                            <label class="bc_filter" for="all-day">{{ __('All day')}}</label>
                            @endif
                        </div>
                        @endif
                        @if($category == 'stay')
                        <div class="sloat-items-ul-div">

                            <div class="sloat-items-ul all_day_checkbox" style="display:block">
                                <div class="sloat-items-li">
                                    <div class="sloat-flex d-block">
                                        <div class="max-input-div">
                                            <input type="text" name="booking_note_check" id="booking_note_check" class="input booking_note_check"
                                                placeholder="Enter Booking Note" value="{{ (!empty($bookingdata)) ? $bookingdata->booking_note  : ''}}"/>
                                            <label id="booking_note_check-error" class="error" for="booking_note_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking note')}}</label>
                                        </div>
                                        <div class="max-input-div">
                                            <input type="number" min="0" max="999" name="max_booking_no_check" id="max_booking_no_check" class="input"
                                                placeholder="Max Booking No." value="{{ (!empty($bookingdata)) ? $bookingdata->max_booking_no : '' }}"/>
                                            <label id="max_booking_no_check-error" class="error" for="max_booking_no_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking number')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="sloat-items-ul-div">

                            <div class="sloat-items-ul all_day_checkbox" style="{{ (!empty($bookingdata) && $bookingdata->all_day == 1) ? 'display:block;' : 'display:none;' }}">
                                <div class="sloat-items-li">
                                    <div class="sloat-flex d-block">
                                        <div class="max-input-div">
                                            <input type="text" name="booking_note_check" id="booking_note_check" class="input booking_note_check"
                                                placeholder="Enter Booking Note" value="{{ (!empty($bookingdata)) ? $bookingdata->booking_note  : ''}}"/>
                                            <label id="booking_note_check-error" class="error" for="booking_note_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking note')}}</label>
                                        </div>
                                        <div class="max-input-div">
                                            <input type="number" min="0" max="999" name="max_booking_no_check" id="max_booking_no_check" class="input"
                                                placeholder="Max Booking No." value="{{ (!empty($bookingdata)) ? $bookingdata->max_booking_no : '' }}"/>
                                            <label id="max_booking_no_check-error" class="error" for="max_booking_no_check" style="display: none;color:red;font-size:15px;">{{ __('Please add booking number')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!empty($bookingdata) && $bookingdata->all_day != 1)
                            <?php $i=0; ?>
                                @foreach ($bookingdata->timeslots as $key => $value)
                                    <div class="sloat-items-ul timeslot_show">
                                        <?php $i++; ?>
                                        <label>{{ __('Time')}} 0{{ $i }}</label>
                                        <div class="sloat-items-li">
                                            @if($key > 0 && $date == null)
                                            <a href="javascript:;" class="remove-sloat">
                                                <i class="la la-times"></i>
                                            </a>
                                            @endif
                                            <div class="sloat-flex">
                                                <div class="sloat-flex-div">
                                                    <div class="sloat-items-grid">
                                                        <input type="hidden" value="{{$value->id??0}}" name="time_slot_val[{{ $key }}][id]">
                                                        <div class="input-group date" id="timePicker_{{ $key }}">
                                                            @php
                                                                $disabled = '';
                                                                if(isset($value->is_booked)){
                                                                    $disabled = $value->is_booked ? 'readonly ' : '';
                                                                }
                                                            @endphp
                                                            <input  type="text" class="form-control timePicker" {{$disabled}} name="time_slot_val[{{ $key }}][start_time]" id="start_time" value="{{ $value->start_time }}">
                                                            <span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span>
                                                        </div>
                                                        <label id="start_time-error" class="error" for="time_slot_val[{{ $key }}][start_time]" style="display: none;color:red;font-size:15px;">{{ __('Please select start time')}}</label>
                                                        <span>To</span>

                                                        <div class="input-group date" id="timePicker1_{{ $key }}">
                                                            <input type="text" class="form-control timePicker" name="time_slot_val[{{ $key }}][end_time]" id="end_time" value="{{ $value->end_time }}">
                                                            <span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span>
                                                        </div>
                                                        <label id="end_time-error" class="error" for="end_time" style="display: none;color:red;font-size:15px;">{{ __('Please select end time')}}</label>
                                                    </div>
                                                </div>
                                                <div class="sloat-flex-div border-left">
                                                    <div class="max-input-div">
                                                        <input type="text" name="time_slot_val[{{ $key }}][booking_note]" id="booking_note" class="input booking_note"
                                                            placeholder="Enter Booking Note" value="{{ $value->booking_note }}"/>
                                                        <label id="booking_note-error" class="error" for="booking_note" style="display: none;color:red;font-size:15px;">{{ __('Please add booking note')}}</label>
                                                    </div>
                                                    <div class="max-input-div">
                                                        <input type="number" min="0" max="999" name="time_slot_val[{{ $key }}][max_booking_no]" id="max_booking_no" class="input"
                                                            placeholder="Max Booking No." value="{{ $value->max_booking_no }}"/>
                                                        <label id="max_booking_no-error" class="error" for="max_booking_no" style="display: none;color:red;font-size:15px;">{{ __('Please add booking number')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="sloat-items-ul timeslot_show" style="{{ (empty($bookingdata)) ? 'display:block;' : 'display:none;' }}">
                                    <label>{{ __('Time')}} 01</label>
                                    <div class="sloat-items-li">
                                        {{-- <a href="javascript:;" class="remove-sloat">
                                            <i class="la la-times"></i>
                                        </a> --}}
                                        <div class="sloat-flex">
                                            <div class="sloat-flex-div">
                                                <div class="sloat-items-grid">
                                                    <div class="input-group date" id="timePicker">
                                                        <input type="text" class="form-control timePicker" name="time_slot_val[0][start_time]" id="start_time">
                                                        <span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span>
                                                    </div>
                                                    <label id="start_time-error" class="error" for="time_slot_val[0][start_time]" style="display: none;color:red;font-size:15px;">{{ __('Please select start time')}}</label>
                                                    <span>{{ __('To')}}</span>

                                                    <div class="input-group date" id="timePicker1">
                                                        <input type="text" class="form-control timePicker" name="time_slot_val[0][end_time]" id="end_time">
                                                        <span class="input-group-addon"><i class="la la-clock-o" aria-hidden="true"></i></span>
                                                    </div>
                                                    <label id="end_time-error" class="error" for="end_time" style="display: none;color:red;font-size:15px;">{{ __('Please select end time')}}</label>
                                                </div>
                                            </div>
                                            <div class="sloat-flex-div border-left">
                                                <div class="max-input-div">
                                                    <input type="text" name="time_slot_val[0][booking_note]" id="booking_note" class="input booking_note"
                                                        placeholder="Enter Booking Note" />
                                                    <label id="booking_note-error" class="error" for="booking_note" style="display: none;color:red;font-size:15px;">{{ __('Please add booking note')}}</label>
                                                </div>
                                                <div class="max-input-div">
                                                    <input type="number" min="0" max="999" name="time_slot_val[0][max_booking_no]" id="max_booking_no" class="input"
                                                        placeholder="Max Booking No." />
                                                    <label id="max_booking_no-error" class="error" for="max_booking_no" style="display: none;color:red;font-size:15px;">{{ __('Please add booking number')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        @endif
                        @if($date == null && $category != 'stay')
                            @if(!empty($bookingdata) && $bookingdata->all_day != 1)
                            <a class="add-time-sloat">
                                <i class="la la-plus"></i>
                                {{ __('Add Time Slot')}}
                            </a>
                            @else
                            <a id="add_time_slots" class="add-time-sloat @if(isset($bookingdata->all_day)) {{$bookingdata->all_day == 1 ? 'd-none' : ""}}@endif">
                                <i class="la la-plus"></i>
                                {{ __('Add Time Slot')}}
                            </a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 booking-li first-div-li">
                    <div class="booking-div">
                        <h5 class="bg-headings">{{ __('Booking Cut Off')}}</h5>
                        <div class="custom-select-drp">
                            <select class="form-control" name="booking_cut_off" id="booking_cut_off">
                                <option value="">{{ __('Select Time Span')}}</option>
                                <option value="30 min" {{ (!empty($bookingdata) && $bookingdata->booking_cut_off == '30 min') ? 'selected' : '' }}>30 min</option>
                                <option value="1 hour" {{ (!empty($bookingdata) && $bookingdata->booking_cut_off == '1 hour') ? 'selected' : '' }}>1 hr</option>
                                <option value="2 hour" {{ (!empty($bookingdata) && $bookingdata->booking_cut_off == '2 hour') ? 'selected' : '' }}>2 hr</option>
                                <option value="5 hour" {{ (!empty($bookingdata) && $bookingdata->booking_cut_off == '5 hour') ? 'selected' : '' }}>5 hr</option>
                                <option value="1 day" {{ (!empty($bookingdata) && $bookingdata->booking_cut_off == '1 day') ? 'selected' : '' }}>1 day</option>
                                <option value="2 day" {{ (!empty($bookingdata) && $bookingdata->booking_cut_off == '2 day') ? 'selected' : '' }}>2 day</option>
                                <option value="1 week" {{ (!empty($bookingdata) && $bookingdata->booking_cut_off == '1 week') ? 'selected' : '' }}>1 week</option>
                            </select>
                            <label id="booking_cut_off-error" class="error" for="booking_cut_off" style="display: none;color:red;font-size:15px;">{{ __('Please select booking cut off')}}</label>
                        </div>

                        <div class="custom-check">
                            <input type="checkbox" id="confirm-booking" name="confirm_booking" value="0"
                                class="confirm_booking" {{ ((!empty($bookingdata)) && $bookingdata->confirm_booking == 0) ? 'checked' : '' }}>
                            <label class="bc_filter" for="confirm-booking">{{ __('Confirm Booking')}}</label>
                        </div>
                        @if($category == 'stay')
                        <div class="max-input-div">
                            <input type="number" min="0" max="999" value="{{$bookingdata->max_adult_per_room??''}}" name="max_adult_per_room" id="max_adult_per_room" class="input" placeholder="Max adult per room">
                            <label id="max_adult_per_room-error" class="error" for="max_adult_per_room" style="display: none;color:red;font-size:15px;">Please add max adult per room</label>
                        </div>
                        <div class="max-input-div">
                            <input type="number" min="0" max="999" value="{{$bookingdata->max_child_per_room??''}}" name="max_child_per_room" id="max_child_per_room" class="input" placeholder="Max child per room">
                            <label id="max_child_per_room-error" class="error" for="max_child_per_room" style="display: none;color:red;font-size:15px;">Please add max child per room</label>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center booking-btn">
        <button class="btn" type="submit" id="add_booking_availibility">@if($date != null || $editData == 1) {{ __('Edit Booking')}} @else  {{ __('Add Booking')}}  @endif</button>
    </div>
</form>

<script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment-all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/calender-main.min.js') }}"></script>

<script>
<?php if(!empty($bookingdata)){
        foreach ($bookingdata->timeslots as $key => $value){ ?>

            $('#timePicker_'+<?php echo $key;?>).datetimepicker({
                format: "hh:mm A",
                allowInputToggle: true,
            });

            $('#timePicker1_'+<?php echo $key;?>).datetimepicker({
                format: "hh:mm A",
                allowInputToggle: true
            }).on('dp.change',function(){
                var starttime = $('#start_time').val();
                var endtime = $('#end_time').val();
                if(starttime != ''){
                    $('#start_time-error').css('display','none');
                    if(starttime > endtime){
                        toastr.warning("End Time must be greater than Start time");
                        $(this).val('');
                        return false;
                    }
                }else{
                    $('#start_time-error').css('display','block');
                    $('#start_time').focus();
                    $(this).val('');
                    return false;
                }
            });
<?php } } ?>
</script>
<script>
$(document).ready(function(){
    $('#timePicker').datetimepicker({
        format: "hh:mm A",
        allowInputToggle: true
    });

    $('#timePicker1').datetimepicker({
        format: "hh:mm A",
        allowInputToggle: true
    }).on('dp.change',function(){
        var starttime = $('#start_time').val();
        var startdt = moment(starttime, ["hh:mm A"]).format("HH:mm");
        console.log("startdt",startdt);
        var endtime = $('#end_time').val();
        var endtimedt = moment(endtime, ["hh:mm A"]).format("HH:mm");
        console.log("endtimedt",endtimedt);
        if(starttime != ''){
            $('#start_time-error').css('display','none');
            if(startdt > endtimedt){
                toastr.warning("End Time must be greater than Start time");
                $(this).val('');
                return false;
            }
        }else{
            $('#start_time-error').css('display','block');
            $('#start_time').focus();
            $(this).val('');
            return false;
        }
    });
    @if($date == null)
    $("#select-date1").datepicker({
        locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
        format: 'dd-mm-yyyy',
        autoclose: true,
        firstDay: 1,
        minDate: '<?php echo  date('d-m-Y H:i:s');?>',
        beforeShowDay: function (date) {return [false, ''];}
    });
    @endif
    $("#select-date2").datepicker({
        locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
        format: 'dd-mm-yyyy',
        autoclose: true,
        firstDay: 1,
        minDate: '<?php echo  date('d-m-Y H:i:s');?>',
    });
    $("#select-date3").datepicker({
        locale: '{{ (Session::get('language_code') != '') ? Session::get('language_code') : 'en' }}',
        format: 'dd-mm-yyyy',
        autoclose: true,
        firstDay: 1,
        minDate: '<?php echo  date('d-m-Y H:i:s');?>'
    });

    $('#all-day').change(function() {
        let isChecked = $('#all-day')[0].checked;
        if(isChecked){
            $("#add_time_slots").addClass('d-none');
        }else{
            $("#add_time_slots").removeClass('d-none');
        }

    });

});

</script>
