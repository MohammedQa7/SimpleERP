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

    protected function checkProductStockArray($order_items)
    {

        foreach ($order_items as $item) {
            if ($item['product']['sku']) {
                $product = Product::where('sku', $item['product']['sku'])->firstOrFail();
                $this->stock_map[$item['product']['sku']]['stock'] = ($this->stock_map[$item['product']['sku']]['stock'] ?? 0) + $item['quantity'];


                // // If any product is out of stock, update the flag
                if ($this->stock_map[$item['product']['sku']]['stock'] > $product->stock) {
                    $this->is_any_product_out_of_stock = true;
                    $this->stock_map[$item['product']['sku']]['in_stock'] = $this->is_any_product_out_of_stock;
                } else {
                    $this->stock_map[$item['product']['sku']]['in_stock'] = false;
                }
            }
        }

        return $this;
    }


    public function getIsAnyProductOutOfStock()
    {
        return $this->is_any_product_out_of_stock;
    }

    public function getStockItems()
    {
        return $this->stock_map;
    }
}