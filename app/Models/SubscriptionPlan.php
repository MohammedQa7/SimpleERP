<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $guarded = [
        'id',
        'created_at',
    ];


    function features()
    {
        return $this->belongsToMany(SubscriptionFeature::class, 'feature_plan', 'plan_id', 'feature_id')->withPivot('description');
    }

    function prices()
    {
        return $this->hasMany(SubscriptionPlanPrice::class,'plan_id');
    }

}