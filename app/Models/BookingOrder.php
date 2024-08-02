<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BookingOrder extends Model
{
    protected $table = 'booking_orders';

    const PAYMENT_STATUS_PENDING = 0;
    const PAYMENT_STATUS_COMPLETED = 1;
    const PAYMENT_STATUS_NOT_REQUIRED = 2;

    protected $fillable = [
        'user_id', 'name', 'email', 'phone_number', 'message', 'total_amount',
        'payable_amount', 'payment_status','charge_id','payment_intent_status',
        'no_of_room',
    ];

    public function getCreatedAtAttribute($val){
        $dateTime =  Carbon::parse($val);
        if(auth()->check() && auth()->user()->timezone != null){
            $dateTime->timezone(auth()->user()->timezone);
        }
        $dateTime->format('Y-m-d H:i:s');
        return $dateTime;
    }

    public static function getBookingPaymentStatusPhrase($booking_order_status)
    {
        if ($booking_order_status == self::PAYMENT_STATUS_PENDING) {
            return "Pending";
        }
        if ($booking_order_status == self::PAYMENT_STATUS_COMPLETED) {
            return "Paid";
        }
        if ($booking_order_status == self::PAYMENT_STATUS_NOT_REQUIRED) {
            return "Not Required";
        }
    }

    public function booking_order_items()
    {
        return $this->hasMany(BookingOrderItems::class, 'booking_order_id', 'id')->with('place_product');
    }

    public static function getBookingByMonth($date){
        $date = $date != null ? date('Y-m-d',strtotime($date)) : date('Y-m-d');
        $dateObj = Carbon::createFromFormat('Y-m-d', $date);
        $user_id = auth()->user()->id;
        $booking_history = BookingOrderItems::query()
        ->select('id','user_id','booking_order_id','place_product_id','place_id','booking_time','booking_date')
        ->with(['place.categories','place_product' => function($query){
            $query->select('id','name');
        }])
        ->where('user_id', $user_id)
        ->whereMonth('booking_date', $dateObj->format('m'))
        ->whereYear('booking_date', $dateObj->format('Y'))
        ->orderBy('id', 'DESC')
        ->get();
        $bookingObject = [];
        foreach($booking_history as $booking){
            $color = $booking->place->categories[0]->color_code ?? 'green';
            $bookingObject[] = [
                'title' => $booking->place_product->name,
                'start' => $booking->booking_date.' '.$booking->booking_time,
                // 'color' => "blue",
                'color' => $color,
            ];
        }

        /* reservation */
        $reservations = Booking::query()
        ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'place_products.name', 'place_products.color_code')
        ->leftjoin('place_products','place_products.place_id','=','bookings.place_id')
        ->with('place.categories')
        ->where('bookings.user_id', $user_id)
        ->whereMonth('bookings.date', $dateObj->format('m'))
        ->whereYear('bookings.date', $dateObj->format('Y'))
        ->orderBy('bookings.id', 'DESC')
        ->groupBy('bookings.date', 'bookings.time')
        ->get();

        foreach($reservations as $reservation){
            $color = $reservation->place->categories[0]->color_code ?? 'green';
            $bookingObject[] = [
                'title' =>'Reservation',
                'start' => $reservation->date.' '.$reservation->time,
                'color' => $color,
            ];
        }
        /* //reservation */
        return $bookingObject;

    }


    public static function getDateRange($from,$to,$dayArr,$month =""){
        $to = Carbon::parse($to)->addDay()->format('Y-m-d');

        $period = new \DatePeriod(
            new \DateTime($from),
            new \DateInterval('P1D'),
            new \DateTime($to)
        );

        $dates = [];
        // $monthArr = range($month-1,$month+1);
        foreach ($period as $key => $value) {
            if(in_array($value->format('l'),$dayArr)){
            // if(in_array($value->format('l'),$dayArr) && $value->format('m') == $month){
                $dates[] = $value->format('Y-m-d');
            }
        }
        return $dates;

    }
    public static function getMonthsRange($from,$to){
        $period = \Carbon\CarbonPeriod::create($from, '1 month', $to);
        $months = [];
        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m");
        }
        return $months;
    }

    public static function getOperatorBookingByMonth($date,$fdate,$ldate, $product_id = null){
        $firstdate = $fdate != null ? date('Y-m-d',strtotime($fdate)) : date('Y-m-d');
        $lastdate = $ldate != null ? date('Y-m-d',strtotime($ldate)) : date('Y-m-d');
        $arrayObject = [];

        $firsttime = $fdate != null ? date('Y-m-d H:i:s',strtotime($fdate)) : date('Y-m-d H:i:s');
        $lasttime = $ldate != null ? date('Y-m-d H:i:s',strtotime($ldate)) : date('Y-m-d H:i:s');

        $arrProducts = [];
        if ($product_id == null) {
            $getplace = Place::with('products')->where('user_id',Auth::user()->id)->first();
            $getplace->load('products');    
            $arrProducts = $getplace->products;
        } else {
            $arrProducts = PlaceProduct::where('id', $product_id)->get();
        }
        
        foreach($arrProducts as $product) {
            if ($product->product_code === '' || is_null($product->product_code)) {
                continue;
            }
            $product_response = app('rezdy')->get('availability', [
                'query' => [
                    'apiKey' => '90ee8baf2ee0439aaf476fa2a9b6b68f',
                    'productCode' => $product->product_code,
                    'startTimeLocal' => $firsttime,
                    'endTimeLocal' => $lasttime,
                    'limit' => '200'
                ]
            ]);
            $product_availity = json_decode($product_response->getBody(), true);
            foreach($product_availity["sessions"] as $rezdy_pro) {
                $arrayObject[] = [
                    'title' => 'rezdy',
                    'start' => $rezdy_pro["startTimeLocal"],
                    'end' => $rezdy_pro["endTimeLocal"],
                    'allDay' => $rezdy_pro["allDay"]
                ];
            }
        }

        $dateObj = Carbon::createFromFormat('Y-m-d', $date);
        $user_id = auth()->user()->id;
        $lastDayofMonth =    \Carbon\Carbon::parse($lastdate)->endOfMonth()->toDateString();
        $startDayofMonth =    \Carbon\Carbon::parse($firstdate)->startOfMonth()->toDateString();
        $query = BookingAvailibility::with('timeslots')
        ->with('place_product')
        ->whereHas('place_product', function ($query) {
            $query->whereNull('product_code')
                ->orWhere('product_code', '');
        })
        ->where(function($query1) use($dateObj,$startDayofMonth,$lastDayofMonth){
            $query1->where(function($query) use($dateObj){
                $query->where('is_recurring',0)
                ->whereMonth('date',$dateObj->format('m'))
                ->whereYear('date',$dateObj->format('Y'));
            });
            $query1->orWhere(function($que) use($startDayofMonth,$lastDayofMonth){
               $que->where('is_recurring',1);
               $que->where(function($query) use($startDayofMonth,$lastDayofMonth){
                $query->where(function($q) use($startDayofMonth,$lastDayofMonth) {
                    $q->where('available_from','<=',$startDayofMonth)->where('available_to','>=',$lastDayofMonth);
                });
                $query->orWhere(function($q) use($startDayofMonth,$lastDayofMonth) {
                    $q->where('available_from','>=',$startDayofMonth)->where('available_from','<=',$lastDayofMonth)->where('available_to','>=',$lastDayofMonth);
                });
                $query->orWhere(function($q) use($startDayofMonth,$lastDayofMonth) {
                    $q->where('available_from','<=',$startDayofMonth)->where('available_to','>=',$startDayofMonth)->where('available_to','<=',$lastDayofMonth);
                });
                $query->orWhere(function($q) use($startDayofMonth,$lastDayofMonth) {
                    $q->where('available_from','>=',$startDayofMonth)->where('available_from','<=',$lastDayofMonth)->where('available_to','<=',$lastDayofMonth)->where('available_to','>=',$startDayofMonth);
                });
             });
            });
        });

        if ($product_id === null) {
            $query = $query->where('user_id',$user_id);
        } else {
            $query = $query->where('product_id',$product_id);
        }

        $gettodaybookingavailibility = $query->get();
        
        foreach($gettodaybookingavailibility as $k=> $value){
            // dd($value);
            if($value->all_day == 1){
                if($value->is_recurring == 1){
                    $dates = self::getDateRange($value->available_from,$value->available_to,json_decode($value->recurring_value),$dateObj->format('m'));
                    foreach($dates as $singleDate){
                        $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$value->id)->where('type',0)->where('date',$singleDate)->first();
                        if(!$checktimeslotdeleted){
                            $arrayObject[] = [
                                'title' => $value->booking_note,
                                'start' => $singleDate,
                                'end' => $singleDate,
                                'allDay' => true,
                            ];
                        }
                    }
                }else{
                    $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$value->id)->where('type',0)->where('date',$value->date)->first();
                    if(!$checktimeslotdeleted){
                        $arrayObject[] = [
                            'title' => $value->booking_note,
                            'start' => $value->date,
                            'end' => $value->date,
                            'allDay' => true,
                        ];
                    }
                }
            }else{
                //dd($value);
                if($value->is_recurring == 1){
                    //dd($value->available_from);
                    $dates = self::getDateRange($value->available_from,$value->available_to,json_decode($value->recurring_value),$dateObj->format('m'));

                    foreach($value->timeslots as $timeslot){
                        foreach($dates as $singleDate){
							// $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$timeslot->id)->where('type',0)->where('date',$singleDate)->first();
                            $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('date',$singleDate)
                            ->where('type',0)
                            ->where(function($query) use($timeslot){
                                $query->where('booking_availibility_id',$timeslot->id)
                                ->orWhere('edit_id',$timeslot->id);
                            })
                            ->first();
                            if(!$checktimeslotdeleted){
                                if($timeslot->start_time != NULL && $timeslot->end_time){
                                    if($timeslot->edit_id != null){
                                        continue;
                                    }
                                    $arrayObject[] = [
                                        'title' => $timeslot->booking_note,
                                        'start' => $singleDate.' '.$timeslot->start_time,
                                        'end' => $singleDate.' '.$timeslot->end_time,
                                        'allDay' => false,
                                        'id' => $timeslot->id,
                                    ];
                                }
							}
                        }
                    }
                }elseif($value->is_recurring == 0){
                    foreach($value->timeslots as $timeslot){
                        $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$timeslot->id)->where('type',0)->where('date',$value->date)->first();
                        if(!$checktimeslotdeleted){
                            if($timeslot->start_time != NULL && $timeslot->end_time != NULL){
                                $arrayObject[] = [
                                    'title' => $timeslot->booking_note,
                                    'start' => $value->date.' '.$timeslot->start_time,
                                    'end' => $value->date.' '.$timeslot->end_time,
                                    'allDay' => false
                                ];
                            }
                        }
                    }
                }
            }
        }

        /* reservations */
        $arrProducts = [];
        if ($product_id == null) {
            $getPlaceID = Place::with('categories')->where('user_id', '=', $user_id)->first();
        } else {
            $arrProducts = PlaceProduct::where('id', $product_id)->get();
            $product_id = $arrProducts[0];

            $getPlaceID = Place::with('categories')->where('id', '=', $product_id->place_id)->first();
        }
        $placeID = $getPlaceID->id;

        if($getPlaceID->category[0] == 20){

            $reservations = Booking::query()
            ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.message', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', 'users.name', 'users.email', 'users.phone_number')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->with('place.categories')
            ->where('bookings.place_id', $placeID)
            ->where('bookings.date', '>=', $firstdate)
            ->where('bookings.date', '<=', $lastdate)
            ->orderBy('bookings.id', 'DESC')
            //->groupBy('bookings.date', 'bookings.time')
            ->get();

            foreach($reservations as $reservation){
                $color = $reservation->place->categories[0]->color_code ?? 'green';
                $arrayObject[] = [
                    'title' => 'Reservation '.$reservation->message,
                    'start' => $reservation->date.' '.$reservation->time,
                    'color' => $color,
                    'allDay' => false
                ];
            }
        }
        /* //reservations */
        return $arrayObject;

    }

    public static function getBookingByDay($start_date, $end_date){
        $startDate = date('Y-m-d H:i:s',strtotime($start_date));
        $endDate = date('Y-m-d H:i:s',strtotime($end_date));
        $startDateObj = Carbon::createFromFormat('Y-m-d H:i:s', $startDate);
        $endDateObj = Carbon::createFromFormat('Y-m-d H:i:s', $endDate);
        $user_id = auth()->user()->id;
        $booking_startDate = $startDateObj->format('Y-m-d');
        $booking_endDate = $endDateObj->format('Y-m-d');
        $booking_history = BookingOrderItems::query()
        ->select('id','user_id','booking_order_id','place_product_id','place_id','booking_time','booking_date','booking_end_time','booking_note')
        ->with(['place.categories','place_product', 'place.city' => function($query){
            $query->select('id','name');
        }])
        ->where('user_id', $user_id)
        ->where(function($query) use ($booking_startDate, $booking_endDate){
            $query->where('booking_date', '>=', $booking_startDate);
            $query->where('booking_date', '<=', $booking_endDate);
        })
        ->orderBy('id', 'DESC')
        ->get();
        // dd($booking_history->toArray());
        $bookingObject = [];
        foreach($booking_history as $booking){
            $allDay = $booking->booking_time == null ? true : false;
            $color = $booking->place->categories[0]->color_code ?? 'green';
            $category = getCategoryMakerUrl($booking->place->categories[0]->slug . '-revert.svg');
            $place_name = $booking->place->name;
            $city_name = $booking->place->city->name;
            if($booking->place->categories[0]->slug == 'stay'){
                $timeStr = 'CheckIn: ' . $booking->booking_time;
            }else{
                $timeStr = 'Time: ' . $booking->booking_time;
            }
            $placeLat = $booking->place->lat;
            $placeLng = $booking->place->lng;
            $google_map_url = "https://maps.google.com/?q=" . $placeLat
                            . "," . $placeLng
                            ."&ll=" . $placeLat . "," . $placeLng
                            ."&z=16";
            if($booking->booking_time == null){
                $bookingObject[] = [
                    'title' => '<b>'.$booking->place_product->name.'</b> | '.$booking->booking_note,
                    'start' => $booking->booking_date,
                    'color' => $color,
                    "allDay" => $allDay,
                    'category' => $category,
                    'place_name' => $place_name,
                    'city_name' => $city_name,
                    'timeStr' => $timeStr,
                    'google_map_url' => $google_map_url,
                    'color_code' => $color,
                    'booking_id' => $booking->booking_order_id,
                    'detail_url' => route('booking_details',$booking->booking_order_id),
                ];
            }else{
                $bookingObject[] = [
                    'title' => '<b>'.$booking->place_product->name.'</b> | '.$booking->booking_note,
                    'start' => $booking->booking_date.' '.$booking->booking_time,
                    'end' => $booking->booking_date.' '.$booking->booking_end_time,
                    'color' => $color,
                    "allDay" => $allDay,
                    'category' => $category,
                    'place_name' => $place_name,
                    'city_name' => $city_name,
                    'timeStr' => $timeStr,
                    'google_map_url' => $google_map_url,
                    'color_code' => $color,
                    'booking_id' => $booking->booking_order_id,
                    'detail_url' => route('booking_details',$booking->booking_order_id),
                ];
            }
        }

        /* reservation */
        $startDate = $startDateObj->format('Y-m-d');
        $endDate = $endDateObj->format('Y-m-d');
        $reservations = Booking::query()
        /* ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'place_products.name', 'place_products.color_code')
        ->leftjoin('place_products','place_products.place_id','=','bookings.place_id') */
        // ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date')
        ->with('place.categories')
        ->with('place.city')
        ->where('bookings.user_id', $user_id)
        ->where(function($query) use ($startDate, $endDate){
            $query->where('date', '>=', $startDate);
            $query->where('date', '<=', $endDate);
            //$query->whereBetween('date', [$startDate, $endDate]);
        })
        ->orderBy('id', 'DESC')
        ->get();

        foreach($reservations as $reservation){
            $allDay = $reservation->time == null ? true : false;
            $color = $reservation->place->categories[0]->color_code ?? 'green';
            $category = getCategoryMakerUrl($reservation->place->categories[0]->slug . '-revert.svg');
            $place_name = $reservation->place->name;
            $city_name = $reservation->place->city->name;
            if($reservation->place->categories[0]->slug == 'stay'){
                $timeStr = 'CheckIn: ' . $reservation->time;
            }else{
                $timeStr = 'Time: ' . $reservation->time;
            }
            $placeLat = $reservation->place->lat;
            $placeLng = $reservation->place->lng;
            $google_map_url = "https://maps.google.com/?q=" . $placeLat
                            . "," . $placeLng
                            ."&ll=" . $placeLat . "," . $placeLng
                            ."&z=16";
            $reservationMessage = '';
            if(!empty($reservation->message)){
                $reservationMessage = ' | '.$reservation->message;
            }
            if($reservation->time == null){

                $bookingObject[] = [
                    //'title' => '<b>'.$reservation->name.'</b>'.$reservationMessage,
                    'title' => '<b>Reservation</b>'.$reservationMessage,
                    'start' => $reservation->date,
                    'color' => $color,
                    "allDay" => $allDay,
                    'isReservation' => 1,
                    'reservationData' => ['reservation_id' => $reservation->id, 'user_id' => $reservation->user_id, 'place_id' => $reservation->place_id, 'date' => $reservation->date, 'time' => $reservation->time, 'address' => $reservation->place->address, 'contact' => $reservation->place->phone_number, 'email' => $reservation->place->email, 'website' => $reservation->place->website],
                    'category' => $category,
                    'place_name' => $place_name,
                    'city_name' => $city_name,
                    'timeStr' => $timeStr,
                    'google_map_url' => $google_map_url,
                    'color_code' => $color,
                ];
            }else{
                $bookingObject[] = [
                    //'title' => '<b>'.$reservation->name.'</b>'.$reservationMessage,
                    'title' => '<b>Reservation</b>'.$reservationMessage,
                    'start' => $reservation->date.' '.$reservation->time,
                    'end' => $reservation->date.' '.$reservation->time,
                    'color' => $color,
                    "allDay" => $allDay,
                    'isReservation' => 1,
                    'reservationData' => ['reservation_id' => $reservation->id, 'user_id' => $reservation->user_id, 'place_id' => $reservation->place_id, 'date' => $reservation->date, 'time' => $reservation->time, 'address' => $reservation->place->address, 'contact' => $reservation->place->phone_number, 'email' => $reservation->place->email, 'website' => $reservation->place->website],
                    'category' => $category,
                    'place_name' => $place_name,
                    'city_name' => $city_name,
                    'timeStr' => $timeStr,
                    'google_map_url' => $google_map_url,
                    'color_code' => $color,
                ];
            }
        }
        //dd($bookingObject);
        /* //reservation */

        return $bookingObject;

    }

    public static function getOperatorBookingByDay($start_date, $end_date)
    {
        $startDate = date('Y-m-d H:i:s',strtotime($start_date));
        $endDate = date('Y-m-d H:i:s',strtotime($end_date));
        $arrayObject = [];
        $firsttime = $start_date != null ? date('Y-m-d H:i:s',strtotime($start_date)) : date('Y-m-d H:i:s');
        $lasttime = $end_date != null ? date('Y-m-d H:i:s',strtotime($end_date)) : date('Y-m-d H:i:s');
        $getplace = Place::with('products')->where('user_id',Auth::user()->id)->first();
        $getplace->load('products');
        $rezdy = null;
        
        foreach($getplace->products as $product) {
            if ($product->product_code === '' || is_null($product->product_code)) {
                continue;
            }
            $product_response = app('rezdy')->get('availability', [
                'query' => [
                    'apiKey' => '90ee8baf2ee0439aaf476fa2a9b6b68f',
                    'productCode' => $product->product_code,
                    'startTimeLocal' => $firsttime,
                    'endTimeLocal' => $lasttime
                ]
            ]);
            $product_availity = json_decode($product_response->getBody(), true);
            if ($product_availity["sessions"]) {
                foreach($product_availity["sessions"] as $rezdy_pro) {
                    $arrayObject[] = [
                        'title' => 'Rezdy Integration',
                        'start' => $rezdy_pro["startTimeLocal"],
                        'end' => $rezdy_pro["endTimeLocal"],
                        'color' => $product->color_code ?? "#72bf44",
                        'extendedProps' => ['date' => $start_date, 'start_time' => substr($rezdy_pro["startTimeLocal"], 11, 8), 'end_time' => substr($rezdy_pro["endTimeLocal"], 11, 8)]
                    ];
                    $rezdy = 'rezdy';
                }
            }
        }
        $startDateObj = Carbon::createFromFormat('Y-m-d H:i:s', $startDate);
        $endDateObj = Carbon::createFromFormat('Y-m-d H:i:s', $endDate);
        $user_id = auth()->user()->id;
        $booking_startDate = $startDateObj->format('Y-m-d');
        $booking_endDate = $endDateObj->format('Y-m-d');
        $day  = $startDateObj->format('l');
        $gettodaybookingavailibility = BookingAvailibility::query()
            ->with('timeslots')
            ->select('booking_availibilities.*','place_products.name as product_name','place_products.color_code')
            ->leftjoin('place_products','place_products.id','=','booking_availibilities.product_id')
            ->where('user_id',$user_id)
            ->whereNull('place_products.product_code')
            ->orWhere('place_products.product_code', '')
            ->where(function($query1) use($booking_startDate, $booking_endDate, $day){
                $query1->where(function($query) use($booking_startDate){
                    $query->where('is_recurring',0)
                    ->where('date',$booking_startDate);
                });
                $query1->orWhere(function($query) use($booking_startDate, $booking_endDate, $day){
                    $query->where('is_recurring',1)
                    ->where('available_from','<=', $booking_startDate)
                    ->where('available_to','>=', $booking_endDate)
                    ->whereJsonContains('recurring_value',[$day]);
                });
            })->get();
        $deleteArrayObject = [];
        $tempArrayObject = [];
        if($gettodaybookingavailibility->count() > 0){
            /* reservation */
            $getPlaceID = Place::where('user_id', '=', $user_id)->first();
            $placeID = $getPlaceID->id;
            if($getPlaceID->category[0] == 20){ //Here 20 = eat category
                //DB::enableQueryLog();
                $reservations = Booking::query()
                /* ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.message', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', 'users.name', 'users.email', 'users.phone_number', 'place_products.name', 'place_products.color_code')
                ->leftjoin('place_products','place_products.place_id','=','bookings.place_id') */
                ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.message', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', 'users.name', 'users.email', 'users.phone_number')
                ->join('users', 'users.id', '=', 'bookings.user_id')
                ->with('place.categories')
                ->where('bookings.place_id', $placeID)
                ->where('bookings.date','<=',$start_date)
                ->where('bookings.date','>=',$start_date)
                ->orderBy('bookings.id', 'DESC')
                ->groupBy('bookings.date', 'bookings.time')
                ->get();
                /* $t = DB::getQueryLog();
                dd($t); */

                foreach($reservations as $reservation){
                    $color = $reservation->place->categories[0]->color_code ?? 'green';
                    $tempArrayObject[] = [
                        'title' => 'Reservation '.$reservation->message,
                        'start' => $booking_startDate.' '.$reservation->time,
                        'end' => $booking_startDate.' '.$reservation->time,
                        'color' => $color,
                        'isReservation' => 1,
                        'extendedProps' => ['isReservation' => 1, 'place_id' => $placeID, 'date' => $reservation->date, 'start_time' => $reservation->time, 'end_time' => $reservation->time]
                    ];
                }
                $arrayObject = array_merge($arrayObject,$tempArrayObject);
            }
            /* //reservation */


            if($getPlaceID->category[0] != 20){

                foreach ($gettodaybookingavailibility as $key => $value) {
                    $deletedBookingAvailibility = BookingAvailibilityTimeSlot::withoutGlobalScopes()
                    ->where('booking_availibility_id',$value->id)
                    ->where('date',$start_date)
                    ->where('is_deleted',1)
                    ->when($value->all_day == 1, function($query){
                        $query->where('start_time', null);
                    })
                    ->get();

                    foreach($deletedBookingAvailibility as $k => $val){
                        if($val->start_time == null){
                            $deleteArrayObject[] = [
                                'title' => 'Deleted slot of  '.$value->place_product->name,
                                'start' => $start_date,
                                'end' => $start_date,
                                'color' =>  "lightgray",
                                'extendedProps' => ['id' => 0],
                                // 'extendedProps' =>['booking_availibility_id' => $value->id,'show_edit_option' => false,'id' => $value->id,'all_day'=>true,'product_id' => $value->product_id,'date' => $start_date,'start_time' => null,'end_time' => null],
                            ];
                        }else{
                            $deleteArrayObject[] = [
                                'title' => 'Deleted slot of '.$value->place_product->name,
                                'start' => $booking_startDate.' '.$val->start_time,
                                'end' => $booking_startDate.' '.$val->end_time,
                                'color' =>  "lightgray",
                                'extendedProps' => ['id' => 0],
                                // 'extendedProps' =>['booking_availibility_id' => $value->id,'show_edit_option' => false,'id' => $value->id,'all_day'=>true,'product_id' => $value->product_id,'date' => $start_date,'start_time' => $val->start_time,'end_time' => $val->end_time],
                            ];
                        }
                    }

                    $getEditSlots = $value->timeslots->where('edit_id','!=',null);
                    $allday = $value->all_day == 1 ? true : false;
                    $isRecurring = $value->is_recurring == 1 ? true : false;
                    if($value->all_day == 1){

                        $totlaSlotCount = $value->max_booking_no??0;
                        $singleRecurring = true;
                        $getEditSlots = $value->timeslots->where('type',1)
                        ->where('booking_availibility_id',$value->id)
                        ->where('start_time',null)
                        ->where('date',$start_date)
                        ->first();
                        if($getEditSlots != null){
                            $totlaSlotCount = $getEditSlots->max_booking_no??0;
                            $singleRecurring = false;
                        }
                        $slotAvailibilityCount = BookingOrderItems::query()
                        ->where(['place_product_id' => $value->product_id,'booking_date' => $start_date])->count();
                        $title = $value->product_name .' '.$slotAvailibilityCount.'/'.$totlaSlotCount;
                        $showEditOption = ($allday && $isRecurring && $singleRecurring);
                        if($isRecurring){

                            $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$value->id)->where('type',0)->where('date',$start_date)->first();
                            if(!$checktimeslotdeleted){
                                $arrayObject[] = [
                                    'title' => $title,
                                    'start' => $start_date,
                                    'end' => $start_date,
                                    'color' => $value->color_code?? "#72bf44",
                                    'extendedProps' => ['recurring' => $value->is_recurring,'booking_availibility_id' => $value->id,'show_edit_option' => $showEditOption,'id' => $value->id,'all_day'=>$allday,'product_id' => $value->product_id,'date' => $start_date,'start_time' => null,'end_time' => null],
                                ];
                            }

                        }else{
                            $arrayObject[] = [
                                'title' => $title,
                                'start' => $start_date,
                                'end' => $start_date,
                                'color' => $value->color_code?? "#72bf44",
                                'extendedProps' => ['recurring' => $value->is_recurring,'booking_availibility_id' => $value->id,'show_edit_option' => $showEditOption,'id' => $value->id,'all_day'=>$allday,'product_id' => $value->product_id,'date' => $start_date,'start_time' => null,'end_time' => null],
                            ];
                        }
                    }else{
                        $allSlots = $value->timeslots->where('edit_id',null);
                        foreach($allSlots as $timeslot){
                            $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$timeslot->id)->where('type',0)->where('date',$start_date)->first();
                            if($checktimeslotdeleted === null){
                            // if(!$checktimeslotdeleted){
                                if($timeslot->start_time != NULL && $timeslot->end_time != NULL){
                                    foreach($getEditSlots as $key => $editvalue){
                                        if($timeslot->id == $editvalue->edit_id && $start_date == $editvalue->date){
                                            $timeslot = $editvalue;
                                        }
                                    }
                                    $showEditOption = ($timeslot->edit_id == null && $timeslot->type == null && $isRecurring) ? true : false;
                                    $totlaSlotCount = $timeslot->max_booking_no??0;
                                    $slotAvailibilityCount = BookingOrderItems::query()
                                    ->where(['place_product_id' => $value->product_id,'booking_date' => $start_date])
                                    ->where('booking_time', $timeslot->start_time)
                                    // ->where('booking_end_time', $timeslot->end_time)
                                    ->count();
                                    $title = $value->product_name .' '.$slotAvailibilityCount.'/'.$totlaSlotCount;
                                    $arrayObject[] = [
                                        'title' => $title,
                                        'start' => $booking_startDate.' '.$timeslot->start_time,
                                        'end' => $booking_startDate.' '.$timeslot->end_time,
                                        'color' =>  $value->color_code ?? "#72bf44",
                                        'extendedProps' => ['recurring' => $value->is_recurring,'booking_availibility_id' => $value->id,'show_edit_option' => $showEditOption,'id' => $timeslot->id,'all_day'=>$allday,'product_id' => $value->product_id,'date' => $start_date,'start_time' => $timeslot->start_time,'end_time' => $timeslot->end_time],
                                    ];
                                }
                            }
                        }
                    }
                }
                $deleteArrayObject = array_unique($deleteArrayObject, SORT_REGULAR);
                $arrayObject = array_merge($arrayObject,$deleteArrayObject);
                // dd($arrayObject);

            }
            return $arrayObject;
        }else{
            //
            if($rezdy !== null ){
                $rezdy = null;
                return $arrayObject;
            }
            $deletedBookingAvailibility = BookingAvailibilityTimeSlot::withoutGlobalScopes()
            ->where('date',$start_date)
            ->where('is_deleted',1)
            ->where('start_time', null)
            ->get();
           
            foreach($deletedBookingAvailibility as $k => $val){
                $deleteArrayObject[] = [
                    'title' => 'Deleted',
                    'start' => $start_date,
                    'end' => $start_date,
                    'color' =>  "lightgray",
                    'extendedProps' => ['id' => 0],
                ];
            }
            $arrayObject = array_unique($deleteArrayObject, SORT_REGULAR);

            /* reservation */
            $getPlaceID = Place::where('user_id', '=', $user_id)->first();
            $placeID = $getPlaceID->id;

            if($getPlaceID->category[0] == 20){ //Here 20 = eat category
                //DB::enableQueryLog();
                $reservations = Booking::query()
                /* ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.message', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', 'users.name', 'users.email', 'users.phone_number', 'place_products.name', 'place_products.color_code')
                ->leftjoin('place_products','place_products.place_id','=','bookings.place_id') */
                ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.message', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', 'users.name', 'users.email', 'users.phone_number')
                ->join('users', 'users.id', '=', 'bookings.user_id')
                ->with('place.categories')
                ->where('bookings.place_id', $placeID)
                ->where('bookings.date','<=',$start_date)
                ->where('bookings.date','>=',$start_date)
                ->orderBy('bookings.id', 'DESC')
                ->groupBy('bookings.date', 'bookings.time')
                ->get();
                /* $t = DB::getQueryLog();
                dd($t); */

                foreach($reservations as $reservation){
                    $color = $reservation->place->categories[0]->color_code ?? 'green';
                    $tempArrayObject[] = [
                        'title' => 'Reservation '.$reservation->message,
                        'start' => $booking_startDate.' '.$reservation->time,
                        'end' => $booking_startDate.' '.$reservation->time,
                        'color' => $color,
                        'isReservation' => 1,
                        'extendedProps' => ['isReservation' => 1, 'place_id' => $placeID, 'date' => $reservation->date, 'start_time' => $reservation->time, 'end_time' => $reservation->time]
                    ];
                }
                $arrayObject = array_merge($arrayObject,$tempArrayObject);
                /* //reservation */
            }

            return $arrayObject;
        }
    }

}
