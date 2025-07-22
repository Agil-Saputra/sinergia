@extends('layouts.mobile')

@section('title', 'Emergency Reports - Sinergia')
@section('header', 'Emergency Reports')

@section('content')
<div class="p-4 space-y-6">
    <!-- Emergency Report Form -->
    <div class="bg-red-50 border-2 border-red-300 rounded-xl p-6">
        <!-- Header with clear instruction -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-red-800 mb-2">Report Emergency</h2>
            <p class="text-sm text-red-700">Fill in the information below to report an emergency</p>
        </div>
        
        <form method="POST" action="{{ route('user.emergency-reports.store') }}" class="space-y-6">
            @csrf
            
            <!-- Step 1: What happened? -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                    <label for="title" class="text-lg font-semibold text-gray-800">What happened?</label>
                </div>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    required 
                    class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                    placeholder="Example: Fire in kitchen, Someone is hurt, Power is out"
                >
                @error('title')
                    <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Step 2: Tell us more -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                    <label for="description" class="text-lg font-semibold text-gray-800">Tell us more details</label>
                </div>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4" 
                    required 
                    class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                    placeholder="Example: There is smoke coming from the kitchen. I can smell burning. The fire alarm is beeping."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Step 3: How serious is it? -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</div>
                    <label class="text-lg font-semibold text-gray-800">How serious is it?</label>
                </div>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 priority-option">
                        <input type="radio" name="priority" value="critical" class="w-5 h-5 mr-4 text-red-600" {{ old('priority') == 'critical' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-600 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold text-red-800">VERY SERIOUS</div>
                                <div class="text-sm text-gray-600">Someone could get hurt or die</div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 priority-option">
                        <input type="radio" name="priority" value="high" class="w-5 h-5 mr-4 text-orange-600" {{ old('priority') == 'high' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-orange-500 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold text-orange-800">SERIOUS</div>
                                <div class="text-sm text-gray-600">Needs quick help</div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 priority-option">
                        <input type="radio" name="priority" value="medium" class="w-5 h-5 mr-4 text-yellow-600" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                            <div>
                                <div class="font-semibold text-yellow-800">NORMAL</div>
                                <div class="text-sm text-gray-600">Needs help but not urgent</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Step 4: Where is it? (Optional) -->
            <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</div>
                    <label for="location" class="text-lg font-semibold text-gray-800">Where is it? <span class="text-sm text-gray-500">(Optional)</span></label>
                </div>
                <input 
                    type="text" 
                    id="location" 
                    name="location" 
                    value="{{ old('location') }}"
                    class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                    placeholder="Example: Building A, 2nd floor, Room 201"
                >
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-red-600 text-white py-4 px-6 rounded-xl text-xl font-bold hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 shadow-lg">
                    <i class="fas fa-paper-plane mr-3"></i>
                    SEND EMERGENCY REPORT
                </button>
                <p class="text-center text-sm text-gray-600 mt-3">
                    <i class="fas fa-clock mr-1"></i>
                    We will respond as quickly as possible
                </p>
            </div>
        </form>
    </div>

    <!-- Simple History Section -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">My Reports</h3>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">{{ $reports->count() }} Total</span>
        </div>

        <!-- Simple Filter Buttons -->
        <div class="flex space-x-2 mb-4">
            <button class="flex-1 py-2 px-3 bg-blue-600 text-white rounded-lg text-sm font-medium filter-btn" data-status="all">
                All Reports
            </button>
            <button class="flex-1 py-2 px-3 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium filter-btn" data-status="pending">
                Waiting
            </button>
            <button class="flex-1 py-2 px-3 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium filter-btn" data-status="resolved">
                Finished
            </button>
        </div>

        <!-- Reports List -->
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
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Waiting
                                </span>
                            @elseif($report->status == 'under_review')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-eye mr-1"></i> Being Reviewed
                                </span>
                            @elseif($report->status == 'resolved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i> Finished
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-times mr-1"></i> Closed
                                </span>
                            @endif
                        </div>
                        <span class="text-sm text-gray-500">{{ $report->reported_at->format('M d, Y') }}</span>
                    </div>
                    
                    <!-- Expandable Details -->
                    <div class="hidden mt-4 pt-4 border-t-2 border-gray-100" id="details-{{ $report->id }}">
                        <div class="space-y-3">
                            <div>
                                <p class="font-semibold text-gray-700 mb-1">Full Details:</p>
                                <p class="text-gray-600 leading-relaxed">{{ $report->description }}</p>
                            </div>
                            
                            @if($report->location)
                                <div>
                                    <p class="font-semibold text-gray-700 mb-1">Location:</p>
                                    <p class="text-gray-600">{{ $report->location }}</p>
                                </div>
                            @endif
                            
                            @if($report->admin_notes)
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <p class="font-semibold text-blue-800 mb-1">Response from Admin:</p>
                                    <p class="text-blue-700">{{ $report->admin_notes }}</p>
                                </div>
                            @endif
                            
                            @if($report->resolved_at)
                                <div>
                                    <p class="font-semibold text-gray-700 mb-1">Completed on:</p>
                                    <p class="text-gray-600">{{ $report->resolved_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium mb-2">No reports yet</p>
                    <p class="text-gray-500">When you submit a report, it will appear here</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Enhanced styles for better usability */
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
}

.filter-btn:not(.active) {
    background-color: #e5e7eb;
    color: #374151;
}
</style>

<script>
// Toggle report details with enhanced feedback
function toggleReportDetails(reportId) {
    const details = document.getElementById(`details-${reportId}`);
    const chevron = document.getElementById(`chevron-${reportId}`);
    
    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        chevron.classList.remove('fa-chevron-down');
        chevron.classList.add('fa-chevron-up');
        chevron.parentElement.style.backgroundColor = '#f3f4f6';
    } else {
        details.classList.add('hidden');
        chevron.classList.remove('fa-chevron-up');
        chevron.classList.add('fa-chevron-down');
        chevron.parentElement.style.backgroundColor = '';
    }
}

// Simplified filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const reportItems = document.querySelectorAll('.report-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;
            
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.backgroundColor = '#e5e7eb';
                btn.style.color = '#374151';
            });
            
            this.classList.add('active');
            this.style.backgroundColor = '#2563eb';
            this.style.color = 'white';
            
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
    
    // Auto-select priority radio buttons when clicked anywhere on the label
    document.querySelectorAll('.priority-option').forEach(label => {
        label.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Update visual feedback
            document.querySelectorAll('.priority-option').forEach(opt => {
                opt.style.backgroundColor = '';
                opt.style.borderColor = '#d1d5db';
            });
            
            this.style.backgroundColor = '#f3f4f6';
            this.style.borderColor = '#3b82f6';
        });
    });
});
</script>
@endsection
