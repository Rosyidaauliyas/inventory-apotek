<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek login & role (pake strtolower biar aman dari typo huruf besar-kecil di DB)
        if (auth()->check() && in_array(strtolower(auth()->user()->role), array_map('strtolower', $roles))) {
            return $next($request);
        }

        // 2. Jika tidak sesuai, lempar ke halaman 403 Forbidden
        abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}