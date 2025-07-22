@extends('layouts.mobile')

@section('title', 'Profile - Sinergia')
@section('header', 'Profile Saya')

@section('content')
<div class="p-4 space-y-6">

    @if(session('success'))
    <div class="bg-green-100 border-2 border-green-400 text-green-800 px-4 py-3 rounded-lg text-lg font-medium text-center">
        {{ session('success') }}
    </div>
    @endif

    <!-- User Information -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Informasi Karyawan</h2>
        </div>
        
        <!-- Avatar Display -->
        <div class="text-center mb-6">
            <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="text-white text-3xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <p class="text-gray-600 font-medium">{{ Auth::user()->name }}</p>
        </div>
        
        <div class="space-y-4">
            <!-- Nama Lengkap -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                        <i class="fas fa-user text-xs"></i>
                    </div>
                    <label class="text-lg font-semibold text-gray-800">Nama Lengkap</label>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-base text-gray-600" id="displayName">{{ Auth::user()->name }}</p>
                        <input type="text" id="editName" value="{{ Auth::user()->name }}" 
                               class="hidden w-full px-3 py-2 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <button onclick="toggleEdit('name')" id="editNameBtn"
                            class="bg-gray-100 text-gray-700 py-1 px-3 rounded-lg text-sm font-medium hover:bg-gray-200">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                </div>
            </div>

            <!-- Kode Karyawan -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                        <i class="fas fa-id-card text-xs"></i>
                    </div>
                    <label class="text-lg font-semibold text-gray-800">Kode Karyawan</label>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-base text-gray-600" id="displayEmployeeCode">
                            <span id="employeeCodeValue" class="hidden">{{ Auth::user()->employee_code ?? 'Belum diatur' }}</span>
                            <span id="employeeCodeHidden">••••••••••</span>
                        </p>
                    </div>
                    <button onclick="toggleEmployeeCode()" id="toggleCodeBtn"
                            class="bg-gray-100 text-gray-700 py-1 px-3 rounded-lg text-sm font-medium hover:bg-gray-200">
                        <i class="fas fa-eye mr-1"></i>Lihat
                    </button>
                </div>
            </div>

            <!-- Nomor HP -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                        <i class="fas fa-phone text-xs"></i>
                    </div>
                    <label class="text-lg font-semibold text-gray-800">Nomor HP</label>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-base text-gray-600" id="displayPhoneNumber">{{ Auth::user()->phone_number ?? 'Belum diatur' }}</p>
                        <input type="text" id="editPhoneNumber" value="{{ Auth::user()->phone_number }}" 
                               class="hidden w-full px-3 py-2 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                               placeholder="Masukkan nomor HP">
                    </div>
                    <button onclick="toggleEdit('phoneNumber')" id="editPhoneNumberBtn"
                            class="bg-gray-100 text-gray-700 py-1 px-3 rounded-lg text-sm font-medium hover:bg-gray-200">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                </div>
            </div>
        </div>

        <!-- Save Changes Button (Hidden by default) -->
        <div id="saveChangesBtn" class="hidden mt-6">
            <button onclick="saveChanges()" 
                    class="w-full bg-green-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 shadow-lg">
                <i class="fas fa-save mr-2"></i>
                SIMPAN PERUBAHAN
            </button>
        </div>
    </div>

    <!-- Change Password Section -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Ganti Password</h2>
        </div>
        
        <div id="changePasswordForm" class="hidden space-y-4">
            <!-- Current Password -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <label class="text-lg font-semibold text-gray-800">Password Lama</label>
                </div>
                <input type="password" id="currentPassword" 
                       class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       placeholder="Masukkan password lama">
                <p id="currentPasswordError" class="text-red-500 text-sm mt-2 hidden"></p>
            </div>

            <!-- New Password -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <label class="text-lg font-semibold text-gray-800">Password Baru</label>
                </div>
                <input type="password" id="newPassword" 
                       class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       placeholder="Masukkan password baru">
                <p id="newPasswordError" class="text-red-500 text-sm mt-2 hidden"></p>
            </div>

            <!-- Confirm New Password -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <label class="text-lg font-semibold text-gray-800">Konfirmasi Password Baru</label>
                </div>
                <input type="password" id="confirmPassword" 
                       class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       placeholder="Konfirmasi password baru">
                <p id="confirmPasswordError" class="text-red-500 text-sm mt-2 hidden"></p>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3">
                <button onclick="cancelChangePassword()" 
                        class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
                <button onclick="submitChangePassword()" 
                        class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Password
                </button>
            </div>
        </div>

        <!-- Toggle Button -->
        <button id="showChangePasswordBtn" onclick="showChangePasswordForm()" 
                class="w-full bg-blue-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg">
            <i class="fas fa-key mr-2"></i>
            GANTI PASSWORD
        </button>
    </div>

    <!-- Logout Button -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 shadow-lg">
                <i class="fas fa-sign-out-alt mr-2"></i>
                KELUAR
            </button>
        </form>
    </div>
</div>

<script>
let isEditing = false;

