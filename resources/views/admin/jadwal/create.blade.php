{{-- resources/views/admin/manajemennapi/create.blade.php --}}
@extends('admin.sidebar')
@section('title', 'Tambah Jadwal Kunjungan')

@section('content')
<div class="section-header">
    <h1>Tambah Jadwal</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('jadwal.index') }}">Jadwal Kunjungan</a>
        </div>
        <div class="breadcrumb-item">Tambah</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus-circle mr-2"></i>Form Tambah Jadwal Kunjungan</h4>
                </div>
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf

                        {{-- Hari --}}
                        <div class="form-group">
                            <label for="hari">Hari Kunjungan <span class="text-danger">*</span></label>
                            <select name="hari" id="hari"
                                class="form-control @error('hari') is-invalid @enderror">
                                <option value="">-- Pilih Hari --</option>
                                @foreach($hariOptions as $hari)
                                    <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jam Mulai & Selesai --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" id="jam_mulai"
                                        class="form-control @error('jam_mulai') is-invalid @enderror"
                                        value="{{ old('jam_mulai') }}">
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_selesai" id="jam_selesai"
                                        class="form-control @error('jam_selesai') is-invalid @enderror"
                                        value="{{ old('jam_selesai') }}">
                                    @error('jam_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Kuota --}}
                        <div class="form-group">
                            <label for="kuota">Kuota Pengunjung <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="kuota" id="kuota" min="1" max="9999"
                                    class="form-control @error('kuota') is-invalid @enderror"
                                    value="{{ old('kuota', 50) }}" placeholder="Contoh: 50">
                                <div class="input-group-append">
                                    <span class="input-group-text">orang</span>
                                </div>
                                @error('kuota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Jumlah maksimal pengunjung untuk sesi ini.</small>
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                           id="status_aktif" value="aktif"
                                           {{ old('status', 'aktif') === 'aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_aktif">
                                        <span class="badge badge-success">Aktif</span>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                           id="status_nonaktif" value="nonaktif"
                                           {{ old('status') === 'nonaktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_nonaktif">
                                        <span class="badge badge-danger">Non-Aktif</span>
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label for="keterangan">Keterangan <span class="text-muted">(opsional)</span></label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Contoh: Sesi pagi untuk keluarga inti"
                                maxlength="500">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maksimal 500 karakter.</small>
                        </div>

                        {{-- Tombol --}}
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Jadwal
                            </button>
                            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection