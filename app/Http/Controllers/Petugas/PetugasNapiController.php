<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Napidana;
use Illuminate\Http\Request;

class PetugasNapiController extends Controller
{
    /**
     * Tampilkan daftar narapidana (read-only untuk petugas).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $napidanas = Napidana::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap',  'like', "%{$search}%")
                      ->orWhere('no_registrasi', 'like', "%{$search}%")
                      ->orWhere('kasus',         'like', "%{$search}%");
                });
            })
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.datanapi.index', compact('napidanas', 'search', 'status'));
    }

    /**
     * Tampilkan detail narapidana (read-only).
     */
    public function show($id)
    {
        $napi = Napidana::findOrFail($id);

        return view('petugas.datanapi.show', compact('napi'));
    }
}