<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'nama_depan' => 'Makise',
            'nama_belakang' => 'Kurisu',
            'email' => 'admin@banksampah.com',
            'password' => Hash::make('supersecret123'),
            'role' => 'admin',
        ]);

        User::factory(35)->create();
    }
}
