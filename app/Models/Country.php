<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name', 'slug', 'description', 'about', 'banner', 'countrymap', 'countrymap_tile', 'website', 'video'
    ];

    protected $hidden = [];

    protected $casts = [
        'category_id' => 'integer'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;
    const DEFAULT = 1;

    public function getFullList()
    {
        return self::query()
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }

    public function getBySlug($slug)
    {
        return self::query()
            ->where('slug', $slug)
            ->first();
    }
}
