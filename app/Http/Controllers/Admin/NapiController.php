<?php
// app/Http/Controllers/Admin/NapiController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Napidana;
use Illuminate\Http\Request;

class NapiController extends Controller
{
    /**
     * Tampilkan daftar semua narapidana
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $napidanas = Napidana::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_registrasi', 'like', "%{$search}%")
                  ->orWhere('kasus', 'like', "%{$search}%")
                  ->orWhere('asal_daerah', 'like', "%{$search}%");
            })
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.manajemennapi.index', compact('napidanas', 'search', 'status'));
    }

    /**
     * Form tambah narapidana
     */
    public function tambah()
    {
        return view('admin.manajemennapi.tambah');
    }

    /**
     * Simpan narapidana baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_registrasi'  => 'required|string|unique:napidanas,no_registrasi',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'kasus'          => 'required|string|max:255',
            'tanggal_masuk'  => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
            'status'         => 'required|in:Aktif,Bebas,Meninggal',
            'asal_daerah'    => 'required|string|max:255',
            'keterangan'     => 'nullable|string',
        ], [
            'no_registrasi.unique'         => 'Nomor registrasi sudah digunakan.',
            'tanggal_keluar.after'         => 'Tanggal keluar harus setelah tanggal masuk.',
            'jenis_kelamin.in'             => 'Jenis kelamin tidak valid.',
            'status.in'                    => 'Status tidak valid.',
        ]);

        Napidana::create($request->all());

        return redirect()->route('manajemennapi.index')
                         ->with('success', 'Data narapidana berhasil ditambahkan.');
    }

    /**
     * Detail narapidana
     */
    public function show($id)
    {
        $napi = Napidana::findOrFail($id);
        return view('admin.manajemennapi.lihat', compact('napi'));
    }

    /**
     * Form edit narapidana
     */
    public function edit($id)
    {
        $napi = Napidana::findOrFail($id);
        return view('admin.manajemennapi.edit', compact('napi'));
    }

    /**
     * Update data narapidana
     */
    public function update(Request $request, $id)
    {
        $napi = Napidana::findOrFail($id);

        $request->validate([
            'no_registrasi'  => 'required|string|unique:napidanas,no_registrasi,' . $id,
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'kasus'          => 'required|string|max:255',
            'tanggal_masuk'  => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
            'status'         => 'required|in:Aktif,Bebas,Meninggal',
            'asal_daerah'    => 'required|string|max:255',
            'keterangan'     => 'nullable|string',
        ]);

        $napi->update($request->all());

        return redirect()->route('manajemennapi.index')
                         ->with('success', 'Data narapidana berhasil diperbarui.');
    }

    /**
     * Hapus narapidana
     */
    public function destroy($id)
    {
        $napi = Napidana::findOrFail($id);
        $napi->delete();

        return redirect()->route('manajemennapi.index')
                         ->with('success', 'Data narapidana berhasil dihapus.');
    }
}