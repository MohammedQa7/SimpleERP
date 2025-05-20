<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\WarehouseRequests;
use App\Policies\OrderPolicy;
use App\Policies\WarehouseRequestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Order::class => OrderPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(WarehouseRequests::class, WarehouseRequestPolicy::class);

    }
}