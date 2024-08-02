<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceProductWishlist extends Model
{
    protected $table = 'place_product_wishlists';
    
    protected $fillable = ['user_id','place_id','product_id'];

}
