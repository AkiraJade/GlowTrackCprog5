<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirect admins to admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            // Redirect other authenticated users to regular dashboard
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
