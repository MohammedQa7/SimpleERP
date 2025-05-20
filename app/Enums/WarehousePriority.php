<?php

namespace App\Enums;

enum WarehousePriority: string
{
    case HIGH = 'High';
    case MEDIUM = 'Medium';
    case NORMAL = 'Normal';
    case LOW = 'Low';

    static function toArray()
    {
        return collect(WarehousePriority::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}