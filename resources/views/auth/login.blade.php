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

                <h1 class="text-2xl md:text-3xl font-bold text-white">Sistem Absensi</h1>
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

                    <!-- Kolom Password (Opsional) -->
                    <div id="passwordField" style="display: none;">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Password (jika ada)
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-4 bg-gray-700 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-lg {{ $errors->has('password') ? 'border-red-500' : '' }}"
                            placeholder="Masukkan password"
                        >
                        @error('password')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        
                        <!-- Link Lupa Password -->
                        <div class="mt-2 text-right">
                            <a href="{{ route('forgot-password') }}" class="text-blue-400 hover:text-blue-300 text-sm underline">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <!-- Ingat Saya -->
                    <div class="flex items-center justify-center">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="h-4 w-4 bg-gray-700 border-gray-600 text-blue-500 focus:ring-blue-500 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-400">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Tombol Masuk -->
                    <div>
                        <button
                            type="submit"
                            class="w-full bg-blue-600 text-white py-4 px-4 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors text-lg font-semibold"
                        >
                            MASUK & ABSEN
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Akun Uji Coba (Opsional) -->
        <div class="fade-in mt-6 w-full max-w-sm bg-gray-800 border border-gray-700 rounded-lg p-4 text-center">
            <h3 class="text-sm font-medium text-gray-200 mb-2">Contoh Kode Karyawan:</h3>
            <div class="text-xs text-gray-400 space-y-1">
                <p><strong>Admin:</strong> SBY00001 (password: admin123)</p>
                <p><strong>Tanpa Password:</strong> SBY09876, SBY09878</p>
                <p><strong>Dengan Password:</strong> SBY09877 (sari123), SBY09879 (indah123)</p>
                <p class="text-green-400 mt-2">✓ Otomatis absen masuk setelah login</p>
                <p class="text-blue-400 mt-1">📱 Gunakan "Lupa Password" untuk testing WhatsApp</p>
            </div>
        </div>
    </div>

    <script>
        // Auto uppercase and format employee code
        document.getElementById('employee_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Check if user needs password after typing employee code
        document.getElementById('employee_code').addEventListener('blur', function(e) {
            if (e.target.value.length === 8) {
                checkIfPasswordRequired(e.target.value);
            }
        });

        // Function to check if password is required for this employee code
        function checkIfPasswordRequired(employeeCode) {
            fetch('/check-password-required', {
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
                const passwordField = document.getElementById('passwordField');
                if (data.password_required) {
                    passwordField.style.display = 'block';
                    document.getElementById('password').focus();
                } else {
                    passwordField.style.display = 'none';
                }
            })
            .catch(error => {
                console.log('Error checking password requirement:', error);
            });
        }

        // Auto submit form when employee code is complete (8 characters) and no password is required
        document.getElementById('employee_code').addEventListener('input', function(e) {
            if (e.target.value.length === 8) {
                // Check if password field is visible
                const passwordField = document.getElementById('passwordField');
                if (passwordField.style.display === 'none' || !passwordField.style.display) {
                    // Small delay to allow user to see the complete code and ensure CSRF token is ready
                    setTimeout(() => {
                        // Re-check if form still has valid CSRF token
                        const form = document.querySelector('form');
                        const csrfToken = form.querySelector('input[name="_token"]');
                        
                        if (csrfToken && csrfToken.value) {
                            form.submit();
                        } else {
                            // If CSRF token is missing, reload page
                            location.reload();
                        }
                    }, 800); // Increased delay
                }
            }
        });

        // Show password field immediately if there's a password error from server
        @if($errors->has('password'))
            document.getElementById('passwordField').style.display = 'block';
        @endif

        // Prevent multiple form submissions
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'MASUK...';
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
                const currentTokenInput = document.querySelector('input[name="_token"]');
                
                if (newToken && currentTokenMeta && currentTokenInput) {
                    currentTokenMeta.content = newToken.content;
                    currentTokenInput.value = newToken.content;
                }
            })
            .catch(error => {
                console.log('Token refresh failed:', error);
            });
        }, 600000); // 10 minutes
    </script>
</body>
</html>
