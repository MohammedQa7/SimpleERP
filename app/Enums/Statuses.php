<?php

namespace App\Enums;

enum Statuses: string
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case DECLINED = 'Declined';
    case REJECTED = 'Rejected';

    static function toArray()
    {
        return collect(Statuses::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}