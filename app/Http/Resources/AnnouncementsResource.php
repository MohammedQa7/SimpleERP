<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AnnouncementsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'image' => $this->getMedia("*")[0]->getFullUrl(),
            'title' => $this->title,
            'content' => $this->content,
            'version' => $this->version,
            'type' => $this->type,
            'createdAt' => $this->created_at->format('F d, Y'),
        ];
    }
}