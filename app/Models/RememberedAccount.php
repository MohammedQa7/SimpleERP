<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class RememberedAccount extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];
    function getRouteKeyName()
    {
        return 'uuid';
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Scopes
    function scopeCheckDeviceToken($query)
    {
        $device_token = hash('sha256', Cookie::get('device_token'));
        return $query->where('device_token', $device_token);
    }
}