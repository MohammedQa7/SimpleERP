<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $guarded = ['id', 'created_at'];

    function order()
    {
        return $this->belongsTo(Order::class);
    }

    function product()
    {
        return $this->belongsTo(Product::class);
    }
}