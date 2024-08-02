<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebNotificationAction extends Model
{
    public $timestamps = false;

    protected $table = "web_notification_actions";

    protected $fillable = [
        'notification_id','user_id','place_id','product_id','read_at','delete_at'
    ];
}
