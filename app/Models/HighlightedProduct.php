<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HighlightedProduct extends Model
{
    protected $fillable = ['place_product_id', 'status'];

    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;

    public function getFullList($all = true)
    {
        return self::query()
            ->when(!$all, function($q){
                $q->has('product');
            })
            ->with('product.place')
            ->select('id', 'place_product_id', 'status')
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('created_at', 'desc')
            ->when(!$all, function($q){
                $q->take(10);
            })
            ->get();
    }

    public function product()
    {
        return $this->hasOne(PlaceProduct::class, 'id', 'place_product_id');
    }
}
