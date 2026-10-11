<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class JadwalKunjunganController extends Controller
{
    /**
     * Tampilkan daftar semua jadwal kunjungan.
     */
    public function index(Request $request): View
    {
        $query = JadwalKunjungan::query();

        // Filter berdasarkan hari
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search keterangan
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        $jadwals = $query->orderByHari()
                         ->orderBy('jam_mulai')
                         ->paginate(10)
                         ->withQueryString();

        $hariOptions = array_keys(JadwalKunjungan::$urutanHari);

        return view('admin.jadwal.index', compact('jadwals', 'hariOptions'));
    }

    /**
     * Tampilkan form tambah jadwal baru.
     */
    public function create(): View
    {
        $hariOptions = array_keys(JadwalKunjungan::$urutanHari);
        return view('admin.jadwal.create', compact('hariOptions'));
    }

    /**
     * Simpan jadwal baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hari'        => ['required', Rule::in(array_keys(JadwalKunjungan::$urutanHari))],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'kuota'       => ['required', 'integer', 'min:1', 'max:9999'],
            'status'      => ['required', Rule::in(['aktif', 'nonaktif'])],
            'keterangan'  => ['nullable', 'string', 'max:500'],
        ], [
            'hari.required'        => 'Hari kunjungan wajib dipilih.',
            'hari.in'              => 'Hari kunjungan tidak valid.',
            'jam_mulai.required'   => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (HH:MM).',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (HH:MM).',
            'jam_selesai.after'    => 'Jam selesai harus lebih besar dari jam mulai.',
            'kuota.required'       => 'Kuota pengunjung wajib diisi.',
            'kuota.integer'        => 'Kuota harus berupa angka.',
            'kuota.min'            => 'Kuota minimal 1 orang.',
            'status.required'      => 'Status wajib dipilih.',
        ]);

        // Cek duplikasi jadwal pada hari yang sama dengan jam yang overlap
        $overlap = JadwalKunjungan::where('hari', $validated['hari'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('jam_mulai', '<=', $validated['jam_mulai'])
                         ->where('jam_selesai', '>=', $validated['jam_selesai']);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors(['jam_mulai' => 'Jadwal pada hari dan jam tersebut sudah ada atau tumpang tindih.']);
        }

        JadwalKunjungan::create($validated);

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal kunjungan berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail jadwal (opsional).
     */
    public function show(JadwalKunjungan $jadwal): View
    {
        return view('admin.jadwal.show', compact('jadwal'));
    }

    /**
     * Tampilkan form edit jadwal.
     */
    public function edit(JadwalKunjungan $jadwal): View
    {
        $hariOptions = array_keys(JadwalKunjungan::$urutanHari);
        return view('admin.jadwal.edit', compact('jadwal', 'hariOptions'));
    }

    /**
     * Update jadwal di database.
     */
    public function update(Request $request, JadwalKunjungan $jadwal): RedirectResponse
    {
        $validated = $request->validate([
            'hari'        => ['required', Rule::in(array_keys(JadwalKunjungan::$urutanHari))],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'kuota'       => ['required', 'integer', 'min:1', 'max:9999'],
            'status'      => ['required', Rule::in(['aktif', 'nonaktif'])],
            'keterangan'  => ['nullable', 'string', 'max:500'],
        ], [
            'hari.required'        => 'Hari kunjungan wajib dipilih.',
            'jam_mulai.required'   => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (HH:MM).',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (HH:MM).',
            'jam_selesai.after'    => 'Jam selesai harus lebih besar dari jam mulai.',
            'kuota.required'       => 'Kuota pengunjung wajib diisi.',
            'kuota.integer'        => 'Kuota harus berupa angka.',
            'kuota.min'            => 'Kuota minimal 1 orang.',
            'status.required'      => 'Status wajib dipilih.',
        ]);

        // Cek duplikasi (kecuali jadwal itu sendiri)
        $overlap = JadwalKunjungan::where('hari', $validated['hari'])
            ->where('id', '!=', $jadwal->id)
            ->where(function ($q) use ($validated) {
                $q->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('jam_mulai', '<=', $validated['jam_mulai'])
                         ->where('jam_selesai', '>=', $validated['jam_selesai']);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors(['jam_mulai' => 'Jadwal pada hari dan jam tersebut sudah ada atau tumpang tindih.']);
        }

        $jadwal->update($validated);

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal kunjungan berhasil diperbarui.');
    }

    /**
     * Hapus jadwal (soft delete).
     */
    public function destroy(JadwalKunjungan $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal kunjungan berhasil dihapus.');
    }

    /**
     * Toggle status aktif/nonaktif via AJAX atau redirect.
     */
    public function toggleStatus(JadwalKunjungan $jadwal): RedirectResponse
    {
        $jadwal->update([
            'status' => $jadwal->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        $label = $jadwal->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('jadwal.index')
            ->with('success', "Jadwal kunjungan berhasil {$label}.");
    }
}