<?php

use App\Enums\UserRoles;
use App\Http\Controllers\AdjustProductStockController;
use App\Http\Controllers\ApproveStockRequestController;
use App\Http\Controllers\DownloadAttachmentController;
use App\Http\Controllers\DownloadInvoicesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FinanceStatisticsController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HrStatisticsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\ProductHistoryController;
use App\Http\Controllers\RejectStockRequestController;
use App\Http\Controllers\UploadTemporatyAttachmentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseDepartment\ProductController;
use App\Http\Controllers\WarehouseRequestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    // Sales Department
    Route::middleware(['role:' . UserRoles::ADMINISTRATOR->value . '|' . UserRoles::SALES_MANAGER->value])->prefix('sales')->group(function () {
        Route::resource('orders', OrderController::class)->names('orders');
    });

    // CRM Department
    Route::middleware(['role:' . UserRoles::ADMINISTRATOR->value . '|' . UserRoles::CRM_MANAGER->value])->prefix('users')->group(function () {
        Route::resource('management', UserController::class)->names('users')->parameters(['management' => 'user']);
    });

    // Finance Department
    Route::middleware(['role:' . UserRoles::ADMINISTRATOR->value . '|' . UserRoles::FINANCE_MANAGER->value])->prefix('finance')->group(function () {
        Route::get('statistics', FinanceStatisticsController::class)->name('finance.statistics');
        Route::resource('invoices', InvoiceController::class)->names('invoices');
        Route::resource('payment/transaction', PaymentTransactionController::class)->except(['edit', 'update', 'delete'])->names('payments');
        Route::get('/attachment/download/{attachment}', DownloadAttachmentController::class)->name('download-attachments')->middleware('password.confirm');
    });

    // Inventory Department
    Route::middleware(['role:' . UserRoles::ADMINISTRATOR->value . '|' . UserRoles::INVENTORY_MANAGER->value, 'password.confirm'])->prefix('inventory')->group(function () {
        Route::resource('products', ProductController::class)->names('products');
        Route::post('product/{product}/stock/adjustment', AdjustProductStockController::class)->name('stock.adjust');
        Route::get('product/history/{product}', ProductHistoryController::class)->name('product.history');
        Route::post('approve/{stock_request}/request', ApproveStockRequestController::class)->name('approve.stock.request');
        Route::post('reject/{stock_request}/request', RejectStockRequestController::class)->name('reject.stock.request');
        Route::get('warehouse/notificaions', [WarehouseRequestController::class, 'notificaions'])->name('warehouse.notificaions');
    });


    // Inventory Department
    Route::middleware(['role:' . UserRoles::ADMINISTRATOR->value . '|' . UserRoles::HR_MANAGER->value])->prefix('hr')->group(function () {
        Route::resource('employees', EmployeeController::class)->names('employees');
        Route::resource('events', EventsController::class)->except('index')->names('events');
        Route::get('calendar/events', [EventsController::class, 'index'])->name('events.calendar');
        Route::get('statistics', HrStatisticsController::class)->name('hr.statistics');
    });


    // Folders / Files Mangers
    Route::resource('folders', FolderController::class)->names('folders');





    // Uploading Attachments
    Route::post('/attachments/upload', [UploadTemporatyAttachmentsController::class, 'uploadAttachments'])->name('upload');
    Route::post('/attachments/revert', [UploadTemporatyAttachmentsController::class, 'revertAttachments'])->name('revert');
    // Download Invoices.
    Route::get('/attachment/download/{invoice}', DownloadInvoicesController::class)->name('download');

});



Route::get('test', function () {
    return Inertia::render('test');
});

Route::get('test2', function () {
    return Inertia::render('calendar');
});






Route::get('dashboard', function () {


    function findAndReplacePattern($words, $pattern)
    {
        $matched_words = [];
        foreach ($words as $word) {
            if (doesWordMatchPattern($word, $pattern)) {
                $matched_words[] = $word;
            }
        }

        return $matched_words;
    }
    function doesWordMatchPattern($word, $pattern)
    {

        $pattern_to_word = [];
        $word_to_pattern = [];

        for ($i = 0; $i < strlen($pattern); $i++) {
            $p_char = $pattern[$i];
            $w_char = $word[$i];

            // if
            if (isset($pattern_to_word[$p_char]) && $pattern_to_word[$p_char] != $w_char || isset($word_to_pattern[$w_char]) && $word_to_pattern[$w_char] != $p_char) {
                dump($pattern_to_word, $word_to_pattern);
                return false;
            }


            $pattern_to_word[$p_char] = $w_char;
            $word_to_pattern[$w_char] = $p_char;

        }

        // dump($pattern_to_word, $word_to_pattern);
        return true;

    }



    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';