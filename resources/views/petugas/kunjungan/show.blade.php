@extends('petugas.sidebar')
@section('title', 'Detail Kunjungan')

@section('content')
<div class="section-header">
    <h1>Detail Kunjungan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('petugas.kunjungan.index') }}">Konfirmasi Kunjungan</a>
        </div>
        <div class="breadcrumb-item">{{ $kunjungan->kode }}</div>
    </div>
</div>

@php
    $badge = match($kunjungan->status) {
        'menunggu'  => 'badge-warning',
        'disetujui' => 'badge-success',
        'ditolak'   => 'badge-danger',
        'selesai'   => 'badge-info',
        default     => 'badge-light',
    };
@endphp

<div class="section-body">

    {{-- Notifikasi (hapus bagian ini jika layout petugas.sidebar sudah menampilkan flash message) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="row">
        {{-- Data pengunjung --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Pendaftaran <code>{{ $kunjungan->kode }}</code></h4>
                    <span class="badge {{ $badge }}">{{ ucfirst($kunjungan->status) }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr><th width="35%">Nama</th><td>{{ $kunjungan->nama }}</td></tr>
                        <tr><th>NIK</th><td>{{ $kunjungan->nik }}</td></tr>
                        <tr><th>No. HP</th><td>{{ $kunjungan->no_hp }}</td></tr>
                        <tr><th>Hubungan</th><td>{{ $kunjungan->hubungan }}</td></tr>
                        <tr><th>Alamat</th><td>{{ $kunjungan->alamat ?: '-' }}</td></tr>
                        <tr>
                            <th>Narapidana</th>
                            <td>
                                {{ $kunjungan->napidana->nama_lengkap ?? '-' }}
                                <small class="text-muted">({{ $kunjungan->napidana->no_registrasi ?? '-' }})</small>
                            </td>
                        </tr>
                        <tr><th>Tanggal</th><td>{{ $kunjungan->tanggal_kunjungan->isoFormat('dddd, D MMMM Y') }}</td></tr>
                        <tr><th>Jam</th><td>{{ $kunjungan->jadwal->jam_kunjungan }}</td></tr>
                        <tr><th>Mendaftar</th><td>{{ $kunjungan->created_at->format('d/m/Y H:i') }}</td></tr>
                        @if($kunjungan->status === 'ditolak')
                            <tr><th>Alasan Ditolak</th><td class="text-danger">{{ $kunjungan->alasan_penolakan }}</td></tr>
                        @endif
                        @if($kunjungan->waktu_masuk)
                            <tr><th>Waktu Masuk</th><td>{{ $kunjungan->waktu_masuk->format('d/m/Y H:i') }}</td></tr>
                        @endif
                        @if($kunjungan->waktu_keluar)
                            <tr><th>Waktu Keluar</th><td>{{ $kunjungan->waktu_keluar->format('d/m/Y H:i') }}</td></tr>
                        @endif
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('petugas.kunjungan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- Foto KTP --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header"><h4>Foto KTP</h4></div>
                <div class="card-body">
                    <a href="{{ route('kunjungan.ktp', $kunjungan->id) }}" target="_blank">
                        <img src="{{ route('kunjungan.ktp', $kunjungan->id) }}"
                             alt="KTP {{ $kunjungan->nama }}" class="img-fluid rounded border">
                    </a>
                    <small class="text-muted d-block mt-2">
                        Klik gambar untuk memperbesar. Cocokkan nama dan NIK dengan data pendaftaran.
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- Konfirmasi (status menunggu) --}}
    @if($kunjungan->status === 'menunggu')
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header"><h4>Konfirmasi Pendaftaran</h4></div>
                    <div class="card-body">
                        <form action="{{ route('petugas.kunjungan.setujui', $kunjungan->id) }}" method="POST"
                              onsubmit="return confirm('Setujui pendaftaran ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Setujui Pendaftaran
                            </button>
                        </form>

                        <hr>

                        <form action="{{ route('petugas.kunjungan.tolak', $kunjungan->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="alasan_penolakan">Atau tolak dengan alasan</label>
                                <textarea name="alasan_penolakan" id="alasan_penolakan" rows="3"
                                          class="form-control @error('alasan_penolakan') is-invalid @enderror"
                                          style="height:auto"
                                          placeholder="Contoh: Foto KTP tidak jelas / NIK tidak sesuai" required>{{ old('alasan_penolakan') }}</textarea>
                                @error('alasan_penolakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times"></i> Tolak Pendaftaran
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Check-in / check-out (status disetujui) --}}
    @if($kunjungan->status === 'disetujui')
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header"><h4>Kunjungan Hari-H</h4></div>
                    <div class="card-body">
                        @if(! $kunjungan->waktu_masuk)
                            <form action="{{ route('petugas.kunjungan.masuk', $kunjungan->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary"
                                        {{ $kunjungan->tanggal_kunjungan->isToday() ? '' : 'disabled' }}>
                                    <i class="fas fa-sign-in-alt"></i> Check-in (Masuk)
                                </button>
                                @unless($kunjungan->tanggal_kunjungan->isToday())
                                    <small class="text-muted ml-2">Hanya bisa dilakukan pada tanggal kunjungan.</small>
                                @endunless
                            </form>
                        @else
                            <form action="{{ route('petugas.kunjungan.keluar', $kunjungan->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-sign-out-alt"></i> Check-out (Keluar)
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection