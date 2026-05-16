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
                            $students = [
                                [
                                    'name' => 'Aisatu Sa\'baniyah',
                                    'gender' => 'Perempuan',
                                    'dob' => '14 Agustus 2007',
                                    'age' => 18,
                                    'role' => 'Maket Desain & Project Secretary',
                                    'phone' => '+62 8810-3642-9035',
                                    'email' => 'aisatu@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Aisatu+Sabaniyah&background=0d6efd&color=fff'
                                ],
                                [
                                    'name' => 'Aisyah Nur R',
                                    'gender' => 'Perempuan',
                                    'dob' => 'Agustus 2008',
                                    'age' => 17,
                                    'role' => 'Desain Maket, Project Secretary & Web Designer',
                                    'phone' => '+62 812-3333-4444',
                                    'email' => 'aisyah@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Aisyah+Nur&background=0d6efd&color=fff'
                                ],
                                [
                                    'name' => 'Aisyiah Rizkika',
                                    'gender' => 'Perempuan',
                                    'dob' => '02 Mei 2008',
                                    'age' => 18,
                                    'role' => 'Desain Maket & Web Designer',
                                    'phone' => '+62 812-5555-6666',
                                    'email' => 'aisyiah@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Aisyiah+Rizkika&background=0d6efd&color=fff'
                                ],
                                [
                                    'name' => 'Angga Dwi S',
                                    'gender' => 'Laki-laki',
                                    'dob' => '14 Mei 2007',
                                    'age' => 19,
                                    'role' => 'Team Leader & Desain Maket',
                                    'phone' => '+62 812-7777-8888',
                                    'email' => 'angga@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Angga+Dwi&background=0d6efd&color=fff'
                                ],
                                [
                                    'name' => 'Arfan Restu R',
                                    'gender' => 'Laki-laki',
                                    'dob' => '15 Agustus 2007',
                                    'age' => 18,
                                    'role' => 'Desain Maket & Full Stack Developer',
                                    'phone' => '+62 812-9999-0000',
                                    'email' => 'arfan@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Arfan+Restu&background=0d6efd&color=fff'
                                ],
                                [
                                    'name' => 'Ario Ilham K',
                                    'gender' => 'Laki-laki',
                                    'dob' => '22 November 2007',
                                    'age' => 18,
                                    'role' => 'Desain Maket, IoT & Web Developer',
                                    'phone' => '+62 813-1111-2222',
                                    'email' => 'ario@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Ario+Ilham&background=0d6efd&color=fff'
                                ],
                                [
                                    'name' => 'Azzahra Khayla R',
                                    'gender' => 'Perempuan',
                                    'dob' => '26 September 2007',
                                    'age' => 18,
                                    'role' => 'Desain Maket & Project Secretary',
                                    'phone' => '+62 813-5769-9710',
                                    'email' => 'azzahra@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Azzahra+Khayla&background=0d6efd&color=fff'
                                ],
                                [
                                    'name' => 'Calista Andra F',
                                    'gender' => 'Perempuan',
                                    'dob' => '14 Oktober 2007',
                                    'age' => 18,
                                    'role' => 'Desain Maket & Mockup Specialist',
                                    'phone' => '+62 813-5555-6666',
                                    'email' => 'calista@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Calista+Andra&background=0d6efd&color=fff'
                                ]
                            ];
                        @endphp
                        @foreach($students as $student)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm hover-lift bg-white rounded-4 overflow-hidden">
                                <div class="bg-primary bg-gradient py-1"></div>
                                <div class="card-body p-4 text-start">
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $student['image'] }}" alt="{{ $student['name'] }}" class="rounded-circle shadow-sm border border-2 border-white mb-3" width="80" height="80">
                                            <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-2" title="Online"></span>
                                        </div>
                                        <h6 class="fw-bold mb-1 text-dark">{{ $student['name'] }}</h6>
                                        <div class="badge bg-soft-primary text-primary rounded-pill px-3 py-1 mb-2" style="font-size: 0.65rem; white-space: normal; line-height: 1.4;">
                                            {{ $student['role'] }}
                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas {{ $student['gender'] == 'Laki-laki' ? 'fa-mars text-info' : 'fa-venus text-danger' }} fa-fw"></i>
                                            </div>
                                            <span class="small text-muted">{{ $student['gender'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas fa-calendar-alt fa-fw text-secondary"></i>
                                            </div>
                                            <span class="small text-muted">{{ $student['dob'] }} ({{ $student['age'] }} thn)</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas fa-phone-alt fa-fw text-success"></i>
                                            </div>
                                            <span class="small text-muted">{{ $student['phone'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape icon-xs bg-light rounded-circle me-3">
                                                <i class="fas fa-envelope fa-fw text-warning"></i>
                                            </div>
                                            <span class="small text-muted" style="word-break: break-all;">{{ $student['email'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
