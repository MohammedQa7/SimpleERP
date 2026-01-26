<?php

use App\Http\Controllers\AppearanceController;
use App\Http\Controllers\Integration\ProivderSettingsController;
use App\Http\Controllers\Integration\ProviderConnectionController;
use App\Http\Controllers\Integration\Slack\SlackChannelsController;
use App\Http\Controllers\IntegrationAuthController;
use App\Http\Controllers\IntegrationConnectionController;
use App\Http\Controllers\IntegrationsController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Middleware\EnsureProviderIsAvailable;
use App\Http\Middleware\HasConnectedIntegration;
use App\Notifications\SlackChannelNotification;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/appearance', AppearanceController::class)->name('appearance');


    // 3rd Party apps
    Route::get('settings/connected-apps', IntegrationsController::class)->name('integrations.index');

    Route::prefix('/{provider}')->group(function () {
        Route::middleware(EnsureProviderIsAvailable::class)->group(function () {
            Route::get('/connect', [IntegrationAuthController::class, 'redirect'])->name('integration.redirect')->middleware(HasConnectedIntegration::class);
            Route::get('/callback', [IntegrationAuthController::class, 'callback'])->name('integration.callback');
            Route::delete('/revoke', [IntegrationConnectionController::class, 'revoke'])->name('integration.disconnect');
            Route::get('/already-connected', ProviderConnectionController::class)->name('provider.connected');
        });
        Route::get('/settings', [ProivderSettingsController::class, 'index'])->name('provider.settings');
    });

    // Slack configuration settings
    Route::prefix('slack')->group(function () {
        Route::resource('/channels', SlackChannelsController::class)->except(['edit', 'show'])->names('slack.channels');

        Route::get('/test', function () {
            auth()->user()->notify(new SlackChannelNotification("C0A3ADHG467", 'test ', 'test'));
        });
    });

});