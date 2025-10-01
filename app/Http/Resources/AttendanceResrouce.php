<?php

namespace App\Http\Resources;

use App\Helpers\GlobalHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AttendanceResrouce extends JsonResource
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
            'checkIn' => $this->check_in->format('h:i A'),
            'checkOut' => $this->check_out->format('h:i A'),
            'hours' => GlobalHelpers::calculateTotalHours($this->check_in, $this->check_out),
            'status' => $this->status,
        ];
    }

}