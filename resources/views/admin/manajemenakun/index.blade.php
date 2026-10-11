@extends('admin.sidebar')

@section('title','Dashboard Admin')

@section('content')
<div class="section-header">
  <h1>Manajemen User</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item">Manajemen User</div>
  </div>
</div>          

<div class="section-body">
  <h2 class="section-title">Data Akun Petugas</h2>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Akun Petugas</h4>
        </div>
        <div class="card-body">
          
          <!-- Alert Messages -->
          @if(session('success'))
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>&times;</span>
              </button>
              {{ session('success') }}
            </div>
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>&times;</span>
              </button>
              {{ session('error') }}
            </div>
          </div>
          @endif

          <div class="col-16 col-md-16 col-lg-16 mb-3">
            <div class="buttons">
              <a href="{{ route('manajemenakun.tambah') }}" class="btn btn-icon icon-left btn-primary">
                <i class="fas fa-solid fa-plus"></i> Tambah Pengguna
              </a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>                                 
                <tr>
                  <th class="text-center">No</th>
                  <th>Nama Petugas</th>
                  <th>Email Petugas</th>
                  <th>Role</th>
                  <th>Created At</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $index => $user)
                <tr>
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : 'info' }}">
                      {{ ucfirst($user->role) }}
                    </span>
                  </td>
                  <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                  <td>
                    <a href="{{ route('manajemenakun.lihat', $user->id) }}" 
                       class="btn btn-sm btn-info" 
                       title="Lihat Detail">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('manajemenakun.edit', $user->id) }}" 
                       class="btn btn-sm btn-warning" 
                       title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    
                    <form action="{{ route('manajemenakun.destroy', $user->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                              class="btn btn-sm btn-danger" 
                              title="Hapus">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">Tidak ada data user</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Auto hide alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);

  // Initialize DataTable if available
  $(document).ready(function() {
    if (typeof $.fn.DataTable !== 'undefined') {
      $('#table-1').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
      });
    }
  });
</script>
@endpush