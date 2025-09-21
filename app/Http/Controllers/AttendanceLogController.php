<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceLogResource;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class AttendanceLogController extends Controller
{
    function index(Request $request)
    {
        $attendance_logs = AttendanceLog::with('employee')
            ->Filter([...$request->query])
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('HrDepartment/Attendances/Logs', [
            'attendanceLogs' => AttendanceLogResource::collection($attendance_logs),
            'filters' => [...$request->query],
        ]);
    }

    function store()
    {
        sleep(2);
        AttendanceLog::create([
            'employee_id' => auth()->user()->id,
            'action' => auth()->user()->lastAttendanceAction()
        ]);
    }

    function show(Request $request)
    {

    }

}