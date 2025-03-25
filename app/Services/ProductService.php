<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;


class ProductService
{
    function getProducts()
    {
        $products = Product::get();
        return ProductResource::collection($products);
    }
}