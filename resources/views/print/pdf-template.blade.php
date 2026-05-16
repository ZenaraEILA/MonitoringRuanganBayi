<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Monitoring Ruangan Bayi - {{ $device->device_name }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #333;
        }
        .header-table {
            width: 100%;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo-cell {
            width: 15%;
            vertical-align: middle;
        }
        .logo {
            width: 80px;
        }
        .title-cell {
            width: 85%;
            text-align: left;
            padding-left: 20px;
        }
        .hospital-name {
            font-size: 20pt;
            font-weight: bold;
            color: #0d6efd;
            margin: 0;
            text-transform: uppercase;
        }
        .report-subtitle {
            font-size: 12pt;
            color: #666;
            margin: 5px 0 0 0;
        }
        .info-section {
            margin-bottom: 25px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        .info-table {
            width: 100%;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            width: 25%;
        }
        .info-value {
            color: #000;
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #0d6efd;
            border-left: 5px solid #0d6efd;
            padding-left: 10px;
            margin: 30px 0 15px 0;
            background: #f1f7ff;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-box {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }
        .stats-label {
            font-size: 9pt;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .stats-number {
            font-size: 15pt;
            font-weight: bold;
            color: #212529;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border: 1px solid #0d6efd;
        }
        .data-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: center;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9pt;
            font-weight: bold;
        }
        .status-safe {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .status-danger {
            background-color: #f8d7da;
            color: #842029;
        }
        .notes-section {
            margin-top: 30px;
            padding: 15px;
            border: 1px dashed #ced4da;
            border-radius: 8px;
        }
        .note-item {
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .note-category {
            font-weight: bold;
            color: #0d6efd;
            font-size: 10pt;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #333;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('images/logo-report.png') }}" class="logo">
            </td>
            <td class="title-cell">
                <h1 class="hospital-name">SISTEM MONITORING RUANGAN BAYI</h1>
                <p class="report-subtitle">Laporan Pemantauan Suhu & Kelembapan Real-Time</p>
            </td>
        </tr>
    </table>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Ruangan / Device:</td>
                <td class="info-value">{{ $device->device_name }}</td>
                <td class="info-label">Tanggal Laporan:</td>
                <td class="info-value">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td class="info-label">ID Perangkat:</td>
                <td class="info-value">{{ $device->device_id ?? '-' }}</td>
                <td class="info-label">Lokasi:</td>
                <td class="info-value">{{ $device->location ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Waktu Cetak:</td>
                <td class="info-value">{{ now()->format('H:i:s') }} WIB</td>
                <td class="info-label">Total Data:</td>
                <td class="info-value">{{ count($readings) }} Titik Monitoring</td>
            </tr>
        </table>
    </div>

    <div class="section-title">RINGKASAN STATISTIK</div>
    <table style="width: 100%; border-spacing: 10px;">
        <tr>
            <td width="33%">
                <div class="stats-box">
                    <div class="stats-label">Rerata Suhu</div>
                    <div class="stats-number">{{ $stats['avg_temperature'] }}°C</div>
                </div>
            </td>
            <td width="33%">
                <div class="stats-box">
                    <div class="stats-label">Rerata Kelembapan</div>
                    <div class="stats-number">{{ $stats['avg_humidity'] }}%</div>
                </div>
            </td>
            <td width="33%">
                <div class="stats-box">
                    <div class="stats-label">Status Aman</div>
                    <div class="stats-number" style="color: #198754;">{{ $stats['safe_count'] }} Data</div>
                </div>
            </td>
        </tr>
        <tr>
            <td width="33%">
                <div class="stats-box">
                    <div class="stats-label">Min/Max Suhu</div>
                    <div class="stats-number">{{ $stats['min_temperature'] }} - {{ $stats['max_temperature'] }}°C</div>
                </div>
            </td>
            <td width="33%">
                <div class="stats-box">
                    <div class="stats-label">Min/Max Kelembapan</div>
                    <div class="stats-number">{{ $stats['min_humidity'] }} - {{ $stats['max_humidity'] }}%</div>
                </div>
            </td>
            <td width="33%">
                <div class="stats-box">
                    <div class="stats-label">Peringatan Bahaya</div>
                    <div class="stats-number" style="color: #dc3545;">{{ $stats['unsafe_count'] }} Kejadian</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">RIWAYAT DATA MONITORING</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Suhu (°C)</th>
                <th>Kelembapan (%)</th>
                <th>Status</th>
                <th>Indikator</th>
            </tr>
        </thead>
        <tbody>
            @foreach($readings as $reading)
            <tr>
                <td>{{ \Carbon\Carbon::parse($reading->recorded_at)->format('H:i') }}</td>
                <td>{{ number_format($reading->temperature, 1) }}°C</td>
                <td>{{ number_format($reading->humidity, 1) }}%</td>
                <td>
                    <span class="status-badge {{ $reading->status == 'Aman' ? 'status-safe' : 'status-danger' }}">
                        {{ $reading->status }}
                    </span>
                </td>
                <td style="color: {{ $reading->status == 'Aman' ? '#198754' : '#dc3545' }}; font-weight: bold;">
                    {{ $reading->status == 'Aman' ? '● STABIL' : '▲ WASPADA' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(count($doctor_notes) > 0)
    <div class="section-title">CATATAN MEDIS & ANALISIS</div>
    <div class="notes-section">
        @foreach($doctor_notes as $note)
        <div class="note-item">
            <span class="note-category">[{{ $note->category }}]</span> - {{ $note->content }}
            <br>
            <small style="color: #888;">Oleh: {{ $note->user->name ?? 'Staf Medis' }} | {{ \Carbon\Carbon::parse($note->created_at)->format('H:i') }}</small>
        </div>
        @endforeach
    </div>
    @endif

    <div class="footer">
        <div class="signature-box">
            <p>Penanggung Jawab Ruangan,</p>
            <div class="signature-line"></div>
            <p><strong>( ________________________ )</strong></p>
            <p style="font-size: 9pt; color: #666;">NIP / ID Petugas</p>
        </div>
    </div>
    <div class="clear"></div>

    <div style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; color: #aaa; border-top: 1px solid #eee; padding-top: 5px;">
        Laporan ini dihasilkan secara otomatis oleh Sistem Monitoring Ruangan Bayi. Dokumen sah tanpa tanda tangan basah jika diverifikasi melalui sistem.
    </div>
</body>
</html>
