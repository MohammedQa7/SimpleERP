<?php

namespace App\Exceptions;

use Exception;

class OAuthProviderException extends Exception
{
    protected $provider;

    public function __construct($message, $provider = null)
    {
        parent::__construct($message);

        $this->provider = $provider;
    }

    public function getProvider()
    {
        return $this->provider;
    }
}