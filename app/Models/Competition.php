<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $table = 'competitions';

    protected $fillable = [
        'title', 'description', 'terms_and_conditions', 'image', 'background_image', 'entry_fee_points', 'prize_points',
        'start_date', 'end_date'
    ];

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function participants()
    {
        return $this->hasMany(CompetitionParticipation::class, 'competition_id', 'id');
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            CompetitionParticipation::class,
            'competition_id',
            'id',
            'id',
            'user_id'
        );
    }
}
