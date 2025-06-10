<?php

namespace App\Services;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;


class CustomerService
{
    function getCustomers()
    {
        $customers = Customer::select('id', 'full_name', 'customer_code', 'phone_number')->get();
        return CustomerResource::collection($customers);
    }
}