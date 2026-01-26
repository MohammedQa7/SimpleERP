<?php

namespace App\Http\Controllers;

use App\Enums\TenantSetupStep;
use App\Events\TenantDatabaseSetup;
use App\Events\TenantDomainSetup;
use App\Events\TenantEssentialDataCreation;
use App\Events\TenantFinalizingProcess;
use App\Events\TenantSetupSteps;
use Illuminate\Http\Request;

class TenantRegistrationController extends Controller
{
    function __invoke()
    {
        broadcast(new TenantSetupSteps(tenant_event_steps: TenantSetupStep::toArray()));

        sleep(5);
        broadcast(new TenantDomainSetup);
        broadcast(new TenantDatabaseSetup);

        sleep(3);
        broadcast(new TenantEssentialDataCreation);
        sleep(4);
        broadcast(new TenantFinalizingProcess);
    }
}