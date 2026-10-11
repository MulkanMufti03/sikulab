<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Cara penggunaan di route:
     *   Route::middleware(['auth', 'role:admin'])  → hanya admin
     *   Route::middleware(['auth', 'role:petugas']) → hanya petugas
     *   Route::middleware(['auth', 'role:admin,petugas']) → keduanya boleh
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan user sudah login
        if (! auth()->check()) {
            return redirect()->route('auth.login');
        }

        $user = auth()->user();

        // Cek apakah kolom 'role' ada di user model
        // Sesuaikan nama kolom dengan tabel users kamu (role / tipe / jabatan, dsb.)
        $userRole = $user->role ?? null; // ← ganti 'role' jika nama kolomnya berbeda

        if (! in_array($userRole, $roles)) {
            // Jika role tidak cocok, redirect ke halaman yang sesuai
            // daripada menampilkan halaman 403 kosong
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            if ($userRole === 'petugas') {
                return redirect()->route('petugas.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            // Fallback: abort 403 dengan pesan yang jelas
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}