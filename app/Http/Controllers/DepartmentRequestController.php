<?php

namespace App\Http\Controllers;

use App\Enums\Statuses;
use App\Http\Resources\DepartmentRequestResource;
use App\Models\DepartmentRequest;
use App\Services\DepartmentRequestsServices;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentRequestController extends Controller
{
    use AuthorizesRequests;

    function index(DepartmentRequestsServices $department_request_service)
    {
        $department_requests = DepartmentRequest::with([
            'employee',
            'employeeRequest' => function ($query) {
                $query->select(['department_request_id', 'type', 'start_date', 'end_date']);
            },
        ])
            ->where('status', Statuses::PENDING->value)
            ->paginate(15);

        $recently_apporved_requests = $department_request_service->getRecentlyApprovedRequests();


        return Inertia::render('HrDepartment/LeavesRequests/LeaveReqeustList', [
            'requests' => DepartmentRequestResource::collection($department_requests),
            'recentlyApprovedRequests' => DepartmentRequestResource::collection($recently_apporved_requests)
        ]);
    }


    function approve(DepartmentRequest $department_leave_request)
    {
        $department_leave_request->update([
            'status' => Statuses::APPROVED->value
        ]);

        // Send Email to the employee.
    }

    function reject(DepartmentRequest $department_leave_request, Request $request)
    {
        $request->validate([
            'rejectionReason' => ['required', 'max:500', 'string']
        ]);

        $department_leave_request->update([
            'status' => Statuses::REJECTED->value
        ]);

        // Send Email to the employee.

    }
}