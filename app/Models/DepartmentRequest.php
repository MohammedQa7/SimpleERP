<?php

namespace App\Models;

use App\Enums\Priorities;
use App\Enums\Statuses;
use Illuminate\Database\Eloquent\Model;

class DepartmentRequest extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];

    function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? $this->getRouteKeyName(), $value)
            ->where('status', Statuses::PENDING->value)
            ->firstOrFail();
    }
    function casts(): array
    {
        return [
            'priority' => Priorities::class,
            'status' => Statuses::class,
        ];
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function employeeRequest()
    {
        return $this->hasOne(EmployeeRequest::class);
    }
}