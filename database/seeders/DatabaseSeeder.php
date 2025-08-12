<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        // Buat 1 admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Password default
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        // Buat 10 user dengan role acak selain admin
        // $roles = ['siswa', 'Guru_BK', 'Guru'];

        // for ($i = 1; $i <= 10; $i++) {
        //     User::create([
        //         'name' => 'User ' . $i,
        //         'username' => 'user' . $i,
        //         'email' => 'user' . $i . '@example.com',
        //         'password' => Hash::make('password'), // Password default
        //         'role' => $roles[array_rand($roles)],
        //         'remember_token' => Str::random(10),
        //     ]);
        // }
    }
}
