<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Jika middleware dipanggil tanpa parameter role, izinkan lewat
        if (empty($roles)) {
            return $next($request);
        }

        // 3. Bersihkan spasi dan samakan huruf kecil pada role user dari database
        $userRole = trim(strtolower($user->role));

        // 4. Ubah daftar roles yang diizinkan menjadi huruf kecil semua
        $allowedRoles = array_map('strtolower', $roles);

        // 5. Cek apakah role user saat ini ada di dalam daftar yang diizinkan
        if (!in_array($userRole, $allowedRoles)) {
            // Jika tidak ada di dalam daftar, kunci akses dengan 403
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}