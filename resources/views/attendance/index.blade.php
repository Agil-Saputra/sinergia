@extends('layouts.mobile')

@section('title', 'Absensi - Sinergia')

@section('header', 'Sistem Absensi')

@section('content')
<div class="p-4">
    <!-- Current Time -->
    <div class="text-center mb-6">
        <div class="text-2xl font-bold text-gray-800 font-mono" id="currentTime"></div>
        <p class="text-gray-600 mt-1 text-sm" id="currentDate"></p>
        <p class="text-xs text-gray-500 mt-1">Server Time: {{ now()->setTimezone('Asia/Jakarta')->format('H:i:s d/m/Y') }}</p>
    </div>

    <!-- Today's Attendance Status -->
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 text-center">Status Absensi Hari Ini</h2>
        
        @if($todayAttendance)
        <div class="space-y-4">
            <!-- Check In Status -->
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                <div class="flex items-center space-x-3">
                    <div class="text-green-600 text-2xl">✓</div>
                    <div>
                        <p class="text-gray-800 font-medium">Masuk Kerja</p>
                        <p class="text-gray-600 text-sm">{{ Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    @if($todayAttendance->status == 'late')
                        <span class="text-orange-600 text-xs bg-orange-100 px-2 py-1 rounded">Terlambat</span>
                    @else
                        <span class="text-green-600 text-xs bg-green-100 px-2 py-1 rounded">Tepat Waktu</span>
                    @endif
                </div>
            </div>
            
            <!-- Check Out Status -->
            @if($todayAttendance->check_out)
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                <div class="flex items-center space-x-3">
                    <div class="text-red-600 text-2xl">✗</div>
                    <div>
                        <p class="text-gray-800 font-medium">Pulang Kerja</p>
                        <p class="text-gray-600 text-sm">{{ Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    @if($todayAttendance->work_duration)
                        <p class="text-gray-700 text-sm font-medium">{{ number_format($todayAttendance->work_duration, 1) }} jam</p>
                    @endif
                </div>
            </div>
            @else
            <!-- Check Out Button -->
            <div class="p-3 bg-gray-50 rounded-lg border">
                <form method="POST" action="{{ route('attendance.checkout') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Akhir Kerja</label>
                        <input type="text" name="notes" placeholder="Area sudah bersih, peralatan tersimpan..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-800 placeholder-gray-500 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-bold text-lg hover:bg-red-700 transition-colors">
                        ✗ PULANG KERJA
                    </button>
                </form>
            </div>
            @endif
            
            <!-- Location and Notes -->
            @if($todayAttendance->location)
            <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-gray-600 text-sm">Lokasi: <span class="text-gray-800 font-medium">{{ $todayAttendance->location }}</span></p>
                @if($todayAttendance->notes)
                    <p class="text-gray-600 text-sm mt-1">Catatan: <span class="text-gray-800">{{ $todayAttendance->notes }}</span></p>
                @endif
            </div>
            @endif
        </div>
        @else
        <!-- No attendance yet -->
        <div class="text-center py-8">
            <div class="text-4xl text-gray-400 mb-3">⏰</div>
            <p class="text-gray-600">Belum ada absensi hari ini</p>
            <p class="text-gray-500 text-sm">Login ulang untuk melakukan check-in otomatis</p>
        </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Statistik Bulan Ini</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['total_days'] }}</div>
                <div class="text-xs text-gray-600">Total Hari</div>
            </div>
            <div class="text-center p-3 bg-green-50 rounded-lg border border-green-200">
                <div class="text-2xl font-bold text-green-600">{{ $stats['present_days'] }}</div>
                <div class="text-xs text-gray-600">Hadir</div>
            </div>
            <div class="text-center p-3 bg-orange-50 rounded-lg border border-orange-200">
                <div class="text-2xl font-bold text-orange-600">{{ $stats['late_days'] }}</div>
                <div class="text-xs text-gray-600">Terlambat</div>
            </div>
            <div class="text-center p-3 bg-purple-50 rounded-lg border border-purple-200">
                <div class="text-2xl font-bold text-purple-600">{{ number_format($stats['total_hours'], 1) }}</div>
                <div class="text-xs text-gray-600">Total Jam</div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    @if($recentAttendances->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border p-4">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terbaru</h2>
        <div class="space-y-3">
            @foreach($recentAttendances->take(3) as $attendance)
            <div class="p-3 bg-gray-50 rounded-lg border">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-medium text-gray-800 text-sm">
                        {{ Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                        @if($attendance->date->isToday())
                            <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full ml-2">Hari Ini</span>
                        @endif
                    </div>
                    <div class="text-right">
                        @if($attendance->status == 'present')
                            <span class="text-green-600 text-xs">✓ Hadir</span>
                        @elseif($attendance->status == 'late')
                            <span class="text-orange-600 text-xs">⚠ Terlambat</span>
                        @elseif($attendance->status == 'early_leave')
                            <span class="text-red-600 text-xs">⚡ Pulang Cepat</span>
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
            <a href="{{ route('attendance.history') }}" class="text-blue-600 text-sm hover:text-blue-700 font-medium">
                Lihat Semua Riwayat →
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
