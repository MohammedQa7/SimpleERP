<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    function index()
    {
        $approvedOrders = Order::with('customer')
            ->onlyApprovedOrders()
            ->paginate(3, ['*'], 'order_page');
        return Inertia::render('FinanceDepartment/Invoices', [
            'approvedOrders' => OrderResource::collection($approvedOrders),
        ]);
    }
}