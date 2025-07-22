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
            'password' => 'required|string', // Password is now mandatory
        ]);

        // Find user by employee_code
        $user = User::where('employee_code', $request->employee_code)->first();

        if (!$user) {
            return back()->withErrors([
                'employee_code' => 'Kode karyawan tidak ditemukan.',
            ])->onlyInput('employee_code');
        }

        // Check password
        if (!$user->password) {
            return back()->withErrors([
                'password' => 'Akun ini belum memiliki password. Silakan hubungi admin atau gunakan "Lupa Password?".',
            ])->onlyInput('employee_code');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->onlyInput('employee_code');
        }

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
     * Send password via WhatsApp (AJAX endpoint)
     */
    public function sendPasswordViaWhatsApp(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|string|size:8',
        ]);

        $user = User::where('employee_code', $request->employee_code)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Kode karyawan tidak ditemukan.'
            ], 404);
        }

        if (!$user->phone_number) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak terdaftar untuk kode karyawan ini. Hubungi admin.'
            ], 400);
        }

        // Generate new password
        $newPassword = 'SIN' . substr($user->employee_code, -4) . rand(10, 99);
        $user->password = Hash::make($newPassword);
        $user->save();

        // Send via WhatsApp using WhatsAppService
        try {
            $whatsappService = app(\App\Services\WhatsAppService::class);
            $formattedPhone = $whatsappService->formatPhoneNumber($user->phone_number);
            
            $message = "🔐 *PASSWORD BARU SINERGIA*\n\n";
            $message .= "Halo *{$user->name}*,\n\n";
            $message .= "Password baru Anda untuk sistem absensi Sinergia:\n";
            $message .= "🔑 *{$newPassword}*\n\n";
            $message .= "📝 *Kode Karyawan:* {$user->employee_code}\n";
            $message .= "📱 *Password Baru:* {$newPassword}\n\n";
            $message .= "✅ Silakan login dengan kode karyawan dan password ini.\n";
            $message .= "⚠️ Disarankan untuk mengganti password setelah login.\n\n";
            $message .= "🏢 *Tim Sinergia*";
            
            $success = $whatsappService->sendMessage($formattedPhone, $message);
            
            if ($success) {
                Log::info("Password reset sent to WhatsApp for user: {$user->employee_code}");
                return response()->json([
                    'success' => true,
                    'message' => 'Password baru telah dikirim ke WhatsApp Anda. Silakan cek pesan masuk.'
                ]);
            } else {
                // Rollback password change if WhatsApp sending failed
                $user->password = null;
                $user->save();
                
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim pesan WhatsApp. Silakan coba lagi atau hubungi admin.'
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message: ' . $e->getMessage());
            
            // Rollback password change if exception occurred
            $user->password = null;
            $user->save();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.'
            ], 500);
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
