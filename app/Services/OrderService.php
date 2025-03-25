<?php

namespace App\Services;

use App\Models\Order;


class OrderService
{
    function getSpecificOrders()
    {
        $orders = Order::get();
        return $orders;
    }

}