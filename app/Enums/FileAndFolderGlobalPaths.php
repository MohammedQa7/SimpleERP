<?php

namespace App\Enums;

enum FileAndFolderGlobalPaths: string
{
    // For public access
    case INVOICE_FOLDER_PATH = "invoices/  ";
    case PAYMENT_TRANSACTIONS_FOLDER_PATH = "payment/attachments/";

    // For private access such as the FileManager.
    case INVOICE_FILE_MANAGER_PATH = "drive/invoices/";
    case PAYMENT_TRANSACTIONS_FILE_MANAGER_PATH = "drive/payment/attachments/";

    case GLOBAL = "";
}