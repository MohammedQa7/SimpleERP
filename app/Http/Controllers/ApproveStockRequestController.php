<?php

namespace App\Http\Controllers;

use App\Actions\IncreaseProductStock;
use App\Actions\NotifyDepartment;
use App\Enums\Departments;
use App\Enums\WarehouseStatus;
use App\Models\WarehouseRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApproveStockRequestController extends Controller
{
    use AuthorizesRequests;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, WarehouseRequests $stock_request, IncreaseProductStock $increase_stock_action, NotifyDepartment $notify_department_action)
    {

        $this->authorize('update', [WarehouseRequests::class, $stock_request]);
        try {
            DB::beginTransaction();
            $stock_request->update([
                'status' => WarehouseStatus::APPROVED->value,
            ]);

            // Reflect the requested amount to the actual product.
            $increase_stock_action->handle($stock_request->product_id, $stock_request->requested_quantity);

            // notify the other department that thier request has been approved
            $notify_department_action->handle(Departments::WAREHOUSE->value, $stock_request->department, 'Your request has been approved, and the product has been restocked with the requested amount.');

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}