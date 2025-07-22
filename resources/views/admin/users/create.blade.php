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
    <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white shadow rounded-lg">
        @csrf
        <div class="px-6 py-8 space-y-6">
                        <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Employee Code -->
            <div>
                <label for="employee_code" class="block text-sm font-medium text-gray-700">
                    Kode Karyawan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('employee_code') border-red-300 @enderror"

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" id="role" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('role') border-red-300 @enderror">
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
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" id="password" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-300 @enderror">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">Password minimal 8 karakter.</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-3">
            <a href="{{ route('admin.users.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-save mr-2"></i>
                Buat Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
