<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeatureCategory extends Model
{
    protected $guarded = [
        'id',
        'created_at',
    ];


    function features()
    {
        return $this->hasMany(SubscriptionFeature::class, 'category_id');
    }
}