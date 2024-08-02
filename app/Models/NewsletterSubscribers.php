<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscribers extends Model
{
    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email','fullname'
    ];
}
