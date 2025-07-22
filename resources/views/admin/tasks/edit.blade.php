@extends('layouts.admin')

@section('title', 'Edit Tugas - Admin')

@section('content')
<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Tugas</h1>
        <p class="mt-2 text-sm text-gray-700">Ubah detail tugas untuk {{ $task->user->name }}</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>
</div>

<div class="mt-8">
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.tasks.update', $task) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')
            
            <!-- Current Task Status Info -->
            <div class="bg-gray-50 rounded-lg p-4 border">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Status Tugas Saat Ini</h3>
                        <p class="text-sm text-gray-600 mt-1">Dibuat pada {{ $task->assigned_date->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->status_color }}">
                        {{ $task->status_text }}
                    </span>
                </div>
            </div>

            <!-- Employee Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Karyawan <span class="text-red-500">*</span>
                </label>
                <select id="user_id" name="user_id" required 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $task->user_id == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }} ({{ $employee->employee_code }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Task Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Tugas <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" required maxlength="255"
                       value="{{ old('title', $task->title) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                       placeholder="Masukkan judul tugas...">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Task Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Tugas <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="4" required
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                          placeholder="Jelaskan detail tugas yang harus dikerjakan...">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority and Category Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                        Prioritas <span class="text-red-500">*</span>
                    </label>
                    <select id="priority" name="priority" required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>
                    <select id="category" name="category" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Pilih kategori...</option>
                        <option value="project" {{ old('category', $task->category) === 'project' ? 'selected' : '' }}>Proyek</option>
                        <option value="maintenance" {{ old('category', $task->category) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="support" {{ old('category', $task->category) === 'support' ? 'selected' : '' }}>Support</option>
                        <option value="training" {{ old('category', $task->category) === 'training' ? 'selected' : '' }}>Training</option>
                        <option value="research" {{ old('category', $task->category) === 'research' ? 'selected' : '' }}>Research</option>
                        <option value="documentation" {{ old('category', $task->category) === 'documentation' ? 'selected' : '' }}>Dokumentasi</option>
                        <option value="meeting" {{ old('category', $task->category) === 'meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="other" {{ old('category', $task->category) === 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Due Date and Estimated Time Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tenggat Waktu
                    </label>
                    <input type="date" id="due_date" name="due_date" 
                           value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                           min="{{ date('Y-m-d') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opsional - biarkan kosong jika tidak ada tenggat waktu</p>
                </div>

                <!-- Estimated Time -->
                <div>
                    <label for="estimated_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Estimasi Waktu (jam)
                    </label>
                    <input type="number" id="estimated_time" name="estimated_time" 
                           value="{{ old('estimated_time', $task->estimated_time) }}"
                           min="0.5" max="200" step="0.5"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           placeholder="8">
                    @error('estimated_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opsional - estimasi berapa jam untuk menyelesaikan tugas</p>
                </div>
            </div>

            <!-- Task Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Tambahan
                </label>
                <textarea id="notes" name="notes" rows="3"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                          placeholder="Catatan khusus atau instruksi tambahan...">{{ old('notes', $task->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Progress Info for In Progress Tasks -->
            @if($task->status === 'in_progress')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Tugas Sedang Dikerjakan</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Tugas ini sedang dikerjakan oleh karyawan. Perubahan akan langsung terlihat oleh karyawan.</p>
                                @if($task->started_at)
                                    <p class="mt-1">Dimulai pada: {{ $task->started_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('admin.tasks.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Warning for Completed Tasks -->
@if($task->status === 'completed')
    <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Peringatan</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>Tugas ini sudah diselesaikan. Editing tidak disarankan karena dapat menimbulkan kebingungan. Gunakan fitur feedback untuk memberikan tanggapan.</p>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
