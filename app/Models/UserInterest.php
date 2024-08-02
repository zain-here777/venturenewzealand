<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    protected $table = 'user_interests';

    protected $fillable = [
        'user_id', 'interest_id'
    ];

    protected $cast = [
        'user_id' => 'integer',
        'interest_id' => 'integer'
    ];
}
