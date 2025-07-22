<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinergia - Manajemen Fasilitas Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827; /* gray-900 */
            color: #d1d5db; /* gray-300 */
        }
        .gradient-text {
            background: linear-gradient(to right, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.2), 0 8px 10px -6px rgb(0 0 0 / 0.2);
        }
    </style>
</head>
<body class="antialiased">

    <header class="sticky top-0 z-50 bg-gray-900/70 backdrop-blur-lg border-b border-gray-700">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <!-- Ganti dengan logo Anda -->
                    <img src="{{ asset('logo.png') }}" alt="logo sinergia" class="h-8 w-auto" onerror="this.style.display='none'">
                    <span class="text-xl font-semibold text-white">Sinergia</span>
                </div>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md text-sm font-semibold hover:bg-blue-500 transition-colors">
                    Masuk
                </a>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative bg-gray-900">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center py-20 sm:py-24">
                <!-- Left Column -->
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                        Standar Baru untuk <span class="gradient-text">Kebersihan & Perawatan</span> Gedung
                    </h1>
                    <p class="mt-5 text-lg text-gray-400">
                        Platform digital untuk mengelola tim cleaning service dan teknisi maintenance. Pastikan setiap sudut gedung terawat sempurna dengan sistem yang terukur.
                    </p>
                    <ul class="mt-6 space-y-3 text-left">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-gray-300">Jadwal kebersihan dan checklist digital yang jelas.</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                             <span class="text-gray-300">Penugasan perbaikan teknis yang cepat dan terarah.</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                           <span class="text-gray-300">Laporan instan dengan bukti foto dari lapangan.</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-md text-base font-semibold hover:bg-blue-500 transition-colors">
                            Lihat Demo
                        </a>
                    </div>
                </div>
                <!-- Right Column (Dynamic Visual) -->
                <div class="relative h-96 flex items-center justify-center">
                    <!-- Base Mockup -->
                    <div class="absolute w-full max-w-sm bg-gray-800 border border-gray-700 rounded-lg p-4 shadow-2xl z-10">
                         <p class="text-sm font-semibold text-white">Jadwal Area Lobi: <span class="text-gray-400">22 Juli 2025</span></p>
                         <div class="mt-2 space-y-2">
                            <div class="bg-gray-700 p-2 rounded-md text-xs text-white">Pembersihan Lantai & Kaca <span class="text-green-400 float-right">✔ Selesai</span></div>
                            <div class="bg-blue-900/50 p-2 rounded-md text-xs text-white ring-2 ring-blue-500">Perbaikan AC Sentral <span class="text-blue-400 float-right">⦿ Dikerjakan</span></div>
                            <div class="bg-gray-700 p-2 rounded-md text-xs text-white">Cek Toilet & Isi Ulang Sabun <span class="text-gray-400 float-right">... Menunggu</span></div>
                         </div>
                    </div>
                     <!-- Floating Card 1 -->
                    <div class="absolute top-0 right-0 w-48 bg-gray-800 border border-gray-700 rounded-lg p-2 shadow-lg transform rotate-6 translate-x-12 -translate-y-8 card-hover">
                        <p class="text-xs font-bold text-white">Laporan Teknisi</p>
                        <p class="text-xs text-gray-400 mt-1">"Filter AC di ruang server kotor, perlu segera diganti."</p>
                    </div>
                    <!-- Floating Card 2 -->
                    <div class="absolute bottom-0 left-0 w-52 bg-gray-800 border border-gray-700 rounded-lg p-2 shadow-lg transform -rotate-3 -translate-x-10 translate-y-12 card-hover">
                         <p class="text-xs font-bold text-white">Laporan Kebersihan</p>
                         <p class="text-xs text-gray-400 mt-1">"Ditemukan tumpahan kopi di dekat lift lantai 2."</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 sm:py-24 bg-gray-800/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-3xl font-bold text-white">Solusi Lengkap Manajemen Fasilitas</h2>
                    <p class="mt-4 text-lg text-gray-400">Dari jadwal rutin hingga penanganan darurat, semua dalam satu platform.</p>
                </div>
                <div class="mt-16 grid md:grid-cols-3 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 card-hover">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500/20 text-blue-400 mb-4">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Checklist Digital</h3>
                        <p class="mt-2 text-gray-400">Pastikan setiap prosedur kebersihan dan perawatan diikuti dengan benar melalui checklist interaktif di ponsel.</p>
                    </div>
                    <!-- Feature Card 2 -->
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 card-hover">
                         <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500/20 text-blue-400 mb-4">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Pelaporan Masalah</h3>
                        <p class="mt-2 text-gray-400">Tim dapat langsung melaporkan kerusakan, kebutuhan pembersihan, atau stok habis dengan bukti foto.</p>
                    </div>
                    <!-- Feature Card 3 -->
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 card-hover">
                         <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500/20 text-blue-400 mb-4">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.325 3.478.097 6.963-.064 10.448-.282a2.25 2.25 0 002.298-2.298V7.875a2.25 2.25 0 00-2.298-2.298h-4.512a2.25 2.25 0 00-2.298 2.298v6.525A3.375 3.375 0 0112 15z" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Riwayat & Laporan</h3>
                        <p class="mt-2 text-gray-400">Lihat riwayat pembersihan dan perbaikan di setiap area untuk audit dan evaluasi kinerja.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="login" class="py-20">
            <div class="max-w-4xl mx-auto text-center px-6">
                 <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Tingkatkan Kualitas Layanan Fasilitas Anda
                </h2>
                <p class="mt-4 text-lg text-gray-400">
                    Hubungi kami untuk demo atau masuk ke portal jika Anda sudah memiliki akses.
                </p>
                <a href="{{ route('login') }}" class="mt-8 inline-block bg-blue-600 text-white px-8 py-3 rounded-md text-base font-semibold hover:bg-blue-500 transition-colors">
                    Login ke Portal
                </a>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 border-t border-gray-700">
        <div class="max-w-7xl mx-auto py-8 px-6 lg:px-8 text-center">
            <p class="text-gray-400">
                &copy; 2025 Sinergia. Platform Manajemen Tim Kebersihan & Maintenance.
            </p>
        </div>
    </footer>

</body>
</html>
