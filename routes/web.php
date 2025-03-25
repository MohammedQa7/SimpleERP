<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


// Sales Department And Controllers
Route::middleware('auth')->prefix('sales')->group(function () {
    Route::resource('orders', OrderController::class)->names('orders');
});

Route::middleware('auth')->prefix('users')->group(function () {
    Route::resource('management', UserController::class)->names('users')->parameters(['management' => 'user']);
});

Route::middleware('auth')->prefix('finance')->group(function () {
    Route::resource('invoices', InvoiceController::class)->names('invoices');
});


Route::get('test', function () {
    return Inertia::render('test');
});




Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';