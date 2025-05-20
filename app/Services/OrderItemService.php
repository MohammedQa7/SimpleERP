<?php

namespace App\Services;

use App\Actions\CalculateTotalPriceForProducts;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;


class OrderItemService
{

    protected $priceAction;
    function __construct(CalculateTotalPriceForProducts $action)
    {
        $this->priceAction = $action;
    }

    function createNewItems($order, $order_items)
    {
        $new_items = array_filter($order_items, function ($item) {
            return $item['orderItemId'] == null;
        });




        foreach ($new_items as $item) {
            $product = Product::where('sku', $item['product']['sku'])->firstOrFail();
            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'total_amount' => $product->selling_price * $item['quantity'],
            ]);
        }
    }

    function updateOrderItems($order, $order_items)
    {

        dd($order , $order_items);
        $existing_order_items = array_column($order->orderItems->toArray(), 'id');
        $order_items_to_update = array_filter($order_items, function ($item) use ($existing_order_items) {
            return in_array($item['orderItemId'], $existing_order_items);
        });


        if (sizeof($order_items_to_update) > 0 && !is_null($order_items_to_update)) {

            foreach ($order_items_to_update as $item) {
                $order_item = OrderItems::where('id', $item['orderItemId'])->firstOrFail();

                $order_item->update([
                    'product_id' => $item['productId'],
                    'quantity' => $item['quantity'],
                    'total_amount' => $this->priceAction->handle(collect($item)),
                ]);
            }
        }
    }

    function getRemovedItems($order, $order_items)
    {
        $new_order_list_id = array_column($order_items, 'orderItemId');

        $removed_items = array_filter($order->orderItems->toArray(), function ($item) use ($new_order_list_id) {
            return !in_array($item['id'], $new_order_list_id);
        });

        return array_column($removed_items, 'id');

    }


    function delete($order_items)
    {
        if (is_array($order_items)) {
            OrderItems::destroy($order_items);
        }
    }


}