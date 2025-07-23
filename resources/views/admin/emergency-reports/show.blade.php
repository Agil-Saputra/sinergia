@extends('layouts.admin')

@section('title', 'Detail Laporan Darurat')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Detail Laporan Darurat</h1>
            <p class="mt-2 text-sm text-gray-700">Informasi lengkap dan pengelolaan laporan darurat.</p>
        </div>
        <div>
            <a href="{{ route('admin.emergency-reports.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Report Information -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Laporan</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Laporan</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $emergencyReport->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium
                            @if($emergencyReport->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($emergencyReport->status === 'under_review') bg-blue-100 text-blue-800
                            @elseif($emergencyReport->status === 'resolved') bg-green-100 text-green-800
                            @elseif($emergencyReport->status === 'closed') bg-gray-100 text-gray-800
                            @endif">
                            @if($emergencyReport->status === 'pending') Tertunda
                            @elseif($emergencyReport->status === 'under_review') Sedang Ditinjau
                            @elseif($emergencyReport->status === 'resolved') Diselesaikan
                            @elseif($emergencyReport->status === 'closed') Ditutup
                            @endif
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium
                            @if($emergencyReport->priority === 'low') bg-gray-100 text-gray-800
                            @elseif($emergencyReport->priority === 'medium') bg-yellow-100 text-yellow-800
                            @elseif($emergencyReport->priority === 'high') bg-orange-100 text-orange-800
                            @elseif($emergencyReport->priority === 'critical') bg-red-100 text-red-800
                            @endif">
                            @if($emergencyReport->priority === 'low') 🟢 Rendah
                            @elseif($emergencyReport->priority === 'medium') 🟡 Sedang
                            @elseif($emergencyReport->priority === 'high') 🟠 Tinggi
                            @elseif($emergencyReport->priority === 'critical') 🔴 Kritis
                            @endif
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Laporan</label>
                        <p class="text-gray-900">{{ $emergencyReport->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @if($emergencyReport->location)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <p class="text-gray-900">📍 {{ $emergencyReport->location }}</p>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $emergencyReport->description }}</p>
                    </div>
                </div>

                @if($emergencyReport->admin_notes)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-blue-900 whitespace-pre-wrap">{{ $emergencyReport->admin_notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Update Status & Catatan</h2>
                @if($emergencyReport->user->phone_number)
                <p class="text-sm text-gray-600 mt-1">
                    <i class="fab fa-whatsapp text-green-500 mr-1"></i>
                    Notifikasi akan dikirim ke WhatsApp pengguna jika status atau catatan diubah
                </p>
                @else
                <p class="text-sm text-orange-600 mt-1">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Pengguna tidak memiliki nomor WhatsApp - notifikasi tidak dapat dikirim
                </p>
                @endif
            </div>
            <div class="p-6">
                <form action="{{ route('admin.emergency-reports.update-status', $emergencyReport) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200">
                            <option value="pending" {{ $emergencyReport->status === 'pending' ? 'selected' : '' }}>Tertunda</option>
                            <option value="under_review" {{ $emergencyReport->status === 'under_review' ? 'selected' : '' }}>Sedang Ditinjau</option>
                            <option value="resolved" {{ $emergencyReport->status === 'resolved' ? 'selected' : '' }}>Diselesaikan</option>
                            <option value="closed" {{ $emergencyReport->status === 'closed' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                        <textarea id="admin_notes" name="admin_notes" rows="4" 
                                  class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-20 transition-all duration-200"
                                  placeholder="Tambahkan catatan mengenai tindakan yang telah diambil atau rencana penyelesaian...">{{ old('admin_notes', $emergencyReport->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        @if($emergencyReport->user->phone_number)
                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fab fa-whatsapp text-green-600 mr-2"></i>
                                <span class="text-sm font-medium text-green-800">Preview Notifikasi WhatsApp</span>
                            </div>
                            <div class="text-xs text-green-700 bg-white p-2 rounded border">
                                <div id="whatsapp-preview">
                                    📝 <strong>UPDATE LAPORAN DARURAT</strong><br><br>
                                    📝 <strong>Laporan:</strong> {{ $emergencyReport->title }}<br>
                                    📊 <strong>Status Baru:</strong> <span id="preview-status">-</span><br>
                                    📅 <strong>Diupdate:</strong> {{ now()->format('d/m/Y H:i') }}<br>
                                    <div id="preview-notes" style="display: none;">
                                    <br>💬 <strong>Catatan Admin:</strong><br><span id="preview-notes-text"></span><br>
                                    </div>
                                    <br><span id="preview-action-message"></span>
                                    <br><br>🏢 <strong>Tim Sinergia</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-3 px-6 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg inline-flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Update Status
                            @if($emergencyReport->user->phone_number)
                            <i class="fab fa-whatsapp ml-2 text-green-300"></i>
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Reporter Information -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Pelapor</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $emergencyReport->user->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $emergencyReport->user->employee_code }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    @if($emergencyReport->user->phone_number)
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-phone w-4 h-4 mr-3"></i>
                        <span>{{ $emergencyReport->user->phone_number }}</span>
                    </div>
                    @endif
                    
                    @if($emergencyReport->user->email)
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-envelope w-4 h-4 mr-3"></i>
                        <span>{{ $emergencyReport->user->email }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Timeline</h2>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Laporan dibuat</p>
                                            <p class="text-sm text-gray-500">{{ $emergencyReport->user->name }} melaporkan insiden</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ $emergencyReport->created_at->format('d M Y') }}
                                            <br>
                                            {{ $emergencyReport->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        @if($emergencyReport->status !== 'pending')
                        <li>
                            <div class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-cog text-white text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Status diperbarui</p>
                                            <p class="text-sm text-gray-500">
                                                @if($emergencyReport->status === 'under_review') Sedang dalam proses peninjauan
                                                @elseif($emergencyReport->status === 'resolved') Insiden telah diselesaikan
                                                @elseif($emergencyReport->status === 'closed') Laporan telah ditutup
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ $emergencyReport->updated_at->format('d M Y') }}
                                            <br>
                                            {{ $emergencyReport->updated_at->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow-lg rounded-2xl border-2 border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat</h2>
            </div>
            <div class="p-6 space-y-3">
                @if($emergencyReport->user->phone_number)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $emergencyReport->user->phone_number) }}" 
                   target="_blank"
                   class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-xl transition-colors inline-flex items-center justify-center">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Hubungi via WhatsApp
                </a>
                @endif
                
                @if($emergencyReport->user->phone_number)
                <a href="tel:{{ $emergencyReport->user->phone_number }}" 
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-phone mr-2"></i>
                    Telepon Langsung
                </a>
                @endif
                
                <button onclick="window.print()" 
                        class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-xl transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-print mr-2"></i>
                    Cetak Laporan
                </button>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-message">
    {{ session('success') }}
</div>
<script>
    setTimeout(() => {
        document.getElementById('success-message').style.display = 'none';
    }, 3000);
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const notesTextarea = document.getElementById('admin_notes');
    const previewStatus = document.getElementById('preview-status');
    const previewNotes = document.getElementById('preview-notes');
    const previewNotesText = document.getElementById('preview-notes-text');
    const previewActionMessage = document.getElementById('preview-action-message');
    
    const statusText = {
        'pending': 'Tertunda',
        'under_review': 'Sedang Ditinjau', 
        'resolved': 'Diselesaikan',
        'closed': 'Ditutup'
    };
    
    const actionMessages = {
        'under_review': '🔍 Laporan Anda sedang dalam proses peninjauan oleh tim kami.',
        'resolved': '✅ Laporan Anda telah diselesaikan. Terima kasih atas laporannya!',
        'closed': '🔒 Laporan ini telah ditutup. Jika ada pertanyaan lebih lanjut, silakan hubungi admin.',
        'pending': ''
    };
    
    function updatePreview() {
        if (previewStatus) {
            const selectedStatus = statusSelect.value;
            previewStatus.textContent = statusText[selectedStatus] || selectedStatus;
            previewActionMessage.textContent = actionMessages[selectedStatus] || '';
            
            const notesValue = notesTextarea.value.trim();
            if (notesValue) {
                previewNotes.style.display = 'block';
                previewNotesText.textContent = notesValue;
            } else {
                previewNotes.style.display = 'none';
            }
        }
    }
    
    // Initialize preview
    updatePreview();
    
    // Update preview on change
    if (statusSelect) {
        statusSelect.addEventListener('change', updatePreview);
    }
    
    if (notesTextarea) {
        notesTextarea.addEventListener('input', updatePreview);
    }
});
</script>

@endsection
