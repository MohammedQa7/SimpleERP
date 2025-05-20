<?php
namespace App\Actions;

use Illuminate\Validation\ValidationException;

class RemoveProductStock
{
    function handle($product, $request)
    {
        if ($request->quantity < $product->stock) {
            $product->update([
                'stock' => $product->stock - $request->quantity,
            ]);
        }

        throw ValidationException::withMessages([
            'quantity' => 'The minimum amount is ' . $product->stock . ' for the removal',
        ]);
    }
}