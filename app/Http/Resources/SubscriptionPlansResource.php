<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPlansResource extends JsonResource
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
            'prices' => when($this->whenLoaded('prices'), function () {
                return SubscriptionPlanPriceResource::collection($this->prices->keyBy('interval'));
            }),
            'highlight' => $this->highlight,
            'featurePivot' => $this->whenPivotLoaded('feature_plan', function () {
                return [
                    'featureId' => $this->pivot->feature_id,
                    'planId' => $this->pivot->plan_id,
                ];
            }),
        ];
    }
}