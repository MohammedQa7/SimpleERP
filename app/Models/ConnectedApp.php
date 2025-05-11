<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectedApp extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];

    function casts()
    {
        return [
            'meta' => 'array',
        ];
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}