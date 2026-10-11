<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UtamaController;
use App\Http\Controllers\KtpController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NapiController;
use App\Http\Controllers\Admin\JadwalKunjunganController;

use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\PetugasNapiController;
use App\Http\Controllers\Petugas\PetugasKunjunganController;

// =======================
// Halaman Utama (public)
// =======================
Route::get('/', [UtamaController::class, 'utama'])->name('halamanutama');

Route::get('/formpengunjung', [UtamaController::class, 'formpengunjung'])->name('formpengunjung');
Route::post('/formpengunjung', [UtamaController::class, 'simpanPengunjung'])
    ->middleware('throttle:5,1')
    ->name('formpengunjung.store');

Route::get('/cek-status', [UtamaController::class, 'cekStatus'])->name('cekstatus');
Route::post('/cek-status', [UtamaController::class, 'prosesCekStatus'])
    ->middleware('throttle:10,1')
    ->name('cekstatus.proses');

// =======================
// Guest (belum login)
// =======================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// =======================
// Auth (sudah login)
// =======================
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('petugas.dashboard');
    })->name('dashboard');

    // Foto KTP (private) - bisa dilihat admin & petugas
    Route::get('/kunjungan/{id}/ktp', KtpController::class)->name('kunjungan.ktp');
});

// =======================
// Admin
// =======================
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('manajemenakun')->name('manajemenakun.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/tambah', [UserController::class, 'create'])->name('tambah');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [UserController::class, 'show'])->name('lihat');
    });

    Route::prefix('manajemennapi')->name('manajemennapi.')->group(function () {
        Route::get('/', [NapiController::class, 'index'])->name('index');
        Route::get('/tambah', [NapiController::class, 'tambah'])->name('tambah');
        Route::post('/store', [NapiController::class, 'store'])->name('store');
        Route::get('/{id}', [NapiController::class, 'show'])->name('lihat');
        Route::get('/{id}/edit', [NapiController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [NapiController::class, 'update'])->name('update');
        Route::delete('/{id}', [NapiController::class, 'destroy'])->name('destroy');
    });

    // Jadwal kunjungan (route khusus SEBELUM resource)
    Route::patch('jadwal/{jadwal}/toggle-status', [JadwalKunjunganController::class, 'toggleStatus'])
        ->name('jadwal.toggleStatus');
    Route::resource('jadwal', JadwalKunjunganController::class);
});

// =======================
// Petugas
// =======================
Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');

    Route::get('/narapidana', [PetugasNapiController::class, 'index'])->name('datanapi.index');
    Route::get('/narapidana/{id}', [PetugasNapiController::class, 'show'])->name('datanapi.show');

    Route::prefix('petugas/kunjungan')->name('petugas.kunjungan.')->group(function () {
        Route::get('/', [PetugasKunjunganController::class, 'index'])->name('index');
        Route::get('/{id}', [PetugasKunjunganController::class, 'show'])->name('show');
        Route::patch('/{id}/setujui', [PetugasKunjunganController::class, 'setujui'])->name('setujui');
        Route::patch('/{id}/tolak', [PetugasKunjunganController::class, 'tolak'])->name('tolak');
        Route::patch('/{id}/masuk', [PetugasKunjunganController::class, 'checkIn'])->name('masuk');
        Route::patch('/{id}/keluar', [PetugasKunjunganController::class, 'checkOut'])->name('keluar');
    });
});