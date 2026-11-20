<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Layanan;
use App\Models\Pembayaran;
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

        $pesananMenunggu = $pesanans->where('status_pesanan', 'menunggu')->count();
        $pesananDiproses = $pesanans->whereIn('status_pesanan', ['diproses', 'dicuci', 'disetrika'])->count();
        $pesananSelesai = $pesanans->where('status_pesanan', 'selesai')->count();

        return view('pelanggan.dashboard', compact(
            'pesanans',
            'pesananMenunggu',
            'pesananDiproses',
            'pesananSelesai'
        ));
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
        $pesanans = Pesanan::with(['detailPesanan.layanan', 'voucher'])
            ->where('user_id', Auth::id())
            ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dicuci', 'disetrika', 'selesai'])
            ->latest()
            ->get();

        return view('pelanggan.status', compact('pesanans'));
    }

    public function pembayaran()
    {
        $pesanans = Pesanan::with(['detailPesanan.layanan', 'voucher', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $totalBelumBayar = $pesanans->filter(function ($p) {
            $status = $p->pembayaran->status_pembayaran ?? 'belum_bayar';
            return $status === 'belum_bayar';
        })->sum('total_harga');

        $menungguVerifikasi = $pesanans->filter(function ($p) {
            return ($p->pembayaran->status_pembayaran ?? '') === 'menunggu_verifikasi';
        })->count();

        $totalLunas = $pesanans->filter(function ($p) {
            return ($p->pembayaran->status_pembayaran ?? '') === 'lunas';
        })->sum('total_harga');

        return view('pelanggan.pembayaran', compact(
            'pesanans',
            'totalBelumBayar',
            'menungguVerifikasi',
            'totalLunas'
        ));
    }

    public function prosesPembayaran(Request $request, $id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'metode_pembayaran' => 'required|in:cash,transfer',
            'bukti_pembayaran' => 'required_if:metode_pembayaran,transfer|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'metode_pembayaran.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'bukti_pembayaran.required_if' => 'Harap unggah foto bukti transfer.',
            'bukti_pembayaran.image' => 'File harus berupa gambar (JPG/PNG).',
            'bukti_pembayaran.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($request->metode_pembayaran === 'transfer') {
            $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

            Pembayaran::updateOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'user_id' => Auth::id(),
                    'jumlah' => $pesanan->total_harga,
                    'metode_pembayaran' => 'transfer',
                    'status_pembayaran' => 'menunggu_verifikasi',
                    'tanggal_pembayaran' => now(),
                    'bukti_pembayaran' => $path,
                ]
            );

            return back()->with('success', 'Bukti transfer berhasil dikirim! Admin akan segera memverifikasi pembayaran Anda.');
        }

        Pembayaran::updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'user_id' => Auth::id(),
                'jumlah' => $pesanan->total_harga,
                'metode_pembayaran' => 'cash',
                'status_pembayaran' => 'belum_bayar',
                'tanggal_pembayaran' => now(),
                'bukti_pembayaran' => null,
            ]
        );

        return back()->with('success', 'Metode pembayaran Cash dipilih. Silakan bayar tunai saat di outlet.');
    }

    public function voucher()
    {
        $vouchers = Voucher::orderByRaw("CASE WHEN status = 'aktif' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        $pesananTerakhir = Pesanan::with('detailPesanan')
            ->where('user_id', Auth::id())
            ->whereIn('status_pesanan', ['menunggu', 'diproses', 'dicuci', 'disetrika'])
            ->latest()
            ->first();

        $beratCucianSaatIni = $pesananTerakhir
            ? $pesananTerakhir->detailPesanan->sum('jumlah')
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