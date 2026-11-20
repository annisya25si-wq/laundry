@extends('layouts.pelanggan')

@section('title', 'Status Laundry')

@section('content')
    <style>
        .filter-pill {
            border-radius: 50px;
            padding: 8px 18px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid #f3d1dc;
            background: #fff;
            color: #6c757d;
            transition: all 0.2s;
            cursor: pointer;
        }
        .filter-pill:hover, .filter-pill.active {
            background: #ff4d8d;
            color: #fff;
            border-color: #ff4d8d;
        }
        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 1.25rem 0;
        }
        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            text-align: center;
            z-index: 1;
        }
        .stepper-item::before {
            position: absolute;
            content: "";
            border-bottom: 3px solid #e9ecef;
            width: 100%;
            top: 15px;
            left: -50%;
            z-index: -1;
        }
        .stepper-item:first-child::before {
            content: none;
        }
        .stepper-item.completed::before {
            border-color: #ff4d8d;
        }
        .step-counter {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            color: #adb5bd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .stepper-item.completed .step-counter {
            background: #ff4d8d;
            border-color: #ff4d8d;
            color: #fff;
        }
        .stepper-item.active .step-counter {
            background: #fff0f5;
            border-color: #ff4d8d;
            color: #ff4d8d;
            box-shadow: 0 0 0 4px rgba(255, 77, 141, 0.15);
        }
        .step-name {
            font-size: 0.72rem;
            color: #6c757d;
            font-weight: 500;
            line-height: 1.2;
        }
        .stepper-item.completed .step-name,
        .stepper-item.active .step-name {
            color: #212529;
            font-weight: 600;
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Status Laundry Aktif</h3>
            <p class="text-muted mb-0">Pantau progres cucian Anda secara real-time.</p>
        </div>
        <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-pink px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Booking Laundry Baru
        </a>
    </div>

    <!-- Filter Status -->
    <div class="d-flex flex-wrap gap-2 mb-4" id="statusFilters">
        <button type="button" class="filter-pill active" data-filter="all">Semua Status</button>
        <button type="button" class="filter-pill" data-filter="menunggu">Menunggu Drop-off</button>
        <button type="button" class="filter-pill" data-filter="diproses">Sedang Diproses</button>
        <button type="button" class="filter-pill" data-filter="selesai">Siap Diambil</button>
    </div>

    <!-- Daftar Kartu Status -->
    <div class="row g-4" id="orderList">
        @forelse($pesanans as $pesanan)
            @php
                $rawStatus = strtolower($pesanan->status_pesanan ?? 'menunggu');

                // Kategori filter
                $filterCategory = match($rawStatus) {
                    'menunggu' => 'menunggu',
                    'selesai' => 'selesai',
                    default => 'diproses',
                };

                // Label & warna badge
                [$statusLabel, $badgeClass] = match($rawStatus) {
                    'menunggu' => ['Menunggu Drop-off', 'bg-pink-soft text-pink'],
                    'diproses' => ['Ditimbang & Diterima', 'bg-info-subtle text-info-emphasis'],
                    'dicuci' => ['Proses Laundry', 'bg-warning-subtle text-warning-emphasis'],
                    'disetrika' => ['Finishing / Setrika', 'bg-primary-subtle text-primary'],
                    'selesai' => ['Siap Diambil', 'bg-success-subtle text-success'],
                    default => [ucfirst($rawStatus), 'bg-pink-soft text-pink'],
                };

                // Urutan step timeline (0 = semua abu-abu saat menunggu drop-off, 1-5 = menyala sesuai progres)
                $currentStep = match($rawStatus) {
                'menunggu' => 0,
                'diproses' => 2, // Pesanan Diterima (1 - centang) & Penimbangan (2 - aktif)
                'dicuci' => 3,   // Proses Laundry aktif
                'disetrika' => 4,// Finishing aktif
                'selesai' => 6,  // Semua langkah (1 sampai 5) centang pink penuh
                default => 0,
                };

                $steps = [
                    1 => 'Pesanan Diterima',
                    2 => 'Penimbangan',
                    3 => 'Proses Laundry',
                    4 => 'Finishing',
                    5 => 'Siap Diambil',
                ];

                // Hitung estimasi selesai otomatis berdasarkan durasi layanan / nama layanan
                $firstDetail = $pesanan->detailPesanan->first();
                $namaLayanan = strtolower($firstDetail->layanan->nama_layanan ?? '');
                $durasiJam = $firstDetail->layanan->estimasi_jam ?? (str_contains($namaLayanan, 'express') ? 6 : 48);
                $estimasiSelesai = \Carbon\Carbon::parse($pesanan->tanggal_pesan ?? $pesanan->created_at)->addHours($durasiJam);

                $subtotal = $pesanan->detailPesanan->sum('subtotal') ?: (($pesanan->total_harga ?? 0) + ($pesanan->diskon ?? 0));
            @endphp

            <div class="col-lg-6 order-card-item" data-status="{{ $filterCategory }}">
                <div class="card-pink p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Header Kartu: Kode & Badge -->
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <div>
                                <span class="badge bg-pink-soft text-pink px-3 py-2 fs-6 fw-bold">
                                    {{ $pesanan->kode_pesanan ?? '#' . $pesanan->id }}
                                </span>
                                <div class="text-muted small mt-2">
                                    <i class="bi bi-calendar3 me-1"></i> Dibuat: {{ $pesanan->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 fw-semibold {{ $badgeClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <!-- Ringkasan Layanan -->
                        <div class="bg-light rounded-3 p-3 my-3">
                            @foreach($pesanan->detailPesanan as $detail)
                                <div class="d-flex justify-content-between align-items-center small {{ !$loop->last ? 'mb-1' : '' }}">
                                    <span class="fw-semibold text-dark">{{ $detail->layanan->nama_layanan ?? 'Layanan Laundry' }}</span>
                                    <span class="text-muted">{{ $detail->berat ?? $detail->jumlah }} {{ $detail->layanan->satuan ?? 'kg' }}</span>
                                </div>
                            @endforeach
                            <hr class="my-2 opacity-10">
                            <div class="d-flex justify-content-between align-items-center small">
                                <span class="text-muted"><i class="bi bi-clock me-1"></i> Estimasi Selesai:</span>
                                <span class="fw-semibold text-dark">{{ $estimasiSelesai->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <!-- Timeline Progres -->
                        <div class="stepper-wrapper">
                            @foreach($steps as $stepNum => $stepLabel)
                                @php
                                    $stepClass = '';
                                    if ($stepNum < $currentStep) {
                                        $stepClass = 'completed';
                                    } elseif ($stepNum === $currentStep) {
                                        $stepClass = 'active';
                                    }
                                @endphp
                                <div class="stepper-item {{ $stepClass }}">
                                    <div class="step-counter">
                                        @if($stepNum < $currentStep)
                                            <i class="bi bi-check-lg"></i>
                                        @else
                                            {{ $stepNum }}
                                        @endif
                                    </div>
                                    <div class="step-name">{{ $stepLabel }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Footer Kartu: Total & Tombol Popup Detail -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-2">
                        <div>
                            <span class="text-muted small d-block">Total Pembayaran</span>
                            <span class="fw-bold fs-5 text-dark">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <button type="button"
                                class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal-{{ $pesanan->id }}">
                            <i class="bi bi-receipt me-1"></i> Lihat Detail Pesanan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Popup Detail Pesanan -->
            <div class="modal fade" id="detailModal-{{ $pesanan->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <div class="modal-header border-bottom-0 pb-0">
                            <div>
                                <span class="badge bg-pink-soft text-pink px-3 py-1 fw-bold mb-1">
                                    {{ $pesanan->kode_pesanan ?? '#' . $pesanan->id }}
                                </span>
                                <h5 class="modal-title fw-bold">Detail Pesanan Laundry</h5>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Info Waktu & Status -->
                            <div class="p-3 rounded-3 bg-light mb-3 small">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Tanggal Booking</span>
                                    <span class="fw-semibold">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Estimasi Selesai</span>
                                    <span class="fw-semibold text-pink">{{ $estimasiSelesai->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Status Saat Ini</span>
                                    <span class="fw-bold">{{ $statusLabel }}</span>
                                </div>
                            </div>

                            <!-- Rincian Layanan & Berat -->
                            <h6 class="fw-bold small text-uppercase text-muted mb-2">Rincian Layanan</h6>
                            <div class="border rounded-3 p-3 mb-3">
                                @foreach($pesanan->detailPesanan as $detail)
                                    @php
                                        $satuan = $detail->layanan->satuan ?? 'kg';
                                        $beratEstimasi = $detail->jumlah ?? $detail->berat;
                                        $beratAktual = $detail->berat_aktual ?? $detail->berat;
                                    @endphp
                                    <div class="{{ !$loop->last ? 'border-bottom pb-2 mb-2' : '' }}">
                                        <div class="d-flex justify-content-between fw-semibold">
                                            <span>{{ $detail->layanan->nama_layanan ?? 'Layanan' }}</span>
                                            <span>Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="small text-muted mt-1">
                                            Harga satuan: Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }} / {{ $satuan }}
                                        </div>
                                        <div class="d-flex gap-3 small mt-1">
                                            <span class="text-muted">Berat Estimasi: <strong class="text-dark">{{ $beratEstimasi }} {{ $satuan }}</strong></span>
                                            <span class="text-muted">Berat Aktual:
                                                <strong class="{{ $rawStatus === 'menunggu' ? 'text-warning' : 'text-success' }}">
                                                    {{ $rawStatus === 'menunggu' ? 'Menunggu timbang' : $beratAktual . ' ' . $satuan }}
                                                </strong>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Rincian Pembayaran -->
                            <h6 class="fw-bold small text-uppercase text-muted mb-2">Informasi Pembayaran</h6>
                            <div class="border rounded-3 p-3 small">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Subtotal</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">
                                        Diskon Voucher
                                        @if($pesanan->voucher)
                                            <span class="badge bg-pink-soft text-pink ms-1">{{ $pesanan->voucher->kode_voucher }}</span>
                                        @endif
                                    </span>
                                    <span class="text-success">- Rp {{ number_format($pesanan->diskon ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2 fw-bold fs-6">
                                    <span>Total Pembayaran</span>
                                    <span class="text-pink">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if($pesanan->catatan)
                                <div class="mt-3 small text-muted">
                                    <strong>Catatan:</strong> {{ $pesanan->catatan }}
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer border-top-0 pt-0">
                            <button type="button" class="btn btn-pink w-100 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-pink p-5 text-center text-muted">
                    <i class="bi bi-basket2 fs-1 text-pink mb-2 d-block"></i>
                    Belum ada cucian aktif saat ini. Yuk buat pesanan baru!
                </div>
            </div>
        @endforelse
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('#statusFilters .filter-pill');
            const cards = document.querySelectorAll('.order-card-item');

            filterButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    filterButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const selected = this.getAttribute('data-filter');
                    cards.forEach(card => {
                        if (selected === 'all' || card.getAttribute('data-status') === selected) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection