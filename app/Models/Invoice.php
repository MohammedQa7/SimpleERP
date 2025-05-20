<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];

    function getRouteKeyName()
    {
        return 'invoice_number';
    }

    protected function casts(): array
    {
        return [
            'status' => InvoiceStatus::class,
            'ends_at' => 'datetime',
        ];
    }

    function order()
    {
        return $this->belongsTo(Order::class);
    }

    function scopeRecentInvoices($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }
}