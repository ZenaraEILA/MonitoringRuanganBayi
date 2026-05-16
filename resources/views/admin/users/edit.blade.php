@extends('layouts.main')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">
                <i class="fas fa-user-edit"></i> Edit Profil User
            </h1>
            <p class="text-muted">Ubah informasi akun '{{ $user->username }}' secara langsung</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> Terdapat kesalahan pada input Anda:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Pembaruan Akun</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="hospital_id" class="form-label">NISN / ID Pegawai</label>
                                <input type="text" class="form-control" id="hospital_id" name="hospital_id" value="{{ old('hospital_id', $user->hospital_id) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role Akses <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-select" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas (Standar)</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Penuh)</option>
                            </select>
                            @if($user->id === auth()->id())
                                <input type="hidden" name="role" value="{{ $user->role }}">
                                <div class="form-text text-warning">Anda tidak dapat mengubah role akun Anda sendiri.</div>
                            @endif
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3 text-primary"><i class="fas fa-info-circle"></i> Pengaturan "Tentang Kami" (Tim Pengembang)</h6>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch p-0" style="padding-left: 2.5rem !important;">
                                <input class="form-check-input" type="checkbox" id="is_on_about_page" name="is_on_about_page" value="1" {{ old('is_on_about_page', $user->is_on_about_page) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_on_about_page">Pin ke Halaman Tentang Kami</label>
                                <div class="form-text">Jika aktif, profil user ini akan muncul di daftar tim pengembang.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="job_title" class="form-label">Jabatan / Peran di Tim</label>
                            <input type="text" class="form-control" id="job_title" name="job_title" value="{{ old('job_title', $user->job_title) }}" placeholder="Contoh: Full Stack Developer">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $user->dob) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-select">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3"><i class="fas fa-lock"></i> Ubah Password (Kosongkan jika tidak ingin diganti)</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8">
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8">
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mt-4">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Perhatian:</strong> Perubahan pada Username atau Password akan langsung berlaku. Pastikan user yang bersangkutan diberitahu.
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Status Akun</h5>
                </div>
                <div class="card-body">
                    <p>Status: 
                        @if($user->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </p>
                    <p>Dibuat: <strong>{{ $user->created_at->format('d M Y') }}</strong></p>
                    <p>Login Terakhir: <strong>{{ $user->getLastLoginInfo() }}</strong></p>
                </div>
            </div>
            
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-key"></i> Code Keamanan</h5>
                </div>
                <div class="card-body text-center">
                    <p class="small text-muted mb-2">Code Darurat saat ini:</p>
                    <h4 class="mb-3"><code>{{ $user->security_code }}</code></h4>
                    <form action="{{ route('admin.users.refreshCode', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-sync-alt"></i> Generate Code Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
