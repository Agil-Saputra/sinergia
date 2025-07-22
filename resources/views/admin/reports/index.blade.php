@extends('layouts.admin')

@section('title', 'Export Data')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900">Export Data</h1>
        <p class="mt-2 text-sm text-gray-700">Download data dalam format Excel (XLSX) untuk analisis lebih lanjut.</p>
    </div>

    <!-- Export Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Task Data Export -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100 hover:shadow-xl transition-all duration-200">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-2xl px-6 py-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-tasks text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-white">Data Tugas</h3>
                        <p class="text-sm text-blue-100">Export semua data tugas karyawan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm text-gray-600 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Status tugas dan progress</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        <span>Data karyawan yang bertanggung jawab</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-purple-500 mr-2"></i>
                        <span>Tanggal penugasan dan penyelesaian</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        <span>Prioritas dan kategori tugas</span>
                    </div>
                </div>
                <a href="{{ route('admin.export.tasks') }}"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-3 px-6 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-lg inline-flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Download Data Tugas
                </a>
            </div>
        </div>

        <!-- Users Data Export -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100 hover:shadow-xl transition-all duration-200">
            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-t-2xl px-6 py-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-white">Data Karyawan</h3>
                        <p class="text-sm text-green-100">Export informasi lengkap karyawan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm text-gray-600 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-id-card text-green-500 mr-2"></i>
                        <span>Data pribadi dan kontak</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-briefcase text-blue-500 mr-2"></i>
                        <span>Informasi jabatan dan role</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-code text-purple-500 mr-2"></i>
                        <span>Kode karyawan dan ID</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar-plus text-yellow-500 mr-2"></i>
                        <span>Status akun dan tanggal bergabung</span>
                    </div>
                </div>
                <a href="{{ route('admin.export.users') }}"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-3 px-6 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-lg inline-flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Download Data Karyawan
                </a>
            </div>
        </div>

        <!-- Attendance Data Export -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100 hover:shadow-xl transition-all duration-200">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-t-2xl px-6 py-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-white">Data Absensi</h3>
                        <p class="text-sm text-purple-100">Export riwayat kehadiran karyawan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm text-gray-600 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-sign-in-alt text-green-500 mr-2"></i>
                        <span>Waktu check-in dan check-out</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-stopwatch text-blue-500 mr-2"></i>
                        <span>Total jam kerja harian</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>
                        <span>Lokasi dan catatan absensi</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar-check text-yellow-500 mr-2"></i>
                        <span>Status kehadiran dan keterlambatan</span>
                    </div>
                </div>
                <a href="{{ route('admin.export.attendance') }}"
                    class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium py-3 px-6 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-lg inline-flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Download Data Absensi
                </a>
            </div>
        </div>

        <!-- Emergency Reports Data Export -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100 hover:shadow-xl transition-all duration-200">
            <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-t-2xl px-6 py-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-white">Laporan Darurat</h3>
                        <p class="text-sm text-red-100">Export data insiden dan laporan darurat</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm text-gray-600 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <span>Jenis dan tingkat urgensi insiden</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user-shield text-blue-500 mr-2"></i>
                        <span>Pelapor dan penanganan</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-purple-500 mr-2"></i>
                        <span>Waktu laporan dan penyelesaian</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-double text-green-500 mr-2"></i>
                        <span>Status dan catatan admin</span>
                    </div>
                </div>
                <a href="{{ route('admin.export.emergency') }}"
                    class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium py-3 px-6 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-lg inline-flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Download Laporan Darurat
                </a>
            </div>
        </div>
    </div>


    </div>


@endsection
