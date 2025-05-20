<?php

namespace App\Http\Controllers;

use App\Actions\GenerateInvoice;
use App\Actions\UpdateOrderStatus;
use App\Enums\InvoiceStatus;
use App\Enums\OrderStatus;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\OrderResource;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InvoiceController extends Controller
{
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

    function store(Request $request, GenerateInvoice $generateInvoice, UpdateOrderStatus $updateOrderStatus)
    {
        sleep(2);
        $request->validate([
            'orderNumber' => ['required', 'exists:orders,order_number'],
        ]);

        $order = Order::where('order_number', $request->orderNumber)->FirstOrFail();
        try {
            DB::beginTransaction();
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . rand(0, 1000000),
                'order_id' => $order->id,
                'status' => InvoiceStatus::PENDING->value,
                'ends_at' => now()->addHours(48),
            ]);

            if ($invoice) {
                $invoice->load('order.customer', 'order.orderItems.product');

                // Update Order Status
                $updateOrderStatus->handle($order, OrderStatus::INVOICED->value);
                // Generate invoice PDF
                $generateInvoice->handle($request->orderNumber, $invoice);

            }
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