<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeature extends Model
{
    protected $guarded = [
        'id',
        'created_at',
    ];

    function category()
    {
        return $this->belongsTo(SubscriptionFeatureCategory::class, 'category_id');
    }

    function plans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'feature_plan', 'feature_id', 'plan_id')->withPivot('description');
    }

}