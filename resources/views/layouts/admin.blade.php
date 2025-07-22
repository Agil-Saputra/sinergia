<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .sidebar-active {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
        }
        .sidebar-active i {
            color: white;
        }
        .card-modern {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #f3f4f6;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow overflow-y-auto bg-white shadow-sm">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-6 py-6">
                        <div class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="logo sinergia" class="h-8 w-auto" onerror="this.style.display='none'">
                    <span class="text-xl font-semibold text-black">Sinergia</span>
                </div>
                </div>

                <!-- Navigation -->
                <div class="flex-grow flex flex-col px-4">
                    <nav class="flex-1 space-y-2">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-chart-pie mr-3 text-lg"></i>
                            Dashboard
                        </a>

                        <!-- Users Management -->
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-users mr-3 text-lg"></i>
                            Kelola Karyawan
                        </a>

                        <!-- Task Management -->
                        <a href="{{ route('admin.tasks.index') }}" 
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.tasks.*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-tasks mr-3 text-lg"></i>
                            Kelola Tugas
                        </a>

                        <!-- Employee Attendance -->
                        <a href="{{ route('admin.attendance.index') }}" 
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.attendance.*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-clock mr-3 text-lg"></i>
                            Absensi
                        </a>

                        <!-- Reports -->
                        <a href="{{ route('admin.export.index') }}" 
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.export.*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-download mr-3 text-lg"></i>
                            Export Data
                        </a>

                        <!-- Emergency Reports -->
                        <a href="{{ route('admin.emergency-reports.index') }}" 
                           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('admin.emergency-reports.*') ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                            Laporan Darurat
                        </a>
                    </nav>

                    <!-- User Profile & Logout -->
                    <div class="border-t border-gray-100 pt-4 pb-4 mt-4">
                        <div class="px-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 px-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow-sm border-b border-gray-100">
                <button type="button" onclick="openMobileSidebar()" class="px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex-1 px-6 flex justify-between items-center">
                    <div class="flex-1 flex">
                        <h2 class="text-2xl font-bold text-gray-900">@yield('title')</h2>
                    </div>
                    <div class="ml-4 flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            <i class="fas fa-bell text-lg"></i>
                        </button>
                        <!-- User Menu -->
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none bg-gray-50">
                <div class="py-8">
                    <div class="max-w-7xl mx-auto px-6">
                        <!-- Display Success Messages -->
                        @if(session('success'))
                            <div class="mb-6 card-modern p-4 border-l-4 border-green-500 bg-green-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 card-modern p-4 border-l-4 border-red-500 bg-red-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    <!-- Mobile Sidebar -->
    <div class="md:hidden" id="mobile-sidebar">
        <div class="fixed inset-0 z-40 flex">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="closeMobileSidebar()"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button" onclick="closeMobileSidebar()" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4 mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">S</span>
                        </div>
                        <h1 class="ml-3 text-xl font-bold text-gray-900">Sinergia</h1>
                    </div>
                    <nav class="px-2 space-y-2">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50">
                            <i class="fas fa-chart-pie mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50">
                            <i class="fas fa-users mr-3"></i>
                            Kelola Karyawan
                        </a>
                        <a href="{{ route('admin.tasks.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50">
                            <i class="fas fa-tasks mr-3"></i>
                            Kelola Tugas
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50">
                            <i class="fas fa-clock mr-3"></i>
                            Absensi
                        </a>
                        <a href="{{ route('admin.export.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50">
                            <i class="fas fa-download mr-3"></i>
                            Export Data
                        </a>
                        <a href="{{ route('admin.emergency-reports.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            Laporan Darurat
                        </a>
                    </nav>
                </div>
            </div>
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
