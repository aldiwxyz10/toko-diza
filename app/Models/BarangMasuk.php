<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';

    protected $fillable = ['barang_id', 'jumlah', 'tanggal', 'keterangan'];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'integer',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}