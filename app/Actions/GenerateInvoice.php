<?php
namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class GenerateInvoice
{
    function handle($invoice_number, $invoice)
    {

        $pdf = \PDF::loadView('Invoices.invoice', ['invoice' => $invoice]);
        $file_path = 'invoices/' . $invoice_number . '.pdf';
        Storage::disk('public')->put($file_path, $pdf->output());


        $invoice->update([
            'file_path' => $file_path,
        ]);
    }
}