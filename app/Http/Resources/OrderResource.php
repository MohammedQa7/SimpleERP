<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'orderItems' => OrderItemsResource::collection($this->whenLoaded('orderItems')),
            'orderNumber' => $this->order_number,
            'totalPrice' => $this->total_price,
            'status' => $this->status,
            'notes' => $this->notes,
            'createdAt' => $this->created_at->format('Y-m-d'),
            'approvedAt' => when(!is_null($this->approved_at), function () {
                return $this->approved_at->format('Y-m-d');
            }),
        ];
    }
}