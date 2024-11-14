<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class create_default_user extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
                    [
                        'id' => 1,
                        'name' => 'konselor',
                        'email' => 'konselor@konseling.local',
                        'password' => bcrypt('konselor'),
                        'npm' => '1'
                    ],
                    [
                        'id' => 2,
                        'name' => 'mahasiswa',
                        'email' => 'user@konseling.local',
                        'password' => bcrypt('mahasiswa'),
                        'npm' => '2'
                    ]
            ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
