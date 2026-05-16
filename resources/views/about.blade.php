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
                                    'name' => 'Aisatu Sa’baniyah',
                                    'gender' => 'Perempuan',
                                    'dob' => '12 Januari 2005',
                                    'age' => 21,
                                    'role' => 'Project Manager',
                                    'phone' => '+62 812-1111-2222',
                                    'email' => 'aisatu@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Aisatu+Sabaniyah&background=random'
                                ],
                                [
                                    'name' => 'Aisyah Nur R',
                                    'gender' => 'Perempuan',
                                    'dob' => '24 Februari 2005',
                                    'age' => 21,
                                    'role' => 'UI/UX Designer',
                                    'phone' => '+62 812-3333-4444',
                                    'email' => 'aisyah@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Aisyah+Nur&background=random'
                                ],
                                [
                                    'name' => 'Aisyiah Rizkika',
                                    'gender' => 'Perempuan',
                                    'dob' => '05 Maret 2005',
                                    'age' => 21,
                                    'role' => 'Frontend Developer',
                                    'phone' => '+62 812-5555-6666',
                                    'email' => 'aisyiah@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Aisyiah+Rizkika&background=random'
                                ],
                                [
                                    'name' => 'Angga Dwi S',
                                    'gender' => 'Laki-laki',
                                    'dob' => '17 April 2005',
                                    'age' => 21,
                                    'role' => 'Backend Developer',
                                    'phone' => '+62 812-7777-8888',
                                    'email' => 'angga@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Angga+Dwi&background=random'
                                ],
                                [
                                    'name' => 'Arfan Restu R',
                                    'gender' => 'Laki-laki',
                                    'dob' => '09 Mei 2005',
                                    'age' => 21,
                                    'role' => 'Database Admin',
                                    'phone' => '+62 812-9999-0000',
                                    'email' => 'arfan@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Arfan+Restu&background=random'
                                ],
                                [
                                    'name' => 'Ario Ilham K',
                                    'gender' => 'Laki-laki',
                                    'dob' => '21 Juni 2005',
                                    'age' => 20,
                                    'role' => 'IoT Engineer',
                                    'phone' => '+62 813-1111-2222',
                                    'email' => 'ario@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Ario+Ilham&background=random'
                                ],
                                [
                                    'name' => 'Azzahra Khayla R',
                                    'gender' => 'Perempuan',
                                    'dob' => '30 Juli 2005',
                                    'age' => 20,
                                    'role' => 'QA Analyst',
                                    'phone' => '+62 813-3333-4444',
                                    'email' => 'azzahra@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Azzahra+Khayla&background=random'
                                ],
                                [
                                    'name' => 'Calista Andra f',
                                    'gender' => 'Perempuan',
                                    'dob' => '14 Agustus 2005',
                                    'age' => 20,
                                    'role' => 'System Analyst',
                                    'phone' => '+62 813-5555-6666',
                                    'email' => 'calista@monitoring.local',
                                    'image' => 'https://ui-avatars.com/api/?name=Calista+Andra&background=random'
                                ]
                            ];
                        @endphp
                        @foreach($students as $student)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm bg-light rounded-4">
                                <div class="card-body p-3 text-start">
                                    <div class="text-center mb-3">
                                        <img src="{{ $student['image'] }}" alt="{{ $student['name'] }}" class="rounded-circle shadow-sm mb-2" width="70" height="70">
                                        <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">{{ $student['name'] }}</h6>
                                        <span class="badge bg-primary bg-gradient rounded-pill text-wrap" style="font-size: 0.7rem; line-height: 1.2;">{{ $student['role'] }}</span>
                                    </div>
                                    <hr class="text-secondary opacity-25 my-2">
                                    <ul class="list-unstyled text-muted mb-0" style="font-size: 0.75rem; word-wrap: break-word;">
                                        <li class="mb-2"><i class="fas {{ $student['gender'] == 'Laki-laki' ? 'fa-mars text-info' : 'fa-venus text-danger' }} fa-fw me-2"></i> {{ $student['gender'] }}</li>
                                        <li class="mb-2"><i class="fas fa-calendar-alt fa-fw me-2 text-secondary"></i> {{ $student['dob'] }} ({{ $student['age'] }} thn)</li>
                                        <li class="mb-2"><i class="fas fa-phone-alt fa-fw me-2 text-success"></i> {{ $student['phone'] }}</li>
                                        <li><i class="fas fa-envelope fa-fw me-2 text-warning"></i> {{ $student['email'] }}</li>
                                    </ul>
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
