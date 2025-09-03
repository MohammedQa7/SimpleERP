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

    function hasGeneratedInvoice()
    {
        if (!$this->relationLoaded('invoice')) {
            $this->load('invoice');

            return !is_null($this->invoice);
        }
        return !is_null($this->invoice);

    }

    // Relationships
    function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    function hasInvoice()
    {
        return $this->invoice()->exists();
    }

    // Scopes
    function scopeOnlyApprovedOrders($query)
    {
        return $query->where('status', OrderStatus::APPROVED->value);
    }


}