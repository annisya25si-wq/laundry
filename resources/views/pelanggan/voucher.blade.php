@extends('layouts.pelanggan')
@section('title', 'Voucher Promo')

@section('content')
    <h3 class="fw-bold mb-1">Voucher Promo Tersedia</h3>
    <p class="text-muted mb-4">Gunakan kode promo di bawah ini saat membuat pesanan baru.</p>

    <div class="row g-4">
        @forelse($vouchers as $v)
            <div class="col-md-4">
                <div class="card-pink p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-pink-soft text-pink px-3 py-2 mb-3 fw-bold fs-6">{{ $v->kode_voucher }}</span>
                        <h5 class="fw-bold">{{ $v->nama_voucher ?? 'Promo Spesial Éclat' }}</h5>
                        <p class="small text-muted">
                            Min. transaksi Rp {{ number_format($v->minimal_transaksi ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-pink w-100 mt-2">Pakai Voucher</a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-pink p-5 text-center text-muted">Belum ada voucher promo aktif saat ini.</div>
            </div>
        @endforelse
    </div>
@endsection