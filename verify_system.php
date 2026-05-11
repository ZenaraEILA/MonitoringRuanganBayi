<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Device;
use App\Models\Monitoring;

echo "--- DEVICES ---\n";
foreach(Device::all() as $d) {
    echo "ID: {$d->id} | DeviceID: {$d->device_id} | Name: {$d->device_name}\n";
}

echo "\n--- SIMULATING DATA ---\n";
$deviceId = Device::first()->device_id ?? 'SIMULATED-DEVICE';
$data = [
    'device_id' => $deviceId,
    'temperature' => 27.5,
    'humidity' => 55.0
];

// Simulate API call logic
$device = Device::firstOrCreate(
    ['device_id' => $data['device_id']],
    ['device_name' => 'Simulated Device', 'location' => 'Lab']
);

$monitoring = Monitoring::create([
    'device_id' => $device->id,
    'temperature' => $data['temperature'],
    'humidity' => $data['humidity'],
    'status' => 'Aman',
    'recorded_at' => now(),
]);

if ($monitoring) {
    echo "Successfully inserted simulated data for {$deviceId}\n";
}
