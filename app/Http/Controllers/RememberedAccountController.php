<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\RememberedAccount;
use App\Services\RememberedAccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RememberedAccountController extends Controller
{
    function store(LoginRequest $request, RememberedAccountService $remembered_account_service)
    {
        if (auth()->user()->email == $request->email) {
            return throw ValidationException::withMessages([
                'notice' => 'You are currently signed in with this account and cannot link it again.'
            ]);
        }

        if (auth()->user()->checkAndValidateCurrentDeviceToken()) {
            dd('device_token');
            // trusted device
            DB::transaction(function () use ($request, $remembered_account_service) {
                $request->authenticate();
                $remembered_account_service->rememberSignedInAccount(auth()->user()->id);
            });

        } else {
            // unknown or invalid device
            DB::transaction(function () use ($request, $remembered_account_service) {
                // Current / Primary signed in account
                $remembered_account_service->generateDeviceToken();
                $remembered_account_service->rememberSignedInAccount(auth()->user()->id);

                // new signed in account
                $request->authenticate();
                $remembered_account_service->rememberSignedInAccount(auth()->user()->id);
            });
        }

        return redirect()->intended(route('dashboard', absolute: false));

    }

    function switch (RememberedAccount $account)
    {
        $device_token = hash('sha256', Cookie::get('device_token'));
        if ($account->device_token == $device_token) {
            Auth::loginUsingId($account->user_id);
        } else {
            abort(404);
        }
    }
}