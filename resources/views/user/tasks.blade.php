@extends('layouts.mobile')

@section('title', 'Tugas Hari Ini - Sinergia')
@section('header', 'Tugas Hari Ini')

@section('content')
<div class="p-4 space-y-4">
    <!-- Header -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">� Daftar Tugas</h2>
            <div class="text-sm text-gray-600">
                {{ now()->format('d M Y') }}
            </div>
        </div>

        <!-- Filter Simple -->
        <div class="flex space-x-2">
            <a href="{{ route('user.tasks') }}" 
               class="px-3 py-2 rounded-lg text-sm font-medium {{ !request('status') || request('status') == 'all' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                📋 Semua
            </a>
            <a href="{{ route('user.tasks', ['status' => 'in_progress']) }}" 
               class="px-3 py-2 rounded-lg text-sm font-medium {{ request('status') == 'in_progress' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                ⚡ Dikerjakan
            </a>
            <a href="{{ route('user.tasks', ['status' => 'completed']) }}" 
               class="px-3 py-2 rounded-lg text-sm font-medium {{ request('status') == 'completed' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                ✅ Selesai
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tugas Hari Ini -->
    @php
        $todayTasks = $tasks->filter(function($task) {
            return $task->assigned_date->isToday();
        });
        $otherTasks = $tasks->filter(function($task) {
            return !$task->assigned_date->isToday();
        });
    @endphp

    @if($todayTasks->count() > 0)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="font-bold text-blue-800 mb-3 flex items-center">
            🌟 Tugas Hari Ini ({{ $todayTasks->count() }})
        </h3>
        <div class="space-y-3">
            @foreach($todayTasks as $task)
            <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 
                        {{ $task->priority == 'high' ? 'border-red-500' : ($task->priority == 'medium' ? 'border-yellow-500' : 'border-green-500') }}">
                
                <!-- Header Task -->
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 {{ $task->status == 'completed' ? 'line-through text-gray-500' : '' }}">
                            {{ $task->title }}
                        </h4>
                        <p class="text-gray-600 text-sm mt-1">{{ $task->description }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $task->priority_color }}">
                        {{ $task->priority == 'high' ? '🔴' : ($task->priority == 'medium' ? '🟡' : '🟢') }}
                    </span>
                </div>

                <!-- Status dan Waktu -->
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs px-3 py-1 rounded-full {{ $task->status_color }}">
                        {{ $task->status_text }}
                    </span>
                    @if($task->status == 'completed')
                        <span class="text-sm text-green-600 font-medium">
                            ⏰ Selesai jam {{ $task->completed_at->format('H:i') }}
                        </span>
                    @elseif($task->status == 'in_progress' && $task->started_at)
                        <span class="text-sm text-blue-600">
                            ⏰ Mulai jam {{ $task->started_at->format('H:i') }}
                        </span>
                    @endif
                </div>

                <!-- Tombol Selesai -->
                @if($task->status == 'in_progress')
                <button onclick="openCompleteModal({{ $task->id }})" 
                        class="w-full bg-green-500 text-white py-3 px-4 rounded-lg font-bold text-lg">
                    ✅ SELESAI
                </button>
                @elseif($task->status == 'completed')
                <a href="{{ route('user.tasks.show', $task) }}" 
                   class="block w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium text-center">
                    👁️ Lihat Bukti
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Tugas Lainnya -->
    @if($otherTasks->count() > 0)
    <div class="space-y-3">
        <h3 class="font-bold text-gray-800">📅 Tugas Lainnya</h3>
        @foreach($otherTasks as $task)
        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-gray-300">
            
            <!-- Header Task -->
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800 {{ $task->status == 'completed' ? 'line-through text-gray-500' : '' }}">
                        {{ $task->title }}
                    </h4>
                    <p class="text-gray-600 text-sm mt-1">{{ $task->description }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $task->priority_color }}">
                    {{ $task->priority == 'high' ? '🔴' : ($task->priority == 'medium' ? '🟡' : '🟢') }}
                </span>
            </div>

            <!-- Info -->
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">
                    📅 {{ $task->assigned_date->format('d M Y') }}
                </span>
                <span class="text-xs px-2 py-1 rounded-full {{ $task->status_color }}">
                    {{ $task->status_text }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($tasks->count() == 0)
    <div class="bg-white rounded-lg p-8 text-center shadow-sm">
        <div class="text-6xl mb-4">🎉</div>
        <h3 class="text-lg font-medium text-gray-600 mb-2">Tidak ada tugas</h3>
        <p class="text-gray-500">Selamat! Anda tidak memiliki tugas saat ini</p>
    </div>
    @endif

    <!-- Ringkasan Progress -->
    @if($tasks->count() > 0)
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-3">📊 Ringkasan Hari Ini</h3>
        @php
            $todayCompleted = $todayTasks->where('status', 'completed')->count();
            $todayTotal = $todayTasks->count();
            $percentage = $todayTotal > 0 ? ($todayCompleted / $todayTotal) * 100 : 0;
        @endphp
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $todayTasks->where('status', 'in_progress')->count() }}</div>
                <div class="text-xs text-gray-600">Sedang Dikerjakan</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $todayCompleted }}</div>
                <div class="text-xs text-gray-600">Sudah Selesai</div>
            </div>
        </div>
        
        @if($todayTotal > 0)
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span>Progress Hari Ini</span>
                <span>{{ $todayCompleted }}/{{ $todayTotal }} ({{ number_format($percentage, 0) }}%)</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-green-500 h-3 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>

<!-- Modal Selesaikan Tugas -->
<div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">✅ Selesaikan Tugas</h3>
            
            <form id="completeForm" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Catatan Penyelesaian -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📝 Catatan Hasil Pekerjaan</label>
                    <textarea name="completion_notes" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                              placeholder="Tulis hasil pekerjaan yang sudah diselesaikan..."></textarea>
                </div>

                <!-- Upload Bukti -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📷 Foto Bukti Pekerjaan</label>
                    <input type="file" name="proof_image" accept="image/*" capture="environment" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-xs text-gray-500 mt-1">Ambil foto hasil pekerjaan sebagai bukti</p>
                </div>

                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button type="button" onclick="closeCompleteModal()" 
                            class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-green-500 text-white py-2 px-4 rounded-lg font-medium">
                        ✅ Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCompleteModal(taskId) {
    document.getElementById('completeForm').action = `/user/tasks/${taskId}/complete`;
    document.getElementById('completeModal').classList.remove('hidden');
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('completeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCompleteModal();
    }
});
</script>
@endsection
