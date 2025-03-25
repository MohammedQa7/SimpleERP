<?php

namespace App\Enums;

enum JobTitles: string
{
    case ADMINISTRATOR = 'Administrator';
    case SOFTWARE_DEVELOPER = 'Software Developer';
    case HR_MANAGER = 'HR Manager';
    case SALES_EXECUTIVE = 'Sales Executive';
    case FINANCE_OFFICER = 'Finance Officer';
    case UI_UX_DESIGNER = 'UI/UX Designer';
    case PROJECT_MANAGER = 'Project Manager';


    static function toArray()
    {
        return collect(JobTitles::cases())->map(function ($value, $key) {
            return [
                'label' => $value->value,
                'value' => $value->value,
            ];
        });
    }

}