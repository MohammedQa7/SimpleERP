<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProviderConnectionController extends Controller
{
    function __invoke(Request $request)
    {
        $user_provider_last_login = auth()->user()->connectedApps()->where('service', $request->provider)->select('created_at')->firstOrFail();

        return Inertia::render('OAuth/AlreadyConnected', [
            'lastLogin' => $user_provider_last_login->created_at->format('M d, Y \a\t h:m A'),
        ]);
    }
}