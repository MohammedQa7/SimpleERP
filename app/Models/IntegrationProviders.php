<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class IntegrationProviders extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [
        'id',
        'created_at'
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }


    public function scopeisIntegrationProviderAvailableAndExists($query, $provider)
    {
        return $query->where('key', $provider)->where('available', true)->exists();
    }
}