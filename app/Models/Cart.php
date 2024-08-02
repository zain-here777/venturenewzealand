<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id', 'place_id', 'place_product_id','checkout_date','no_of_room',
        'number_of_adult', 'number_of_children', 'booking_date', 'booking_time','checkout_date','booking_end_time','confirm_booking','booking_note','number_of_car'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'checkout_date' => 'date'
    ];

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }

    public function place_product()
    {
        return $this->hasOne(PlaceProduct::class, 'id', 'place_product_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function getMyCartItemsCount()
    {
        if (auth()->user()) {
            $count = self::query()->where('user_id', auth()->user()->id)
                ->join('place_products', 'place_products.id', '=', 'cart.place_product_id')
                ->count();
            return $count;
        } else {
            return 0;
        }
    }

    public static function getCartItemtotalAmount()
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $cartItems = Cart::query()->has('place_product')->where('user_id', $user_id)->get();
            $total = 0;
            foreach ($cartItems as $cartItem) {
                if ($cartItem->place_product->online_payment_required == 1) {
                    $total_adult = $cartItem->number_of_adult;
                    $total_child = $cartItem->number_of_children;
                    $total_car = $cartItem->number_of_car;
                    // CHECK DISCOUNT FOR ADULTS
                    if($cartItem->no_of_room != null){
                        //
                        $startDate  = new Carbon($cartItem->booking_date);
                        $endDate    = new Carbon($cartItem->checkout_date);
                        $diffDay = $startDate->diff($endDate)->d ?? 1;
                        $days = $diffDay + 1;
                        //
                        if (checkIfOnDiscount($cartItem->place_product)) {
                            $adult_unit_price = checkIfOnDiscount($cartItem->place_product, true);
                            $total_price = $cartItem->no_of_room * $adult_unit_price * $days;
                        } else {
                            $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                            $total_price =  $cartItem->no_of_room * $adult_unit_price * $days;
                        }
                        $total = $total + $total_price;

                    }else{
                        if (checkIfOnDiscount($cartItem->place_product)) {
                            $adult_unit_price = checkIfOnDiscount($cartItem->place_product, true);
                            $adult_total_price = $total_adult * $adult_unit_price;
                        } else {
                            $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                            $adult_total_price = $total_adult * $adult_unit_price;
                        }
                        // CHECK DISCOUNT FOR CHILDREN
                        if (checkIfOnChildDiscount($cartItem->place_product)) {
                            $child_unit_price = checkIfOnChildDiscount($cartItem->place_product, true);
                            $child_total_price = $total_child * $child_unit_price;
                        } else {
                            
                            $child_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child'));
                            $child_total_price = $total_child * $child_unit_price;
                        }

                        if (checkIfOnCarDiscount($cartItem->place_product)) {
                            $car_unit_price = checkIfOnCarDiscount($cartItem->place_product, true);
                            $car_total_price = $total_car * $car_unit_price;
                        } else {
                            $car_unit_price = cleanDecimalZeros($cartItem->place_product->car_price);
                            $car_total_price = $total_car * $car_unit_price;
                        }
                        $total = $total + $adult_total_price + $child_total_price + $car_total_price;
                    }
                }
            }
            $total = cleanDecimalZeros($total);
            return $total;
        } else {
            return 0;
        }
    }

    public static function getItemsPayableTotal($confirmbooking=null,$cartid = 0)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $cartItems = Cart::query()
                ->has('place_product')
                ->where('user_id', $user_id)
                ->where('id',$cartid)
                ->where('confirm_booking',$confirmbooking)
                ->get();

            $total = 0;
            foreach ($cartItems as $cartItem) {
                if ($cartItem->place_product->online_payment_required == 1) {
                    $total_adult = $cartItem->number_of_adult;
                    $total_child = $cartItem->number_of_children;
                    $total_car = $cartItem->number_of_car;

                    // CHECK DISCOUNT FOR ADULTS
                    if (checkIfOnDiscount($cartItem->place_product)) {
                        $adult_unit_price = checkIfOnDiscount($cartItem->place_product, true);
                        $adult_total_price = $total_adult * $adult_unit_price;
                    } else {
                        $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                        $adult_total_price = $total_adult * $adult_unit_price;
                    }

                    // CHECK DISCOUNT FOR CHILDREN
                    if (checkIfOnChildDiscount($cartItem->place_product)) {
                        $child_unit_price = checkIfOnChildDiscount($cartItem->place_product, true);
                        $child_total_price = $total_child * $child_unit_price;
                    } else {
                        
                        $child_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child'));
                        $child_total_price = $total_child * $child_unit_price;
                    }

                    if (checkIfOnCarDiscount($cartItem->place_product)) {
                        $car_unit_price = checkIfOnCarDiscount($cartItem->place_product, true);
                        $car_total_price = $total_car * $car_unit_price;
                    } else {
                        $car_unit_price = cleanDecimalZeros($cartItem->place_product->car_price);
                        $car_total_price = $total_car * $car_unit_price;
                    }

                    $total = $total + $adult_total_price + $child_total_price + $car_total_price;
                }
            }
            $total = cleanDecimalZeros($total);
            return $total;
        } else {
            return 0;
        }
    }

    public static function getMyCartItemsPayableTotal($confirmbooking=null,$cartid = 0)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $cartItems = Cart::query()
                ->has('place_product')
                // ->with(['place_product' => function($q) {
                //     $q->where('online_payment_required', 1);
                // }])
                ->where('user_id', $user_id)
                //->where('id',$cartid)
                ->where('confirm_booking',$confirmbooking)
                ->get();

            $total = 0;
            foreach ($cartItems as $cartItem) {
                if($cartItem->no_of_room != null){
                    $startDate  = new Carbon($cartItem->booking_date);
                    $endDate    = new Carbon($cartItem->checkout_date);
                    $diffDay = $startDate->diff($endDate)->d ?? 1;
                    $days = $diffDay + 1;
                    info("===========days======>".$days);
                    if (checkIfOnDiscount($cartItem->place_product)) {
                        $total = $total + ($days * $cartItem->no_of_room * checkIfOnDiscount($cartItem->place_product, true));
                    } else {
                        $total =  $total + ($days * $cartItem->no_of_room * getRezdyPrice($cartItem->place_product));
                    }

                }else{
                    if ($cartItem->place_product->online_payment_required == 1) {
                        $total_adult = $cartItem->number_of_adult;
                        $total_child = $cartItem->number_of_children;
                        $total_car = $cartItem->number_of_car;

                        // CHECK DISCOUNT FOR ADULTS
                        if (checkIfOnDiscount($cartItem->place_product)) {
                            $adult_unit_price = checkIfOnDiscount($cartItem->place_product, true);
                            $adult_total_price = $total_adult * $adult_unit_price;
                        } else {
                            $adult_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product));
                            $adult_total_price = $total_adult * $adult_unit_price;
                        }

                        // CHECK DISCOUNT FOR CHILDREN
                        if (checkIfOnChildDiscount($cartItem->place_product)) {
                            $child_unit_price = checkIfOnChildDiscount($cartItem->place_product, true);
                            $child_total_price = $total_child * $child_unit_price;
                        } else {
                            
                            $child_unit_price = cleanDecimalZeros(getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child'));
                            $child_total_price = $total_child * $child_unit_price;
                        }

                        if (checkIfOnCarDiscount($cartItem->place_product)) {
                            $car_unit_price = checkIfOnCarDiscount($cartItem->place_product, true);
                            $car_total_price = $total_car * $car_unit_price;
                        } else {
                            $car_unit_price = cleanDecimalZeros($cartItem->place_product->car_price);
                            $car_total_price = $total_car * $car_unit_price;
                        }

                        $total = $total + $adult_total_price + $child_total_price + $car_total_price;
                    }
                }
            }
            if(!isUserHaveMembership()){
                $total = $total * 1.019;
            }
            $total = cleanDecimalZeros($total);
            return $total;
        } else {
            return 0;
        }
    } //getMyCartItemsPayableTotal()

    public static function getCartOperators($confirmbooking=null,$cartid=0)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $cartOperators = Cart::query()
                ->select('users.id', 'users.name', 'users.email', 'users.stripe_account_id', DB::raw('group_concat(place_products.id) as place_product_ids'),'cart.number_of_adult','cart.number_of_children','cart.number_of_car','cart.confirm_booking')
                ->join('place_products', 'place_products.id', '=', 'cart.place_product_id')
                ->join('places', 'places.id', '=', 'place_products.place_id')
                ->join('users', 'users.id', '=', 'places.user_id')
                ->where('cart.user_id', $user_id)
                ->where('cart.confirm_booking',$confirmbooking);
                if($cartid != 0){
                    $cartOperators->where('cart.id',$cartid);
                }
                $cartOperators = $cartOperators->get();


            // $cartOperators = Cart::query()
            //     ->select('users.id', 'users.name', 'users.email', 'users.stripe_account_id', 'place_products.id as place_product_ids','cart.number_of_adult','cart.number_of_children','cart.number_of_car','cart.confirm_booking')
            //     ->join('place_products', 'place_products.id', '=', 'cart.place_product_id')
            //     ->join('places', 'places.id', '=', 'place_products.place_id')
            //     ->join('users', 'users.id', '=', 'places.user_id')
            //     ->where('cart.user_id', $user_id)
            //     ->where('cart.confirm_booking',$confirmbooking);
            //     if($cartid != 0){
            //         $cartOperators->where('cart.id',$cartid);
            //     }
            //     //$cartOperators = $cartOperators->groupBy('users.id')->get();
                 //$cartOperators = $cartOperators->get();
                //  echo "<pre>";
                //  print_r($cartOperators);die;
            return $cartOperators;
        } else {
            return false;
        }
    } //getCartOperators()

    public static function getCartItemsByOperatorId($operator_id,$cartid=0)
    {
         if (auth()->user()) {
            $user_id = auth()->user()->id;
            $operatorCartItems = Cart::query()
                ->select('cart.*', 'place_products.name as product_name')
                ->join('place_products', 'place_products.id', '=', 'cart.place_product_id')
                ->join('places', 'places.id', '=', 'place_products.place_id')
                ->join('users', 'users.id', '=', 'places.user_id');
                if($cartid != 0){
                    $operatorCartItems->where('cart.id',$cartid);
                }
                $operatorCartItems = $operatorCartItems->where('cart.user_id', $user_id)
                ->where('places.user_id', $operator_id)
                ->get();

            return $operatorCartItems;
        } else {
            return false;
        }
    } //getCartItemsByOperatorId()

    public static function emptyMyCart()
    {
        if (auth()->user()) {
            try {
                return self::query()->where('user_id', auth()->user()->id)->delete();
            } catch (Exception $e) {
                Log::error("Cart Model emptyMyCart Exception: " . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    } //emptyMyCart()

    protected static function getAvailability($cartItem,$all_day = false){
        try {
            $request_timestamp = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d',strtotime($cartItem->booking_date)).' '. date('H:i:s',strtotime($cartItem->booking_time)));
            $id = $cartItem->place_product_id;
            $time = $request_timestamp->format('H:i:s');
            $date =$request_timestamp->format('Y-m-d');
            $oparr =['date' => $date,'time' => $time];
            $totalSlot = 0;
            if($cartItem->no_of_room != null){
                $oparr['checkoutDate'] = $cartItem->checkout_date;
                $oparr['number_of_children'] = $cartItem->no_of_room ;
                $oparr['number_of_adult'] = $cartItem->no_of_room ;
                $oparr['no_of_room'] = $cartItem->no_of_room ;
                $bookingAvailibility = BookingAvailibility::isBookingAvailableForStayCategory($id,$oparr,$all_day,true);
            }else{
                $bookingAvailibility = BookingAvailibility::isBookingAvailable($id,$oparr,$all_day,true);
            }
            \Log::info("========bookingAvailibility)===========");
            \Log::info($bookingAvailibility);
            if($bookingAvailibility['status'] == false){
                throw new \ErrorException('Slot is not availibile');
            }
            $totalSlot = $bookingAvailibility['totalSlot'] ??  $bookingAvailibility['bookingCount'];
            return $totalSlot;
        } catch (\Throwable $th) {
            throw new \ErrorException('Slot is not availibile2');
        }
    }

    public static function moveCartItemsToBookingOrderItems($booking_order_id,$confirmbooking,$cartid=0)
    {
        // date_default_timezone_set('Asia/Kolkata');
        try {
            if (auth()->user()) {
                $user_id = auth()->user()->id;
                $cartItems = Cart::query()
                ->has('place_product')
                ->with('place','place_product');
                if($cartid != 0){
                    $cartItems->where('id', $cartid);
                }
                $cartItems = $cartItems->where('user_id', $user_id)
                ->where('confirm_booking',$confirmbooking)
                ->get();
                // dd($cartItems->toArray());
                $availibleItemArr = [];
                $errorMessage = 'Slot is not availibile';
                $errorProducts = [];
                foreach ($cartItems as $cartItem) {
                    $all_day = $cartItem->booking_time == null ? true : false;
                    if($cartItem->no_of_room != null){
                        //
                        $startDate  = new Carbon($cartItem->booking_date);
                        $endDate    = new Carbon($cartItem->checkout_date);
                        $diffDay = $startDate->diff($endDate)->d ?? 1;
                        $days = $diffDay + 1;
                        //
                        $totalSlot = self::getAvailability($cartItem,$all_day); //edited
                        if(!array_key_exists($cartItem->place_product_id,$availibleItemArr)){
                            $availibleItemArr[$cartItem->place_product_id] = $totalSlot;
                        }
                        $request_timestamp = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d',strtotime($cartItem->booking_date)).' '. date('H:i:s',strtotime($cartItem->booking_time)));
                        $time = $request_timestamp->format('H:i:s');
                        $date =$request_timestamp->format('Y-m-d');
                        if($cartItem->no_of_room != null){
                            if (checkIfOnDiscount($cartItem->place_product)) {
                                $price = ($days * $cartItem->no_of_room * checkIfOnDiscount($cartItem->place_product, true));
                            } else {
                                $price =($days * $cartItem->no_of_room * getRezdyPrice($cartItem->place_product));
                            }

                        }else{

                            if (checkIfOnDiscount($cartItem->place_product)) {
                                $price = checkIfOnDiscount($cartItem->place_product, true);
                            } else {
                                $price = getRezdyPrice($cartItem->place_product);
                                $child_price = getRezdyPrice($cartItem->place_product);
                            }
                            if (checkIfOnChildDiscount($cartItem->place_product)) {
                                $child_price = checkIfOnChildDiscount($cartItem->place_product, true);
                            } else {
                                // $child_price = isset($cartItem->place_product->child_price) ? $cartItem->place_product->child_price : 0;
                                $child_price = isset($cartItem->place_product->child_price) ? getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child') : 0;
                            }

                            if (checkIfOnCarDiscount($cartItem->place_product)) {
                                $car_price = checkIfOnCarDiscount($cartItem->place_product, true);
                            } else {
                                $car_price = isset($cartItem->place_product->car_price) ? $cartItem->place_product->car_price : 0;
                            }
                        }
                        $insertArr = [
                            'user_id' => $user_id,
                            'booking_order_id' => $booking_order_id,
                            'place_id' => $cartItem->place_id,
                            'place_product_id' => $cartItem->place_product_id,
                            'price' => $price,
                            'child_price' => $child_price ?? null,
                            'number_of_adult' => $cartItem->number_of_adult,
                            'number_of_children' => $cartItem->number_of_children,
                            'booking_date' => $cartItem->booking_date,
                            'booking_time' => $cartItem->booking_time,
                            'checkout_date' => $cartItem->checkout_date,
                            'booking_end_time' => $cartItem->booking_end_time,
                            'confirm_booking' => $cartItem->confirm_booking,
                            'booking_note' => $cartItem->booking_note,
                            'number_of_car' => $cartItem->number_of_car,
                            'car_price' => $car_price ?? null,
                            'no_of_room' =>  $cartItem->no_of_room ?? null,
                        ];
                        if($cartItem->no_of_room != null){
                            $insertArr['no_of_room'] = $cartItem->no_of_room;
                        }

                        $bookingCount = BookingOrderItems::where('place_product_id',$cartItem->place_product_id)
                        ->where(function($query)  use($cartItem){
                            $query->whereBetween('booking_date', [$cartItem->booking_date, $cartItem->checkout_date])
                            ->orWhereBetween('checkout_date', [$cartItem->booking_date, $cartItem->checkout_date])
                            ->orWhereRaw('? BETWEEN booking_date and checkout_date', [$cartItem->booking_date])
                            ->orWhereRaw('? BETWEEN booking_date and checkout_date', [$cartItem->checkout_date]);
                        })
                        ->count();

                        $availibleItemCount = $totalSlot - $cartItem->no_of_room;
                        $availibleItemArr[$cartItem->place_product_id] = $availibleItemCount;

                        if(min($availibleItemArr) < 0){
                            $placeProduct = PlaceProduct::where('id',$cartItem->place_product_id)->select('name')->first();
                            // $errorMessage.= $placeProduct->name;
                            $errorProducts[] = $placeProduct->name;
                        }
                        // -----------------Rezdy booking--------------------

                        $product_name = PlaceProduct::where('id',$cartItem->place_product_id)->first();
                        $place = Place::where('id',$cartItem->place_id)->first();
                        $product_response = app('rezdy')->get('products/marketplace', [
                            'query' => [
                                'apiKey' => '90ee8baf2ee0439aaf476fa2a9b6b68f',
                                'search' => $product_name->name
                            ]
                        ]);
                        $rezdy_product = json_decode($product_response->getBody(), true);
                        
                        // dd('1');
                       
                        if ($rezdy_product["products"]) {
                            $rezdy_pro = null;
                            foreach($rezdy_product["products"] as $rezdy){
                                if ($rezdy['name'] == $product_name->name && $rezdy['supplierName'] == $place->name){
                                    $rezdy_pro = $rezdy;
                                }
                            }
                            // dd($rezdy_pro);
                            if ($rezdy_pro) {
                                $user = User::where('id',$user_id)->first();
                                if (strpos($user->name, " ")) {
                                    $first_name = substr($user->name, 0 ,strpos($user->name, " ") + 1);
                                    $last_name = substr($user->name, strpos($user->name, " ") + 1, strlen($user->name) - strpos($user->name, " "));
                                } else {
                                    $first_name = $user->name;
                                    $last_name = "";
                                }
                                $booking_start_time = $cartItem->booking_date . " " . $cartItem->booking_time;
                                $rezdy_Data = [
                                    "resellerReference" => "VNZ" . $booking_order_id,
                                    "resellerComments"=> "Venture NewZealand",
                                    "customer"=> [
                                        "firstName" =>$first_name,
                                        "lastName"=> $last_name,
                                        "phone"=> $user->phone_number,
                                        "email" => $user->email
                                    ],
                                    "items"=> [
                                        ["productCode"=> $rezdy_pro["productCode"],
                                        "startTimeLocal"=> date("Y-m-d H:i:s", strtotime($booking_start_time)),
                                        "quantities"=> [
                                            [
                                                "optionLabel"=> "1 Adults + 4 Children",
                                                "value"=> ($cartItem->number_of_adult + $cartItem->number_of_children) / 5],
                                            // [
                                            //     "optionLabel"=> "Child",
                                            //     "value"=> $cartItem->number_of_children ],
                                            ]
                                        ]
                                    ],
                                    "payments"=> [
                                        ["amount"=> $price,
                                        "currency" => "NZD",
                                        "type"=> "CREDITCARD",
                                        "label"=> ""]
                                    ]
                                ];
                                Storage::disk('local')->put('public/rezdy_payload.txt', json_encode($rezdy_Data));
                                $rezdy_response = app('rezdy')->post('bookings', [
                                    'json' => $rezdy_Data
                                ]);
                                
                                $rezdy_booking = json_decode($rezdy_response->getBody(), true);
                                Storage::disk('local')->put('public/rezdy_response.txt', json_encode($rezdy_booking));
                                $insertArr['rezdy_number'] = $rezdy_booking["booking"]["orderNumber"];
                            }
                        }

                        BookingOrderItems::create($insertArr);

                        // send notification to operator when book new product
                        $productName = $cartItem->place_product->name;
                        $title = 'New Booking';
                        $body = 'Product ' . $productName . ' is Booked for ' .$cartItem->booking_date.' '.$cartItem->booking_time??"";
                        $image = null;
                        $webNotification = WebNotification::create(
                            [
                                'title' => $title,
                                'body' => $body,
                                'image' => $image,
                                'type' => 2, //single =2
                                'delete_type' => 4, //Product updated = 4
                                'place_id' => $cartItem->place_id, 'product_id' => $cartItem->place_product_id,
                                'redirect_to' => "booking_list",
                                'for_user_id' => $cartItem->place->user_id,
                            ]
                        );

                    } else {
                          // get slot ref_id
                        $bookingAvailibility = BookingAvailibility::where('product_id',$cartItem->place_product_id)
                        ->where('available_from','<=',$cartItem->booking_date)
                        ->where('available_to','>=',$cartItem->booking_date)
                        ->orWhere(function($query) use($cartItem){
                            $query->where('date',$cartItem->booking_date);
                        })
                        ->first();
                        // dd($cartItem->toArray(),$bookingAvailibility);
                        $ref_id = null;
                        if($bookingAvailibility != null){
                            if($all_day){
                                $ref_id = $bookingAvailibility->id;
                            }else{
                                $slot= $bookingAvailibility->timeslots()->where('start_time',$cartItem->booking_time)
                                ->where(function($q) use($cartItem){
                                    $q->where(function($query) use($cartItem){
                                        $query->where('type',1)
                                        ->where('date',$cartItem->booking_date);
                                    })
                                    ->orWhere('type',null);
                                })->first();
                                $ref_id = $slot->id ?? null;
                            }
                        }
                        //

                        // $totalSlot = 5;
                        $totalSlot = self::getAvailability($cartItem,$all_day); //edited
                        if(!array_key_exists($cartItem->place_product_id,$availibleItemArr)){
                            $availibleItemArr[$cartItem->place_product_id] = $totalSlot;
                        }

                        $request_timestamp = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d',strtotime($cartItem->booking_date)).' '. date('H:i:s',strtotime($cartItem->booking_time)));
                        $time = $request_timestamp->format('H:i:s');
                        $date =$request_timestamp->format('Y-m-d');
                        if (checkIfOnDiscount($cartItem->place_product)) {
                            $price = checkIfOnDiscount($cartItem->place_product, true);
                        } else {
                            $price = getRezdyPrice($cartItem->place_product);
                            $child_price = getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child');
                        }
                        if (checkIfOnChildDiscount($cartItem->place_product)) {
                            $child_price = checkIfOnChildDiscount($cartItem->place_product, true);
                        } else {
                            $child_price = isset($cartItem->place_product->child_price) ? getRezdyPrice($cartItem->place_product, $cartItem->place_product->child_price, 'child') : 0;
                        }

                        if (checkIfOnCarDiscount($cartItem->place_product)) {
                            $car_price = checkIfOnCarDiscount($cartItem->place_product, true);
                        } else {
                            $car_price = isset($cartItem->place_product->car_price) ? $cartItem->place_product->car_price : 0;
                        }
                        $insertArr = [
                            'user_id' => $user_id,
                            'booking_order_id' => $booking_order_id,
                            'place_id' => $cartItem->place_id,
                            'place_product_id' => $cartItem->place_product_id,
                            'price' => $price,
                            'child_price' => $child_price,
                            'number_of_adult' => $cartItem->number_of_adult,
                            'number_of_children' => $cartItem->number_of_children,
                            'booking_date' => $cartItem->booking_date,
                            'booking_time' => $cartItem->booking_time,
                            'checkout_date' => $cartItem->checkout_date,
                            'booking_end_time' => $cartItem->booking_end_time,
                            'confirm_booking' => $cartItem->confirm_booking,
                            'booking_note' => $cartItem->booking_note,
                            'number_of_car' => $cartItem->number_of_car,
                            'car_price' => $car_price,
                            'ref_id' => $ref_id,
                            'no_of_room' =>  $cartItem->no_of_room ?? null,
                        ];
                        if($cartItem->no_of_room != null){
                            $insertArr['no_of_room'] = $cartItem->no_of_room;
                        }

                        // -----------------Rezdy booking--------------------

                        $product_name = PlaceProduct::where('id',$cartItem->place_product_id)->first();
                        $place = Place::where('id',$cartItem->place_id)->first();
                        $product_response = app('rezdy')->get('products/marketplace', [
                            'query' => [
                                'apiKey' => '90ee8baf2ee0439aaf476fa2a9b6b68f',
                                'search' => $product_name->name
                            ]
                        ]);
                        $rezdy_product = json_decode($product_response->getBody(), true);
                        // dd('2');
                        
                        if($rezdy_product["products"]) {
                            $rezdy_pro = null;
                            foreach($rezdy_product["products"] as $rezdy){
                                if($rezdy['name'] == $product_name->name && $rezdy['supplierName'] == $place->name){
                                    $rezdy_pro = $rezdy;
                                }
                            }
                            if ($rezdy_pro) {
                                $user = User::where('id',$user_id)->first();
                                if (strpos($user->name, " ")) {
                                    $first_name = substr($user->name, 0 ,strpos($user->name, " ") + 1);
                                    $last_name = substr($user->name, strpos($user->name, " ") + 1, strlen($user->name) - strpos($user->name, " "));
                                } else {
                                    $first_name = $user->name;
                                    $last_name = "";
                                }
                                $booking_start_time = $cartItem->booking_date . " " . $cartItem->booking_time;
                                $rezdy_Data = [
                                    "resellerReference" => "VNZ" . $booking_order_id,
                                    "resellerComments"=> "Venture NewZealand",
                                    "customer"=> [
                                        "firstName" =>$first_name,
                                        "lastName"=> $last_name,
                                        "phone"=> $user->phone_number,
                                        "email" => $user->email
                                    ],
                                    "items"=> [
                                        [
                                            "productCode"=> $rezdy_pro["productCode"],
                                            "startTimeLocal"=> date("Y-m-d H:i:s", strtotime($booking_start_time)),
                                            "quantities"=> [
                                                [
                                                    "optionLabel"=> "Quantity",
                                                    "value"=> $cartItem->number_of_adult],
                                                // [
                                                //     "optionLabel"=> "Child",
                                                //     "value"=> $cartItem->number_of_children],
                                                ],
                                            "pickupLocation"=> [
                                                "locationName"=> "Selvatura Adventure Park"
                                            ]
                                        ]
                                    ],
                                    "payments"=> [
                                        ["amount"=> $price,
                                        "currency" => "NZD",
                                        "type"=> "CREDITCARD",
                                        "label"=> ""]
                                    ]
                                ];
                                Storage::disk('local')->put('public/rezdy_payload.txt', json_encode($rezdy_Data));
                                $rezdy_response = app('rezdy')->post('bookings', [
                                    'json' => $rezdy_Data
                                ]);
                                
                                $rezdy_booking = json_decode($rezdy_response->getBody(), true);
                                Storage::disk('local')->put('public/rezdy_response.txt', json_encode($rezdy_booking));
                                $insertArr['rezdy_number'] = $rezdy_booking["booking"]["orderNumber"];
                            }
                        }

                        BookingOrderItems::create($insertArr);
                        // send notification to operator when book new product
                        $productName = $cartItem->place_product->name;
                        $title = 'New Booking';
                        $body = 'Product ' . $productName . ' is Booked for ' .$cartItem->booking_date.' '.$cartItem->booking_time??"";
                        $image = null;
                        $webNotification = WebNotification::create(
                            [
                                'title' => $title,
                                'body' => $body,
                                'image' => $image,
                                'type' => 2, //single =2
                                'delete_type' => 4, //Product updated = 4
                                'place_id' => $cartItem->place_id, 'product_id' => $cartItem->place_product_id,
                                'redirect_to' => "booking_list",
                                'for_user_id' => $cartItem->place->user_id,
                            ]
                        );
                        //
                        $bookingCount = BookingOrderItems::where('place_product_id',$cartItem->place_product_id)
                        ->where('booking_date',$date)
                        ->when(!$all_day, function($query) use($time){
                            $query->where('booking_time', $time);
                            // ->where('booking_time' ,'<=', $time);
                        })
                        ->count();

                        $availibleItemCount = $totalSlot - $bookingCount;
                        $availibleItemArr[$cartItem->place_product_id] = $availibleItemCount;

                        if(min($availibleItemArr) < 0){
                            $placeProduct = PlaceProduct::where('id',$cartItem->place_product_id)->select('name')->first();
                            // $errorMessage.= $placeProduct->name;
                            $errorProducts[] = $placeProduct->name;
                        }
                    }
                }
                $errorProducts = array_unique($errorProducts);
                if(!empty($errorProducts)){
                    $errorProducts = implode(", ",$errorProducts);
                    $errorMessage = 'Slot is not availibile for : ' .$errorProducts;
                }

                if(min($availibleItemArr) < 0){
                    $errorMessage.= ", Remove from the cart for other checkout.";
                    throw new \ErrorException($errorMessage);
                }
            } else {
                throw new \ErrorException('User not found');
            }
        } catch (\Throwable $th) {
            // dd($th);
            throw new \ErrorException($errorMessage);
        }
        return true;
    } //moveCartItemsToBookingOrderItems()
}
