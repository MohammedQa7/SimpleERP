<?php

namespace App\Http\Controllers;

use App\Actions\AttachMediaToAnyModel;
use App\Actions\AttachMediaToFolder;
use App\Actions\CreateRequiredFolders;
use App\Actions\GenerateInvoice;
use App\Actions\UpdateOrderStatus;
use App\Enums\InvoiceStatus;
use App\Enums\MediaCollection;
use App\Enums\OrderStatus;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\OrderResource;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    use AuthorizesRequests;
    function index()
    {
        $apporved_orders = Order::with('customer')
            ->onlyApprovedOrders()
            ->paginate(2, ['*'], 'order_page')->withQueryString();


        $recent_invoices = Invoice::with('order.customer')
            ->recentInvoices()
            ->paginate(2, ['*'], 'invoice_page')->withQueryString();

        return Inertia::render('FinanceDepartment/Invoices', [
            'approvedOrders' => OrderResource::collection($apporved_orders),
            'recentInvoices' => InvoiceResource::collection($recent_invoices),
        ]);
    }

    function store(Request $request, UpdateOrderStatus $update_order_status, AttachMediaToAnyModel $attach_media_to_model, CreateRequiredFolders $create_required_folders, AttachMediaToFolder $attach_media_to_folder)
    {
        $request->validate([
            'orderNumber' => ['required', 'exists:orders,order_number'],
        ]);
        $order = Order::where('order_number', $request->orderNumber)->FirstOrFail();

        // Authorizing
        $this->authorize('create', $order);

        try {
            DB::beginTransaction();
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . rand(0, 1000000),
                'order_id' => $order->id,
                'status' => InvoiceStatus::PENDING->value,
                'ends_at' => now()->addHours(48),
            ]);


            $invoice->load('order.customer', 'order.orderItems.product');

            // Generate invoice PDF
            $pdf = \PDF::loadView('Invoices.invoice', ['invoice' => $invoice]);
            $attach_media_to_model->handle($invoice, $pdf->output(), MediaCollection::INVOICES, false, $invoice->invoice_number);

            // Update Order Status
            $update_order_status->handle($order, OrderStatus::INVOICED->value);

            // Create required folders for the file system
            $create_required_folders->handle('customers', $invoice->order->customer->customer_code);

            // Attach the generated invoice into the customer invoice folder.
            $attach_media_to_folder->handle($invoice->getMedia(MediaCollection::INVOICES->value), $invoice->order->customer->customer_code, MediaCollection::INVOICES->value);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function show(Invoice $invoice)
    {
        $invoice->load('order.customer', 'order.orderItems.product');
        return response()->json([
            'invoice' => new InvoiceResource($invoice),
        ]);
    }
}