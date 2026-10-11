<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;
use App\Models\Kunjungan;
use App\Models\Napidana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UtamaController extends Controller
{
    /** Hari -> Carbon::dayOfWeek (Minggu = 0) */
    private const HARI = [
        'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4,
        'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 0,
    ];

    public function utama()
    {
        return view('halamanutama');
    }

    public function formpengunjung()
    {
        $slots = $this->slotKunjungan();

        return view('formpengunjung', [
            'slots'     => $slots,
            'berikutnya' => $slots ? null : $this->jadwalBerikutnya(),
            'napi'      => Napidana::where('status', 'Aktif')->orderBy('nama_lengkap')->get(),
        ]);
    }

    public function simpanPengunjung(Request $request)
    {
        $data = $request->validate([
            'slot'        => ['required', 'regex:/^\d+\|\d{4}-\d{2}-\d{2}$/'],
            'napidana_id' => ['required', Rule::exists('napidanas', 'id')->where('status', 'Aktif')],
            'nama'        => ['required', 'string', 'max:255'],
            'nik'         => ['required', 'digits:16'],
            'no_hp'       => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'hubungan'    => ['required', 'string', 'max:100'],
            'alamat'      => ['nullable', 'string', 'max:500'],
            'foto_ktp'    => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'slot.required'  => 'Silakan pilih jadwal kunjungan.',
            'slot.regex'     => 'Jadwal kunjungan tidak valid.',
            'nik.digits'     => 'NIK harus 16 digit angka.',
            'no_hp.regex'    => 'Format nomor HP tidak valid (contoh: 081234567890).',
            'foto_ktp.max'   => 'Ukuran foto KTP maksimal 2 MB.',
            'foto_ktp.image' => 'File KTP harus berupa gambar (JPG/PNG).',
            'napidana_id.exists' => 'Narapidana tidak ditemukan atau sudah tidak aktif.',
        ]);

        [$jadwalId, $tanggalStr] = explode('|', $data['slot']);

        $kunjungan = DB::transaction(function () use ($data, $request, $jadwalId, $tanggalStr) {
            // Kunci baris jadwal agar kuota tidak "tembus" saat banyak yang daftar bersamaan
            $jadwal = JadwalKunjungan::aktif()->whereKey($jadwalId)->lockForUpdate()->first();

            if (! $jadwal) {
                throw ValidationException::withMessages(['slot' => 'Jadwal ini sudah tidak tersedia.']);
            }

            try {
                $tanggal = Carbon::createFromFormat('Y-m-d', $tanggalStr)->startOfDay();
            } catch (\Throwable $e) {
                throw ValidationException::withMessages(['slot' => 'Tanggal kunjungan tidak valid.']);
            }

            // Pendaftaran hanya untuk jadwal HARI INI (sesuai hari & jam nyata)
            $cocokHari    = self::HARI[$jadwal->hari] === $tanggal->dayOfWeek;
            $dalamRentang = $tanggal->isToday();
            $sudahLewat   = now()->format('H:i') >= substr($jadwal->jam_selesai, 0, 5);

            if (! $cocokHari || ! $dalamRentang || $sudahLewat) {
                throw ValidationException::withMessages(['slot' => 'Tanggal kunjungan tidak tersedia.']);
            }

            $terpakai = Kunjungan::where('jadwal_id', $jadwal->id)
                ->whereDate('tanggal_kunjungan', $tanggal)
                ->whereIn('status', Kunjungan::STATUS_PAKAI_KUOTA)
                ->count();

            if ($terpakai >= $jadwal->kuota) {
                throw ValidationException::withMessages(['slot' => 'Kuota untuk jadwal ini sudah penuh.']);
            }

            $sudahDaftar = Kunjungan::where('jadwal_id', $jadwal->id)
                ->whereDate('tanggal_kunjungan', $tanggal)
                ->where('nik', $data['nik'])
                ->exists();

            if ($sudahDaftar) {
                throw ValidationException::withMessages(['nik' => 'NIK ini sudah terdaftar pada jadwal tersebut.']);
            }

            return Kunjungan::create([
                'kode'              => Kunjungan::generateKode(),
                'jadwal_id'         => $jadwal->id,
                'tanggal_kunjungan' => $tanggal->toDateString(),
                'napidana_id'       => $data['napidana_id'],
                'nama'              => $data['nama'],
                'nik'               => $data['nik'],
                'no_hp'             => $data['no_hp'],
                'hubungan'          => $data['hubungan'],
                'alamat'            => $data['alamat'] ?? null,
                // KTP disimpan di disk private (tidak bisa diakses lewat URL publik)
                'foto_ktp'          => $request->file('foto_ktp')->store('ktp', 'local'),
                'status'            => 'menunggu',
            ]);
        });

        return redirect()
            ->route('cekstatus')
            ->with('success', 'Pendaftaran berhasil dikirim. Simpan kode pendaftaran Anda.')
            ->with('kode', $kunjungan->kode);
    }

    public function cekStatus()
    {
        return view('cekstatus');
    }

    public function prosesCekStatus(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'string', 'max:12'],
            'nik'  => ['required', 'digits:16'],
        ]);

        $kunjungan = Kunjungan::with(['jadwal', 'napidana'])
            ->where('kode', strtoupper($request->kode))
            ->where('nik', $request->nik)
            ->first();

        if (! $kunjungan) {
            return back()->withInput()->withErrors(['kode' => 'Data tidak ditemukan. Periksa kode dan NIK Anda.']);
        }

        return view('cekstatus', compact('kunjungan'));
    }

    /**
     * Jadwal aktif untuk HARI INI saja (berdasarkan hari nyata) yang jam
     * selesainya belum lewat, lengkap dengan sisa kuota hari ini.
     */
    private function slotKunjungan(): array
    {
        $hariIni = array_search(now()->dayOfWeek, self::HARI, true);
        $tanggal = today();

        $terpakai = Kunjungan::whereDate('tanggal_kunjungan', $tanggal)
            ->whereIn('status', Kunjungan::STATUS_PAKAI_KUOTA)
            ->selectRaw('jadwal_id, COUNT(*) as total')
            ->groupBy('jadwal_id')
            ->pluck('total', 'jadwal_id');

        return JadwalKunjungan::aktif()
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get()
            ->filter(fn ($j) => now()->format('H:i') < substr($j->jam_selesai, 0, 5))
            ->map(fn ($j) => (object) [
                'key'     => $j->id . '|' . $tanggal->toDateString(),
                'jadwal'  => $j,
                'tanggal' => $tanggal->copy(),
                'sisa'    => max(0, $j->kuota - (int) ($terpakai[$j->id] ?? 0)),
            ])
            ->values()
            ->all();
    }

    /** Jadwal aktif terdekat setelah hari ini (hanya untuk info saat hari ini kosong). */
    private function jadwalBerikutnya(): ?object
    {
        for ($i = 1; $i <= 7; $i++) {
            $tanggal = today()->addDays($i);
            $hari    = array_search($tanggal->dayOfWeek, self::HARI, true);

            $jadwal = JadwalKunjungan::aktif()->where('hari', $hari)->orderBy('jam_mulai')->first();

            if ($jadwal) {
                return (object) ['tanggal' => $tanggal, 'jam' => $jadwal->jam_kunjungan];
            }
        }

        return null;
    }
}