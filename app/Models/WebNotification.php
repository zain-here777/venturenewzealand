<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebNotification extends Model
{

    const TYPE_BROADCAST = 1;
    const TYPE_SINGLE = 2;
    const TYPE_ONE_TO_ONE = 3;

    protected $table = "web_notifications";

    protected $fillable = [
        'title', 'body', 'image', 'type', 'delete_type','redirect_to','place_id', 'product_id', 'for_user_id', 'from_user_id'
    ];

    public function web_notification_actions()
    {
        return $this->hasMany(WebNotificationAction::class, 'notification_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
