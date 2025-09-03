<?php
namespace App\Actions;

use App\Enums\MediaCollection;
use App\Models\Event;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AttachMediaToAnyModel
{


    function handle(Model $model, array|string $file_path, MediaCollection $media_collection, bool $preserve_original = false, string $file_name = null)
    {
        // All the normal files (uploaded files) should be in an array (images+files etc...).
        if (is_array($file_path)) {
            foreach ($file_path as $path) {
                $full_file_path = Storage::disk('public')->path($path);
                file_exists($full_file_path)
                    ? $this->spatieAddMedia($model, $full_file_path, $preserve_original, $media_collection)
                    : throw new \Exception("Folder/File Doesn't Exist, Please Contact The Support", 300);

            }
        } else {
            // Any generated file that returns its content as raw data .
            $this->spatieAddPDFMedia($model, $file_path, $preserve_original, $media_collection, $file_name);
        }

    }


    function spatieAddMedia($model, $path, $preserve_original, $media_collection)
    {
        $mediaAdder = $model->addMedia($path);
        $preserve_original
            ? $mediaAdder->preservingOriginal()
            : '';

        $mediaAdder->toMediaCollection($media_collection->value);
    }

    function spatieAddPDFMedia($model, $file, $preserve_original, $media_collection, $file_name = null)
    {

        $mediaAdder = $model->addMediaFromString($file);
        $mediaAdder->usingName($file_name . ' ' . $media_collection->value . ' ' . now()->format('d-m-Y'));
        $mediaAdder->usingFileName($file_name . '.pdf');

        $preserve_original
            ? $mediaAdder->preservingOriginal()
            : '';

        $mediaAdder->toMediaCollection($media_collection->value);
    }
}