<?php
namespace App\Actions;

use App\Models\DepartmentNotificaion;
use App\Models\Product;

class IncreaseProductStock
{
    public function handle($product, $requested_quantity)
    {
        $product = Product::findOrFail($product);
        $product->update([
            'stock' => $product->stock + $requested_quantity
        ]);
    }
}