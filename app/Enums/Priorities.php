<?php

namespace App\Enums;

enum Priorities: string
{
    case HIGH = 'High';
    case MEDIUM = 'Medium';
    case NORMAL = 'Normal';
    case LOW = 'Low';

    static function toArray()
    {
        return collect(Priorities::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

    static function toArrayWithKeys()
    {
        return collect(Priorities::cases())->map(function ($value) {
            return [
                'label' => str_replace('_', ' ', $value->value),
                'value' => $value->value,
            ];
        });
    }

}