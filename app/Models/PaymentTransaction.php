<?php

namespace App\Models;

use App\Enums\PaymentMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PaymentTransaction extends Model
{
    protected $guarded = [
        'id',
        'created_at',
    ];

    protected function casts()
    {
        return [
            'method' => PaymentMethods::class
        ];
    }

    function getRouteKeyName()
    {
        return 'payment_number';
    }


    function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}