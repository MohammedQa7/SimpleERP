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
    function handle(Model $model, array|string $file_path, MediaCollection $media_collection, bool $preserve_original = false)
    {
        !is_array($file_path)
            ? $path = Storage::disk('public')->path($file_path)
            : '';

        if (is_array($file_path)) {
            foreach ($file_path as $path) {
                $full_file_path = Storage::disk('public')->path($path);

                file_exists($full_file_path)
                    ? $this->spatieAddMedia($model, $full_file_path, $preserve_original, $media_collection)
                    : throw new \Exception("Folder/File Doesn't Exist, Please Contact The Support", 300);

            }
        } else {

            file_exists($path)
                ? $this->spatieAddMedia($model, $path, $preserve_original, $media_collection)
                : throw new \Exception("Folder/File Doesn't Exist, Please Contact The Support", 300);
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
}