@extends('layouts.mobile')

@section('title', 'Edit Profile - Sinergia')
@section('header', 'Edit Profile')

@section('content')
<div class="p-4">
    <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-4">
        @csrf
        @method('PUT')
        
        <!-- Profile Picture -->
        <div class="bg-white rounded-lg p-4 shadow-sm text-center">
            <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-white text-2xl font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <button type="button" class="text-blue-600 text-sm font-medium">Change Picture</button>
        </div>

        <!-- Name -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name', Auth::user()->name) }}"
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your full name"
            >
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email', Auth::user()->email) }}"
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your email address"
            >
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone Number -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input 
                type="tel" 
                id="phone" 
                name="phone" 
                value="{{ old('phone') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your phone number"
            >
        </div>

        <!-- Department -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
            <select 
                id="department" 
                name="department" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Select department</option>
                <option value="sales" {{ old('department') == 'sales' ? 'selected' : '' }}>Sales</option>
                <option value="marketing" {{ old('department') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="development" {{ old('department') == 'development' ? 'selected' : '' }}>Development</option>
                <option value="hr" {{ old('department') == 'hr' ? 'selected' : '' }}>Human Resources</option>
                <option value="finance" {{ old('department') == 'finance' ? 'selected' : '' }}>Finance</option>
                <option value="operations" {{ old('department') == 'operations' ? 'selected' : '' }}>Operations</option>
            </select>
        </div>

        <!-- Bio -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
            <textarea 
                id="bio" 
                name="bio" 
                rows="3" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Tell us about yourself..."
            >{{ old('bio') }}</textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3 pt-4">
            <a href="{{ route('user.profile') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg text-center font-medium">
                Cancel
            </a>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg font-medium">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
