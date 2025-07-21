<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Sinergia</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">User Dashboard</h1>
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
            <h2 class="text-2xl font-bold mb-4 text-gray-800">User Panel</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800">My Profile</h3>
                    <p class="text-gray-600">Name: {{ Auth::user()->name }}</p>
                    <p class="text-gray-600">Email: {{ Auth::user()->email }}</p>
                    <p class="text-gray-600">Role: {{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800">Account Status</h3>
                    <p class="text-2xl font-bold text-green-600">Active</p>
                    <p class="text-gray-600">Member since {{ Auth::user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">User Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold">My Documents</h4>
                        <p class="text-gray-600">View and manage your documents</p>
                        <button class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            View Documents
                        </button>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold">Profile Settings</h4>
                        <p class="text-gray-600">Update your profile information</p>
                        <button class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Edit Profile
                        </button>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold">Support</h4>
                        <p class="text-gray-600">Get help and support</p>
                        <button class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
