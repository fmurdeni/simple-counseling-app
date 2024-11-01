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
                        'name' => 'Konselor',
                        'email' => 'feri@murdeni.com',
                        'password' => bcrypt('pekanbaru')
                    ],
                    [
                        'id' => 2,
                        'name' => 'Yudha',
                        'email' => 'yudha@gmail.com',
                        'password' => bcrypt('pekanbaru')
                    ]
            ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
