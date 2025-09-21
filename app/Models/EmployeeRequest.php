<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EmployeeRequest extends Model
{
    protected $guarded = ['id', 'created_at'];

    function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }


    public function request()
    {
        return $this->belongsTo(Request::class);
    }


    function scopeGetRequestsFromToday($query)
    {
        return $query->whereDate('start_date', '>=', Carbon::today());
    }
}