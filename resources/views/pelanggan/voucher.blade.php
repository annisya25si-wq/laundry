@extends('layouts.pelanggan')
@section('title', 'Voucher Saya')

@section('content')
<style>
    .voucher-claim-box {
        background: #FFFFFF;
        border: 1px solid #F8D7E3;
        border-radius: 18px;
        padding: 10px 14px 10px 22px;
        box-shadow: 0 6px 20px rgba(255, 107, 157, 0.06);
    }
    .voucher-claim-box input {
        border: none;
        outline: none;
        box-shadow: none !important;
        font-weight: 500;
        background: transparent;
    }
    .voucher-item-card {
        background: #FFFFFF;
        border: 1px solid #F8D7E3;
        border-radius: 20px;
        padding: 22px 24px;
        position: relative;
        transition: all 0.25s ease;
        box-shadow: 0 8px 24px rgba(45, 49, 66, 0.04);
    }
    .voucher-item-card:hover:not(.is-expired) {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(255, 107, 157, 0.12);
    }
    /* Garis aksen vertikal di sisi kiri kartu */
    .voucher-accent-line {
        position: absolute;
        left: 10px;
        top: 20px;
        bottom: 20px;
        width: 4px;
        border-radius: 10px;
        background-color: #FF6B9D;
    }
    .voucher-item-card.is-expired {
        background-color: #FAFAFB;
        border-color: #E5E7EB;
        opacity: 0.72;
        box-shadow: none;
    }
    .voucher-item-card.is-expired .voucher-accent-line {
        background-color: #9CA3AF;
    }
    .badge-status-aktif {
        background-color: #DCFCE7;
        color: #15803D;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 4px 12px;
        border-radius: 50px;
    }
    .badge-status-expired {
        background-color: #FEE2E2;
        color: #B91C1C;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 4px 12px;
        border-radius: 50px;
    }
    .btn-gunakan-aktif {
        background-color: #FF6B9D;
        border: 1.5px solid #FF6B9D;
        color: #FFFFFF;
        font-weight: 600;
        border-radius: 50px;
        padding: 8px 24px;
        font-size: 0.88rem;
        transition: all 0.2s;
    }
    .btn-gunakan-aktif:hover {
        background-color: #E85586;
        border-color: #E85586;
        color: #FFFFFF;
    }
    .btn-gunakan-disabled {
        background-color: #FFFFFF;
        border: 1.5px solid #F8B4CD;
        color: #F472B6;
        font-weight: 600;
        border-radius: 50px;
        padding: 8px 24px;
        font-size: 0.88rem;
        cursor: not-allowed;
        opacity: 0.85;
    }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Voucher Saya</h3>
        <p class="text-muted mb-0">Voucher aktif yang bisa kamu klaim dan pakai untuk potongan harga cucian.</p>
    </div>

    <!-- Form Klaim Kode Voucher -->
    <form action="{{ route('pelanggan.voucher.klaim') }}" method="POST" class="w-100" style="max-width: 440px;">
        @csrf
        <div class="voucher-claim-box d-flex align-items-center justify-content-between gap-2">
            <input type="text" name="kode_voucher" class="form-control text-uppercase"
                   placeholder="Masukkan kode voucher" value="{{ old('kode_voucher') }}" required>
            <button type="submit" class="btn text-pink fw-bold px-3 border-0 bg-transparent">
                Klaim
            </button>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->has('kode_voucher'))
    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first('kode_voucher') }}
    </div>
@endif

<div class="row g-4">
    @forelse($vouchers as $v)
        @php
            $isExpired = $v->status !== 'aktif'
                || (!empty($v->tanggal_berakhir) && \Carbon\Carbon::parse($v->tanggal_berakhir)->endOfDay()->lt(now()))
                || (isset($v->kuota) && ($v->kuota - ($v->kuota_terpakai ?? 0)) <= 0);

            $minBerat = $v->min_berat ?? 3;
            $sisaKuota = max(0, ($v->kuota ?? 0) - ($v->kuota_terpakai ?? 0));

            // Jika pelanggan punya cucian aktif tapi beratnya di bawah syarat minimal voucher
            $belumMemenuhiSyarat = !$isExpired
                && !is_null($beratCucianSaatIni)
                && $beratCucianSaatIni > 0
                && $beratCucianSaatIni < $minBerat;
        @endphp

        <div class="col-lg-6">
            <div class="voucher-item-card h-100 d-flex flex-column justify-content-between ps-4 {{ $isExpired ? 'is-expired' : '' }}">
                <div class="voucher-accent-line"></div>

                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="fw-bold fs-5 {{ $isExpired ? 'text-secondary' : 'text-pink' }}" style="letter-spacing: 0.5px;">
                                {{ $v->kode_voucher }}
                            </span>
                            @if($isExpired)
                                <span class="badge-status-expired">Kedaluwarsa</span>
                            @else
                                <span class="badge-status-aktif">Aktif</span>
                            @endif
                        </div>

                        <h6 class="fw-bold mb-1 text-dark">
                            @if(($v->tipe_diskon ?? 'nominal') === 'persen')
                                Diskon {{ rtrim(rtrim(number_format($v->nilai_diskon, 2, '.', ''), '0'), '.') }}%
                            @else
                                Potongan Rp {{ number_format($v->nilai_diskon, 0, ',', '.') }}
                            @endif
                        </h6>

                        <p class="small text-muted mb-0">
                            Min. cucian {{ $minBerat }} kg
                            @if($isExpired)
                                @if(!empty($v->tanggal_berakhir))
                                    • berakhir {{ \Carbon\Carbon::parse($v->tanggal_berakhir)->format('d-m-Y') }}
                                @endif
                            @else
                                @if(!empty($v->tanggal_berakhir))
                                    • s/d {{ \Carbon\Carbon::parse($v->tanggal_berakhir)->format('d-m-Y') }}
                                @endif
                                • sisa kuota {{ $sisaKuota }}
                            @endif
                        </p>
                    </div>

                    <!-- Tombol Aksi sesuai Status -->
                    @if(!$isExpired)
                        @if($belumMemenuhiSyarat)
                            <button type="button" class="btn-gunakan-disabled flex-shrink-0" disabled>
                                Gunakan
                            </button>
                        @else
                            <a href="{{ route('pelanggan.pesanan.create', ['voucher' => $v->kode_voucher]) }}"
                               class="btn-gunakan-aktif text-decoration-none flex-shrink-0">
                                Gunakan
                            </a>
                        @endif
                    @endif
                </div>

                @if($belumMemenuhiSyarat)
                    <div class="mt-2 pt-2 border-top border-light">
                        <small class="text-muted">Tambah cucian untuk memakai voucher ini (minimal {{ $minBerat }} kg).</small>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="voucher-item-card p-5 text-center text-muted">
                <i class="bi bi-ticket-perforated fs-1 text-pink opacity-50 d-block mb-2"></i>
                Belum ada voucher yang tersedia saat ini.
            </div>
        </div>
    @endforelse
</div>
@endsection