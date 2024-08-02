<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Mail;

use App\Commons\Response;
use App\Services\ConvarsionService;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Place;
use App\Models\Booking;
use App\Models\BookingOrder;
use App\Models\PlaceProduct;
use App\Models\User;
use App\Models\BookingAvailibility;
use App\Models\BookingAvailibilityTimeSlot;
use App\Models\BookingOrderItems;
use App\Models\WebNotification;
use App\Models\City;
use App\Models\Category;
use App\Models\PlaceType;

use Carbon\Carbon;
use DateTime;
use Exception;
use Route;
use Stripe;

class BookingOrderController extends Controller
{

    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function addItemToCart(Request $request)
    {
        try {
            if (auth()->user()) {
                // $dateArr = explode( ' - ',$request->date);

                $user_id = auth()->user()->id;
                $place_id = $request->place_id;
                $place_product_id = $request->place_product_id;

                $number_of_adult = $request->number_of_adult;
                $number_of_children = $request->number_of_children;
                $number_of_car = $request->number_of_car;
                // $booking_date = $dateArr[0];
                // $checkout_booking_date = $dateArr[1];
                $booking_date = $request->date;
                $checkout_booking_date = $request->checkout_date;
                $slot_time = $request->time;
                $booking_time = $request->all_day == 0 ? date('H:i:s',strtotime($request->time)) : null ;


                if($number_of_adult == 0 && $number_of_car == 0) {
                    return response()->json(['status' => 'error', 'message' => __('Please enter number of adult!')]);
                }

                if($booking_date == "") {
                    return response()->json(['status' => 'error', 'message' => __('Please select booking date!')]);
                }

                if($booking_date != "") {
                    $current_date = date('Y-m-d');

                    if(strtotime($booking_date) < strtotime($current_date)) {
                        return response()->json(['status' => 'error', 'message' => __('Booking date must be greater then or equel to current date!')]);
                    }
                }
                if($request->category != 'stay' && $request->category != 'rent'){
                    if($booking_time == "" && $request->all_day == 0) {
                        return response()->json(['status' => 'error', 'message' => __('Please select booking time!')]);
                    }
                }
                $allDay = $request->all_day == 1 ? true :false;

                $availibility = BookingAvailibility::where('product_id',$place_product_id)->when($booking_date != null, function($query) use($booking_date, $place_product_id){ //get time slot when date pass
                    $query->where('product_id',$place_product_id)
                    ->where(function($query) use($booking_date,$place_product_id){
                        $query->where('date',$booking_date)
                        ->orWhere(function($query) use($booking_date,$place_product_id){
                            $query->where('available_from','<=',$booking_date)
                            ->where('available_to','>=',$booking_date);
                        });
                    });
                })
                ->get();
                
                $flag = false;
                $bookingAvailibilityResult = getRezdyBookingAvailability($place_product_id, $booking_date);

                if ($bookingAvailibilityResult != false) {
                    $slotSeats = $bookingAvailibilityResult['slot_seats'];
                    if (isset($slotSeats[$slot_time])) {
                        if ($slotSeats[$slot_time] < $number_of_adult + $number_of_children) {
                            $flag = true;
                        }
                    }
                } else {
                    foreach($availibility as $k=> $value) {
                        $checkBookingNo = BookingAvailibilityTimeSlot::query()
                            ->where('booking_availibility_id', $value->id)
                            ->where('start_time', $booking_time)
                            ->get();
                        foreach($checkBookingNo as $check) {
                            if($check->max_booking_no < $number_of_adult + $number_of_children) {
                                $flag = true;
                                break;
                            }
                        }

                        if ($flag == true) {
                            break;
                        }
                    }
                }

                if($flag == true) {
                    return response()->json(['status' => false, 'message' => __('No spots for selected time slot')]);        
                }                

                $is_place_exists = Place::where('id', $place_id)->first();
                if (!$is_place_exists) {
                    return response()->json(['status' => false, 'message' => __('Place does not exists!')]);
                }

                $is_product_exists = PlaceProduct::where('id', $place_product_id)
                ->where('place_id', $is_place_exists->id)
                ->first();
                if (!$is_product_exists) {
                    return response()->json(['status' => false, 'message' => __('Place product does not exists!')]);
                }
                $booking_endtime = '';
                $confirmbooking = 0;
                $booking_note = '';
                // $getbookingendtime = BookingAvailibility::with('timeslots')
                // ->where('product_id',$request->place_product_id)
                // ->first();
                $getbookingendtime = BookingAvailibility::where('product_id',$request->place_product_id)
                ->where('available_from','<=',dateFormat($booking_date, 'Y-m-d'))
                ->where('available_to','>=',dateFormat($booking_date, 'Y-m-d'))
                ->orWhere(function($query) use($booking_date){
                    $query->where('date',dateFormat($booking_date, 'Y-m-d'));
                })
                ->first();
                if($getbookingendtime){
                    if($getbookingendtime->all_day == 1){
                        $booking_note = $getbookingendtime->booking_note;
                    }else{
                        foreach ($getbookingendtime->timeslots as $value) {
                            $booking_note = $value->booking_note;
                        }
                    }
                    foreach ($getbookingendtime->timeslots as $value) {
                        if($booking_time == $value->start_time){
                            $booking_endtime = $value->end_time;
                        }
                    }
					$confirmbooking = $getbookingendtime->confirm_booking;
                }

                if($request->category == 'stay'){
                    if($checkout_booking_date != null) {
                        if(strtotime($booking_date) > strtotime($checkout_booking_date)) {
                            return response()->json(['status' => false, 'message' => __('Check out date must be greater than or equel to check in date!')]);
                        }
                    }else{
                        return response()->json(['status' => false, 'message' => __('Please select checkout date')]);
                    }
                    $arr = [
                        'date' => $booking_date,
                        'checkoutDate' =>  $checkout_booking_date,
                        'number_of_children' => $request->number_of_children ,
                        'number_of_adult' => $request->number_of_adult ,
                        'no_of_room' => $request->no_of_room ,
                    ];
                    $bookingAvailibility = BookingAvailibility::isBookingAvailableForStayCategory($place_product_id,$arr,$allDay);
                }else{
                    $bookingAvailibility = BookingAvailibility::isBookingAvailable($place_product_id,$arr= ['date' => $request->date,'time' => $request->time],$allDay);
                }
                if(!$bookingAvailibility['status']){
                    return response()->json($bookingAvailibility);
                };

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////


                $cartData = [
                    'user_id' => $user_id,
                    'place_id' => $place_id,
                    'place_product_id' => $place_product_id,
                    'number_of_adult' => $number_of_adult,
                    'number_of_children' => (isset($number_of_children) && $number_of_children != '') ? $number_of_children : 0,
                    'booking_date' => dateFormat($booking_date, 'Y-m-d'),
                    'checkout_date' => (isset($checkout_date)) ? dateFormat($checkout_date, 'Y-m-d') : NULL,
                    'booking_time' => (isset($booking_time)) ? $booking_time : NULL,
                    'booking_end_time' => $booking_endtime,
					'confirm_booking' => $confirmbooking,
                    'booking_note' => $booking_note,
                    'number_of_car' => $number_of_car
                ];
                // if($dateArr[1] != null){
                //     $cartData['no_of_room'] = $request->no_of_room;
                //     $cartData['checkout_date'] =dateFormat($checkout_booking_date, 'Y-m-d');
                // }
                if($request->checkout_date != null){
                    $cartData['no_of_room'] = $request->no_of_room;
                    $cartData['checkout_date'] =dateFormat($checkout_booking_date, 'Y-m-d');
                }
                Cart::create($cartData);
                $cartItemsCount = Cart::getMyCartItemsCount();

                $event = 'AddtoCart';
                ConvarsionService::conversionAPI($event,url('/').'/'.Route::current()->getName());

                return $this->response->formatResponse(200, ['count' => $cartItemsCount], __('Added to cart!'));
            } else {
                return $this->response->formatResponse(401, [], __('Login required'));
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => __('Something went wrong!!')]);
        }
    }

    public function removeItemToCart(Request $request)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $item_id = $request->item_id;
            $delete_item = Cart::where('id', $item_id)->where('user_id', $user_id)->delete();
            if ($delete_item) {
                $cartItemsCount = Cart::getMyCartItemsCount();
                return response()->json(['status' => true, 'count' => $cartItemsCount, 'message' => __('Item removed from your cart successfully!')]);
            } else {
                return response()->json(['status' => false, 'message' => __('Something went wrong to remove item!')]);
            }
        }
    }

    public function clearItemToCart(Request $request)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $delete_item = Cart::where('user_id', $user_id)->delete();
            if ($delete_item) {
                return response()->json(['status' => true, 'message' => __('Item removed from your cart successfully!')]);
            } else {
                return response()->json(['status' => false, 'message' => __('Something went wrong to remove item!')]);
            }
        }
    }

    public function cartListing()
    {

        $notAvailibileItems = [];
        $user_id = auth()->user()->id;
        $user_info = User::query()
            ->where('id', $user_id)
            ->first();
        $cartItems = Cart::query()
        ->where('user_id', $user_id)
        ->with('place')->with('user')
        ->with('place_product')
        ->has('place_product')
        ->get();
        $total =  Cart::getCartItemtotalAmount();
        return view('frontend.cart.cart',
            ['cartItems' => $cartItems,
            'total' => $total,
            'user_info' => $user_info]);
    }


    public function bookingSummary()
    {

        $total =  Cart::getCartItemtotalAmount();
        $charge = Config::get('app.stripe_user_charge');
        $booking_fee = 0;
        if(!isUserHaveMembership()){
            $booking_fee = $total * 0.019;
        }
        $totalwithcharges =  $total + $charge + $booking_fee;
        $total = number_format($total, 2);
        $totalwithcharges =  number_format($totalwithcharges,2);
        return view('frontend.cart.booking_summary', ['total' => $total, 'booking_fee' => $booking_fee, 'charge'=>$charge,'totalwithcharges'=>$totalwithcharges]);
    }


    public function bookingDetails($booking_id)
    {
        $user_id = auth()->user()->id;
        $user_info = User::where('id', $user_id)
                    ->select('id', 'name', 'avatar', 'phone_number', 'email', 'phone_number', 'user_note')
                    ->first();
        $booking_order = BookingOrder::query()->where('id', $booking_id)
            ->with('booking_order_items')->first();
        $operator = User::where('id', $booking_order->booking_order_items['0']->place->user_id)
            ->first();

        if ($booking_order == NULL) {
            return abort(404);
        }

        if (!auth()->user()) {
            return redirect(route('home'))->with('error', __('Login required'));
          }

        return view('frontend.cart.booking_details',
            [
                'booking_order' => $booking_order,
                'user_info'     => $user_info,
                'operator'      => $operator
            ]);
    }

    public function addUsernote(Request $request)
    {

        $data = $this->validate($request, [
            'user_note' => 'nullable',
        ]);
        $user = User::find(Auth::id());
        $user->fill($data)->save();
        return back();
    }

    public function getBookingByMonth(Request $request){
        $date = $request->date ?? null;
        $bookingObject = BookingOrder::getBookingByMonth($date);
        return response()->json(['status' => true, 'message' => 'success', 'data' => $bookingObject]);
    }

    public function getBookingByDay(Request $request){
        $start_date = $request->start ?? null;
        $end_date = $request->end ?? null;
        $bookingObject = [];
        if(($start_date != null || $start_date != "") && ($end_date != null || $end_date != "")){
            $bookingObject = BookingOrder::getBookingByDay($start_date, $end_date);
        }
        return response()->json($bookingObject);

    }

    public function bookingHistory()
    {
        if(!auth()->check()){
            return redirect('/');
        }
        $user_id = auth()->user()->id;
        $user_info = User::where('id', $user_id)
                    ->select('name', 'avatar', 'phone_number', 'email', 'phone_number')
                    ->first();
        $booking_orders = BookingOrder::select(
            'booking_orders.*',
            'booking_order_items.*',
            'pt.name as place_name',
            'places.city_id as place_city_id',
            'places.category as place_category',
            'places.place_type as place_type',
            'places.lat as place_lat',
            'places.lng as place_lng',
            'places.thumb as place_thumb',
            'places.logo as place_logo'
        )
        ->leftjoin('booking_order_items','booking_order_items.booking_order_id','=','booking_orders.id')
        ->leftjoin('places','booking_order_items.place_id','=','places.id')
        ->join('place_translations as pt', 'pt.place_id', '=', 'places.id')
        ->where('booking_orders.user_id', $user_id)
        ->orderBy('booking_orders.id', 'DESC')
        ->groupBy('booking_orders.id')
        ->get();

        $bookingObject = BookingOrder::getBookingByMonth(date('Y-m-d'));
        $isMembership = isUserHaveMembership();

        /* reservation history */
        $reservations = Booking::query()
        ->select(
            'bookings.id',
            'bookings.user_id',
            'bookings.place_id',
            'bookings.date',
            'bookings.time',
            'bookings.status AS booking_status',
            'pt.name as place_name',
            'places.address',
            'places.phone_number as place_contact',
            'places.email',
            'places.city_id as place_city_id',
            'places.category as place_category',
            'places.place_type as place_type',
            'places.lat as place_lat',
            'places.lng as place_lng',
            'places.thumb as place_thumb',
            'places.logo as place_logo'
            )
        //->with('places')
        ->join('places', 'places.id', '=', 'bookings.place_id')
        ->join('place_translations as pt', 'pt.place_id', '=', 'places.id')
        ->join('users', 'users.id', '=', 'places.user_id')
        ->where('bookings.user_id', '=', auth()->user()->id)
        ->orderBy('bookings.id', 'DESC')
        ->get();
        //dd($reservations);
        /* reservation history */

        $arrCities = [];
        $arrTempData = City::all();
        foreach ($arrTempData as $city) {
            $arrCities[$city->id] = $city->name;
        }
        $arrCategory = [];
        $tempCategory = Category::select('id', 'icon_map_marker', 'color_code')
                    ->get();
        foreach ($tempCategory as $cate) {
            $arrCategory[$cate->id] = [
                'marker' =>   $cate->icon_map_marker,
                'color' =>   $cate->color_code
            ];
        }
        $arrPlacetype = [];
        $arrTempDataType = PlaceType::all();
        foreach ($arrTempDataType as $type) {
            $arrPlacetype[$type->id] = $type->name;
        }
        return view(
            'frontend.cart.booking_history', compact(
                'booking_orders', 'bookingObject', 'isMembership', 'reservations', 'user_info',
                'arrCities', 'arrCategory', 'arrPlacetype'
            )
        );
    }

    //Operator - Start
    public function operatorBookingList()
    {
        $today_date = date("Y-m-d");
        $user_id = auth()->user()->id;
        $user_info = User::where('id', $user_id)
                    ->select('name', 'avatar', 'phone_number', 'email', 'phone_number')
                    ->first();
        if(isOperatorUser() && !isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->first();
        }
        if(isOperatorUser() && isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->get();
        }

        $booking_confirmed_orders =
            //DB::raw('sum(booking_order_items.price) as payable_amount')
            BookingOrder::query()
            ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
            ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
            ->join('places', 'places.id', '=', 'place_products.place_id')
            ->select('booking_orders.*', 'booking_order_items.*','place_products.name as product_name', 'places.name as place_name' )
            ->where('places.user_id', $user_id)
            ->whereIn('booking_orders.payment_intent_status',['succeeded','canceled'])
            ->where('booking_order_items.booking_date', $today_date)
            ->orderBy('booking_order_items.booking_time', 'ASC')
            ->orderBy('booking_order_items.place_product_id', 'ASC')
            ->get();
        $arrBookingConfirmedData = [];
        foreach ($booking_confirmed_orders as $info) {
            if (isset($arrBookingConfirmedData[$info->booking_time]) == false) {
                $arrBookingConfirmedData[$info->booking_time] = [];
            }
            if (isset($arrBookingConfirmedData[$info->place_product_id]) == false) {
                $arrBookingConfirmedData[$info->booking_time][$info->place_product_id] = [];
            }
            $arrBookingConfirmedData[$info->booking_time][$info->place_product_id][] = $info;
        }

        // ->get();
        $booking_confirmed_slots = BookingAvailibilityTimeSlot::query()
            ->join('booking_availibilities', 'booking_availibilities.id', '=', 'booking_availibility_time_slots.booking_availibility_id' )
            ->join('place_products', 'booking_availibilities.product_id', '=', 'place_products.id')
            ->select('booking_availibility_time_slots.*',
                'booking_availibilities.user_id as user_id',
                'booking_availibilities.product_id',
                'booking_availibilities.recurring_value',
                'place_products.name as product_name')
            ->where('booking_availibilities.user_id', $user_id)
            // ->where('booking_availibilities.recurring_value', 'like', '%' . date('l') . '%')
            ->get();
        $arrSlotInfo = [];
        foreach ($booking_confirmed_slots as $slot_info) {
            $arrSlotInfo[$slot_info->start_time][$slot_info->product_id] = $slot_info;
        }
        $get_to_confirm_order = BookingOrder::query()->select('booking_orders.*','booking_order_items.booking_order_id','booking_order_items.place_id','booking_order_items.place_product_id','place_products.name as product_name')
        ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
        ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
        ->join('places', 'places.id', '=', 'place_products.place_id')
        ->where('places.user_id', $user_id)
        ->where('booking_orders.payment_intent_status','pending')
        ->groupBy('booking_orders.id')
        ->orderBy('id', 'DESC')
        ->paginate();

        // echo "<pre>";
        // print_r($get_to_confirm_order);die;

        $getplace = Place::with('products')->where('user_id',Auth::user()->id)->first();
        $logo = null;
        $category = null;
        if($getplace){
            $logo = $getplace->logo != null ? getImageUrl($getplace->logo) : null;
            $category = $getplace->categories->first()->slug?? null;
        }
        /* reservation */
        $getPlaceData = Place::where('user_id',Auth::user()->id)->first();
        $place_id = null;
        if($getPlaceData){
            $place_id = $getPlaceData->id;
        }
        
        /* echo $getplace->category[0];
        dd($getplace); */
        //dd($getPlaceData);
        $reservations = Booking::query()
        ->select('bookings.id as reservation_id', 'bookings.place_id', 'bookings.numbber_of_adult', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', DB::raw('DATE_FORMAT(bookings.date, "%d-%m-%Y") AS date'), DB::raw('DATE_FORMAT(bookings.time, "%h:%i %p") as time'), DB::raw('DATE_FORMAT(bookings.created_at, "%d-%m-%Y %h:%i %p") as created_at'), 'bookings.status', 'users.id', 'users.name', 'users.email', 'users.phone_number as user_phone_number')
        ->join('users', 'users.id', '=', 'bookings.user_id')
        ->where('bookings.place_id', '=', $place_id)
        ->whereIn('bookings.status', [1,3])
        ->orderBy('bookings.id', 'Desc')
        ->paginate();

        $reservationsToConfirms = Booking::query()
        ->select('bookings.id as reservation_id', 'bookings.place_id', 'bookings.numbber_of_adult', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', DB::raw('DATE_FORMAT(bookings.date, "%d-%m-%Y") AS date'), DB::raw('DATE_FORMAT(bookings.time, "%h:%i %p") as time'), DB::raw('DATE_FORMAT(bookings.created_at, "%d-%m-%Y %h:%i %p") as created_at'), 'users.id', 'users.name', 'users.email', 'users.phone_number as user_phone_number')
        ->join('users', 'users.id', '=', 'bookings.user_id')
        ->where('bookings.place_id', '=', $place_id)
        ->where('bookings.status', '=', 2)
        ->orderBy('bookings.id', 'Desc')
        ->paginate();
        /* reservation */

        $today = date('Y-m-d'); // Get today's date in yyyy-mm-dd format
        $day_of_week = date('w', strtotime($today)); // Get the day of the week (0-6, where 0 is Sunday)

        // Calculate the date of the Sunday before the current date
        $sunday = date('Y-m-d', strtotime("-$day_of_week days", strtotime($today)));

        // Create an empty array to hold the dates of the week
        $dates_of_week = array();

        // Loop through the days of the week, adding each date to the array
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime("+$i days", strtotime($sunday)));
            array_push($dates_of_week, $date);
        }

        $arrDate = [];
        foreach ($dates_of_week as $date) {
           $events = BookingOrder::query()
           ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
           ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
           ->join('places', 'places.id', '=', 'place_products.place_id')
           ->where('places.user_id', $user_id)
           ->whereIn('booking_orders.payment_intent_status',['succeeded','canceled'])
           ->where('booking_order_items.booking_date', $date)
           ->count();
            $arrDate[] = [
                'date'      =>  $date,
                'events'    =>  $events
            ];
        }

        return view(
            'frontend.operator_bookings.booking_list',
            ['logo' => $logo,
            'arrBookingConfirmedData' => $arrBookingConfirmedData,
            'get_to_confirm_order'=>$get_to_confirm_order,
            'products'=>$getplace,
            'category' => $category,
            'reservations' => $reservations,
            'reservationsToConfirms' => $reservationsToConfirms,
            'user_info' => $user_info,
            'operator_place' => $operator_place,
            'arrDate' => $arrDate,
            'arrSlotInfo' => $arrSlotInfo]
        );
    }

    public function operatorGetpreviousweek(Request $request){
        $user_id = auth()->user()->id;
        $previous_startdate = $request->date;
        $current_date = date('Y-m-d', strtotime($previous_startdate .' -1 day'));
        $color = $request->color;
        $day_of_week = date('w', strtotime($current_date)); // Get the day of the week (0-6, where 0 is Sunday)

        // Calculate the date of the Sunday before the current date
        $sunday = date('Y-m-d', strtotime("-$day_of_week days", strtotime($current_date)));

        // Create an empty array to hold the dates of the week
        $dates_of_week = array();

        // Loop through the days of the week, adding each date to the array
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime("+$i days", strtotime($sunday)));
            array_push($dates_of_week, $date);
        }

        $arrDate = [];
        foreach ($dates_of_week as $date) {
           $events = BookingOrder::query()
           ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
           ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
           ->join('places', 'places.id', '=', 'place_products.place_id')
           ->where('places.user_id', $user_id)
           ->whereIn('booking_orders.payment_intent_status',['succeeded','canceled'])
           ->where('booking_order_items.booking_date', $date)
           ->count();
            $arrDate[] = [
                'date'      =>  $date,
                'events'    =>  $events
            ];
        }

        $next_end_date = date('Y-m-d', strtotime($arrDate[6]['date'] .' +1 day'));
        $pre_start_date = date('Y-m-d', strtotime($arrDate[0]['date'] .' -1 day'));
        $next_week_month = date('M',strtotime($next_end_date));
        $pre_week_month = date('M',strtotime($pre_start_date));

        $html = ' <div class="operator-weekbar-pre" data-day = "' . $arrDate[0]['date'] . '" data-color = "' . $color . '" data-month = "' . $pre_week_month . '"><i class="fas fa-caret-left"></i></div>';
        foreach($arrDate as $day){
            $week_month = date('M',strtotime($day['date']));
            $week_day = date('d', strtotime($day['date']));
            $html .='<div class="operator-weekbar-day" data-day="' . $day['date'] . '">
            <div class="weekday-month">' . $week_month . '</div>
            <div class="weekday-day">' . $week_day . '</div><div class="weekday-events" style="color:' . $color . '">';
            for ($i = 0; $i < $day['events']; $i++){
                $html .= '<i class="fas fa-circle"></i>';
            }
            $html .= '</div></div>';
        }
        $html .= '<div class="operator-weekbar-next" data-day = "' . $arrDate[6]['date'] . '" data-color = "' . $color . '" data-month = "' . $next_week_month . '"><i class="fas fa-caret-right"></i></div>';
        return $html;
    }

    public function operatorGetnextweek(Request $request){
        $user_id = auth()->user()->id;
        $previous_enddate = $request->date;
        $current_date = date('Y-m-d', strtotime($previous_enddate .' +1 day'));
        $color = $request->color;
        $day_of_week = date('w', strtotime($current_date)); // Get the day of the week (0-6, where 0 is Sunday)

        // Calculate the date of the Sunday before the current date
        $sunday = date('Y-m-d', strtotime("-$day_of_week days", strtotime($current_date)));

        // Create an empty array to hold the dates of the week
        $dates_of_week = array();

        // Loop through the days of the week, adding each date to the array
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime("+$i days", strtotime($sunday)));
            array_push($dates_of_week, $date);
        }

        $arrDate = [];
        foreach ($dates_of_week as $date) {
           $events = BookingOrder::query()
           ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
           ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
           ->join('places', 'places.id', '=', 'place_products.place_id')
           ->where('places.user_id', $user_id)
           ->whereIn('booking_orders.payment_intent_status',['succeeded','canceled'])
           ->where('booking_order_items.booking_date', $date)
           ->count();
            $arrDate[] = [
                'date'      =>  $date,
                'events'    =>  $events
            ];
        }

        $next_end_date = date('Y-m-d', strtotime($arrDate[6]['date'] .' +1 day'));
        $pre_start_date = date('Y-m-d', strtotime($arrDate[0]['date'] .' -1 day'));
        $next_week_month = date('M',strtotime($next_end_date));
        $pre_week_month = date('M',strtotime($pre_start_date));

        $html = ' <div class="operator-weekbar-pre" data-day = "' . $arrDate[0]['date'] . '" data-color = "' . $color . '" data-month = "' . $pre_week_month . '"><i class="fas fa-caret-left"></i></div>';
        foreach($arrDate as $day){
            $week_month = date('M',strtotime($day['date']));
            $week_day = date('d', strtotime($day['date']));
            $html .='<div class="operator-weekbar-day" data-day="' . $day['date'] . '">
            <div class="weekday-month">' . $week_month . '</div>
            <div class="weekday-day">' . $week_day . '</div><div class="weekday-events" style="color:' . $color . '">';
            for ($i = 0; $i < $day['events']; $i++){
                $html .= '<i class="fas fa-circle"></i>';
            }
            $html .= '</div></div>';
        }
        $html .= '<div class="operator-weekbar-next" data-day = "' . $arrDate[6]['date'] . '" data-color = "' . $color . '" data-month = "' . $next_week_month . '"><i class="fas fa-caret-right"></i></div>';
        return $html;
    }

    public function operatorGetConfirmList(Request $request){
        $select_date = $request->date;
        $user_id = auth()->user()->id;
        if(isOperatorUser() && !isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->first();
        }
        if(isOperatorUser() && isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->get();
        }
        $booking_confirmed_orders =
            //DB::raw('sum(booking_order_items.price) as payable_amount')
            BookingOrder::query()
            ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
            ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
            ->join('places', 'places.id', '=', 'place_products.place_id')
            ->select('booking_orders.*', 'booking_order_items.*','place_products.name as product_name', 'places.name as place_name' )
            ->where('places.user_id', $user_id)
            ->whereIn('booking_orders.payment_intent_status',['succeeded','canceled'])
            ->where('booking_order_items.booking_date', $select_date)
            ->orderBy('booking_order_items.booking_time', 'ASC')
            ->orderBy('booking_order_items.place_product_id', 'ASC')
            ->get();
        $arrBookingConfirmedData = [];
        foreach ($booking_confirmed_orders as $info) {
            if (isset($arrBookingConfirmedData[$info->booking_time]) == false) {
                $arrBookingConfirmedData[$info->booking_time] = [];
            }
            if (isset($arrBookingConfirmedData[$info->booking_time][$info->place_product_id]) == false) {
                $arrBookingConfirmedData[$info->booking_time][$info->place_product_id] = [];
            }
            $arrBookingConfirmedData[$info->booking_time][$info->place_product_id][] = $info;
        }
        $booking_confirmed_slots = BookingAvailibilityTimeSlot::query()
            ->join('booking_availibilities', 'booking_availibilities.id', '=', 'booking_availibility_time_slots.booking_availibility_id' )
            ->join('place_products', 'booking_availibilities.product_id', '=', 'place_products.id')
            ->select('booking_availibility_time_slots.*',
                'booking_availibilities.user_id as user_id',
                'booking_availibilities.product_id',
                'booking_availibilities.recurring_value',
                'place_products.name as product_name')
            ->where('booking_availibilities.user_id', $user_id)
            // ->where('booking_availibilities.recurring_value', 'like', '%' . date('l') . '%')
            ->get();
        $arrSlotInfo = [];
        foreach ($booking_confirmed_slots as $slot_info) {
            $arrSlotInfo[$slot_info->start_time][$slot_info->product_id] = $slot_info;
        }
        $get_to_confirm_order = BookingOrder::query()->select('booking_orders.*','booking_order_items.booking_order_id','booking_order_items.place_id','booking_order_items.place_product_id','place_products.name as product_name')
        ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
        ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
        ->join('places', 'places.id', '=', 'place_products.place_id')
        ->where('places.user_id', $user_id)
        ->where('booking_orders.payment_intent_status','pending')
        ->groupBy('booking_orders.id')
        ->orderBy('id', 'DESC')
        ->paginate();

        // echo "<pre>";
        // print_r($get_to_confirm_order);die;

        $getplace = Place::with('products')->where('user_id',Auth::user()->id)->first();
        $logo = $getplace->logo != null ? getImageUrl($getplace->logo) : null;
        $category = $getplace->categories->first()->slug?? null;

        /* reservation */
        $getPlaceData = Place::where('user_id',Auth::user()->id)->first();
        $place_id = $getPlaceData->id;
        /* echo $getplace->category[0];
        dd($getplace); */
        //dd($getPlaceData);
        $reservations = Booking::query()
        ->select('bookings.id as reservation_id', 'bookings.place_id', 'bookings.numbber_of_adult', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', DB::raw('DATE_FORMAT(bookings.date, "%d-%m-%Y") AS date'), DB::raw('DATE_FORMAT(bookings.time, "%h:%i %p") as time'), DB::raw('DATE_FORMAT(bookings.created_at, "%d-%m-%Y %h:%i %p") as created_at'), 'bookings.status', 'users.id', 'users.name', 'users.email', 'users.phone_number as user_phone_number')
        ->join('users', 'users.id', '=', 'bookings.user_id')
        ->where('bookings.place_id', '=', $place_id)
        ->whereIn('bookings.status', [1,3])
        ->orderBy('bookings.id', 'Desc')
        ->paginate();

        $reservationsToConfirms = Booking::query()
        ->select('bookings.id as reservation_id', 'bookings.place_id', 'bookings.numbber_of_adult', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', DB::raw('DATE_FORMAT(bookings.date, "%d-%m-%Y") AS date'), DB::raw('DATE_FORMAT(bookings.time, "%h:%i %p") as time'), DB::raw('DATE_FORMAT(bookings.created_at, "%d-%m-%Y %h:%i %p") as created_at'), 'users.id', 'users.name', 'users.email', 'users.phone_number as user_phone_number')
        ->join('users', 'users.id', '=', 'bookings.user_id')
        ->where('bookings.place_id', '=', $place_id)
        ->where('bookings.status', '=', 2)
        ->orderBy('bookings.id', 'Desc')
        ->paginate();
        /* reservation */

        $html = view(
            'frontend.operator_bookings.confirmed_booking_list',
            ['logo' => $logo,
            'arrBookingConfirmedData' => $arrBookingConfirmedData,
            'get_to_confirm_order'=>$get_to_confirm_order,
            'products'=>$getplace,
            'category' => $category,
            'reservations' => $reservations,
            'reservationsToConfirms' => $reservationsToConfirms,
            'operator_place' => $operator_place,
            'arrSlotInfo' => $arrSlotInfo]
        )->render() ;
        return $html;
    }

    public function BookingSlotDetail(Request $request){
        $select_date = $request->date;
        $slot_id = $request->slot_id;
        $user_id = auth()->user()->id;
        if(isOperatorUser() && !isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->first();
        }
        if(isOperatorUser() && isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->get();
        }
        $booking_confirmed_slots = BookingAvailibilityTimeSlot::query()
        ->join('booking_availibilities', 'booking_availibilities.id', '=', 'booking_availibility_time_slots.booking_availibility_id' )
        ->join('place_products', 'booking_availibilities.product_id', '=', 'place_products.id')
        ->select('booking_availibility_time_slots.*',
            'booking_availibilities.user_id as user_id',
            'booking_availibilities.product_id',
            'booking_availibilities.recurring_value',
            'place_products.name as product_name')
        ->where('booking_availibility_time_slots.id', $slot_id)
        // ->where('booking_availibilities.recurring_value', 'like', '%' . date('l') . '%')
        ->first();
        $booking_confirmed_orders =
            BookingOrder::query()
            ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
            ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
            ->join('places', 'places.id', '=', 'place_products.place_id')
            ->select('booking_orders.*', 'booking_order_items.*','place_products.name as product_name', 'places.name as place_name' )
            ->where('places.user_id', $user_id)
            ->whereIn('booking_orders.payment_intent_status',['succeeded','canceled'])
            ->where('booking_order_items.booking_date', $select_date)
            ->where('booking_order_items.booking_time', $booking_confirmed_slots->start_time)
            ->where('booking_order_items.place_product_id', $booking_confirmed_slots->product_id)
            ->get();

        $getplace = Place::with('products')->where('user_id',Auth::user()->id)->first();
        $logo = $getplace->logo != null ? getImageUrl($getplace->logo) : null;
        $category = $getplace->categories->first()->slug?? null;

        /* reservation */
        $getPlaceData = Place::where('user_id',Auth::user()->id)->first();
        $place_id = $getPlaceData->id;
        /* echo $getplace->category[0];
        dd($getplace); */
        //dd($getPlaceData);
        // $reservations = Booking::query()
        // ->select('bookings.id as reservation_id', 'bookings.place_id', 'bookings.numbber_of_adult', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', DB::raw('DATE_FORMAT(bookings.date, "%d-%m-%Y") AS date'), DB::raw('DATE_FORMAT(bookings.time, "%h:%i %p") as time'), DB::raw('DATE_FORMAT(bookings.created_at, "%d-%m-%Y %h:%i %p") as created_at'), 'bookings.status', 'users.id', 'users.name', 'users.email', 'users.phone_number as user_phone_number')
        // ->join('users', 'users.id', '=', 'bookings.user_id')
        // ->where('bookings.place_id', '=', $place_id)
        // ->whereIn('bookings.status', [1,3])
        // ->orderBy('bookings.id', 'Desc')
        // ->paginate();

        // $reservationsToConfirms = Booking::query()
        // ->select('bookings.id as reservation_id', 'bookings.place_id', 'bookings.numbber_of_adult', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', DB::raw('DATE_FORMAT(bookings.date, "%d-%m-%Y") AS date'), DB::raw('DATE_FORMAT(bookings.time, "%h:%i %p") as time'), DB::raw('DATE_FORMAT(bookings.created_at, "%d-%m-%Y %h:%i %p") as created_at'), 'users.id', 'users.name', 'users.email', 'users.phone_number as user_phone_number')
        // ->join('users', 'users.id', '=', 'bookings.user_id')
        // ->where('bookings.place_id', '=', $place_id)
        // ->where('bookings.status', '=', 2)
        // ->orderBy('bookings.id', 'Desc')
        // ->paginate();
        /* reservation */

        $html = view(
            'frontend.operator_bookings.booking_slot_detail',
            ['logo' => $logo,
            'booking_confirmed_orders' => $booking_confirmed_orders,
            'products'=>$getplace,
            'category' => $category,
            // 'reservations' => $reservations,
            // 'reservationsToConfirms' => $reservationsToConfirms,
            'operator_place' => $operator_place,
            'booking_confirmed_slots' => $booking_confirmed_slots,
            'select_date' => $select_date]
        )->render() ;
        return $html;
    }

    public function getOperatorBookingByMonth(){
        $date = request()->date ?? null;
        $firstdate = request()->firstdate ?? null;
        $lastdate = request()->lastdate ?? null;
        $product_id = request()->product_id ?? null;

        $bookingObject = BookingOrder::getOperatorBookingByMonth($date,$firstdate,$lastdate,$product_id);
        
        return response()->json(['status' => true, 'message' => 'success', 'data' => $bookingObject]);
    }
    public function getgetOperatorBookingByDay(Request $request){
        $start_date = $request->start ?? null;
        $end_date = $request->end ?? null;
        $bookingObject = [];
        if(($start_date != null || $start_date != "") && ($end_date != null || $end_date != "")){
            $bookingObject = BookingOrder::getOperatorBookingByDay($start_date, $end_date);
        }
        // return response()->json(['status' => true, 'message' => 'success', 'data' => $bookingObject]);
        return response()->json($bookingObject);

    }
    public function operatorBookingItems($booking_id)
    {

        $user_id = auth()->user()->id;

        //DB::raw('sum(booking_order_items.price) as payable_amount')
        $booking_order = BookingOrder::query()->select('booking_orders.*','places.id as place_id','places.slug')
            ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
            ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
            ->join('places', 'places.id', '=', 'place_products.place_id')
            ->where('places.user_id', $user_id)
            ->where('booking_orders.id', $booking_id)
            ->groupBy('booking_orders.id')
            ->first();


        $booking_order_items = BookingOrder::query()->select('booking_order_items.*', 'place_products.thumb','places.slug')
            ->join('booking_order_items', 'booking_order_items.booking_order_id', '=', 'booking_orders.id')
            ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
            ->join('places', 'places.id', '=', 'place_products.place_id')
            ->where('places.user_id', $user_id)
            ->where('booking_orders.id', $booking_id)
            // ->groupBy('booking_orders.id')
            ->get();

        if ($booking_order == NULL) {
            return abort(404);
        }

        return view(
            'frontend.operator_bookings.booking_items',
            [
                'booking_order' => $booking_order,
                'booking_order_items' => $booking_order_items
            ]
        );
    }

    public function AddBookingAvailibility(Request $request)
    {

        $editmode = $request->editmode ?? 0;   // value 1  id only for date slot edit
        $update_all  = $request->update_all  ?? 0;
        $confirm_booking = $request->confirm_booking?? 1;
        $all_day_field = $request->all_day_field ?? 0;
        $deletePendingbooking = 0;

        if($request->all_day == 1 || ($editmode == 1 && $request->all_day_field == 1)){
            if($request->max_booking_no_check <= 0){
                return response()->json(['status'=>false,'message'=>'Max booking number must be greater than 0']);
            }
        }else{
            if(min(array_column($request->time_slot_val,'max_booking_no')) <= 0){
                return response()->json(['status'=>false,'message'=>'Max booking number must be greater than 0']);
            }
        }
        if(!isset($request->all_day) && $all_day_field == 0){
            $checktimeslot = $this->checkTimeSlotOverlapping($request->time_slot_val);
            if($checktimeslot != '' && !$checktimeslot['status']){
                return response()->json(['status'=>false,'message'=>$checktimeslot['message']]);
            }
        }
        $editDate = Carbon::parse($request->date)->format('Y-m-d');
        $getexistsavailibility = BookingAvailibility::where('id',$request->booking_availibility_id)->first();

        $post['user_id'] = Auth::user()->id;
        if($request->category !== 'eat') {
            $post['product_id'] =  $request->product_id;
            $post['place_id'] = null;
        } else {
            $post['place_id'] =  $request->product_id;
            $post['product_id'] = null;
        }
        $post['booking_cut_off'] = $request->booking_cut_off;
        $post['max_adult_per_room'] = $request->max_adult_per_room ?? null;
        $post['max_child_per_room'] = $request->max_child_per_room ?? null;
        $post['confirm_booking'] = $confirm_booking;
        if($editmode != 1){
            if(isset($request->is_recurring)){
                $post['is_recurring'] = $request->is_recurring;
                $post['recurring_value'] = json_encode($request->recurring_value);
                $post['available_from'] = Carbon::parse($request->available_from)->format('Y-m-d');
                $post['available_to'] = Carbon::parse($request->available_to)->format('Y-m-d');
                $post['date'] = '';
            }else{
                $post['date'] = $editDate;
                $post['is_recurring'] = 0;
                $post['recurring_value'] = '';
                $post['available_from'] = '';
                $post['available_to'] = '';
            }
        }
        if($getexistsavailibility == null){   //add mode
            if(isset($request->is_recurring)){
                $post['is_recurring'] = $request->is_recurring;
                $post['recurring_value'] = json_encode($request->recurring_value);
                $post['available_from'] = Carbon::parse($request->available_from)->format('Y-m-d');
                $post['available_to'] = Carbon::parse($request->available_to)->format('Y-m-d');
                $post['date'] = '';
            }else{
                $post['date'] = $editDate;
                $post['is_recurring'] = 0;
                $post['recurring_value'] = '';
                $post['available_from'] = '';
                $post['available_to'] = '';
            }
            $product_id = $request->product_id;
            $date  = $request->date != null ?  Carbon::parse($request->date)->format('Y-m-d') : null;
            if($editmode != 1){
                // check DateConflict with exisiting BookingAvailability
                $validateDateConflict = BookingAvailibility::validateDateConflict($product_id,$date,$post['available_from'],$post['available_to'], $post['is_recurring'], $post['recurring_value']);
                if($validateDateConflict['status'] == false){
                    return response()->json($validateDateConflict);
                }
            }
            if(isset($request->all_day)){
                $post['all_day'] = $request->all_day;
                $post['booking_note'] = $request->booking_note_check;
                $post['max_booking_no'] = $request->max_booking_no_check;
                // dd($post,'all',$request->all());
                $save = BookingAvailibility::create($post);
            }else{
                // dd($post,'slot',$request->all());
                $save = BookingAvailibility::create($post);
                if($save){
                    $data['booking_availibility_id'] = $save->id;
                    foreach($request->time_slot_val as $value){
                        $data['start_time'] = Carbon::parse($value['start_time'])->format('H:i:s');
                        $data['end_time'] = Carbon::parse($value['end_time'])->format('H:i:s');
                        $data['booking_note'] = $value['booking_note'];
                        $data['max_booking_no'] = $value['max_booking_no'];
                        BookingAvailibilityTimeSlot::create($data);
                    }
                }
            }
        }else{   //edit mode

            if(isset($request->all_day) || ($all_day_field == 1 && $editmode == 1 ) ){  //allday

                if($request->date != null && $editmode == 0){
                    $post['date'] = $editDate;
                    $post['is_recurring'] = 0;
                    $post['recurring_value'] = '';
                    $post['available_from'] = '';
                    $post['available_to'] = '';
                }
                if(!($request->is_recurring_field == 1 && !isset($request->all_day) && $request->date != null && $all_day_field == 1 && $editmode == 1)){
                    $post['all_day'] = isset($request->all_day) ? $request->all_day :  $request->all_day_field;
                    $post['booking_note'] = $request->booking_note_check;
                    $post['max_booking_no'] = $request->max_booking_no_check;
                    $getexistsavailibility->update($post);
                    BookingAvailibilityTimeSlot::where('booking_availibility_id',$request->booking_availibility_id)
                    ->delete();
                }
                $save = true;
                //
                $available_from = date('Y-m-d',strtotime($request->available_from));
                $available_to = date('Y-m-d',strtotime($request->available_to));

                if(isset($request->all_day) && $all_day_field == 1 && $editmode == 0 ){
                    $checkbookings = BookingOrderItems::query()
                    ->where('ref_id',$request->booking_availibility_id)
                    ->where('booking_time',null)
                    ->whereBetween('booking_date', [$available_from, $available_to])->get();
                    foreach($checkbookings as $k => $checkbooking){
                        $bookingData['booking_availibility_id'] = $request->booking_availibility_id;
                        $bookingData['date'] = $checkbooking->booking_date;
                        $bookingData['is_deleted'] = 1;
                        $bookingData['booking_note'] = 'Deleted allDay';
                        // BookingAvailibilityTimeSlot::create($bookingData);
                        if($checkbooking->confirm_booking == 1){
                            BookingAvailibilityTimeSlot::create($bookingData);
                        }else{
                            $status = $checkbooking->booking_order->payment_intent_status;
                            if($status == 'succeeded'){
                                BookingAvailibilityTimeSlot::create($bookingData);
                            }else{
                                if($checkbooking->booking_order->payment_intent_status == 'pending'){
                                    $deletePendingbooking ++;
                                    $place_id = $checkbooking->place_id;
                                    $place_product_id = $checkbooking->place_product_id;
                                    $user_id = $checkbooking->user_id;
                                    $datetime = $checkbooking->booking_date .' '. $checkbooking->booking_time;
                                    $productName = $checkbooking->place_product->name;
                                    $body = 'Your booking request of '.$productName.' for '.$datetime .' was declined due to booking capacity';
                                    $this->sendDeletenotification($body,$place_id,$place_product_id,$user_id);
                                }
                                $checkbooking->booking_order->delete();
                                $checkbooking->delete();
                            }
                        }
                        //
                    }
                }elseif(isset($request->all_day) && $all_day_field == 0 && $editmode == 0){
                    // delete all slot data
                    $deletetimeslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$getexistsavailibility->id)->get();
                    foreach($deletetimeslots as $deletetimeslot){
                        $checkbookings = BookingOrderItems::query()
                        ->where('ref_id',$deletetimeslot->id)
                        ->where('booking_time','!=',null)
                        ->get();
                        foreach($checkbookings as $k => $checkbooking){
                            $bookingData['booking_availibility_id'] = $deletetimeslot->booking_availibility_id;
                            $bookingData['date'] = $checkbooking->booking_date;
                            $bookingData['edit_id'] = $deletetimeslot->id;
                            $bookingData['is_deleted'] = 1;
                            $bookingData['booking_note'] = 'Deleted';
                            $bookingData['start_time'] = $deletetimeslot->start_time;
                            $bookingData['end_time'] = $deletetimeslot->end_time;
                            // BookingAvailibilityTimeSlot::create($bookingData);
                            if($checkbooking->confirm_booking == 1){
                                BookingAvailibilityTimeSlot::create($bookingData);
                            }else{
                                $status = $checkbooking->booking_order->payment_intent_status;
                                if($status == 'succeeded'){
                                    BookingAvailibilityTimeSlot::create($bookingData);
                                }else{
                                    if($checkbooking->booking_order->payment_intent_status == 'pending'){
                                        $deletePendingbooking ++;
                                        $place_id = $checkbooking->place_id;
                                        $place_product_id = $checkbooking->place_product_id;
                                        $user_id = $checkbooking->user_id;
                                        $datetime = $checkbooking->booking_date .' '. $checkbooking->booking_time;
                                        $productName = $checkbooking->place_product->name;
                                        $body = 'Your booking request of '.$productName.' for '.$datetime .' was declined due to booking capacity';
                                        $this->sendDeletenotification($body,$place_id,$place_product_id,$user_id);
                                    }
                                    $checkbooking->booking_order->delete();
                                    $checkbooking->delete();
                                }
                            }
                            //
                       }
                       $deletetimeslot->delete();
                    }
                }
                elseif(!isset($request->all_day) && $request->date != null && $all_day_field == 1 && $editmode == 1){
                    if($request->is_recurring_field == 1){
                        // edit single date with all day option
                        $editedBookingData['type'] = BookingAvailibilityTimeSlot::TYPEEDIT;
                        $editedBookingData['booking_availibility_id'] = $request->booking_availibility_id;
                        $editedBookingData['date'] = date('Y-m-d',strtotime($request->date));
                        $matchThese = $editedBookingData;
                        $editedBookingData['booking_note'] = $request->booking_note_check;
                        $editedBookingData['max_booking_no'] = $request->max_booking_no_check;
                        // BookingAvailibilityTimeSlot::create($editedBookingData);
                        BookingAvailibilityTimeSlot::updateOrCreate($matchThese,$editedBookingData);
                    }else{
                        $save = $getexistsavailibility->update($post);
                    }
                }
                //
                // $deletetimeslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$getexistsavailibility->id)->delete();
            }else{  //slot done
                $post['all_day'] = 0;
                $post['booking_note'] = '';
                $post['max_booking_no'] = 0;
                $save = $getexistsavailibility->update($post);
                if($save){
                    if($editmode == 1){ // edit only single date data (done)
                        foreach($request->time_slot_val as $value){
                            $start_time =Carbon::parse($value['start_time'])->format('H:i:s');
                            $end_time =Carbon::parse($value['end_time'])->format('H:i:s');
                            $slot = BookingAvailibilityTimeSlot::query()
                            ->where('id',$value['id'])
                            ->first();
                            $data['start_time'] = $start_time;
                            $data['booking_availibility_id'] = $getexistsavailibility->id;
                            $data['end_time'] = $end_time;
                            $data['booking_note'] = $value['booking_note'];
                            $data['max_booking_no'] = $value['max_booking_no'];
                            if($getexistsavailibility->is_recurring == 0){
                                BookingAvailibilityTimeSlot::where('id',$value['id'])->first()->update($data);
                            }else{
                                if($slot->edit_id == null){
                                    if($update_all == 1){
                                        BookingAvailibilityTimeSlot::where('id',$value['id'])->first()->update($data);
                                    }else{
                                        $data['type'] = BookingAvailibilityTimeSlot::TYPEEDIT;
                                        $data['date'] = date('Y-m-d',strtotime($request->date));
                                        $data['edit_id'] = $value['id'];
                                        BookingAvailibilityTimeSlot::create($data);
                                    }
                                }else{
                                    BookingAvailibilityTimeSlot::where('id',$value['id'])->first()->update($data);
                                }
                            }
                        }
                    }else{ // edit all slot data (done)
                        // $deletetimeslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$getexistsavailibility->id)->delete();
                        // delete old slot and add thoes entry if booking exist in booking table
                        $deletetimeslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$getexistsavailibility->id)->get();
                        foreach($deletetimeslots as $deletetimeslot){
                            $checkbookings = BookingOrderItems::query()
                            ->where('ref_id',$deletetimeslot->id)
                            ->where('booking_time','!=',null)
                            ->get();
                            // dd($deletetimeslots->toArray());
                            // dd($checkbookings->toArray());
                            foreach($checkbookings as $k => $checkbooking){
                                $bookingData['booking_availibility_id'] = $deletetimeslot->booking_availibility_id;
                                $bookingData['date'] = $checkbooking->booking_date;
                                $bookingData['edit_id'] = $deletetimeslot->id;
                                $bookingData['is_deleted'] = 1;
                                $bookingData['booking_note'] = 'Deleted';
                                $bookingData['start_time'] = $deletetimeslot->start_time;
                                $bookingData['end_time'] = $deletetimeslot->end_time;
                                // BookingAvailibilityTimeSlot::create($bookingData);
                                if($checkbooking->confirm_booking == 1){
                                    BookingAvailibilityTimeSlot::create($bookingData);
                                }else{
                                    $status = $checkbooking->booking_order->payment_intent_status;
                                    if($status == 'succeeded'){
                                        BookingAvailibilityTimeSlot::create($bookingData);
                                    }else{
                                        if($checkbooking->booking_order->payment_intent_status == 'pending'){
                                            $deletePendingbooking ++;
                                            $place_id = $checkbooking->place_id;
                                            $place_product_id = $checkbooking->place_product_id;
                                            $user_id = $checkbooking->user_id;
                                            $datetime = $checkbooking->booking_date .' '. $checkbooking->booking_time;
                                            $productName = $checkbooking->place_product->name;
                                            $body = 'Your booking request of '.$productName.' for '.$datetime .' was declined due to booking capacity';
                                            $this->sendDeletenotification($body,$place_id,$place_product_id,$user_id);
                                        }
                                        $checkbooking->booking_order->delete();
                                        $checkbooking->delete();
                                    }
                                }
                           }

                           $deletetimeslot->delete();
                        }
                        // delete old slot and add thoes entry if booking exist in booking table

                        $data['booking_availibility_id'] = $getexistsavailibility->id;
                        foreach($request->time_slot_val as $value){
                            $startTime =  Carbon::parse($value['start_time'])->format('H:i:s');
                            $endTime  = Carbon::parse($value['end_time'])->format('H:i:s');
                            $data['start_time'] = $startTime;
                            $data['end_time'] = $endTime;
                            $data['booking_note'] = $value['booking_note'];
                            $data['max_booking_no'] = $value['max_booking_no'];
                            BookingAvailibilityTimeSlot::create($data);
                            $dl = BookingAvailibilityTimeSlot::withoutGlobalScopes()
                            ->where('is_deleted',1)
                            ->where('start_time',$startTime)
                            ->where('end_time',$endTime)
                            ->where('booking_availibility_id', $getexistsavailibility->id)
                            ->delete();
                        }
                    }
                }
            }
        }
        if(isset($request->editmode) && $request->editmode == 1){
            $res = response()->json(['status' => true, 'message'=>'Booking availability edited successfully!','data' => $save]);
            if($deletePendingbooking > 0){
                $res = response()->json([
                    'status' => true,
                    'message'=>'Booking availability edited successfully!, there are '.$deletePendingbooking.' booking are pending for confirmation was deleted',
                    'data' => $save
                ]);
            }
            return $res;
        }else{
            $message = 'Successfully added your booking availability!';
            if($request->editform == 1){
                $message ='Booking availability edited successfully!';
                if($deletePendingbooking > 0){
                    $message = 'Booking availability edited successfully!, there are '.$deletePendingbooking.' booking are pending for confirmation was deleted';
                }
            }
            return response()->json(['status' => true, 'message' => $message,'data' => $save]);
            // if($save){
            // }else{
            //     return response()->json(['status' => false, 'message'=>'Something went wrong!']);
            // }
        }
    }

    public function checkBookingAvailbity($product_id,$bookingDate,$bookingTime){
        $booking = BookingOrderItems::where('place_product_id',$product_id)
        ->where('booking_date',$bookingDate)
        ->where('booking_time',$bookingTime)
        ->first();
        return $booking != null ? true : false;
    }


    public function LoadBookingData(Request $request)
    {

        $editData = 0;
        $mode  =  isset($request->mode) ? 0 : 1;
        $updateAll =  isset($request->update_all) ?  $request->update_all  : 0; // option for edit all slot or single
        $reqDate = $request->date != null && $updateAll == 0 ?  $request->date : null;
        $request->merge(['date' => $reqDate]);  // set date null for edit all slot of reccuring booking_availibility
        $getbookingdata = BookingAvailibility::where('id',$request->booking_availibility_id)
        ->with(['timeslots' =>function($query) use($request,$mode,$updateAll){
            $query->when(($mode == 1 &&  $request->all_day == 'false' && $request->date != null), function($query) use($request){
                $query->where('id',$request->slot_id);
            });
            $query->when(($mode == 1 &&  $updateAll ==1), function($query) use($request){
                $query->where('edit_id',null)
                ->where('type',null);
            });
        }])
        ->first();
        if($getbookingdata != null){
            $editData = 1;
            if($getbookingdata->all_day != 1){
                $allSlots = $getbookingdata->timeslots;
                $newAllSlots = [];
                foreach($allSlots as $timeslot){
                    $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('date',$request->date)
                    ->where('type',0)
                    ->where(function($query) use($timeslot){
                        $query->where('booking_availibility_id',$timeslot->id)
                        ->orWhere('edit_id',$timeslot->id);
                    })
                    ->first();
                    if(!$checktimeslotdeleted){
                        $timeslot->is_booked = $this->checkBookingAvailbity($getbookingdata->product_id,$request->date,$timeslot->start_time);
                        $newAllSlots[] = $timeslot;
                    }
                }
                $getbookingdata->timeslots = $newAllSlots;
            }else{
                if($updateAll != 1){
                    $getEditSlots = $getbookingdata->timeslots->where('type',1)
                    ->where('booking_availibility_id',$getbookingdata->id)
                    ->where('start_time',null)
                    ->where('date',$request->date)
                    ->first();
                    if($getEditSlots != null){
                        $getbookingdata->max_booking_no = $getEditSlots->max_booking_no??0;
                        $getbookingdata->booking_note = $getEditSlots->booking_note??'note';
                    }
                }
            }
        }
        $getplace = Place::with('products')->where('user_id',Auth::user()->id)->first();
        return view('frontend.operator_bookings.booking_availibility_form',['bookingdata'=>$getbookingdata,'products'=>$getplace,'product_id'=>$request->product_id,'date' => $request->date,'editData' => $editData]);
    }

    private function sendDeletenotification($body,$place_id,$place_product_id,$user_id){
        // send notification to user when book availabilty deleted from operator side
        $webNotification = WebNotification::create(
            [
                'title' => 'Booking request declined',
                'body' => $body,
                'image' => null,
                'type' => 2,
                // 'delete_type' => 4,
                'place_id' => $place_id,
                'product_id' => $place_product_id,
                'redirect_to' => "booking_history",
                'for_user_id' => $user_id,
            ]
        );
        //
    }

    public function DeleteAllDayBooking(Request $r)
    {
        // dd($r->all());
        $deletePendingbooking = 0;
        $recurringAllDelete = $r->recurring_all_delete == 'true' ? true : false;
        if($r->allday == 'true'){
            $checkbookingavailability = BookingAvailibility::where('id',$r->id)->where('all_day',1)->first();
            if(!empty($checkbookingavailability)){
                // if($checkbookings->count() > 0){
                    //     return response()->json(['status' => false, 'message'=>'Warning, you have bookings already made for this time slot, by deleting you ensure no new bookings will be made, but you must contact them yourself to arrange refunds']);
                    // }else{

                    $checkbookings = BookingOrderItems::where('booking_date',$r->date)
                    ->where('ref_id',$checkbookingavailability->id)->get();
                    foreach($checkbookings as $booking){
                        $bookingData['booking_availibility_id'] = $r->id;
                        $bookingData['date'] = $r->date;
                        $bookingData['is_deleted'] = 1;
                        $bookingData['booking_note'] = 'Deleted';
                        if($booking->confirm_booking == 1){
                            BookingAvailibilityTimeSlot::create($bookingData);
                        }else{
                            $status = $booking->booking_order->payment_intent_status;
                            if($status == 'succeeded'){
                                BookingAvailibilityTimeSlot::create($bookingData);
                            }else{
                                if($booking->booking_order->payment_intent_status == 'pending'){
                                    $deletePendingbooking ++;
                                    $place_id = $booking->place_id;
                                    $place_product_id = $booking->place_product_id;
                                    $user_id = $booking->user_id;
                                    $datetime = $booking->booking_date .' '. $booking->booking_time;
                                    $productName = $booking->place_product->name;
                                    $body = 'Your booking request of '.$productName.' for '.$datetime .' was declined due to booking capacity';
                                    $this->sendDeletenotification($body,$place_id,$place_product_id,$user_id);
                                }
                                $booking->booking_order->delete();
                                $booking->delete();
                            }
                        }
                    }

                    if($checkbookingavailability->is_recurring == 1){
                        $data['booking_availibility_id'] = $r->id;
                        $data['type'] = 0;
                        $data['date'] = $r->date;
                        $save = BookingAvailibilityTimeSlot::create($data);
                        if($save){
                            $res = response()->json(['status' => true, 'message'=>'Successfully deleted']);
                            if($deletePendingbooking > 0){
                                $res = response()->json([
                                    'status' => true,
                                    'message'=>'Successfully deleted, there are '.$deletePendingbooking.' booking are pending for confirmation was deleted',
                                ]);
                            }
                            if($recurringAllDelete){
                                $checkbookingavailability->timeslots()->delete();
                                $checkbookingavailability->delete();
                            }
                            return $res;
                        }else{
                            return response()->json(['status' => false, 'message'=>'Something went wrong!']);
                        }
                    }else{
                        $save = BookingAvailibility::where('id',$r->id)->delete();
                        if($save){
                            $res = response()->json(['status' => true, 'message'=>'Successfully deleted']);
                            if($deletePendingbooking > 0){
                                $res = response()->json([
                                    'status' => true,
                                    'message'=>'Successfully deleted, there are '.$deletePendingbooking.' booking are pending for confirmation was deleted',
                                ]);
                            }
                            if($recurringAllDelete){
                                $checkbookingavailability->timeslots()->delete();
                                $checkbookingavailability->delete();
                            }
                            return $res;
                        }else{
                            return response()->json(['status' => false, 'message'=>'Something went wrong!']);
                        }
                    }
                // }
            }else{
                return response()->json(['status' => false, 'message'=>'Data not found!']);
            }
        }else{
            $gettimeslot = BookingAvailibilityTimeSlot::where('id',$r->id)->first();
            if(!empty($gettimeslot)){
                $bookingavailability = BookingAvailibility::where('id',$gettimeslot->booking_availibility_id)->first();
                $editId = $gettimeslot->edit_id;
                $checkbookings = BookingOrderItems::where('booking_date',$r->date)->where('booking_time',$gettimeslot->start_time)->where('booking_end_time',$gettimeslot->end_time)->get();
                // if($checkbookings->count() > 0){
                    // return response()->json(['status' => false, 'message'=>'Warning, you have bookings already made for this time slot, by deleting you ensure no new bookings will be made, but you must contact them yourself to arrange refunds']);
                    // }else{
                if($r->alldelete == 1){
                    $gettimslotdata = BookingAvailibilityTimeSlot::where('booking_availibility_id',$gettimeslot->booking_availibility_id)->get();
                    if($gettimslotdata->count() > 0){
                        foreach($gettimslotdata as $timeslot){
                            //
                            $checkbookings = BookingOrderItems::query()
                            ->with(['booking_order'])
                            ->where('booking_date',$r->date)
                            ->where('ref_id',$timeslot->id)
                            ->where('booking_time','!=',null)
                            ->get();
                            if($checkbookings->count() > 0){
                                BookingAvailibilityTimeSlot::withoutGlobalScopes()->where('is_deleted',1)
                                ->where('date',$r->date)
                                ->where('edit_id',$timeslot->id)
                                ->delete();
                            }
                            foreach($checkbookings as $booking){
                                $bookingData['booking_availibility_id'] = $gettimeslot->booking_availibility_id;
                                $bookingData['date'] = $r->date;
                                $bookingData['edit_id'] = $gettimeslot->id;
                                $bookingData['is_deleted'] = 1;
                                $bookingData['booking_note'] = 'Deleted';
                                $bookingData['start_time'] = $booking->booking_time;
                                $bookingData['end_time'] = $booking->booking_end_time;
                                // BookingAvailibilityTimeSlot::create($bookingData);
                                if($booking->confirm_booking == 1){
                                    BookingAvailibilityTimeSlot::create($bookingData);
                                }else{
                                    $status = $booking->booking_order->payment_intent_status;
                                    if($status == 'succeeded'){
                                        BookingAvailibilityTimeSlot::create($bookingData);
                                    }else{
                                        if($booking->booking_order->payment_intent_status == 'pending'){
                                            $deletePendingbooking ++;
                                            $place_id = $booking->place_id;
                                            $place_product_id = $booking->place_product_id;
                                            $user_id = $booking->user_id;
                                            $datetime = $booking->booking_date .' '. $booking->booking_time;
                                            $productName = $booking->place_product->name;
                                            $body = 'Your booking request of '.$productName.' for '.$datetime .' was declined due to booking capacity';
                                            $this->sendDeletenotification($body,$place_id,$place_product_id,$user_id);
                                        }
                                        $booking->booking_order->delete();
                                        $booking->delete();
                                    }
                                }
                            }
                            //
                            $bookingAvailibility = $timeslot->bookingAvailibility??null; // handle single date with timeslot delete
                            if($bookingAvailibility !=null && $bookingAvailibility->is_recurring == 0){
                                \Log::info('single date slot');
                                \Log::info($timeslot);
                                $bookingAvailibility->delete();
                                $timeslot->delete();
                            }
                            $data['booking_availibility_id'] = $timeslot->id;
                            $data['type'] = 0;
                            $data['date'] = $r->date;
                            $data['edit_id'] = $editId;
                            $save = BookingAvailibilityTimeSlot::create($data);
                        }
                        if($save){
                            $res = response()->json(['status' => true, 'message'=>'Successfully deleted']);
                            if($deletePendingbooking > 0){
                                $res = response()->json([
                                    'status' => true,
                                    'message'=>'Successfully deleted, there are '.$deletePendingbooking.' booking are pending for confirmation was deleted',
                                ]);
                            }
                            if($recurringAllDelete){
                                $bookingavailability->timeslots()->withoutGlobalScopes()->delete()??null;
                                $bookingavailability->delete();
                            }
                            return $res;
                        }else{
                            return response()->json(['status' => false, 'message'=>'Something went wrong!']);
                        }
                    }else{
                        return response()->json(['status' => false, 'message'=>'Data not found!']);
                    }
                }else{
                    //

                    $checkbookings = BookingOrderItems::with(['booking_order'])
                    ->where('booking_date',$r->date)
                    ->where('ref_id',$r->id)
                    ->where('booking_time','!=',null)
                    ->get();
                    foreach($checkbookings as $booking){
                        $bookingData['booking_availibility_id'] = $gettimeslot->booking_availibility_id;
                        $bookingData['date'] = $r->date;
                        $bookingData['is_deleted'] = 1;
                        $bookingData['booking_note'] = 'Deleted';
                        $bookingData['start_time'] = $gettimeslot->start_time;
                        $bookingData['end_time'] = $gettimeslot->end_time;
                        $bookingData['edit_id'] = $gettimeslot->id;
                        if($booking->confirm_booking == 1){
                            BookingAvailibilityTimeSlot::create($bookingData);
                        }else{
                            $status = $booking->booking_order->payment_intent_status;
                            if($status == 'succeeded'){
                                BookingAvailibilityTimeSlot::create($bookingData);
                            }else{
                                if($booking->booking_order->payment_intent_status == 'pending'){
                                    $deletePendingbooking ++;
                                    $place_id = $booking->place_id;
                                    $place_product_id = $booking->place_product_id;
                                    $user_id = $booking->user_id;
                                    $datetime = $booking->booking_date .' '. $booking->booking_time;
                                    $productName = $booking->place_product->name;
                                    $body = 'Your booking request of '.$productName.' for '.$datetime .' was declined due to booking capacity';
                                    $this->sendDeletenotification($body,$place_id,$place_product_id,$user_id);
                                }
                                $booking->booking_order->delete();
                                $booking->delete();
                            }
                        }
                    }
                    //

                    $bookingAvailibility = $gettimeslot->bookingAvailibility??null; // handle single date with timeslot delete
                    if($bookingAvailibility !=null && $bookingAvailibility->is_recurring == 0){
                        \Log::info('single date slot');
                        \Log::info($gettimeslot);
                        $bookingAvailibility->delete();
                        $gettimeslot->delete();
                        $save =true;
                    }else{
                        $data['booking_availibility_id'] = $r->id;
                        $data['type'] = 0;
                        $data['date'] = $r->date;
                        $data['edit_id'] = $editId;
                        $save = BookingAvailibilityTimeSlot::create($data);
                    }
                    if($save){
                        $res = response()->json(['status' => true, 'message'=>'Successfully deleted']);
                        if($deletePendingbooking > 0){
                            $res = response()->json([
                                'status' => true,
                                'message'=>'Successfully deleted, there are '.$deletePendingbooking.' booking are pending for confirmation was deleted',
                            ]);
                        }
                        if($recurringAllDelete){
                            $bookingavailability->timeslots()->withoutGlobalScopes()->delete()??null;
                            $bookingavailability->delete();
                        }
                        return $res;
                    }else{
                        return response()->json(['status' => false, 'message'=>'Something went wrong!']);
                    }
                }
                // }
            }else{
                return response()->json(['status' => false, 'message'=>'Data not found!']);
            }
        }
    }

    public function get_all_booking_data_by_time(Request $request) {
        try {
            $bookings = BookingOrderItems::with([
                'place_product' => function($query){
                    $query->select('id','name','price');
                },
                'user' => function($query){
                    $query->select('id','name','email');
                },
            ])
            ->where('place_product_id',$request->id)
            ->where('booking_date',$request->date)
            ->when($request->allday == "false", function($query) use($request){
                $query->where('booking_time',$request->start_time)
                ->where('booking_end_time',$request->end_time);
            })->get();
            $html = '';
            if(count($bookings) > 0){
                foreach($bookings as $k => $booking){
                    $price =  ($booking->price * $booking->number_of_adult)+($booking->child_price * $booking->number_of_children);
                    $username = $booking->user->name ?? '-';
                    $product = $booking->place_product->name ?? '-';
                    $bookingTime = $request->allday == "false" ? $booking->booking_date.' '.$booking->booking_time :  $booking->booking_date;
                    $html .= '<tr><td>'.$booking->id.'</td>
                    <td>'.$product.'</td>
                    <td>'.$username.'</td>
                    <td>$'.$price.'</td>
                    <td>'.$bookingTime.'</td>
                    <td>
                    <span style="text-transform: capitalize;" class="status bg-light">'.$booking->booking_order->payment_intent_status.'</span>
                    </td>
                    </tr>';
                }
            }else{
                $html .= '<tr><td colspan="5" class="text-center">'.__("No booking found").'</td><tr>';
            }

            /* reservation */
            $user_id = auth()->user()->id;
            $getPlaceID = Place::where('user_id', '=', $user_id)->first();
            $place_id = $getPlaceID->id;

            $html_reservation = '';
            $reservations = Booking::query()
            ->select('bookings.id as reservation_id', 'bookings.numbber_of_adult', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', 'bookings.date', 'bookings.time', 'bookings.created_at', 'users.id', 'users.name', 'users.email', 'users.phone_number as user_phone_number')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.place_id', '=', $place_id)
            ->where('date', $request->date)
            ->where('time', $request->start_time)->get();

            if($reservations->count() > 0){
                foreach($reservations as $reservation){

                    $html_reservation .= '<tr>
                    <td>'.$reservation->reservation_id.'</td>
                    <td>'.($reservation->name ?? '-').'</td>
                    <td>'.($reservation->user_phone_number ?? '-').'</td>
                    <td>'.($reservation->email ?? '-').'</td>
                    <td>'.($reservation->numbber_of_adult ?? '-').'</td>
                    <td>'.($reservation->numbber_of_children ?? '-').'</td>
                    <td>'.(dateFormat($reservation->created_at). ' ' .Carbon::parse($reservation->created_at)->format('h:i A')).'</td>
                    <td>'.(dateFormat($reservation->date).' '.Carbon::parse($reservation->time)->format('h:i A')).'</td>
                    </tr>';
                }
            }
            /* //reservation */
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message'=>$th->getMessage()]);
        }
        return response()->json(['status' => true, 'message'=>'success', 'data' => ['html' => $html, 'html_reservation' => $html_reservation]]);
    }

	public function ConfirmBooking(Request $r)
    {
        $getbookingdata = BookingOrder::where('id',$r->booking_id)->first();
        $onlinePaymentRequired = $getbookingdata->booking_order_items->first()->place_product->online_payment_required;

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        if(!empty($getbookingdata)){
            try{
                if($onlinePaymentRequired){
                    $result = $stripe->charges->capture($getbookingdata->charge_id, []);
                    if($result){
                        $getbookingdata->payment_intent_id = $result->id;
                        $getbookingdata->payment_intent_status = $result->status;
                        $getbookingdata->save();
                        $getbookingitems = BookingOrderItems::where('booking_order_id',$r->booking_id)->first();
                        $getbookingitems->confirm_booking = 1;
                        $getbookingitems->save();
                        $bookingData = BookingOrder::where('id',$r->booking_id)->first();
                        dispatch(new \App\Jobs\UserNewBookingEmailJob([
                            'user_id' => $getbookingdata->user_id,
                            'name' =>  $getbookingdata->name,
                            'email' => $getbookingdata->email,
                            'phone_number' => $getbookingdata->phone_number,
                            'cart_items' => $bookingData->booking_order_items,
                            'total' => $getbookingdata->booking_order_items->sum(function ($data) {
                                return $data->totalPrice();
                            }),
                            'send_mail_to' => $getbookingdata->email
                        ]));

                        $booking_ref_for_stripe = 'BOOKING_' . $getbookingdata->id;
                        $getoperator = BookingOrderItems::select('booking_order_items.*','users.id as operator_id','users.name', 'users.email', 'users.stripe_account_id')
                                    ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
                                    ->join('places', 'places.id', '=', 'booking_order_items.place_id')
                                    ->join('users', 'users.id', '=', 'places.user_id')
                                    ->where('booking_order_items.booking_order_id',$r->booking_id)
                                    ->where('booking_order_items.place_id',$r->place_id)
                                    ->first();
                        if(!empty($getoperator)){
                            if ($getoperator->stripe_account_id != NULL) {
                                $place_products = PlaceProduct::query()->where('id', $getoperator->place_product_id)->first();
                                $total = 0;
                                if(!empty($place_products)){
                                    if ($place_products->online_payment_required == 1) {
                                        $total_adult = $getoperator->number_of_adult;
                                        $total_child = $getoperator->number_of_children;
                                        $total_car = $getoperator->number_of_car;
                                        // CHECK DISCOUNT FOR ADULTS
                                        if (checkIfOnDiscount($place_products)) {
                                            $adult_unit_price = checkIfOnDiscount($place_products, true);
                                            $adult_total_price = $total_adult * $adult_unit_price;
                                        } else {
                                            $adult_unit_price = cleanDecimalZeros($place_products->price);
                                            $adult_total_price = $total_adult * $adult_unit_price;
                                        }
                                        // CHECK DISCOUNT FOR CHILDREN
                                        if (checkIfOnChildDiscount($place_products)) {
                                            $child_unit_price = checkIfOnChildDiscount($place_products, true);
                                            $child_total_price = $total_child * $child_unit_price;
                                        } else {
                                            $child_unit_price = cleanDecimalZeros($place_products->child_price);
                                            $child_total_price = $total_child * $child_unit_price;
                                        }

                                        if (checkIfOnCarDiscount($place_products)) {
                                            $car_unit_price = checkIfOnCarDiscount($place_products, true);
                                            $car_total_price = $total_car * $car_unit_price;
                                        } else {
                                            $car_unit_price = cleanDecimalZeros($place_products->car_price);
                                            $car_total_price = $total_car * $car_unit_price;
                                        }
                                        $total = $total + $adult_total_price + $child_total_price + $car_total_price;
                                    }

                                    $commission_percentage = setting('booking_commission_percentage');
                                    info('commission_percentage=> '.$commission_percentage);
                                    $commission = ($commission_percentage / 100) * $total; //0.03
                                    info('commission=> '.$commission);
                                    info('total=> '.$total);
                                // $commission = (($total * 100 * $commission_percentage) / 100);//+ 30; // + 0.30 stripe
                                    $amount = cleanDecimalZeros(($total - $commission) - Config::get('app.stripe_operator_charge'));
                                    // $amount = number_format($amount,2);
                                    \Log::info('amount');
                                    \Log::info($amount);
                                    // $amount = number_format((float)$amount, 2);
                                    $amount = number_format($amount, 2, '.', '');
                                    \Log::info($amount);
                                    info('amount=> '.$amount);

                                    $transfer = \Stripe\Transfer::create([
                                        'amount' => $amount * 100, // x 100
                                        'currency' => 'nzd',
                                        "source_transaction" => $result->id,
                                        'destination' => $getoperator->stripe_account_id,
                                        'transfer_group' => $booking_ref_for_stripe,
                                    ]);

                                    $cart_items = BookingOrderItems::getCartItemsByOperatorId($getoperator->operator_id,$r->booking_id);
                                    $adults = $cart_items->sum('number_of_adult');
                                    $childrens = $cart_items->sum('number_of_children');
                                    $bookingDateTime = date('d-m-Y h:i A',strtotime($getbookingdata->created_at));
                                    $operatorBookingDetails = [
                                        'booked_at' => $bookingDateTime,
                                        'date_and_time' => '',
                                        'adults' => $adults,
                                        'childrens' => $childrens,
                                        'name' => $getbookingdata->name,
                                        'email' => $getbookingdata->email,
                                        'phone_number' => $getbookingdata->phone_number,
                                        'cart_items' => $cart_items,
                                        'sub_total' => $total,
                                        'transaction_charge' =>$commission,
                                        'total' => ($amount / 100),
                                        'send_mail_to' => $getoperator->email,
                                    ];
                                    //Send Booking Email to Operator
                                    dispatch(new \App\Jobs\OperatorNewBookingEmailJob($operatorBookingDetails));
                                }
                            }
                        }
                        return response()->json(['status' => true, 'message'=>'Order confirm successfully.','data'=>$getbookingdata]);
                    }else{
                        return response()->json(['status' => false, 'message'=>'Something went wrong!']);
                    }
                }else{
                    $getbookingdata->payment_intent_status = 'succeeded';
                    $getbookingdata->save();
                    $getbookingitems = BookingOrderItems::where('booking_order_id',$r->booking_id)->first();
                    $getbookingitems->confirm_booking = 1;
                    $getbookingitems->save();
                    return response()->json(['status' => true, 'message'=>'Order confirm successfully.','data'=>$getbookingdata]);
                }
            }catch(Exception $e){
                return response()->json(['status' => false, 'message'=>$e->getMessage()]);
            }
        }else{
            return response()->json(['status' => false, 'message'=>'Booking data not found!']);
        }
    }

    public function DeclineBooking(Request $r)
    {
        $getbookingdata = BookingOrder::where('id',$r->booking_id)->first();


        if(!empty($getbookingdata)){
            try{
                $bookingData = BookingOrder::where('id',$r->booking_id)->first();
                $mailData =[
                    'user_id' => $getbookingdata->user_id,
                    'name' =>  $getbookingdata->name,
                    'email' => $getbookingdata->email,
                    'phone_number' => $getbookingdata->phone_number,
                    'booking_data' => $bookingData,
                    'cart_items' => $bookingData->booking_order_items,
                    'total' => $getbookingdata->booking_order_items->sum(function ($data) {
                        return $data->totalPrice();
                    }),
                    'send_mail_to' => $getbookingdata->email
                ];
                //
                if($getbookingdata->payment_intent_status == 'pending'){
                    $booking = $getbookingdata->booking_order_items->first();
                    $place_id = $booking->place_id;
                    $place_product_id = $booking->place_product_id;
                    $user_id = $booking->user_id;
                    $datetime = $booking->booking_date .' '. $booking->booking_time;
                    $productName = $booking->place_product->name;
                    $body = 'Your booking request of '.$productName.' for '.$datetime .' was declined due to booking capacity';
                    $this->sendDeletenotification($body,$place_id,$place_product_id,$user_id);
                }
                $booking->delete();
                $getbookingdata->delete();
                //
                dispatch(new \App\Jobs\UserNewBookingEmailJob($mailData));
                return response()->json(['status' => true, 'message'=>'Order decline successfully.','data'=>$getbookingdata]);

            }catch(Exception $e){
                return response()->json(['status' => false, 'message'=>$e->getMessage()]);
            }
        }else{
            return response()->json(['status' => false, 'message'=>'Booking data not found!']);
        }
    }
    // public function DeclineBooking(Request $r)
    // {
    //     $getbookingdata = BookingOrder::where('id',$r->booking_id)->first();


    //     if(!empty($getbookingdata)){
    //         try{
    //                 $getbookingdata->payment_intent_id = '';
    //                 $getbookingdata->payment_intent_status = 'canceled';
    //                 $getbookingdata->save();
    //                 $getbookingitems = BookingOrderItems::where('booking_order_id',$r->booking_id)->first();
    //                 $getbookingitems->confirm_booking = 1;
    //                 $getbookingitems->save();
    //                 $bookingData = BookingOrder::where('id',$r->booking_id)->first();
    //                 dispatch(new \App\Jobs\UserNewBookingEmailJob([
    //                     'user_id' => $getbookingdata->user_id,
    //                     'name' =>  $getbookingdata->name,
    //                     'email' => $getbookingdata->email,
    //                     'phone_number' => $getbookingdata->phone_number,
    //                     'booking_data' => $bookingData,
    //                     'cart_items' => $bookingData->booking_order_items,
    //                     'total' => $getbookingdata->booking_order_items->sum(function ($data) {
    //                         return $data->totalPrice();
    //                     }),
    //                     'send_mail_to' => $getbookingdata->email
    //                 ]));

    //                 // $booking_ref_for_stripe = 'BOOKING_' . $getbookingdata->id;
    //                 // $getoperator = BookingOrderItems::select('booking_order_items.*','users.id as operator_id','users.name', 'users.email', 'users.stripe_account_id')
    //                 //             ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
    //                 //             ->join('places', 'places.id', '=', 'booking_order_items.place_id')
    //                 //             ->join('users', 'users.id', '=', 'places.user_id')
    //                 //             ->where('booking_order_items.booking_order_id',$r->booking_id)
    //                 //             ->where('booking_order_items.place_id',$r->place_id)
    //                 //             ->first();
    //                 // if(!empty($getoperator)){
    //                 //     if ($getoperator->stripe_account_id != NULL) {
    //                 //         $place_products = PlaceProduct::query()->where('id', $getoperator->place_product_id)->first();
    //                 //         $total = 0;
    //                 //         if(!empty($place_products)){
    //                 //             if ($place_products->online_payment_required == 1) {
    //                 //                 $total_adult = $getoperator->number_of_adult;
    //                 //                 $total_child = $getoperator->number_of_children;
    //                 //                 $total_car = $getoperator->number_of_car;
    //                 //                 // CHECK DISCOUNT FOR ADULTS
    //                 //                 if (checkIfOnDiscount($place_products)) {
    //                 //                     $adult_unit_price = checkIfOnDiscount($place_products, true);
    //                 //                     $adult_total_price = $total_adult * $adult_unit_price;
    //                 //                 } else {
    //                 //                     $adult_unit_price = cleanDecimalZeros($place_products->price);
    //                 //                     $adult_total_price = $total_adult * $adult_unit_price;
    //                 //                 }
    //                 //                 // CHECK DISCOUNT FOR CHILDREN
    //                 //                 if (checkIfOnChildDiscount($place_products)) {
    //                 //                     $child_unit_price = checkIfOnChildDiscount($place_products, true);
    //                 //                     $child_total_price = $total_child * $child_unit_price;
    //                 //                 } else {
    //                 //                     $child_unit_price = cleanDecimalZeros($place_products->child_price);
    //                 //                     $child_total_price = $total_child * $child_unit_price;
    //                 //                 }

    //                 //                 if (checkIfOnCarDiscount($place_products)) {
    //                 //                     $car_unit_price = checkIfOnCarDiscount($place_products, true);
    //                 //                     $car_total_price = $total_car * $car_unit_price;
    //                 //                 } else {
    //                 //                     $car_unit_price = cleanDecimalZeros($place_products->car_price);
    //                 //                     $car_total_price = $total_car * $car_unit_price;
    //                 //                 }
    //                 //                 $total = $total + $adult_total_price + $child_total_price + $car_total_price;
    //                 //             }

    //                 //             $commission_percentage = setting('booking_commission_percentage');
    //                 //             $commission = ($commission_percentage / 100) * $total; //0.03
    //                 //         // $commission = (($total * 100 * $commission_percentage) / 100);//+ 30; // + 0.30 stripe
    //                 //             $amount = cleanDecimalZeros(($total - $commission) - Config::get('app.stripe_operator_charge'));
    //                 //             // $amount = number_format($amount,2);
    //                 //             \Log::info('amount');
    //                 //             \Log::info($amount);
    //                 //             // $amount = number_format((float)$amount, 2);
    //                 //             $amount = number_format($amount, 2, '.', '');
    //                 //             \Log::info($amount);

    //                 //             $transfer = \Stripe\Transfer::create([
    //                 //                 'amount' => $amount * 100, // x 100
    //                 //                 'currency' => 'nzd',
    //                 //                 "source_transaction" => $result->id,
    //                 //                 'destination' => $getoperator->stripe_account_id,
    //                 //                 'transfer_group' => $booking_ref_for_stripe,
    //                 //             ]);

    //                 //             $cart_items = BookingOrderItems::getCartItemsByOperatorId($getoperator->operator_id,$r->booking_id);
    //                 //             $adults = $cart_items->sum('number_of_adult');
    //                 //             $childrens = $cart_items->sum('number_of_children');
    //                 //             $bookingDateTime = date('d-m-Y h:i A',strtotime($getbookingdata->created_at));
    //                 //             $operatorBookingDetails = [
    //                 //                 'booked_at' => $bookingDateTime,
    //                 //                 'date_and_time' => '',
    //                 //                 'adults' => $adults,
    //                 //                 'childrens' => $childrens,
    //                 //                 'name' => $getbookingdata->name,
    //                 //                 'email' => $getbookingdata->email,
    //                 //                 'phone_number' => $getbookingdata->phone_number,
    //                 //                 'cart_items' => $cart_items,
    //                 //                 'sub_total' => $total,
    //                 //                 'transaction_charge' =>$commission,
    //                 //                 'total' => ($amount / 100),
    //                 //                 'send_mail_to' => $getoperator->email,
    //                 //             ];
    //                 //             //Send Booking Email to Operator
    //                 //             dispatch(new \App\Jobs\OperatorNewBookingEmailJob($operatorBookingDetails));
    //                 //         }
    //                 //     }
    //                 // }
    //                 return response()->json(['status' => true, 'message'=>'Order decline successfully.','data'=>$getbookingdata]);

    //         }catch(Exception $e){
    //             return response()->json(['status' => false, 'message'=>$e->getMessage()]);
    //         }
    //     }else{
    //         return response()->json(['status' => false, 'message'=>'Booking data not found!']);
    //     }
    // }

    public function getReservationDetails(Request $request) {
        try {
            /* $bookings = BookingOrderItems::with([
                'place_product' => function($query){
                    $query->select('id','name','price');
                },
                'user' => function($query){
                    $query->select('id','name','email');
                },
            ])
            ->where('place_product_id',$request->id)
            ->where('booking_date',$request->date)
            ->when($request->allday == "false", function($query) use($request){
                $query->where('booking_time',$request->start_time)
                ->where('booking_end_time',$request->end_time);
            })->get();
            $html = '';
            if(count($bookings) > 0){
                foreach($bookings as $k => $booking){
                    $price =  ($booking->price * $booking->number_of_adult)+($booking->child_price * $booking->number_of_children);
                    $username = $booking->user->name ?? '-';
                    $product = $booking->place_product->name ?? '-';
                    $bookingTime = $request->allday == "false" ? $booking->booking_date.' '.$booking->booking_time :  $booking->booking_date;
                    $html .= '<tr><td>'.$booking->id.'</td>
                    <td>'.$product.'</td>
                    <td>'.$username.'</td>
                    <td>$'.$price.'</td>
                    <td>'.$bookingTime.'</td>
                    <td>
                    <span style="text-transform: capitalize;" class="status bg-light">'.$booking->booking_order->payment_intent_status.'</span>
                    </td>
                    </tr>';
                }
            }else{
                $html .= '<tr><td colspan="5" class="text-center">'.__("No booking found").'</td><tr>';
            } */

            $reservation_id = $request->reservation_id;
            $user_id = $request->user_id;
            $date = $request->date;
            $time = $request->time;
            $dateTime = $date.' '.$time;
            $startDate = $dateTime;
            $endDate = $dateTime;

            //DB::enableQueryLog();
            $user_info = User::where('id', $user_id)
                    ->select('name', 'avatar', 'phone_number', 'email', 'phone_number','user_note')
                    ->first();
            $reservations = Booking::query()
                ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.numbber_of_adult','bookings.numbber_of_children','place_products.name', 'place_products.color_code')
                ->leftjoin('place_products','place_products.place_id','=','bookings.place_id')
                ->join('places', 'places.id', '=', 'bookings.place_id')
                ->with('place.categories')
                ->with('place.city')
                ->where('bookings.user_id', $user_id)
                ->where('bookings.id', $reservation_id)
                ->where('bookings.date', $date)
                ->where('bookings.time', $time)
                //->whereBetween('date', [$startDateObj->format('Y-m-d'), $endDateObj->format('Y-m-d')])
                /* ->where(function($query) use ($startDate, $endDate){

                    $query->whereBetween('date', [$startDate, $endDate]);
                }) */
                ->orderBy('id', 'DESC')
                ->groupBy('bookings.date', 'bookings.time')
                ->get();
                /* $t = DB::getQueryLog();
                dd($t); */
                //dd($reservations);
                $html = '';
                if(isset($reservations) && !empty($reservations)){
                    foreach($reservations as $reservation){
                        $html = view('frontend.cart.reservation_detail', compact(
                            'reservation', 'user_info'
                        ))->render();
                    }
                }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message'=>$th->getMessage()]);
        }
        return response()->json(['status' => true, 'message'=>'success', 'data' => ['html' => $html]]);
    }

    public function getReservationDetailsAtOperator(Request $request) {
        try {
            $reservation_id = $request->reservation_id;
            $user_id = $request->user_id;

            //DB::enableQueryLog();
            $reservations = Booking::query()
                ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.numbber_of_adult', 'bookings.numbber_of_children', 'bookings.created_at', 'users.name', 'users.email', 'users.phone_number')
                ->join('users', 'users.id', '=', 'bookings.user_id')
                ->where('bookings.user_id', $user_id)
                ->where('bookings.id', $reservation_id)
                ->get();
                /* $t = DB::getQueryLog();
                dd($t); */
                //dd($reservations);
                $html = '';
                if(isset($reservations) && !empty($reservations)){
                    foreach($reservations as $reservation){
                        $html .= '<tr><th>Reservation ID: </th><td>'.$reservation->id.'</td></tr>
                        <tr><th>Reservation On: </th><td>'.dateFormat($reservation->created_at).' '.Carbon::parse($reservation->created_at)->format('h:i A').'</td></tr>
                        <tr><th>Reservation For: </th><td>'.dateFormat($reservation->date).' '.Carbon::parse($reservation->time)->format('h:i A').'</td></tr>
                        <tr><th>Name: </th><td>'.$reservation->name.'</td></tr>
                        <tr><th>Contact: </th><td>'.$reservation->phone_number.'</td></tr>
                        <tr><th>Email: </th><td>'.$reservation->email.'</td></tr>
                        <tr><th>No. of Adult: </th><td>'.$reservation->numbber_of_adult.'</td></tr>
                        <tr><th>No. of Child: </th><td>'.$reservation->numbber_of_children.'</td></tr>';
                    }
                }

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message'=>$th->getMessage()]);
        }
        return response()->json(['status' => true, 'message'=>'success', 'data' => ['html' => $html]]);
    }

    public function getReservationConfirm(Request $request){

        $ack = Booking::where('id', '=', $request->reservation_id)->update(['status' => 1]);

        $status = '';
        $message = '';
        if($ack){
            $message = 'Reservation is confirmed.';
            $status = true;

            /* reservation confirmation mail send operator to user */
            $reservationDetails = Booking::query()
            ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.numbber_of_adult','bookings.numbber_of_children','place_products.name', 'place_products.color_code', 'users.name AS user_name', 'users.email')
            ->leftjoin('place_products','place_products.place_id','=','bookings.place_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('places', 'places.id', '=', 'bookings.place_id')
            ->with('place.categories')
            ->where('bookings.id', $request->reservation_id)
            ->first();

            $to_user_email = $reservationDetails->email;
            $to_user_name = $reservationDetails->user_name;
            $getOperatorData = Place::with('categories')->where('places.id', '=', $reservationDetails->place_id)->join('users', 'users.id', '=', 'places.user_id')->first();
            $place = Place::find($reservationDetails->place_id);
            $mailDataForUser = [
                'name' => $getOperatorData->name,
                'address' => $getOperatorData->address,
                'phone' => $getOperatorData->phone_number,
                'email' => $getOperatorData->email,
                'place' => $place->name,
                'datetime' => Carbon::parse($reservationDetails->date)->format('Y-m-d') . " " . $reservationDetails->time
            ];

            Mail::send('frontend.mail.confirm_booking_user', $mailDataForUser, function ($message) use ($request,$to_user_email,$to_user_name) {
                $message->to($to_user_email, "{$to_user_name}")->subject('Reservation Confirmed');
            });

            /* //reservation mail send operator to user */
        }else{
            $message = 'Not confirmed.';
            $status = false;
        }

        return response()->json(['status' => $status, 'message'=>$message, 'data' => ['message' => $message]]);
    }

    public function getReservationCancel(Request $request){

        $ack = Booking::where('id', '=', $request->reservation_id)->update(['status' => 3]);

        $status = '';
        $message = '';
        if($ack){
            $message = 'Reservation is canceled.';
            $status = true;

            /* reservation confirmation mail send operator to user */
            $reservationDetails = Booking::query()
            ->select('bookings.id','bookings.user_id','bookings.place_id','bookings.time','bookings.date', 'bookings.numbber_of_adult','bookings.numbber_of_children','place_products.name', 'place_products.color_code', 'users.name AS user_name', 'users.email')
            ->leftjoin('place_products','place_products.place_id','=','bookings.place_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('places', 'places.id', '=', 'bookings.place_id')
            ->with('place.categories')
            ->where('bookings.id', $request->reservation_id)
            ->first();

            $to_user_email = $reservationDetails->email;
            $to_user_name = $reservationDetails->user_name;
            $getOperatorData = Place::with('categories')->where('places.id', '=', $reservationDetails->place_id)->join('users', 'users.id', '=', 'places.user_id')->first();
            $place = Place::find($reservationDetails->place_id);
            $mailDataForUser = [
                'name' => $getOperatorData->name,
                'address' => $getOperatorData->address,
                'phone' => $getOperatorData->phone_number,
                'email' => $getOperatorData->email,
                'place' => $place->name,
                'datetime' => Carbon::parse($reservationDetails->date)->format('Y-m-d') . " " . $reservationDetails->time
            ];

            Mail::send('frontend.mail.cancel_booking_user', $mailDataForUser, function ($message) use ($request,$to_user_email,$to_user_name) {
                $message->to($to_user_email, "{$to_user_name}")->subject('Reservation Canceled');
            });

            /* //reservation mail send operator to user */
        }else{
            $message = 'Not canceled.';
            $status = false;
        }

        return response()->json(['status' => $status, 'message'=>$message, 'data' => ['message' => $message]]);
    }
}
