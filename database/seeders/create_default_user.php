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
                        'password' => bcrypt('konselor')
                    ],
                    [
                        'id' => 2,
                        'name' => 'mahasiswa',
                        'email' => 'user@konseling.local',
                        'password' => bcrypt('mahasiswa')
                    ]
            ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
