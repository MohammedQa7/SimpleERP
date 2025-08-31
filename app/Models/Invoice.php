<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Invoice extends Model implements HasMedia
{
    use InteractsWithMedia;
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
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentTransaction()
    {
        return $this->morphOne(PaymentTransaction::class, 'modelable');
    }

    function scopeRecentInvoices($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }
}