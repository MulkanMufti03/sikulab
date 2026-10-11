@extends('admin.sidebar')

@section('title','Detail User')

@section('content')
<div class="section-header">
  <h1>Detail User</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('manajemenakun.index') }}">Manajemen User</a></div>
    <div class="breadcrumb-item">Detail User</div>
  </div>
</div>

<div class="section-body">
  <h2 class="section-title">Informasi User</h2>
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header">
          <h4>Data User</h4>
        </div>
        <div class="card-body">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td width="30%"><strong>ID</strong></td>
                <td>: {{ $user->id }}</td>
              </tr>
              <tr>
                <td><strong>Nama Lengkap</strong></td>
                <td>: {{ $user->name }}</td>
              </tr>
              <tr>
                <td><strong>Email</strong></td>
                <td>: {{ $user->email }}</td>
              </tr>
              <tr>
                <td><strong>Role</strong></td>
                <td>: 
                  <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : 'info' }}">
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
              </tr>
              <tr>
                <td><strong>Email Verified</strong></td>
                <td>: 
                  @if($user->email_verified_at)
                    <span class="badge badge-success">Verified</span>
                    <br>
                    <small class="text-muted">{{ $user->email_verified_at->format('d-m-Y H:i:s') }}</small>
                  @else
                    <span class="badge badge-warning">Not Verified</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td><strong>Created At</strong></td>
                <td>: {{ $user->created_at->format('d-m-Y H:i:s') }}</td>
              </tr>
              <tr>
                <td><strong>Updated At</strong></td>
                <td>: {{ $user->updated_at->format('d-m-Y H:i:s') }}</td>
              </tr>
            </tbody>
          </table>

          <div class="mt-3">
            <a href="{{ route('manajemenakun.edit', $user->id) }}" class="btn btn-warning">
              <i class="fas fa-edit"></i> Edit User
            </a>
            <a href="{{ route('manajemenakun.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" 
                    class="btn btn-danger" 
                    onclick="confirmDelete({{ $user->id }})">
              <i class="fas fa-trash"></i> Hapus User
            </button>
            
            <!-- Hidden Delete Form -->
            <form id="delete-form-{{ $user->id }}" 
                  action="{{ route('manajemenakun.destroy', $user->id) }}" 
                  method="POST" 
                  style="display: none;">
              @csrf
              @method('DELETE')
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header">
          <h4>Informasi Tambahan</h4>
        </div>
        <div class="card-body">
          <div class="alert alert-info">
            <h6>Catatan:</h6>
            <ul class="mb-0">
              <li>User dengan role <strong>Admin</strong> memiliki akses penuh ke sistem</li>
              <li>User dengan role <strong>Petugas</strong> memiliki akses terbatas</li>
              <li>Pastikan untuk tidak menghapus akun admin utama</li>
            </ul>
          </div>

          <div class="card">
            <div class="card-body">
              <h6 class="mb-3">Aktivitas Akun</h6>
              <div class="mb-2">
                <small class="text-muted">Terakhir diperbarui:</small><br>
                <strong>{{ $user->updated_at->diffForHumans() }}</strong>
              </div>
              <div>
                <small class="text-muted">Terdaftar sejak:</small><br>
                <strong>{{ $user->created_at->diffForHumans() }}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function confirmDelete(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')) {
      document.getElementById('delete-form-' + userId).submit();
    }
  }
</script>
@endpush