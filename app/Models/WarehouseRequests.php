<?php

namespace App\Models;

use App\Enums\WarehousePriority;
use App\Enums\WarehouseStatus;
use Illuminate\Database\Eloquent\Model;

class WarehouseRequests extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];

    protected function casts()
    {
        return [
            'status' => WarehouseStatus::class,
            'priority' => WarehousePriority::class,
        ];
    }



    // Relationships
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function order()
    {
        return $this->belongsTo(Order::class);
    }
    function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scoped

    function scopeisTherePrevoiusRequest($query, $order, $product)
    {
        return $query->where('order_id', $order->id)
            ->where('product_id', $product->id);
    }



}