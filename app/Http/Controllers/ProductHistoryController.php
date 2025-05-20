<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Resources\AuditResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductHistoryController extends Controller
{
    function __invoke(Product $product, Request $request)
    {

        $product_history = $product->audits()->with('user')

            ->when($request->query('user'), function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    return $query->where('name', $request->query('user'));
                });
            })

            ->when(isset($request['date']), function ($query) use ($request) {
                return match ($request['date']) {
                    'today' => $query->where('created_at', now()),
                    'this_week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'this_month' => $query->whereMonth('created_at', now()->month),
                    'last_three_months' => $query->where('created_at', '>', now()->subMonths(3)),
                    'last_year' => $query->whereYear('created_at', now()->year),
                    default => $query,
                };
            })

            ->when(isset($request['type']), function ($query) use ($request) {
                return match ($request['type']) {
                    'name' => $query->whereRaw("JSON_CONTAINS_PATH(old_values, 'one', '$.name')"),
                    'price' => $query->whereRaw("JSON_CONTAINS_PATH(old_values, 'one', '$.price')"),
                    'category' => $query->whereRaw("JSON_CONTAINS_PATH(old_values, 'one', '$.category_id')"),
                    'stock' => $query->whereRaw("JSON_CONTAINS_PATH(old_values, 'one', '$.stock')"),
                    default => $query,
                };
            })->get();

            
        $warehouse_users = User::role([UserRoles::INVENTORY_MANAGER->value, UserRoles::ADMINISTRATOR->value])->get();

        return Inertia::render('WarehouseManagement/ProductHistory', [
            'product' => new ProductResource($product),
            'productHistory' => AuditResource::collection($product_history),
            'users' => UserResource::collection($warehouse_users),
            'filters' => [...$request->query()],
        ]);
    }
}