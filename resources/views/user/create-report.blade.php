@extends('layouts.mobile')

@section('title', 'Create Report - Sinergia')
@section('header', 'Create Report')

@section('content')
<div class="p-4">
    <form method="POST" action="{{ route('user.reports.store') }}" class="space-y-4">
        @csrf
        
        <!-- Title -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Report Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="{{ old('title') }}"
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter report title"
            >
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select 
                id="category" 
                name="category" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Select category</option>
                <option value="sales" {{ old('category') == 'sales' ? 'selected' : '' }}>Sales</option>
                <option value="finance" {{ old('category') == 'finance' ? 'selected' : '' }}>Finance</option>
                <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="operations" {{ old('category') == 'operations' ? 'selected' : '' }}>Operations</option>
                <option value="hr" {{ old('category') == 'hr' ? 'selected' : '' }}>Human Resources</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea 
                id="description" 
                name="description" 
                rows="6" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Describe your report in detail..."
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Priority -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level</label>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="priority" value="low" class="mr-3" {{ old('priority') == 'low' ? 'checked' : '' }}>
                    <span class="text-sm">Low Priority</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="priority" value="medium" class="mr-3" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                    <span class="text-sm">Medium Priority</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="priority" value="high" class="mr-3" {{ old('priority') == 'high' ? 'checked' : '' }}>
                    <span class="text-sm">High Priority</span>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3 pt-4">
            <a href="{{ route('user.reports') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg text-center font-medium">
                Cancel
            </a>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg font-medium">
                Submit Report
            </button>
        </div>
    </form>
</div>
@endsection
