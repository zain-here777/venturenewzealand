<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $table = 'interests';

    protected $fillable = [
        'category_id', 'keyword'
    ];

    protected $cast = [
        'category_id' => 'integer',
    ];

    // public function category(){
    //     return $this->belongsTo(Category::class);
    // }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getListByCategory($category_id)
    {
        $interests = self::query()->with('category');
        if ($category_id) {
            $interests->where('category_id', $category_id);
        }
        $interests = $interests->orderBy('created_at', 'desc')->get();
        return $interests;
    }
}
