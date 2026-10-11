<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Status Kunjungan</title>
    <style>
        body{font-family:system-ui,sans-serif;background:#f3f4f6;margin:0;padding:24px;color:#111827}
        .card{max-width:560px;margin:0 auto 16px;background:#fff;border-radius:12px;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,.1)}
        input{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:8px;box-sizing:border-box;margin:6px 0 14px;font:inherit}
        button{width:100%;padding:12px;background:#2563eb;color:#fff;border:0;border-radius:8px;cursor:pointer;font-size:1rem}
        .ok{background:#dcfce7;color:#166534;padding:12px;border-radius:8px;margin-bottom:16px}
        .err{color:#b91c1c;font-size:.875rem;margin:-8px 0 12px}
        .badge{display:inline-block;padding:4px 10px;border-radius:999px;font-weight:600;font-size:.85rem}
        .menunggu{background:#fef3c7;color:#92400e}.disetujui{background:#dcfce7;color:#166534}
        .ditolak{background:#fee2e2;color:#991b1b}.selesai{background:#e0e7ff;color:#3730a3}
        .muted{color:#6b7280;font-size:.875rem}
        td{padding:6px 0;vertical-align:top}td:first-child{color:#6b7280;width:38%}
        a{color:#2563eb}
    </style>
</head>
<body>
<div class="card">
    <h1 style="margin-top:0">Cek Status Kunjungan</h1>

    @if (session('success'))
        <div class="ok">
            {{ session('success') }}<br>
            Kode pendaftaran: <b style="font-size:1.25rem">{{ session('kode') }}</b>
        </div>
    @endif

    <form action="{{ route('cekstatus.proses') }}" method="POST">
        @csrf
        <label>Kode Pendaftaran</label>
        <input type="text" name="kode" value="{{ old('kode', session('kode')) }}" required>
        @error('kode')<div class="err">{{ $message }}</div>@enderror

        <label>NIK</label>
        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" required>
        @error('nik')<div class="err">{{ $message }}</div>@enderror

        <button type="submit">Cek Status</button>
    </form>
    <p><a href="{{ route('formpengunjung') }}">&larr; Kembali ke form pendaftaran</a></p>
</div>

@isset($kunjungan)
<div class="card">
    <h2 style="margin-top:0">Hasil Pendaftaran</h2>
    <table width="100%">
        <tr><td>Kode</td><td><b>{{ $kunjungan->kode }}</b></td></tr>
        <tr><td>Status</td><td><span class="badge {{ $kunjungan->status }}">{{ ucfirst($kunjungan->status) }}</span></td></tr>
        <tr><td>Nama</td><td>{{ $kunjungan->nama }}</td></tr>
        <tr><td>Narapidana</td><td>{{ $kunjungan->napidana->nama_lengkap ?? '-' }}</td></tr>
        <tr><td>Hubungan</td><td>{{ $kunjungan->hubungan }}</td></tr>
        <tr><td>Tanggal</td><td>{{ $kunjungan->tanggal_kunjungan->isoFormat('dddd, D MMMM Y') }}</td></tr>
        <tr><td>Jam</td><td>{{ $kunjungan->jadwal->jam_kunjungan }}</td></tr>
        @if ($kunjungan->status === 'ditolak')
            <tr><td>Alasan</td><td>{{ $kunjungan->alasan_penolakan }}</td></tr>
        @endif
    </table>
    @if ($kunjungan->status === 'disetujui')
        <p class="muted">Tunjukkan kode ini dan KTP asli kepada petugas saat datang.</p>
    @endif
</div>
@endisset
</body>
</html>