function toggleEmployeeCode() {
    const valueSpan = document.getElementById('employeeCodeValue');
    const hiddenSpan = document.getElementById('employeeCodeHidden');
    const button = document.getElementById('toggleCodeBtn');
    
    if (valueSpan.classList.contains('hidden')) {
        valueSpan.classList.remove('hidden');
        hiddenSpan.classList.add('hidden');
        button.innerHTML = '<i class="fas fa-eye-slash mr-1"></i>Sembunyikan';
    } else {
        valueSpan.classList.add('hidden');
        hiddenSpan.classList.remove('hidden');
        button.innerHTML = '<i class="fas fa-eye mr-1"></i>Lihat';
    }
}

function toggleEdit(field) {
    const displayElement = document.getElementById(`display${field.charAt(0).toUpperCase() + field.slice(1)}`);
    const editElement = document.getElementById(`edit${field.charAt(0).toUpperCase() + field.slice(1)}`);
    const buttonElement = document.getElementById(`edit${field.charAt(0).toUpperCase() + field.slice(1)}Btn`);
    const saveBtn = document.getElementById('saveChangesBtn');
    
    if (displayElement.classList.contains('hidden')) {
        // Cancel edit
        displayElement.classList.remove('hidden');
        editElement.classList.add('hidden');
        buttonElement.innerHTML = '<i class="fas fa-edit mr-1"></i>Edit';
        editElement.value = displayElement.textContent;
        
        // Check if any field is still being edited
        if (!document.getElementById('editName').classList.contains('hidden') || 
            !document.getElementById('editPhoneNumber').classList.contains('hidden')) {
            saveBtn.classList.remove('hidden');
        } else {
            saveBtn.classList.add('hidden');
        }
    } else {
        // Start edit
        displayElement.classList.add('hidden');
        editElement.classList.remove('hidden');
        editElement.focus();
        buttonElement.innerHTML = '<i class="fas fa-times mr-1"></i>Batal';
        saveBtn.classList.remove('hidden');
    }
}

function saveChanges() {
    const formData = new FormData();
    
    if (!document.getElementById('editName').classList.contains('hidden')) {
        formData.append('name', document.getElementById('editName').value);
    }
    
    if (!document.getElementById('editPhoneNumber').classList.contains('hidden')) {
        formData.append('phone_number', document.getElementById('editPhoneNumber').value);
    }
    
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('{{ route('user.profile.update') }}', {
        method: 'POST',
        body: formData
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

// Change Password Functions
function showChangePasswordForm() {
    document.getElementById('changePasswordForm').classList.remove('hidden');
    document.getElementById('showChangePasswordBtn').classList.add('hidden');
    document.getElementById('currentPassword').focus();
}

function cancelChangePassword() {
    document.getElementById('changePasswordForm').classList.add('hidden');
    document.getElementById('showChangePasswordBtn').classList.remove('hidden');
    
    // Clear all fields
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
    
    // Clear all error messages
    clearPasswordErrors();
}

function clearPasswordErrors() {
    document.getElementById('currentPasswordError').classList.add('hidden');
    document.getElementById('newPasswordError').classList.add('hidden');
    document.getElementById('confirmPasswordError').classList.add('hidden');
}

function validatePasswords() {
    clearPasswordErrors();
    let isValid = true;
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Validate current password
    if (!currentPassword) {
        document.getElementById('currentPasswordError').textContent = 'Password lama harus diisi';
        document.getElementById('currentPasswordError').classList.remove('hidden');
        isValid = false;
    }
    
    // Validate new password
    if (!newPassword) {
        document.getElementById('newPasswordError').textContent = 'Password baru harus diisi';
        document.getElementById('newPasswordError').classList.remove('hidden');
        isValid = false;
    } else if (newPassword.length < 6) {
        document.getElementById('newPasswordError').textContent = 'Password baru minimal 6 karakter';
        document.getElementById('newPasswordError').classList.remove('hidden');
        isValid = false;
    }
    
    // Validate confirm password
    if (!confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Konfirmasi password harus diisi';
        document.getElementById('confirmPasswordError').classList.remove('hidden');
        isValid = false;
    } else if (newPassword !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Konfirmasi password tidak sesuai';
        document.getElementById('confirmPasswordError').classList.remove('hidden');
        isValid = false;
    }
    
    return isValid;
}

function submitChangePassword() {
    if (!validatePasswords()) {
        return;
    }
    
    const submitBtn = event.target;
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    
    const formData = new FormData();
    formData.append('current_password', document.getElementById('currentPassword').value);
    formData.append('new_password', document.getElementById('newPassword').value);
    formData.append('new_password_confirmation', document.getElementById('confirmPassword').value);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('{{ route('user.password.update') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Password berhasil diubah!');
            cancelChangePassword();
        } else {
            if (data.errors) {
                if (data.errors.current_password) {
                    document.getElementById('currentPasswordError').textContent = data.errors.current_password[0];
                    document.getElementById('currentPasswordError').classList.remove('hidden');
                }
                if (data.errors.new_password) {
                    document.getElementById('newPasswordError').textContent = data.errors.new_password[0];
                    document.getElementById('newPasswordError').classList.remove('hidden');
                }
            } else {
                alert(data.error || 'Terjadi kesalahan');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}
</script>
@endsection
