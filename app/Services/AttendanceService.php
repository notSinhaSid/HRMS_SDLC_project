<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;

class AttendanceService
{
    public function checkIn(Employee $employee): Attendance
    {
        $now = now();
        $attendance = $employee->attendances()->make()->forceFill([
            'work_date' => $now->copy()->timezone('Asia/Kolkata')->toDateString(),
            'check_in_time' => $now,
        ]);
        $attendance->save();

        return $attendance;
    }
}
