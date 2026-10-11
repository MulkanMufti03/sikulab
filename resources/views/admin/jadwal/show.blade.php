{{-- resources/views/admin/manajemennapi/show.blade.php --}}
@extends('admin.sidebar')
@section('title', 'Detail Jadwal Kunjungan')

@section('content')
<div class="section-header">
    <h1>Detail Jadwal</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">
            <a href="{{ route('jadwal.index') }}">Jadwal Kunjungan</a>
        </div>
        <div class="breadcrumb-item">Detail</div>
    </div>
</div>

<div class="section-body">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-calendar-day mr-2"></i>Detail Jadwal Kunjungan</h4>
                    <div>
                        <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary btn-sm ml-1">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="200" class="bg-light">ID</th>
                                <td>#{{ $jadwal->id }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Hari Kunjungan</th>
                                <td>
                                    <span class="badge badge-primary badge-pill px-3 py-2">
                                        {{ $jadwal->hari }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Jam Mulai</th>
                                <td>{{ substr($jadwal->jam_mulai, 0, 5) }} WIB</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Jam Selesai</th>
                                <td>{{ substr($jadwal->jam_selesai, 0, 5) }} WIB</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Durasi</th>
                                <td>
                                    @php
                                        $mulai   = \Carbon\Carbon::parse($jadwal->jam_mulai);
                                        $selesai = \Carbon\Carbon::parse($jadwal->jam_selesai);
                                        $durasi  = $mulai->diffInMinutes($selesai);
                                    @endphp
                                    {{ $durasi }} menit
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Kuota Pengunjung</th>
                                <td><strong>{{ number_format($jadwal->kuota) }}</strong> orang</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Status</th>
                                <td>{!! $jadwal->status_badge !!}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Keterangan</th>
                                <td>{{ $jadwal->keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Dibuat Pada</th>
                                <td>{{ $jadwal->created_at->format('d F Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Terakhir Diperbarui</th>
                                <td>{{ $jadwal->updated_at->format('d F Y, H:i') }} WIB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <form action="{{ route('jadwal.destroy', $jadwal) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus jadwal {{ $jadwal->hari }} ini?')">
                            <i class="fas fa-trash mr-1"></i> Hapus Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection