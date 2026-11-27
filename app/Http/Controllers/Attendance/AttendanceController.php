<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Database\UniqueConstraintViolationException;

class AttendanceController extends Controller
{
    public function __construct(private AttendanceService $attendanceService) {}

    public function store()
    {
        $employee = auth()->user()->employee;
        try {
            $attendance = $this->attendanceService->checkIn($employee);
            $checkedInTime = $attendance->check_in_time->setTimezone('Asia/Kolkata')->format('h:i A');

            return redirect()->route('dashboard')
                ->with(['status' => __('messages.attendance.check_in_success', ['time' => $checkedInTime])]);
        } catch (UniqueConstraintViolationException) {
            return back()->withErrors(['message' => __('messages.attendance.already_checked_in')]);
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['message' => __('messages.attendance.check_in_failed')]);
        }
    }
}
