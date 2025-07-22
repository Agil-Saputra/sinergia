@extends('layouts.mobile')

@section('title', 'Detail Tugas - Sinergia')
@section('header', 'DETAIL TUGAS')

@section('content')
<div class="p-4 space-y-6">
    <!-- Header Tugas -->
    <div class="bg-blue-50 border-2 border-blue-300 rounded-xl p-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-tasks text-white text-2xl"></i>
            </div>
            <h1 class="text-xl font-bold text-blue-800 mb-2 {{ $task->status == 'completed' ? 'line-through text-gray-500' : '' }}">
                {{ $task->title }}
            </h1>
            <span class="text-sm px-3 py-1 rounded-full font-medium {{ $task->status_color }}">
                @if($task->status == 'todo')
                    <i class="fas fa-clock mr-1"></i>Belum Mulai
                @elseif($task->status == 'in_progress')
                    <i class="fas fa-spinner mr-1"></i>Sedang Dikerjakan
                @else
                    <i class="fas fa-check-circle mr-1"></i>Sudah Selesai
                @endif
            </span>
        </div>
        
        <div class="bg-white rounded-lg p-4 border-2 border-gray-200 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 text-center">
                <i class="fas fa-file-alt mr-2"></i>Penjelasan Tugas
            </h3>
            <p class="text-base text-gray-600 leading-relaxed text-center">{{ $task->description }}</p>
        </div>
        
        <!-- Info Detail dengan Card -->
        <div class="grid grid-cols-1 gap-4">
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <span class="text-sm text-gray-700 font-medium block mb-2">
                    <i class="fas fa-calendar mr-1"></i>Tanggal Ditugaskan
                </span>
                <p class="text-lg font-bold text-gray-800">
                    {{ $task->assigned_date->format('d M Y') }}
                </p>
            </div>
            
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <span class="text-sm text-gray-700 font-medium block mb-2">
                    <i class="fas fa-exclamation-circle mr-1"></i>Tingkat Penting
                </span>
                <p class="text-base font-medium">
                    <span class="px-3 py-1 rounded-full {{ $task->priority_color }}">
                        <div class="w-3 h-3 rounded-full inline-block mr-2 {{ $task->priority == 'high' ? 'bg-red-500' : ($task->priority == 'medium' ? 'bg-orange-500' : 'bg-yellow-500') }}"></div>
                        {{ $task->priority == 'high' ? 'Sangat Penting' : ($task->priority == 'medium' ? 'Penting' : 'Biasa') }}
                    </span>
                </p>
            </div>
            
            @if($task->category)
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <span class="text-sm text-gray-700 font-medium block mb-2">
                    <i class="fas fa-tag mr-1"></i>Kategori
                </span>
                <p class="text-lg font-bold text-gray-800">{{ $task->category }}</p>
            </div>
            @endif
            
            @if($task->estimated_time)
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <span class="text-sm text-gray-700 font-medium block mb-2">
                    <i class="fas fa-clock mr-1"></i>Perkiraan Waktu
                </span>
                <p class="text-lg font-bold text-gray-800">{{ $task->estimated_time }} Jam</p>
            </div>
            @endif
            
            @if($task->started_at)
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 text-center">
                <span class="text-sm text-gray-700 font-medium block mb-2">
                    <i class="fas fa-play mr-1"></i>Waktu Mulai
                </span>
                <p class="text-lg font-bold text-gray-800">{{ $task->started_at->format('H:i') }}</p>
            </div>
            @endif
        </div>
    </div>

    @if($task->status == 'completed')
    <!-- Informasi Penyelesaian -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-green-800 mb-4 text-center flex items-center justify-center">
            <i class="fas fa-check-circle mr-2"></i>Tugas Sudah Selesai
        </h3>
        
        <div class="space-y-4">
            <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center">
                <span class="text-sm text-green-700 font-medium block mb-2">
                    <i class="fas fa-calendar-check mr-1"></i>Waktu Selesai
                </span>
                <p class="text-lg text-green-800 font-bold">
                    {{ $task->completed_at->format('d M Y, H:i') }}
                </p>
            </div>
            
            @if($task->completion_notes)
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <span class="text-sm text-gray-700 font-medium block mb-3 text-center">
                    <i class="fas fa-sticky-note mr-1"></i>Catatan Hasil Kerja
                </span>
                <p class="text-base text-gray-800 bg-white p-4 rounded-lg border border-gray-200 leading-relaxed text-center">
                    {{ $task->completion_notes }}
                </p>
            </div>
            @endif
            
            @if($task->proof_image)
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <span class="text-sm text-gray-700 font-medium block mb-3 text-center">
                    <i class="fas fa-camera mr-1"></i>Foto Bukti Pekerjaan
                </span>
                <div class="text-center">
                    <img src="{{ Storage::url($task->proof_image) }}" 
                         alt="Bukti penyelesaian tugas" 
                         class="w-full max-w-md mx-auto rounded-lg border border-gray-200 cursor-pointer shadow-md"
                         onclick="openImageModal('{{ Storage::url($task->proof_image) }}')">
                    <p class="text-sm text-blue-600 mt-3 font-medium">
                        <i class="fas fa-expand mr-1"></i>Tekan foto untuk memperbesar
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <!-- Tombol Aksi untuk Tugas Belum Selesai -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-orange-800 mb-4 text-center">
            <i class="fas fa-tools mr-2"></i>Aksi Tugas
        </h3>
        
        <div class="space-y-4">
            @if($task->status == 'in_progress')
                <button onclick="openCompleteModal()" 
                        class="w-full bg-green-600 text-white py-4 px-6 rounded-xl font-bold text-xl hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-200 shadow-lg">
                    <i class="fas fa-check mr-2"></i>Selesaikan Tugas
                </button>
                @if($task->started_at)
                <div class="text-center bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <p class="text-base text-blue-700 font-medium">
                        <i class="fas fa-clock mr-1"></i>Dimulai jam {{ $task->started_at->format('H:i') }}
                    </p>
                </div>
                @endif
            @elseif($task->status == 'assigned')
                <div class="text-center py-6 bg-yellow-50 border-2 border-yellow-200 rounded-lg">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-clock text-yellow-500"></i>
                    </div>
                    <p class="text-lg text-yellow-800 font-bold mb-2">Tugas Belum Dimulai</p>
                    <p class="text-base text-yellow-700">Tugas akan otomatis dimulai setelah Anda melakukan check-in</p>
                    <span class="inline-block mt-3 px-4 py-2 bg-yellow-200 rounded-lg text-sm font-medium text-yellow-800">
                        <i class="fas fa-list mr-1"></i>Menunggu Check-in
                    </span>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tombol Kembali -->
    <div class="pt-4">
        <a href="{{ route('user.tasks') }}" 
           class="block w-full bg-blue-600 text-white py-4 px-6 rounded-xl text-center font-bold text-xl hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 shadow-lg">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Tugas
        </a>
    </div>
