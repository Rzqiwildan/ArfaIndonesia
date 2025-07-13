<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Menggunakan model User standar Laravel
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ArfaIndonesia',
            'email' => 'arfatransportasi@gmail.com',  // Ganti dengan email admin Anda
            'password' => Hash::make('Perhatian01'),  // Ganti dengan password yang aman
        ]);
    }
}