<?php

use App\Actions\AttachMediaToAnyModel;
use App\Enums\UserRoles;
use App\Http\Controllers\AdjustProductStockController;
use App\Http\Controllers\ApproveStockRequestController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\DepartmentRequestController;
use App\Http\Controllers\DownloadAttachmentController;
use App\Http\Controllers\DownloadInvoicesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeRequestController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ExportController;
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
        // Products
        Route::resource('products', ProductController::class)->names('products');
        Route::get('product/history/{product}', ProductHistoryController::class)->name('product.history');

        // Products requests for restock
        Route::get('warehouse/notificaions', [WarehouseRequestController::class, 'notificaions'])->name('warehouse.notificaions');

        // Actions
        Route::post('product/{product}/stock/adjustment', AdjustProductStockController::class)->name('stock.adjust');
        Route::post('approve/{stock_request}/request', ApproveStockRequestController::class)->name('approve.stock.request');
        Route::post('reject/{stock_request}/request', RejectStockRequestController::class)->name('reject.stock.request');
    });

    // HR Department
    Route::middleware(['role:' . UserRoles::ADMINISTRATOR->value . '|' . UserRoles::HR_MANAGER->value])->prefix('hr')->group(function () {
        // Employees
        Route::resource('employees', EmployeeController::class)->names('employees');
        Route::resource('attendances/logs', AttendanceLogController::class)->except(['destroy', 'create', 'edit', 'update'])->names('attendances.logs');
        Route::resource('attendances', AttendanceController::class)->names('attendances');

        Route::resource('department/leave-requests', DepartmentRequestController::class)->names('department.leave.requests');
        Route::put('leave-requests/{department_leave_request}/apporve', [DepartmentRequestController::class, 'approve'])->name('leave.request.approve');
        Route::put('leave-requests/{department_leave_request}/reject', [DepartmentRequestController::class, 'reject'])->name('leave.request.reject');

        // Events
        Route::resource('events', EventsController::class)->except('index')->names('events');
        Route::get('calendar/events', [EventsController::class, 'index'])->name('events.calendar');

        // Statistics
        Route::get('statistics', HrStatisticsController::class)->name('hr.statistics');

    });

    // Global Access to all permissions;

    Route::resource('employee/leave-requests', EmployeeRequestController::class)->except('destroy', 'edit', 'show', 'update')->names('employee.requests');
    Route::get('test/atten', [AttendanceController::class, 'test']);

    // Exporting different type of files for all departments 
    Route::get('export/{module}/{type}', ExportController::class)->name('export');

    // Folders / Files Mangers
    Route::resource('folders', FolderController::class)->names('folders');

    // Uploading Attachments
    Route::post('/attachments/upload', [UploadTemporatyAttachmentsController::class, 'uploadAttachments'])->name('upload');
    Route::post('/attachments/revert', [UploadTemporatyAttachmentsController::class, 'revertAttachments'])->name('revert');
    // Download Invoices.
    Route::get('/attachment/download/{media}', DownloadInvoicesController::class)->name('download');
    // ------
});



Route::get('test', function () {
    return Inertia::render('test');
});

Route::get('test2', function () {
    return Inertia::render('calendar');
});






Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/website.php';