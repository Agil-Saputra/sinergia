<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sinergia Mobile')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom mobile styles */
        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            background: #f8fafc;
        }
        
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            background: white;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .nav-item {
            transition: all 0.2s ease;
        }
        
        .nav-item.active {
            color: #3b82f6;
        }
        
        .nav-item:not(.active) {
            color: #6b7280;
        }
        
        .content-wrapper {
            padding-bottom: 80px; /* Space for bottom nav */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="mobile-container">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="px-4 py-3 flex items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-800">@yield('header', 'Sinergia')</h1>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 hidden sm:inline">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <!-- Logout button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 ml-2">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content-wrapper">
            <!-- Display Success Messages -->
            @if(session('success'))
                <div class="mx-4 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display Error Messages -->
            @if(session('error'))
                <div class="mx-4 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Bottom Navigation -->
        <nav class="bottom-nav">
            <div class="flex justify-around items-center py-2">
                <!-- Attendance Tab -->
                <a href="{{ route('attendance.index') }}" class="nav-item flex flex-col items-center py-2 {{ request()->routeIs('attendance*') ? 'active' : '' }}">
                    <i class="fas fa-clock text-xl mb-1"></i>
                    <span class="text-xs">Absensi</span>
                </a>
                
                <!-- Report Tab -->
                <a href="{{ route('user.emergency-reports') }}" class="nav-item flex flex-col items-center py-2 {{ request()->routeIs('user.emergency-reports*') || request()->routeIs('user.reports*') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle text-xl mb-1"></i>
                    <span class="text-xs">Emergency</span>
                </a>
                
                <!-- Task Tab -->
                <a href="{{ route('user.tasks') }}" class="nav-item flex flex-col items-center py-2 {{ request()->routeIs('user.tasks*') ? 'active' : '' }}">
                    <i class="fas fa-tasks text-xl mb-1"></i>
                    <span class="text-xs">Tasks</span>
                </a>
                
                <!-- Profile Tab -->
                <a href="{{ route('user.profile') }}" class="nav-item flex flex-col items-center py-2 {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
                    <i class="fas fa-user text-xl mb-1"></i>
                    <span class="text-xs">Profile</span>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>
