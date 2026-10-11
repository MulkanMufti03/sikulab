{{-- resources/views/admin/manajemennapi/edit.blade.php --}}
@extends('admin.sidebar')
@section('title', 'Edit Narapidana')

@section('content')
<div class="section-header">
    <h1>Edit Narapidana</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('manajemennapi.index') }}">Manajemen Napi</a>
        </div>
        <div class="breadcrumb-item">Edit Tahanan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Formulir Edit Data Tahanan</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Data: {{ $napi->nama_lengkap }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('manajemennapi.update', $napi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap"
                                           class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           value="{{ old('nama_lengkap', $napi->nama_lengkap) }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Registrasi <span class="text-danger">*</span></label>
                                    <input type="text" name="no_registrasi"
                                           class="form-control @error('no_registrasi') is-invalid @enderror"
                                           value="{{ old('no_registrasi', $napi->no_registrasi) }}" required>
                                    @error('no_registrasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir"
                                           class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                           value="{{ old('tanggal_lahir', $napi->tanggal_lahir->format('Y-m-d')) }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin"
                                            class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="Laki-laki"  {{ old('jenis_kelamin', $napi->jenis_kelamin) == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan"  {{ old('jenis_kelamin', $napi->jenis_kelamin) == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kasus <span class="text-danger">*</span></label>
                            <input type="text" name="kasus"
                                   class="form-control @error('kasus') is-invalid @enderror"
                                   value="{{ old('kasus', $napi->kasus) }}" required>
                            @error('kasus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_masuk"
                                           class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                           value="{{ old('tanggal_masuk', $napi->tanggal_masuk->format('Y-m-d')) }}" required>
                                    @error('tanggal_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Keluar / Bebas <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_keluar"
                                           class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                           value="{{ old('tanggal_keluar', $napi->tanggal_keluar->format('Y-m-d')) }}" required>
                                    @error('tanggal_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                        @foreach(['Aktif','Bebas','Meninggal'] as $s)
                                            <option value="{{ $s }}"
                                                {{ old('status', $napi->status) == $s ? 'selected' : '' }}>
                                                {{ $s }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Asal Daerah <span class="text-danger">*</span></label>
                                    <input type="text" name="asal_daerah"
                                           class="form-control @error('asal_daerah') is-invalid @enderror"
                                           value="{{ old('asal_daerah', $napi->asal_daerah) }}" required>
                                    @error('asal_daerah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $napi->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <a href="{{ route('manajemennapi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection