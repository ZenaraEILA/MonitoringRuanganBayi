@extends('layouts.main')

@section('title', 'Tentang Kami - Sistem Monitoring')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px;">
                    <i class="fas fa-heartbeat fa-3x"></i>
                </div>
                <h1 class="fw-bold text-dark">Tentang Sistem Monitoring</h1>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    Inovasi teknologi untuk kenyamanan dan keamanan ruang perawatan bayi dengan pemantauan suhu dan kelembapan secara real-time.
                </p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3"><i class="fas fa-bullseye text-primary me-2"></i> Tujuan Kami</h4>
                            <p class="text-muted">
                                Sistem ini dibangun untuk membantu tenaga medis dan rumah sakit dalam mengawasi kondisi ruangan bayi secara terus menerus (24/7). 
                                Kami percaya bahwa kondisi lingkungan yang stabil sangat penting bagi perkembangan dan kesehatan bayi yang baru lahir.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3"><i class="fas fa-microchip text-primary me-2"></i> Teknologi</h4>
                            <p class="text-muted">
                                Kami menggunakan teknologi <strong>Internet of Things (IoT)</strong> dengan sensor canggih yang secara akurat membaca suhu dan kelembapan, 
                                lalu mengirimkannya ke server secara nirkabel. Semua riwayat data dicatat dengan aman dan dapat diekspor untuk laporan medis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body p-5 text-center rounded">
                    <h3 class="fw-bold mb-4">Tim Pengembang</h3>
                    <p class="text-muted mb-5">Sistem ini dikembangkan oleh tim ahli kami:</p>
                    <div class="row justify-content-center g-4">
                        @php
                            // Ambil data user yang di-pin oleh admin ke halaman About Us
                            try {
                                $teamMembers = \App\Models\User::where('is_on_about_page', true)
                                    ->orderBy('name', 'asc')
                                    ->get();
                            } catch (\Throwable $e) {
                                $teamMembers = collect();
                            }
                        @endphp

                        @forelse($teamMembers as $member)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm hover-lift bg-white rounded-4 overflow-hidden">
                                <div class="bg-primary bg-gradient py-1"></div>
                                <div class="card-body p-4 text-start">
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            @php
                                                if ($member->profile_photo_path) {
                                                    $imagePath = "/storage/" . ltrim($member->profile_photo_path, '/');
                                                } else {
                                                    $cleanName = str_replace(["'", "’"], "", $member->name);
                                                    $imagePath = "https://ui-avatars.com/api/?name=" . urlencode($cleanName) . "&background=0d6efd&color=fff";
                                                }
                                            @endphp
                                            <img src="{{ $imagePath }}" alt="{{ $member->name }}" class="rounded-circle shadow-sm border border-2 border-white mb-3" width="80" height="80" style="object-fit: cover;">
                                            @php
                                                $isOnline = false;
                                                try {
                                                    $isOnline = \DB::table('sessions')
                                                        ->where('user_id', $member->id)
                                                        ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
                                                        ->exists();
                                                } catch (\Throwable $e) {
                                                    $isOnline = false;
                                                }
                                            @endphp
                                            <span class="position-absolute bottom-0 end-0 {{ $isOnline ? 'bg-success' : 'bg-danger' }} border border-white rounded-circle p-2" title="{{ $isOnline ? 'Online' : 'Offline' }}"></span>
                                        </div>
                                        <h6 class="fw-bold mb-1 text-dark">{{ $member->name }}</h6>
                                        <div class="badge bg-soft-primary text-primary rounded-pill px-3 py-1 mb-2" style="font-size: 0.65rem; white-space: normal; line-height: 1.4;">
                                            {{ $member->job_title ?? 'Developer' }}
                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas {{ $member->gender == 'Laki-laki' ? 'fa-mars text-info' : 'fa-venus text-danger' }} fa-fw"></i>
                                            </div>
                                            <span class="small text-muted">{{ $member->gender ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas fa-calendar-alt fa-fw text-secondary"></i>
                                            </div>
                                            <span class="small text-muted">
                                                {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->locale('id')->isoFormat('D MMMM YYYY') : '-' }}
                                                @if($member->dob)
                                                    ({{ \Carbon\Carbon::parse($member->dob)->age }} thn)
                                                @endif
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas fa-phone-alt fa-fw text-success"></i>
                                            </div>
                                            <span class="small text-muted">{{ $member->phone ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas fa-envelope fa-fw text-warning"></i>
                                            </div>
                                            <span class="small text-muted" style="word-break: break-all;">{{ $member->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada tim yang di-pin oleh Admin.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted small">Versi Sistem: 1.0.0 &bull; Dibuat pada Tahun 2026</p>
            </div>
        </div>
    </div>
</div>
@endsection
