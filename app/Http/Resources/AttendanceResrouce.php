<?php

namespace App\Http\Resources;

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
            'hours' => $this->calculateTotalHours($this->check_in, $this->check_out),
            'status' => $this->status,
        ];
    }

    protected function calculateTotalHours($check_in, $check_out)
    {
        if (!is_null($check_out)) {
            $total_hours = $check_in->diffAsCarbonInterval($check_out);
            return $total_hours->format('%hh %im');
        }
        return '0h 00m';
    }
}