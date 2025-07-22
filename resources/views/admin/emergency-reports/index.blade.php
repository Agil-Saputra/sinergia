@extends('layouts.admin')

@section('title', 'Emergency Reports')

@section('content')
<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold text-gray-900">Emergency Reports</h1>
        <p class="mt-2 text-sm text-gray-700">Monitor and manage emergency reports from employees.</p>
    </div>
</div>

<!-- Filters -->
<div class="mt-8 bg-white shadow rounded-lg p-6">
    <form method="GET" action="{{ route('admin.emergency-reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div>
            <label for="urgency" class="block text-sm font-medium text-gray-700">Urgency</label>
            <select id="urgency" name="urgency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                <option value="">All Urgency</option>
                <option value="low" {{ request('urgency') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('urgency') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('urgency') == 'high' ? 'selected' : '' }}>High</option>
                <option value="critical" {{ request('urgency') == 'critical' ? 'selected' : '' }}>Critical</option>
            </select>
        </div>
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                <option value="">All Types</option>
                <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="safety" {{ request('type') == 'safety' ? 'selected' : '' }}>Safety</option>
                <option value="security" {{ request('type') == 'security' ? 'selected' : '' }}>Security</option>
                <option value="health" {{ request('type') == 'health' ? 'selected' : '' }}>Health</option>
                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <i class="fas fa-search mr-2"></i>
                Filter
            </button>
        </div>
    </form>
</div>

<!-- Stats Cards -->
<div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Reports</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $reports->total() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $reports->where('status', 'pending')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-cog text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">In Progress</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $reports->where('status', 'in_progress')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Resolved</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $reports->where('status', 'resolved')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reports Grid -->
<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($reports as $report)
        <div class="bg-white rounded-lg shadow border hover:shadow-lg transition-shadow">
            <!-- Header -->
            <div class="p-6 border-b">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $report->urgency === 'critical' ? 'bg-red-100 text-red-800' : 
                                   ($report->urgency === 'high' ? 'bg-orange-100 text-orange-800' : 
                                   ($report->urgency === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                {{ ucfirst($report->urgency) }}
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                {{ ucfirst($report->type) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $report->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $report->description }}</p>
                    </div>
                </div>
                
                <!-- Reporter Info -->
                <div class="mt-4 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-blue-600">{{ substr($report->user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $report->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $report->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Status and Actions -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full 
                        {{ $report->status === 'resolved' ? 'bg-green-100 text-green-800' : 
                           ($report->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                    </span>
                    @if($report->location)
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $report->location }}
                        </span>
                    @endif
                </div>

                @if($report->admin_notes)
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700">{{ $report->admin_notes }}</p>
                    </div>
                @endif

                <div class="flex space-x-2">
                    <a href="{{ route('admin.emergency-reports.show', $report) }}" 
                       class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 text-center">
                        View Details
                    </a>
                    @if($report->status !== 'resolved')
                        <button onclick="openStatusModal({{ $report->id }}, '{{ $report->status }}', '{{ addslashes($report->admin_notes) }}')"
                                class="bg-gray-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">
                            Update Status
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Emergency Reports</h3>
            <p class="text-gray-600">No emergency reports match your current filters</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($reports->hasPages())
    <div class="mt-8">
        {{ $reports->links() }}
    </div>
@endif

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg w-full max-w-md">
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                    
                    <!-- Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status_select" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                        </select>
                    </div>

                    <!-- Admin Notes -->
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Notes
                        </label>
                        <textarea id="admin_notes" name="admin_notes" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Add notes about the resolution or progress..."></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-2">
                    <button type="button" onclick="closeStatusModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openStatusModal(reportId, currentStatus, currentNotes) {
    const modal = document.getElementById('statusModal');
    const form = document.getElementById('statusForm');
    const statusSelect = document.getElementById('status_select');
    const notesTextarea = document.getElementById('admin_notes');
    
    // Set form action
    form.action = `/admin/emergency-reports/${reportId}/status`;
    
    // Set current values
    statusSelect.value = currentStatus;
    notesTextarea.value = currentNotes;
    
    modal.classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

// Close modal on background click
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatusModal();
    }
});
</script>
@endsection
