<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Monitoring;
use App\Models\DoctorNote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrintController extends Controller
{
    /**
     * Print today's condition for a device
     */
    public function printTodayCondition(Device $device, Request $request)
    {
        $today = Carbon::today();
        $tomorrow = $today->copy()->addDay();

        $todayData = $device->monitorings()
            ->whereBetween('recorded_at', [$today, $tomorrow])
            ->orderBy('recorded_at')
            ->get();

        if ($todayData->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data untuk hari ini',
            ]);
        }

        // Calculate statistics
        $stats = [
            'avg_temperature' => round($todayData->avg('temperature'), 2),
            'max_temperature' => $todayData->max('temperature'),
            'min_temperature' => $todayData->min('temperature'),
            'avg_humidity' => round($todayData->avg('humidity'), 2),
            'max_humidity' => $todayData->max('humidity'),
            'min_humidity' => $todayData->min('humidity'),
            'unsafe_count' => $todayData->where('status', 'Tidak Aman')->count(),
            'safe_count' => $todayData->where('status', 'Aman')->count(),
            'total_readings' => $todayData->count(),
        ];

        $doctorNotes = DoctorNote::where('device_id', $device->id)
            ->where('note_date', $today)
            ->get();

        $htmlContent = $this->generatePrintHTML($device, $today, $stats, $todayData, $doctorNotes);

        return view('print.condition', [
            'device' => $device,
            'date' => $today,
            'stats' => $stats,
            'readings' => $todayData,
            'doctor_notes' => $doctorNotes,
            'html_content' => $htmlContent,
        ]);
    }

    /**
     * Generate HTML for printing (Browser Preview)
     */
    private function generatePrintHTML($device, $date, $stats, $readings, $notes)
    {
        // Re-use the professional template for browser print as well
        return view('print.pdf-template', [
            'device' => $device,
            'date' => $date,
            'stats' => $stats,
            'readings' => $readings,
            'doctor_notes' => $notes,
        ])->render();
    }

    /**
     * Download print as PDF
     */
    public function downloadPDF(Device $device, Request $request)
    {
        $today = Carbon::today();
        $tomorrow = $today->copy()->addDay();

        $todayData = $device->monitorings()
            ->whereBetween('recorded_at', [$today, $tomorrow])
            ->orderBy('recorded_at')
            ->get();

        if ($todayData->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk hari ini');
        }

        // Stats calculation
        $stats = [
            'avg_temperature' => round($todayData->avg('temperature'), 2),
            'max_temperature' => $todayData->max('temperature'),
            'min_temperature' => $todayData->min('temperature'),
            'avg_humidity' => round($todayData->avg('humidity'), 2),
            'max_humidity' => $todayData->max('humidity'),
            'min_humidity' => $todayData->min('humidity'),
            'unsafe_count' => $todayData->where('status', 'Tidak Aman')->count(),
            'safe_count' => $todayData->where('status', 'Aman')->count(),
            'total_readings' => $todayData->count(),
        ];

        $doctorNotes = DoctorNote::where('device_id', $device->id)
            ->where('note_date', $today)
            ->get();

        $data = [
            'device' => $device,
            'date' => $today,
            'stats' => $stats,
            'readings' => $todayData,
            'doctor_notes' => $doctorNotes,
        ];

        // Use DomPDF to generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('print.pdf-template', $data);
        
        $filename = 'Laporan-Monitoring-' . Str::slug($device->device_name) . '-' . $today->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}
