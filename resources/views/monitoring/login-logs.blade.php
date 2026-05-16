@extends('layouts.main')

@section('title', 'Riwayat Login - Sistem Monitoring')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
            <h1 class="h3 mb-0"><i class="fas fa-sign-in-alt text-primary me-2"></i> Riwayat Login</h1>
            <small class="text-muted">Total: <strong>{{ $totalLogin }}</strong> aktivitas login</small>
        </div>
    </div>
</div>

{{-- Statistik Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100" style="height:4px;background:linear-gradient(90deg,#0d6efd,#6ea8fe);"></div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:.5px;">Total Login</p>
                        <h2 class="fw-bold mb-0" style="font-size:2rem;">{{ $totalLogin }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:rgba(13,110,253,.1);">
                        <i class="fas fa-list text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100" style="height:4px;background:linear-gradient(90deg,#dc3545,#f87171);"></div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:.5px;">Login Admin</p>
                        <h2 class="fw-bold mb-0" style="font-size:2rem;">{{ $adminCount }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:rgba(220,53,69,.1);">
                        <i class="fas fa-user-shield text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100" style="height:4px;background:linear-gradient(90deg,#198754,#34d399);"></div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:.5px;">Login Petugas</p>
                        <h2 class="fw-bold mb-0" style="font-size:2rem;">{{ $petugasCount }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:rgba(25,135,84,.1);">
                        <i class="fas fa-user text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100" style="height:4px;background:linear-gradient(90deg,#f59e0b,#fbbf24);"></div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 fw-bold" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:.5px;">Pengguna Unik</p>
                        <h2 class="fw-bold mb-0" style="font-size:2rem;">{{ $uniqueUsers }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:rgba(245,158,11,.1);">
                        <i class="fas fa-users text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('login-logs.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold text-muted small mb-1">Rentang Tanggal</label>
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control text-center" style="font-size:.85rem;" value="{{ $startDate }}">
                        <span class="input-group-text bg-light border-start-0 border-end-0 px-2" style="font-size:.85rem;">s/d</span>
                        <input type="date" name="end_date" class="form-control text-center" style="font-size:.85rem;" value="{{ $endDate }}">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('login-logs.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;" title="Reset">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-table text-primary me-2"></i> Log Aktivitas Login</h5>
    </div>
    <div class="card-body px-0 pt-0">
        <div class="table-responsive px-4">
            <table class="table table-hover mb-0 table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Waktu Login</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loginLogs as $log)
                    <tr>
                        <td class="text-muted">{{ $loginLogs->firstItem() + $loop->index }}</td>
                        <td>
                            <span class="fw-semibold">{{ $log->user->name ?? '—' }}</span><br>
                            <small class="text-muted">{{ $log->user->email ?? '' }}</small>
                        </td>
                        <td>
                            @if($log->user)
                                <span class="badge {{ $log->user->role === 'admin' ? 'bg-danger' : 'bg-info' }}">
                                    {{ ucfirst($log->user->role) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Tidak Diketahui</span>
                            @endif
                        </td>
                        <td>
                            {{ $log->login_time->format('d M Y') }}<br>
                            <small class="text-muted">{{ $log->login_time->format('H:i:s') }} · {{ $log->login_time->diffForHumans() }}</small>
                        </td>
                        <td><code>{{ $log->ip_address ?? '—' }}</code></td>
                        <td>
                            <small class="text-muted" title="{{ $log->user_agent ?? '' }}">
                                {{ Str::limit($log->user_agent ?? '—', 40) }}
                            </small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                            <p class="text-muted mb-0">Tidak ada riwayat login</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($loginLogs->hasPages())
        <div class="d-flex justify-content-center mt-4 pb-3">
            {{ $loginLogs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
