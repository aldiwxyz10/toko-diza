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
        User::create(['name' => 'Admin Toko',    'email' => 'admin@tokoplastik.com', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::create(['name' => 'Budi Santoso',  'email' => 'budi@tokoplastik.com',  'password' => Hash::make('password'), 'role' => 'user']);
        User::create(['name' => 'Siti Rahayu',   'email' => 'siti@tokoplastik.com',  'password' => Hash::make('password'), 'role' => 'user']);

        $barangs = [
            ['kode_barang' => 'BRG-001', 'nama_barang' => 'Kantong Plastik HD 24x37',  'jenis' => 'Kantong Plastik', 'stok' => 150, 'harga' => 25000],
            ['kode_barang' => 'BRG-002', 'nama_barang' => 'Kantong Plastik HD 30x50',  'jenis' => 'Kantong Plastik', 'stok' => 80,  'harga' => 45000],
            ['kode_barang' => 'BRG-003', 'nama_barang' => 'Plastik Wrap 30cm x 100m',  'jenis' => 'Plastik Wrap',    'stok' => 5,   'harga' => 35000],
            ['kode_barang' => 'BRG-004', 'nama_barang' => 'Plastik Vacuum 20x30',       'jenis' => 'Plastik Vacuum',  'stok' => 0,   'harga' => 55000],
            ['kode_barang' => 'BRG-005', 'nama_barang' => 'Sedotan Plastik Bening',     'jenis' => 'Sedotan',         'stok' => 200, 'harga' => 8000],
            ['kode_barang' => 'BRG-006', 'nama_barang' => 'Plastik Bening OPP 30x40',   'jenis' => 'Plastik OPP',    'stok' => 3,   'harga' => 30000],
            ['kode_barang' => 'BRG-007', 'nama_barang' => 'Tali Rafia Merah',            'jenis' => 'Tali',            'stok' => 50,  'harga' => 12000],
            ['kode_barang' => 'BRG-008', 'nama_barang' => 'Plastik Bubble Wrap 50m',    'jenis' => 'Bubble Wrap',     'stok' => 15,  'harga' => 120000],
        ];

        foreach ($barangs as $b) Barang::create($b);
    }
}
