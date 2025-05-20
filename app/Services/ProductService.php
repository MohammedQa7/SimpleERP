<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Carbon;


class ProductService
{
    protected $products;
    function __construct()
    {
        $this->products = Product::get();
    }

    function getProducts()
    {
        return ProductResource::collection($this->products);
    }

    function getTotalProducts()
    {
        return [
            'count' => $this->products->count(),
            'currentMonthCount' => $this->products->where(function ($query) {
                $query->created_at->isSameMonth(now());
            })->count(),
        ];
    }

    function getLowStockProductsCount()
    {
        $low_stock_percentage = ($this->products->where('stock', '<', '5')->count() / $this->products->count()) * 100;
        return [
            'count' => $this->products->where('stock', '<', '5')->count(),
            'percentage' => round($low_stock_percentage, 2),
        ];
    }

    function getOutOfStockProductsCount()
    {
        $low_stock_percentage = ($this->products->where('stock', '0')->count() / $this->products->count()) * 100;
        return [
            'count' => $this->products->where('stock', '0')->count(),
            'percentage' => round($low_stock_percentage, 2),
        ];
    }

    function getTotalInventoryValue()
    {
        return $this->products->sum('cost_price');
    }
}