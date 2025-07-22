@extends('layouts.mobile')

@section('title', 'Absensi - Sinergia')

@section('header', 'Sistem Absensi')

@section('content')
<div class="p-4 space-y-6">
    <!-- Current Time -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="text-center mb-4">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-clock text-white text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-blue-800 mb-2">Waktu Saat Ini</h2>
            <p class="text-sm text-blue-700">Pantau waktu kerja Anda hari ini</p>
        </div>
        <div class="text-center">
            <div class="text-2xl font-bold text-gray-800 font-mono" id="currentTime"></div>
            <p class="text-gray-600 mt-1" id="currentDate"></p>
        </div>
    </div>

    <!-- Today's Attendance Status -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Status Absensi Hari Ini</h2>
        </div>
        
        @if($todayAttendance)
        <div class="space-y-4">
            <!-- Check In Status -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                        1
                    </div>
                    <label class="text-lg font-semibold text-gray-800">Masuk Kerja</label>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-base text-gray-600">{{ Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }}</p>
                    </div>
                    <div>
                        @if($todayAttendance->status == 'late')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                Terlambat
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Tepat Waktu
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Check Out Status -->
            @if($todayAttendance->check_out)
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                        2
                    </div>
                    <label class="text-lg font-semibold text-gray-800">Pulang Kerja</label>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-base text-gray-600">{{ Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') }}</p>
                    </div>
                    <div>
                        @if($todayAttendance->work_duration)
                            <p class="text-gray-700 text-sm font-medium">
                                {{ number_format($todayAttendance->work_duration, 1) }} jam
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <!-- Check Out Button -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                        2
                    </div>
                    <label class="text-lg font-semibold text-gray-800">Pulang Kerja</label>
                </div>
                <form method="POST" action="{{ route('attendance.checkout') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Akhir Kerja</label>
                        <input type="text" name="notes" placeholder="Area sudah bersih, peralatan tersimpan..." 
                               class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-red-500">
                    </div>
                    <button type="submit" class="w-full bg-red-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 shadow-lg">
                        PULANG KERJA
                    </button>
                </form>
            </div>
            @endif
            
        </div>
        @else
        <!-- No attendance yet -->
        <div class="text-center py-8">
            <div class="text-4xl text-gray-400 mb-3">
                <i class="fas fa-clock"></i>
            </div>
            <p class="text-gray-600 text-lg font-medium mb-2">Belum ada absensi hari ini</p>
            <p class="text-gray-500">Login ulang untuk melakukan check-in otomatis</p>
        </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Statistik Bulan Ini</h2>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <div class="flex items-center justify-center mb-2">
                    <span class="text-xs text-gray-600 font-medium">Total Hari</span>
                </div>
                <div class="text-2xl font-bold text-blue-600">{{ $stats['total_days'] }}</div>
            </div>
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <div class="flex items-center justify-center mb-2">
                    <span class="text-xs text-gray-600 font-medium">Hadir</span>
                </div>
                <div class="text-2xl font-bold text-green-600">{{ $stats['present_days'] }}</div>
            </div>
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <div class="flex items-center justify-center mb-2">
                    <span class="text-xs text-gray-600 font-medium">Terlambat</span>
                </div>
                <div class="text-2xl font-bold text-orange-600">{{ $stats['late_days'] }}</div>
            </div>
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <div class="flex items-center justify-center mb-2">
                    <span class="text-xs text-gray-600 font-medium">Total Jam</span>
                </div>
                <div class="text-2xl font-bold text-purple-600">{{ number_format($stats['total_hours'], 1) }}</div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    @if($recentAttendances->count() > 0)
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h2>
        </div>
        <div class="space-y-3">
            @foreach($recentAttendances->take(3) as $attendance)
            <div class="border-2 border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="font-medium text-gray-800 text-sm">
                        {{ Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                        @if($attendance->date->isToday())
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                Hari Ini
                            </span>
                        @endif
                    </div>
                    <div class="text-right">
                        @if($attendance->status == 'present')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Hadir
                            </span>
                        @elseif($attendance->status == 'late')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                Terlambat
                            </span>
                        @elseif($attendance->status == 'early_leave')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Pulang Cepat
                            </span>
                        @endif
                    </div>
                </div>
                <div class="text-xs text-gray-600">
                    @if($attendance->check_in)
                        Masuk: {{ Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                    @endif
                    @if($attendance->check_out)
                        | Pulang: {{ Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                    @endif
                    @if($attendance->location)
                        | {{ $attendance->location }}
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('attendance.history') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                Lihat Semua Riwayat
            </a>
        </div>
    </div>
    @endif
</div>

<script>
    function updateClock() {
        const now = new Date();
        
        // Get Jakarta time specifically
        const jakartaTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Jakarta"}));
        
        const timeString = jakartaTime.toLocaleTimeString('id-ID', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        const dateString = jakartaTime.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        document.getElementById('currentTime').textContent = timeString;
        document.getElementById('currentDate').textContent = dateString;
    }
    
    // Update clock every second
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection
