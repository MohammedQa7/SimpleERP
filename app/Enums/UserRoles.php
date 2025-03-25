<?php

namespace App\Enums;

enum UserRoles: string
{
    case ADMINISTRATOR = 'Administrator';
    case SALES_MANAGER = 'Sales Manager';
    case FINANCE_MANAGER = 'Finance Manager';
    case HR_MANAGER = 'HR Manager';
    case INVENTORY_MANAGER = 'Inventory Manager';
    case CRM_MANAGER = 'CRM Manager';


    static function toArray()
    {
        return collect(UserRoles::cases())->map(function ($value, $key) {
            return [
                'label' => $value->value,
                'value' => $value->value,
            ];
        });
    }

}