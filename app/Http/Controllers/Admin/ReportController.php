<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function tasks(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        $taskStats = [
            'total' => Task::whereBetween('assigned_date', [$startDate, $endDate])->count(),
            'completed' => Task::whereBetween('assigned_date', [$startDate, $endDate])->where('status', 'completed')->count(),
            'in_progress' => Task::whereBetween('assigned_date', [$startDate, $endDate])->where('status', 'in_progress')->count(),
            'assigned' => Task::whereBetween('assigned_date', [$startDate, $endDate])->where('status', 'assigned')->count(),
        ];

        $tasksByUser = Task::with('user')
            ->whereBetween('assigned_date', [$startDate, $endDate])
            ->selectRaw('user_id, COUNT(*) as total_tasks, 
                        COUNT(CASE WHEN status = "completed" THEN 1 END) as completed_tasks,
                        AVG(CASE WHEN completed_at IS NOT NULL AND started_at IS NOT NULL 
                            THEN TIMESTAMPDIFF(MINUTE, started_at, completed_at) END) as avg_completion_time')
            ->groupBy('user_id')
            ->get();

        $tasksByCategory = Task::whereBetween('assigned_date', [$startDate, $endDate])
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        return view('admin.reports.tasks', compact('taskStats', 'tasksByUser', 'tasksByCategory', 'startDate', 'endDate'));
    }

    public function attendance(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        $attendanceStats = [
            'total_records' => Attendance::whereBetween('date', [$startDate, $endDate])->count(),
            'completed_shifts' => Attendance::whereBetween('date', [$startDate, $endDate])->whereNotNull('check_out')->count(),
            'average_hours' => Attendance::whereBetween('date', [$startDate, $endDate])
                ->whereNotNull('check_out')
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, check_in, check_out) / 60) as avg_hours')
                ->value('avg_hours') ?? 0
        ];

        $attendanceByUser = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('user_id, COUNT(*) as total_days,
                        COUNT(CASE WHEN check_out IS NOT NULL THEN 1 END) as completed_days,
                        AVG(CASE WHEN check_out IS NOT NULL 
                            THEN TIMESTAMPDIFF(MINUTE, check_in, check_out) / 60 END) as avg_hours')
            ->groupBy('user_id')
            ->get();

        return view('admin.reports.attendance', compact('attendanceStats', 'attendanceByUser', 'startDate', 'endDate'));
    }

    public function emergencyReports(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        $emergencyStats = [
            'total' => EmergencyReport::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count(),
            'resolved' => EmergencyReport::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'resolved')->count(),
            'pending' => EmergencyReport::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'pending')->count(),
        ];

        $reportsByType = EmergencyReport::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get();

        $reportsByUrgency = EmergencyReport::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->selectRaw('urgency, COUNT(*) as count')
            ->groupBy('urgency')
            ->get();

        return view('admin.reports.emergency', compact('emergencyStats', 'reportsByType', 'reportsByUrgency', 'startDate', 'endDate'));
    }
}
