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
                'job_title' => 'System Administrator',
                'is_on_about_page' => false,
            ]
        );

        // Data Tim Pengembang (Berdasarkan data terbaru dari user)
        $friends = [
            [
                'name' => 'Aisatu Sa’baniyah', 
                'username' => 'aisatu', 
                'job_title' => 'Maket Desain & Project Secretary',
                'dob' => '2007-08-14',
                'gender' => 'Perempuan',
                'phone' => '+62 8810-3642-9035'
            ],
            [
                'name' => 'Aisyah Nur R', 
                'username' => 'aisyah', 
                'job_title' => 'Desain Maket, Project Secretary & Web Designer',
                'dob' => '2008-08-01',
                'gender' => 'Perempuan',
                'phone' => '+62 812-3333-4444'
            ],
            [
                'name' => 'Aisyiah Rizkika', 
                'username' => 'aisyiah', 
                'job_title' => 'Desain Maket & Web Designer',
                'dob' => '2008-05-02',
                'gender' => 'Perempuan',
                'phone' => '+62 812-5555-6666'
            ],
            [
                'name' => 'Angga Dwi S', 
                'username' => 'angga', 
                'job_title' => 'Team Leader & Desain Maket',
                'dob' => '2007-05-14',
                'gender' => 'Laki-laki',
                'phone' => '+62 812-7777-8888'
            ],
            [
                'name' => 'Arfan Restu R', 
                'username' => 'arfan', 
                'job_title' => 'Desain Maket & Full Stack Developer',
                'dob' => '2007-08-15',
                'gender' => 'Laki-laki',
                'phone' => '+62 812-9999-0000'
            ],
            [
                'name' => 'Ario Ilham K', 
                'username' => 'ario', 
                'job_title' => 'Desain Maket, IoT & Web Developer',
                'dob' => '2007-11-22',
                'gender' => 'Laki-laki',
                'phone' => '+62 813-1111-2222'
            ],
            [
                'name' => 'Azzahra Khayla R', 
                'username' => 'azzahra', 
                'job_title' => 'Desain Maket & Project Secretary',
                'dob' => '2007-09-26',
                'gender' => 'Perempuan',
                'phone' => '+62 813-5769-9710'
            ],
            [
                'name' => 'Calista Andra f', 
                'username' => 'calista', 
                'job_title' => 'Desain Maket & Mockup Specialist',
                'dob' => '2007-10-14',
                'gender' => 'Perempuan',
                'phone' => '+62 813-5555-6666'
            ],
        ];

        foreach ($friends as $friend) {
            $email = $friend['username'] . '@monitoring.local';
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $friend['name'],
                    'username' => $friend['username'],
                    'password' => Hash::make('password123'),
                    'role' => 'petugas',
                    'job_title' => $friend['job_title'],
                    'dob' => $friend['dob'],
                    'gender' => $friend['gender'],
                    'phone' => $friend['phone'],
                    'is_on_about_page' => true, // Pin ke About Us page secara otomatis
                    'is_active' => true,
                ]
            );
        }
    }
}
