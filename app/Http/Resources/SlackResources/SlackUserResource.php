<?php

namespace App\Http\Resources\SlackResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlackUserResource extends JsonResource
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
            'isOwner' => $this['is_primary_owner'] ?? false,
            'isEmailConfirmed' => $this['is_email_confirmed'],
            'isConnected' => auth()->user()->isAppConnected('slack'),
            'teamId' => $this['team_id'],
            'avatar' => $this['avatar'],
        ];
    }
}