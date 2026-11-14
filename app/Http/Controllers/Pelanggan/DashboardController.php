<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $pesanans = Pesanan::where('user_id', $userId)
            ->latest()
            ->get();

        $pesananAktif = $pesanans->whereIn('status_pesanan', ['menunggu', 'diproses', 'dicuci', 'disetrika'])->count();
        $pesananSelesai = $pesanans->where('status_pesanan', 'selesai')->count();

        return view('pelanggan.dashboard', compact('pesanans', 'pesananAktif', 'pesananSelesai'));
    }

    public function createPesanan()
    {
        $layanans = Layanan::where('status', 'aktif')->get();
        $vouchers = Voucher::where('status', 'aktif')->get();

        return view('pelanggan.pesanan-create', compact('layanans', 'vouchers'));
    }

    public function storePesanan(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'jumlah' => 'required|numeric|min:1',
            'kode_voucher' => 'nullable|string',
            'catatan' => 'nullable|string|max:255',
        ], [
            'layanan_id.required' => 'Silakan pilih jenis layanan terlebih dahulu.',
            'jumlah.required' => 'Masukkan perkiraan berat (kg) atau jumlah item.',
            'jumlah.min' => 'Minimal pemesanan adalah 1 kg/item.',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $subtotal = $layanan->harga * $request->jumlah;
        $diskon = 0;
        $voucherId = null;

        if ($request->filled('kode_voucher')) {
            $voucher = Voucher::where('kode_voucher', strtoupper(trim($request->kode_voucher)))
                ->where('status', 'aktif')
                ->first();

            if (!$voucher) {
                return back()->withInput()->withErrors(['kode_voucher' => 'Kode voucher tidak ditemukan atau sudah tidak aktif.']);
            }

            if ($subtotal < ($voucher->minimal_transaksi ?? 0)) {
                return back()->withInput()->withErrors([
                    'kode_voucher' => 'Minimal transaksi untuk voucher ini adalah Rp ' . number_format($voucher->minimal_transaksi, 0, ',', '.')
                ]);
            }

            $voucherId = $voucher->id;
            if (($voucher->tipe_diskon ?? 'nominal') === 'persen') {
                $diskon = ($subtotal * $voucher->nilai_diskon) / 100;
            } else {
                $diskon = $voucher->nilai_diskon;
            }
        }

        $totalHarga = max(0, $subtotal - $diskon);
        $kodePesanan = 'ECL-' . date('ymd') . '-' . strtoupper(Str::random(4));

        DB::transaction(function () use ($request, $layanan, $subtotal, $diskon, $totalHarga, $voucherId, $kodePesanan) {
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'voucher_id' => $voucherId,
                'kode_pesanan' => $kodePesanan,
                'total_harga' => $totalHarga,
                'diskon' => $diskon,
                'status_pesanan' => 'menunggu',
                'catatan' => $request->catatan,
            ]);

            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'layanan_id' => $layanan->id,
                'jumlah' => $request->jumlah,
                'harga_satuan' => $layanan->harga,
                'subtotal' => $subtotal,
            ]);
        });

        return redirect()->route('pelanggan.dashboard')
            ->with('success', 'Pesanan berhasil dibuat! Tunjukkan kode ' . $kodePesanan . ' saat drop-off cucian di outlet.');
    }

    public function statusLaundry()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dicuci', 'disetrika'])
            ->latest()
            ->get();

        return view('pelanggan.status', compact('pesanans'));
    }

    public function pembayaran()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pelanggan.pembayaran', compact('pesanans'));
    }

    public function voucher()
    {
        $vouchers = Voucher::where('status', 'aktif')->latest()->get();

        return view('pelanggan.voucher', compact('vouchers'));
    }

    public function riwayat()
    {
        $riwayats = Pesanan::where('user_id', Auth::id())
            ->where('status_pesanan', 'selesai')
            ->latest()
            ->get();

        return view('pelanggan.riwayat', compact('riwayats'));
    }
}