</div>

@if($task->status != 'completed')
<!-- Modal Selesaikan Tugas -->
<div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-green-800">Selesaikan Tugas</h3>
            </div>
            
            <form method="POST" action="{{ route('user.tasks.complete', $task) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- Catatan Penyelesaian -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                        <label class="text-lg font-semibold text-gray-800">Catatan Hasil Pekerjaan</label>
                    </div>
                    <textarea name="completion_notes" rows="4" required
                              class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
                              placeholder="Tulis hasil pekerjaan atau catatan..."></textarea>
                </div>

                <!-- Upload Bukti -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                        <label class="text-lg font-semibold text-gray-800">Foto Bukti Pekerjaan</label>
                    </div>
                    <input type="file" name="proof_image" accept="image/*" capture="environment" required
                           class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <div class="flex items-center mt-2 text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2 text-green-500"></i>
                        <span>Upload foto hasil pekerjaan sebagai bukti</span>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="pt-4 space-y-3">
                    <button type="submit" class="w-full bg-green-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 shadow-lg">
                        <i class="fas fa-check mr-2"></i>Selesaikan Tugas
                    </button>
                    <button type="button" onclick="closeCompleteModal()" 
                            class="w-full bg-gray-300 text-gray-800 py-3 px-6 rounded-lg font-medium text-lg hover:bg-gray-400">
                        <i class="fas fa-times mr-2"></i>Batal
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
                    class="absolute top-4 right-4 bg-white text-black rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl z-10 hover:bg-gray-200">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Bukti penyelesaian tugas" class="w-full h-auto rounded-xl shadow-2xl">
            <div class="text-center mt-4">
                <p class="text-white text-lg font-medium">
                    <i class="fas fa-camera mr-2"></i>Foto Bukti Pekerjaan
                </p>
            </div>
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
