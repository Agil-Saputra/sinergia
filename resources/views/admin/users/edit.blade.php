@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Pengguna</h1>
            <p class="mt-2 text-gray-600">Ubah informasi pengguna</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.show', $user) }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                <i class="fas fa-eye mr-2"></i>
                Lihat Detail
            </a>
            <a href="{{ route('admin.users.index') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- User Info Card -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Edit Form -->
    <div class="lg:col-span-2">
        <div class="card-modern p-8">
            <div class="flex items-center mb-8">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center">
                    <span class="text-white font-bold text-xl">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    <!-- Name -->
                    <div class="group">
                        <label for="name" class="block text-sm font-semibold text-gray-800 mb-3">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('name') border-red-300 focus:ring-red-500 @enderror"
                               placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah</p>
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-gray-800 mb-3">
                            Alamat Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('email') border-red-300 focus:ring-red-500 @enderror"
                               placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah</p>
                    </div>

                    <!-- Employee Code -->
                    <div class="group">
                        <label for="employee_code" class="block text-sm font-semibold text-gray-800 mb-3">
                            Kode Karyawan
                        </label>
                        <input type="text" 
                               name="employee_code" 
                               id="employee_code" 
                               value="{{ old('employee_code', $user->employee_code) }}"
                               class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('employee_code') border-red-300 focus:ring-red-500 @enderror"
                               placeholder="EMP001">
                        @error('employee_code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah</p>
                    </div>

                    <!-- Phone Number -->
                    <div class="group">
                        <label for="phone_number" class="block text-sm font-semibold text-gray-800 mb-3">
                            Nomor Telepon
                        </label>
                        <input type="tel" 
                               name="phone_number" 
                               id="phone_number" 
                               value="{{ old('phone_number', $user->phone_number) }}"
                               class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('phone_number') border-red-300 focus:ring-red-500 @enderror"
                               placeholder="08xxxxxxxxxx">
                        @error('phone_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="group">
                        <label for="role" class="block text-sm font-semibold text-gray-800 mb-3">
                            Role
                        </label>
                        <div class="relative">
                            <select name="role" 
                                    id="role"
                                    class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 appearance-none cursor-pointer @error('role') border-red-300 focus:ring-red-500 @enderror">
                                <option value="">Pilih role (kosongkan jika tidak ingin mengubah)</option>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                    Karyawan
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah</p>
                    </div>

                    <!-- Password Section -->
                    <div class="border-t-2 border-gray-100 pt-8">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 mb-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                Ubah Password (Opsional)
                            </h3>
                            <p class="text-sm text-gray-600">Biarkan kosong jika tidak ingin mengubah password</p>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- New Password -->
                            <div class="group">
                                <label for="password" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 @error('password') border-red-300 focus:ring-red-500 @enderror"
                                           placeholder="Masukkan password baru">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <button type="button" 
                                                onclick="togglePassword('password')"
                                                class="text-gray-400 hover:text-blue-500 transition-colors focus:outline-none">
                                            <svg class="w-5 h-5" id="password-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="group">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-800 mb-3">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation"
                                           class="block w-full px-4 py-4 text-gray-900 bg-white border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-300"
                                           placeholder="Konfirmasi password baru">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <button type="button" 
                                                onclick="togglePassword('password_confirmation')"
                                                class="text-gray-400 hover:text-blue-500 transition-colors focus:outline-none">
                                            <svg class="w-5 h-5" id="password_confirmation-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4 pt-8 border-t-2 border-gray-100">
                        <button type="button" 
                                onclick="resetForm()"
                                class="px-6 py-3 border-2 border-yellow-300 rounded-2xl text-sm font-semibold text-yellow-700 bg-yellow-50 hover:bg-yellow-100 hover:border-yellow-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" 
                           class="px-8 py-3 border-2 border-gray-300 rounded-2xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            Batal
                        </a>
                        <button type="submit" 
                                class="btn-primary px-8 py-3 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- User Info & Actions -->
    <div class="space-y-6">
        <!-- Current Status -->
        <div class="card-modern p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Status Saat Ini</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Role</span>
                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ $user->role === 'admin' ? 'Administrator' : 'Karyawan' }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Status</span>
                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                        Aktif
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Bergabung</span>
                    <span class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        @if($user->role === 'user')
        <!-- Quick Stats -->
        <div class="card-modern p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tasks text-blue-600 text-sm"></i>
                        </div>
                        <span class="ml-3 text-sm text-gray-600">Total Tugas</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">{{ $user->tasks()->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                        </div>
                        <span class="ml-3 text-sm text-gray-600">Selesai</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">{{ $user->tasks()->where('status', 'completed')->count() }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Warning -->
        <div class="card-modern p-6 border-l-4 border-yellow-400 bg-yellow-50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Perubahan role akan mempengaruhi akses pengguna</li>
                            <li>Kode karyawan harus unik</li>
                            <li>Password baru minimal 8 karakter</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Toggle JavaScript -->
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-toggle-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        // Change to eye-slash icon
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
    } else {
        field.type = 'password';
        // Change back to eye icon
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset semua perubahan ke nilai asli?')) {
        // Reset all fields to original values
        document.getElementById('name').value = '{{ $user->name }}';
        document.getElementById('email').value = '{{ $user->email }}';
        document.getElementById('employee_code').value = '{{ $user->employee_code }}';
        document.getElementById('phone_number').value = '{{ $user->phone_number ?? '' }}';
        document.getElementById('role').value = '{{ $user->role }}';
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
        
        // Reset visual styling
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.classList.remove('border-red-300', 'border-green-300');
            input.classList.add('border-gray-200');
        });
    }
}

// Add form validation feedback
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select');
    
    // Remove the required validation since we want partial updates
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            // Remove previous validation styling
            this.classList.remove('border-red-300', 'border-green-300');
            this.classList.add('border-gray-200');
        });
        
        input.addEventListener('input', function() {
            // Remove validation styling while typing
            this.classList.remove('border-red-300', 'border-green-300');
            this.classList.add('border-gray-200');
        });
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        let hasChanges = false;
        const currentValues = {
            name: '{{ $user->name }}',
            email: '{{ $user->email }}',
            employee_code: '{{ $user->employee_code }}',
            phone_number: '{{ $user->phone_number ?? '' }}',
            role: '{{ $user->role }}'
        };

        // Check if any field has been changed
        inputs.forEach(input => {
            if (input.name === 'password' || input.name === 'password_confirmation') {
                if (input.value.trim() !== '') {
                    hasChanges = true;
                }
            } else if (input.name in currentValues) {
                if (input.value !== currentValues[input.name]) {
                    hasChanges = true;
                }
            }
        });

        if (!hasChanges) {
            e.preventDefault();
            alert('Tidak ada perubahan yang terdeteksi. Silakan ubah setidaknya satu field untuk memperbarui data.');
            return false;
        }

        // Validate password confirmation if password is provided
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password && password !== passwordConfirmation) {
            e.preventDefault();
            alert('Konfirmasi password tidak cocok dengan password baru.');
            document.getElementById('password_confirmation').focus();
            return false;
        }
    });
});
</script>
@endsection
