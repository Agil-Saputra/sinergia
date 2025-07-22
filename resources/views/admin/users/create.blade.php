@extends('layouts.admin')

@section('title', 'Buat Pengguna')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Buat Pengguna Baru</h1>
            <p class="mt-2 text-sm text-gray-700">Tambahkan pengguna baru ke sistem.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Pengguna
        </a>
    </div>
</div>

<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white shadow-lg rounded-2xl border-2 border-gray-100">
        @csrf
        <div class="px-6 py-8 space-y-6">
                        <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="block w-full px-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200 @error('name') !border-red-300 @enderror">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="block w-full px-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200 @error('email') !border-red-300 @enderror">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Employee Code -->
            <div>
                <label for="employee_code" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Karyawan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code') }}" required
                       class="block w-full px-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200 @error('employee_code') !border-red-300 @enderror">
                @error('employee_code')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Telepon
                </label>
                <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                       class="block w-full px-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200 @error('phone_number') !border-red-300 @enderror"
                       placeholder="08xxxxxxxxxx">
                @error('phone_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" id="role" required
                        class="block w-full px-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200 @error('role') !border-red-300 @enderror">
                    <option value="">Pilih role</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Karyawan</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" id="password" required
                       class="block w-full px-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200 @error('password') !border-red-300 @enderror">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">Password minimal 8 karakter.</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="block w-full px-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200">
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl flex justify-end space-x-3 border-t border-gray-200">
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-lg">
                Batal
            </a>
            <button type="submit" 
                    class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-3 px-6 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-lg">
                Buat Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
