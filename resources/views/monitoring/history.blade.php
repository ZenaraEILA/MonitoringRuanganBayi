@extends('layouts.main')

@section('title', 'Riwayat Monitoring - Sistem Monitoring Suhu Bayi')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                <i class="fas fa-history fs-4"></i>
            </div>
            <div>
                <h1 class="h3 mb-0 fw-bold text-dark">Riwayat Monitoring</h1>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Lihat dan filter data pemantauan ruangan dari waktu ke waktu</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-filter text-primary me-2"></i> Filter Data</h5>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ route('monitoring.history') }}" class="row g-3">
            <!-- Hidden device_id since only 1 room exists -->
            <input type="hidden" name="device_id" value="{{ $selectedDevice }}">
            <div class="col-lg-3 col-md-6">
                <label class="form-label fw-semibold text-muted small mb-1">Rentang Tanggal</label>
                <div class="input-group">
                    <input type="date" name="start_date" class="form-control px-2 text-center" style="font-size: 0.85rem;" value="{{ $startDate }}">
                    <span class="input-group-text bg-light px-2 border-start-0 border-end-0" style="font-size: 0.85rem;">s/d</span>
                    <input type="date" name="end_date" class="form-control px-2 text-center" style="font-size: 0.85rem;" value="{{ $endDate }}">
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <label for="status" class="form-label fw-semibold text-muted small mb-1">Status/Tindakan</label>
                <select name="status" id="status" class="form-select">
                    <option value="semua" {{ ($status ?? '') == 'semua' ? 'selected' : '' }}>Semua Kondisi</option>
                    <option value="normal" {{ ($status ?? '') == 'normal' ? 'selected' : '' }}>Normal (Aman)</option>
                    <option value="bahaya" {{ ($status ?? '') == 'bahaya' ? 'selected' : '' }}>Bahaya (Tidak Aman)</option>
                    <option value="panas" {{ ($status ?? '') == 'panas' ? 'selected' : '' }}>Kondisi Panas (Suhu &ge; 31&deg;C)</option>
                    <option value="dingin" {{ ($status ?? '') == 'dingin' ? 'selected' : '' }}>Kondisi Dingin (Suhu &le; 29&deg;C)</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-4">
                <label for="search_suhu" class="form-label fw-semibold text-muted small mb-1">Cari Suhu</label>
                <div class="input-group">
                    <input type="text" name="search_suhu" id="search_suhu" class="form-control" value="{{ $searchSuhu ?? '' }}" placeholder="26.5">
                    <span class="input-group-text bg-light px-2" style="font-size: 0.85rem;">°C</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-4">
                <label for="search_kelembapan" class="form-label fw-semibold text-muted small mb-1">Cari Kelembapan</label>
                <div class="input-group">
                    <input type="text" name="search_kelembapan" id="search_kelembapan" class="form-control" value="{{ $searchKelembapan ?? '' }}" placeholder="55.0">
                    <span class="input-group-text bg-light px-2" style="font-size: 0.85rem;">%</span>
                </div>
            </div>

            <div class="col-lg-1 col-md-4 d-flex align-items-end mt-3 mt-lg-0">
                <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; padding: 10px 14px;" title="Terapkan Filter">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Grafik Suhu & Kelembapan -->
<div class="card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-chart-area text-primary me-2"></i> Grafik Rata-rata Suhu & Kelembapan</h5>
            <div class="d-flex align-items-center gap-2">
                <label class="form-label fw-semibold text-muted small mb-0">Interval:</label>
                <select id="chartInterval" class="form-select form-select-sm border-0 bg-light" style="width:auto;min-width:140px;cursor:pointer;">
                    <option value="15">Tiap 15 Detik</option>
                    <option value="60" selected>Tiap 1 Menit</option>
                    <option value="300">Tiap 5 Menit</option>
                    <option value="900">Tiap 15 Menit</option>
                    <option value="1800">Tiap 30 Menit</option>
                    <option value="3600">Tiap 1 Jam</option>
                    <option value="21600">Tiap 6 Jam</option>
                    <option value="43200">Tiap 12 Jam</option>
                    <option value="86400">Tiap 1 Hari</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div id="chartEmpty" class="text-center py-5" style="display:none;">
            <i class="fas fa-chart-area fa-3x text-muted opacity-25 mb-3"></i>
            <p class="text-muted">Tidak ada data untuk ditampilkan dalam rentang ini</p>
        </div>
        <div class="chart-container" style="position:relative;height:320px;" id="chartWrapper">
            <canvas id="historyChart"></canvas>
        </div>
        <div class="d-flex gap-4 justify-content-center mt-3">
            <div class="d-flex align-items-center gap-2"><span style="width:14px;height:14px;border-radius:3px;background:#ef4444;display:inline-block;"></span><small class="text-muted fw-semibold">Suhu (°C)</small></div>
            <div class="d-flex align-items-center gap-2"><span style="width:14px;height:14px;border-radius:3px;background:#3b82f6;display:inline-block;"></span><small class="text-muted fw-semibold">Kelembapan (%)</small></div>
        </div>
    </div>
