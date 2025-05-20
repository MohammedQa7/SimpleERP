<?php

namespace App\Http\Resources;

use App\Enums\WarehouseStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseStockRequestResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'order' => new OrderResource($this->whenLoaded('order')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'department' => $this->department,
            'status' => $this->status,
            'priority' => $this->priority,
            'reason' => $this->reason,
            'notes' => $this->notes,
            'isRequestStatusPending' => $this->status->value == WarehouseStatus::PENDING->value,
            'requestedQuantity' => $this->requested_quantity,
            'createdAt' => $this->created_at->diffForHumans(),
        ];
    }
}