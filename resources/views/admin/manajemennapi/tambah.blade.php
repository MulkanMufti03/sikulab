{{-- resources/views/admin/manajemennapi/tambah.blade.php --}}
@extends('admin.sidebar')
@section('title', 'Tambah Narapidana')

@section('content')
<div class="section-header">
    <h1>Tambah Narapidana</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('manajemennapi.index') }}">Manajemen Napi</a>
        </div>
        <div class="breadcrumb-item">Tambah Tahanan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Formulir Tambah Tahanan</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Tahanan Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('manajemennapi.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap"
                                           class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           placeholder="Masukkan nama lengkap"
                                           value="{{ old('nama_lengkap') }}" required>
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
                                           placeholder="Contoh: LP-2024-001"
                                           value="{{ old('no_registrasi') }}" required>
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
                                           value="{{ old('tanggal_lahir') }}" required>
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
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki"  {{ old('jenis_kelamin') == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan"  {{ old('jenis_kelamin') == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
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
                                   placeholder="Contoh: Narkotika Pasal 112"
                                   value="{{ old('kasus') }}" required>
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
                                           value="{{ old('tanggal_masuk') }}" required>
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
                                           value="{{ old('tanggal_keluar') }}" required>
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
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Aktif"     {{ old('status') == 'Aktif'     ? 'selected' : '' }}>Aktif</option>
                                        <option value="Bebas"     {{ old('status') == 'Bebas'     ? 'selected' : '' }}>Bebas</option>
                                        <option value="Meninggal" {{ old('status') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
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
                                           placeholder="Contoh: Ternate Selatan"
                                           value="{{ old('asal_daerah') }}" required>
                                    @error('asal_daerah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <a href="{{ route('manajemennapi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection