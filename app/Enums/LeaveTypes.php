<?php

namespace App\Enums;


enum LeaveTypes: string
{
    case ON_VACATION = 'Vacation';
    case DAY_OFF = 'Day Off';
    case URGENT_SITUATION = 'Urgent';

    static function toArray()
    {

        return collect(LeaveTypes::cases())->map(function ($value, $key) {
            return [
                'title' => str_replace('_', ' ', $value->value),
                'description' => statusDescription()[$value->value] ?? '',
            ];
        });
    }
}

function statusDescription(): array
{
    return [
        LeaveTypes::ON_VACATION->value => 'Plan your time off for extended breaks',
        LeaveTypes::DAY_OFF->value => 'Request single days off for personal matters',
        LeaveTypes::URGENT_SITUATION->value => 'Emergency situations requiring immediate attention',
    ];
}