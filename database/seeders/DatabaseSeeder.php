<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        // Seed users (admin & petugas)
        $this->call(UserSeeder::class);

        // Seed production users and devices (uncomment untuk production)
        // $this->call(ProductionUserSeeder::class);
        // $this->call(ProductionDeviceSeeder::class);

        // Seed dummy monitoring data
        $this->call(MonitoringSeeder::class);
    }
}
