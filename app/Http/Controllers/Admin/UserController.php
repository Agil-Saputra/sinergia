<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'employee_code' => 'required|string|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'employee_code' => $request->employee_code,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Base validation rules
        $rules = [];
        $updateData = [];

        // Only validate and update fields that are provided and different from current values
        if ($request->filled('name') && $request->name !== $user->name) {
            $rules['name'] = 'required|string|max:255';
            $updateData['name'] = $request->name;
        }

        if ($request->filled('email') && $request->email !== $user->email) {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
            $updateData['email'] = $request->email;
        }

        if ($request->filled('employee_code') && $request->employee_code !== $user->employee_code) {
            $rules['employee_code'] = 'required|string|max:255|unique:users,employee_code,' . $user->id;
            $updateData['employee_code'] = $request->employee_code;
        }

        if ($request->has('phone_number') && $request->phone_number !== $user->phone_number) {
            $rules['phone_number'] = 'nullable|string|max:20';
            $updateData['phone_number'] = $request->phone_number;
        }

        if ($request->filled('role') && $request->role !== $user->role) {
            $rules['role'] = 'required|in:admin,user';
            $updateData['role'] = $request->role;
        }

        $passwordChanged = false;

        // Handle password update separately
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $updateData['password'] = Hash::make($request->password);
            $passwordChanged = true;
        }

        // Validate only the fields that are being updated
        if (!empty($rules)) {
            $request->validate($rules);
        }

        // Check if there are any changes to make
        if (empty($updateData)) {
            return redirect()->back()->with('info', 'Tidak ada perubahan yang terdeteksi.');
        }

        // Update the user
        $user->update($updateData);

        $message = 'User updated successfully!';
        if ($passwordChanged) {
            $message .= ' Password juga telah diperbarui.';
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
