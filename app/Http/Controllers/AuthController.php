<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|string|size:8', // Format: SBY09876
        ]);

        // Find user by employee_code
        $user = User::where('employee_code', $request->employee_code)->first();

        if ($user) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            
            // Auto check-in for regular users
            if ($user->isUser()) {
                $today = today();
                $existingAttendance = $user->attendances()->whereDate('date', $today)->first();
                
                if (!$existingAttendance) {
                    // Create new attendance record with auto check-in
                    $checkInTime = now()->format('H:i:s');
                    $status = 'present';
                    
                    // Check if late (after 8:00 AM)
                    if (Carbon::parse($checkInTime)->gt(Carbon::parse('08:00:00'))) {
                        $status = 'late';
                    }
                    
                    Attendance::create([
                        'user_id' => $user->id,
                        'date' => $today,
                        'check_in' => $checkInTime,
                        'status' => $status,
                        'location' => 'Otomatis',
                        'notes' => 'Check-in otomatis saat login'
                    ]);
                    
                    $message = $status === 'late' ? 
                        'Selamat datang! Anda terlambat. Absensi masuk telah dicatat.' : 
                        'Selamat datang! Absensi masuk telah dicatat.';
                } else {
                    $message = 'Selamat datang kembali!';
                }
            }
            
            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang Admin!');
            } else {
                return redirect()->intended('/attendance')->with('success', $message ?? 'Selamat datang!');
            }
        }

        return back()->withErrors([
            'employee_code' => 'Kode karyawan tidak ditemukan.',
        ])->onlyInput('employee_code');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show admin dashboard
     */
    public function adminDashboard()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login')->with('error', 'Access denied. Admin only.');
        }
        
        return view('admin.dashboard');
    }

    /**
     * Show user dashboard
     */
    public function userDashboard()
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }
        
        return view('user.dashboard');
    }
}
