<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\EmergencyReport;
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
            'password' => 'nullable|string',
        ]);

        // Find user by employee_code
        $user = User::where('employee_code', $request->employee_code)->first();

        if (!$user) {
            return back()->withErrors([
                'employee_code' => 'Kode karyawan tidak ditemukan.',
            ])->onlyInput('employee_code');
        }

        // Check if user has password and password is provided
        if ($user->password && $request->filled('password')) {
            // Login with password
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'password' => 'Password salah.',
                ])->onlyInput('employee_code');
            }
        } elseif ($user->password && !$request->filled('password')) {
            // User has password but didn't provide it
            return back()->withErrors([
                'password' => 'Password diperlukan untuk kode karyawan ini.',
            ])->onlyInput('employee_code');
        }
        // If user doesn't have password, allow login without password (backward compatibility)

        Auth::login($user, $request->filled('remember'));
        
        // Regenerate session to prevent session fixation
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

    /**
     * Check if password is required for this employee code
     */
    public function checkPasswordRequired(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|string|size:8',
        ]);

        $user = User::where('employee_code', $request->employee_code)->first();
        
        return response()->json([
            'password_required' => $user && $user->password ? true : false
        ]);
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password via WhatsApp
     */
    public function sendPasswordViaWhatsApp(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|string|size:8',
        ]);

        $user = User::where('employee_code', $request->employee_code)->first();

        if (!$user) {
            return back()->withErrors([
                'employee_code' => 'Kode karyawan tidak ditemukan.',
            ])->onlyInput('employee_code');
        }

        if (!$user->phone_number) {
            return back()->withErrors([
                'employee_code' => 'Nomor WhatsApp tidak terdaftar untuk kode karyawan ini. Hubungi admin.',
            ])->onlyInput('employee_code');
        }

        // Generate new password if user doesn't have one
        if (!$user->password) {
            $newPassword = 'SIN' . substr($user->employee_code, -4) . rand(10, 99);
            $user->password = Hash::make($newPassword);
            $user->save();
        } else {
            // For existing password, generate a temporary one
            $newPassword = 'SIN' . substr($user->employee_code, -4) . rand(10, 99);
            $user->password = Hash::make($newPassword);
            $user->save();
        }

        // Send via WhatsApp (you'll need to implement this with your preferred WhatsApp API)
        $this->sendWhatsAppMessage($user->phone_number, $newPassword, $user->name);

        return redirect()->route('login')->with('success', 'Password baru telah dikirim ke WhatsApp Anda.');
    }

    /**
     * Send WhatsApp message (implement with your preferred WhatsApp API)
     */
    private function sendWhatsAppMessage($phoneNumber, $password, $userName)
    {
        // Remove leading zero and add country code for Indonesia
        $phoneNumber = '62' . ltrim($phoneNumber, '0');
        
        $message = "Halo {$userName},\n\n";
        $message .= "Password baru Anda untuk sistem absensi Sinergia:\n";
        $message .= "*{$password}*\n\n";
        $message .= "Silakan login dengan kode karyawan dan password ini.\n";
        $message .= "Disarankan untuk mengganti password setelah login.\n\n";
        $message .= "Terima kasih,\nTim Sinergia";

        // Example using a WhatsApp API service (you'll need to replace with actual service)
        // This is a placeholder - implement according to your WhatsApp API provider
        try {
            // Example API call (replace with your actual WhatsApp API)
            /*
            Http::post('https://api.whatsapp-service.com/send', [
                'phone' => $phoneNumber,
                'message' => $message,
                'api_key' => env('WHATSAPP_API_KEY')
            ]);
            */
            
            // For now, just log the message (remove this in production)
            Log::info("WhatsApp message to {$phoneNumber}: {$message}");
            
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp message: " . $e->getMessage());
        }
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
        
        // Get today's attendance data
        $todayAttendance = Attendance::with('user')
            ->whereDate('date', today())
            ->orderBy('check_in', 'desc')
            ->get();

        // Get statistics
        $totalEmployees = User::where('role', 'user')->count();
        $todayPresent = $todayAttendance->count();
        $totalTasks = \App\Models\Task::count();
        $completedTasks = \App\Models\Task::where('status', 'completed')->count();
        $pendingTasks = \App\Models\Task::where('status', '!=', 'completed')->count();
        $emergencyReports = \App\Models\EmergencyReport::whereDate('created_at', today())->count();

        // Get recent activities
        $recentTasks = \App\Models\Task::with(['user', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentReports = \App\Models\EmergencyReport::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'todayAttendance',
            'totalEmployees',
            'todayPresent',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'emergencyReports',
            'recentTasks',
            'recentReports'
        ));
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
