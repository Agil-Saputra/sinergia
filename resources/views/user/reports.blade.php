@extends('layouts.mobile')

@section('title', 'Emergency Reports - Sinergia')
@section('header', 'Emergency Reports')

@section('content')
<div class="p-4 space-y-4">
    <!-- Emergency Report Form -->
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center mb-3">
            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
            <h2 class="text-lg font-semibold text-red-800">Report Emergency</h2>
        </div>
        
        <form method="POST" action="{{ route('user.emergency-reports.store') }}" class="space-y-3">
            @csrf
            
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Emergency Title</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Brief description of emergency"
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Emergency Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3" 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Provide detailed information about the emergency..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority and Location Row -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select 
                        id="priority" 
                        name="priority" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                    >
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        value="{{ old('location') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Optional"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                <i class="fas fa-paper-plane mr-2"></i>Submit Emergency Report
            </button>
        </form>
    </div>

    <!-- Filter Tabs -->
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
        <button class="flex-1 py-2 px-3 bg-white rounded-md text-sm font-medium text-red-600 shadow-sm filter-btn" data-status="all">All</button>
        <button class="flex-1 py-2 px-3 text-sm font-medium text-gray-600 filter-btn" data-status="pending">Pending</button>
        <button class="flex-1 py-2 px-3 text-sm font-medium text-gray-600 filter-btn" data-status="resolved">Resolved</button>
    </div>

    <!-- Reports History -->
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
                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                        </span>
                        <span class="text-xs px-2 py-1 rounded-full {{ $report->priority_color }}">
                            {{ ucfirst($report->priority) }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-500">{{ $report->reported_at->format('M d, Y H:i') }}</span>
                </div>
                
                <!-- Expandable Details -->
                <div class="hidden mt-3 pt-3 border-t border-gray-100" id="details-{{ $report->id }}">
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Full Description:</p>
                            <p class="text-sm text-gray-600">{{ $report->description }}</p>
                        </div>
                        
                        @if($report->location)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Location:</p>
                                <p class="text-sm text-gray-600">{{ $report->location }}</p>
                            </div>
                        @endif
                        
                        @if($report->admin_notes)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Admin Notes:</p>
                                <p class="text-sm text-gray-600">{{ $report->admin_notes }}</p>
                            </div>
                        @endif
                        
                        @if($report->resolved_at)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Resolved At:</p>
                                <p class="text-sm text-gray-600">{{ $report->resolved_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg p-6 text-center">
                <i class="fas fa-clipboard-list text-gray-400 text-3xl mb-3"></i>
                <p class="text-gray-600">No emergency reports found.</p>
                <p class="text-sm text-gray-500">Submit your first emergency report above.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reports->hasPages())
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    @endif

    <!-- Stats Summary -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="font-medium mb-3">Report Statistics</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-red-600">{{ $reports->total() }}</p>
                <p class="text-xs text-gray-600">Total Reports</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $reports->where('status', 'pending')->count() }}</p>
                <p class="text-xs text-gray-600">Pending</p>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle report details
function toggleReportDetails(reportId) {
    const details = document.getElementById(`details-${reportId}`);
    const chevron = document.getElementById(`chevron-${reportId}`);
    
    details.classList.toggle('hidden');
    chevron.classList.toggle('fa-chevron-down');
    chevron.classList.toggle('fa-chevron-up');
}

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const reportItems = document.querySelectorAll('.report-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;
            
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-white', 'text-red-600', 'shadow-sm');
                btn.classList.add('text-gray-600');
            });
            this.classList.add('bg-white', 'text-red-600', 'shadow-sm');
            this.classList.remove('text-gray-600');
            
            // Filter reports
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
