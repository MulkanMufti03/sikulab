<?php
// app/Models/Napidana.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Napidana extends Model
{
    use HasFactory;

    protected $table = 'napidanas';

    protected $fillable = [
        'no_registrasi',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'kasus',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'asal_daerah',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir'   => 'date',
        'tanggal_masuk'   => 'date',
        'tanggal_keluar'  => 'date',
    ];

    // Accessor: hitung sisa masa tahanan
    public function getSisaMasaTahananAttribute(): string
    {
        if ($this->tanggal_keluar->isPast()) {
            return 'Selesai';
        }
        $diff = now()->diff($this->tanggal_keluar);
        return $diff->y . ' thn ' . $diff->m . ' bln ' . $diff->d . ' hr';
    }

    // Accessor: durasi total tahanan
    public function getMasaTahananAttribute(): string
    {
        $diff = $this->tanggal_masuk->diff($this->tanggal_keluar);
        return $diff->y . ' Tahun ' . $diff->m . ' Bulan ' . $diff->d . ' Hari';
    }
}