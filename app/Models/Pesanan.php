<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'user_id',
        'voucher_id',
        'tanggal_pesan',
        'status_pesanan',
        'subtotal',
        'diskon',
        'total_harga',
        'catatan',
        'foto_cucian',
    ];

    protected $casts = [
        'foto_cucian' => 'array',
        'tanggal_pesan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function layanan()
    {
    return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function pembayaran()
    {
    return $this->hasOne(Pembayaran::class, 'pesanan_id')->latestOfMany();
    }
}