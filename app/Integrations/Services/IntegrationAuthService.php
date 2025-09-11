<?php

namespace App\Integrations\Services;

use App\Integrations\Contracts\IntegrationAuthenticator;

class IntegrationAuthService
{
    function redirect(IntegrationAuthenticator $provider)
    {
        return $provider->redirect();
    }

    function callback(IntegrationAuthenticator $provider)
    {
        return $provider->callback();
    }

    function revoke(IntegrationAuthenticator $provider)
    {
        return $provider->revoke();
    }


    function dispatchJobs(IntegrationAuthenticator $provider)
    {
        return $provider->dispatchJobs();
    }
}