<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionFeaturesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            // dd($this->plans),
            'planFeatures' => $this->whenLoaded('plans', function ($query) {
                return $this->plans->mapWithKeys(function ($plan) {
                    return [
                        $plan->id => [
                            'featuredId' => $plan->pivot->feature_id,
                            'description' => $plan->pivot->description,
                        ]
                    ];
                });
            }),
            'category' => new SubscriptionFeaturesCategoryResource($this->whenLoaded('category')),
            'restrictions' => $this->restrictions,
        ];
    }
}