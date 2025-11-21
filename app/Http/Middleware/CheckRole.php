<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Handle comma-separated roles
        $allowedRoles = [];
        foreach ($roles as $role) {
            if (str_contains($role, ',')) {
                $allowedRoles = array_merge($allowedRoles, explode(',', $role));
            } else {
                $allowedRoles[] = $role;
            }
        }

        if (!in_array($request->user()->role, $allowedRoles)) {
            return abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}