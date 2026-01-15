<?php

namespace App\Services;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\RememberedAccount;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class RememberedAccountService
{

    private $device_token;
    function __construct()
    {
        $this->device_token = Str::random(70);
    }
    function rememberSignedInAccount($user_id)
    {
        RememberedAccount::create([
            'uuid' => Str::uuid(),
            'user_id' => $user_id,
            'device_token' => hash('sha256', $this->device_token),
            'last_used_at' => now(),
        ]);

    }

    function generateDeviceToken()
    {
        if (!Cookie::has('device_token')) {
            Cookie::queue(
                'device_token',
                $this->device_token,
                60 * 24 * 365,
                '/',
                null,
                app()->environment('production'),
                // secure ONLY in prod
                true
            );

        }
    }

}