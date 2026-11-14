@extends('layouts.pelanggan')
@section('title', 'Pembayaran')

@section('content')
    <h3 class="fw-bold mb-1">Tagihan & Pembayaran</h3>
    <p class="text-muted mb-4">Rincian tagihan pesanan laundry Anda.</p>

    <div class="card-pink p-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-uppercase text-muted">
                        <th>Kode Pesanan</th>
                        <th>Diskon</th>
                        <th>Total Tagihan</th>
                        <th>Status Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $item)
                        <tr>
                            <td class="fw-bold text-pink">{{ $item->kode_pesanan }}</td>
                            <td>Rp {{ number_format($item->diskon ?? 0, 0, ',', '.') }}</td>
                            <td class="fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-pink-soft text-pink px-3 py-2">{{ ucfirst($item->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data tagihan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection