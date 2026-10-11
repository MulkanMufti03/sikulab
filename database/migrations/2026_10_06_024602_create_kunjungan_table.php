<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama dari versi sebelumnya (jika sudah pernah di-migrate)
        Schema::dropIfExists('kunjungan');

        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 12)->unique();

            // jadwal mingguan (hari + jam) milik admin + tanggal pasti kunjungannya
            $table->foreignId('jadwal_id')->constrained('jadwal_kunjungan');
            $table->date('tanggal_kunjungan');

            $table->foreignId('napidana_id')->constrained('napidanas')->cascadeOnDelete();

            $table->string('nama');
            $table->string('nik', 16);
            $table->string('no_hp', 20);
            $table->string('hubungan', 100);
            $table->text('alamat')->nullable();
            $table->string('foto_ktp'); // path di disk private (storage/app/private/ktp)

            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('waktu_masuk')->nullable();
            $table->timestamp('waktu_keluar')->nullable();
            $table->timestamps();

            $table->index(['jadwal_id', 'tanggal_kunjungan']);
            $table->unique(['jadwal_id', 'tanggal_kunjungan', 'nik']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};