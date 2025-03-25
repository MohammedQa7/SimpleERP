<?php
namespace App\Actions;

use App\Models\OrderItems;
use App\Models\Product;

class CreateOrderItems
{
    function handle($order_id, $order_items)
    {
        foreach ($order_items as $item) {
            $product = Product::where('sku', $item['product']['sku'])->firstOrFail();
            OrderItems::create([
                'product_id' => $product->id,
                'order_id' => $order_id,
                'quantity' => $item['quantity'],
                'total_amount' => $product->selling_price * $item['quantity'],
            ]);
        }
    }
}