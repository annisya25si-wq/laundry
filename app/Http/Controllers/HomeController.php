<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Voucher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua layanan yang aktif
        $layanans = Layanan::where('status', 'aktif')->get();

        // Ambil voucher yang aktif dan belum melewati tanggal berakhir
        $vouchers = Voucher::where('status', 'aktif')
            ->get();

        return view('welcome', compact('layanans', 'vouchers'));
    }
}
