<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationProviderResource extends JsonResource
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
            'key' => $this->key,
            'folderName' => $this->folder_name,
            'description' => $this->description,
            'isAvailable' => $this->available,
            'icon' => $this->getMedia('*')[0]->getFullUrl(),
            'isUserAuthorized' => auth()->user()->hasConnected($this->key),
        ];
    }
}