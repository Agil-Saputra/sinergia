<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sinergia</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Admin Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span>Welcome, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4">
        <!-- Display Success Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Admin Panel</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800">Total Users</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800">Total Admins</h3>
                    <p class="text-3xl font-bold text-green-600">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-purple-800">All Users</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ \App\Models\User::count() }}</p>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">Admin Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold">User Management</h4>
                        <p class="text-gray-600">Manage all users in the system</p>
                        <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            View Users
                        </button>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold">System Settings</h4>
                        <p class="text-gray-600">Configure system parameters</p>
                        <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
