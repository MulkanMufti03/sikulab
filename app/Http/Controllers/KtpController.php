<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Support\Facades\Storage;

/**
 * Menampilkan foto KTP dari disk private.
 * Hanya user yang login (admin/petugas) yang bisa mengakses.
 */
class KtpController extends Controller
{
    public function __invoke($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        abort_unless(Storage::disk('local')->exists($kunjungan->foto_ktp), 404);

        return Storage::disk('local')->response($kunjungan->foto_ktp);
    }
}