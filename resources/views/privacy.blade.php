@extends('layouts.main')

@section('title', 'Kebijakan Privasi - Room Temp Baby')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kebijakan Privasi</li>
                </ol>
            </nav>

            <!-- Card Policy -->
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <!-- Header -->
                <div class="card-header bg-primary text-white p-4 border-0" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <h2 class="mb-1 fw-bold text-white">Kebijakan Privasi</h2>
                            <p class="mb-0 text-white-50" style="font-size: 0.9rem;">Terakhir diperbarui: 17 Mei 2026</p>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-4 p-md-5">
                    <p class="lead text-muted mb-4">
                        Selamat datang di Sistem Monitoring Suhu & Kelembapan Ruangan Bayi (<strong>Room Temp Baby</strong>). Kami sangat menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi serta data medis yang dikelola dalam sistem ini.
                    </p>

                    <hr class="my-4" style="opacity: 0.1;">

                    <!-- Section 1 -->
                    <div class="mb-4">
                        <h4 class="fw-bold text-dark mb-3"><i class="fas fa-database text-primary me-2"></i> 1. Data yang Kami Kumpulkan</h4>
                        <p>Sistem ini mengumpulkan beberapa jenis data untuk memastikan pemantauan berjalan dengan baik:</p>
                        <ul class="text-muted">
                            <li><strong>Data Sensor Real-Time</strong>: Suhu dan kelembapan ruangan yang diambil secara otomatis oleh perangkat ESP8266/ESP32.</li>
                            <li><strong>Data Akun Pengguna</strong>: Nama, email, username, dan password (terenkripsi) untuk keperluan login dan hak akses.</li>
                            <li><strong>Log Aktivitas</strong>: Catatan waktu login, logout, dan perubahan data untuk keperluan audit keamanan.</li>
                        </ul>
                    </div>

                    <!-- Section 2 -->
                    <div class="mb-4">
                        <h4 class="fw-bold text-dark mb-3"><i class="fas fa-clipboard-check text-primary me-2"></i> 2. Penggunaan Data</h4>
                        <p>Data yang dikumpulkan digunakan semata-mata untuk:</p>
                        <ul class="text-muted">
                            <li>Menampilkan kondisi suhu dan kelembapan ruangan bayi secara real-time pada dashboard.</li>
                            <li>Memberikan notifikasi darurat jika kondisi ruangan berada di luar batas aman.</li>
                            <li>Menyusun laporan riwayat (history) untuk keperluan analisis medis oleh dokter atau perawat.</li>
                        </ul>
                    </div>

                    <!-- Section 3 -->
                    <div class="mb-4">
                        <h4 class="fw-bold text-dark mb-3"><i class="fas fa-lock text-primary me-2"></i> 3. Keamanan Data</h4>
                        <p>Kami menerapkan standar keamanan terbaik untuk melindungi data Anda:</p>
                        <ul class="text-muted">
                            <li>Semua komunikasi data antara perangkat ESP dan server menggunakan protokol yang aman.</li>
                            <li>Password pengguna dienkripsi menggunakan algoritma <code>Bcrypt</code> standar industri.</li>
                            <li>Akses ke database dibatasi dan dilindungi dengan kredensial yang kuat.</li>
                        </ul>
                    </div>

                    <!-- Section 4 -->
                    <div class="mb-4">
                        <h4 class="fw-bold text-dark mb-3"><i class="fas fa-user-tag text-primary me-2"></i> 4. Hak Akses Data</h4>
                        <p>Data ini bersifat internal dan hanya dapat diakses oleh:</p>
                        <ul class="text-muted">
                            <li><strong>Admin</strong>: Memiliki akses penuh untuk mengelola user dan perangkat.</li>
                            <li><strong>Petugas/Perawat</strong>: Dapat melihat data real-time dan riwayat untuk keperluan medis.</li>
                            <li><strong>Publik</strong>: Hanya dapat melihat data real-time tanpa bisa melihat data pribadi atau riwayat masa lalu.</li>
                        </ul>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm mt-5" style="border-radius: 12px; background: rgba(13, 110, 253, 0.05);">
                        <div class="d-flex gap-3">
                            <i class="fas fa-info-circle text-primary fs-4 mt-1"></i>
                            <div>
                                <h6 class="fw-bold text-primary mb-1">Catatan Penting</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                    Kebijakan ini dapat berubah sewaktu-waktu mengikuti perkembangan regulasi perlindungan data. Penggunaan sistem ini secara terus-menerus berarti Anda menyetujui kebijakan privasi ini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
