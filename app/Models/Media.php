<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    function folder()
    {
        return $this->belongsToMany(Folder::class, 'folder_media');
    }
}