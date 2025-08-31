<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice' => new InvoiceResource($this->whenLoaded('modelable')),
            'attachments' => AttachmentResource::collection($this->getMedia("*")),
            'receiptFile' => new AttachmentResource($this->getFirstMedia("receipt_payment")),
            'paymentNumber' => $this->payment_number,
            'paymentMethod' => $this->method,
            'notes' => $this->notes,
            'createdAt' => $this->created_at->format('d/m/Y')
        ];
    }
}