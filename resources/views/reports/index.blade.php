@extends('layouts.main')

@section('title', 'Export Laporan - Sistem Monitoring Suhu Bayi')

@section('content')
<div class="container-fluid py-4 reports-container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3">📊 Export Laporan Monitoring</h1>
            <p class="text-muted">Unduh laporan monitoring dalam format PDF atau Excel untuk keperluan dokumentasi medis</p>
        </div>
    </div>

    <!-- Alert -->
    @if($devices->isEmpty())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>⚠️ Perhatian!</strong> Belum ada device yang terdaftar. Silakan tambahkan device terlebih dahulu.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- LAPORAN HARIAN -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: #e0f2ff; color: #0d6efd; font-size: 1.2rem;">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Laporan Harian</h5>
                            <small class="text-muted">Data per 24 jam</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3 d-flex flex-column">
                    <form action="{{ route('reports.export-daily') }}" method="POST" class="flex-grow-1 d-flex flex-column justify-content-between">
                        @csrf

                        <!-- Hidden device_id since only 1 room exists -->
                        <input type="hidden" name="device_id" value="{{ $devices->first()->id ?? '' }}">

                        <div class="mb-3">
                            <label for="daily_date" class="form-label small text-muted text-uppercase fw-bold">Pilih Tanggal</label>
                            <input type="date" class="form-control form-control-lg @error('date') is-invalid @enderror" id="daily_date" name="date" 
                                   value="{{ old('date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required style="border-radius: 10px; font-size: 0.95rem; border: 2px solid #e8ebed;">
                            <small class="form-text text-muted">&nbsp;</small> <!-- Spacer to match height -->
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Format Unduhan</label>
                            <div class="d-flex gap-2">
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="format" id="daily_pdf" value="pdf" checked>
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="daily_pdf" style="border-radius: 10px; border-width: 2px;">
                                        <i class="far fa-file-pdf"></i> PDF
                                    </label>
                                </div>
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="format" id="daily_excel" value="excel">
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="daily_excel" style="border-radius: 10px; border-width: 2px;">
                                        <i class="far fa-file-excel"></i> Excel
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mt-auto" style="border-radius: 10px; font-size: 0.95rem;">
                            <i class="fas fa-cloud-download-alt me-2"></i>Unduh Laporan
                        </button>
                    </form>

                    <div class="mt-3 p-3 bg-light rounded-3" style="font-size: 0.8rem;">
                        <div class="d-flex align-items-center mb-1 text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Grafik, statistik, dan tabel data</span>
                        </div>
                        <div class="d-flex align-items-center mb-1 text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Cocok untuk laporan harian ke dokter</span>
                        </div>
                        <div class="d-flex align-items-center text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Ukuran file ringan (< 5 MB)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LAPORAN MINGGUAN -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: #cff4fc; color: #0dcaf0; font-size: 1.2rem;">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Laporan Mingguan</h5>
                            <small class="text-muted">Data per 7 hari</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3 d-flex flex-column">
                    <form action="{{ route('reports.export-weekly') }}" method="POST" class="flex-grow-1 d-flex flex-column justify-content-between">
                        @csrf

                        <!-- Hidden device_id since only 1 room exists -->
                        <input type="hidden" name="device_id" value="{{ $devices->first()->id ?? '' }}">

                        <div class="mb-3">
                            <label for="weekly_start_date" class="form-label small text-muted text-uppercase fw-bold">Pilih Hari Pertama</label>
                            <input type="date" class="form-control form-control-lg @error('start_date') is-invalid @enderror" id="weekly_start_date" 
                                   name="start_date" value="{{ old('start_date', date('Y-m-d', strtotime('Monday this week'))) }}" 
                                   max="{{ date('Y-m-d') }}" required style="border-radius: 10px; font-size: 0.95rem; border: 2px solid #e8ebed;">
                            <small class="form-text text-muted">Laporan untuk 7 hari mulai dari tanggal ini</small>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Format Unduhan</label>
                            <div class="d-flex gap-2">
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="format" id="weekly_pdf" value="pdf" checked>
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="weekly_pdf" style="border-radius: 10px; border-width: 2px;">
                                        <i class="far fa-file-pdf"></i> PDF
                                    </label>
                                </div>
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="format" id="weekly_excel" value="excel">
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="weekly_excel" style="border-radius: 10px; border-width: 2px;">
                                        <i class="far fa-file-excel"></i> Excel
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info btn-lg w-100 fw-bold text-white mt-auto" style="border-radius: 10px; font-size: 0.95rem; background: #0dcaf0; border: none;">
                            <i class="fas fa-cloud-download-alt me-2"></i>Unduh Laporan
                        </button>
                    </form>

                    <div class="mt-3 p-3 bg-light rounded-3" style="font-size: 0.8rem;">
                        <div class="d-flex align-items-center mb-1 text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Cakupan: 7 hari laporan penuh</span>
                        </div>
                        <div class="d-flex align-items-center mb-1 text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Cocok untuk review mingguan</span>
                        </div>
                        <div class="d-flex align-items-center text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Data points: ~2000++ records</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LAPORAN BULANAN -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: #d1e7dd; color: #198754; font-size: 1.2rem;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Laporan Bulanan</h5>
                            <small class="text-muted">Data per bulan</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3 d-flex flex-column">
                    <form action="{{ route('reports.export-monthly') }}" method="POST" class="flex-grow-1 d-flex flex-column justify-content-between">
                        @csrf

                        <!-- Hidden device_id since only 1 room exists -->
                        <input type="hidden" name="device_id" value="{{ $devices->first()->id ?? '' }}">

                        <div class="mb-3">
                            <label for="monthly_month" class="form-label small text-muted text-uppercase fw-bold">Pilih Bulan & Tahun</label>
                            <input type="month" class="form-control form-control-lg @error('month') is-invalid @enderror" id="monthly_month" 
                                   name="month" value="{{ old('month', date('Y-m')) }}" required style="border-radius: 10px; font-size: 0.95rem; border: 2px solid #e8ebed;">
                            <small class="form-text text-muted">&nbsp;</small> <!-- Spacer to match height -->
                            @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted text-uppercase fw-bold">Format Unduhan</label>
                            <div class="d-flex gap-2">
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="format" id="monthly_pdf" value="pdf" checked>
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="monthly_pdf" style="border-radius: 10px; border-width: 2px;">
                                        <i class="far fa-file-pdf"></i> PDF
                                    </label>
                                </div>
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="format" id="monthly_excel" value="excel">
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="monthly_excel" style="border-radius: 10px; border-width: 2px;">
                                        <i class="far fa-file-excel"></i> Excel
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 fw-bold mt-auto" style="border-radius: 10px; font-size: 0.95rem;">
                            <i class="fas fa-cloud-download-alt me-2"></i>Unduh Laporan
                        </button>
                    </form>

                    <div class="mt-3 p-3 bg-light rounded-3" style="font-size: 0.8rem;">
                        <div class="d-flex align-items-center mb-1 text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Cakupan: Seluruh bulan (Data Agregat)</span>
                        </div>
                        <div class="d-flex align-items-center mb-1 text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Cocok untuk laporan arsip & audit</span>
                        </div>
                        <div class="d-flex align-items-center text-secondary">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Data di-agregasi per jam agar stabil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mt-5">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: #e0f2ff; color: #0d6efd;">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Informasi Laporan</h5>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold text-secondary mb-3" style="font-size: 0.9rem;">APA YANG TERMASUK DALAM LAPORAN?</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="fw-bold text-dark mb-1"><i class="fas fa-chart-line text-primary me-2"></i>Ringkasan Statistik</div>
                                <p class="text-muted small mb-0">Suhu/Kelembapan min, max, rata-rata, dan status monitoring.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="fw-bold text-dark mb-1"><i class="fas fa-chart-area text-primary me-2"></i>Grafik Visual</div>
                                <p class="text-muted small mb-0">Chart interaktif yang menampilkan tren suhu dan kelembapan.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="fw-bold text-dark mb-1"><i class="fas fa-table text-primary me-2"></i>Tabel Data Lengkap</div>
                                <p class="text-muted small mb-0">Setiap data point dengan timestamp, status, dan tindakan.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="fw-bold text-dark mb-1"><i class="fas fa-exclamation-circle text-primary me-2"></i>Kejadian Penting</div>
                                <p class="text-muted small mb-0">Semua incident markers selama periode laporan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(255,255,255,0.2); color: white;">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Tips Penggunaan</h5>
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 0.85rem; opacity: 0.9;">
                        <li class="mb-3 d-flex gap-2">
                            <i class="far fa-file-pdf mt-1"></i>
                            <span><strong>Format PDF:</strong> Gunakan untuk laporan profesional yang siap dicetak.</span>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="far fa-file-excel mt-1"></i>
                            <span><strong>Format Excel:</strong> Gunakan untuk analisis data lebih lanjut dan pivot table.</span>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fas fa-print mt-1"></i>
                            <span><strong>Cetak:</strong> Laporan PDF bisa langsung dicetak dengan format rapi.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <i class="fas fa-archive mt-1"></i>
                            <span><strong>Arsip:</strong> Simpan laporan sebagai dokumen resmi ruangan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .reports-container {
        padding-bottom: 2rem;
    }
</style>
@endsection
