{{-- Detail user dengan form ubah role
File: resources/views/admin/users/show.blade.php
GET /admin/users/{id}
--}}

@extends('layouts.main')

@section('content')
<div class="container-fluid p-3 p-md-4">
    <!-- Header -->
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="overflow-hidden">
                    <h1 class="h3 h2-md mb-0">Detail User</h1>
                    <p class="text-muted mb-0 text-truncate">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-exclamation-circle me-2"></i> 
                <strong>Terjadi kesalahan:</strong>
            </div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- User Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-1"></i> Informasi User
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Nama</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            <p class="mb-0 text-break"><strong>{{ $user->name }}</strong></p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Email</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            <p class="mb-0 text-break"><code>{{ $user->email }}</code></p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Username</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            <p class="mb-0 text-break"><strong>{{ $user->username ?? '-' }}</strong></p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">NISN / ID Pegawai</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            <p class="mb-0 text-break"><strong>{{ $user->hospital_id ?? '-' }}</strong></p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Role</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">
                                    <i class="fas fa-crown"></i> Admin
                                </span>
                            @elseif($user->role === 'petugas')
                                <span class="badge bg-secondary">
                                    <i class="fas fa-user"></i> Petugas
                                </span>
                            @else
                                <span class="badge bg-info">
                                    <i class="fas fa-eye"></i> Publik
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Status</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            @if($user->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle"></i> Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Email Verified</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            @if($user->email_verified_at)
                                <span class="badge bg-success">
                                    {{ $user->email_verified_at->format('d M Y H:i') }}
                                </span>
                            @else
                                <span class="badge bg-warning">Belum Verifikasi</span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Login Terakhir</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            <p class="mb-0 text-muted small text-break">
                                {{ $user->getLastLoginInfo() }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row mb-3">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Dibuat Pada</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            <p class="mb-0 text-dark fw-bold small">
                                {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                            <p class="mb-0 text-muted small">
                                Pukul {{ $user->created_at->format('H:i:s') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row">
                        <div class="col-sm-5 col-md-4">
                            <label class="form-label text-muted small mb-1 mb-sm-0">Didaftarkan Oleh</label>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            <p class="mb-0 text-muted small">
                                <span class="badge bg-secondary"><i class="fas fa-user-shield me-1"></i> Administrator / Sistem</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Management -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-edit text-primary me-1"></i> Manajemen Role
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    @if($canChangeRole)
                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex-grow-1 d-flex flex-column">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">
                                    <strong>Role Saat Ini</strong>
                                </label>
                                <div class="alert alert-light border mb-0">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-crown"></i> Admin
                                        </span>
                                    @elseif($user->role === 'petugas')
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-user"></i> Petugas
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="fas fa-eye"></i> Publik
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label">
                                    <strong>Ubah Role Menjadi</strong>
                                </label>
                                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">-- Pilih Role Baru --</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="public" {{ $user->role === 'public' ? 'selected' : '' }}>Publik (Hanya Lihat)</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="alert alert-info small mt-auto">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Catatan:</strong> Perubahan role akan dicatat dalam log sistem untuk audit trail.
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning border-warning h-100 d-flex flex-column justify-content-center">
                            <div>
                                <i class="fas fa-shield-alt fs-4 mb-3"></i>
                                <h6 class="fw-bold">Proteksi Keamanan</h6>
                                <p class="small mb-2">Anda tidak dapat mengubah role akun Anda sendiri untuk alasan keamanan.</p>
                                <p class="small mb-0 text-muted">Jika Anda perlu meng-upgrade user lain menjadi admin, gunakan form di atas pada akun user tersebut.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Management Row -->
    <div class="row">
        <!-- User Status Management -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-toggle-on text-primary me-1"></i> Status User
                    </h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    @if($user->is_active)
                        <div class="mb-4 mt-3">
                            <div class="fs-1 text-success mb-2"><i class="fas fa-user-check"></i></div>
                            <p class="mb-0">User saat ini dalam status <strong>AKTIF</strong></p>
                        </div>
                        <form action="{{ route('admin.users.deactivate', $user) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100"
                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan user ini?')">
                                <i class="fas fa-ban me-1"></i> Nonaktifkan User
                            </button>
                        </form>
                    @else
                        <div class="mb-4 mt-3">
                            <div class="fs-1 text-danger mb-2"><i class="fas fa-user-times"></i></div>
                            <p class="mb-0">User saat ini dalam status <strong>NONAKTIF</strong></p>
                        </div>
                        <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-1"></i> Aktifkan User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Security Code Management -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-info h-100">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-1"></i> Code Keamanan (Darurat)
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="mb-3 small">Code Keamanan digunakan untuk login alternatif tanpa password saat keadaan darurat.</p>
                    
                    <div class="mb-4 text-center mt-3">
                        <label class="form-label text-muted small">Code Saat Ini:</label>
                        <div class="alert alert-light border fs-4 font-monospace mb-0 text-break">
                            {{ $user->security_code ?? 'Belum ada code' }}
                        </div>
                    </div>

                    <form action="{{ route('admin.users.refreshCode', $user) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="btn btn-outline-info w-100"
                                onclick="return confirm('Apakah Anda yakin ingin mengganti Code Keamanan user ini? Code yang lama tidak akan bisa digunakan lagi.')">
                            <i class="fas fa-sync-alt me-1"></i> Generate Code Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
