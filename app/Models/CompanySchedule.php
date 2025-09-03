<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySchedule extends Model
{
    protected $guarded = ['id', 'created_at'];

    function casts(): array
    {
        return [
            'start_time' => 'datetime:h:i A',
            'end_time' => 'datetime:h:i A',
            'off_working_days' => 'array',
        ];
    }
}