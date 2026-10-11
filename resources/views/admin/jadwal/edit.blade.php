{{-- resources/views/admin/manajemennapi/edit.blade.php --}}
@extends('admin.sidebar')
@section('title', 'Edit Jadwal Kunjungan')

@section('content')
<div class="section-header">
    <h1>Edit Jadwal</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('jadwal.index') }}">Jadwal Kunjungan</a>
        </div>
        <div class="breadcrumb-item">Edit</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-edit mr-2"></i>Form Edit Jadwal Kunjungan</h4>
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

                    <form action="{{ route('jadwal.update', $jadwal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Hari --}}
                        <div class="form-group">
                            <label for="hari">Hari Kunjungan <span class="text-danger">*</span></label>
                            <select name="hari" id="hari"
                                class="form-control @error('hari') is-invalid @enderror">
                                <option value="">-- Pilih Hari --</option>
                                @foreach($hariOptions as $hari)
                                    <option value="{{ $hari }}"
                                        {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
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
                                        value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}">
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
                                        value="{{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) }}">
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
                                    value="{{ old('kuota', $jadwal->kuota) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">orang</span>
                                </div>
                                @error('kuota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                           id="status_aktif" value="aktif"
                                           {{ old('status', $jadwal->status) === 'aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_aktif">
                                        <span class="badge badge-success">Aktif</span>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                           id="status_nonaktif" value="nonaktif"
                                           {{ old('status', $jadwal->status) === 'nonaktif' ? 'checked' : '' }}>
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
                                maxlength="500"
                                placeholder="Contoh: Sesi pagi untuk keluarga inti">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Perbarui Jadwal
                            </button>
                            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card card-info">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle mr-2"></i>Info Jadwal</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted">ID</td>
                            <td><strong>#{{ $jadwal->id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ $jadwal->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Diperbarui</td>
                            <td>{{ $jadwal->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status Saat Ini</td>
                            <td>{!! $jadwal->status_badge !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection