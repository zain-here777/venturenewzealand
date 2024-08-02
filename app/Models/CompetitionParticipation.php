<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionParticipation extends Model
{

    const STATUS_PARTICIPATE = 0;
    const STATUS_WIN = 1;
    const STATUS_LOSS = 2;

    protected $table = 'competition_participations';

    protected $fillable = [
        'user_id','competition_id','entry_fee_points','prize_points','status'
    ];

    public function competition() {
        return $this->hasOne(Competition::class, 'id', 'competition_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
