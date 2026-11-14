<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPesanan = Pesanan::count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalLayanan = Layanan::count();
        $voucherAktif = Voucher::where('status', 'aktif')->count();

        $pesananTerbaru = Pesanan::with(['user', 'detailPesanan.layanan'])
            ->latest()
            ->take(8)
            ->get();

        // Data grafik 7 hari terakhir
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D');
            $chartData[] = (int) Pesanan::whereDate('created_at', $date->toDateString())->sum('total_harga');
        }

        return view('admin.dashboard', compact(
            'totalPesanan',
            'totalPelanggan',
            'totalLayanan',
            'voucherAktif',
            'pesananTerbaru',
            'chartLabels',
            'chartData'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu,diproses,dicuci,disetrika,selesai',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan,
        ]);

        return back()->with('success', "Status pesanan {$pesanan->kode_pesanan} diperbarui menjadi " . ucfirst($request->status_pesanan) . ".");
    }
}