@extends('layouts.mobile')

@section('title', 'Dashboard - Sinergia')
@section('header', 'Dashboard')

@section('content')
<div class="p-4 space-y-4">
    <!-- Quick Stats -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Reports</p>
                    <p class="text-lg font-semibold">12</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tasks text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Tasks</p>
                    <p class="text-lg font-semibold">8</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="text-lg font-semibold mb-3">Recent Activity</h3>
        <div class="space-y-3">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-xs"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">New report submitted</p>
                    <p class="text-xs text-gray-500">2 hours ago</p>
                </div>
            </div>
            
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">Task completed</p>
                    <p class="text-xs text-gray-500">5 hours ago</p>
                </div>
            </div>
            
            <div class="flex items-center">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xs"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">Task deadline approaching</p>
                    <p class="text-xs text-gray-500">1 day ago</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="text-lg font-semibold mb-3">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('user.emergency-reports') }}" class="flex items-center justify-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                <i class="fas fa-plus text-blue-600 mr-2"></i>
                <span class="text-sm font-medium text-blue-600">New Report</span>
            </a>
            
            <a href="{{ route('user.tasks.create') }}" class="flex items-center justify-center p-3 bg-green-50 rounded-lg border border-green-200">
                <i class="fas fa-plus text-green-600 mr-2"></i>
                <span class="text-sm font-medium text-green-600">New Task</span>
            </a>
        </div>
    </div>

    <!-- Profile Summary -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <h3 class="text-lg font-semibold mb-3">Profile Summary</h3>
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                <span class="text-white text-lg font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="ml-3 flex-1">
                <p class="font-medium">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                <p class="text-xs text-gray-500">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
            </div>
            <a href="{{ route('user.profile') }}" class="text-blue-600">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection
