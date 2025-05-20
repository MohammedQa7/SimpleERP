<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DownloadAttachmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Attachment $attachment)
    {
        if (Storage::disk('public')->exists($attachment->attachment_path)) {
            $attachments_path = public_path('storage/' . $attachment->attachment_path);
            return Response::download($attachments_path);
        } else {
            abort(404, 'No file were found');
        }
    }
}