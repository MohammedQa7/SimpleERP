<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceResrouce;
use App\Models\Attendances;
use Illuminate\Http\Request;
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
}