<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample categories
        $kategori1 = Kategori::create([
            'nama_kategori' => 'Kantong Plastik',
        ]);

        $kategori2 = Kategori::create([
            'nama_kategori' => 'Gelas Plastik',
        ]);

        $kategori3 = Kategori::create([
            'nama_kategori' => 'Wadah Plastik',
        ]);

        $kategori4 = Kategori::create([
            'nama_kategori' => 'Pita Plastik',
        ]);

        // Create sample products
        Barang::create([
            'nama_barang' => 'Kantong Plastik Tebal 25x35',
            'id_kategori' => $kategori1->id_kategori,
            'harga' => 1500.00,
            'stok' => 100,
        ]);

        Barang::create([
            'nama_barang' => 'Kantong Plastik Mika 20x30',
            'id_kategori' => $kategori1->id_kategori,
            'harga' => 2000.00,
            'stok' => 75,
        ]);

        Barang::create([
            'nama_barang' => 'Gelas Plastik 240ml',
            'id_kategori' => $kategori2->id_kategori,
            'harga' => 3000.00,
            'stok' => 200,
        ]);

        Barang::create([
            'nama_barang' => 'Gelas Plastik 360ml',
            'id_kategori' => $kategori2->id_kategori,
            'harga' => 4500.00,
            'stok' => 150,
        ]);

        Barang::create([
            'nama_barang' => 'Wadah Plastik Bening 500ml',
            'id_kategori' => $kategori3->id_kategori,
            'harga' => 2500.00,
            'stok' => 120,
        ]);

        Barang::create([
            'nama_barang' => 'Wadah Plastik 1 Liter',
            'id_kategori' => $kategori3->id_kategori,
            'harga' => 5000.00,
            'stok' => 80,
        ]);

        Barang::create([
            'nama_barang' => 'Pita Plastik Hitam 24mm',
            'id_kategori' => $kategori4->id_kategori,
            'harga' => 8000.00,
            'stok' => 50,
        ]);

        Barang::create([
            'nama_barang' => 'Pita Plastik Coklat 18mm',
            'id_kategori' => $kategori4->id_kategori,
            'harga' => 6500.00,
            'stok' => 60,
        ]);

        // Create admin user (optional)
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
