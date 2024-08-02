<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class PlaceProduct extends Model
{
    protected $table = 'place_products';

    protected $fillable = [
        'place_id', 'name', 'description', 'price','color_code', 'child_price', 'child_discount_price', 'thumb', 'discount_percentage', 'discount_start_date', 'discount_end_date', 'featured', 'booking_link', 'online_payment_required','car_price','car_discount_price'
    ];

    public function placeProductWishlist()
    {
        return $this->hasOne(PlaceProductWishlist::class, 'product_id', 'id')->where('user_id', Auth::id());
    }

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }

    public function operator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getPriceAttribute($value)
    {
        if (isset($value)) {
            return floatval($value);
        }
        return $value;
    }

    public function getCarPriceAttribute($value)
    {
        if (isset($value)) {
            return floatval($value);
        }
        return $value;
    }

    public function getChildPriceAttribute($value)
    {
        if (isset($value)) {
            return floatval($value);
        }
        return $value;
    }

    public function getChildDiscountPriceAttribute($value)
    {
        if (isset($value)) {
            return floatval($value);
        }
        return $value;
    }

    public function getCarDiscountPriceAttribute($value)
    {
        if (isset($value)) {
            return floatval($value);
        }
        return $value;
    }

    public function getDiscountPercentageAttribute($value)
    {
        if (isset($value)) {
            return floatval($value);
        }
        return $value;
    }
    public function bookingAvailibilities()
    {
        return $this->hasMany(BookingAvailibility::class, 'product_id', 'id');
    }
}
