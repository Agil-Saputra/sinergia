<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the profile page
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }
        
        return view('user.profile');
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }
        
        return view('user.edit-profile');
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        
        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        
        $user->save();
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
        }
        
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show change password form
     */
    public function changePassword()
    {
        if (!Auth::check() || !Auth::user()->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }
        
        return view('user.change-password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'new_password_confirmation' => 'required|same:new_password',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['current_password' => ['Password lama tidak sesuai.']]
                ], 422);
            }
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah!'
            ]);
        }
        
        return redirect()->route('user.profile')->with('success', 'Password changed successfully!');
    }
}
