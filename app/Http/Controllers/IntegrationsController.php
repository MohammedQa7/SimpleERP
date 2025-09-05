<?php

namespace App\Http\Controllers;

use App\Http\Resources\IntegrationProviderResource;
use App\Integrations\Slack\Services\SlackService;
use App\Models\IntegrationProviders;
use App\Traits\InertiaFlashMessage;
use Inertia\Inertia;

class IntegrationsController extends Controller
{
    use InertiaFlashMessage;
    function __invoke()
    {
        $integrations = IntegrationProviders::get();

        return Inertia::render('settings/ConnectedApps', [
            'integrations' => IntegrationProviderResource::collection($integrations),
            'sessionMessage' => session()->get('sessionMessage') ?? null,
        ]);
    }
}