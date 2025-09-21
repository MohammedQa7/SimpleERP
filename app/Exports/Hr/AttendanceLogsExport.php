<?php

namespace App\Exports\Hr;

use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceLogsExport implements FromCollection, WithHeadings
{
    function __construct(public $query_params)
    {

    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $attendance_logs = AttendanceLog::
            Filter([...request()->query])
            ->select(['id', 'employee_id', 'action', 'device', 'created_at'])
            ->with([
                'employee' => function ($query) {
                    $query->select(['id', 'name', 'email', 'job_title', 'account_code']); // include id!
                }
            ])
            ->get()->map(function ($query) {
                return [
                    'employee_code' => $query->employee->account_code ?? "N\A",
                    'employee_name' => $query->employee->name,
                    'employee_email' => $query->employee->email,
                    'employee_job_title' => $query->employee->job_title ?? "N\A",
                    'action' => $query->action,
                    'device' => $query->device,
                    'created_at' => $query->created_at,
                ];
            });


        if (sizeof($attendance_logs) < 1) {
            Log::error('No date were found to export');
            return throw new \Exception("No data were found to export", 400);
        }

        return $attendance_logs;
    }



    public function headings(): array
    {
        $users_headings = User::select(['account_code', 'name', 'email', 'job_title'])
            ->first()
            ->toArray();
        $attendance_logs_headings = AttendanceLog::select(['action', 'device', 'created_at'])
            ->first()
            ->toArray();

        return $users_headings && $attendance_logs_headings
            ? array_merge(array_keys($users_headings), array_keys($attendance_logs_headings))
            : null;
    }
}