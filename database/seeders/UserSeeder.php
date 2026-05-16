<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@monitoring.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );



        // Data Teman-Teman
        $friends = [
            ['name' => 'Aisatu Sa’baniyah', 'absen' => '03', 'username' => 'aisatu'],
            ['name' => 'Aisyah Nur R', 'absen' => '04', 'username' => 'aisyah'],
            ['name' => 'Aisyiah Rizkika', 'absen' => '05', 'username' => 'aisyiah'],
            ['name' => 'Angga Dwi S', 'absen' => '11', 'username' => 'angga'],
            ['name' => 'Arfan Restu R', 'absen' => '12', 'username' => 'arfan'],
            ['name' => 'Ario Ilham K', 'absen' => '13', 'username' => 'ario'],
            ['name' => 'Azzahra Khayla R', 'absen' => '16', 'username' => 'azzahra'],
            ['name' => 'Calista Andra f', 'absen' => '21', 'username' => 'calista'],
        ];

        foreach ($friends as $friend) {
            $email = $friend['username'] . $friend['absen'] . '@monitoring.local';
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $friend['name'],
                    'username' => $friend['username'] . $friend['absen'],
                    'password' => Hash::make('password123'),
                    'role' => 'petugas',
                    'hospital_id' => 'ABSEN-' . $friend['absen'],
                    'is_active' => true,
                ]
            );
        }
    }
}
