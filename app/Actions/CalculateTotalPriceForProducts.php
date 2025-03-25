<?php
namespace App\Actions;

use App\Models\OrderItems;
use App\Models\Product;

class CalculateTotalPriceForProducts
{
    function handle($order_items)
    {
        $totalPrice = 0;
        if (is_array($order_items)) {
            foreach ($order_items as $item) {
                $product = Product::where('sku', $item['product']['sku'])->firstOrFail();
                $totalPrice += $product->selling_price * $item['quantity'];
                
            }
            
        } else {
            $product = Product::where('sku', $order_items['product']['sku'])->firstOrFail();
            $totalPrice += $product->selling_price * $order_items['quantity'];
        }

        return $totalPrice;
    }
}