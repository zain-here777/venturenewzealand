<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PlaceInterest extends Model
{
    protected $table = 'place_interests';

    protected $fillable = [
        'place_id', 'interest_id'
    ];

    protected $cast = [
        'place_id' => 'integer',
        'interest_id' => 'integer'
    ];

    public function places()
    {
        return $this->belongsTo(Place::class, 'id');
    }
}
