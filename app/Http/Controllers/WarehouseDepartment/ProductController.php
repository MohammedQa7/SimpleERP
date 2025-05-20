<?php

namespace App\Http\Controllers\WarehouseDepartment;

use App\Enums\Departments;
use App\Enums\WarehouseStatus;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WarehouseResource;
use App\Models\Category;
use App\Models\DepartmentNotificaion;
use App\Models\Product;
use App\Models\WarehouseRequests;
use App\Services\ProductService;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class ProductController extends Controller
{
    function index(Request $request, ProductService $productService, WarehouseService $warehouseService)
    {
        $products = Product::with('category')
            ->Filter([...$request->query])
            ->orderBy('created_at', 'DESC')
            ->paginate(7)
            ->withQueryString();

        $categories = Category::get();

        return Inertia::render('WarehouseManagement/index', [
            'products' => ProductResource::collection($products),
            'productSummary' => [
                'totalProducts' => $productService->getTotalProducts(),
                'lowStockItems' => $productService->getLowStockProductsCount(),
                'outOfStockItems' => $productService->getOutOfStockProductsCount(),
                'InventoryValue' => $productService->getTotalInventoryValue(),
            ],
            'categories' => CategoryResource::collection($categories),
            'pendingRequests' => $warehouseService->getPendingRequests(),
            'filters' => [...$request->query]
        ]);
    }

    function store(ProductRequest $request)
    {
        $data = fluent($request->validated());
        Product::create([
            'name' => $data->name,
            'category_id' => $data->category,
            'sku' => $this->generateSKU($data->name),
            'cost_price' => $data->costPrice,
            'selling_price' => $data->sellingPrice,
            'stock' => $data->stock,
            'description' => $data->description ?? null,
        ]);

    }

    function edit(Product $product)
    {
        $product->load('category');
        return Inertia::render('WarehouseManagement/index', [
            'product' => new ProductResource($product),
        ]);
    }

    function update(Product $product, UpdateProductRequest $request)
    {
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category,
            'cost_price' => $request->costPrice,
            'selling_price' => $request->sellingPrice,
            'description' => $request->description,
        ]);
    }

    function generateSKU($name)
    {
        return strtoupper(substr($name, 0, 3)) . '-' . rand(1, 999999);
    }
}