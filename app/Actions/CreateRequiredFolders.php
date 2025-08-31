<?php
namespace App\Actions;

use App\Models\Folder;


class CreateRequiredFolders
{
    function handle($folder_type, $customer_code)
    {
        match ($folder_type) {
            'customers' => $this->createCustomerFolders($customer_code),

            'employees' => $this->createFolderForPaymentCheques($customer_code),
        };
    }


    function createFolderForPaymentCheques($customer_code)
    {

    }

    function createCustomerFolders($customer_code)
    {

        // mandetory sub folders
        $customer_sub_folders = ['invoices', 'proof of payment', 'receipt'];

        // Create 'customers' root folder
        $customers_folder = Folder::firstOrCreate(
            [
                'name' => 'customers',
                'parent_id' => null
            ],

            ['is_deletable' => 0]
        );

        //  Create customer code folder inside 'customers'
        $customer_code_folder = Folder::firstOrCreate(
            [
                'name' => $customer_code,
                'parent_id' => $customers_folder->id
            ],
            [
                'is_deletable' => 0,
            ]
        );

        foreach ($customer_sub_folders as $value) {
            Folder::firstOrCreate(
                [
                    'name' => $value,
                    'parent_id' => $customer_code_folder->id
                ],

                ['is_deletable' => 0]
            );
        }
    }
}