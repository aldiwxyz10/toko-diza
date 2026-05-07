<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin otomatis
        \App\Models\User::factory()->create([
            'name' => 'Admin Toko Diza',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Membuat akun User/Karyawan otomatis
        User::create([
            'name' => 'Nabilah',
            'email' => 'nabilah@gmail.com',
            'password' => Hash::make('nabilah123'),
            'role' => 'user',
        ]);

    }
}
