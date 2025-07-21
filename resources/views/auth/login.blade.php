<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sinergia</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Login</h1>
            <p class="text-gray-600 mt-2">Please sign in to your account</p>
        </div>

        <!-- Display Success Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Error Messages -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Enter your email address"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Enter your password"
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember" 
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Remember me
                </label>
            </div>

            <!-- Login Button -->
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200"
                >
                    Sign In
                </button>
            </div>
        </form>

        <!-- Role Information -->
        <div class="mt-6 p-4 bg-gray-50 rounded-md">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Test Accounts:</h3>
            <div class="text-xs text-gray-600">
                <p><strong>Admin:</strong> admin@example.com</p>
                <p><strong>User:</strong> user@example.com</p>
                <p><strong>Password:</strong> password123</p>
            </div>
        </div>
    </div>
</body>
</html>
