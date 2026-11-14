<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'harga',
        'satuan',
        'deskripsi',
        'gambar',
        'status',
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'layanan_id');
    }
}