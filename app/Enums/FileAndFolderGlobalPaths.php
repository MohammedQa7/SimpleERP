<?php

namespace App\Enums;

enum FileAndFolderGlobalPaths: string
{
    // For public access
    case INVOICE_FOLDER_PATH = "invoices/  ";
    case PAYMENT_TRANSACTIONS_FOLDER_PATH = "payment/attachments/";

    case CUSTOMERS_INVOICES_PATH = "invoices/";
    case CUSTOMERS_PROOF_OF_PAYMENT_PATH = "proof of payment/";
    case CUSTOMERS_RECEIPT_PATH = "receipt/";

    // For private access such as the FileManager.
    case INVOICE_FILE_MANAGER_PATH = "drive/invoices/";
    case PAYMENT_TRANSACTIONS_FILE_MANAGER_PATH = "drive/payment/attachments/";

    case GLOBAL = "";


    
}