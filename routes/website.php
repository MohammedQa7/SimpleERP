<?php
use App\Http\Controllers\TenantRegistrationController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\PricingController;
use Illuminate\Support\Facades\Route;

Route::get('/home', IndexController::class)->name('website.index');
Route::get('/pricing', PricingController::class)->name('website.pricing');

Route::post('company/tenant/store', TenantRegistrationController::class)->name('tenant.store');