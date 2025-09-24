<?php

namespace App\Models;

use App\Enums\Departments;
use App\Observers\SlackNotificationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([SlackNotificationObserver::class])]
class SlackNotification extends Model
{
    protected $guarded = [
        'id ',
        'created_at'
    ];

    function casts()
    {
        return [
            'department' => Departments::class,
        ];
    }
    function getRouteKeyName()
    {
        return 'channel_id';
    }

}