<?php
namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class UpdateOrderStatus
{
    function handle($order, $status)
    {
        $order->update([
            'status' => $status
        ]);
    }
}