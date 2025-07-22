@extends('layouts.admin')

@section('title', 'Kelola Karyawan')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pengguna</h1>
            <p class="mt-2 text-gray-600">Kelola semua pengguna dalam sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary inline-flex items-center px-6 py-3 text-white font-medium rounded-xl shadow-sm hover:shadow-lg transition-all">
            <i class="fas fa-plus mr-2"></i>
            Tambah Pengguna
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card-modern p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
                <p class="text-sm text-gray-600">Total Pengguna</p>
            </div>
        </div>
    </div>

    <div class="card-modern p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-shield text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                <p class="text-sm text-gray-600">Administrator</p>
            </div>
        </div>
    </div>

    <div class="card-modern p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-hard-hat text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                <p class="text-sm text-gray-600">Karyawan</p>
            </div>
        </div>
    </div>

    <div class="card-modern p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Attendance::whereDate('date', today())->distinct('user_id')->count() }}</p>
                <p class="text-sm text-gray-600">Aktif Hari Ini</p>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card-modern overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Pengguna
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Kode Karyawan
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Nomor HP
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Bergabung
                    </th>
                    <th scope="col" class="relative px-6 py-4">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->employee_code ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->phone_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->role === 'admin' ? 'Administrator' : 'Karyawan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengguna</p>
                            <p class="text-gray-500">Tambahkan pengguna pertama untuk memulai</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
                                
<!-- Pagination -->
@if($users->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $users->links() }}
    </div>
@endif
@endsection
