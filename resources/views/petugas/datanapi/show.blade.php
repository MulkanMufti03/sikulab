@extends('petugas.sidebar')
@section('title', 'Detail Narapidana')

@section('content')
<div class="section-header">
    <h1>Detail Narapidana</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('datanapi.index') }}">Data Narapidana</a>
        </div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>

<div class="section-body">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ $napi->nama_lengkap }}
                    </h4>
                    @php
                        $badge = match($napi->status) {
                            'Aktif'     => 'badge-success',
                            'Bebas'     => 'badge-secondary',
                            'Meninggal' => 'badge-dark',
                            default     => 'badge-light',
                        };
                    @endphp
                    <span class="badge {{ $badge }} badge-lg" style="font-size: 0.9rem;">
                        {{ $napi->status }}
                    </span>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <th width="35%" class="bg-light">No. Registrasi</th>
                                <td><code>{{ $napi->no_registrasi }}</code></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Nama Lengkap</th>
                                <td>{{ $napi->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Kasus</th>
                                <td>{{ $napi->kasus }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Masa Tahanan</th>
                                <td>{{ $napi->masa_tahanan }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Sisa Masa Tahanan</th>
                                <td>
                                    <span class="badge badge-info">{{ $napi->sisa_masa_tahanan }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Asal Daerah</th>
                                <td>{{ $napi->asal_daerah }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Status</th>
                                <td>
                                    <span class="badge {{ $badge }}">{{ $napi->status }}</span>
                                </td>
                            </tr>
                            {{-- Tambahkan kolom lain sesuai kolom di tabel napidanas Anda --}}
                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('datanapi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    {{-- Tidak ada tombol Edit / Hapus untuk petugas --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection