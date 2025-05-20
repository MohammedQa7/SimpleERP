<?php

namespace App\Http\Controllers;

use App\Http\Resources\WarehouseStockRequestResource;
use App\Models\WarehouseRequests;

class WarehouseRequestController extends Controller
{
    function notificaions()
    {
        $notificaion_requests = WarehouseRequests::with('user', 'order', 'product')->get();
        return response()->json([
            'notificaion_requests' => WarehouseStockRequestResource::collection($notificaion_requests),
        ]);
    }
}