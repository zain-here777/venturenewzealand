<?php

namespace App\Models;


use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

class City extends Model implements TranslatableContract
{

    const FLAG_FETCH_WEATHER_DATA_NO = 0;
    const FLAG_FETCH_WEATHER_DATA_YES = 1;

    const OEPNWEATHERMAP_API_KEY = "4cfb4588731a160eb67b57c99b633648"; //openweathermap api key

    use Translatable;

    public $translatedAttributes = ['name', 'intro', 'description'];

    protected $table = 'cities';

    protected $fillable = [
        'country_id', 'slug',
        'thumb', 'banner', 'map', 'map_tile','website', 'video', 'best_time_to_visit', 'currency', 'language', 'lat', 'lng', 'seo_title', 'seo_description',
        'priority', 'status' , 'is_popular' , 'fetch_weather_data'
    ];

    protected $hidden = [];

    protected $casts = [
        'country_id' => 'integer',
        'priority' => 'integer',
        'lat' => 'double',
        'lng' => 'double',
        'status' => 'integer',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function places()
    {
        return $this->hasMany(Place::class, 'city_id');
    }

    public function getListByCountry($country_id)
    {
        $cities = self::query()->with('country');
        if ($country_id) {
            $cities->where('country_id', $country_id);
        }
        $cities = $cities->orderBy('created_at', 'desc')->get();
        return $cities;
    }

    public function getBySlug($slug)
    {
        return self::query()
            ->with('country')
            ->where('slug', $slug)
            ->first();
    }
}
