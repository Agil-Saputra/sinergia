@extends('layouts.mobile')

@section('title', 'Buat Laporan - Sinergia')
@section('header', 'Buat Laporan')

@section('content')
<div class="p-4">
    <form method="POST" action="{{ route('user.reports.store') }}" class="space-y-4">
        @csrf

        <!-- Judul Laporan -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Laporan</label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan judul laporan"
            >
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kategori -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select
                id="category"
                name="category"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Pilih kategori</option>
                <option value="sales" {{ old('category') == 'sales' ? 'selected' : '' }}>Penjualan</option>
                <option value="finance" {{ old('category') == 'finance' ? 'selected' : '' }}>Keuangan</option>
                <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>Pemasaran</option>
                <option value="operations" {{ old('category') == 'operations' ? 'selected' : '' }}>Operasional</option>
                <option value="hr" {{ old('category') == 'hr' ? 'selected' : '' }}>Sumber Daya Manusia</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea
                id="description"
                name="description"
                rows="6"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Jelaskan laporan Anda secara rinci..."
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Prioritas -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Prioritas</label>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="priority" value="low" class="mr-3" {{ old('priority') == 'low' ? 'checked' : '' }}>
                    <span class="text-sm">Prioritas Rendah</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="priority" value="medium" class="mr-3" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                    <span class="text-sm">Prioritas Sedang</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="priority" value="high" class="mr-3" {{ old('priority') == 'high' ? 'checked' : '' }}>
                    <span class="text-sm">Prioritas Tinggi</span>
                </label>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex space-x-3 pt-4">
            <a href="{{ route('user.reports') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg text-center font-medium">
                Batal
            </a>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg font-medium">
                Kirim Laporan
            </button>
        </div>
    </form>
</div>
@endsection
