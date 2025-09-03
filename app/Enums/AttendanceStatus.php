<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'Present';
    case ABSENT = 'Absent';
    case LATE = 'Late';
    case URGENT_SITUATION = 'Urgent Situation';
    case SICK_LEAVE = 'Sick Leave';
    case ON_LEAVE = 'On Leave';
    case ON_VACATION = 'On Vacation';

    static function toArray()
    {
        return collect(AttendanceStatus::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}