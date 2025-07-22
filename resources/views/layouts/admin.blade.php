<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white border-r border-gray-200">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">S</span>
                        </div>
                        <h1 class="ml-3 text-xl font-bold text-gray-900">Sinergia</h1>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-8 flex-grow flex flex-col">
                    <nav class="flex-1 px-2 pb-4 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-tachometer-alt mr-3 flex-shrink-0 h-5 w-5"></i>
                            Dashboard
                        </a>

                        <!-- Users Management -->
                        <a href="{{ route('admin.users.index') }}" 
                           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-users mr-3 flex-shrink-0 h-5 w-5"></i>
                            Users Management
                        </a>

                        <!-- Task Management -->
                        <a href="{{ route('admin.tasks.index') }}" 
                           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.tasks.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-tasks mr-3 flex-shrink-0 h-5 w-5"></i>
                            Manage Tasks
                        </a>

                        <!-- Employee Attendance -->
                        <a href="{{ route('admin.attendance.index') }}" 
                           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-clock mr-3 flex-shrink-0 h-5 w-5"></i>
                            Employee Attendance
                        </a>

                        <!-- Reports -->
                        <a href="{{ route('admin.reports.index') }}" 
                           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-chart-bar mr-3 flex-shrink-0 h-5 w-5"></i>
                            Reports
                        </a>

                        <!-- Emergency Reports -->
                        <a href="{{ route('admin.emergency-reports.index') }}" 
                           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.emergency-reports.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-exclamation-triangle mr-3 flex-shrink-0 h-5 w-5"></i>
                            Emergency Reports
                        </a>
                    </nav>

                    <!-- User Profile & Logout -->
                    <div class="border-t border-gray-200 pt-4 pb-3">
                        <div class="px-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="group flex items-center w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-gray-900">
                                    <i class="fas fa-sign-out-alt mr-3 flex-shrink-0 h-5 w-5"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Sidebar -->
        <div class="md:hidden" id="mobile-sidebar">
            <div class="fixed inset-0 z-40 flex">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="closeMobileSidebar()"></div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" onclick="closeMobileSidebar()" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <i class="fas fa-times h-6 w-6 text-white"></i>
                        </button>
                    </div>
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">S</span>
                                </div>
                                <h1 class="ml-3 text-xl font-bold text-gray-900">Sinergia</h1>
                            </div>
                        </div>
                        <nav class="mt-5 px-2 space-y-1">
                            <!-- Mobile Navigation Items (same as desktop) -->
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-tachometer-alt mr-3 h-5 w-5"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-users mr-3 h-5 w-5"></i>
                                Users Management
                            </a>
                            <a href="{{ route('admin.tasks.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-tasks mr-3 h-5 w-5"></i>
                                Manage Tasks
                            </a>
                            <a href="{{ route('admin.attendance.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-clock mr-3 h-5 w-5"></i>
                                Employee Attendance
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-chart-bar mr-3 h-5 w-5"></i>
                                Reports
                            </a>
                            <a href="{{ route('admin.emergency-reports.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-exclamation-triangle mr-3 h-5 w-5"></i>
                                Emergency Reports
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button type="button" onclick="openMobileSidebar()" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden">
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <div class="w-full flex md:ml-0">
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <i class="fas fa-search h-5 w-5"></i>
                                </div>
                                <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Search..." type="search">
                            </div>
                        </div>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notifications -->
                        <button class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-bell h-6 w-6"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Display Success Messages -->
                        @if(session('success'))
                            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle h-5 w-5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle h-5 w-5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar functions
        function openMobileSidebar() {
            document.getElementById('mobile-sidebar').classList.remove('hidden');
        }

        function closeMobileSidebar() {
            document.getElementById('mobile-sidebar').classList.add('hidden');
        }

        // Hide mobile sidebar initially
        document.getElementById('mobile-sidebar').classList.add('hidden');
    </script>
</body>
</html>
