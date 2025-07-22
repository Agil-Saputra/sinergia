<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', today());
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->latest('date')->latest('check_in')->paginate(20);
        
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.attendance.index', compact('attendances', 'users'));
    }

    public function show(Attendance $attendance)
    {
        $attendance->load('user');
        return view('admin.attendance.show', compact('attendance'));
    }

    public function stats(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        $attendanceStats = Attendance::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('
                COUNT(*) as total_records,
                COUNT(CASE WHEN check_out IS NOT NULL THEN 1 END) as completed_shifts,
                AVG(CASE WHEN check_out IS NOT NULL THEN 
                    TIMESTAMPDIFF(MINUTE, check_in, check_out) END) as avg_work_hours
            ')
            ->first();

        $dailyAttendance = Attendance::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('DATE(date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $userAttendance = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('user_id, COUNT(*) as total_days, 
                        COUNT(CASE WHEN check_out IS NOT NULL THEN 1 END) as completed_days')
            ->groupBy('user_id')
            ->get();

        return view('admin.attendance.stats', compact('attendanceStats', 'dailyAttendance', 'userAttendance', 'startDate', 'endDate'));
    }
}
