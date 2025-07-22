@extends('layouts.admin')

@section('title', 'Buat Tugas Baru - Admin')

@section('content')
<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold text-gray-900">Buat Tugas Baru</h1>
        <p class="mt-2 text-sm text-gray-700">Buat dan tugaskan tugas kepada karyawan</p>
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
        <form method="POST" action="{{ route('admin.tasks.store') }}" class="space-y-6 p-6">
            @csrf
            
            <!-- Employee Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Karyawan <span class="text-red-500">*</span>
                </label>
                <select id="user_id" name="user_id" required 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('user_id') border-red-300 @enderror">
                    <option value="">Pilih karyawan...</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('user_id') == $employee->id ? 'selected' : '' }}>
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
                       value="{{ old('title') }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('title') border-red-300 @enderror"
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
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('description') border-red-300 @enderror"
                          placeholder="Jelaskan detail tugas yang harus dikerjakan...">{{ old('description') }}</textarea>
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
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('priority') border-red-300 @enderror">
                        <option value="">Pilih prioritas...</option>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                Rendah
                            </span>
                        </option>
                        <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                Sedang
                            </span>
                        </option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                Tinggi
                            </span>
                        </option>
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
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('category') border-red-300 @enderror">
                        <option value="">Pilih kategori...</option>
                        <option value="project" {{ old('category') === 'project' ? 'selected' : '' }}>Proyek</option>
                        <option value="maintenance" {{ old('category') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="support" {{ old('category') === 'support' ? 'selected' : '' }}>Support</option>
                        <option value="training" {{ old('category') === 'training' ? 'selected' : '' }}>Training</option>
                        <option value="research" {{ old('category') === 'research' ? 'selected' : '' }}>Research</option>
                        <option value="documentation" {{ old('category') === 'documentation' ? 'selected' : '' }}>Dokumentasi</option>
                        <option value="meeting" {{ old('category') === 'meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Lainnya</option>
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
                           value="{{ old('due_date') }}"
                           min="{{ date('Y-m-d') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('due_date') border-red-300 @enderror">
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
                           value="{{ old('estimated_time') }}"
                           min="0.5" max="200" step="0.5"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('estimated_time') border-red-300 @enderror"
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
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('notes') border-red-300 @enderror"
                          placeholder="Catatan khusus atau instruksi tambahan...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('admin.tasks.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Buat Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Help Information -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-blue-400"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Tips Membuat Tugas</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc list-inside space-y-1">
                    <li>Berikan judul yang jelas dan deskriptif</li>
                    <li>Sertakan detail lengkap dalam deskripsi tugas</li>
                    <li>Pilih prioritas sesuai urgency tugas</li>
                    <li>Tentukan estimasi waktu untuk membantu perencanaan</li>
                    <li>Gunakan catatan untuk instruksi khusus</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
