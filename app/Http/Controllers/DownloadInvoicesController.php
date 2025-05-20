<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DownloadInvoicesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Invoice $invoice)
    {

        $get3D = new \getID3;
        if (Storage::disk('public')->exists($invoice->file_path)) {
            $attachments_path = public_path('storage/' . $invoice->file_path);
            return Response::download($attachments_path);
        } else {
            abort(404, 'No file were found');
        }
    }
}