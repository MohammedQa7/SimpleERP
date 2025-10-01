<?php


namespace App\Actions;

use App\Enums\AttendanceStatus;
use App\Models\AttendanceLog;
use App\Models\Attendances;
use Illuminate\Support\Carbon;


class CalculateAttendanceHours
{
    function handle()
    {

        AttendanceLog::whereToday('created_at')
            ->whereDoesntHave('employee.attendances', function ($query) {
                return $query->whereDate('check_in', today()->timezone('Asia/Beirut'));
            })
            ->orderBy('created_at')
            ->chunk('1000', function ($logs) {
                $grouped_logs = $logs->groupBy('employee_id');

                foreach ($grouped_logs as $employee_id => $entries) {
                    $total_minutes = 0;

                    // Pair check-in and check-out to calculate the actual working hours.
                    for ($i = 0; $i < $entries->count(); $i += 2) {
                        $check_in = $entries[$i]->created_at ?? null;
                        $check_out = $entries[$i + 1]->created_at ?? null;

                        if ($check_in && $check_out) {
                            $total_minutes += $check_in->diffInMinutes($check_out);
                        }
                    }

                    $hours = intdiv($total_minutes, 60);
                    $mins = $total_minutes % 60;


                    return Attendances::create([
                        'employee_id' => $employee_id,
                        'check_in' => $logs->first()->created_at,
                        'check_out' => $logs->last()->created_at,
                        'total_hours' => "{$hours}h {$mins}m",
                        'status' => AttendanceStatus::PRESENT,
                    ]);

                }
            });
    }
}