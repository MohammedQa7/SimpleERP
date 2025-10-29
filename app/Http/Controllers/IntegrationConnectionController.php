<?php

namespace App\Http\Controllers;

use App\Integrations\Provider\IntegrationAuthProvider;
use App\Integrations\Services\IntegrationAuthService;
use App\Traits\FlashMessage;
use App\Traits\InertiaFlashMessage;
use Inertia\Inertia;

class IntegrationConnectionController extends Controller
{
    use InertiaFlashMessage;
    function revoke($provider, IntegrationAuthProvider $integration_provider, IntegrationAuthService $integration_auth)
    {
        $provider_instance = $integration_provider->getProvider($provider);

        // Api call to revoke the token on the platfrom
        $status_result = $integration_auth->revoke($provider_instance);

        // revoking the token internally.
        auth()->user()->connectedApps()->where('service', $provider)->delete();
        if ($status_result) {
            $this->success("Your {$provider} account has been successfully removed!");
            return back();
        }

        $this->error('Somehting went wrong while trying to remove your linked account');
        return back();
    }
}