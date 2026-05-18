<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Show monitoring history.
     */
    public function history(Request $request)
    {
        $devices = Device::all();
        $selectedDevice = $request->get('device_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');
        $status = $request->get('status');
        $searchSuhu = $request->get('search_suhu');
        $searchKelembapan = $request->get('search_kelembapan');

        $query = Monitoring::with('device');

        if ($selectedDevice) {
            $query->where('device_id', $selectedDevice);
        }

        if ($startDate) {
            $startDateTime = Carbon::parse($startDate)->startOfDay();
            if ($startTime) {
                $startDateTime = Carbon::parse($startDate . ' ' . $startTime);
            }
            $query->where('recorded_at', '>=', $startDateTime);
        }

        if ($endDate) {
            $endDateTime = Carbon::parse($endDate)->endOfDay();
            if ($endTime) {
                $endDateTime = Carbon::parse($endDate . ' ' . $endTime);
            }
            $query->where('recorded_at', '<=', $endDateTime);
        }

        if ($status && $status !== 'semua') {
            if ($status === 'normal') {
                $query->where('status', 'Aman');
            } elseif ($status === 'bahaya') {
                $query->where('status', 'Tidak Aman');
            } elseif ($status === 'panas') {
                $query->where('temperature', '>=', 31);
            } elseif ($status === 'dingin') {
                $query->where('temperature', '<=', 29);
            }
        }

        if ($searchSuhu) {
            $query->where('temperature', 'like', "%{$searchSuhu}%");
        }

        if ($searchKelembapan) {
            $query->where('humidity', 'like', "%{$searchKelembapan}%");
        }

        $hourlyQuery = clone $query;
        $hourlySummaries = $hourlyQuery
            ->selectRaw('DATE(recorded_at) as date, HOUR(recorded_at) as hour')
            ->selectRaw('ROUND(AVG(temperature), 2) as avg_temp')
            ->selectRaw('ROUND(AVG(humidity), 2) as avg_humidity')
            ->selectRaw('ROUND(MAX(temperature), 2) as max_temp')
            ->selectRaw('ROUND(MIN(temperature), 2) as min_temp')
            ->groupBy('date', 'hour')
            ->orderBy('date', 'desc')
            ->orderBy('hour', 'desc')
            ->get();

        $monitorings = $query->latest('recorded_at')->paginate(50);

        return view('monitoring.history', compact('monitorings', 'hourlySummaries', 'devices', 'selectedDevice', 'startDate', 'endDate', 'startTime', 'endTime', 'status', 'searchSuhu', 'searchKelembapan'));
    }



    /**
     * Update action note for monitoring record
     */
    public function updateAction(Request $request, $id)
    {
        $validated = $request->validate([
            'action_note' => 'required|string|max:500',
        ]);

        $monitoring = Monitoring::findOrFail($id);
        $monitoring->update(['action_note' => $validated['action_note']]);

        return redirect()->back()->with('success', 'Catatan tindakan berhasil disimpan');
    }

    /**
     * Show emergency incidents
     */
    public function emergencyIncidents(Request $request)
    {
        $devices = Device::all();
        $selectedDevice = $request->get('device_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Monitoring::where('is_emergency', true);

        if ($selectedDevice) {
            $query->where('device_id', $selectedDevice);
        }

        if ($startDate) {
            $query->where('recorded_at', '>=', Carbon::parse($startDate)->startOfDay());
        }

        if ($endDate) {
            $query->where('recorded_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $emergencies = $query->with(['device'])
            ->latest('recorded_at')
            ->paginate(50);

        return view('monitoring.emergency-incidents', compact('emergencies', 'devices', 'selectedDevice', 'startDate', 'endDate'));
    }
}
