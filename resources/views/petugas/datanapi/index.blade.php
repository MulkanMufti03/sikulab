@extends('petugas.sidebar')
@section('title', 'Data Narapidana')

@section('content')
<div class="section-header">
    <h1>Data Narapidana</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Data Narapidana</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Daftar Narapidana</h2>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Para Narapidana</h4>
                    {{-- Tidak ada tombol Tambah karena petugas hanya bisa melihat --}}
                </div>

                <div class="card-body">
                    {{-- Filter & Search --}}
                    <form method="GET" action="{{ route('datanapi.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Cari nama, registrasi, kasus..."
                                           value="{{ $search ?? '' }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Semua Status --</option>
                                    <option value="Aktif"     {{ ($status ?? '') == 'Aktif'     ? 'selected' : '' }}>Aktif</option>
                                    <option value="Bebas"     {{ ($status ?? '') == 'Bebas'     ? 'selected' : '' }}>Bebas</option>
                                    <option value="Meninggal" {{ ($status ?? '') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                                </select>
                            </div>
                            @if($search || $status)
                                <div class="col-md-2">
                                    <a href="{{ route('datanapi.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th>No. Registrasi</th>
                                    <th>Nama Napi</th>
                                    <th>Kasus</th>
                                    <th>Masa Tahanan</th>
                                    <th class="text-center">Status</th>
                                    <th>Asal Daerah</th>
                                    <th class="text-center" width="80">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($napidanas as $index => $napi)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($napidanas->currentPage() - 1) * $napidanas->perPage() + $index + 1 }}
                                        </td>
                                        <td><code>{{ $napi->no_registrasi }}</code></td>
                                        <td>{{ $napi->nama_lengkap }}</td>
                                        <td>{{ $napi->kasus }}</td>
                                        <td>
                                            <small class="text-muted">{{ $napi->masa_tahanan }}</small><br>
                                            <span class="badge badge-info">Sisa: {{ $napi->sisa_masa_tahanan }}</span>
                                        </td>
                                        <td class="text-center">
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
                                        <td>{{ $napi->asal_daerah }}</td>
                                        <td class="text-center">
                                            {{-- Hanya tombol lihat detail, tanpa edit & hapus --}}
                                            <a href="{{ route('datanapi.show', $napi->id) }}"
                                               class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Tidak ada data narapidana ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $napidanas->firstItem() ?? 0 }} - {{ $napidanas->lastItem() ?? 0 }}
                            dari {{ $napidanas->total() }} data
                        </small>
                        {{ $napidanas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection