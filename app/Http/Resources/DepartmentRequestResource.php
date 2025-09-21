<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentRequestResource extends JsonResource
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
            'employee' => new UserResource($this->whenLoaded('employee')),
            'employeeRequest' => new EmployeeRequestResource($this->whenLoaded('employeeRequest')),
            'title' => $this->title,
            'department' => $this->department,
            'status' => $this->status,
            'priority' => $this->priority,
            'reason' => $this->reason,
            'note' => $this->note,
            'createdAt' => $this->created_at->format('M d, Y'),
        ];
    }
}