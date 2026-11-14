@extends('layouts.pelanggan')
@section('title', 'Status Laundry')

@section('content')
    <h3 class="fw-bold mb-1">Status Laundry Aktif</h3>
    <p class="text-muted mb-4">Pantau progres cucian Anda secara real-time.</p>

    <div class="row g-4">
        @forelse($pesanans as $item)
            <div class="col-md-6">
                <div class="card-pink p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-pink-soft text-pink px-3 py-2 fw-bold">{{ $item->kode_pesanan }}</span>
                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3 py-2">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <p class="small text-muted mb-2">Dibuat pada: {{ $item->created_at->format('d M Y, H:i') }}</p>
                    <h5 class="fw-bold mb-0">Total: Rp {{ number_format($item->total_harga, 0, ',', '.') }}</h5>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-pink p-5 text-center text-muted">
                    Tidak ada cucian yang sedang diproses saat ini.
                </div>
            </div>
        @endforelse
    </div>
@endsection