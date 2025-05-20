<?php
namespace App\Actions;

class AddProductStock
{
    function handle($product, $request)
    {
        $product->update([
            'stock' => $product->stock + $request->quantity,
        ]);
    }
}