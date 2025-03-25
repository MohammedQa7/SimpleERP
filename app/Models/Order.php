<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id', 'created_at'];

    protected $casts = [
        'approved_at' => 'datetime',
        'status' => OrderStatus::class,
    ];

    public function getRouteKeyName()
    {
        return 'order_number';
    }


    function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }


    function scopeOnlyApprovedOrders($query)
    {
        return $query->where('status', OrderStatus::APPROVED->value);
    }
}