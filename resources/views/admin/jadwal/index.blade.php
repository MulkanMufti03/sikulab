{{-- resources/views/admin/manajemennapi/index.blade.php --}}
@extends('admin.sidebar')
@section('title', 'Manajemen Jadwal Kunjungan')

@section('content')
<div class="section-header">
    <h1>Manajemen Jadwal</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Jadwal Kunjungan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Manajemen Jadwal Kunjungan</h2>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-calendar-alt mr-2"></i>Jadwal Kunjungan</h4>
                    <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-icon icon-left">
                        <i class="fas fa-plus"></i> Tambah Jadwal Baru
                    </a>
                </div>

                <div class="card-body">

                    {{-- Filter & Search --}}
                    <form method="GET" action="{{ route('jadwal.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <select name="hari" class="form-control form-control-sm">
                                    <option value="">-- Semua Hari --</option>
                                    @foreach($hariOptions as $hari)
                                        <option value="{{ $hari }}" {{ request('hari') == $hari ? 'selected' : '' }}>
                                            {{ $hari }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">-- Semua Status --</option>
                                    <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="text" name="search" class="form-control form-control-sm"
                                       placeholder="Cari keterangan..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 mb-2 d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-info mr-1">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th>Hari Kunjungan</th>
                                    <th>Jam Kunjungan</th>
                                    <th class="text-center">Kuota</th>
                                    <th class="text-center">Status</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" width="180">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwals as $i => $jadwal)
                                    <tr>
                                        <td class="text-center">{{ $jadwals->firstItem() + $i }}</td>
                                        <td>
                                            <span class="badge badge-primary badge-pill px-3 py-2">
                                                {{ $jadwal->hari }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="fas fa-clock text-muted mr-1"></i>
                                            {{ $jadwal->jam_kunjungan }}
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ number_format($jadwal->kuota) }}</strong>
                                            <small class="text-muted">orang</small>
                                        </td>
                                        <td class="text-center">
                                            {!! $jadwal->status_badge !!}
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $jadwal->keterangan ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{-- Toggle Status --}}
                                            <form action="{{ route('jadwal.toggleStatus', $jadwal) }}"
                                                  method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $jadwal->status === 'aktif' ? 'btn-warning' : 'btn-success' }}"
                                                    title="{{ $jadwal->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                    onclick="return confirm('Ubah status jadwal ini?')">
                                                    <i class="fas {{ $jadwal->status === 'aktif' ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                </button>
                                            </form>

                                            {{-- Edit --}}
                                            <a href="{{ route('jadwal.edit', $jadwal) }}"
                                               class="btn btn-sm btn-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('jadwal.destroy', $jadwal) }}"
                                                  method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus jadwal {{ $jadwal->hari }} ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                            Belum ada data jadwal kunjungan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $jadwals->firstItem() ?? 0 }} -
                            {{ $jadwals->lastItem() ?? 0 }} dari
                            {{ $jadwals->total() }} data
                        </small>
                        {{ $jadwals->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection