<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoiceNumber' => $this->invoice_number,
            'order' => new OrderResource($this->whenLoaded('order')),
            'invoiceFile' => $this->getFirstMedia('*'),
            'status' => $this->status,
            'isSend' => $this->is_sent,
            'endsAt' => when(!is_null($this->ends_at), function () {
                return $this->ends_at->diffForHumans();
            }),
            'createdAt' => when(!is_null($this->created_at), function () {
                return $this->created_at->format('Y-m-d');
            }),
        ];
    }
}