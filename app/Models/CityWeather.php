<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityWeather extends Model
{
    protected $table = 'city_weather';

    protected $fillable = [
        'city_id','city_name','temprature','temprature_phrase','unit','icon_url'
    ];
}
