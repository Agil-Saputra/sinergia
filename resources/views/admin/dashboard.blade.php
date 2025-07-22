@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<!-- Dashboard Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600 mt-2">Selamat datang kembali, {{ Auth::user()->name }}! Ini yang terjadi hari ini.</p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a.5.5 0 01.5.5v.5"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Karyawan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalEmployees }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Hadir Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">{{ $todayPresent }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Tugas Tertunda</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingTasks }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Tugas Selesai</p>
                <p class="text-2xl font-bold text-gray-900">{{ $completedTasks }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Tasks -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Tugas Terbaru</h3>
                <a href="{{ route('admin.tasks.index') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentTasks as $task)
                    <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $task->title }}</p>
                            <p class="text-sm text-gray-600">{{ $task->user->name }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->status_color }}">
                            {{ $task->status_text }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada tugas ditemukan</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Today's Attendance -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Absensi Hari Ini</h3>
                <a href="{{ route('admin.attendance.index') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($todayAttendance as $attendance)
                    <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $attendance->user->name }}</p>
                            <p class="text-sm text-gray-600">
                                Check-in: {{ $attendance->check_in ? $attendance->check_in->format('H:i') : 'Belum diatur' }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $attendance->check_out ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $attendance->check_out ? 'Selesai' : 'Aktif' }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada catatan absensi hari ini</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Emergency Reports Today -->
@if($emergencyReports > 0)
    <div class="mt-8">
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.232 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-red-900">Laporan Darurat Hari Ini</h3>
                    <p class="text-red-700">{{ $emergencyReports }} laporan darurat{{ $emergencyReports > 1 ? '' : '' }} diterima hari ini</p>
                    <a href="{{ route('admin.emergency-reports.index') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">Tinjau laporan →</a>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
