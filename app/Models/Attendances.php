<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    protected $guarded = ['id', 'created_at'];

    function casts(): array
    {
        return [
            'status' => AttendanceStatus::class,
            'check_in' => 'datetime',
            'check_out' => 'datetime',
        ];
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}