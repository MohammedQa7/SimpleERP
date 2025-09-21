<?php

namespace App\Http\Controllers;

use App\Enums\LeaveTypes;
use App\Enums\Priorities;
use App\Http\Requests\EmployeeLeaveFormRequest;
use App\Http\Resources\DepartmentRequestResource;
use App\Models\DepartmentRequest;
use App\Models\EmployeeRequest;
use App\Services\DepartmentRequestsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class EmployeeRequestController extends Controller
{
    function index()
    {
        // whereEmployeeId It’s generated automatically by Laravel based on your model’s table column employee_id.
        $current_employee_requests = DepartmentRequest::whereEmployeeId(auth()->user()->id)
            ->with('employeeRequest')
            ->whereHas('employeeRequest', function ($query) {
                return $query->GetRequestsFromToday();
            })
            ->get();
        return Inertia::render('Employee/LeaveRequests', [
            'employeeRequests' => DepartmentRequestResource::collection($current_employee_requests),
            'requestTypes' => LeaveTypes::toArray(),
            'priority' => Priorities::toArray(),
        ]);

    }

    function store(EmployeeLeaveFormRequest $request, DepartmentRequestsServices $department_requests_services)
    {
        // Create the initial Request entity before attaching it to the relevant target (e.g., employee requests, warehouse requests).
        try {
            DB::beginTransaction();
            $intial_department_request = $department_requests_services->createIntialRequest($request);

            $intial_department_request->employeeRequest()->create([
                'type' => $request->type,
                'start_date' => $request->startDate,
                'end_date' => $request->startDate,
            ]);

            Log::info('intial request has been created with its relevant target: Employee Request ');
            DB::commit();
        } catch (\Throwable $th) {
            Log::info('Unable to create Employee Leave Reqeust');
            DB::rollBack();
            throw $th;
        }
    }

    function show(EmployeeRequest $employee_request)
    {

    }
}