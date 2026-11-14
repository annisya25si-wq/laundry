<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';

    protected $fillable = [
        'kode_voucher',
        'tipe_diskon',
        'nilai_diskon',
        'min_berat',
        'tanggal_berakhir',
        'kuota',
        'kuota_terpakai',
        'status',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'voucher_id');
    }
}