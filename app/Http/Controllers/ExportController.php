<?php

namespace App\Http\Controllers;

use App\Exports\Hr\AttendanceLogsExport;
use App\Handler\Exports\ExportDispatcher;
use App\Models\Attendances;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    function __invoke(Request $request, ExportDispatcher $export_dispatcher, string $module, string $export_type)
    {
        return $export_dispatcher->handle($module, $export_type);
    }
}