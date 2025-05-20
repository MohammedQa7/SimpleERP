<?php

namespace App\Http\Controllers;

use App\Actions\NotifyDepartment;
use App\Enums\Departments;
use App\Enums\WarehouseStatus;
use App\Models\WarehouseRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RejectStockRequestController extends Controller
{
    use AuthorizesRequests;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, WarehouseRequests $stock_request, NotifyDepartment $notify_department_action)
    {
        $this->authorize('update', [WarehouseRequests::class, $stock_request]);
        try {
            DB::beginTransaction();

            $stock_request->update([
                'status' => WarehouseStatus::DECLINED->value,
            ]);

            $notify_department_action->handle(
                Departments::WAREHOUSE->value,
                $stock_request->department,
                'Your restock request has been rejected.'
            );
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}