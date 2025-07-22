<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Sinergia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827; /* gray-900 */
            color: #d1d5db; /* gray-300 */
        }
        /* Simple fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
        <!-- Login Card -->
        <div class="fade-in w-full max-w-sm">
            <div class="text-center mb-6">
                <!-- Gunakan helper `asset()` Laravel untuk memuat gambar dari folder /public -->
                <img src="{{ asset('logo.png') }}" alt="Logo Sinergia" class="mx-auto h-10 w-auto mb-4 md:h-12"
                     onerror="this.onerror=null; this.src='https://placehold.co/200x60/111827/FFFFFF?text=Sinergia&font=inter';">

                <h1 class="text-2xl md:text-3xl font-bold text-white">Sinergia</h1>
                <p class="text-gray-400 mt-2 text-sm">Masukkan kode karyawan untuk masuk</p>
            </div>

            <div class="bg-gray-800 border border-gray-700 p-6 md:p-8 rounded-lg shadow-2xl">
                <!-- Tampilkan Pesan Sukses -->
                @if(session('success'))
                    <div class="bg-green-900/50 border border-green-600 text-green-300 px-4 py-3 rounded-md mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tampilkan Pesan Kesalahan -->
                @if(session('error'))
                    <div class="bg-red-900/50 border border-red-600 text-red-300 px-4 py-3 rounded-md mb-6 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                    @csrf
                    
                    <!-- Hidden field to track form freshness -->
                    <input type="hidden" name="form_timestamp" value="{{ time() }}">

                    <!-- Kolom Kode Karyawan -->
                    <div>
                        <label for="employee_code" class="block text-sm font-medium text-gray-300 mb-2">
                            Kode Karyawan
                        </label>
                        <input
                            type="text"
                            id="employee_code"
                            name="employee_code"
                            value="{{ old('employee_code') }}"
                            required
                            maxlength="8"
                            class="w-full px-4 py-4 bg-gray-700 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-xl {{ $errors->has('employee_code') ? 'border-red-500' : '' }}"
                            placeholder="SBY09876"
                            style="letter-spacing: 3px; font-family: 'Courier New', monospace; text-align: center;"
                            autofocus
                        >
                        @error('employee_code')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kolom Password (Wajib) -->
                    <div id="passwordField">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Password <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-4 py-4 bg-gray-700 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-lg {{ $errors->has('password') ? 'border-red-500' : '' }}"
                            placeholder="Masukkan password"
                        >
                        @error('password')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Masuk dan Lupa Password -->
                    <div class="space-y-3">
                        <button
                            type="submit"
                            class="w-full bg-blue-600 text-white py-4 px-4 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors text-lg font-semibold"
                        >
                            MASUK & ABSEN
                        </button>
                        
                        <button
                            type="button"
                            onclick="showForgotPasswordModal()"
                            class="w-full bg-gray-600 text-white py-3 px-4 rounded-md hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors text-base font-medium uppercase"
                        >
                            Lupa Password?
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Lupa Password -->
    <div id="forgotPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 z-50" style="display: none;">
        <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 w-full max-w-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Reset Password via WhatsApp</h3>
                <button onclick="closeForgotPasswordModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4 text-sm text-gray-300">
                <p>Masukkan kode karyawan untuk mendapatkan password baru via WhatsApp.</p>
                <p class="mt-2 text-yellow-400">⚠️ Pastikan nomor WhatsApp Anda terdaftar di sistem.</p>
            </div>
            
            <form id="forgotPasswordForm" class="space-y-4">
                @csrf
                <div>
                    <label for="forgot_employee_code" class="block text-sm font-medium text-gray-300 mb-2">
                        Kode Karyawan
                    </label>
                    <input
                        type="text"
                        id="forgot_employee_code"
                        name="employee_code"
                        required
                        maxlength="8"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-lg"
                        placeholder="SBY09876"
                        style="letter-spacing: 3px; font-family: 'Courier New', monospace; text-align: center;"
                    >
                </div>
                
                <div class="flex space-x-3">
                    <button
                        type="button"
                        onclick="closeForgotPasswordModal()"
                        class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-md hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors font-medium"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        id="sendWhatsAppBtn"
                        class="flex-1 bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors font-medium"
                    >
                        <span class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            Kirim ke WhatsApp
                        </span>
                    </button>
                </div>
            </form>
            
            <div id="forgotPasswordMessage" class="mt-4" style="display: none;"></div>
        </div>
    </div>

    <script>
        // Auto uppercase and format employee code
        document.getElementById('employee_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Auto uppercase for forgot password modal
        document.getElementById('forgot_employee_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Modal functions
        function showForgotPasswordModal() {
            document.getElementById('forgotPasswordModal').style.display = 'flex';
            document.getElementById('forgot_employee_code').focus();
        }

        function closeForgotPasswordModal() {
            document.getElementById('forgotPasswordModal').style.display = 'none';
            document.getElementById('forgotPasswordForm').reset();
            document.getElementById('forgotPasswordMessage').style.display = 'none';
        }

        // Handle forgot password form submission
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = document.getElementById('sendWhatsAppBtn');
            const originalContent = submitButton.innerHTML;
            const employeeCode = document.getElementById('forgot_employee_code').value;
            
            if (employeeCode.length < 8) {
                showMessage('Kode karyawan harus 8 karakter', 'error');
                return;
            }
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengirim...
                </span>
            `;
            
            fetch('/forgot-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    employee_code: employeeCode
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    // Reset form after successful send
                    document.getElementById('forgot_employee_code').value = '';
                    setTimeout(() => {
                        closeForgotPasswordModal();
                    }, 5000); // Close modal after 5 seconds
                } else {
                    showMessage(data.message || 'Terjadi kesalahan. Coba lagi.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Terjadi kesalahan koneksi. Periksa jaringan Anda dan coba lagi.', 'error');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = originalContent;
            });
        });

        function showMessage(message, type) {
            const messageDiv = document.getElementById('forgotPasswordMessage');
            messageDiv.style.display = 'block';
            messageDiv.className = `mt-4 px-4 py-3 rounded-md text-sm ${
                type === 'success' 
                    ? 'bg-green-900/50 border border-green-600 text-green-300' 
                    : 'bg-red-900/50 border border-red-600 text-red-300'
            }`;
            messageDiv.textContent = message;
        }

        // Prevent multiple form submissions for main login
        document.querySelector('#loginForm').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'MASUK...';
        });

        // Close modal when clicking outside
        document.getElementById('forgotPasswordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeForgotPasswordModal();
            }
        });

        // Refresh CSRF token every 10 minutes to prevent expiration
        setInterval(function() {
            fetch('/login', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newToken = doc.querySelector('meta[name="csrf-token"]');
                const currentTokenMeta = document.querySelector('meta[name="csrf-token"]');
                const currentTokenInputs = document.querySelectorAll('input[name="_token"]');
                
                if (newToken && currentTokenMeta) {
                    currentTokenMeta.content = newToken.content;
                    currentTokenInputs.forEach(input => {
                        input.value = newToken.content;
                    });
                }
            })
            .catch(error => {
                console.log('Token refresh failed:', error);
            });
        }, 600000); // 10 minutes
    </script>
</body>
</html>
