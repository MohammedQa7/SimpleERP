<?php
namespace App\Actions;

use App\Enums\MediaCollection;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Model;

class AttachMediaToFolder
{
    function handle($media_files, string $folder_name_key, $media_collection)
    {
        $user_identifier_folder = Folder::where('name', $folder_name_key)->firstOrFail();
        match ($media_collection) {
            MediaCollection::INVOICES->value => $this->attachToInvoiceFolder($media_files, $user_identifier_folder->id),
        };

    }

    function attachToInvoiceFolder($media_files, $parent_folder_id)
    {
        $invoice_folder = Folder::where('name', 'invoices')
            ->where('parent_id', $parent_folder_id)
            ->firstOrFail();

        foreach ($media_files as $value) {
            $invoice_folder->media()->attach($value->id);
        }

    }

}