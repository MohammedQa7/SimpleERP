<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockLogs extends Model
{
    protected $guarded = [
        'id ',
        'created_at'
    ];


    function product()
    {
        return $this->belongsTo(Product::class);
    }
}