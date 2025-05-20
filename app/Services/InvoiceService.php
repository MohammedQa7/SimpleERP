<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Customer;
use App\Models\Invoice;


class InvoiceService
{
    function getInvoices()
    {

        $invoice = Invoice::select('id', 'invoice_number')
            ->where('status', '!=', InvoiceStatus::PAID->value)
            ->get();
        return InvoiceResource::collection($invoice);
    }
}