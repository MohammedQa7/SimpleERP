<?php

namespace App\Services;

use App\Enums\Statuses;
use App\Models\DepartmentRequest;

class DepartmentRequestsServices
{

    function createIntialRequest($request)
    {
        return DepartmentRequest::create([
            'employee_id' => auth()->user()->id,
            'title' => $request->title,
            'department' => auth()->user()->department ?? 'High Authority',
            'reason' => $request->reason,
            'note' => $request->note,
            'priority' => $request->priority,
            'status' => Statuses::PENDING->value,
        ]);
    }


    function getRecentlyApprovedRequests()
    {
        return DepartmentRequest::with([
            'employee',
            'employeeRequest' => function ($query) {
                $query->select(['department_request_id', 'type', 'start_date', 'end_date']);
            },
        ])
            ->where('status', Statuses::APPROVED->value)
            ->latest()
            ->limit(5)
            ->get();
    }
}