<?php

namespace App\Http\Middleware;

use App\Models\IntegrationProviders;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProviderIsAvailable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (IntegrationProviders::isIntegrationProviderAvailableAndExists($request->route('provider'))) {
            return $next($request);
        }
        return abort(code: 404, message: 'provider does not exists');
    }
}