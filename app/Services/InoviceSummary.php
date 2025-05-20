<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;

class InoviceSummary
{

    protected $invoice;

    function __construct()
    {
        $this->invoice = Invoice::query()->get();
    }

    public function getPaidInvoices()
    {
        $paid_invoices_last_month = $this->invoice->where('status', InvoiceStatus::PAID->value)
            ->where(function ($query) {
                return $query->updated_at->isSameMonth(now()->subMonth());
            })->count();

        $paid_invoices_current_month = $this->invoice->where('status', InvoiceStatus::PAID->value)
            ->where(function ($query) {
                return $query->updated_at->isSameMonth(now());
            })->count();


        return [
            'title' => 'Paid Invoices',
            'value' => $this->invoice->where('status', InvoiceStatus::PAID->value)->count(),
            'icon' => 'CheckCircle',
            'color' => 'emerald',
            'percentage' => $paid_invoices_last_month > 0
            ? round((($paid_invoices_current_month - $paid_invoices_last_month) / $paid_invoices_last_month) * 100, 2)
            : 0
        ];


    }

    public function getPendingInvocies()
    {

        $pending_invoices_last_month = $this->invoice->where('status', InvoiceStatus::PENDING->value)
            ->where(function ($query) {
                return $query->created_at->isSameMonth(now()->subMonth());
            })->count();

        $pending_invoices_current_month = $this->invoice->where('status', InvoiceStatus::PENDING->value)
            ->where(function ($query) {
                return $query->created_at->isSameMonth(now());
            })->count();
        return [
            'title' => 'Pending Invoices',
            'value' => $this->invoice->where('status', InvoiceStatus::PENDING->value)->count(),
            'icon' => 'AlertCircle',
            'color' => 'rose',
            'percentage' => $pending_invoices_last_month > 0
            ? round((($pending_invoices_current_month - $pending_invoices_last_month) / $pending_invoices_last_month) * 100, 2)
            : 0
        ];
    }

}