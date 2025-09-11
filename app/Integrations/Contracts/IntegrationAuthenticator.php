<?php
namespace App\Integrations\Contracts;

interface IntegrationAuthenticator
{
    function redirect();
    function callback();
    function revoke();
    function dispatchJobs();
}