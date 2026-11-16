@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Filter Status & Pencarian -->
<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-12 col-lg-8">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.pesanan.index') }}"
                       class="btn btn-sm rounded-pill px-3 {{ !$status ? 'text-white fw-semibold' : 'btn-outline-secondary' }}"
                       style="{{ !$status ? 'background-color: #e83e8c; border-color: #e83e8c;' : '' }}">
                        Semua <span class="badge bg-white text-dark ms-1">{{ $counts['semua'] }}</span>
                    </a>
                    <a href="{{ route('admin.pesanan.index', ['status' => 'menunggu']) }}"
                       class="btn btn-sm rounded-pill px-3 {{ $status === 'menunggu' ? 'btn-warning text-dark fw-semibold' : 'btn-outline-warning text-dark' }}">
                        Menunggu <span class="badge bg-dark text-white ms-1">{{ $counts['menunggu'] }}</span>
                    </a>
                    <a href="{{ route('admin.pesanan.index', ['status' => 'diproses']) }}"
                       class="btn btn-sm rounded-pill px-3 {{ $status === 'diproses' ? 'btn-info text-white fw-semibold' : 'btn-outline-info' }}">
                        Diproses <span class="badge bg-white text-dark ms-1">{{ $counts['diproses'] }}</span>
                    </a>
                    <a href="{{ route('admin.pesanan.index', ['status' => 'selesai']) }}"
                       class="btn btn-sm rounded-pill px-3 {{ $status === 'selesai' ? 'btn-success text-white fw-semibold' : 'btn-outline-success' }}">
                        Selesai <span class="badge bg-white text-dark ms-1">{{ $counts['selesai'] }}</span>
                    </a>
                    <a href="{{ route('admin.pesanan.index', ['status' => 'diambil']) }}"
                       class="btn btn-sm rounded-pill px-3 {{ $status === 'diambil' ? 'btn-secondary text-white fw-semibold' : 'btn-outline-secondary' }}">
                        Diambil <span class="badge bg-white text-dark ms-1">{{ $counts['diambil'] }}</span>
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <form action="{{ route('admin.pesanan.index') }}" method="GET" class="d-flex gap-2">
                    @if($status)
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    <input type="text" name="search" class="form-control form-control-sm rounded-pill px-3"
                           placeholder="Cari kode pesanan / pelanggan..." value="{{ $search }}">
                    <button type="submit" class="btn btn-sm text-white rounded-pill px-3" style="background-color: #1e2235;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Daftar Pesanan -->
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #1e2235; color: #ffffff;">
                    <tr>
                        <th class="ps-4 py-3">Kode Pesanan</th>
                        <th class="py-3">Pelanggan</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Total Harga</th>
                        <th class="py-3">Status Cucian</th>
                        <th class="pe-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pesanans->count() > 0)
                        @foreach($pesanans as $item)
                            <tr>
                                <td class="ps-4 fw-bold" style="color: #e83e8c;">
                                    {{ $item->kode_pesanan }}
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->user->name ?? 'Pelanggan Dihapus' }}</div>
                                    <small class="text-muted">{{ $item->user->email ?? '-' }}</small>
                                </td>
                                <td>
                                    <div>{{ $item->tanggal_pesan ? $item->tanggal_pesan->format('d M Y') : '-' }}</div>
                                    <small class="text-muted">{{ $item->tanggal_pesan ? $item->tanggal_pesan->format('H:i') : '' }} WIB</small>
                                </td>
                                <td>
                                    <div class="fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                                    @if($item->diskon > 0)
                                        <small class="text-success">Diskon: -Rp {{ number_format($item->diskon, 0, ',', '.') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.pesanan.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_pesanan" onchange="this.form.submit()"
                                                class="form-select form-select-sm rounded-pill fw-semibold"
                                                style="width: 140px;">
                                            <option value="menunggu" {{ $item->status_pesanan === 'menunggu' ? 'selected' : '' }}>🟡 Menunggu</option>
                                            <option value="diproses" {{ $item->status_pesanan === 'diproses' ? 'selected' : '' }}>🔵 Diproses</option>
                                            <option value="selesai"  {{ $item->status_pesanan === 'selesai'  ? 'selected' : '' }}>🟢 Selesai</option>
                                            <option value="diambil"  {{ $item->status_pesanan === 'diambil'  ? 'selected' : '' }}>⚪ Diambil</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="pe-4 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>

                                    <form action="{{ route('admin.pesanan.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pesanan {{ $item->kode_pesanan }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Detail Pesanan -->
                            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4">
                                        <div class="modal-header text-white rounded-top-4" style="background-color: #1e2235;">
                                            <h5 class="modal-title text-white">Detail Pesanan: {{ $item->kode_pesanan }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted small">Nama Pelanggan</p>
                                                    <p class="fw-bold">{{ $item->user->name ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted small">Catatan Pelanggan</p>
                                                    <p class="fw-semibold">{{ $item->catatan ?: 'Tidak ada catatan' }}</p>
                                                </div>
                                            </div>

                                            <h6 class="fw-bold mb-2">Rincian Layanan</h6>
                                            <div class="table-responsive mb-3">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Layanan</th>
                                                            <th class="text-center">Berat / Jumlah</th>
                                                            <th class="text-end">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($item->detailPesanan->count() > 0)
                                                            @foreach($item->detailPesanan as $detail)
                                                                <tr>
                                                                    <td>{{ $detail->layanan->nama_layanan ?? 'Layanan' }}</td>
                                                                    <td class="text-center">{{ $detail->berat }} kg</td>
                                                                    <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" class="text-center text-muted">Belum ada rincian item layanan.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2" class="text-end">Subtotal</th>
                                                            <th class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2" class="text-end">Diskon {{ $item->voucher ? '(' . $item->voucher->kode_voucher . ')' : '' }}</th>
                                                            <th class="text-end text-success">- Rp {{ number_format($item->diskon, 0, ',', '.') }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2" class="text-end">Total Akhir</th>
                                                            <th class="text-end" style="color: #e83e8c;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            @if(!empty($item->foto_cucian) && is_array($item->foto_cucian))
                                                <h6 class="fw-bold mb-2">Foto Cucian</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($item->foto_cucian as $foto)
                                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto Cucian"
                                                                 class="rounded-3 border" style="width: 100px; height: 100px; object-fit: cover;">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data pesanan masuk.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @if($pesanans->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $pesanans->links() }}
        </div>
    @endif
</div>
@endsection