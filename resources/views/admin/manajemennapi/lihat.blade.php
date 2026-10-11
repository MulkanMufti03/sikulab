{{-- resources/views/admin/manajemennapi/show.blade.php --}}
@extends('admin.sidebar')
@section('title', 'Detail Narapidana')

@section('content')
<div class="section-header">
    <h1>Detail Narapidana</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('manajemennapi.index') }}">Manajemen Napi</a>
        </div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Data Narapidana</h4>
                    <div>
                        <a href="{{ route('manajemennapi.edit', $napi->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('manajemennapi.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200" class="bg-light">No. Registrasi</th>
                            <td><code>{{ $napi->no_registrasi }}</code></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nama Lengkap</th>
                            <td>{{ $napi->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal Lahir</th>
                            <td>{{ $napi->tanggal_lahir->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Jenis Kelamin</th>
                            <td>{{ $napi->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kasus</th>
                            <td>{{ $napi->kasus }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal Masuk</th>
                            <td>{{ $napi->tanggal_masuk->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal Bebas</th>
                            <td>{{ $napi->tanggal_keluar->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Total Masa Tahanan</th>
                            <td>{{ $napi->masa_tahanan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Sisa Masa Tahanan</th>
                            <td><span class="badge badge-info">{{ $napi->sisa_masa_tahanan }}</span></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status</th>
                            <td>
                                @php
                                    $badge = match($napi->status) {
                                        'Aktif'     => 'badge-success',
                                        'Bebas'     => 'badge-secondary',
                                        'Meninggal' => 'badge-dark',
                                        default     => 'badge-light',
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ $napi->status }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Asal Daerah</th>
                            <td>{{ $napi->asal_daerah }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Keterangan</th>
                            <td>{{ $napi->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
