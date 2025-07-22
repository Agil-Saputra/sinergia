@extends('layouts.mobile')

@section('title', 'Buat Tugas - Sinergia')
@section('header', 'Buat Tugas Baru')

@section('content')
<div class="p-4">
    <form method="POST" action="{{ route('user.tasks.store') }}" class="space-y-4">
        @csrf
        
        <!-- Judul Tugas -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="title" class="block text-sm font-bold text-gray-700 mb-2">📝 Nama Tugas</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="{{ old('title') }}"
                required 
                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-lg"
                placeholder="Contoh: Bersihkan toilet lantai 2"
            >
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">📋 Detail Pekerjaan</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4" 
                required 
                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Jelaskan apa yang harus dikerjakan..."
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Prioritas -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="priority" class="block text-sm font-bold text-gray-700 mb-2">⚡ Tingkat Prioritas</label>
            <div class="space-y-2">
                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="priority" value="high" {{ old('priority') == 'high' ? 'checked' : '' }} class="mr-3">
                    <div class="flex items-center">
                        <span class="text-red-500 mr-2">🔴</span>
                        <span class="font-medium">Penting (Harus dikerjakan hari ini)</span>
                    </div>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="priority" value="medium" {{ old('priority') == 'medium' ? 'checked' : '' }} class="mr-3" checked>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">🟡</span>
                        <span class="font-medium">Sedang (Bisa dikerjakan besok)</span>
                    </div>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="priority" value="low" {{ old('priority') == 'low' ? 'checked' : '' }} class="mr-3">
                    <div class="flex items-center">
                        <span class="text-green-500 mr-2">🟢</span>
                        <span class="font-medium">Rendah (Tidak terburu-buru)</span>
                    </div>
                </label>
            </div>
            @error('priority')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Ditugaskan -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="assigned_date" class="block text-sm font-bold text-gray-700 mb-2">📅 Tanggal Ditugaskan</label>
            <input 
                type="date" 
                id="assigned_date" 
                name="assigned_date" 
                value="{{ old('assigned_date', date('Y-m-d')) }}"
                required 
                min="{{ date('Y-m-d') }}"
                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-lg"
            >
            @error('assigned_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kategori (Opsional) -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="category" class="block text-sm font-bold text-gray-700 mb-2">🏷️ Jenis Pekerjaan (Opsional)</label>
            <select 
                id="category" 
                name="category" 
                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            >
                <option value="">Pilih jenis pekerjaan...</option>
                <option value="cleaning" {{ old('category') == 'cleaning' ? 'selected' : '' }}>🧽 Kebersihan</option>
                <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>🔧 Perawatan</option>
                <option value="security" {{ old('category') == 'security' ? 'selected' : '' }}>🛡️ Keamanan</option>
                <option value="gardening" {{ old('category') == 'gardening' ? 'selected' : '' }}>🌱 Taman</option>
                <option value="supplies" {{ old('category') == 'supplies' ? 'selected' : '' }}>📦 Perlengkapan</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>📝 Lainnya</option>
            </select>
        </div>

        <!-- Estimasi Waktu -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="estimated_time" class="block text-sm font-bold text-gray-700 mb-2">⏱️ Perkiraan Waktu</label>
            <select 
                id="estimated_time" 
                name="estimated_time" 
                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            >
                <option value="">Berapa lama kira-kira?</option>
                <option value="0.5" {{ old('estimated_time') == '0.5' ? 'selected' : '' }}>⚡ 30 menit</option>
                <option value="1" {{ old('estimated_time') == '1' ? 'selected' : '' }}>🕐 1 jam</option>
                <option value="2" {{ old('estimated_time') == '2' ? 'selected' : '' }}>🕑 2 jam</option>
                <option value="4" {{ old('estimated_time') == '4' ? 'selected' : '' }}>🕓 4 jam (setengah hari)</option>
                <option value="8" {{ old('estimated_time') == '8' ? 'selected' : '' }}>🕗 8 jam (1 hari penuh)</option>
                <option value="16" {{ old('estimated_time') == '16' ? 'selected' : '' }}>📅 2 hari</option>
                <option value="24" {{ old('estimated_time') == '24' ? 'selected' : '' }}>🗓️ 3+ hari</option>
            </select>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex space-x-3 pt-4">
            <a href="{{ route('user.tasks') }}" class="flex-1 bg-gray-200 text-gray-800 py-4 px-4 rounded-lg text-center font-bold text-lg">
                ❌ Batal
            </a>
            <button type="submit" class="flex-1 bg-green-500 text-white py-4 px-4 rounded-lg font-bold text-lg">
                ✅ Buat Tugas
            </button>
        </div>
    </form>
</div>

<script>
// Auto-focus pada field pertama
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('title').focus();
});
</script>
@endsection
