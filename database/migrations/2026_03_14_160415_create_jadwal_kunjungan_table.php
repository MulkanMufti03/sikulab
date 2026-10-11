<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', [
                'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
            ]);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('kuota')->default(0)->comment('Maksimal jumlah pengunjung');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kunjungan');
    }
};