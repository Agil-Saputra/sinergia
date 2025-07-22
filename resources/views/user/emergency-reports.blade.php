@extends('layouts.mobile')

@section('title', 'Laporan Isu & Permintaan - Sinergia')
@section('header', 'Laporan Isu & Permintaan')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="p-4 space-y-6">
    <!-- Formulir Laporan Isu & Permintaan -->
    <div class="bg-blue-50 border-2 border-blue-300 rounded-xl p-6">
        <!-- Header dengan instruksi yang jelas -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-tools text-white text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-blue-800 mb-2">Lapor Isu atau Permintaan</h2>
            <p class="text-sm text-blue-700">Isi formulir untuk melaporkan masalah atau permintaan perbaikan.</p>
        </div>

        <form method="POST" action="{{ route('user.emergency-reports.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <!-- Langkah 1: Apa masalahnya? -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                    <label for="title" class="text-lg font-semibold text-gray-800">Apa masalahnya?</label>
                </div>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Contoh: AC tidak dingin, Lampu mati, Keran bocor"
                >
                @error('title')
                    <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Langkah 2: Deskripsi dan Lokasi -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                    <label for="description" class="text-lg font-semibold text-gray-800">Deskripsi Detail</label>
                </div>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    required
                    class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Contoh: AC di ruang meeting B tidak dingin sejak pagi. Lantai lobi utama kotor."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Langkah 3: Tingkat Urgensi -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</div>
                    <label class="text-lg font-semibold text-gray-800">Tingkat Urgensi</label>
                </div>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 priority-option">
                        <input type="radio" name="priority" value="high" class="w-5 h-5 mr-4 text-red-600" {{ old('priority') == 'high' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-600 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold text-red-800">Tinggi</div>
                                <div class="text-sm text-gray-600">Mengganggu operasional atau berisiko bahaya</div>
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 priority-option">
                        <input type="radio" name="priority" value="medium" class="w-5 h-5 mr-4 text-orange-600" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-orange-500 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold text-orange-800">Sedang</div>
                                <div class="text-sm text-gray-600">Perlu ditangani segera namun tidak darurat</div>
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 priority-option">
                        <input type="radio" name="priority" value="low" class="w-5 h-5 mr-4 text-yellow-600" {{ old('priority') == 'low' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold text-yellow-800">Rendah</div>
                                <div class="text-sm text-gray-600">Bisa dijadwalkan untuk perbaikan rutin</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Langkah 4: Di mana lokasinya? (Opsional) -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</div>
                    <label for="location" class="text-lg font-semibold text-gray-800">Lokasi Spesifik <span class="text-sm text-gray-500">(Opsional)</span></label>
                </div>
                <input
                    type="text"
                    id="location"
                    name="location"
                    value="{{ old('location') }}"
                    class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Contoh: Gedung A, Lantai 2, Ruang 201"
                >
            </div>

            <!-- Langkah 5: Upload Bukti (Opsional) -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">5</div>
                    <label for="attachment" class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-paperclip mr-2"></i>Bukti Masalah <span class="text-sm text-gray-500">(Foto/Video/Dokumen)</span>
                    </label>
                </div>
                <div class="relative">
                    <input
                        type="file"
                        id="attachment"
                        name="attachment"
                        accept="image/*,video/*,.pdf,.doc,.docx"
                        class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        onchange="updateFileName(this)"
                    >
                </div>
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    <span>Format: JPG, PNG, MP4, PDF, DOC • Maksimal 10MB</span>
                </div>
                <div id="file-preview" class="hidden mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center justify-between">
                        <span id="file-name" class="text-sm text-blue-800 font-medium"></span>
                        <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 font-medium">
                            <i class="fas fa-times mr-1"></i>Hapus
                        </button>
                    </div>
                </div>
                @error('attachment')
                    <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Kirim -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg">
                    <i class="fas fa-paper-plane mr-3"></i>
                    KIRIM LAPORAN
                </button>
                <p class="text-center text-sm text-gray-600 mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    Laporan akan diteruskan ke tim terkait.
                </p>
            </div>
        </form>

        <!-- Emergency Call Button -->
        <div class="mt-6 p-4 bg-gradient-to-r from-orange-50 to-red-50 border-2 border-orange-200 rounded-xl shadow-sm">
            <div class="text-center mb-4">
                <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-phone text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-orange-800">Butuh Bantuan Segera?</h3>
                <p class="text-sm text-orange-700">Untuk situasi darurat yang memerlukan penanganan segera</p>
            </div>
            
            <div class="space-y-3">
                <button 
                    onclick="callSupervisor()" 
                    class="w-full bg-orange-600 text-white py-3 px-6 rounded-xl text-lg font-bold hover:bg-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-300 transform hover:scale-105 transition-all duration-200 shadow-lg"
                >
                    <i class="fas fa-phone mr-2"></i>HUBUNGI SUPERVISOR
                </button>
                
                <button 
                    onclick="callSecurity()" 
                    class="w-full bg-red-600 text-white py-3 px-6 rounded-xl text-lg font-bold hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transform hover:scale-105 transition-all duration-200 shadow-lg"
                >
                    <i class="fas fa-shield-alt mr-2"></i>HUBUNGI SECURITY
                </button>
            </div>
        </div>
    </div>

    <!-- Bagian Riwayat Laporan -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Riwayat Laporan Saya</h3>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">{{ $reports->count() }} Total</span>
        </div>

        <!-- Tombol Filter -->
        <div class="flex space-x-2 mb-4">
            <button class="flex-1 py-2 px-3 bg-blue-600 text-white rounded-lg text-sm font-medium filter-btn active" data-status="all">
                Semua
            </button>
            <button class="flex-1 py-2 px-3 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium filter-btn" data-status="pending">
                Baru
            </button>
            <button class="flex-1 py-2 px-3 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium filter-btn" data-status="under_review">
                Dikerjakan
            </button>
            <button class="flex-1 py-2 px-3 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium filter-btn" data-status="resolved">
                Selesai
            </button>
        </div>

        <!-- Daftar Laporan -->
        <div class="space-y-3" id="reports-list">
            @forelse($reports as $report)
                <div class="border-2 border-gray-200 rounded-lg p-4 report-item" data-status="{{ $report->status }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 text-lg mb-1">{{ $report->title }}</h4>
                            <p class="text-gray-600 text-base leading-relaxed">{{ Str::limit($report->description, 80) }}</p>
                        </div>
                        <button class="ml-3 text-gray-500 hover:text-gray-700 p-2" onclick="toggleReportDetails({{ $report->id }})">
                            <i class="fas fa-chevron-down text-lg" id="chevron-{{ $report->id }}"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($report->status == 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-flag mr-1"></i> Baru
                                </span>
                            @elseif($report->status == 'under_review')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-wrench mr-1"></i> Dikerjakan
                                </span>
                            @elseif($report->status == 'resolved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-times-circle mr-1"></i> Ditutup
                                </span>
                            @endif
                        </div>
                        <span class="text-sm text-gray-500">{{ $report->reported_at->format('d M Y') }}</span>
                    </div>

                    <!-- Detail yang Dapat Diperluas -->
                    <div class="hidden mt-4 pt-4 border-t-2 border-gray-100" id="details-{{ $report->id }}">
                        <div class="space-y-3">
                            <div>
                                <p class="font-semibold text-gray-700 mb-1">Detail Lengkap:</p>
                                <p class="text-gray-600 leading-relaxed">{{ $report->description }}</p>
                            </div>

                            @if($report->location)
                                <div>
                                    <p class="font-semibold text-gray-700 mb-1">Lokasi:</p>
                                    <p class="text-gray-600">{{ $report->location }}</p>
                                </div>
                            @endif

                            @if($report->attachments && count($report->attachments) > 0)
                                <div>
                                    <p class="font-semibold text-gray-700 mb-2">Lampiran:</p>
                                    <div class="space-y-2">
                                        @foreach($report->attachments as $attachment)
                                            <a 
                                                href="{{ Storage::url($attachment) }}" 
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors"
                                            >
                                                <i class="fas fa-paperclip mr-2"></i>
                                                <span class="text-sm font-medium">{{ basename($attachment) }}</span>
                                                <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($report->admin_notes)
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <p class="font-semibold text-blue-800 mb-1">Tanggapan dari Admin:</p>
                                    <p class="text-blue-700">{{ $report->admin_notes }}</p>
                                </div>
                            @endif

                            @if($report->resolved_at)
                                <div>
                                    <p class="font-semibold text-gray-700 mb-1">Selesai pada:</p>
                                    <p class="text-gray-600">{{ $report->resolved_at->format('d M Y \p\u\k\u\l H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium mb-2">Belum ada laporan</p>
                    <p class="text-gray-500">Saat Anda mengirim laporan, laporan itu akan muncul di sini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Gaya yang disempurnakan untuk usabilitas yang lebih baik */
.priority-option:has(input:checked) {
    background-color: #f3f4f6;
    border-color: #3b82f6;
}

.priority-option input:checked + div .font-semibold {
    color: #1f2937;
}

.filter-btn.active {
    background-color: #2563eb !important;
    color: white !important;
    font-weight: 600;
}

.filter-btn:not(.active) {
    background-color: #e5e7eb;
    color: #374151;
}
</style>

<script>
// Function untuk update file name preview
function updateFileName(input) {
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        
        fileName.innerHTML = `
            <i class="fas fa-file mr-2"></i>
            <span class="font-medium">${file.name}</span>
            <span class="text-blue-600 text-xs ml-2">(${fileSize} MB)</span>
        `;
        filePreview.classList.remove('hidden');
    } else {
        filePreview.classList.add('hidden');
    }
}

// Function untuk remove file
function removeFile() {
    const fileInput = document.getElementById('attachment');
    const filePreview = document.getElementById('file-preview');
    
    fileInput.value = '';
    filePreview.classList.add('hidden');
}

// Function to call supervisor
function callSupervisor() {
    const supervisorPhone = '{{ config("emergency.supervisor_phone") }}';
    
    if (confirm('Apakah Anda yakin ingin menghubungi supervisor untuk situasi darurat?')) {
        // Untuk mobile device, gunakan tel: protocol
        if (/Mobi|Android/i.test(navigator.userAgent)) {
            window.location.href = `tel:${supervisorPhone}`;
        } else {
            // Untuk desktop, tampilkan nomor dan copy ke clipboard
            navigator.clipboard.writeText(supervisorPhone).then(function() {
                alert(`Nomor supervisor: ${supervisorPhone}\n(Nomor telah disalin ke clipboard)`);
            }).catch(function() {
                alert(`Nomor supervisor: ${supervisorPhone}`);
            });
        }
    }
}

// Function to call security
function callSecurity() {
    const securityPhone = '{{ config("emergency.security_phone") }}';
    
    if (confirm('Apakah Anda yakin ingin menghubungi security untuk situasi darurat?')) {
        // Untuk mobile device, gunakan tel: protocol
        if (/Mobi|Android/i.test(navigator.userAgent)) {
            window.location.href = `tel:${securityPhone}`;
        } else {
            // Untuk desktop, tampilkan nomor dan copy ke clipboard
            navigator.clipboard.writeText(securityPhone).then(function() {
                alert(`Nomor security: ${securityPhone}\n(Nomor telah disalin ke clipboard)`);
            }).catch(function() {
                alert(`Nomor security: ${securityPhone}`);
            });
        }
    }
}

// Tampilkan/sembunyikan detail laporan dengan umpan balik yang disempurnakan
function toggleReportDetails(reportId) {
    const details = document.getElementById(`details-${reportId}`);
    const chevron = document.getElementById(`chevron-${reportId}`);

    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        chevron.classList.remove('fa-chevron-down');
        chevron.classList.add('fa-chevron-up');
        chevron.closest('.report-item').classList.add('border-blue-500');
    } else {
        details.classList.add('hidden');
        chevron.classList.remove('fa-chevron-up');
        chevron.classList.add('fa-chevron-down');
         chevron.closest('.report-item').classList.remove('border-blue-500');
    }
}

// Fungsionalitas filter yang disederhanakan
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const reportItems = document.querySelectorAll('.report-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;

            // Perbarui tombol aktif
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white', 'font-semibold');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });

            this.classList.add('active', 'bg-blue-600', 'text-white', 'font-semibold');
            this.classList.remove('bg-gray-200', 'text-gray-700');

            // Filter laporan
            let visibleCount = 0;
            reportItems.forEach(item => {
                if (status === 'all' || item.dataset.status === status) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada laporan yang cocok
            const emptyState = document.querySelector('#reports-list .text-center');
            if(emptyState && visibleCount === 0) {
                 // Anda bisa menambahkan logika untuk menampilkan pesan "Tidak ada laporan untuk filter ini"
            }
        });
    });

    // Pilih otomatis tombol radio prioritas saat diklik di mana saja pada label
    document.querySelectorAll('.priority-option').forEach(label => {
        label.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        });
    });
});
</script>
@endsection
