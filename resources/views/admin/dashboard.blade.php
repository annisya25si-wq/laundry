@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Selamat Datang, admin')
@section('page_subtitle', 'Kelola layanan, pengguna, dan pesanan laundry.')

@section('content')
    <!-- 4 Kartu Statistik Sesuai Proposal -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="eclat-card d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="fw-bold mb-1">4</h3>
                    <span class="text-muted small fw-semibold">Total Pesanan</span>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #FFE8F0; color: #FF6B9D;">
                    <i class="bi bi-bag-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="eclat-card d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="fw-bold mb-1">5</h3>
                    <span class="text-muted small fw-semibold">Total Pelanggan</span>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #FFE8F0; color: #FF6B9D;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="eclat-card d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="fw-bold mb-1">4</h3>
                    <span class="text-muted small fw-semibold">Total Layanan</span>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #FFE8F0; color: #FF6B9D;">
                    <i class="bi bi-stars"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="eclat-card d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="fw-bold mb-1">2</h3>
                    <span class="text-muted small fw-semibold">Voucher Aktif</span>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #FFE8F0; color: #FF6B9D;">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Pesanan Terbaru -->
    <h5 class="fw-bold mb-3">Pesanan terbaru</h5>

    <div class="d-flex flex-column gap-3">
        <div class="eclat-card d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-1">#7 Rania</h6>
                <span class="text-muted small">Cuci Express · Rp 20.000</span>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background: #FEF3C7; color: #B45309; font-weight: 700;">Menunggu</span>
        </div>

        <div class="eclat-card d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-1">#6 Rania</h6>
                <span class="text-muted small">Setrika · Rp 25.000</span>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background: #EDE9FE; color: #6D28D9; font-weight: 700;">Diproses</span>
        </div>
    </div>
@endsection