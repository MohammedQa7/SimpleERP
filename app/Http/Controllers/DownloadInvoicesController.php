<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadInvoicesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Media $media)
    {

        return response()->download($media->getPath(), $media->file_name);

        // return $invoice->getFirstMedia('*');

        // return $mediaItem;
        // $get3D = new \getID3;
        // if (Storage::disk('public')->exists($invoice->file_path)) {
        //     $attachments_path = public_path('storage/' . $invoice->file_path);
        //     return Response::download($attachments_path);
        // } else {
        //     abort(404, 'No file were found');
        // }
    }
}