@extends('layouts.mobile')

@section('title', 'Riwayat Absensi - Sinergia')

@section('header')
<div class="flex items-center justify-between w-full">
    <span>Riwayat Absensi</span>
    <a href="{{ route('attendance.index') }}" class="text-blue-600 text-sm font-medium">
        ← Kembali
    </a>
</div>
@endsection

@section('content')
<div class="p-4">
    @if($attendances->count() > 0)
        <div class="space-y-4">
            @foreach($attendances as $attendance)
            <div class="bg-white rounded-lg shadow-sm border p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <div class="font-semibold text-gray-800 text-lg">
                            {{ Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ Carbon\Carbon::parse($attendance->date)->format('l') }}
                        </div>
                    </div>
                    <div class="text-right">
                        @if($attendance->date->isToday())
                            <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full">Hari Ini</span>
                        @elseif($attendance->date->isYesterday())
                            <span class="text-xs bg-gray-600 text-white px-2 py-1 rounded-full">Kemarin</span>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-3 text-sm mb-3">
                    <div class="flex justify-between items-center p-2 bg-green-50 rounded border border-green-200">
                        <span class="text-gray-600">Masuk:</span>
                        <span class="text-gray-800 font-medium">
                            @if($attendance->check_in)
                                {{ Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                            @else
                                <span class="text-red-600">Belum check-in</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center p-2 bg-red-50 rounded border border-red-200">
                        <span class="text-gray-600">Pulang:</span>
                        <span class="text-gray-800 font-medium">
                            @if($attendance->check_out)
                                {{ Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                            @else
                                <span class="text-orange-600">Belum check-out</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center p-2 bg-blue-50 rounded border border-blue-200">
                        <span class="text-gray-600">Durasi:</span>
                        <span class="text-gray-800 font-medium">
                            @if($attendance->work_duration)
                                {{ number_format($attendance->work_duration, 1) }} jam
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </span>
                    </div>
                </div>
                
                @if($attendance->location)
                <div class="mb-2 text-sm">
                    <span class="text-gray-600">Lokasi:</span>
                    <span class="text-gray-800 ml-1 font-medium">{{ $attendance->location }}</span>
                </div>
                @endif
                
                @if($attendance->notes)
                <div class="mb-2 text-sm">
                    <span class="text-gray-600">Catatan:</span>
                    <span class="text-gray-800 ml-1">{{ $attendance->notes }}</span>
                </div>
                @endif
                
                <div class="mt-3 flex justify-end">
                    @if($attendance->status == 'present')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 border border-green-200">
                            ✓ Hadir
                        </span>
                    @elseif($attendance->status == 'late')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800 border border-orange-200">
                            ⚠ Terlambat
                        </span>
                    @elseif($attendance->status == 'early_leave')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-red-100 text-red-800 border border-red-200">
                            ⚡ Pulang Cepat
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-800 border border-gray-200">
                            ⚪ {{ ucfirst($attendance->status) }}
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $attendances->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl text-gray-400 mb-4">📋</div>
            <h3 class="text-xl font-medium text-gray-700 mb-2">Belum Ada Riwayat Absensi</h3>
            <p class="text-gray-500 mb-6">Mulai lakukan absensi untuk melihat riwayat Anda di sini.</p>
            <a href="{{ route('attendance.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Mulai Absensi
            </a>
        </div>
    @endif
</div>
@endsection
