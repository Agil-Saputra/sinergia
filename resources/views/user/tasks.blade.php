@extends('layouts.mobile')

@section('title', 'Tugas Hari Ini - Sinergia')
@section('header', 'Tugas Hari Ini')

@section('content')
<div class="p-4 space-y-6">
    <!-- Header -->
    <div class="bg-blue-50 border-2 border-blue-300 rounded-xl p-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-tasks text-white text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-blue-800 mb-2">Daftar Tugas Saya</h2>
            <p class="text-sm text-blue-700">{{ now()->format('d M Y') }}</p>
        </div>

        <!-- Tombol Buat Task -->
        <button onclick="openCreateTaskModal()" 
                class="w-full bg-blue-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg mb-6">
            TAMBAHKAN TASK INSIDENTAL
        </button>

        <!-- Filter dengan Button -->
        <div class="space-y-3 mb-4">
            <p class="text-lg font-bold text-blue-800 text-center">Filter Tugas:</p>
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('user.tasks') }}" 
                   class="block py-3 px-4 rounded-lg text-lg font-medium text-center transition-all {{ !request('status') || request('status') == 'all' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border-2 border-gray-200' }}">
                    Semua Tugas
                </a>
                <a href="{{ route('user.tasks', ['status' => 'in_progress']) }}" 
                   class="block py-3 px-4 rounded-lg text-lg font-medium text-center transition-all {{ request('status') == 'in_progress' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border-2 border-gray-200' }}">
                    Sedang Dikerjakan
                </a>
                <a href="{{ route('user.tasks', ['status' => 'completed']) }}" 
                   class="block py-3 px-4 rounded-lg text-lg font-medium text-center transition-all {{ request('status') == 'completed' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border-2 border-gray-200' }}">
                    Sudah Selesai
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-2 border-green-400 text-green-800 px-4 py-3 rounded-lg text-lg font-medium text-center">
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
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">
            Tugas Hari Ini ({{ $todayTasks->count() }} Tugas)
        </h3>
        <div class="space-y-4">
            @foreach($todayTasks as $task)
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200 
                        {{ $task->priority == 'high' ? 'border-l-4 border-l-red-500' : ($task->priority == 'medium' ? 'border-l-4 border-l-orange-500' : 'border-l-4 border-l-yellow-500') }}">
                
                <!-- Header Task -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-lg font-semibold text-gray-900 {{ $task->status == 'completed' ? 'line-through text-gray-500' : '' }}">
                            {{ $task->title }}
                        </h4>
                        <div class="w-4 h-4 rounded-full {{ $task->priority == 'high' ? 'bg-red-500' : ($task->priority == 'medium' ? 'bg-orange-500' : 'bg-yellow-500') }}"></div>
                    </div>
                    <p class="text-base text-gray-600 leading-relaxed mb-3">{{ $task->description }}</p>
                    
                    @if(isset($task->task_type))
                        <div class="mb-3">
                            <span class="text-sm px-3 py-1 rounded-full font-medium {{ $task->task_type_color ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $task->task_type_text ?? $task->task_type }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Status dan Waktu -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <div class="text-center mb-2">
                        <span class="text-sm px-3 py-1 rounded-full font-medium {{ $task->status_color }}">
                            {{ $task->status_text }}
                        </span>
                    </div>
                    @if($task->status == 'completed')
                        <div class="text-center">
                            <span class="text-sm text-green-600 font-medium">
                                Selesai jam {{ $task->completed_at->format('H:i') }}
                            </span>
                        </div>
                    @elseif($task->status == 'in_progress' && $task->started_at)
                        <div class="text-center">
                            <span class="text-sm text-blue-600 font-medium">
                                Mulai jam {{ $task->started_at->format('H:i') }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Admin Feedback -->
                @if($task->status == 'completed' && ($task->admin_feedback || $task->feedback_type))
                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="text-center mb-3">
                        <span class="text-lg font-semibold text-blue-800">
                            Pesan dari Supervisor
                        </span>
                        @if($task->feedback_type)
                            <div class="mt-2">
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->feedback_type_color }}">
                                    {{ $task->feedback_type_text }}
                                </span>
                            </div>
                        @endif
                    </div>
                    @if($task->admin_feedback)
                        <p class="text-base text-blue-800 font-medium text-center bg-white p-3 rounded-lg">{{ $task->admin_feedback }}</p>
                    @endif
                    @if($task->feedback_at)
                        <p class="text-sm text-blue-600 text-center mt-2">
                            {{ $task->feedback_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                    
                    <!-- Tombol Perbaikan Selesai untuk feedback needs_improvement -->
                    @if($task->feedback_type === 'needs_improvement' && $task->correction_needed && !$task->correction_completed_at)
                        <div class="mt-4 text-center">
                            <form method="POST" action="{{ route('user.tasks.correction-completed', $task) }}" class="inline-block">
                                @csrf
                                <button type="submit" 
                                        class="bg-orange-600 text-white py-2 px-6 rounded-lg font-semibold text-base hover:bg-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-300 transition-all duration-200 shadow-md">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Perbaikan Selesai
                                </button>
                            </form>
                        </div>
                    @elseif($task->feedback_type === 'needs_improvement' && !$task->correction_needed && $task->correction_completed_at)
                        <div class="mt-4 text-center">
                            <div class="bg-green-100 border border-green-300 py-2 px-4 rounded-lg">
                                <span class="text-green-800 font-medium">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Perbaikan telah selesai ({{ $task->correction_completed_at->format('d/m/Y H:i') }})
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Tombol Aksi -->
                @if($task->status == 'in_progress')
                <button onclick="openCompleteModal({{ $task->id }})" 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-200 shadow-md">
                    Selesaikan Tugas
                </button>
                @elseif($task->status == 'completed')
                <a href="{{ route('user.tasks.show', $task) }}" 
                   class="block w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold text-lg text-center hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 shadow-md">
                    Lihat Hasil Kerja
                </a>
                @elseif($task->status == 'assigned')
                <button onclick="startTask({{ $task->id }})" 
                        class="w-full bg-yellow-600 text-white py-3 px-4 rounded-lg font-semibold text-lg hover:bg-yellow-700 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition-all duration-200 shadow-md">
                    <i class="fas fa-play mr-2"></i>
                    Mulai Kerjakan
                </button>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($tasks->count() == 0)
    <div class="bg-white rounded-xl p-8 text-center shadow-sm border border-gray-200">
        <div class="text-6xl mb-4">
            <i class="fas fa-clipboard-check text-green-500"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-700 mb-3">Tidak Ada Tugas</h3>
        <p class="text-lg text-gray-600">Selamat! Anda tidak memiliki tugas saat ini</p>
    </div>
    @endif

    <!-- Ringkasan Progress -->
    @if($tasks->count() > 0)
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">
            Ringkasan Hari Ini
        </h3>
        @php
            $todayCompleted = $todayTasks->where('status', 'completed')->count();
            $todayTotal = $todayTasks->count();
            $percentage = $todayTotal > 0 ? ($todayCompleted / $todayTotal) * 100 : 0;
        @endphp
        
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="text-center bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="text-2xl font-bold text-blue-600 mb-1">{{ $todayTasks->where('status', 'in_progress')->count() }}</div>
                <div class="text-sm text-blue-800 font-medium">Sedang Dikerjakan</div>
            </div>
            <div class="text-center bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="text-2xl font-bold text-green-600 mb-1">{{ $todayCompleted }}</div>
                <div class="text-sm text-green-800 font-medium">Sudah Selesai</div>
            </div>
        </div>
        
        @if($todayTotal > 0)
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="text-center mb-3">
                <div class="text-lg font-bold text-gray-800 mb-1">Progress Hari Ini</div>
                <div class="text-base font-medium text-gray-700">{{ $todayCompleted }}/{{ $todayTotal }} Tugas ({{ number_format($percentage, 0) }}%)</div>
            </div>
            <div class="w-full bg-gray-300 rounded-full h-4">
                <div class="bg-green-500 h-4 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>

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
            
            <form id="completeForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- Catatan Penyelesaian -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                        <label class="text-lg font-semibold text-gray-800">Catatan Hasil Pekerjaan</label>
                    </div>
                    <textarea name="completion_notes" rows="4" required
                              class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500"
                              placeholder="Tulis hasil pekerjaan yang sudah diselesaikan..."></textarea>
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
                        <span>Ambil foto hasil pekerjaan sebagai bukti</span>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="pt-4 space-y-3">
                    <button type="submit" class="w-full bg-green-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 shadow-lg">
                        Selesaikan Tugas
                    </button>
                    <button type="button" onclick="closeCompleteModal()" 
                            class="w-full bg-gray-300 text-gray-800 py-3 px-6 rounded-lg font-medium text-lg hover:bg-gray-400">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Buat Task Baru -->
<div id="createTaskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg max-h-screen overflow-y-auto">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-plus text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-blue-800">Buat Tugas Baru</h3>
            </div>
            
            <form method="POST" action="{{ route('user.tasks.store') }}" class="space-y-4">
                @csrf
                
                <!-- Judul Task -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                        <label class="text-lg font-semibold text-gray-800">Nama Tugas</label>
                    </div>
                    <input type="text" name="title" required
                           class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Bersihkan ruang meeting">
                </div>

                <!-- Deskripsi -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                        <label class="text-lg font-semibold text-gray-800">Penjelasan Tugas</label>
                    </div>
                    <textarea name="description" rows="3" required
                              class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                              placeholder="Jelaskan detail pekerjaan yang akan dilakukan..."></textarea>
                </div>

                <!-- Hidden inputs for default values -->
                <input type="hidden" name="task_type" value="incidental">
                <input type="hidden" name="assigned_date" value="{{ date('Y-m-d') }}">

                <!-- Prioritas -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</div>
                        <label class="text-lg font-semibold text-gray-800">Tingkat Penting</label>
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="priority" value="high" class="w-4 h-4 mr-3 text-red-600">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                                <div>
                                    <div class="font-medium text-red-800">Tinggi</div>
                                    <div class="text-sm text-gray-600">Harus segera dikerjakan</div>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="priority" value="medium" class="w-4 h-4 mr-3 text-orange-600">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-orange-500 rounded-full mr-3"></div>
                                <div>
                                    <div class="font-medium text-orange-800">Sedang</div>
                                    <div class="text-sm text-gray-600">Penting tapi tidak urgent</div>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="priority" value="low" class="w-4 h-4 mr-3 text-yellow-600">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                                <div>
                                    <div class="font-medium text-yellow-800">Rendah</div>
                                    <div class="text-sm text-gray-600">Bisa dikerjakan kapan saja</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Estimasi Waktu (Optional) -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <label class="text-lg font-semibold text-gray-800 mb-3 block">Perkiraan Waktu (Jam) <span class="text-sm text-gray-500">(Opsional)</span></label>
                    <input type="number" name="estimated_time" step="0.5" min="0.5" max="24"
                           class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: 2">
                </div>

                <!-- Tombol -->
                <div class="pt-4 space-y-3">
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg">
                        Tambahkan Task Insidental
                    </button>
                    <button type="button" onclick="closeCreateTaskModal()" 
                            class="w-full bg-gray-300 text-gray-800 py-3 px-6 rounded-lg font-medium text-lg hover:bg-gray-400">
                        Batal
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

function openCreateTaskModal() {
    document.getElementById('createTaskModal').classList.remove('hidden');
}

function closeCreateTaskModal() {
    document.getElementById('createTaskModal').classList.add('hidden');
}

function startTask(taskId) {
    fetch(`/user/tasks/${taskId}/start`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem');
    });
}

// Close modal when clicking outside
document.getElementById('completeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCompleteModal();
    }
});

document.getElementById('createTaskModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateTaskModal();
    }
});
</script>
@endsection
