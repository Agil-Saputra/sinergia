<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absensi - Sinergia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827;
            color: #d1d5db;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Header -->
        <div class="bg-gray-800 border-b border-gray-700 px-4 py-4">
            <div class="max-w-4xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto"
                         onerror="this.onerror=null; this.src='https://placehold.co/40x40/111827/FFFFFF?text=S&font=inter';">
                    <div>
                        <h1 class="text-xl font-bold text-white">Riwayat Absensi</h1>
                        <p class="text-sm text-gray-400">{{ Auth::user()->name }} - {{ Auth::user()->employee_code }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('attendance.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 transition-colors">
                        ← Kembali
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-500 transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Attendance History -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                <h2 class="text-xl font-bold text-white mb-6">Riwayat Absensi</h2>
                
                @if($attendances->count() > 0)
                    <div class="space-y-4">
                        @foreach($attendances as $attendance)
                        <div class="bg-gray-700 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <div class="font-semibold text-white text-lg">
                                        {{ Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-400">
                                        {{ Carbon\Carbon::parse($attendance->date)->format('l') }}
                                    </div>
                                    @if($attendance->date->isToday())
                                        <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full">Hari Ini</span>
                                    @elseif($attendance->date->isYesterday())
                                        <span class="text-xs bg-gray-600 text-white px-2 py-1 rounded-full">Kemarin</span>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-400">Masuk:</span>
                                        <span class="text-white ml-1">
                                            @if($attendance->check_in)
                                                {{ Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                                            @else
                                                <span class="text-red-400">Belum check-in</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <span class="text-gray-400">Pulang:</span>
                                        <span class="text-white ml-1">
                                            @if($attendance->check_out)
                                                {{ Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                                            @else
                                                <span class="text-yellow-400">Belum check-out</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <span class="text-gray-400">Durasi:</span>
                                        <span class="text-white ml-1">
                                            @if($attendance->work_duration)
                                                {{ number_format($attendance->work_duration, 1) }} jam
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                @if($attendance->location)
                                <div class="mt-2 text-sm">
                                    <span class="text-gray-400">Lokasi:</span>
                                    <span class="text-white ml-1">{{ $attendance->location }}</span>
                                </div>
                                @endif
                                
                                @if($attendance->notes)
                                <div class="mt-2 text-sm">
                                    <span class="text-gray-400">Catatan:</span>
                                    <span class="text-white ml-1">{{ $attendance->notes }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <div class="ml-4 text-right">
                                @if($attendance->status == 'present')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-900/50 text-green-300 border border-green-600">
                                        ✓ Hadir
                                    </span>
                                @elseif($attendance->status == 'late')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-900/50 text-yellow-300 border border-yellow-600">
                                        ⚠ Terlambat
                                    </span>
                                @elseif($attendance->status == 'early_leave')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-orange-900/50 text-orange-300 border border-orange-600">
                                        ⚡ Pulang Cepat
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-900/50 text-gray-300 border border-gray-600">
                                        ⚪ {{ ucfirst($attendance->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $attendances->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl text-gray-600 mb-4">📋</div>
                        <h3 class="text-xl font-medium text-gray-300 mb-2">Belum Ada Riwayat Absensi</h3>
                        <p class="text-gray-400 mb-6">Mulai lakukan absensi untuk melihat riwayat Anda di sini.</p>
                        <a href="{{ route('attendance.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 transition-colors">
                            Mulai Absensi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
