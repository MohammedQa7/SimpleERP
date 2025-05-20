<?php

namespace App\Models;

use App\Enums\Priorities;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];


    function casts()
    {
        return [
            'priority' => Priorities::class,
        ];
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function invitedUsers()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
}