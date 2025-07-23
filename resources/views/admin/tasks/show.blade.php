@extends('layouts.admin')

@section('title', 'Detail Tugas')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Tugas</h1>
                <p class="mt-2 text-gray-600">Informasi lengkap tugas untuk {{ $task->user->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.tasks.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                @if ($task->status !== 'completed')
                    <a href="{{ route('admin.tasks.edit', $task) }}"
                        class="btn-primary inline-flex items-center px-4 py-2 text-white font-medium rounded-xl shadow-sm hover:shadow-lg transition-all">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Tugas
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Task Info -->
        <div class="lg:col-span-2">
            <div class="card-modern p-8">
                <!-- Task Header -->
                <div class="mb-8">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $task->title }}</h2>
                            <p class="text-gray-600 text-lg">{{ $task->description }}</p>
                        </div>
                    </div>

                    <!-- Status Badges -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->priority_color }}">
                            <i class="fas fa-flag mr-1"></i>
                            {{ ucfirst($task->priority) }} Priority
                        </span>
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->status_color }}">
                            <i class="fas fa-circle mr-1"></i>
                            {{ $task->status_text }}
                        </span>
                        @if (isset($task->task_type))
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->task_type_color ?? 'bg-gray-100 text-gray-800' }}">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $task->task_type_text ?? ucfirst($task->task_type) }}
                            </span>
                        @endif
                        @if ($task->is_self_assigned)
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800">
                                <i class="fas fa-user mr-1"></i>
                                Dibuat Sendiri
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Task Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Ditugaskan Pada</label>
                        <p class="text-lg font-medium text-gray-900">{{ $task->assigned_date->format('d/m/Y') }}</p>
                    </div>

                    @if ($task->due_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Batas Waktu</label>
                            <p class="text-lg font-medium text-gray-900">{{ $task->due_date->format('d/m/Y') }}</p>
                        </div>
                    @endif

                    @if ($task->estimated_time)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Estimasi Waktu</label>
                            <p class="text-lg font-medium text-gray-900">{{ $task->estimated_time }} jam</p>
                        </div>
                    @endif

                    @if ($task->category)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Kategori</label>
                            <p class="text-lg font-medium text-gray-900">{{ ucfirst($task->category) }}</p>
                        </div>
                    @endif

                    @if ($task->started_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Dimulai Pada</label>
                            <p class="text-lg font-medium text-gray-900">{{ $task->started_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif

                    @if ($task->completed_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Selesai Pada</label>
                            <p class="text-lg font-medium text-gray-900">{{ $task->completed_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Notes Section -->
                @if ($task->notes)
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Catatan Admin</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900">{{ $task->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Completion Details -->
                @if ($task->status === 'completed')
                    <div class="bg-green-50 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-semibold text-green-900 mb-4">
                            <i class="fas fa-check-circle mr-2"></i>
                            Detail Penyelesaian
                        </h3>

                        @if ($task->completion_notes)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-green-700 mb-2">Catatan Penyelesaian</label>
                                <p class="text-green-900">{{ $task->completion_notes }}</p>
                            </div>
                        @endif

                        @if ($task->proof_image)
                            <div>
                                <label class="block text-sm font-medium text-green-700 mb-2">Bukti Foto</label>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $task->proof_image) }}" 
                                         alt="Bukti penyelesaian tugas"
                                         class="max-w-md rounded-lg shadow-md cursor-pointer hover:shadow-lg transition-shadow"
                                         onclick="openImageModal('{{ asset('storage/' . $task->proof_image) }}')">
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Feedback Section -->
                @if ($task->status === 'completed' && ($task->admin_feedback || $task->feedback_type))
                    <div class="bg-blue-50 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-blue-900">
                                <i class="fas fa-comment mr-2"></i>
                                Feedback Admin
                            </h3>
                            @if ($task->feedback_type)
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->feedback_type_color }}">
                                    {{ $task->feedback_type_text }}
                                </span>
                            @endif
                        </div>

                        @if ($task->admin_feedback)
                            <div class="mb-4">
                                <p class="text-blue-900">{{ $task->admin_feedback }}</p>
                            </div>
                        @endif

                        @if ($task->feedbackBy)
                            <div class="text-sm text-blue-700">
                                <p>Diberikan oleh: {{ $task->feedbackBy->name }}</p>
                                <p>Pada: {{ $task->feedback_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif

                        <!-- Correction Status -->
                        @if ($task->feedback_type === 'needs_improvement')
                            <div class="mt-4 pt-4 border-t border-blue-200">
                                @if ($task->correction_needed && !$task->correction_completed_at)
                                    <div class="flex items-center text-orange-600">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span class="font-medium">Menunggu perbaikan dari karyawan</span>
                                    </div>
                                @elseif(!$task->correction_needed && $task->correction_completed_at)
                                    <div class="flex items-center text-green-600">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <span class="font-medium">
                                            Perbaikan selesai ({{ $task->correction_completed_at->format('d/m/Y H:i') }})
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Employee Info -->
            <div class="card-modern p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-user mr-2"></i>
                    Karyawan yang Ditugaskan
                </h3>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">{{ substr($task->user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">{{ $task->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $task->user->employee_code }}</p>
                        @if ($task->user->email)
                            <p class="text-sm text-gray-600">{{ $task->user->email }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Task Creator Info -->
            @if ($task->assignedBy)
                <div class="card-modern p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-user-tie mr-2"></i>
                        Dibuat Oleh
                    </h3>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-semibold">{{ substr($task->assignedBy->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $task->assignedBy->name }}</p>
                            <p class="text-sm text-gray-600">{{ ucfirst($task->assignedBy->role) }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="card-modern p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-cog mr-2"></i>
                    Aksi
                </h3>
                <div class="space-y-3">
                    @if ($task->status !== 'completed')
                        <a href="{{ route('admin.tasks.edit', $task) }}"
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Tugas
                        </a>
                    @endif

                    @if ($task->status === 'completed')
                        <button
                            onclick="openFeedbackModal({{ $task->id }}, '{{ $task->feedback_type }}', '{{ addslashes($task->admin_feedback) }}')"
                            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-comment mr-2"></i>
                            {{ $task->admin_feedback ? 'Edit Feedback' : 'Beri Feedback' }}
                        </button>
                    @endif

                    @if ($task->status !== 'completed')
                        <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="w-full"
                            onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Tugas
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 items-center justify-center hidden z-50">
        <div class="relative max-w-4xl max-h-full p-4">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Bukti penyelesaian tugas" class="max-w-full max-h-full rounded-lg">
        </div>
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-6 border w-96 shadow-lg rounded-2xl bg-white">
            <div class="mt-2">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Berikan Feedback</h3>
                <form id="feedbackForm" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Feedback Type -->
                        <div class="group">
                            <label for="feedback_type" class="block text-sm font-semibold text-gray-800 mb-2">
                                Jenis Feedback <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="feedback_type" name="feedback_type" required
                                    class="block w-full px-3 py-3 text-gray-900 bg-white border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 appearance-none cursor-pointer">
                                    <option value="">Pilih jenis feedback...</option>
                                    <option value="excellent">⭐ Sempurna</option>
                                    <option value="good">👍 Bagus</option>
                                    <option value="needs_improvement">📝 Perlu Perbaikan</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback Notes -->
                        <div class="group">
                            <label for="admin_feedback" class="block text-sm font-semibold text-gray-800 mb-2">
                                Catatan Feedback
                            </label>
                            <textarea id="admin_feedback" name="admin_feedback" rows="3"
                                class="block w-full px-3 py-3 text-gray-900 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300"
                                placeholder="Berikan feedback untuk tugas ini..."></textarea>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 mt-6 border-t border-gray-100">
                        <button type="button" onclick="closeFeedbackModal()"
                            class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="btn-primary px-6 py-2 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Feedback 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            document.getElementById('modalImage').src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openFeedbackModal(taskId, currentType, currentFeedback) {
            document.getElementById('feedbackModal').classList.remove('hidden');
            document.getElementById('feedbackForm').action = `/admin/tasks/${taskId}/feedback`;
            document.getElementById('feedback_type').value = currentType || '';
            document.getElementById('admin_feedback').value = currentFeedback || '';
        }

        function closeFeedbackModal() {
            document.getElementById('feedbackModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        document.getElementById('feedbackModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFeedbackModal();
            }
        });

        // Close modals with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
                closeFeedbackModal();
            }
        });
    </script>
@endsection
