<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'employee' => new UserResource($this->whenLoaded('employee')),
            'action' => $this->action,
            'device' => $this->device,
            'checkInDate' => $this->created_at->format('M d, Y'),
            'checkInTime' => $this->created_at->format('h:i A'),
        ];
    }
}