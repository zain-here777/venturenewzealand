<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BookingOrderItems extends Model
{
    protected $table = 'booking_order_items';
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'user_id', 'booking_order_id', 'place_id', 'place_product_id',
    //     'number_of_adult', 'number_of_children', 'booking_date', 'booking_time', 'price',
    //     'child_price'
    // ];

    public function place_product()
    {
        return $this->hasOne(PlaceProduct::class, 'id', 'place_product_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function booking_notes()
    {
        return $this->hasOne(BookingAvailibility::class, 'product_id', 'place_product_id');
    }

    public function booking_order()
    {
        return $this->belongsTo(BookingOrder::class,'booking_order_id','id');
    }

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }

    public function getTotalNumberOfBooking()
    {
        $totalNumberMembers = 0;
        if (isset($this->attributes['price'])) {
            $totalNumberMembers += $this->attributes['number_of_adult'];
        }

        if (isset($this->attributes['child_price'])) {
            $totalNumberMembers += $this->attributes['number_of_children'];
        }
        return $totalNumberMembers;
    }

    public function totalPrice()
    {
        $totalAmount = 0;
        if (isset($this->attributes['price'])) {
            $totalAmount += $this->attributes['number_of_adult'] * $this->attributes['price'];
        }

        if (isset($this->attributes['child_price'])) {
            $totalAmount += $this->attributes['number_of_children'] * $this->attributes['child_price'];
        }

        if (isset($this->attributes['car_price'])) {
            $totalAmount += $this->attributes['number_of_car'] * $this->attributes['car_price'];
        }
        return $totalAmount;
    }

    public function changeDateFormat()
    {
        return Carbon::parse($this->attributes['booking_date'])->format('d/m/y');
    }

    public function changeCheckoutDateFormat()
    {
        return Carbon::parse($this->attributes['checkout_date'])->format('d/m/y');
    }

    public function changeTimeFormat()
    {
        return Carbon::parse($this->attributes['booking_time'])->format('h:i a');
    }

    public static function getCartItemsByOperatorId($operatorid,$bookingid)
    {
        if (auth()->user()) {
            $operatorCartItems = BookingOrderItems::query()
                ->select('booking_order_items.*', 'place_products.name as product_name')
                ->join('place_products', 'place_products.id', '=', 'booking_order_items.place_product_id')
                ->join('places', 'places.id', '=', 'place_products.place_id')
                ->join('users', 'users.id', '=', 'places.user_id')
                ->where('places.user_id', $operatorid)
                ->where('booking_order_items.booking_order_id',$bookingid)
                ->get();

            return $operatorCartItems;
        } else {
            return false;
        }
    }
}
