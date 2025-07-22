<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <!-- Login Card -->
        <div class="fade-in w-full max-w-md">
            <div class="text-center mb-8">
                <!-- Gunakan helper `asset()` Laravel untuk memuat gambar dari folder /public -->
                <img src="{{ asset('logo.png') }}" alt="Logo Sinergia" class="mx-auto h-12 w-auto mb-4"
                     onerror="this.onerror=null; this.src='https://placehold.co/200x60/111827/FFFFFF?text=Sinergia&font=inter';">

                <h1 class="text-3xl font-bold text-white">Masuk ke Akun Anda</h1>
                <p class="text-gray-400 mt-2">Lanjutkan untuk mengelola tugas tim Anda.</p>
            </div>

            <div class="bg-gray-800 border border-gray-700 p-8 rounded-lg shadow-2xl">
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

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Kolom Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Alamat Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('email') ? 'border-red-500' : '' }}"
                            placeholder="anda@email.com"
                        >
                        @error('email')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kolom Kata Sandi -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Kata Sandi
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('password') ? 'border-red-500' : '' }}"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ingat Saya -->
                    <div class="flex items-center">
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
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors"
                        >
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Akun Uji Coba (Opsional) -->
        <div class="fade-in mt-8 w-full max-w-md bg-gray-800 border border-gray-700 rounded-lg p-4 text-center">
            <h3 class="text-sm font-medium text-gray-200 mb-2">Akun Uji Coba:</h3>
            <div class="text-xs text-gray-400 space-y-1">
                <p><strong>Admin:</strong> admin@example.com</p>
                <p><strong>Pengguna:</strong> user@example.com</p>
                <p><strong>Kata Sandi:</strong> password123</p>
            </div>
        </div>
    </div>
</body>
</html>
