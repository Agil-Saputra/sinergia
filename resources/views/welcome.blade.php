<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Dasbor Efisiensi Kerja</title>
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
                    <img src="{{ asset('logo.png') }}" alt="logo sinergia">
                    <span class="text-xl font-semibold text-white">Sinergia</span>
                </div>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md text-sm font-semibold hover:bg-blue-500 transition-colors">
                    Masuk
                </a>
            </div>
        </nav>
    </header>

    <main>
        <section class="relative bg-gray-900">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center py-20 sm:py-24">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                        Transformasi Digital untuk <span class="gradient-text">Tim Lapangan</span> Anda
                    </h1>
                    <p class="mt-5 text-lg text-gray-400">
                        Otomatiskan penugasan, lacak progres secara real-time, dan dapatkan laporan instan. Tingkatkan efisiensi kerja tim Anda ke level berikutnya.
                    </p>
                    <ul class="mt-6 space-y-3 text-left">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-gray-300">Transparansi penuh atas semua tugas harian.</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                             <span class="text-gray-300">Pelaporan kendala cepat, langsung dari lapangan.</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                           <span class="text-gray-300">Analitik sederhana untuk mengukur produktivitas.</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-md text-base font-semibold hover:bg-blue-500 transition-colors">
                            Mulai Sekarang
                        </a>
                    </div>
                </div>
                <div class="relative h-96 flex items-center justify-center">
                    <div class="absolute w-full max-w-sm bg-gray-800 border border-gray-700 rounded-lg p-4 shadow-2xl z-10">
                         <p class="text-sm font-semibold text-white">Tugas Hari Ini: <span class="text-gray-400">22 Juli 2025</span></p>
                         <div class="mt-2 space-y-2">
                            <div class="bg-gray-700 p-2 rounded-md text-xs text-white">Inspeksi Area Gudang A <span class="text-green-400 float-right">✔ Selesai</span></div>
                            <div class="bg-blue-900/50 p-2 rounded-md text-xs text-white ring-2 ring-blue-500">Perbaikan Pipa R. Pompa <span class="text-blue-400 float-right">⦿ Sedang Dikerjakan</span></div>
                            <div class="bg-gray-700 p-2 rounded-md text-xs text-white">Cek Stok Barang Masuk <span class="text-gray-400 float-right">... Menunggu</span></div>
                         </div>
                    </div>
                     <div class="absolute top-0 right-0 w-48 bg-gray-800 border border-gray-700 rounded-lg p-2 shadow-lg transform rotate-6 translate-x-12 -translate-y-8 card-hover">
                        <p class="text-xs font-bold text-white">Laporan Masuk</p>
                        <p class="text-xs text-gray-400 mt-1">"Alat bor rusak di Gudang A, butuh pengganti."</p>
                    </div>
                    <div class="absolute bottom-0 left-0 w-52 bg-gray-800 border border-gray-700 rounded-lg p-2 shadow-lg transform -rotate-3 -translate-x-10 translate-y-12 card-hover">
                         <p class="text-xs font-bold text-white">Notifikasi Supervisor</p>
                         <p class="text-xs text-gray-400 mt-1">"Tim B, mohon segera menuju area darurat."</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 sm:py-24 bg-gray-800/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-3xl font-bold text-white">Fitur Unggulan Platform</h2>
                    <p class="mt-4 text-lg text-gray-400">Alat yang tepat untuk setiap tahapan kerja, dari penugasan hingga pelaporan.</p>
                </div>
                <div class="mt-16 grid md:grid-cols-3 gap-8">
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 card-hover">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500/20 text-blue-400 mb-4">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125z" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Manajemen Tugas</h3>
                        <p class="mt-2 text-gray-400">Buat, tugaskan, dan atur prioritas pekerjaan dengan beberapa klik. Semua terdokumentasi secara digital.</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 card-hover">
                         <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500/20 text-blue-400 mb-4">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Akses Mobile</h3>
                        <p class="mt-2 text-gray-400">Pekerja dapat melihat tugas dan mengirim laporan langsung dari ponsel, bahkan di area dengan sinyal lemah.</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 card-hover">
                         <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500/20 text-blue-400 mb-4">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1.5-1.5m1.5 1.5l1.5-1.5m0 0l-1.5 1.5m1.5-1.5l1.5 1.5" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Dasbor Analitik</h3>
                        <p class="mt-2 text-gray-400">Pantau performa tim, waktu penyelesaian tugas, dan metrik penting lainnya melalui dasbor visual.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="login" class="py-20">
            <div class="max-w-4xl mx-auto text-center px-6">
                 <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Ambil Langkah Pertama Menuju Efisiensi
                </h2>
                <p class="mt-4 text-lg text-gray-400">
                    Hubungi administrator untuk mendapatkan akses dan mulailah mengelola tugas dengan cara yang lebih cerdas.
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
                &copy; 2025 PT. Maju Bersama. Platform Manajemen Tugas Internal.
            </p>
        </div>
    </footer>

</body>
</html>
