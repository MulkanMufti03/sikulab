<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKunjungan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_kunjungan';

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'jam_mulai'   => 'string',
        'jam_selesai' => 'string',
        'kuota'       => 'integer',
    ];

    /**
     * Urutan hari dalam seminggu
     */
    public static array $urutanHari = [
        'Senin'  => 1,
        'Selasa' => 2,
        'Rabu'   => 3,
        'Kamis'  => 4,
        'Jumat'  => 5,
        'Sabtu'  => 6,
        'Minggu' => 7,
    ];

    /**
     * Format jam kunjungan (jam_mulai - jam_selesai)
     */
    public function getJamKunjunganAttribute(): string
    {
        return substr($this->jam_mulai, 0, 5) . ' - ' . substr($this->jam_selesai, 0, 5) . ' WIB';
    }

    /**
     * Label badge status
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->status === 'aktif'
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-danger">Non-Aktif</span>';
    }

    /**
     * Scope: hanya jadwal aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope: urutkan berdasarkan hari
     */
    public function scopeOrderByHari($query)
    {
        $order = array_keys(self::$urutanHari);
        return $query->orderByRaw('FIELD(hari, "' . implode('","', $order) . '")');
    }
}