<?php

namespace App\Models;
use App\Scopes\IsBookingDeletedScope;

use Illuminate\Database\Eloquent\Model;

class BookingAvailibilityTimeSlot extends Model
{
    const TYPEEDIT = 1;
    const TYPEDELTE = 0;
    protected $fillable = [
         'booking_availibility_id','start_time','end_time','booking_note', 'max_booking_no','type','date','edit_id','is_deleted'
    ];
    // public function scopeDelete($query)
    // {
    //     return $query->where('is_deleted', 1);
    // }

    protected $hidden = ['created_at','updated_at'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new IsBookingDeletedScope);
    }
    public function bookingAvailibility()
    {
        return $this->belongsTo(BookingAvailibility::class,'booking_availibility_id','id');
    }
}
