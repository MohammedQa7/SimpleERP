<?php
namespace App\Integrations\Provider;

use App\Integrations\Slack\SlackOAuth;
use Exception;

class IntegrationAuthProvider
{
    protected $providers_array = [];
    public function __construct()
    {
        $this->providers_array = [
            'slack' => SlackOAuth::class,
        ];
    }

    function getProvider($provider)
    {
        if (!array_key_exists($provider, $this->providers_array)) {
            return throw new Exception("Unknown provider: $provider");
        }

        return app($this->providers_array[$provider]);
    }
}