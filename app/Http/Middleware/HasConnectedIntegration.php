<?php

namespace App\Http\Middleware;

use App\Models\IntegrationProviders;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasConnectedIntegration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->isAppConnected($request->route('provider'))) {
            return redirect()->route('provider.connected', ['provider' => $request->route('provider')]);
        }
        return $next($request);
    }
}