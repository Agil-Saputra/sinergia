@extends('layouts.mobile')

@section('title', 'Detail Tugas - Sinergia')
@section('header', 'Detail Tugas')

@section('content')
<div class="p-4 space-y-4">
    <!-- Header Tugas -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="flex justify-between items-start mb-3">
            <h1 class="text-xl font-bold text-gray-800 {{ $task->status == 'completed' ? 'line-through text-gray-500' : '' }}">
                {{ $task->title }}
            </h1>
            <span class="text-xs px-3 py-1 rounded-full {{ $task->status_color }}">
                @if($task->status == 'todo')
                    ⏳ Belum Mulai
                @elseif($task->status == 'in_progress')
                    ⚡ Sedang Dikerjakan
                @else
                    ✅ Selesai
                @endif
            </span>
        </div>
        
        <p class="text-gray-600 mb-4">{{ $task->description }}</p>
        
        <!-- Info Detail -->
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-500">📅 Ditugaskan:</span>
                <p class="font-medium">
                    {{ $task->assigned_date->format('d M Y') }}
                </p>
            </div>
            <div>
                <span class="text-gray-500">⚡ Prioritas:</span>
                <p class="font-medium">
                    <span class="px-2 py-1 rounded-full text-xs {{ $task->priority_color }}">
                        {{ $task->priority == 'high' ? '🔴 Penting' : ($task->priority == 'medium' ? '🟡 Sedang' : '🟢 Rendah') }}
                    </span>
                </p>
            </div>
            @if($task->category)
            <div>
                <span class="text-gray-500">🏷️ Kategori:</span>
                <p class="font-medium">{{ ucfirst($task->category) }}</p>
            </div>
            @endif
            @if($task->estimated_time)
            <div>
                <span class="text-gray-500">⏱️ Estimasi:</span>
                <p class="font-medium">{{ $task->estimated_time }} jam</p>
            </div>
            @endif
            @if($task->started_at)
            <div>
                <span class="text-gray-500">▶️ Mulai:</span>
                <p class="font-medium">{{ $task->started_at->format('H:i') }}</p>
            </div>
            @endif
        </div>
    </div>

    @if($task->status == 'completed')
    <!-- Informasi Penyelesaian -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <h3 class="font-bold text-green-800 mb-3 flex items-center">
            ✅ Tugas Selesai
        </h3>
        
        <div class="space-y-3">
            <div>
                <span class="text-sm text-green-700 font-medium">📅 Diselesaikan pada:</span>
                <p class="text-green-800 font-bold">
                    {{ $task->completed_at->format('d M Y, H:i') }}
                </p>
            </div>
            
            @if($task->completion_notes)
            <div>
                <span class="text-sm text-green-700 font-medium">📝 Catatan:</span>
                <p class="text-green-800 bg-white p-3 rounded-lg border border-green-200 mt-1">
                    {{ $task->completion_notes }}
                </p>
            </div>
            @endif
            
            @if($task->proof_image)
            <div>
                <span class="text-sm text-green-700 font-medium">📷 Bukti Pekerjaan:</span>
                <div class="mt-2">
                    <img src="{{ Storage::url($task->proof_image) }}" 
                         alt="Bukti penyelesaian tugas" 
                         class="w-full max-w-md rounded-lg border border-green-200 cursor-pointer"
                         onclick="openImageModal('{{ Storage::url($task->proof_image) }}')">
                    <p class="text-xs text-green-600 mt-1">Tap untuk melihat lebih besar</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <!-- Tombol Aksi untuk Tugas Belum Selesai -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-3">🎯 Aksi Tugas</h3>
        
        <div class="space-y-3">
            @if($task->status == 'in_progress')
                <button onclick="openCompleteModal()" 
                        class="w-full bg-green-500 text-white py-4 px-4 rounded-lg font-bold text-xl">
                    ✅ SELESAIKAN TUGAS
                </button>
                @if($task->started_at)
                <p class="text-center text-sm text-gray-600">
                    Dimulai jam {{ $task->started_at->format('H:i') }}
                </p>
                @endif
            @elseif($task->status == 'assigned')
                <div class="text-center py-4">
                    <p class="text-gray-600 mb-2">Tugas akan otomatis dimulai setelah Anda melakukan check-in</p>
                    <span class="px-4 py-2 bg-gray-100 rounded-lg text-sm">📋 Menunggu Check-in</span>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tombol Kembali -->
    <div class="pt-4">
        <a href="{{ route('user.tasks') }}" 
           class="block w-full bg-gray-200 text-gray-800 py-3 px-4 rounded-lg text-center font-medium">
            ← Kembali ke Daftar Tugas
        </a>
    </div>
</div>

@if($task->status != 'completed')
<!-- Modal Selesaikan Tugas -->
<div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">✅ Selesaikan Tugas</h3>
            
            <form method="POST" action="{{ route('user.tasks.complete', $task) }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Catatan Penyelesaian -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📝 Catatan Penyelesaian</label>
                    <textarea name="completion_notes" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                              placeholder="Tulis hasil pekerjaan atau catatan..."></textarea>
                </div>

                <!-- Upload Bukti -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📷 Foto Bukti Pekerjaan</label>
                    <input type="file" name="proof_image" accept="image/*" capture="environment" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-xs text-gray-500 mt-1">Upload foto hasil pekerjaan sebagai bukti</p>
                </div>

                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button type="button" onclick="closeCompleteModal()" 
                            class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-green-500 text-white py-2 px-4 rounded-lg font-medium">
                        ✅ Selesaikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if($task->proof_image)
<!-- Modal Image Viewer -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeImageModal()" 
                    class="absolute top-4 right-4 bg-white text-black rounded-full w-10 h-10 flex items-center justify-center font-bold z-10">
                ✕
            </button>
            <img id="modalImage" src="" alt="Bukti penyelesaian tugas" class="w-full h-auto rounded-lg">
        </div>
    </div>
</div>
@endif

<script>
function updateStatus(taskId, status) {
    fetch(`/user/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

function openCompleteModal() {
    document.getElementById('completeModal').classList.remove('hidden');
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
}

function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modals when clicking outside
document.getElementById('completeModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCompleteModal();
    }
});

document.getElementById('imageModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection
