<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'John Joseph B. Ablog',
                'role' => 'Leader',
                'email' => 'joseph@gmail.com',
                'phone' => '+639171234567',
                'fb' => 'https://facebook.com/',
                'img' => 'images/default.png'
            ],
            [
                'name' => 'Lherna M. Raquinio',
                'role' => 'Documentation',
                'email' => 'lherna@gmail.com',
                'phone' => '+639181234567',
                'fb' => 'https://facebook.com/',
                'img' => 'images/default.png'
            ],
            [
                'name' => 'Jay-Lord E. Sebastian',
                'role' => 'Developer',
                'email' => 'jaylord@gmail.com',
                'phone' => '+639191234567',
                'fb' => 'https://facebook.com/',
                'img' => 'images/default.png'
            ],
            [
                'name' => 'Franksel P. Tindoc Jr.',
                'role' => 'Adviser',
                'email' => 'franksel@gmail.com',
                'phone' => '+639191234567',
                'fb' => 'https://facebook.com/',
                'img' => 'images/default.png'
            ]
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }
}