</div>

<script>
@php
$chartData = $monitorings->map(function($m) {
    return [
        'ts'   => $m->recorded_at->timestamp,
        'temp' => (float) $m->temperature,
        'hum'  => (float) $m->humidity,
        'label'=> $m->recorded_at->format('d/m H:i:s'),
    ];
})->sortBy('ts')->values();
@endphp
const rawData = @json($chartData);

let historyChart = null;

function buildChartData(intervalSeconds) {
    if (!rawData || rawData.length === 0) return null;

    // Group data into buckets based on interval
    const buckets = {};
    rawData.forEach(d => {
        const bucketKey = Math.floor(d.ts / intervalSeconds) * intervalSeconds;
        if (!buckets[bucketKey]) buckets[bucketKey] = { temps: [], hums: [], ts: bucketKey };
        buckets[bucketKey].temps.push(d.temp);
        buckets[bucketKey].hums.push(d.hum);
    });

    const sorted = Object.values(buckets).sort((a, b) => a.ts - b.ts);

    const labels = sorted.map(b => {
        const d = new Date(b.ts * 1000);
        if (intervalSeconds >= 86400) return d.toLocaleDateString('id-ID', {day:'2-digit',month:'short'});
        if (intervalSeconds >= 3600)  return d.toLocaleDateString('id-ID', {day:'2-digit',month:'short'}) + ' ' + d.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
        return d.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second: intervalSeconds < 60 ? '2-digit' : undefined});
    });

    const avg = arr => parseFloat((arr.reduce((a, b) => a + b, 0) / arr.length).toFixed(2));
    const temps = sorted.map(b => avg(b.temps));
    const hums  = sorted.map(b => avg(b.hums));

    return { labels, temps, hums, count: sorted.length };
}

function renderChart(intervalSeconds) {
    const data = buildChartData(intervalSeconds);

    if (!data || data.count === 0) {
        document.getElementById('chartWrapper').style.display = 'none';
        document.getElementById('chartEmpty').style.display   = 'block';
        return;
    }

    document.getElementById('chartWrapper').style.display = 'block';
    document.getElementById('chartEmpty').style.display   = 'none';

    if (historyChart) historyChart.destroy();

    const ctx = document.getElementById('historyChart').getContext('2d');
    historyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Rata-rata Suhu (°C)',
                    data: data.temps,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,0.08)',
                    borderWidth: 2,
                    pointRadius: data.count > 60 ? 0 : 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'yTemp',
                },
                {
                    label: 'Rata-rata Kelembapan (%)',
                    data: data.hums,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.08)',
                    borderWidth: 2,
                    pointRadius: data.count > 60 ? 0 : 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'yHum',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': ' + ctx.parsed.y
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        maxTicksLimit: 12,
                        maxRotation: 45,
                        font: { size: 11 }
                    },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                },
                yTemp: {
                    type: 'linear',
                    position: 'left',
                    title: { display: true, text: 'Suhu (°C)', color: '#ef4444', font: { size: 11 } },
                    ticks: { color: '#ef4444', font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    // Safe range lines
                    min: Math.min(...data.temps) - 2,
                },
                yHum: {
                    type: 'linear',
                    position: 'right',
                    title: { display: true, text: 'Kelembapan (%)', color: '#3b82f6', font: { size: 11 } },
                    ticks: { color: '#3b82f6', font: { size: 11 } },
                    grid: { drawOnChartArea: false },
                }
            }
        }
    });
}

// Init chart on load
document.addEventListener('DOMContentLoaded', function () {
    renderChart(parseInt(document.getElementById('chartInterval').value));

    document.getElementById('chartInterval').addEventListener('change', function () {
        renderChart(parseInt(this.value));
    });
});
</script>


