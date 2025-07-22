<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - Sinergia</title>
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
        <!-- Forgot Password Card -->
        <div class="fade-in w-full max-w-sm">
            <div class="text-center mb-6">
                <img src="{{ asset('logo.png') }}" alt="Logo Sinergia" class="mx-auto h-10 w-auto mb-4 md:h-12"
                     onerror="this.onerror=null; this.src='https://placehold.co/200x60/111827/FFFFFF?text=Sinergia&font=inter';">

                <h1 class="text-2xl md:text-3xl font-bold text-white">Lupa Password</h1>
                <p class="text-gray-400 mt-2 text-sm">Masukkan kode karyawan untuk mendapatkan password baru via WhatsApp</p>
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

                <form method="POST" action="{{ route('forgot-password.send') }}" class="space-y-4">
                    @csrf

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

                    <!-- Tombol Kirim -->
                    <div>
                        <button
                            type="submit"
                            class="w-full bg-green-600 text-white py-4 px-4 rounded-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors text-lg font-semibold"
                        >
                            KIRIM PASSWORD VIA WHATSAPP
                        </button>
                    </div>

                    <!-- Kembali ke Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 text-sm underline">
                            ← Kembali ke halaman login
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="fade-in mt-6 w-full max-w-sm bg-gray-800 border border-gray-700 rounded-lg p-4 text-center">
            <h3 class="text-sm font-medium text-gray-200 mb-2">Informasi:</h3>
            <div class="text-xs text-gray-400 space-y-1">
                <p>📱 Password akan dikirim ke nomor WhatsApp yang terdaftar</p>
                <p>🔐 Password baru akan dibuat secara otomatis</p>
                <p>⚠️ Jika nomor WhatsApp belum terdaftar, hubungi admin</p>
            </div>
        </div>
    </div>

    <script>
        // Auto uppercase employee code
        document.getElementById('employee_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Prevent multiple form submissions
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'MENGIRIM...';
        });
    </script>
</body>
</html>
