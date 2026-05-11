<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Device;

$devices = Device::all();
foreach ($devices as $device) {
    echo "ID: " . $device->id . " | DeviceID: " . $device->device_id . " | Name: " . $device->device_name . "\n";
}
