<?php
namespace App\Integrations\Provider;

use App\Integrations\Slack\Services\SlackService;
use Exception;

class IntegrationServiceProvider
{
    protected $providers_array = [];
    public function __construct()
    {
        $this->providers_array = [
            'slack' => new SlackService(),
        ];
    }

    function getProvider($provider)
    {
        if (!array_key_exists($provider, $this->providers_array)) {
            return throw new Exception("Unknown provider: $provider");
        }

        return $this->providers_array[$provider];
    }
}