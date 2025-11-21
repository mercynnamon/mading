<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redirect ke dashboard sesuai role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'guru':
                        return redirect()->route('guru.dashboard');
                    case 'siswa':
                        return redirect()->route('siswa.dashboard');
                    default:
                        Auth::logout();
                        return redirect()->route('public.index')->with('error', 'Role tidak valid.');
                }
            }
        }

        return $next($request);
    }
}