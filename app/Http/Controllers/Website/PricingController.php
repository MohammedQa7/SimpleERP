<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionFeaturesCategoryResource;
use App\Http\Resources\SubscriptionPlansResource;
use App\Models\SubscriptionFeatureCategory;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PricingController extends Controller
{
    function __invoke()
    {
        $features_and_categories = SubscriptionFeatureCategory::with(['features.plans'])->get();
        // $plans = SubscriptionPlan::get()
        //     ->groupBy('name')
        //     ->map(function ($plans_array) {
        //         return $plans_array->mapWithKeys(function ($item) {
        //             return [$item->interval => new SubscriptionPlansResource($item)];
        //         });
        //     })->values();

        $plans = SubscriptionPlan::with('prices')->orderBy('order')->get();

        return Inertia::render('Website/Pricing', [
            'plans' => SubscriptionPlansResource::collection($plans),
            'featuresAndCategories' => SubscriptionFeaturesCategoryResource::collection($features_and_categories),
        ]);
    }
}