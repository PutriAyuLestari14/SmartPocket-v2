<?php

namespace App\Http\Middleware;

use App\Models\Nasabah;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckNasabahStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'nasabah') {
            $nasabah = Nasabah::where('username', Auth::user()->username)->first();

            // Kolom status: 'aktif' / 'nonaktif'
            if ($nasabah && strtolower($nasabah->status) === 'nonaktif') {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi operator.');
            }
        }

        return $next($request);
    }
}