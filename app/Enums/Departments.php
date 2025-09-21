<?php

namespace App\Enums;

enum Departments: string
{
    case SALES = 'Sales Department';
    case FINANCE = 'Finance Department';
    case WAREHOUSE = 'Warehouse Department';
    case CRM = 'CRM Department';
    case HR = 'HR Department';
    case IT = 'IT Department';

    static function toArray()
    {
        return collect(Departments::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}