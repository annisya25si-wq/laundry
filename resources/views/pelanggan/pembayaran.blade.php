@extends('layouts.pelanggan')

@section('title', 'Pembayaran')

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
        .method-card {
            border: 2px solid #eee;
            border-radius: 14px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .method-card:hover, .method-card.selected {
            border-color: #ff4d8d;
            background-color: #fff5f8;
        }
    </style>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Pembayaran & Tagihan</h3>
        <p class="text-muted mb-0">Kelola pembayaran cucian Anda melalui tunai di outlet atau transfer bank.</p>
    </div>

    <!-- Ringkasan Tagihan -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-pink p-4 h-100">
                <span class="text-muted small">Total Belum Dibayar</span>
                <h3 class="fw-bold text-pink mt-1 mb-0">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-pink p-4 h-100">
                <span class="text-muted small">Menunggu Verifikasi Admin</span>
                <h3 class="fw-bold text-warning mt-1 mb-0">{{ $menungguVerifikasi }} Pesanan</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-pink p-4 h-100">
                <span class="text-muted small">Total Sudah Lunas</span>
                <h3 class="fw-bold text-success mt-1 mb-0">Rp {{ number_format($totalLunas, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter Status Pembayaran -->
    <div class="d-flex flex-wrap gap-2 mb-4" id="paymentFilters">
        <button type="button" class="filter-pill active" data-filter="all">Semua Tagihan</button>
        <button type="button" class="filter-pill" data-filter="belum_bayar">Belum Bayar</button>
        <button type="button" class="filter-pill" data-filter="menunggu_verifikasi">Menunggu Verifikasi</button>
        <button type="button" class="filter-pill" data-filter="lunas">Lunas</button>
    </div>

    <!-- Tabel Daftar Pembayaran -->
    <div class="card-pink p-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-uppercase text-muted">
                        <th>Kode Pesanan</th>
                        <th>Layanan & Tanggal</th>
                        <th>Total Tagihan</th>
                        <th>Metode</th>
                        <th>Status Bayar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $pesanan)
                        @php
                            $bayar = $pesanan->pembayaran;
                            $statusBayar = $bayar->status_pembayaran ?? 'belum_bayar';
                            $metodeBayar = $bayar->metode_pembayaran ?? null;

                            [$labelBayar, $badgeBayar] = match($statusBayar) {
                                'lunas' => ['Lunas', 'bg-success-subtle text-success'],
                                'menunggu_verifikasi' => ['Menunggu Verifikasi', 'bg-warning-subtle text-warning-emphasis'],
                                default => ['Belum Bayar', 'bg-danger-subtle text-danger'],
                            };
                        @endphp
                        <tr class="payment-row" data-status="{{ $statusBayar }}">
                            <td>
                                <span class="badge bg-pink-soft text-pink px-3 py-2 fw-bold">
                                    {{ $pesanan->kode_pesanan ?? '#' . $pesanan->id }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark small">
                                    @foreach($pesanan->detailPesanan as $detail)
                                        {{ $detail->layanan->nama_layanan ?? 'Layanan' }} ({{ $detail->berat ?? $detail->jumlah }} {{ $detail->layanan->satuan ?? 'kg' }})
                                    @endforeach
                                </div>
                                <div class="text-muted small">{{ $pesanan->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="fw-bold text-dark">
                                Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($metodeBayar === 'transfer')
                                    <span class="badge bg-light text-dark border"><i class="bi bi-bank me-1"></i> Transfer Bank</span>
                                @elseif($metodeBayar === 'cash')
                                    <span class="badge bg-light text-dark border"><i class="bi bi-cash-stack me-1"></i> Cash (Outlet)</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 {{ $badgeBayar }}">
                                    {{ $labelBayar }}
                                </span>
                            </td>
                            <td class="text-end">
                                @if($statusBayar === 'belum_bayar')
                                    <button type="button"
                                            class="btn btn-pink btn-sm rounded-pill px-3 py-2 fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#bayarModal-{{ $pesanan->id }}">
                                        Bayar Sekarang
                                    </button>
                                @elseif($statusBayar === 'menunggu_verifikasi')
                                    <button type="button"
                                            class="btn btn-outline-warning btn-sm rounded-pill px-3 py-2 fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#buktiModal-{{ $pesanan->id }}">
                                        <i class="bi bi-image me-1"></i> Lihat Bukti
                                    </button>
                                @else
                                    <button type="button"
                                            class="btn btn-outline-success btn-sm rounded-pill px-3 py-2 fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#buktiModal-{{ $pesanan->id }}">
                                        <i class="bi bi-receipt me-1"></i> Struk Lunas
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Bayar Sekarang -->
                        <div class="modal fade" id="bayarModal-{{ $pesanan->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <form action="{{ route('pelanggan.pembayaran.proses', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <div>
                                                <span class="badge bg-pink-soft text-pink px-3 py-1 fw-bold mb-1">
                                                    {{ $pesanan->kode_pesanan }}
                                                </span>
                                                <h5 class="modal-title fw-bold">Pilih Metode Pembayaran</h5>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="p-3 rounded-3 bg-light d-flex justify-content-between align-items-center mb-3">
                                                <span class="text-muted small">Total yang harus dibayar</span>
                                                <span class="fw-bold fs-5 text-pink">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</span>
                                            </div>

                                            <!-- Pilihan Metode -->
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <label class="method-card w-100 text-center {{ $metodeBayar === 'cash' ? 'selected' : '' }}"
                                                           onclick="toggleMethod({{ $pesanan->id }}, 'cash', this)">
                                                        <input type="radio" name="metode_pembayaran" value="cash" class="d-none" {{ $metodeBayar === 'cash' ? 'checked' : '' }} required>
                                                        <i class="bi bi-cash-coin fs-3 text-pink d-block mb-1"></i>
                                                        <span class="fw-bold d-block small">Cash (Tunai)</span>
                                                        <span class="text-muted" style="font-size: 0.72rem;">Bayar langsung di kasir</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="method-card w-100 text-center {{ $metodeBayar === 'transfer' ? 'selected' : '' }}"
                                                           onclick="toggleMethod({{ $pesanan->id }}, 'transfer', this)">
                                                        <input type="radio" name="metode_pembayaran" value="transfer" class="d-none" {{ $metodeBayar === 'transfer' ? 'checked' : '' }} required>
                                                        <i class="bi bi-bank fs-3 text-pink d-block mb-1"></i>
                                                        <span class="fw-bold d-block small">Transfer Bank</span>
                                                        <span class="text-muted" style="font-size: 0.72rem;">Upload bukti transfer</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Info Jika Pilih Cash -->
                                            <div id="info-cash-{{ $pesanan->id }}" class="p-3 rounded-3 border bg-light small {{ $metodeBayar === 'cash' ? '' : 'd-none' }}">
                                                <i class="bi bi-info-circle-fill text-pink me-1"></i>
                                                Silakan lakukan pembayaran tunai sebesar <strong>Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</strong> kepada kasir saat mengantar (drop-off) atau mengambil cucian di outlet.
                                            </div>

                                            <!-- Info Rekening & Upload Jika Pilih Transfer -->
                                            <div id="info-transfer-{{ $pesanan->id }}" class="{{ $metodeBayar === 'transfer' ? '' : 'd-none' }}">
                                                <div class="p-3 rounded-3 border border-pink bg-pink-soft mb-3">
                                                    <div class="small text-muted mb-1">Transfer ke Rekening Resmi Outlet:</div>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <strong class="d-block text-dark">Bank BCA — 1234 5678 90</strong>
                                                            <span class="small text-muted">a.n. Éclat Laundry Indonesia</span>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" onclick="copyRekening('1234567890', this)">
                                                            Salin
                                                        </button>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                                        <div>
                                                            <strong class="d-block text-dark">Bank Mandiri — 0987 6543 21</strong>
                                                            <span class="small text-muted">a.n. Éclat Laundry Indonesia</span>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" onclick="copyRekening('0987654321', this)">
                                                            Salin
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label small fw-bold">Upload Bukti Transfer (JPG/PNG, Maks 2MB)</label>
                                                    <input type="file" name="bukti_pembayaran" id="file-transfer-{{ $pesanan->id }}" class="form-control rounded-3" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="submit" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold">
                                                Konfirmasi Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Lihat Bukti / Struk -->
                        <div class="modal fade" id="buktiModal-{{ $pesanan->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Detail Pembayaran ({{ $pesanan->kode_pesanan }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body small">
                                        <div class="p-3 rounded-3 bg-light mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="text-muted">Status Pembayaran</span>
                                                <span class="fw-bold">{{ $labelBayar }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="text-muted">Metode</span>
                                                <span class="fw-semibold text-uppercase">{{ $metodeBayar ?? '-' }}</span>
                                            </div>
                                            @if($bayar && $bayar->tanggal_pembayaran)
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">Waktu Konfirmasi</span>
                                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($bayar->tanggal_pembayaran)->format('d M Y, H:i') }}</span>
                                                </div>
                                            @endif
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Total Dibayar</span>
                                                <span class="fw-bold text-pink">Rp {{ number_format($bayar->jumlah ?? $pesanan->total_harga ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        </div>

                                        @if($bayar && $bayar->bukti_pembayaran)
                                            <div class="text-center">
                                                <p class="text-muted mb-2 fw-semibold">Bukti Transfer Terunggah:</p>
                                                <img src="{{ asset('storage/' . $bayar->bukti_pembayaran) }}" alt="Bukti Transfer" class="img-fluid rounded-3 border" style="max-height: 320px;">
                                            </div>
                                        @else
                                            <div class="text-center text-muted py-3">
                                                <i class="bi bi-check-circle text-success fs-2 d-block mb-1"></i>
                                                Pembayaran tunai telah dikonfirmasi lunas oleh kasir outlet.
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
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Belum ada tagihan pembayaran saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleMethod(orderId, method, element) {
            const modal = document.getElementById('bayarModal-' + orderId);
            modal.querySelectorAll('.method-card').forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');

            const infoCash = document.getElementById('info-cash-' + orderId);
            const infoTransfer = document.getElementById('info-transfer-' + orderId);
            const fileInput = document.getElementById('file-transfer-' + orderId);

            if (method === 'transfer') {
                infoTransfer.classList.remove('d-none');
                infoCash.classList.add('d-none');
                fileInput.setAttribute('required', 'required');
            } else {
                infoCash.classList.remove('d-none');
                infoTransfer.classList.add('d-none');
                fileInput.removeAttribute('required');
            }
        }

        function copyRekening(nomor, btn) {
            navigator.clipboard.writeText(nomor);
            const originalText = btn.innerText;
            btn.innerText = 'Tersalin!';
            setTimeout(() => btn.innerText = originalText, 1500);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('#paymentFilters .filter-pill');
            const rows = document.querySelectorAll('.payment-row');

            filterButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    filterButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const selected = this.getAttribute('data-filter');
                    rows.forEach(row => {
                        if (selected === 'all' || row.getAttribute('data-status') === selected) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection