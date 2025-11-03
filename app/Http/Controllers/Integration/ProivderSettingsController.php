<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Integrations\Provider\IntegrationServiceProvider;
use App\Traits\InertiaFlashMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProivderSettingsController extends Controller
{
    use InertiaFlashMessage;
    function index(Request $request, IntegrationServiceProvider $integration_serivce_provider, $provider)
    {
        $provider_service = $integration_serivce_provider->getProvider($provider);

        if ($provider_service->hasSettings()) {
            return Inertia::render('settings/ConnectedApps', $provider_service->settings());
        }

        $this->error('This integration does not have configurable settings.');
        return Inertia::render('settings/ConnectedApps', []);


    }
}