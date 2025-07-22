@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pengguna</h1>
            <p class="mt-2 text-gray-600">Informasi lengkap pengguna</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="btn-primary inline-flex items-center px-4 py-2 text-white font-medium rounded-xl shadow-sm hover:shadow-lg transition-all">
                <i class="fas fa-edit mr-2"></i>
                Edit Pengguna
            </a>
        </div>
    </div>
</div>

<!-- User Profile Card -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Profile Info -->
    <div class="lg:col-span-2">
        <div class="card-modern p-8">
            <div class="flex items-center mb-8">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                    <span class="inline-flex mt-2 px-3 py-1 text-sm font-medium rounded-full {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ $user->role === 'admin' ? 'Administrator' : 'Karyawan' }}
                    </span>
                </div>
            </div>

            <!-- User Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Nama Lengkap</label>
                    <p class="text-lg font-medium text-gray-900">{{ $user->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Email</label>
                    <p class="text-lg text-gray-900">{{ $user->email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Kode Karyawan</label>
                    <p class="text-lg text-gray-900">{{ $user->employee_code ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Role</label>
                    <p class="text-lg text-gray-900">{{ $user->role === 'admin' ? 'Administrator' : 'Karyawan' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Nomor Telepon</label>
                    <p class="text-lg text-gray-900">{{ $user->phone_number ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Bergabung</label>
                    <p class="text-lg text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats & Activity -->
    <div class="space-y-6">
        <!-- Stats Card -->
        <div class="card-modern p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik</h3>
            
            @if($user->role === 'user')
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tasks text-blue-600 text-sm"></i>
                        </div>
                        <span class="ml-3 text-sm text-gray-600">Total Tugas</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">{{ $user->tasks()->count() }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                        </div>
                        <span class="ml-3 text-sm text-gray-600">Tugas Selesai</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">{{ $user->tasks()->where('status', 'completed')->count() }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-sm"></i>
                        </div>
                        <span class="ml-3 text-sm text-gray-600">Absensi Bulan Ini</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">{{ $user->attendances()->whereMonth('date', now()->month)->count() }}</span>
                </div>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-user-shield text-blue-600 text-3xl mb-2"></i>
                <p class="text-sm text-gray-600">Administrator</p>
            </div>
            @endif
        </div>

        <!-- Account Status -->
        <div class="card-modern p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Status Akun</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Status</span>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                        Aktif
                    </span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Terakhir Login</span>
                    <span class="text-sm text-gray-900">
                        {{ $user->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card-modern p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Pengguna
                </a>
                
                @if($user->role === 'user')
                <a href="{{ route('admin.tasks.index', ['user' => $user->id]) }}" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-all">
                    <i class="fas fa-tasks mr-2"></i>
                    Lihat Tugas
                </a>
                
                <a href="{{ route('admin.attendance.index', ['user' => $user->id]) }}" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-all">
                    <i class="fas fa-clock mr-2"></i>
                    Lihat Absensi
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if($user->role === 'user')
<!-- Recent Activity -->
<div class="mt-8">
    <div class="card-modern p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Aktivitas Terbaru</h3>
        
        @php
            $recentTasks = $user->tasks()->latest('updated_at')->take(5)->get();
            $recentAttendance = $user->attendances()->latest('date')->take(5)->get();
        @endphp
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Tasks -->
            <div>
                <h4 class="text-md font-medium text-gray-900 mb-4">Tugas Terbaru</h4>
                @forelse($recentTasks as $task)
                    <div class="flex items-center py-3 border-b border-gray-100 last:border-0">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $task->status === 'completed' ? 'bg-green-100' : ($task->status === 'in_progress' ? 'bg-yellow-100' : 'bg-gray-100') }}">
                            <i class="fas {{ $task->status === 'completed' ? 'fa-check text-green-600' : ($task->status === 'in_progress' ? 'fa-clock text-yellow-600' : 'fa-circle text-gray-600') }} text-sm"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                            <p class="text-xs text-gray-500">{{ $task->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada tugas</p>
                @endforelse
            </div>

            <!-- Recent Attendance -->
            <div>
                <h4 class="text-md font-medium text-gray-900 mb-4">Absensi Terbaru</h4>
                @forelse($recentAttendance as $attendance)
                    <div class="flex items-center py-3 border-b border-gray-100 last:border-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-600 text-sm"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $attendance->date->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">
                                Masuk: {{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}
                                @if($attendance->check_out)
                                    | Keluar: {{ $attendance->check_out->format('H:i') }}
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada absensi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endif
@endsection
