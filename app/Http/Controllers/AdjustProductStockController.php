<?php

namespace App\Http\Controllers;

use App\Actions\AddProductStock;
use App\Actions\RemoveProductStock;
use App\Http\Requests\StockAdjustmentRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustProductStockController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product, StockAdjustmentRequest $request, AddProductStock $addProductStock, RemoveProductStock $removeProductStock)
    {

        try {
            DB::beginTransaction();
            match ($request->type) {
                'add' => $addProductStock->handle($product, $request),
                'remove' => $removeProductStock->handle($product, $request),
            };

            $product->productStockLogs()->create([
                'type' => $request->type,
                'quantity' => $request->quantity,
                'reason' => $request->reason,
                'notes' => $request->notes,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


    }
}