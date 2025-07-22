<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Show attendance dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $today = today();
        
        // Get today's attendance
        $todayAttendance = $user->attendances()->whereDate('date', $today)->first();
        
        // Get recent attendances (last 7 days)
        $recentAttendances = $user->attendances()
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();
        
        // Calculate this month's statistics
        $thisMonth = Carbon::now()->startOfMonth();
        $monthlyAttendances = $user->attendances()
            ->whereDate('date', '>=', $thisMonth)
            ->get();
        
        $stats = [
            'total_days' => $monthlyAttendances->count(),
            'present_days' => $monthlyAttendances->where('status', 'present')->count(),
            'late_days' => $monthlyAttendances->where('status', 'late')->count(),
            'total_hours' => $monthlyAttendances->sum('work_duration') ?? 0
        ];
        
        return view('attendance.index', compact('todayAttendance', 'recentAttendances', 'stats'));
    }

    /**
     * Check in
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = today();
        
        // Check if already checked in today
        $existingAttendance = $user->attendances()->whereDate('date', $today)->first();
        
        if ($existingAttendance && $existingAttendance->check_in) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-in hari ini!');
        }
        
        $checkInTime = now()->setTimezone('Asia/Jakarta')->format('H:i:s');
        $status = 'present';
        
        // Check if late (after 8:00 AM)
        if (Carbon::parse($checkInTime)->gt(Carbon::parse('08:00:00'))) {
            $status = 'late';
        }
        
        if ($existingAttendance) {
            // Update existing record
            $existingAttendance->update([
                'check_in' => $checkInTime,
                'status' => $status,
                'location' => $request->input('location', 'Gedung'),
                'notes' => $request->input('notes')
            ]);
        } else {
            // Create new record
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'check_in' => $checkInTime,
                'status' => $status,
                'location' => $request->input('location', 'Gedung'),
                'notes' => $request->input('notes')
            ]);
        }

        // Otomatis start semua task yang diassign untuk hari ini
        Task::startTodayTasks($user->id);
        
        return redirect()->back()->with('success', 'Check-in berhasil! Semua tugas hari ini sudah otomatis dimulai. Selamat bekerja.');
    }

    /**
     * Check out
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $today = today();
        
        $attendance = $user->attendances()->whereDate('date', $today)->first();
        
        if (!$attendance || !$attendance->check_in) {
            return redirect()->back()->with('error', 'Anda belum melakukan check-in hari ini!');
        }
        
        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-out hari ini!');
        }
        
        $checkOutTime = now()->setTimezone('Asia/Jakarta')->format('H:i:s');
        $status = $attendance->status;
        
        // Check if early leave (before 5:00 PM)
        if (Carbon::parse($checkOutTime)->lt(Carbon::parse('17:00:00'))) {
            $status = 'early_leave';
        }
        
        $attendance->update([
            'check_out' => $checkOutTime,
            'status' => $status,
            'notes' => $request->input('notes')
        ]);
        
        return redirect()->back()->with('success', 'Check-out berhasil! Terima kasih atas kerja keras Anda.');
    }

    /**
     * Show attendance history
     */
    public function history()
    {
        $user = Auth::user();
        
        $attendances = $user->attendances()
            ->orderBy('date', 'desc')
            ->paginate(15);
        
        return view('attendance.history', compact('attendances'));
    }
}
