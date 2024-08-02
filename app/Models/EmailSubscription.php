<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class EmailSubscription extends Model
{
    protected $table = 'email_subscription';

    protected $fillable = [
        'email', 'name'
    ];
}