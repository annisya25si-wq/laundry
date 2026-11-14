@extends('layouts.pelanggan')
@section('title', 'Riwayat Transaksi')

@section('content')
    <h3 class="fw-bold mb-1">Riwayat Transaksi Selesai</h3>
    <p class="text-muted mb-4">Arsip pesanan laundry Anda yang telah selesai.</p>

    <div class="card-pink p-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-uppercase text-muted">
                        <th>Kode Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayats as $item)
                        <tr>
                            <td class="fw-bold text-pink">{{ $item->kode_pesanan }}</td>
                            <td class="text-muted small">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="fw-semibold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-success-subtle text-success px-3 py-2">Selesai</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat cucian yang selesai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection