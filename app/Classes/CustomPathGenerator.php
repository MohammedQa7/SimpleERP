<?php

namespace App\Classes;

use App\Enums\FileAndFolderGlobalPaths;
use App\Enums\MediaCollection;
use App\Helpers\FilePathHelper;
use App\Models\Invoice;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{

    public function getPath(Media $media): string
    {
        $model = $media->model;
        $collection = $media->collection_name;

        $username = 'guest';
        switch ($collection) {

            case MediaCollection::INVOICES->value:
                $model->load('order.customer');


                $username = $model->order->customer->full_name;
                $customer_code = $model->order->customer->customer_code;

                return FilePathHelper::buildCustomerUploadPath(FileAndFolderGlobalPaths::CUSTOMERS_INVOICES_PATH, [], $customer_code);


            case MediaCollection::PAYMENT_TRANSACTIONS_ATTACHMENTS->value:

                $model->load([
                    'modelable' =>
                    function ($morphTo) {
                        $morphTo->morphWith([
                            Invoice::class => ['order.customer'],
                        ]);
                    }
                ]);

                $username = $model->modelable->order->customer->full_name;
                $customer_code = $model->modelable->order->customer->customer_code;

                return FilePathHelper::buildCustomerUploadPath(FileAndFolderGlobalPaths::CUSTOMERS_PROOF_OF_PAYMENT_PATH, [], $customer_code);

            case MediaCollection::RECEIPT_PAYMENT->value:

                $model->load([
                    'modelable' =>
                    function ($morphTo) {
                        $morphTo->morphWith([
                            Invoice::class => ['order.customer'],
                        ]);
                    }
                ]);

                $username = $model->modelable->order->customer->full_name;
                $customer_code = $model->modelable->order->customer->customer_code;

                return FilePathHelper::buildCustomerUploadPath(FileAndFolderGlobalPaths::CUSTOMERS_RECEIPT_PATH, [], $customer_code);

            default:
                dd('e13123213ts');
                return "uploads/";
        }
    }


    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}