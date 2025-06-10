<?php

namespace App\Http\Controllers;

use App\Actions\AttachMediaToAnyModel;
use App\Actions\CreateRequiredFolders;
use App\Actions\StoreAttachments;
use App\Enums\FileAndFolderGlobalPaths;
use App\Enums\InvoiceStatus;
use App\Enums\MediaCollection;
use App\Helpers\FilePathHelper;
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

    function store(Request $request, AttachMediaToAnyModel $attach_media_to_model, CreateRequiredFolders $create_required_folders)
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

            // Get files from temp directory and store them into the new one then attach it to the model
            $attach_media_to_model->handle($payment_transaction, $request->attachments, MediaCollection::PAYMENT_TRANSACTIONS_ATTACHMENTS, false);

            // store the same files in the file manager in order to keep track of all files and manage all files.
            $create_required_folders->handle();

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