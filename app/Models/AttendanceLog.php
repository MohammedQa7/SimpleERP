<?php

namespace App\Models;

use App\Http\Resources\AttendanceLogResource;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AttendanceLog extends Model
{
    protected $guarded = ['id', 'created_at'];

    protected function createdAt(): Attribute
    {
        return Attribute::make(

            get: fn($value) => Carbon::parse($value)->timezone('Asia/Beirut'),
        );
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // SCOPES
    function scopeIsEmployeeCheckedIn($query)
    {
        $data = $query->with('employee')
            ->where('employee_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();

            
        if ($data) {
            return [
                'value' => $data->action == 'check-in',
                'data' => $data->action == 'check-in' ? new AttendanceLogResource($data) : null,
            ];
        }
    }
}