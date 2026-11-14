@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- 4 Kartu Statistik Utama -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 mb-0">
            <div class="card-body p-4 d-flex align-items-center justify-content-between gap-3">
                <div class="stat-icon-box">
                    <i class="bi bi-basket2-fill"></i>
                </div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalPesanan }}</h2>
                    <small class="text-muted fw-medium">Total Pesanan</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 mb-0">
            <div class="card-body p-4 d-flex align-items-center justify-content-between gap-3">
                <div class="stat-icon-box">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalPelanggan }}</h2>
                    <small class="text-muted fw-medium">Total Pelanggan</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 mb-0">
            <div class="card-body p-4 d-flex align-items-center justify-content-between gap-3">
                <div class="stat-icon-box">
                    <i class="bi bi-stars"></i>
                </div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalLayanan }}</h2>
                    <small class="text-muted fw-medium">Total Layanan</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 mb-0">
            <div class="card-body p-4 d-flex align-items-center justify-content-between gap-3">
                <div class="stat-icon-box">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0 text-dark">{{ $voucherAktif }}</h2>
                    <small class="text-muted fw-medium">Voucher Aktif</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grid Bawah: Tabel Pesanan Terbaru (Kiri) & Grafik Pendapatan Mingguan (Kanan) -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                <h5 class="fw-bold mb-0 text-dark">Pesanan terbaru</h5>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead style="background-color: #F8FAFC;">
                            <tr class="text-muted small">
                                <th class="border-0 py-3">Order ID</th>
                                <th class="border-0 py-3">Pelanggan</th>
                                <th class="border-0 py-3">Layanan</th>
                                <th class="border-0 py-3">Status</th>
                                <th class="border-0 py-3">Total</th>
                                <th class="border-0 py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananTerbaru as $p)
                                @php
                                    $status = strtolower($p->status_pesanan);
                                    $badgeStyle = match($status) {
                                        'menunggu' => 'background-color: #FACC15; color: #FFFFFF;',
                                        'diproses', 'dicuci', 'disetrika' => 'background-color: #8B5CF6; color: #FFFFFF;',
                                        'selesai' => 'background-color: #10B981; color: #FFFFFF;',
                                        default => 'background-color: #64748B; color: #FFFFFF;',
                                    };
                                @endphp
                                <tr>
                                    <td class="fw-bold text-dark">#{{ $p->id }}</td>
                                    <td class="fw-medium">{{ $p->user->name ?? '-' }}</td>
                                    <td>
                                        @foreach($p->detailPesanan as $detail)
                                            <span class="d-block small">{{ $detail->layanan->nama_layanan ?? '-' }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-1 fw-semibold" style="{{ $badgeStyle }}">
                                            {{ ucfirst($p->status_pesanan) }}
                                        </span>
                                    </td>
                                    <td class="fw-semibold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.pesanan.updateStatus', $p->id) }}" method="POST" class="d-inline-flex gap-1 align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_pesanan" class="form-select form-select-sm rounded-3" style="width: 115px; font-size: 12px;">
                                                <option value="menunggu" {{ $status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="dicuci" {{ $status === 'dicuci' ? 'selected' : '' }}>Dicuci</option>
                                                <option value="disetrika" {{ $status === 'disetrika' ? 'selected' : '' }}>Disetrika</option>
                                                <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-light border rounded-3 px-2 fw-semibold" style="font-size: 12px;">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0 text-dark">Laporan Pendapatan Mingguan</h5>
            </div>
            <div class="card-body px-4 pb-4 d-flex flex-column justify-content-center">
                <canvas id="weeklyRevenueChart" height="230"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($chartData),
                backgroundColor: '#334155',
                borderRadius: 6,
                barThickness: 22
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#F1F5F9' },
                    ticks: { font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
</script>
@endpush