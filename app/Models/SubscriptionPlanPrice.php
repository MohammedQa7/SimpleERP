<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanPrice extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];




    function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }
}