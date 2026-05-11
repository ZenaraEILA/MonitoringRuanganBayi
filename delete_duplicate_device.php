<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Device;

$device = Device::where('device_id', 'DEVICE_LCF7P6RQYR_1777015359')->first();
if ($device) {
    $device->delete();
    echo "Deleted device: DEVICE_LCF7P6RQYR_1777015359\n";
} else {
    echo "Device not found.\n";
}
