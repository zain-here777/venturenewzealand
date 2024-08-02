<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BookingAvailibility extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'place_id','is_recurring', 'recurring_value', 'date', 'available_from',
        'available_to', 'all_day', 'booking_note', 'max_booking_no','booking_cut_off','confirm_booking',
        'max_child_per_room','max_adult_per_room',
    ];

    protected $hidden = ['created_at','updated_at'];

    public function timeslots()
    {
        return $this->hasMany(BookingAvailibilityTimeSlot::class, 'booking_availibility_id', 'id');
    }

    public function place_product()
    {
        return $this->hasOne(PlaceProduct::class, 'id', 'product_id');
    }

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }

    static function SplitTime($StartTime, $EndTime, $Duration="60"){
        $ReturnArray = array ();
        $StartTime    = strtotime ($StartTime);
        $EndTime      = strtotime ($EndTime);

        $AddMins  = $Duration * 60;

        while ($StartTime <= $EndTime)
        {
            $ReturnArray[] = date ("g:i A", $StartTime);
            $StartTime += $AddMins;
        }
        return $ReturnArray;
    }

    public static function bookingAvailibility($id, $category, $date){
        if($category !== 'eat') {
            $availibility = self::where('product_id',$id)->with(['timeslots' => function($query){
                $query->select('id','booking_availibility_id','start_time','end_time','edit_id','date','type');
            }])
            ->when($date != null, function($query) use($date, $id){ //get time slot when date pass
                $query->where('product_id',$id)
                ->where(function($query) use($date,$id){
                    $query->where('date',$date)
                    ->orWhere(function($query) use($date,$id){
                        $query->where('available_from','<=',$date)
                        ->where('available_to','>=',$date);
                    });
                });
            })
            ->get();
        } else {
            $availibility = self::where('place_id', intval($id))->with(['timeslots' => function($query){
                $query->select('id','booking_availibility_id','start_time','end_time','edit_id','date','type');
            }])
            ->when($date != null, function($query) use($date,$id){ //get time slot when date pass
                $query->where('place_id',intval($id))
                ->where(function($query) use($date,$id){
                    $query->where('date',$date)
                    ->orWhere(function($query) use($date,$id){
                        $query->where('available_from','<=',$date)
                        ->where('available_to','>=',$date);
                    });
                });
            })
            ->get();
        }
        if(count($availibility) == 0){
            return  ['date-slots' => [],'time-slots' => []];
        }
        $availibilityArr = [];
        $availibilityTimeArr = [];
        foreach($availibility as $k=> $value){
            if($value->all_day == 1 ){
                if($date != null){    //get time slot when date pass
                    $availibilityTimeArr[] = true;
                }else{
                    if($value->is_recurring == 1){
                        $dates = BookingOrder::getDateRange($value->available_from,$value->available_to,json_decode($value->recurring_value));
                        foreach($dates as $singleDate){
                            $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$value->id)->where('type',0)->where('date',$singleDate)->first();
                            if(!$checktimeslotdeleted){
                                $availibilityArr[] = date('Y-n-j',strtotime($singleDate));
                            }
                        }
                    }else{
                        $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$value->id)->where('type',0)->where('date',$value->date)->first();
                        if(!$checktimeslotdeleted){
                            $availibilityArr[] = date('Y-n-j',strtotime($value->date));
                        }
                    }
                }
            }else{
                $allSlots = $value->timeslots;
                if($date != null){   //get time slot when date pass
                    $allSlots = $allSlots->where('edit_id',null)->where('type',null);
                    $editedSlots = $value->timeslots->where('date',$date)->where('type',1);
                    foreach($allSlots as $timeslot){
                        foreach($editedSlots as $editedSlot){
                            if($editedSlot->edit_id == $timeslot->id){
                                $timeslot = $editedSlot;
                            }
                        }
                        $checkslots = BookingAvailibilityTimeSlot::query()
                        ->where('date',$date)
                        ->where('type',0)
                        ->where(function($query) use($timeslot){
                            $query->where('booking_availibility_id',$timeslot->id)
                            ->orWhere('edit_id',$timeslot->id);
                        })
                        ->first();
                        if(!$checkslots && ($timeslot->type !== 0)){
                            $time = date('h:i A',strtotime($timeslot->start_time));
                            $availibilityTimeArr[] = $time;
                        }
                    }
                }else{
                    if($value->is_recurring == 1){
                        $dates = BookingOrder::getDateRange($value->available_from,$value->available_to,json_decode($value->recurring_value));

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
                                        $availibilityArr[] = date('Y-n-j',strtotime($singleDate));
                                    }
                                }
                            }
                        }
                    }elseif($value->is_recurring == 0){
                        foreach($value->timeslots as $timeslot){
                            $checktimeslotdeleted = BookingAvailibilityTimeSlot::where('booking_availibility_id',$timeslot->id)->where('type',0)->where('date',$value->date)->first();
                            if(!$checktimeslotdeleted){
                                if($timeslot->start_time != NULL && $timeslot->end_time != NULL){
                                    $availibilityArr[] = date('Y-n-j',strtotime($value->date));
                                }
                            }
                        }
                    }
                }
            }
        }

        if(count($availibilityArr)){
            $availibilityArr = array_values(array_unique($availibilityArr));
        }
        usort($availibilityTimeArr, function($a, $b) {
            return (strtotime($a) > strtotime($b));
        });
        $responseArr = ['date-slots' => $availibilityArr,'time-slots' => $availibilityTimeArr];
        return $responseArr;
    }
    // public static function bookingAvailibility($id,$date=null){
    //     $availibility = self::where('product_id',$id)->with(['timeslots' => function($query){
    //         $query->select('id','booking_availibility_id','start_time','end_time','edit_id','date','type');
    //     }])
    //     ->when($date != null, function($query) use($date,$id){
    //         $query->where('product_id',$id)
    //         ->where(function($query) use($date,$id){
    //             $query->where('date',$date)
    //             ->orWhere(function($query) use($date,$id){
    //                 $query->where('available_from','<=',$date)
    //                 ->where('available_to','>=',$date);
    //             });
    //         });
    //     })
    //     ->get();
    //     if(count($availibility) == 0){
    //         return  ['date-slots' => [],'time-slots' => []];
    //     }
    //     $availibilityArr = [];
    //     $availibilityTimeArr = [];
    //     foreach($availibility as $key => $value){
    //         if($value->all_day == 1 && $date != null ){
    //             $availibilityTimeArr[] = true;
    //         }else{
    //             $allSlots = $value->timeslots;
    //             if($date != null){
    //                 $allSlots = $allSlots->where('edit_id',null)->where('type',null);
    //                 $editedSlots = $value->timeslots->where('date',$date)->where('type',1);
    //                 foreach($allSlots as $timeslot){
    //                     foreach($editedSlots as $editedSlot){
    //                         if($editedSlot->edit_id == $timeslot->id){
    //                             $timeslot = $editedSlot;
    //                         }
    //                     }
    //                     $checkslots = BookingAvailibilityTimeSlot::query()
    //                     ->where('date',$date)
    //                     ->where('type',0)
    //                     ->where(function($query) use($timeslot){
    //                         $query->where('booking_availibility_id',$timeslot->id)
    //                         ->orWhere('edit_id',$timeslot->id);
    //                     })
    //                     ->first();
    //                     if(!$checkslots && ($timeslot->type !== 0)){
    //                         $time = date('h:i A',strtotime($timeslot->start_time));
    //                         $availibilityTimeArr[] = $time;
    //                     }
    //                 }
    //             }else{
    //                 foreach($allSlots as $timeslot){
    //                     if($timeslot->edit_id == null){

    //                         $checkslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$timeslot->id)->where('date',$value->date)->where('type',0)->first();
    //                         if(!$checkslots){
    //                             $time = date('h:i A',strtotime($timeslot->start_time));
    //                             $availibilityTimeArr[] = $time;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         if($value->is_recurring == 1){
    //             $datePeriods = CarbonPeriod::create($value->available_from, $value->available_to);
    //             $recurringDays = json_decode($value->recurring_value,true);
    //             foreach($datePeriods as $period){
    //                 $checkslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$value->id)->where('type',0)->where('date',$period->format('Y-m-d'))->first();
    //                 if(!$checkslots){
    //                     if(in_array($period->format('l'),$recurringDays)){
    //                         $availibilityArr[] = $period->format('Y-n-j');
    //                     }
    //                 }
    //             }
    //         }else{
    //             $checkslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$value->id)->where('type',0)->where('date',$value->date)->first();
    //             if(!$checkslots){
    //                 $availibilityArr[] = date('Y-n-j',strtotime($value->date));
    //             }
    //         }
    //     }
    //     // dd($availibilityArr,$availibilityTimeArr);

    //     usort($availibilityTimeArr, function($a, $b) {
    //         return (strtotime($a) > strtotime($b));
    //     });
    //     $responseArr = ['date-slots' => $availibilityArr,'time-slots' => $availibilityTimeArr];
    //     return $responseArr;
    // }
    // public static function bookingAvailibility($id,$date=null){

    //     $availibility = self::where('product_id',$id)->with(['timeslots' => function($query){
    //         $query->select('id','booking_availibility_id','start_time','end_time','edit_id','date','type');
    //     }])->first();
    //     if($availibility == null){
    //         return  ['date-slots' => [],'time-slots' => []];
    //     }
    //     $availibilityArr = [];
    //     $availibilityTimeArr = [];
    //     if($availibility->all_day == 1){
    //         $availibilityTimeArr[] = 'true';
    //     }else{
    //         $allSlots = $availibility->timeslots;
    //         if($date != null){
    //             $allSlots = $allSlots->where('edit_id',null)->where('type',null);
    //             $editedSlots = $availibility->timeslots->where('date',$date)->where('type',1);
    //             foreach($allSlots as $timeslot){
    //                 foreach($editedSlots as $editedSlot){
    //                     if($editedSlot->edit_id == $timeslot->id){
    //                         $timeslot = $editedSlot;
    //                     }
    //                 }
    //                 $checkslots = BookingAvailibilityTimeSlot::query()
    //                 ->where('date',$date)
    //                 ->where('type',0)
    //                 ->where(function($query) use($timeslot){
    //                     $query->where('booking_availibility_id',$timeslot->id)
    //                     ->orWhere('edit_id',$timeslot->id);
    //                 })
    //                 ->first();
    //                 if(!$checkslots){
    //                     $time = date('h:i A',strtotime($timeslot->start_time));
    //                     $availibilityTimeArr[] = $time;
    //                 }
    //             }
    //         }else{
    //             foreach($allSlots as $timeslot){
    //                 if($timeslot->edit_id == null){

    //                     $checkslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$timeslot->id)->where('date',$availibility->date)->where('type',0)->first();
    //                     if(!$checkslots){
    //                         $time = date('h:i A',strtotime($timeslot->start_time));
    //                         $availibilityTimeArr[] = $time;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     // dd($availibilityTimeArr);
    //     if($availibility->is_recurring == 1){
    //         $datePeriods = CarbonPeriod::create($availibility->available_from, $availibility->available_to);
    //         $recurringDays = json_decode($availibility->recurring_value,true);
    //         foreach($datePeriods as $period){
    //             $checkslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$availibility->id)->where('type',0)->where('date',$period->format('Y-m-d'))->first();
    //             if(!$checkslots){
    //                 if(in_array($period->format('l'),$recurringDays)){
    //                     $availibilityArr[] = $period->format('Y-n-j');
    //                 }
    //             }
    //         }
    //     }else{
    //         $checkslots = BookingAvailibilityTimeSlot::where('booking_availibility_id',$availibility->id)->where('type',0)->where('date',$availibility->date)->first();
    //         if(!$checkslots){
    //             $availibilityArr[] = date('Y-n-j',strtotime($availibility->date));
    //         }
    //     }
    //     usort($availibilityTimeArr, function($a, $b) {
    //         return (strtotime($a) > strtotime($b));
    //     });
    //     $responseArr = ['date-slots' => $availibilityArr,'time-slots' => $availibilityTimeArr];
    //     return $responseArr;
    // }
    public static function isBookingAvailable($id,$arr=[],$allDay = false,$countOnly = false){
        if (isRezdyProduct($id)) {
            return ['status' => true,'message' => 'success','bookingCount' => 1];
        }

        try {
            // date_default_timezone_set('Asia/Kolkata');
            $request_timestamp = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d',strtotime($arr['date'])).' '. date('H:i:s',strtotime($arr['time'])));
            $time = $request_timestamp->format('H:i:s');
            $date =$request_timestamp->format('Y-m-d');
            $bookingAvailibility = self::where('product_id',$id)
            ->with(['timeslots' => function($query) use($date,$time,$allDay){
                $query->when($allDay, function($query) use($date,$time){
                    $query->where('start_time',null)
                    ->where('type',1)
                    ->where('date',$date);
                })
                ->when(!$allDay, function($query) use($date,$time){
                    $query->where('start_time',$time)
                    ->where(function($q) use($date,$time){
                        $q->where(function($query) use($date,$time){
                            $query->where('type',1)
                            ->where('date',$date);
                        })
                        ->orWhere('type',null);
                    });
                });
            }])
            ->when( $allDay,function($query) use($request_timestamp,$date){
                $query->where('available_from','<=',$date)
                ->where('available_to','>=',$date)
                ->orWhere(function($query) use($date){
                    $query->where('booking_availibilities.date',$date);
                });
            })
            ->when(!$allDay,function($query) use($request_timestamp,$time,$date){
                $query->whereHas('timeslots',function($q) use($time){
                    $q->where('start_time',$time);
                })
                ->where(function($query) use($date,$time){
                    $query->where('available_from','<=',$date)
                    ->where('available_to','>=',$date)
                    ->orWhere(function($query) use($time,$date){
                        $query->where('booking_availibilities.date',$date);
                    });
                });
            })
            // ->when(\DB::raw('booking_availibilities.is_recurring'), function($q) use($request_timestamp){
            //     $q->where('booking_availibilities.recurring_value','like','%'.$request_timestamp->format('l').'%');
            // })
            ->first();
            if($bookingAvailibility == null){
                return ['status' => false,'message' => 'Slot is not available'];
            }
            // dd($bookingAvailibility);
            $totalSlot = 0;
            // if($bookingAvailibility->is_recurring == 1){
            //     if(!in_array($request_timestamp->format('l'),json_decode($bookingAvailibility->recurring_value))){
            //         $availibily = ['status' => true,'message' => 'success','bookingCount' => 0];
            //         return $availibily;
            //     }
            // }
            if($bookingAvailibility->all_day == 1){
                $totalSlot = $bookingAvailibility->max_booking_no;
                $slot = $bookingAvailibility->timeslots->first();
                if($slot !=null){
                    $totalSlot = $slot->max_booking_no;
                }
            }else{
                // $totalSlot = $bookingAvailibility->timeslots->pluck('max_booking_no')->sum();
                $availabilitySlot = $bookingAvailibility->timeslots->first();
                if($availabilitySlot != null){
                    $totalSlot = $availabilitySlot->max_booking_no;
                }
            }
            if($countOnly){
                return ['status' => true,'message' => 'success','totalSlot' => $totalSlot];
            }
            $bookingCount = BookingOrderItems::where('place_product_id',$id)
            ->when(!$allDay,function($query) use($time){
                $query->where('booking_time', $time);
            })
            ->where('booking_date',$date)
            ->count();
            $userCartCount = Cart::where('place_product_id',$id)
            ->where('user_id',auth()->user()->id)
            ->where('booking_date',$date)
            ->when( !$allDay,function($query) use($time){
                $query->where('booking_time',$time);
            })
            ->count();
            $availiblebookingCount = $totalSlot - $bookingCount;

            if(!$allDay){
                $currentLocalTime =  Carbon::parse(date('H:i:s', strtotime('+'.$bookingAvailibility['booking_cut_off'])));
                if(auth()->check() && auth()->user()->timezone != null){
                    $currentLocalTime = $currentLocalTime->timezone(auth()->user()->timezone);
                }
                $currentLocalTime = $currentLocalTime->format('H:i:s');
                // if($date == date('Y-m-d') && $time < date('H:i:s', strtotime('+'.$bookingAvailibility['booking_cut_off']))){
                if($date == date('Y-m-d') && $time < $currentLocalTime){
                    return ['status' => false,'message' => 'Slot not available due to booking cut off time'];
                }
            }

            if ($availiblebookingCount == 0 || ($availiblebookingCount - $userCartCount <= 0)) {
                return ['status' => false,'message' => 'This slot is not available.'];
            }
            $availibily = ['status' => true,'message' => 'success','bookingCount' => $availiblebookingCount];
            return $availibily;
        } catch (\Throwable $th) {
            Log::info($th);
            return ['status' => false,'message' => 'Something went wrong!!'];
        }
    }

    protected static function getDayRange($startDate,$endDate,$exclude = []){
        $dates = CarbonPeriod::create($startDate, $endDate)->filter(function ($date) use($exclude) {
            if(empty($exclude)){
                return true;
            }else{
                return  in_array($date->format('l'),$exclude);
            }
        })->map(function ($date) {
            return $date->toDateString();
        });

        $dates = iterator_to_array($dates);
        return $dates;
    }
    public static function isBookingAvailableForStayCategory($id,$arr=[],$allDay = false,$countOnly = false){
        try {
            $date = Carbon::parse($arr['date'])->format('Y-m-d');
            $ckeckOutDate = Carbon::parse($arr['checkoutDate'])->format('Y-m-d');
            $bookingAvailabilityDates = [];
            $maxAdult = [];
            $maxChild = [];
            $maxRoom = [];

            $bookingAvailibility = self::query()
            ->where('product_id',$id)
            ->where(function($query)  use($date,$ckeckOutDate,$id){
                $query->whereBetween('available_from', [$date, $ckeckOutDate])
                ->orWhereBetween('date', [$date, $ckeckOutDate])
                ->orWhereBetween('available_to', [$date, $ckeckOutDate])
                ->orWhereRaw('? BETWEEN available_from and available_to', [$date])
                ->orWhereRaw('? BETWEEN available_from and available_to', [$ckeckOutDate]);
            })
            ->get();
            if($bookingAvailibility == null){
                return ['status' => false,'message' => 'Slot is not available'];
            }
            $requestRange = self::getDayRange($date,$ckeckOutDate);
            foreach($bookingAvailibility as $availibility){
                $maxRoom[] = $availibility->max_booking_no;
                $maxChild[] = $availibility->max_child_per_room;
                $maxAdult[] = $availibility->max_adult_per_room;
                if($availibility->is_recurring == 1){
                    $dates = self::getDayRange($availibility->available_from,$availibility->available_to,json_decode($availibility->recurring_value)??[]);
                    $bookingAvailabilityDates = array_merge($dates,$bookingAvailabilityDates);
                }else{
                    $bookingAvailabilityDates[] = $availibility->date;
                }
            }

            $containsAllValues = !array_diff($requestRange,$bookingAvailabilityDates);
            if(!$containsAllValues){
                return ['status' => false,'message' => 'Slot not available for this booking date range.'];
            }
            if(min($maxRoom) < $arr['no_of_room']){
                return ['status' => false,'message' => 'requested number of room is not available'];
            }
            if(min($maxAdult) < ($arr['number_of_adult']/$arr['no_of_room']) || min($maxChild) < ($arr['number_of_children']/$arr['no_of_room'])){
                return ['status' => false,'message' => 'Invalid number of adult or child per room, please add more room for other members.'];
            }

            $bookingCount = BookingOrderItems::where('place_product_id',$id)
            ->where(function($query)  use($date,$ckeckOutDate){
                $query->whereBetween('booking_date', [$date, $ckeckOutDate])
                ->orWhereBetween('checkout_date', [$date, $ckeckOutDate])
                ->orWhereRaw('? BETWEEN booking_date and checkout_date', [$date])
                ->orWhereRaw('? BETWEEN booking_date and checkout_date', [$ckeckOutDate]);
            })
            ->get()->pluck('no_of_room')->toArray();
            $bookingCount = array_sum($bookingCount) ?? 0;
            $userCartCount = Cart::where('place_product_id',$id)
            ->where('user_id',auth()->user()->id)
            ->where(function($query)  use($date,$ckeckOutDate){
                $query->whereBetween('booking_date', [$date, $ckeckOutDate])
                ->orWhereBetween('checkout_date', [$date, $ckeckOutDate])
                ->orWhereRaw('? BETWEEN booking_date and checkout_date', [$date])
                ->orWhereRaw('? BETWEEN booking_date and checkout_date', [$ckeckOutDate]);
            })
            ->get()
            ->toArray();
            $userCartCount = array_sum(array_column($userCartCount,'no_of_room')) ?? 0;
            $totalSlot = array_sum($maxRoom);
            $availiblebookingCount = $totalSlot - $bookingCount;
            // $arr = [
            //     'totalSlot' => $totalSlot,
            //     'userCartCount' => $userCartCount,
            //     'bookingCount' => $bookingCount,
            //     'availiblebookingCount' => $availiblebookingCount,
            //     '$availiblebookingCount - $userCartCount ' => ($availiblebookingCount - $userCartCount )
            // ];
            // dd($arr);
            if($availiblebookingCount == 0 || ($availiblebookingCount - $userCartCount < 0)){
                return ['status' => false,'message' => 'This slot is not available.'];
            }
            $availibily = ['status' => true,'message' => 'success','bookingCount' => $availiblebookingCount];
            return $availibily;
        } catch (\Throwable $th) {
            Log::info($th);
            return ['status' => false,'message' => 'Something went wrong!!'];
        }
    }

    public static function validateDateConflict($product_id,$date = null,$available_from = null,$available_to = null, $is_recurring, $recurring_value){
        $bookingAvailability = self::query()
        ->where('product_id',$product_id)
        ->when($date != null, function($query) use($date,$product_id){
            $query->whereDate('date', $date)
            ->orWhere(function($query)  use($date,$product_id){
                $query->where('product_id',$product_id)
                ->whereRaw('? BETWEEN available_from and available_to', [$date]);
            });
        })
        ->when($date == null, function($query) use($available_from,$available_to,$product_id){
            $query->where('product_id',$product_id)
            ->where(function($query)  use($available_from,$available_to,$product_id){
                $query->whereBetween('available_from', [$available_from, $available_to])
                ->orWhereBetween('available_to', [$available_from, $available_to])
                ->orWhereRaw('? BETWEEN available_from and available_to', [$available_from])
                ->orWhereRaw('? BETWEEN available_from and available_to', [$available_to]);
            });
        })
        ->get();
        $count = 0;
        foreach($bookingAvailability as $booking_availabity){
            $count++;
        }

        if($count > 0){
            foreach($bookingAvailability as $booking_availabity){
                // if($booking_availabity->is_recurring == 1){
                    $save_recurring = $booking_availabity->recurring_value;
                    $save_recurring_array = explode('","',trim($save_recurring,'[""]'));
                    $post_recurring_array = explode('","',trim($recurring_value,'[""]'));
                    $diff_array = array_intersect($save_recurring_array, $post_recurring_array);
                    $diff_count = count($diff_array);
                    // if($diff_count > 0 ){
                    //     return ['status' => false,'message' => "Booking availability conflict, you already added booking availability for this date slot"];
                    // }
                // }else{
                //     if($booking_availabity->date == $date){
                //         return ['status' => false,'message' => "Booking availability conflict, you already added booking availability for this date slot"];
                //     }
                // }
            }
        }
        return ['status' => true,'message' => "success"];
    }
}
