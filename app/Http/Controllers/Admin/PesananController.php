<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Pesanan::with(['user', 'voucher', 'detailPesanan.layanan'])
            ->latest('tanggal_pesan');

        if ($status && in_array($status, ['menunggu', 'diproses', 'selesai', 'diambil'])) {
            $query->where('status_pesanan', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $pesanans = $query->paginate(10)->withQueryString();

        $counts = [
            'semua'    => Pesanan::count(),
            'menunggu' => Pesanan::where('status_pesanan', 'menunggu')->count(),
            'diproses' => Pesanan::where('status_pesanan', 'diproses')->count(),
            'selesai'  => Pesanan::where('status_pesanan', 'selesai')->count(),
            'diambil'  => Pesanan::where('status_pesanan', 'diambil')->count(),
        ];

        return view('admin.pesanan.index', compact('pesanans', 'counts', 'status', 'search'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu,diproses,selesai,diambil',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan,
        ]);

        return back()->with('success', "Status pesanan {$pesanan->kode_pesanan} berhasil diperbarui menjadi " . ucfirst($request->status_pesanan) . ".");
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $kode = $pesanan->kode_pesanan;
        $pesanan->delete();

        return back()->with('success', "Pesanan {$kode} berhasil dihapus.");
    }
}