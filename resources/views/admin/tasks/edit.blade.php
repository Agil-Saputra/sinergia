@extends('layouts.admin')

@section('title', 'Edit Tugas')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Tugas</h1>
                <p class="mt-2 text-gray-600">Ubah detail tugas untuk {{ $task->user->name }}</p>
            </div>
            <a href="{{ route('admin.tasks.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="card-modern p-8">
                <!-- Current Task Status Info -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 mb-8 border-l-4 border-blue-400">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Status Tugas Saat Ini</h3>
                            <p class="text-sm text-gray-600 mt-1">Dibuat pada
                                {{ $task->assigned_date->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="px-4 py-2 text-sm font-semibold rounded-2xl {{ $task->status_color }}">
                            {{ $task->status_text }}
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.tasks.update', $task) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">

                        <div class="space-y-8">
                            <!-- Employee Selection -->
                            <div class="group">
                                <label for="user_id" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Pilih Karyawan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="user_id" name="user_id" required
                                        class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 appearance-none cursor-pointer @error('user_id') border-red-300 focus:ring-red-500 @enderror">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ $task->user_id == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} ({{ $employee->employee_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('user_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Task Title -->
                            <div class="group">
                                <label for="title" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Judul Tugas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title" name="title" required maxlength="255"
                                    value="{{ old('title', $task->title) }}"
                                    class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('title') border-red-300 focus:ring-red-500 @enderror"
                                    placeholder="Masukkan judul tugas...">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Task Description -->
                            <div class="group">
                                <label for="description" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Deskripsi Tugas <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description" name="description" rows="4" required
                                    class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('description') border-red-300 focus:ring-red-500 @enderror"
                                    placeholder="Jelaskan detail tugas yang harus dikerjakan...">{{ old('description', $task->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Priority and Category Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Priority -->
                                <div class="group">
                                    <label for="priority" class="block text-sm font-semibold text-gray-800 mb-3">
                                        Prioritas <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="priority" name="priority" required
                                            class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 appearance-none cursor-pointer @error('priority') border-red-300 focus:ring-red-500 @enderror">
                                            <option value="low"
                                                {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Rendah
                                            </option>
                                            <option value="medium"
                                                {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>
                                                Sedang</option>
                                            <option value="high"
                                                {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>Tinggi
                                            </option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('priority')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="group">
                                    <label for="category" class="block text-sm font-semibold text-gray-800 mb-3">
                                        Kategori
                                    </label>
                                    <div class="relative">
                                        <select id="category" name="category"
                                            class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 appearance-none cursor-pointer @error('category') border-red-300 focus:ring-red-500 @enderror">
                                            <option value="">Pilih kategori...</option>
                                            <option value="project"
                                                {{ old('category', $task->category) === 'project' ? 'selected' : '' }}>
                                                Proyek</option>
                                            <option value="maintenance"
                                                {{ old('category', $task->category) === 'maintenance' ? 'selected' : '' }}>
                                                Maintenance</option>
                                            <option value="support"
                                                {{ old('category', $task->category) === 'support' ? 'selected' : '' }}>
                                                Support</option>
                                            <option value="training"
                                                {{ old('category', $task->category) === 'training' ? 'selected' : '' }}>
                                                Training</option>
                                            <option value="research"
                                                {{ old('category', $task->category) === 'research' ? 'selected' : '' }}>
                                                Research</option>
                                            <option value="documentation"
                                                {{ old('category', $task->category) === 'documentation' ? 'selected' : '' }}>
                                                Dokumentasi</option>
                                            <option value="meeting"
                                                {{ old('category', $task->category) === 'meeting' ? 'selected' : '' }}>
                                                Meeting</option>
                                            <option value="other"
                                                {{ old('category', $task->category) === 'other' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('category')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Due Date and Estimated Time Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Due Date -->
                                <div class="group">
                                    <label for="due_date" class="block text-sm font-semibold text-gray-800 mb-3">
                                        Tenggat Waktu
                                    </label>
                                    <input type="date" id="due_date" name="due_date"
                                        value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                                        min="{{ date('Y-m-d') }}"
                                        class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('due_date') border-red-300 focus:ring-red-500 @enderror">
                                    @error('due_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">Opsional - biarkan kosong jika tidak ada tenggat
                                        waktu</p>
                                </div>

                                <!-- Estimated Time -->
                                <div class="group">
                                    <label for="estimated_time" class="block text-sm font-semibold text-gray-800 mb-3">
                                        Estimasi Waktu (jam)
                                    </label>
                                    <input type="number" id="estimated_time" name="estimated_time"
                                        value="{{ old('estimated_time', $task->estimated_time) }}" min="0.5"
                                        max="200" step="0.5"
                                        class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('estimated_time') border-red-300 focus:ring-red-500 @enderror"
                                        placeholder="8">
                                    @error('estimated_time')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">Opsional - estimasi berapa jam untuk
                                        menyelesaikan tugas</p>
                                </div>
                            </div>

                            <!-- Task Notes -->
                            <div class="group">
                                <label for="notes" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Catatan Tambahan
                                </label>
                                <textarea id="notes" name="notes" rows="3"
                                    class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('notes') border-red-300 focus:ring-red-500 @enderror"
                                    placeholder="Catatan khusus atau instruksi tambahan...">{{ old('notes', $task->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Progress Info for In Progress Tasks -->
                            @if ($task->status === 'in_progress')
                                <div
                                    class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-6 border-l-4 border-yellow-400">
                                    <h3 class="text-lg font-bold text-yellow-800 mb-2">Tugas Sedang Dikerjakan</h3>
                                    <div class="text-sm text-yellow-700">
                                        <p>Tugas ini sedang dikerjakan oleh karyawan. Perubahan akan langsung terlihat oleh
                                            karyawan.</p>
                                        @if ($task->started_at)
                                            <p class="mt-2 font-semibold">Dimulai pada:
                                                {{ $task->started_at->format('d/m/Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-4 pt-8 border-t-2 border-gray-100">
                                <a href="{{ route('admin.tasks.index') }}"
                                    class="px-8 py-3 border-2 border-gray-300 rounded-2xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="btn-primary px-8 py-3 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <!-- Task Info & Actions -->
        <div class="space-y-6 mt-6">
            <!-- Task Status -->
            <div class="card-modern p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Tugas</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $task->status_color }}">
                            {{ $task->status_text }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Prioritas</span>
                        <span class="text-sm font-semibold text-gray-900 capitalize">{{ $task->priority }}</span>
                    </div>
                    @if ($task->category)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Kategori</span>
                            <span class="text-sm text-gray-900 capitalize">{{ $task->category }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Dibuat</span>
                        <span class="text-sm text-gray-900">{{ $task->assigned_date->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning for Completed Tasks -->
    @if ($task->status === 'completed')
        <div class="mt-8">
            <div class="card-modern p-6 border-l-4 border-red-400 bg-red-50">
                <h3 class="text-lg font-bold text-red-800 mb-2">Peringatan</h3>
                <div class="text-sm text-red-700">
                    <p>Tugas ini sudah diselesaikan. Editing tidak disarankan karena dapat menimbulkan kebingungan. Gunakan
                        fitur feedback untuk memberikan tanggapan.</p>
                </div>
            </div>
        </div>
    @endif
@endsection
