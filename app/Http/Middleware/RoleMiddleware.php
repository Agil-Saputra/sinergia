<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access this page.');
        }

        $user = Auth::user();

        if ($role === 'admin' && !$user->isAdmin()) {
            return redirect('/login')->with('error', 'Access denied. Admin only.');
        }

        if ($role === 'user' && !$user->isUser()) {
            return redirect('/login')->with('error', 'Access denied. User only.');
        }

        return $next($request);
    }
}
