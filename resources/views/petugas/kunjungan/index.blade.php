@extends('petugas.sidebar')
@section('title', 'Konfirmasi Kunjungan')

@section('content')
<div class="section-header">
    <h1>Konfirmasi Kunjungan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Konfirmasi Kunjungan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Pendaftaran Kunjungan</h2>
    <p class="section-lead">Periksa data dan foto KTP pengunjung, lalu setujui atau tolak pendaftaran.</p>

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
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Pendaftaran Pengunjung</h4>
                </div>

                <div class="card-body">
                    {{-- Tab status --}}
                    <ul class="nav nav-pills mb-3">
                        @foreach(['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'selesai' => 'Selesai', 'semua' => 'Semua'] as $key => $label)
                            <li class="nav-item">
                                <a class="nav-link {{ $status === $key ? 'active' : '' }}"
                                   href="{{ route('petugas.kunjungan.index', ['status' => $key]) }}">
                                    {{ $label }}
                                    @if($key === 'menunggu' && $jumlahMenunggu > 0)
                                        <span class="badge badge-danger">{{ $jumlahMenunggu }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Filter & Search --}}
                    <form method="GET" action="{{ route('petugas.kunjungan.index') }}" class="mb-3">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control"
                                           placeholder="Cari nama, kode, atau NIK..."
                                           value="{{ request('q') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal" class="form-control"
                                       value="{{ request('tanggal') }}" onchange="this.form.submit()">
                            </div>
                            @if(request('q') || request('tanggal'))
                                <div class="col-md-2">
                                    <a href="{{ route('petugas.kunjungan.index', ['status' => $status]) }}" class="btn btn-secondary btn-block">
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
                                    <th>Kode</th>
                                    <th>Pengunjung</th>
                                    <th>Narapidana</th>
                                    <th>Jadwal Kunjungan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="130">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kunjungan as $index => $k)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($kunjungan->currentPage() - 1) * $kunjungan->perPage() + $index + 1 }}
                                        </td>
                                        <td>
                                            <code>{{ $k->kode }}</code><br>
                                            <small class="text-muted">{{ $k->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            {{ $k->nama }}<br>
                                            <small class="text-muted">{{ $k->hubungan }} &middot; {{ $k->no_hp }}</small>
                                        </td>
                                        <td>{{ $k->napidana->nama_lengkap ?? '-' }}</td>
                                        <td>
                                            {{ $k->tanggal_kunjungan->isoFormat('ddd, D MMM Y') }}<br>
                                            <small class="text-muted">{{ $k->jadwal->jam_kunjungan }}</small>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badge = match($k->status) {
                                                    'menunggu'  => 'badge-warning',
                                                    'disetujui' => 'badge-success',
                                                    'ditolak'   => 'badge-danger',
                                                    'selesai'   => 'badge-info',
                                                    default     => 'badge-light',
                                                };
                                            @endphp
                                            <span class="badge {{ $badge }}">{{ ucfirst($k->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('petugas.kunjungan.show', $k->id) }}"
                                               class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($k->status === 'menunggu')
                                                <form action="{{ route('petugas.kunjungan.setujui', $k->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Setujui pendaftaran {{ $k->kode }}?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Tidak ada data pendaftaran ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $kunjungan->firstItem() ?? 0 }} - {{ $kunjungan->lastItem() ?? 0 }}
                            dari {{ $kunjungan->total() }} data
                        </small>
                        {{ $kunjungan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection