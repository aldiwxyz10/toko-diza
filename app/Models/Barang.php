<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'nama_barang',
        'id_kategori',
        'harga',
        'stok',
        'satuan',
        'deskripsi',
    ];

    /**
     * Relasi many-to-one dengan Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relasi one-to-many dengan StokMasuk
     */
    public function stokMasuks()
    {
        return $this->hasMany(StokMasuk::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi one-to-many dengan StokKeluar
     */
    public function stokKeluars()
    {
        return $this->hasMany(StokKeluar::class, 'id_barang', 'id_barang');
    }
}
