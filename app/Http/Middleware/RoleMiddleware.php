<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = strtolower(trim(Auth::user()->role ?? ''));

        $allowedRoles = array_map(function ($role) {
            return strtolower(trim($role));
        }, $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Akses di tolak, anda tidak memmiliki akses ini ');
        }

        return $next($request);
    }
}