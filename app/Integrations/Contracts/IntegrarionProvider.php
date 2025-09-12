<?php
namespace App\Integrations\Contracts;

abstract class IntegrarionProvider
{
    /**
     * Does this provider have settings?
     */
    public function hasSettings(): bool
    {
        return false;
    }

    /**
     * Return data to be passed directly to Inertia
     */
    public function settings(): array
    {
        return [];
    }

}