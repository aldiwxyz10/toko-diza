<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['kode_barang', 'nama_barang', 'jenis', 'stok', 'harga'];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok'  => 'integer',
    ];

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }

    public function requestStocks()
    {
        return $this->hasMany(RequestStock::class, 'barang_id');
    }

    public function getStatusStokAttribute(): string
    {
        if ($this->stok === 0)      return 'habis';
        if ($this->stok <= 5)       return 'menipis';
        return 'tersedia';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status_stok) {
            'habis'    => 'danger',
            'menipis'  => 'warning',
            'tersedia' => 'success',
            default    => 'secondary',
        };
    }
}