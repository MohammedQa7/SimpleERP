<?php

namespace App\Models;

use App\Enums\PaymentMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PaymentTransaction extends Model implements HasMedia
{
    use InteractsWithMedia;

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

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
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