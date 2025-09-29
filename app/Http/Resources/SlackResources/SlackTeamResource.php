<?php

namespace App\Http\Resources\SlackResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlackTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'url' => $this['url'],
            'avatar' => $this['avatar'],
            'isVerified' => $this['is_verified'],
        ];
    }
}