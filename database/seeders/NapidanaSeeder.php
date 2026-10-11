<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Napidana;

class NapidanaSeeder extends Seeder
{
    public function run(): void
    {
        Napidana::create([
            'no_registrasi' => 'TRN001',
            'nama_lengkap' => 'Ahmad Hidayat',
            'tanggal_lahir' => '1990-05-12',
            'jenis_kelamin' => 'Laki-laki',
            'kasus' => 'Pencurian kendaraan bermotor di Kota Ternate',
            'tanggal_masuk' => '2024-01-10',
            'tanggal_keluar' => '2026-01-10',
            'status' => 'Aktif',
            'asal_daerah' => 'Ternate',
            'keterangan' => 'Kasus terjadi di Kecamatan Ternate Tengah'
        ]);

        Napidana::create([
            'no_registrasi' => 'TRN002',
            'nama_lengkap' => 'Siti Rahma',
            'tanggal_lahir' => '1995-08-20',
            'jenis_kelamin' => 'Perempuan',
            'kasus' => 'Penggelapan dana UMKM di Kota Ternate',
            'tanggal_masuk' => '2023-06-15',
            'tanggal_keluar' => '2025-06-15',
            'status' => 'Aktif',
            'asal_daerah' => 'Ternate',
            'keterangan' => 'Kasus terjadi di Kecamatan Ternate Selatan'
        ]);

        Napidana::create([
            'no_registrasi' => 'TRN003',
            'nama_lengkap' => 'Rizal Kurniawan',
            'tanggal_lahir' => '1988-11-02',
            'jenis_kelamin' => 'Laki-laki',
            'kasus' => 'Narkotika golongan I di Kota Ternate',
            'tanggal_masuk' => '2022-03-01',
            'tanggal_keluar' => '2027-03-01',
            'status' => 'Aktif',
            'asal_daerah' => 'Ternate',
            'keterangan' => 'Diamankan di Pelabuhan Ahmad Yani Ternate'
        ]);
    }
}
