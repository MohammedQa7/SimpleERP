<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentNotificaion extends Model
{
    protected $guarded = [
        'created_at'
    ];


    function casts()
    {
        return [
            'data' => 'array',
        ];
    }
}