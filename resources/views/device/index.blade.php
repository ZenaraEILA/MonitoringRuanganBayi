@extends('layouts.main')

@section('title', 'Manajemen Device - Sistem Monitoring Suhu Bayi')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0"><i class="fas fa-microchip"></i> Manajemen Device</h1>
            <a href="{{ route('device.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Device
            </a>
        </div>
    </div>
</div>

<!-- Info Alert -->
<div class="alert alert-info" role="alert">
    <i class="fas fa-info-circle"></i>
    <strong>Informasi:</strong> Setiap device akan mendapatkan Device ID yang unik untuk identifikasi saat ESP mengirim data.
</div>

<!-- Devices Table -->
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Device</th>
                <th>Lokasi</th>
                <th>Device ID</th>
                <th>Status Terbaru</th>
                <th>Suhu Terbaru</th>
                <th>Kelembapan Terbaru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($devices as $key => $device)
            <tr>
                <td>{{ ($devices->currentPage() - 1) * $devices->perPage() + $key + 1 }}</td>
                <td><strong>{{ $device->device_name }}</strong></td>
                <td>{{ $device->location }}</td>
                <td>
                    <code class="bg-light p-2 rounded" style="font-size: 0.85rem; word-break: break-all;">
                        {{ $device->device_id }}
                    </code>
                </td>
                <td>
                    @if($device->monitorings->count() > 0)
                        @php $monitoring = $device->monitorings->first(); @endphp
                        <span class="badge {{ $monitoring->status === 'Aman' ? 'bg-success' : 'bg-danger' }}">
                            {{ $monitoring->status }}
                        </span>
                    @else
                        <span class="badge bg-secondary">Belum ada data</span>
                    @endif
                </td>
                <td>
                    @if($device->monitorings->count() > 0)
                        @php $monitoring = $device->monitorings->first(); @endphp
                        {{ number_format($monitoring->temperature, 2) }}°C
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($device->monitorings->count() > 0)
                        @php $monitoring = $device->monitorings->first(); @endphp
                        {{ number_format($monitoring->humidity, 2) }}%
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('device.edit', $device->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('device.destroy', $device->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <p class="text-muted mb-0">
                        <i class="fas fa-box-open"></i> Belum ada device terdaftar
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $devices->links() }}
</div>


@endsection
