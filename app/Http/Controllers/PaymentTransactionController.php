<?php

namespace App\Http\Controllers;

use App\Actions\StoreAttachments;
use App\Enums\InvoiceStatus;
use App\Http\Requests\PaymentTransactionRequest;
use App\Http\Resources\PaymentTransactionResource;
use App\Models\Invoice;
use App\Models\PaymentTransaction;
use App\Services\InvoiceService;
use App\Traits\hasAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentTransactionController extends Controller
{
    use hasAttachments;

    function index()
    {
        $payment_transactions = PaymentTransaction::with('invoice.order.customer')->paginate(10);

        return Inertia::render('FinanceDepartment/PaymentTransactions', [
            'paymentTransactions' => PaymentTransactionResource::collection($payment_transactions),
        ]);
    }

    function create(InvoiceService $invoiceService)
    {
        return Inertia::render('FinanceDepartment/Invoices', [
            'invoices' => $invoiceService->getInvoices(),
        ]);
    }

    function store(PaymentTransactionRequest $request, StoreAttachments $storeAttachments)
    {
        try {
            DB::beginTransaction();
            $invoice = Invoice::where('invoice_number', $request->invoiceNumber)->firstOrFail();
            $payment_transaction = PaymentTransaction::create([
                'invoice_id' => $invoice->id,
                'payment_number' => 'TXN' . rand(0, 9999999),
                'method' => $request->paymentMethod,
                'notes' => $request->notes
            ]);

            $storeAttachments->handle($payment_transaction, $request->attachments);

            $invoice->update([
                'status' => InvoiceStatus::PAID->value,
                'ends_at' => null,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            throw $th;
        }
    }


    function show(PaymentTransaction $transaction)
    {
        $transaction->load('attachments', 'invoice.order.customer', 'invoice.order.orderItems.product');

        return response()->json([
            'transaction' => new PaymentTransactionResource($transaction),
        ]);
    }
}