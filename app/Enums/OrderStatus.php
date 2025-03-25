<?php

namespace App\Enums;

enum OrderStatus: string
{
    // Sales Dep
    case APPROVED = 'Approved';
    case WAITING_FOR_RESTOCK = 'Waiting_for_restock';

    // Finance Dep
    case INVOICED = 'Invoiced';

    // Warehouse Dep / Inventory Dep
    case SHIPPED = 'Shipped';
    case RETURNED = 'Returned';
    // ---
    case CANCELED = 'Canceled';


    static function toArray()
    {
        return collect(OrderStatus::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}