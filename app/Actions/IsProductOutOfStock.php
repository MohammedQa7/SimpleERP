<?php
namespace App\Actions;

use App\Models\Product;

class IsProductOutOfStock
{
    protected $is_any_product_out_of_stock = false;
    protected $stock_map = [];
    function handle($order_items)
    {
        return $this->checkProductStockArray($order_items);
    }


    function checkProductStockArray($order_items)
    {

        foreach ($order_items as $item) {
            if ($item['product']['sku']) {
                $product = Product::where('sku', $item['product']['sku'])->firstOrFail();
                $this->stock_map[$item['product']['sku']] = ($this->stock_map[$item['product']['sku']] ?? 0) + $item['quantity'];

                // // If any product is out of stock, update the flag
                if ($this->stock_map[$item['product']['sku']] > $product->stock) {
                    $this->is_any_product_out_of_stock = true;
                }
            }
        }

        return $this->is_any_product_out_of_stock;
    }
}