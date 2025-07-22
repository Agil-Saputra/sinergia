<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmergencyReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/check-password-required', [AuthController::class, 'checkPasswordRequired']);

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendPasswordViaWhatsApp'])->name('forgot-password.send');

// Admin Routes
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // Users Management
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Task Management
    Route::get('/admin/tasks', [\App\Http\Controllers\Admin\TaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('/admin/tasks/create', [\App\Http\Controllers\Admin\TaskController::class, 'create'])->name('admin.tasks.create');
    Route::post('/admin/tasks', [\App\Http\Controllers\Admin\TaskController::class, 'store'])->name('admin.tasks.store');
    Route::get('/admin/tasks/{task}', [\App\Http\Controllers\Admin\TaskController::class, 'show'])->name('admin.tasks.show');
    Route::get('/admin/tasks/{task}/edit', [\App\Http\Controllers\Admin\TaskController::class, 'edit'])->name('admin.tasks.edit');
    Route::put('/admin/tasks/{task}', [\App\Http\Controllers\Admin\TaskController::class, 'update'])->name('admin.tasks.update');
    Route::delete('/admin/tasks/{task}', [\App\Http\Controllers\Admin\TaskController::class, 'destroy'])->name('admin.tasks.destroy');
    Route::post('/admin/tasks/{task}/feedback', [\App\Http\Controllers\Admin\TaskController::class, 'giveFeedback'])->name('admin.tasks.feedback');
    Route::post('/admin/tasks/{task}/approve', [\App\Http\Controllers\Admin\TaskController::class, 'approve'])->name('admin.tasks.approve');
    Route::post('/admin/tasks/{task}/reject', [\App\Http\Controllers\Admin\TaskController::class, 'reject'])->name('admin.tasks.reject');
    
    // Attendance Management
    Route::get('/admin/attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/admin/attendance/{attendance}', [\App\Http\Controllers\Admin\AttendanceController::class, 'show'])->name('admin.attendance.show');
    Route::get('/admin/attendance/stats', [\App\Http\Controllers\Admin\AttendanceController::class, 'stats'])->name('admin.attendance.stats');
    
    // Reports
    Route::get('/admin/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/tasks', [\App\Http\Controllers\Admin\ReportController::class, 'tasks'])->name('admin.reports.tasks');
    Route::get('/admin/reports/attendance', [\App\Http\Controllers\Admin\ReportController::class, 'attendance'])->name('admin.reports.attendance');
    Route::get('/admin/reports/emergency', [\App\Http\Controllers\Admin\ReportController::class, 'emergencyReports'])->name('admin.reports.emergency');
    
    // Emergency Reports Management
    Route::get('/admin/emergency-reports', [\App\Http\Controllers\Admin\EmergencyReportController::class, 'index'])->name('admin.emergency-reports.index');
    Route::get('/admin/emergency-reports/{emergencyReport}', [\App\Http\Controllers\Admin\EmergencyReportController::class, 'show'])->name('admin.emergency-reports.show');
    Route::put('/admin/emergency-reports/{emergencyReport}/status', [\App\Http\Controllers\Admin\EmergencyReportController::class, 'updateStatus'])->name('admin.emergency-reports.update-status');
});

// User Routes
Route::middleware(['role:user'])->group(function () {
    // Attendance System
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
    
    // Legacy routes (redirect to attendance)
    Route::get('/user/dashboard', function () {
        return redirect()->route('attendance.index');
    })->name('user.dashboard');
    
    // Emergency Reports
    Route::get('/user/reports', [EmergencyReportController::class, 'index'])->name('user.reports');
    Route::get('/user/emergency-reports', [EmergencyReportController::class, 'index'])->name('user.emergency-reports');
    Route::post('/user/emergency-reports', [EmergencyReportController::class, 'store'])->name('user.emergency-reports.store');
    Route::get('/user/emergency-reports/{id}', [EmergencyReportController::class, 'show'])->name('user.emergency-reports.show');
    
    // Tasks
    Route::get('/user/tasks', [TaskController::class, 'index'])->name('user.tasks');
    Route::get('/user/tasks/create', [TaskController::class, 'create'])->name('user.tasks.create');
    Route::post('/user/tasks', [TaskController::class, 'store'])->name('user.tasks.store');
    Route::get('/user/tasks/{task}', [TaskController::class, 'show'])->name('user.tasks.show');
    Route::patch('/user/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('user.tasks.update-status');
    Route::post('/user/tasks/{task}/complete', [TaskController::class, 'complete'])->name('user.tasks.complete');
    
    // Profile
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/user/profile/change-password', [ProfileController::class, 'changePassword'])->name('user.profile.change-password');
    Route::put('/user/profile/change-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
});
