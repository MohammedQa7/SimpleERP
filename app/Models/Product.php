<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Models\Audit;

class Product extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at'];

    function getRouteKeyName()
    {
        return 'sku';
    }

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
    function productStockLogs()
    {
        return $this->hasMany(ProductStockLogs::class);
    }

    function scopegetAuditsRecords($query, array $filters = null)
    {
    }

    function scopeFilter($query, $request)
    {
        if (sizeof($request) > 0) {
            return $query->when(isset($request['search']), function ($query) use ($request) {
                $query->whereAny(['name', 'sku'], 'LIKE', "%{$request['search']}%");
            })

                ->when(isset($request['category']), function ($query) use ($request) {

                    $query->withWhereHas('category', function ($query) use ($request) {
                        $query->where('slug', $request['category']);
                    });
                })
                ->when(isset($request['stockStatus']), function ($query) use ($request) {
                    return match ($request['stockStatus']) {
                        'in-stock' => $query->where('stock', '>', 0),
                        'low-stock' => $query->where('stock', '<', 6),
                        'out-of-stock' => $query->where('stock', '==', 0),
                        'all' => $query,
                        default => $query,
                    };
                })
                ->when(isset($request['sortBy']), function ($query) use ($request) {
                    return match ($request['sortBy']) {
                        'name-asc' => $query->orderBy('name', 'ASC'),
                        'name-desc' => $query->orderBy('name', 'DESC'),
                        'stock-asc' => $query->orderBy('stock', 'ASC'),
                        'stock-desc' => $query->orderBy('stock', 'DESC'),
                        'price-asc' => $query->orderBy('selling_price', 'ASC'),
                        'price-desc' => $query->orderBy('selling_price', 'DESC'),
                        default => $query,
                    };
                });
        }
        return;
    }
}