<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $guarded = [
        'id',
        'created_at',
    ];

    function media()
    {
        return $this->belongsToMany(Media::class, 'folder_media');
    }

    function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    function subFolders()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }
}