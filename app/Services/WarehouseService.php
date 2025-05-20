<?php

namespace App\Services;

use App\Enums\WarehouseStatus;
use App\Models\WarehouseRequests;

class WarehouseService
{
    protected $warehouse_requests;
    function __construct()
    {
        $this->warehouse_requests = WarehouseRequests::get();
    }


    function getPendingRequests()
    {
        return $this->warehouse_requests->where('status', WarehouseStatus::PENDING->value)->count();
    }


}