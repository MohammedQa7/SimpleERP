<?php

namespace App\Http\Resources\SlackResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlackChannelResource extends JsonResource
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
            'name' => $this['name_normalized'],
            'memberCount' => $this['num_members'],
            'purpose' => $this['purpose'],
        ];
    }
}