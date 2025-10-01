<?php

namespace App\Http\Controllers;

use App\Actions\CalculateAttendanceHours;
use App\Helpers\GlobalHelpers;
use App\Http\Resources\AttendanceResrouce;
use App\Models\AttendanceLog;
use App\Models\Attendances;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    function index()
    {
        $attendances = Attendances::with('employee')->paginate(5);
        return Inertia::render('HrDepartment/Attendances/Index', [
            'attendances' => AttendanceResrouce::collection($attendances),
        ]);
    }

    function test(CalculateAttendanceHours $action)
    {
        $action->handle();
    }
}