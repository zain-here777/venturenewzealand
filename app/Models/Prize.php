<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $table = 'prizes';

    protected $fillable = [
        'product_id', 'date_from', 'date_to', 'scan_no'
    ];

    protected $cast = [
        'product_id' => 'integer',
        'scan_no'    => 'integer'
    ];
}
