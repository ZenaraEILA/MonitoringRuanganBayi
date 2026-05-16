<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $teamData = [
            [
                'name' => 'Aisatu Sa\'baniyah',
                'gender' => 'Perempuan',
                'dob' => '14 Agustus 2007',
                'age' => 18,
                'role' => 'Maket Desain & Project Secretary',
                'phone' => '+62 8810-3642-9035',
                'email' => 'aisatu@monitoring.local'
            ],
            [
                'name' => 'Aisyah Nur R',
                'gender' => 'Perempuan',
                'dob' => 'Agustus 2008',
                'age' => 17,
                'role' => 'Desain Maket, Project Secretary & Web Designer',
                'phone' => '+62 812-3333-4444',
                'email' => 'aisyah@monitoring.local'
            ],
            [
                'name' => 'Aisyiah Rizkika',
                'gender' => 'Perempuan',
                'dob' => '02 Mei 2008',
                'age' => 18,
                'role' => 'Desain Maket & Web Designer',
                'phone' => '+62 812-5555-6666',
                'email' => 'aisyiah@monitoring.local'
            ],
            [
                'name' => 'Angga Dwi S',
                'gender' => 'Laki-laki',
                'dob' => '14 Mei 2007',
                'age' => 19,
                'role' => 'Team Leader & Desain Maket',
                'phone' => '+62 812-7777-8888',
                'email' => 'angga@monitoring.local'
            ],
            [
                'name' => 'Arfan Restu R',
                'gender' => 'Laki-laki',
                'dob' => '15 Agustus 2007',
                'age' => 18,
                'role' => 'Desain Maket & Full Stack Developer',
                'phone' => '+62 812-9999-0000',
                'email' => 'arfan@monitoring.local'
            ],
            [
                'name' => 'Ario Ilham K',
                'gender' => 'Laki-laki',
                'dob' => '22 November 2007',
                'age' => 18,
                'role' => 'Desain Maket, IoT & Web Developer',
                'phone' => '+62 813-1111-2222',
                'email' => 'ario@monitoring.local'
            ],
            [
                'name' => 'Azzahra Khayla R',
                'gender' => 'Perempuan',
                'dob' => '26 September 2007',
                'age' => 18,
                'role' => 'Desain Maket & Project Secretary',
                'phone' => '+62 813-5769-9710',
                'email' => 'azzahra@monitoring.local'
            ],
            [
                'name' => 'Calista Andra F',
                'gender' => 'Perempuan',
                'dob' => '14 Oktober 2007',
                'age' => 18,
                'role' => 'Desain Maket & Mockup Specialist',
                'phone' => '+62 813-5555-6666',
                'email' => 'calista@monitoring.local'
            ]
        ];

        $students = [];
        foreach ($teamData as $member) {
            $nameForAvatar = str_replace("'", "", $member['name']);
            $member['image'] = "https://ui-avatars.com/api/?name=" . urlencode($nameForAvatar) . "&background=0d6efd&color=fff";
            $students[] = $member;
        }

        return view('about', compact('students'));
    }
}
