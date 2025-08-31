<?php

namespace App\Http\Resources;

use App\Helpers\GlobalHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // $getID3 = new \getID3;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->mime_type,
            'size' => $this->human_readable_size,
            'path' => $this->getFullUrl(),
            'createdAt' => $this->created_at->format('M d, Y')
            // 'name' => Str::substr($getID3->analyze(Storage::disk('public')->path($this->attachment_path))['filename'], 10),
            // 'path' => Storage::disk('public')->url($this->attachment_path),
            // 'size' => GlobalHelpers::humanReadableFileSize($getID3->analyze(Storage::disk('public')->path($this->attachment_path))['filesize']),
            // 'type' => $getID3->analyze(Storage::disk('public')->path($this->attachment_path))['mime_type']
        ];
    }
}