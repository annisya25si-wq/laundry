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

            $minimalBerat = $voucher->minimal_berat ?? 3;
            if ($request->jumlah < $minimalBerat) {
                return back()->withInput()->withErrors([
                    'kode_voucher' => "Voucher {$voucher->kode_voucher} hanya berlaku untuk pemesanan minimal {$minimalBerat} kg/item."
                ]);
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
                'tanggal_pesan' => now(),
                'total_harga' => $totalHarga,
                'diskon' => $diskon,
                'status_pesanan' => 'menunggu',
                'catatan' => $request->catatan,
            ]);

            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'layanan_id' => $layanan->id,
                'berat' => $request->berat ?? $request->jumlah ?? $request->berat_cucian ?? ($subtotal / max(1, $layanan->harga)),
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
        // Mengambil seluruh voucher (aktif maupun kedaluwarsa)
        $vouchers = Voucher::orderByRaw("CASE WHEN status = 'aktif' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        // Cek berat/jumlah cucian aktif terakhir pelanggan untuk validasi syarat minimal berat
        $pesananTerakhir = Pesanan::with('detailPesanans')
            ->where('user_id', Auth::id())
            ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dicuci', 'disetrika'])
            ->latest()
            ->first();

        $beratCucianSaatIni = $pesananTerakhir
            ? $pesananTerakhir->detailPesanans->sum('jumlah')
            : null;

        return view('pelanggan.voucher', compact('vouchers', 'beratCucianSaatIni'));
    }

    public function klaimVoucher(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required|string|max:50',
        ], [
            'kode_voucher.required' => 'Masukkan kode voucher terlebih dahulu.',
        ]);

        $kode = strtoupper(trim($request->kode_voucher));
        $voucher = Voucher::where('kode_voucher', $kode)->first();

        if (!$voucher) {
            return back()->withErrors(['kode_voucher' => "Kode voucher '{$kode}' tidak ditemukan."]);
        }

        $isExpired = $voucher->status !== 'aktif'
            || (!empty($voucher->tanggal_berakhir) && \Carbon\Carbon::parse($voucher->tanggal_berakhir)->endOfDay()->lt(now()))
            || (isset($voucher->kuota) && $voucher->kuota <= 0);

        if ($isExpired) {
            return back()->withErrors(['kode_voucher' => "Voucher '{$kode}' sudah kedaluwarsa atau kuotanya telah habis."]);
        }

        $claimed = session('claimed_vouchers', []);
        if (!in_array($kode, $claimed)) {
            $claimed[] = $kode;
            session(['claimed_vouchers' => $claimed]);
        }

        return back()->with('success', "Voucher {$kode} berhasil diklaim dan siap digunakan!");
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