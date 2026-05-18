@extends('layouts.main')

@section('title', 'Export Laporan - Sistem Monitoring Suhu Bayi')

@section('content')
<div class="container-fluid py-4 reports-container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 fw-bold text-dark">Export Laporan Monitoring</h1>
            <p class="text-muted">Unduh laporan monitoring dalam format PDF atau Excel untuk dokumentasi medis.</p>
        </div>
    </div>

    <!-- Alert -->
    @if($devices->isEmpty())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Perhatian:</strong> Belum ada device yang terdaftar. Silakan tambahkan device terlebih dahulu.
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
