<?php

namespace App\Enums;

enum MediaCollection: string
{
    case INVOICES = 'invoices';
    case PAYMENT_TRANSACTIONS_ATTACHMENTS = 'payment_transactions_attachments';


    static function toArray()
    {
        return collect(MediaCollection::cases())->map(function ($value, $key) {
            return [
                'label' => $value->value,
                'value' => $value->value,
            ];
        });
    }

}