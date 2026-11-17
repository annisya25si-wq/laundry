@extends('layouts.pelanggan')

@section('title', 'Dashboard Pelanggan')

@section('content')
    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Halo, {{ auth()->user()->name }}!</h3>
            <p class="text-muted mb-0">Pantau status cucian Anda dan tunjukkan Kode Pesanan saat ke outlet.</p>
        </div>
        <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-pink px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Booking Laundry Baru
        </a>
    </div>

    <!-- Ringkasan Status -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-pink p-4">
                <span class="text-muted small">Total Riwayat Pesanan</span>
                <h2 class="fw-bold mt-1 mb-0">{{ $pesanans->count() }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-pink p-4">
                <span class="text-muted small">Sedang Diproses / Menunggu Drop-off</span>
                <h2 class="fw-bold text-pink mt-1 mb-0">{{ $pesananAktif }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-pink p-4">
                <span class="text-muted small">Selesai & Siap Diambil</span>
                <h2 class="fw-bold text-success mt-1 mb-0">{{ $pesananSelesai }}</h2>
            </div>
        </div>
    </div>

    <!-- Daftar Pesanan -->
    <div class="card-pink p-4">
        <h5 class="fw-bold mb-3">Daftar Pesanan Saya</h5>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-uppercase text-muted">
                        <th>Kode Pesanan (Outlet)</th>
                        <th>Tanggal Booking</th>
                        <th>Total Bayar</th>
                        <th>Status Cucian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $pesanan)
                        <tr>
                            <td>
                                <span class="badge bg-pink-soft text-pink px-3 py-2 fs-6 fw-bold">
                                    {{ $pesanan->kode_pesanan ?? '#' . $pesanan->id }}
                                </span>
                                <div class="small text-muted mt-1 fw-medium">
                                    @foreach($pesanan->detailPesanan as $detail)
                                        {{ $detail->layanan->nama_layanan ?? 'Layanan' }} ({{ $detail->berat }} {{ $detail->layanan->satuan ?? 'kg' }})
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-muted small">{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                            <td class="fw-semibold">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $status = $pesanan->status_pesanan ?? $pesanan->status ?? 'menunggu';
                                    $badgeClass = match($status) {
                                        'selesai' => 'bg-success-subtle text-success',
                                        'diproses', 'dicuci' => 'bg-warning-subtle text-warning-emphasis',
                                        default => 'bg-pink-soft text-pink',
                                    };
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                Kamu belum memiliki pesanan laundry. Yuk buat pesanan pertama!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection