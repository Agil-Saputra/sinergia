@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard Laporan</h1>
    <p class="mt-2 text-sm text-gray-700">Akses laporan detail dan analitik untuk organisasi Anda.</p>
</div>

<!-- Report Categories -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Task Reports -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tasks text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-medium text-gray-900">Laporan Tugas</h3>
                    <p class="text-sm text-gray-600">Lihat tingkat penyelesaian tugas, metrik kinerja, dan analitik produktivitas.</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.reports.tasks') }}" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Lihat Laporan Tugas
                </a>
            </div>
        </div>
    </div>

    <!-- Attendance Reports -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-medium text-gray-900">Laporan Absensi</h3>
                    <p class="text-sm text-gray-600">Monitor pola absensi karyawan, jam kerja, dan ketepatan waktu.</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.reports.attendance') }}" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Lihat Laporan Absensi
                </a>
            </div>
        </div>
    </div>

    <!-- Emergency Reports -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-medium text-gray-900">Laporan Darurat</h3>
                    <p class="text-sm text-gray-600">Analisis insiden darurat, waktu respons, dan pola penyelesaian.</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.reports.emergency') }}" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Lihat Laporan Darurat
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Overview -->
<div class="mt-12">
    <h2 class="text-lg font-medium text-gray-900 mb-6">Ikhtisar Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tugas Selesai Hari Ini</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Task::whereDate('completed_at', today())->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Karyawan Hadir</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ \App\Models\Attendance::whereDate('date', today())->distinct('user_id')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Darurat Tertunda</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ \App\Models\EmergencyReport::where('status', 'pending')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-percentage text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                                                <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tingkat Penyelesaian</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                @php
                                    $totalTasks = \App\Models\Task::whereDate('assigned_date', today())->count();
                                    $rate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                                @endphp
                                {{ $rate }}%
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-12">
    <h2 class="text-lg font-medium text-gray-900 mb-6">Aktivitas Terbaru</h2>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @php
                $recentTasks = \App\Models\Task::with('user')->where('status', 'completed')->latest('completed_at')->take(5)->get();
            @endphp
            @forelse($recentTasks as $task)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                                <p class="text-sm text-gray-500">Diselesaikan oleh {{ $task->user->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $task->completed_at->diffForHumans() }}
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500">
                    Tidak ada tugas yang baru diselesaikan
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
