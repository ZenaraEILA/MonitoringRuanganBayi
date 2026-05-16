{{-- Daftar semua user (Admin only)
File: resources/views/admin/users/index.blade.php
GET /admin/users
--}}

@extends('layouts.main')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">
                <i class="fas fa-users"></i> Manajemen User
            </h1>
            <p class="text-muted">Kelola akun user dan ubah role sesuai kebutuhan</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Users Table -->
    <form action="{{ route('admin.users.bulkDelete') }}" method="POST" id="bulkDeleteForm">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="fas fa-list text-primary me-2"></i> Daftar User
                </h5>
                <div id="bulkActions" style="display: none;">
                    <span class="text-muted me-3 small" id="selectedCount">0 terpilih</span>
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen semua user yang dipilih?')">
                        <i class="fas fa-trash-alt me-1"></i> Hapus Terpilih
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="text-center">
                                <div class="form-check m-0 d-inline-block">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th style="width: 50px;">No</th>
                            <th>Info User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Login Terakhir</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $u)
                        <tr>
                            <td class="text-center">
                                <div class="form-check m-0 d-inline-block">
                                    <input class="form-check-input user-checkbox" type="checkbox" name="ids[]" value="{{ $u->id }}" 
                                           {{ $u->id === auth()->id() ? 'disabled' : '' }}>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle-sm bg-primary text-white me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 35px; height: 35px; font-size: 0.8rem; overflow: hidden;">
                                        @if($u->profile_photo_path)
                                            <img src="/storage/{{ $u->profile_photo_path }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <span>{{ strtoupper(substr($u->name ?? 'U', 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $u->name }}</div>
                                        <small class="text-muted">@<span>{{ $u->username ?? '-' }}</span></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small><code>{{ $u->email }}</code></small>
                            </td>
                            <td>
                                @if($u->role === 'admin')
                                    <span class="badge bg-soft-danger text-danger border-danger">
                                        <i class="fas fa-crown"></i> Admin
                                    </span>
                                @elseif($u->role === 'petugas')
                                    <span class="badge bg-soft-primary text-primary border-primary">
                                        <i class="fas fa-user"></i> Petugas
                                    </span>
                                @else
                                    <span class="badge bg-soft-info text-info border-info">
                                        <i class="fas fa-eye"></i> Publik
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($u->is_active)
                                    <span class="text-success small fw-bold">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="text-danger small fw-bold">
                                        <i class="fas fa-times-circle"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $u->getLastLoginInfo() }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('admin.users.show', $u) }}"
                                       class="btn btn-sm btn-white border" title="Lihat Detail">
                                        <i class="fas fa-eye text-info"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $u) }}"
                                       class="btn btn-sm btn-white border" title="Edit Profil">
                                        <i class="fas fa-edit text-warning"></i>
                                    </a>
                                    @if($u->id !== auth()->id())
                                    <button type="button" 
                                            class="btn btn-sm btn-white border delete-user-btn" 
                                            data-id="{{ $u->id }}" 
                                            data-name="{{ $u->name }}"
                                            title="Hapus User">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i><br>
                                Tidak ada user yang ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user</small>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Single Delete Form (Hidden) -->
<form id="singleDeleteForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    const deleteBtns = document.querySelectorAll('.delete-user-btn');
    const singleDeleteForm = document.getElementById('singleDeleteForm');

    // Handle Select All
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                if (!cb.disabled) cb.checked = this.checked;
            });
            updateBulkActions();
        });
    }

    // Handle Individual Checkboxes
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkActions.style.display = 'flex';
            selectedCount.textContent = `${checkedCount} terpilih`;
        } else {
            bulkActions.style.display = 'none';
        }
    }

    // Handle Single Delete
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus permanen akun '${name}'? Data tidak dapat dikembalikan.`)) {
                singleDeleteForm.action = `/admin/users/${id}`;
                singleDeleteForm.submit();
            }
        });
    });
});
</script>
@endsection

@section('styles')
<style>
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    
    .badge {
        padding: 0.4rem 0.6rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 0.7rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
    
    .btn-white {
        background-color: #fff;
    }
    
    .btn-group .btn:hover {
        background-color: #f8f9fa;
        z-index: 2;
    }

    .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endsection
