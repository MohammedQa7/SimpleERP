<?php

namespace App\Http\Controllers;

use App\Exceptions\OAuthProviderException;
use App\Integrations\Provider\IntegrationAuthProvider;
use App\Integrations\Services\IntegrationAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IntegrationAuthController extends Controller
{

    function redirect($provider, IntegrationAuthProvider $integration_provider, IntegrationAuthService $integration_auth)
    {
        // Retrieve the instance of the specified integration provider
        $provider = $integration_provider->getProvider($provider);

        // Use the integration auth service to initiate the OAuth redirect 
        // specific to the retrieved provider
        return $integration_auth->redirect($provider);
    }

    function callback(Request $request, $provider, IntegrationAuthProvider $integration_provider, IntegrationAuthService $integration_auth)
    {

        try {
            DB::beginTransaction();

            // Retrieve the instance of the specified integration provider
            $provider_instance = $integration_provider->getProvider($provider);
            // Handle the provider callback (e.g., fetch user data, create session)
            $provider_data = $integration_auth->callback($provider_instance);

            // Connect the app with the user
            auth()->user()->connectedApps()->create([
                'service' => $provider_data->provider,
                'access_token' => $provider_data->access_token,
                'refresh_token' => $provider_data->refresh_token,
                'expires_at' => $provider_data->expires_at,
                'meta' => $provider_data->attributes
            ]);

            // Dispatching a job to get external user data from slack api
            $integration_auth->dispatchJobs($provider_instance);

            DB::commit();
            return redirect()->route('integrations.index')->with([
                'sessionMessage' => [
                    'message' => "Your {$provider} account has been successfully connected!",
                    'type' => 'success',
                ]
            ]);

        } catch (OAuthProviderException $e) {
            DB::rollBack();
            return redirect()->route('integrations.index')->with([
                'sessionMessage' => [
                    'message' => $e->getMessage(),
                    'type' => 'error',
                ]
            ]);

            // * This catches any External/System Error
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("OAuth System Failure: " . $e->getMessage());
            return redirect()->route('integrations.index')->with([
                'sessionMessage' => [
                    'message' => "OAuth System Failure:" . $e->getMessage(),
                    'type' => 'error',
                ]
            ]);
        }
    }
}