<div class="card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-clock text-primary me-2"></i> Ringkasan Kondisi Per Jam</h5>
    </div>
    <div class="card-body px-0 pt-0">
        <div class="table-responsive px-4" style="max-height: 350px; overflow-y: auto;">
            <table class="table table-hover mb-0 table-sm">
                <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                    <tr>
                        <th>Tanggal & Jam</th>
                        <th>Rata-rata Suhu</th>
                        <th>Min - Max Suhu</th>
                        <th>Rata-rata Kelembapan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hourlySummaries as $summary)
                    <tr>
                        <td>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($summary->date)->format('d M Y') }}</span><br>
                            <small class="text-muted">{{ str_pad($summary->hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($summary->hour, 2, '0', STR_PAD_LEFT) }}:59</small>
                        </td>
                        <td>
                            <span class="badge px-2 py-1 rounded-2" style="background-color: {{ $summary->avg_temp < 28 || $summary->avg_temp > 30 ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $summary->avg_temp < 28 || $summary->avg_temp > 30 ? '#ef4444' : '#10b981' }}; border: 1px solid {{ $summary->avg_temp < 28 || $summary->avg_temp > 30 ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' }}">
                                {{ number_format($summary->avg_temp, 2) }} °C
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">{{ number_format($summary->min_temp, 1) }} °C - {{ number_format($summary->max_temp, 1) }} °C</small>
                        </td>
                        <td>
                            <span class="badge px-2 py-1 rounded-2" style="background-color: {{ $summary->avg_humidity < 35 || $summary->avg_humidity > 60 ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $summary->avg_humidity < 35 || $summary->avg_humidity > 60 ? '#ef4444' : '#10b981' }}; border: 1px solid {{ $summary->avg_humidity < 35 || $summary->avg_humidity > 60 ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' }}">
                                {{ number_format($summary->avg_humidity, 2) }} %
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <p class="text-muted mb-0">Tidak ada ringkasan data</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Data Table Detail -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list text-primary me-2"></i> Log Monitoring Detail (Per 10 Detik)</h5>
    </div>
    <div class="card-body px-0 pt-0">
    <div class="table-responsive px-4">
        <table class="table table-hover mb-0 table-sm">
            <thead>
                <tr>
                    <th>Suhu (°C)</th>
                    <th>Kelembapan (%)</th>
                    <th>Status</th>
                    <th>Rekomendasi</th>
                    <th>Catatan Tindakan</th>
                    <th>Waktu Pencatatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($monitorings as $monitoring)
                <tr class="{{ $monitoring->status === 'Tidak Aman' ? 'table-danger' : '' }}">
                    <td>
                        <span class="badge px-2 py-1 rounded-2" style="background-color: {{ $monitoring->temperature < 28 || $monitoring->temperature > 30 ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $monitoring->temperature < 28 || $monitoring->temperature > 30 ? '#ef4444' : '#10b981' }}; border: 1px solid {{ $monitoring->temperature < 28 || $monitoring->temperature > 30 ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' }}">
                            {{ number_format($monitoring->temperature, 2) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge px-2 py-1 rounded-2" style="background-color: {{ $monitoring->humidity < 35 || $monitoring->humidity > 60 ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $monitoring->humidity < 35 || $monitoring->humidity > 60 ? '#ef4444' : '#10b981' }}; border: 1px solid {{ $monitoring->humidity < 35 || $monitoring->humidity > 60 ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' }}">
                            {{ number_format($monitoring->humidity, 2) }}
                        </span>
                    </td>
                    <td>
                        <!-- Status Utama -->
                        <span class="badge {{ $monitoring->status === 'Aman' ? 'bg-success' : 'bg-danger' }}">
                            {{ $monitoring->status }}
                        </span>
                        
                        <!-- Status Kondisi Spesifik -->
                        @if($monitoring->temperature >= 31)
                            <span class="badge bg-danger ms-1">
                                <i class="fas fa-fire-alt me-1"></i>Panas
                            </span>
                        @elseif($monitoring->temperature <= 29)
                            <span class="badge bg-warning text-dark ms-1">
                                <i class="fas fa-snowflake me-1"></i>Dingin
                            </span>
                        @endif
                    </td>
                    <td>
                        @php
                            $recs = $monitoring->recommendation_list;
                        @endphp
                        @if(count($recs) > 0)
                            <small class="text-muted">
                                @foreach($recs as $rec)
                                    • {{ $rec }}<br>
                                @endforeach
                            </small>
                        @else
                            <small class="text-success">✓ Normal</small>
                        @endif
                    </td>
                    <td>
                        @if($monitoring->action_note)
                            <small class="text-muted">{{ Str::limit($monitoring->action_note, 30) }}</small>
                        @else
                            <small class="text-secondary">-</small>
                        @endif
                        @if($monitoring->status === 'Tidak Aman' && auth()->user()->role !== 'public')
                            <button class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#actionModal{{ $monitoring->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            

                        @endif
                    </td>
                    <td>{{ $monitoring->recorded_at->format('d-m-Y H:i:s') }}<br><small class="text-muted">{{ $monitoring->recorded_at->diffForHumans() }}</small></td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $monitoring->id }}" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <p class="text-muted mb-0">Tidak ada data monitoring</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
    </div>
    <div class="card-footer px-4 pb-3 pt-3 bg-white" style="position: sticky; bottom: 0; z-index: 100; border-top: 1px solid rgba(0,0,0,0.05) !important; border-radius: 0 0 16px 16px; box-shadow: 0 -8px 20px rgba(0,0,0,0.03);">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <small class="text-muted fw-bold">
                Total: {{ $monitorings->total() }} data
            </small>
            <div class="pagination-container m-0">
                {{ $monitorings->links() }}
            </div>
        </div>
    </div>
</div>


<!-- Modals for Action Notes -->
@foreach($monitorings as $monitoring)
    @if($monitoring->status === 'Tidak Aman')
        <!-- Action Modal -->
        <div class="modal fade" id="actionModal{{ $monitoring->id }}" tabindex="-1" aria-labelledby="actionModalLabel{{ $monitoring->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-warning bg-opacity-10 border-warning border-opacity-25">
                        <h5 class="modal-title text-warning-emphasis fw-bold" id="actionModalLabel{{ $monitoring->id }}">
                            <i class="fas fa-edit me-2"></i>Catatan Tindakan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('monitoring.update-action', $monitoring->id) }}" method="post">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label for="action_note_{{ $monitoring->id }}" class="form-label fw-semibold">Deskripsi Tindakan</label>
                                <textarea name="action_note" id="action_note_{{ $monitoring->id }}" class="form-control" rows="4" placeholder="Tulis tindakan apa yang telah dilakukan..." required>{{ $monitoring->action_note }}</textarea>
                                <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i>Catat apa yang telah dilakukan untuk mengatasi kondisi tidak aman ini.</small>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light rounded-bottom">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning text-dark fw-semibold px-4"><i class="fas fa-save me-2"></i>Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal{{ $monitoring->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $monitoring->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info bg-opacity-10 border-info border-opacity-25">
                    <h5 class="modal-title text-info-emphasis fw-bold" id="detailModalLabel{{ $monitoring->id }}">
                        <i class="fas fa-info-circle me-2"></i>Detail Monitoring
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <table class="table table-borderless table-sm mb-0">
                        <tr><td width="35%" class="text-muted fw-semibold">Device</td><td>: <strong>{{ $monitoring->device->device_name }}</strong></td></tr>
                        <tr><td class="text-muted fw-semibold">Lokasi</td><td>: {{ $monitoring->device->location }}</td></tr>
                        <tr><td class="text-muted fw-semibold">Suhu</td><td>: {{ $monitoring->temperature }} °C</td></tr>
                        <tr><td class="text-muted fw-semibold">Kelembapan</td><td>: {{ $monitoring->humidity }} %</td></tr>
                        <tr><td class="text-muted fw-semibold">Status</td><td>: 
                            <span class="badge {{ $monitoring->status === 'Aman' ? 'bg-success' : 'bg-danger' }}">{{ $monitoring->status }}</span>
                        </td></tr>
                        <tr><td class="text-muted fw-semibold">Waktu</td><td>: {{ $monitoring->recorded_at->format('d M Y, H:i:s') }}</td></tr>
                    </table>
                    
                    @php $recs = $monitoring->recommendation_list; @endphp
                    @if(count($recs) > 0)
                    <div class="mt-3 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded">
                        <h6 class="fw-bold mb-2 text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Rekomendasi:</h6>
                        <ul class="mb-0 text-danger small ps-3">
                            @foreach($recs as $rec)
                                <li>{{ $rec }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if($monitoring->action_note)
                    <div class="mt-3 p-3 bg-light rounded border">
                        <h6 class="fw-bold mb-1"><i class="fas fa-clipboard-check text-success me-1"></i> Catatan Tindakan:</h6>
                        <p class="mb-0 text-muted small">{{ $monitoring->action_note }}</p>
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-top-0 bg-light rounded-bottom">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
    .badge-aman {
        background-color: rgba(16, 185, 129, 0.1) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 8px;
    }

    .badge-tidak-aman {
        background-color: rgba(239, 68, 68, 0.1) !important;
        color: #ef4444 !important;
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 8px;
    }

    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 6px;
    }
    
    .table-danger {
        background-color: rgba(239, 68, 68, 0.04) !important;
    }
    
    .pagination-container .pagination {
        margin-bottom: 0 !important;
    }
</style>
<script>
    // Pindahkan semua modal ke body untuk menghindari bug z-index & backdrop
    document.querySelectorAll('.modal').forEach(function(modal) {
        document.body.appendChild(modal);
    });
</script>
@endsection
