<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class AdsBanner extends Model
{
    use Translatable;

    protected $table = 'ads_banners';

    protected $fillable = ['title','image'];

    public $translatedAttributes = ['title'];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
