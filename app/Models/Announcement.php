<?php

namespace App\Models;

use App\Enums\AnnouncmentsType;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Announcement extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [
        'id',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'type' => AnnouncmentsType::class,
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}