<?php

namespace App\Enums;

enum PaymentMethods: string
{
    case CREDIT_CARD = 'Credit Card';
    case PAYPAL = 'PayPal';
    case BANK_TRANSFER = 'Bank Transfer';
    case CHECK = 'Check';



    static function toArray()
    {
        return collect(PaymentMethods::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}