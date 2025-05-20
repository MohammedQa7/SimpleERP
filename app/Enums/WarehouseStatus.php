<?php

namespace App\Enums;

enum WarehouseStatus: string
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case DECLINED = 'Declined';

    static function toArray()
    {
        return collect(WarehouseStatus::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}