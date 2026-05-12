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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah role user yang login sesuai dengan yang diizinkan di Route
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // 2. Jika tidak sesuai, lempar user ke tempat yang benar
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard'); // Untuk mahasiswa & dosen
        }

        // 3. Jika belum login sama sekali
        return redirect('/login');
    }
}

