<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login
        // 2. Pastikan kolom is_admin pada user tersebut bernilai true
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Izinkan akses (lanjutkan request)
        }

        // Jika bukan admin, kembalikan ke beranda (atau tampilkan error 403)
        // abort(403, 'Akses Ditolak. Anda bukan Admin.'); // <- Gunakan ini jika ingin tampilan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}