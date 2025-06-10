<?php

namespace App\Classes;

use App\Actions\AttachMediaToAnyModel;
use App\Enums\FileAndFolderGlobalPaths;
use App\Enums\MediaCollection;
use App\Helpers\FilePathHelper;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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

                $model->load('invoice.order.customer');
                $username = $model->invoice->order->customer->full_name;
                $customer_code = $model->invoice->order->customer->customer_code;

                return FilePathHelper::build(FileAndFolderGlobalPaths::INVOICE_FOLDER_PATH, [$username, $customer_code]);


            case MediaCollection::PAYMENT_TRANSACTIONS_ATTACHMENTS->value:

                $model->load('invoice.order.customer');
                $username = $model->invoice->order->customer->full_name;
                $customer_code = $model->invoice->order->customer->customer_code;

                return FilePathHelper::build(FileAndFolderGlobalPaths::PAYMENT_TRANSACTIONS_FOLDER_PATH, [$username, $customer_code]);

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