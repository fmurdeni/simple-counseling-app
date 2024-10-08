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
        $user = [
                    [
                        'id' => 1,
                        'name' => 'admin',
                        'email' => 'feri@murdeni.com',
                        'password' => bcrypt('pekanbaru')
                    ],
                    [
                        'id' => 2,
                        'name' => 'user',
                        'email' => 'user@murdeni.com',
                        'password' => bcrypt('pekanbaru')
                    ]
            ];
        User::insert($user);
    }
}
