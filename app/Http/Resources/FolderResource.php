<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FolderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'attachments' => AttachmentResource::collection($this->whenLoaded('media')),
            'parentFolder' => when($this->whenLoaded('parentFolder'), function () {
                return new FolderResource($this->whenLoaded('parentFolder'));
            }),
            'subFolders' => when($this->whenLoaded('subFolders'), function () {
                return FolderResource::collection($this->whenLoaded('subFolders'));
            }),
            'subFoldersCount' => $this->sub_folders_count,
            'createdAt' => $this->created_at->diffForHumans()
        ];
    }
}