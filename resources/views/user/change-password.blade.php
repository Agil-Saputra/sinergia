@extends('layouts.mobile')

@section('title', 'Change Password - Sinergia')
@section('header', 'Change Password')

@section('content')
<div class="p-4">
    <form method="POST" action="{{ route('user.profile.update-password') }}" class="space-y-4">
        @csrf
        @method('PUT')
        
        <!-- Security Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                <div>
                    <h3 class="text-sm font-medium text-blue-800">Security Notice</h3>
                    <p class="text-sm text-blue-700 mt-1">Make sure your new password is strong and unique. Use a combination of letters, numbers, and special characters.</p>
                </div>
            </div>
        </div>

        <!-- Current Password -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
            <input 
                type="password" 
                id="current_password" 
                name="current_password" 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your current password"
            >
            @error('current_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
            <input 
                type="password" 
                id="new_password" 
                name="new_password" 
                required 
                minlength="6"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your new password"
            >
            @error('new_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Password must be at least 6 characters long</p>
        </div>

        <!-- Confirm New Password -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
            <input 
                type="password" 
                id="new_password_confirmation" 
                name="new_password_confirmation" 
                required 
                minlength="6"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Confirm your new password"
            >
        </div>

        <!-- Password Strength Indicator -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Password Requirements</h3>
            <div class="space-y-1">
                <div class="flex items-center text-sm">
                    <i class="fas fa-check text-green-500 w-4 mr-2"></i>
                    <span class="text-gray-600">At least 6 characters</span>
                </div>
                <div class="flex items-center text-sm">
                    <i class="fas fa-times text-gray-400 w-4 mr-2"></i>
                    <span class="text-gray-600">Include uppercase letter</span>
                </div>
                <div class="flex items-center text-sm">
                    <i class="fas fa-times text-gray-400 w-4 mr-2"></i>
                    <span class="text-gray-600">Include lowercase letter</span>
                </div>
                <div class="flex items-center text-sm">
                    <i class="fas fa-times text-gray-400 w-4 mr-2"></i>
                    <span class="text-gray-600">Include number</span>
                </div>
                <div class="flex items-center text-sm">
                    <i class="fas fa-times text-gray-400 w-4 mr-2"></i>
                    <span class="text-gray-600">Include special character</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3 pt-4">
            <a href="{{ route('user.profile') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg text-center font-medium">
                Cancel
            </a>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg font-medium">
                Change Password
            </button>
        </div>
    </form>
</div>
@endsection
