<?php

namespace Database\Seeders;

use App\Models\JadwalKunjungan;
use Illuminate\Database\Seeder;

class JadwalKunjunganSeeder extends Seeder
{
    public function run(): void
    {
        $jadwals = [
            // Senin
            ['hari' => 'Senin',  'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi pagi'],
            ['hari' => 'Senin',  'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi siang'],
            // Selasa
            ['hari' => 'Selasa',  'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi pagi'],
            ['hari' => 'Selasa',  'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi siang'],
            // Rabu
            ['hari' => 'Rabu',   'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi pagi'],
            ['hari' => 'Rabu',   'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi siang'],

             // Kamis
            ['hari' => 'Kamis',   'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi pagi'],
            ['hari' => 'Kamis',   'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kuota' => 50, 'status' => 'aktif',    'keterangan' => 'Sesi siang'],
            // Jumat
            ['hari' => 'Jumat',  'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'kuota' => 40, 'status' => 'aktif',    'keterangan' => 'Sesi pagi'],
            ['hari' => 'Jumat',  'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'kuota' => 40, 'status' => 'nonaktif', 'keterangan' => 'Ditutup sementara'],

        ];

        foreach ($jadwals as $jadwal) {
            JadwalKunjungan::create($jadwal);
        }
    }
}