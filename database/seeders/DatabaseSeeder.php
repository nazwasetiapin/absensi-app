<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 1, // admin = 1
            'email_verified_at' => Carbon::now(),
        ]);

        // Karyawan user
        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 2, // karyawan = 2
            'email_verified_at' => Carbon::now(),
        ]);

        // PKL user
        User::create([
            'name' => 'PKL',
            'email' => 'pkl@gmail.com',
            'password' => bcrypt('password'),
            'role' => 3, // pkl = 3
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
