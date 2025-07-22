@extends('layouts.admin')

@section('title', 'Kelola Tugas - Admin')

@section('content')
<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold text-gray-900">Kelola Tugas</h1>
        <p class="mt-2 text-sm text-gray-700">Buat, kelola, dan berikan feedback untuk tugas karyawan</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="{{ route('admin.tasks.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i>
            Buat Tugas Baru
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-tasks text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Tugas</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $tasks->total() }}</dd>
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
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $tasks->where('status', 'completed')->count() }}</dd>
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
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Sedang Dikerjakan</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $tasks->where('status', 'in_progress')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-gray-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Belum Dimulai</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $tasks->where('status', 'assigned')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="mt-8">
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <option>Semua Tugas</option>
            <option>Menunggu Approval</option>
            <option>Dibuat Karyawan</option>
            <option>Tugas Rutin</option>
            <option>Tugas Insidental</option>
        </select>
    </div>
    <div class="hidden sm:block">
        <nav class="flex space-x-8" aria-label="Tabs">
            <a href="{{ route('admin.tasks.index') }}" 
               class="{{ !request('approval') && !request('type') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Semua Tugas
            </a>
            <a href="{{ route('admin.tasks.index', ['approval' => 'pending_approval']) }}" 
               class="{{ request('approval') === 'pending_approval' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                ⏳ Menunggu Approval
            </a>
            <a href="{{ route('admin.tasks.index', ['approval' => 'employee_created']) }}" 
               class="{{ request('approval') === 'employee_created' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                👤 Dibuat Karyawan
            </a>
            <a href="{{ route('admin.tasks.index', ['type' => 'routine']) }}" 
               class="{{ request('type') === 'routine' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                🔄 Rutin
            </a>
            <a href="{{ route('admin.tasks.index', ['type' => 'incidental']) }}" 
               class="{{ request('type') === 'incidental' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                ⚡ Insidental
            </a>
        </nav>
    </div>
</div>

