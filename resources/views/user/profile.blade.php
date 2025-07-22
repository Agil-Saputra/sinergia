@extends('layouts.mobile')

@section('title', 'Profile - Sinergia')
@section('header', 'Profile')

@section('content')
<div class="p-4 space-y-4">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg p-6 shadow-sm text-center">
        <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-white text-2xl font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
        <p class="text-gray-600">{{ Auth::user()->email }}</p>
        <span class="inline-block mt-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ ucfirst(Auth::user()->role) }}</span>
    </div>

    <!-- Profile Options -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <a href="{{ route('user.profile.edit') }}" class="flex items-center p-4 border-b border-gray-100">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-edit text-blue-600"></i>
            </div>
            <div class="ml-3 flex-1">
                <p class="font-medium">Edit Profile</p>
                <p class="text-sm text-gray-600">Update your personal information</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </a>

        <a href="{{ route('user.profile.change-password') }}" class="flex items-center p-4 border-b border-gray-100">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-lock text-green-600"></i>
            </div>
            <div class="ml-3 flex-1">
                <p class="font-medium">Change Password</p>
                <p class="text-sm text-gray-600">Update your account password</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </a>

        <div class="flex items-center p-4 border-b border-gray-100">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-bell text-purple-600"></i>
            </div>
            <div class="ml-3 flex-1">
                <p class="font-medium">Notifications</p>
                <p class="text-sm text-gray-600">Manage notification preferences</p>
            </div>
            <div class="flex items-center">
                <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
            </div>
        </div>

        <div class="flex items-center p-4">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-question-circle text-yellow-600"></i>
            </div>
            <div class="ml-3 flex-1">
                <p class="font-medium">Help & Support</p>
                <p class="text-sm text-gray-600">Get help and contact support</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </div>
    </div>

    <!-- Account Information -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="font-medium mb-3">Account Information</h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Member Since</span>
                <span class="font-medium">{{ Auth::user()->created_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Last Updated</span>
                <span class="font-medium">{{ Auth::user()->updated_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Account Status</span>
                <span class="text-green-600 font-medium">Active</span>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="font-medium mb-3">My Statistics</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-3 bg-blue-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">12</p>
                <p class="text-sm text-gray-600">Reports Created</p>
            </div>
            <div class="text-center p-3 bg-green-50 rounded-lg">
                <p class="text-2xl font-bold text-green-600">8</p>
                <p class="text-sm text-gray-600">Tasks Completed</p>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center p-3 bg-red-50 text-red-600 rounded-lg border border-red-200 hover:bg-red-100">
                <i class="fas fa-sign-out-alt mr-2"></i>
                <span class="font-medium">Sign Out</span>
            </button>
        </form>
    </div>
</div>
@endsection
