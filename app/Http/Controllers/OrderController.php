<?php

namespace App\Http\Controllers;

use App\Actions\CalculateTotalPriceForProducts;
use App\Actions\CreateOrderItems;
use App\Actions\IsProductOutOfStock;
use App\Enums\OrderStatus;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\CustomerService;
use App\Services\OrderItemService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected $orderService;
    protected $customerService;
    protected $productService;
    function __construct(OrderService $orderService, CustomerService $customerService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->productService = $productService;
    }


    function index()
    {
        $orders = Order::with('customer')->paginate(3);
        $order_status = OrderStatus::toArray();

        return Inertia::render('SalesDepartment/index', [
            'orders' => OrderResource::collection($orders),
            'orderStatus' => $order_status
        ]);
    }


    function create()
    {
        return Inertia::render('SalesDepartment/index', [
            'customers' => $this->customerService->getCustomers(),
            'products' => $this->productService->getProducts(),
        ]);
    }

    function store(OrderRequest $request, CreateOrderItems $orderAction, CalculateTotalPriceForProducts $priceAction, IsProductOutOfStock $checkStockAction)
    {
        $data = fluent($request->validated());

        $is_any_product_out_of_stock = $checkStockAction->handle($data->orderItems);

        try {
            DB::beginTransaction();
            // Creating Order 
            $order = Order::create([
                'customer_id' => $data->customerId,
                'order_number' => 'ORD-' . rand(0, 100000),
                'total_price' => $priceAction->handle($data->orderItems),
                'notes' => $data->notes,
                'status' => $is_any_product_out_of_stock
                ? OrderStatus::WAITING_FOR_RESTOCK->value
                : OrderStatus::APPROVED->value,
                'approved_at' => !$is_any_product_out_of_stock
                ? now()
                : null
            ]);

            // Creating Order items
            $orderAction->handle($order->id, $request->orderItems);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function show(Order $order)
    {
        sleep(1);
        $order->load('customer', 'orderItems.product');
        return response()->json([
            'order' => new OrderResource($order),
        ]);
    }

    function edit(Order $order)
    {
        sleep(2);
        $order->load('customer', 'orderItems.product');

        return Inertia::render('SalesDepartment/index', [
            'order' => new OrderResource($order),
            'customers' => $this->customerService->getCustomers(),
            'products' => $this->productService->getProducts(),
        ]);
    }

    function update(OrderRequest $request, Order $order, OrderItemService $orderItemService, CalculateTotalPriceForProducts $priceAction, IsProductOutOfStock $checkStockAction)
    {
        $order->load('orderItems');
        $data = fluent($request->validated());

        $is_any_product_out_of_stock = $checkStockAction->handle($data->orderItems);
        try {
            DB::beginTransaction();
            // // Update the order 
            $order->update([
                'customer_id' => $data->customerId,
                'total_price' => $priceAction->handle($request->orderItems),
                'notes' => $data->notes,
                'status' => $is_any_product_out_of_stock
                ? OrderStatus::WAITING_FOR_RESTOCK->value
                : OrderStatus::APPROVED->value,
                'approved_at' => !$is_any_product_out_of_stock
                ? now()
                : null
            ]);

            // Get new items and create them
            $orderItemService->createNewItems($order, $data->orderItems);

            // Update existing order items
            $orderItemService->updateOrderItems($order, $data->orderItems);

            // Get the deleted items and delete them
            $removed_item_list = $orderItemService->getRemovedItems($order, $data->orderItems);
            $orderItemService->delete($removed_item_list);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}