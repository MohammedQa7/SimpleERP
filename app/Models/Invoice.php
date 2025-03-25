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


    protected function casts(): array
    {
        return [
            'status' => InvoiceStatus::class,
        ];
    }
}