<!-- Tasks Grid -->
<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($tasks as $task)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow border">
            <!-- Task Header -->
            <div class="p-6 border-b">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $task->title }}</h3>
                            @if(isset($task->task_type))
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->task_type_color ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $task->task_type_text ?? $task->task_type }}
                                </span>
                            @endif
                            @if($task->is_self_assigned)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    👤 Dibuat Sendiri
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                        
                        @if(isset($task->task_type) && $task->task_type === 'incidental' && isset($task->approval_status))
                            <div class="mt-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->approval_status_color ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $task->approval_status_text ?? $task->approval_status }}
                                </span>
                                @if($task->approval_status === 'rejected' && $task->rejection_reason)
                                    <p class="text-xs text-red-600 mt-1">{{ $task->rejection_reason }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="flex space-x-1">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->priority_color }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->status_color }}">
                            {{ $task->status_text }}
                        </span>
                    </div>
                </div>
                
                <!-- Employee Info -->
                <div class="mt-4 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-blue-600">{{ substr($task->user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $task->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $task->user->employee_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Task Details -->
            <div class="p-6 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Ditugaskan:</span>
                    <span class="font-medium">{{ $task->assigned_date->format('d/m/Y') }}</span>
                </div>

                @if($task->estimated_time)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Estimasi:</span>
                        <span class="font-medium">{{ $task->estimated_time }}h</span>
                    </div>
                @endif

                @if($task->category)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Kategori:</span>
                        <span class="font-medium">{{ ucfirst($task->category) }}</span>
                    </div>
                @endif

                @if($task->status === 'completed')
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Selesai:</span>
                        <span class="font-medium">{{ $task->completed_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    @if($task->proof_image)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Bukti:</span>
                            <a href="{{ asset('storage/' . $task->proof_image) }}" target="_blank" 
                               class="text-blue-600 hover:underline">Lihat Foto</a>
                        </div>
                    @endif

                    @if($task->completion_notes)
                        <div class="text-sm">
                            <span class="text-gray-600">Catatan:</span>
                            <p class="mt-1 text-gray-900">{{ $task->completion_notes }}</p>
                        </div>
                    @endif
                @endif

                <!-- Current Feedback -->
                @if($task->status === 'completed' && ($task->admin_feedback || $task->feedback_type))
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-900">Feedback Admin</span>
                            @if($task->feedback_type)
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->feedback_type_color }}">
                                    {{ $task->feedback_type_text }}
                                </span>
                            @endif
                        </div>
                        @if($task->admin_feedback)
                            <p class="text-sm text-gray-700">{{ $task->admin_feedback }}</p>
                        @endif
                        @if($task->feedbackBy)
                            <p class="text-xs text-gray-500 mt-2">
                                Oleh: {{ $task->feedbackBy->name }} • {{ $task->feedback_at->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="px-6 pb-6">
                <div class="flex space-x-2">
                    <!-- Approval Buttons (only for pending incidental tasks) -->
                    @if(isset($task->task_type) && $task->task_type === 'incidental' && isset($task->approval_status) && $task->approval_status === 'pending')
                        <button onclick="approveTask({{ $task->id }})"
                                class="flex-1 bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                            <i class="fas fa-check mr-1"></i>
                            Setujui
                        </button>
                        <button onclick="openRejectModal({{ $task->id }})"
                                class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                            <i class="fas fa-times mr-1"></i>
                            Tolak
                        </button>
                    @else
                        <!-- Edit Button (only for non-completed tasks) -->
                        @if($task->status !== 'completed')
                            <a href="{{ route('admin.tasks.edit', $task) }}" 
                               class="flex-1 bg-gray-600 text-white px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors text-center text-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                        @endif
                        
                        <!-- Feedback Button (only for completed tasks) -->
                        @if($task->status === 'completed')
                            <button onclick="openFeedbackModal({{ $task->id }}, '{{ $task->feedback_type }}', '{{ addslashes($task->admin_feedback) }}')"
                                    class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                <i class="fas fa-comment mr-1"></i>
                                {{ $task->admin_feedback ? 'Edit Feedback' : 'Beri Feedback' }}
                            </button>
                        @endif

                        <!-- Delete Button (only for non-completed tasks) -->
                        @if($task->status !== 'completed')
                            <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Tugas</h3>
            <p class="text-gray-600 mb-4">Buat tugas pertama untuk karyawan</p>
            <a href="{{ route('admin.tasks.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Buat Tugas Baru
            </a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($tasks->hasPages())
    <div class="mt-8">
        {{ $tasks->links() }}
    </div>
@endif

<!-- Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Berikan Feedback</h3>
            <form id="feedbackForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="feedback_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Feedback
                    </label>
                    <select id="feedback_type" name="feedback_type" required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Pilih jenis feedback...</option>
                        <option value="excellent">⭐ Sempurna</option>
                        <option value="good">👍 Bagus</option>
                        <option value="needs_improvement">📝 Perlu Perbaikan</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="admin_feedback" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Feedback
                    </label>
                    <textarea id="admin_feedback" name="admin_feedback" rows="4" 
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                              placeholder="Berikan feedback untuk tugas ini..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeFeedbackModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded">
                        Simpan Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Task Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Task Insidental</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan
                    </label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="4" required
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                              placeholder="Jelaskan alasan mengapa task ini ditolak..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded">
                        Tolak Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openFeedbackModal(taskId, currentType, currentFeedback) {
    document.getElementById('feedbackModal').classList.remove('hidden');
    document.getElementById('feedbackForm').action = `/admin/tasks/${taskId}/feedback`;
    document.getElementById('feedback_type').value = currentType || '';
    document.getElementById('admin_feedback').value = currentFeedback || '';
}

function closeFeedbackModal() {
    document.getElementById('feedbackModal').classList.add('hidden');
}

function openRejectModal(taskId) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectForm').action = `/admin/tasks/${taskId}/reject`;
    document.getElementById('rejection_reason').value = '';
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

function approveTask(taskId) {
    if (confirm('Yakin ingin menyetujui task ini?')) {
        fetch(`/admin/tasks/${taskId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
}

// Handle reject form submission
document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeRejectModal();
            location.reload();
        } else {
            alert(data.error || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem');
    });
});

// Close modal when clicking outside
document.getElementById('feedbackModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFeedbackModal();
    }
});

document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection
