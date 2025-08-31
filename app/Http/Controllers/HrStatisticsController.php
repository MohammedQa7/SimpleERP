<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\Event;
use App\Models\User;
use App\Services\HrStatisticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HrStatisticsController extends Controller
{
    function __invoke(HrStatisticsService $hr_statistics_service)
    {
        // Upcoming events
        $upcoming_events = Event::where('start_date', '>', now())->orderBy('start_date')->limit(5)->get();

        return Inertia::render('HrDepartment/Index', [
            'departmentEmployeesCount' => $hr_statistics_service->getDepratmentsEmployeesCount(),
            'upcomingEvents' => EventResource::collection($upcoming_events),
            'totalEmployees' => $hr_statistics_service->getAllEmployees(),
        ]);
    }
}