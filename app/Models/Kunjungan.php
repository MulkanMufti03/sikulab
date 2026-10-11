<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    public const STATUS_PAKAI_KUOTA = ['menunggu', 'disetujui', 'selesai'];

    protected $fillable = [
        'kode', 'jadwal_id', 'tanggal_kunjungan', 'napidana_id', 'nama', 'nik',
        'no_hp', 'hubungan', 'alamat', 'foto_ktp', 'status',
        'alasan_penolakan', 'waktu_masuk', 'waktu_keluar',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'waktu_masuk'       => 'datetime',
        'waktu_keluar'      => 'datetime',
    ];

    public function jadwal(): BelongsTo
    {
        // withTrashed: jadwal yang sudah dihapus admin (soft delete) tetap terbaca di riwayat
        return $this->belongsTo(JadwalKunjungan::class, 'jadwal_id')->withTrashed();
    }

    public function napidana(): BelongsTo
    {
        return $this->belongsTo(Napidana::class, 'napidana_id');
    }

    public static function generateKode(): string
    {
        do {
            $kode = 'KJ' . strtoupper(Str::random(6));
        } while (static::where('kode', $kode)->exists());

        return $kode;
    }
}
