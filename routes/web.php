<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmergencyReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
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
