<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserViewPlace extends Model
{
    protected $table = 'user_view_places';
    protected $fillable = ['user_id', 'place_id', 'view_at'];

    const MAX_PLACE_VIEW_CAN_ADD = 4;

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id')->whereIn('places.status', [
            Place::STATUS_ACTIVE,
            Place::STATUS_PENDING,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
