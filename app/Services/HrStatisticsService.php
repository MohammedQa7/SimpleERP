<?php

namespace App\Services;

use App\Enums\UserRoles;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;


class HrStatisticsService
{
    function getAllEmployees()
    {
        $employees = $employees = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', UserRoles::ADMINISTRATOR->value);
        })->get();

        $employees_this_month = $employees->where(function ($query) {
            return $query->created_at->isSameMonth(now()->subMonth());
        })->count();

        $employees_last_month = $employees->where(function ($query) {
            return $query->created_at->isSameMonth(now());
        })->count();


        return [
            'count' => count($employees),
            'percentage' => $employees_last_month > 0
            ? round((($employees_this_month - $employees_last_month) / $employees_last_month) * 100, 2)
            : 0
        ];
    }

    function getDepratmentsEmployeesCount()
    {
        $employees_per_department = User::get()->groupBy(function ($query) {
            return $query->department ?? 'No Department';
        })->map(function ($user) {
            return count($user);
        });

        $employees_array = [];
        foreach ($employees_per_department as $key => $value) {
            $employees_array[$key]['department'] = $key;
            $employees_array[$key]['count'] = $value;
        }

        return array_values($employees_array);
    }


}