<?php

namespace App\Listeners;

use App\Enums\Departments;
use App\Enums\WarehouseStatus;
use App\Events\ProductOutOfStock;
use App\Models\DepartmentNotificaion;
use App\Models\Product;
use App\Models\WarehouseRequests;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class CreateWarehouseDepartmentRequest
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductOutOfStock $event): void
    {
        foreach ($event->stockItems as $item_sku => $value) {
            $product = Product::where('sku', $item_sku)->firstOrFail();
            $isTherePreviousRequest = WarehouseRequests::isTherePrevoiusRequest($event->order, $product)->exists();
            if (!$isTherePreviousRequest) {
                WarehouseRequests::create([
                    'user_id' => auth()->id(),
                    'order_id' => $event->order->id,
                    'product_id' => $product->id,
                    'department' => $event->department,
                    'status' => WarehouseStatus::PENDING->value,
                    'priority' => $event->priority,
                    'requested_quantity' => $value['stock'],
                    'notes' => $event->note ?? null,
                ]);
            }
        }
    }
}