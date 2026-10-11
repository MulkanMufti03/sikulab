<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class PetugasKunjunganController extends Controller
{
    private const STATUS = ['menunggu', 'disetujui', 'ditolak', 'selesai', 'semua'];

    /** Daftar pendaftaran pengunjung (default: yang menunggu konfirmasi). */
    public function index(Request $request)
    {
        $status = in_array($request->status, self::STATUS, true) ? $request->status : 'menunggu';

        $kunjungan = Kunjungan::with(['jadwal', 'napidana'])
            ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
            ->when($request->tanggal, fn ($q, $t) => $q->whereDate('tanggal_kunjungan', $t))
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('nama', 'like', "%{$s}%")
                ->orWhere('kode', 'like', "%{$s}%")
                ->orWhere('nik', 'like', "%{$s}%")))
            ->orderBy('tanggal_kunjungan')
            ->orderBy('created_at')
            ->paginate(15)
            ->withQueryString();

        $jumlahMenunggu = Kunjungan::where('status', 'menunggu')->count();

        return view('petugas.kunjungan.index', compact('kunjungan', 'status', 'jumlahMenunggu'));
    }

    public function show($id)
    {
        $kunjungan = Kunjungan::with(['jadwal', 'napidana'])->findOrFail($id);

        return view('petugas.kunjungan.show', compact('kunjungan'));
    }

    /** Konfirmasi / setujui pendaftaran. */
    public function setujui($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        if ($kunjungan->status !== 'menunggu') {
            return back()->with('error', 'Hanya pendaftaran berstatus "menunggu" yang bisa disetujui.');
        }

        $kunjungan->update(['status' => 'disetujui', 'alasan_penolakan' => null]);

        return back()->with('success', 'Pendaftaran ' . $kunjungan->kode . ' disetujui.');
    }

    /** Tolak pendaftaran (alasan wajib diisi). */
    public function tolak(Request $request, $id)
    {
        $request->validate(['alasan_penolakan' => ['required', 'string', 'max:500']], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $kunjungan = Kunjungan::findOrFail($id);

        if ($kunjungan->status !== 'menunggu') {
            return back()->with('error', 'Hanya pendaftaran berstatus "menunggu" yang bisa ditolak.');
        }

        $kunjungan->update([
            'status'           => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return back()->with('success', 'Pendaftaran ' . $kunjungan->kode . ' ditolak.');
    }

    public function checkIn($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        if ($kunjungan->status !== 'disetujui' || $kunjungan->waktu_masuk) {
            return back()->with('error', 'Pengunjung tidak bisa check-in (belum disetujui atau sudah masuk).');
        }

        if (! $kunjungan->tanggal_kunjungan->isToday()) {
            return back()->with('error', 'Check-in hanya bisa dilakukan pada tanggal kunjungan.');
        }

        $kunjungan->update(['waktu_masuk' => now()]);

        return back()->with('success', $kunjungan->nama . ' berhasil check-in.');
    }

    public function checkOut($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        if (! $kunjungan->waktu_masuk || $kunjungan->waktu_keluar) {
            return back()->with('error', 'Pengunjung belum check-in atau sudah check-out.');
        }

        $kunjungan->update(['waktu_keluar' => now(), 'status' => 'selesai']);

        return back()->with('success', $kunjungan->nama . ' berhasil check-out.');
    }
}