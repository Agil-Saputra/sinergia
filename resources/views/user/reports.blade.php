@extends('layouts.mobile')

@section('title', 'Laporan Darurat - Sinergia')
@section('header', 'Laporan Darurat')

@section('content')
<div class="p-4 space-y-4">
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center mb-3">
            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
            <h2 class="text-lg font-semibold text-red-800">Laporkan Keadaan Darurat</h2>
        </div>

        <form method="POST" action="{{ route('user.emergency-reports.store') }}" class="space-y-3">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Keadaan Darurat</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Deskripsi singkat keadaan darurat"
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Keadaan Darurat</label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Berikan informasi rinci tentang keadaan darurat..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                    <select
                        id="priority"
                        name="priority"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                    >
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Kritis</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    </select>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Opsional"
                    >
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan Darurat
            </button>
        </form>
    </div>

    <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
        <button class="flex-1 py-2 px-3 bg-white rounded-md text-sm font-medium text-red-600 shadow-sm filter-btn" data-status="all">Semua</button>
        <button class="flex-1 py-2 px-3 text-sm font-medium text-gray-600 filter-btn" data-status="pending">Tertunda</button>
        <button class="flex-1 py-2 px-3 text-sm font-medium text-gray-600 filter-btn" data-status="resolved">Selesai</button>
    </div>

    <div class="space-y-3" id="reports-list">
        @forelse($reports as $report)
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 report-item" data-status="{{ $report->status }}">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">{{ $report->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($report->description, 100) }}</p>
                    </div>
                    <button class="text-gray-400 ml-2" onclick="toggleReportDetails({{ $report->id }})">
                        <i class="fas fa-chevron-down" id="chevron-{{ $report->id }}"></i>
                    </button>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-xs px-2 py-1 rounded-full {{ $report->status_color }}">
                            @if($report->status == 'pending')
                                Tertunda
                            @elseif($report->status == 'resolved')
                                Selesai
                            @else
                                {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                            @endif
                        </span>
                        <span class="text-xs px-2 py-1 rounded-full {{ $report->priority_color }}">
                            @if($report->priority == 'low')
                                Rendah
                            @elseif($report->priority == 'medium')
                                Sedang
                            @elseif($report->priority == 'high')
                                Tinggi
                            @elseif($report->priority == 'critical')
                                Kritis
                            @else
                                {{ ucfirst($report->priority) }}
                            @endif
                        </span>
                    </div>
                    <span class="text-xs text-gray-500">{{ $report->reported_at->format('d M Y, H:i') }}</span>
                </div>

                <div class="hidden mt-3 pt-3 border-t border-gray-100" id="details-{{ $report->id }}">
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Deskripsi Lengkap:</p>
                            <p class="text-sm text-gray-600">{{ $report->description }}</p>
                        </div>

                        @if($report->location)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Lokasi:</p>
                                <p class="text-sm text-gray-600">{{ $report->location }}</p>
                            </div>
                        @endif

                        @if($report->admin_notes)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Catatan Admin:</p>
                                <p class="text-sm text-gray-600">{{ $report->admin_notes }}</p>
                            </div>
                        @endif

                        @if($report->resolved_at)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Diselesaikan Pada:</p>
                                <p class="text-sm text-gray-600">{{ $report->resolved_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg p-6 text-center">
                <i class="fas fa-clipboard-list text-gray-400 text-3xl mb-3"></i>
                <p class="text-gray-600">Tidak ada laporan darurat yang ditemukan.</p>
                <p class="text-sm text-gray-500">Kirim laporan darurat pertama Anda melalui formulir di atas.</p>
            </div>
        @endforelse
    </div>

    @if($reports->hasPages())
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    @endif

    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="font-medium mb-3">Statistik Laporan</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-red-600">{{ $reports->total() }}</p>
                <p class="text-xs text-gray-600">Total Laporan</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $reports->where('status', 'pending')->count() }}</p>
                <p class="text-xs text-gray-600">Tertunda</p>
            </div>
        </div>
    </div>
</div>

<script>
// Tampilkan/sembunyikan detail laporan
function toggleReportDetails(reportId) {
    const details = document.getElementById(`details-${reportId}`);
    const chevron = document.getElementById(`chevron-${reportId}`);

    details.classList.toggle('hidden');
    chevron.classList.toggle('fa-chevron-down');
    chevron.classList.toggle('fa-chevron-up');
}

// Fungsionalitas filter
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const reportItems = document.querySelectorAll('.report-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;

            // Perbarui tombol aktif
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-white', 'text-red-600', 'shadow-sm');
                btn.classList.add('text-gray-600');
            });
            this.classList.add('bg-white', 'text-red-600', 'shadow-sm');
            this.classList.remove('text-gray-600');

            // Filter laporan
            reportItems.forEach(item => {
                if (status === 'all' || item.dataset.status === status) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
