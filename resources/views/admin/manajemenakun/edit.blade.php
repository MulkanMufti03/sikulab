@extends('admin.sidebar')

@section('title','Edit User')

@section('content')
<div class="section-header">
  <h1>Edit User</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('manajemenakun.index') }}">Manajemen User</a></div>
    <div class="breadcrumb-item">Edit User</div>
  </div>
</div>

<div class="section-body">
  <h2 class="section-title">Formulir Edit User</h2>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Edit Data User: {{ $user->name }}</h4>
        </div>
        <div class="card-body">
          
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

          <form action="{{ route('manajemenakun.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
              <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" 
                     class="form-control @error('name') is-invalid @enderror" 
                     id="name" 
                     name="name" 
                     value="{{ old('name', $user->name) }}" 
                     placeholder="Masukkan nama lengkap"
                     required>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" 
                     class="form-control @error('email') is-invalid @enderror" 
                     id="email" 
                     name="email" 
                     value="{{ old('email', $user->email) }}" 
                     placeholder="Masukkan email"
                     required>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="role">Role <span class="text-danger">*</span></label>
              <select class="form-control @error('role') is-invalid @enderror" 
                      id="role" 
                      name="role" 
                      required>
                <option value="">Pilih Role</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
              </select>
              @error('role')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password">Password Baru</label>
              <div class="input-group">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Kosongkan jika tidak ingin mengubah password">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                    <i class="fas fa-eye" id="password-icon"></i>
                  </button>
                </div>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
            </div>

            <div class="form-group">
              <label for="password_confirmation">Konfirmasi Password Baru</label>
              <div class="input-group">
                <input type="password" 
                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Ulangi password baru">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                  </button>
                </div>
                @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
              </button>
              <a href="{{ route('manajemenakun.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
      field.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      field.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }

  // Auto hide alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);
</script>
@endpush