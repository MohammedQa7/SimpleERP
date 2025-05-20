<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'sku' => $this->sku,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'description' => $this->description,
            'costPrice' => $this->cost_price,
            'sellingPrice' => $this->selling_price,
            'stock' => $this->stock,
        ];
    }
}