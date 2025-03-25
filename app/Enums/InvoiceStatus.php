<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    // Finance Dep
    case SENT = 'Sent';
    case PAID = 'Paid';
    case PENDING = 'Pending';
    case REFUNDED = 'Refunded';

}