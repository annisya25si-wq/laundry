@extends('layouts.pelanggan')
@section('title', 'Buat Pesanan Laundry')

@section('content')
<style>
    .layanan-card {
        border: 1.5px solid var(--pink-border);
        border-radius: 14px;
        background: #FFFFFF;
        cursor: pointer;
        transition: all 0.2s ease;
        overflow: hidden;
    }
    .layanan-card:hover {
        border-color: var(--pink-primary);
        transform: translateY(-1px);
    }
    .layanan-radio:checked + .layanan-card {
        border-color: var(--pink-primary);
        background-color: var(--pink-soft);
        box-shadow: 0 4px 12px rgba(255, 107, 157, 0.15);
    }
    .layanan-thumb {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        background: linear-gradient(135deg, #FFF0F5 0%, #FFE0EC 100%);
    }
</style>

<div class="mb-4">
    <span class="badge bg-pink-soft text-pink px-3 py-2 rounded-pill fw-semibold mb-2">Online Booking</span>
    <h3 class="fw-bold mb-1">Buat Pesanan Laundry</h3>
    <p class="text-muted mb-0">Pilih jenis layanan dengan gambar dan atur perkiraan berat cucian Anda.</p>
</div>

@if($errors->any())
    <div class="alert alert-danger border-0 rounded-4 mb-4">
        <ul class="mb-0 small">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pelanggan.pesanan.store') }}" method="POST" id="formPesanan">
    @csrf
    <div class="row g-4">
        <!-- Kolom Kiri: Pilihan Layanan Bergambar & Form Isian -->
        <div class="col-lg-7">
            <div class="card-pink p-4 p-md-5">
             <div class="mb-4">
                    <label class="form-label fw-semibold mb-2">Pilih Layanan Laundry</label>
                    <div class="row g-2">
                        @foreach($layanans as $index => $layanan)
                            @php
                                $namaLower = strtolower($layanan->nama_layanan);
                                if (!empty($layanan->gambar)) {
                                    $imgUrl = asset('storage/' . $layanan->gambar);
                                } elseif (str_contains($namaLower, 'setrika')) {
                                    $imgUrl = 'https://images.unsplash.com/photo-1582735689369-4fe89db7114c?auto=format&fit=crop&w=300&q=80';
                                } elseif (str_contains($namaLower, 'express') || str_contains($namaLower, 'kilat')) {
                                   $imgUrl = asset('guest/assets/img/bg/bg15.jpg');
                                } elseif (str_contains($namaLower, 'dry') || str_contains($namaLower, 'jas')) {
                                  $imgUrl = asset('guest/assets/img/bg/bg14.jpg');
                                  } elseif (str_contains($namaLower, 'bed')) {
                                  $imgUrl = asset('guest/assets/img/bg/bg13.jpg');
                                } else {
                                    $imgUrl = $imgUrl = asset('guest/assets/img/bg/bg2.jpg');
                                }
                            @endphp
                            <div class="col-sm-6">
                                <label class="w-100 h-100 mb-0">
                                    <input type="radio"
                                           name="layanan_id"
                                           value="{{ $layanan->id }}"
                                           class="d-none layanan-radio"
                                           data-nama="{{ $layanan->nama_layanan }}"
                                           data-harga="{{ $layanan->harga }}"
                                           data-satuan="{{ $layanan->satuan ?? 'kg' }}"
                                           {{ old('layanan_id') == $layanan->id ? 'checked' : '' }}
                                           required>
                                    <div class="layanan-card h-100 p-2 d-flex align-items-center gap-2">
                                        <img src="{{ $imgUrl }}" alt="{{ $layanan->nama_layanan }}" class="layanan-thumb">
                                        <div class="overflow-hidden flex-grow-1">
                                            <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 13px;">{{ $layanan->nama_layanan }}</h6>
                                            @if(!empty($layanan->deskripsi))
                                                <p class="text-muted mb-1 text-truncate" style="font-size: 11px;">{{ $layanan->deskripsi }}</p>
                                            @endif
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="fw-bold text-pink" style="font-size: 13px;">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                                <span class="badge bg-pink-soft text-pink rounded-pill" style="font-size: 10px;">/{{ $layanan->satuan ?? 'kg' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Perkiraan Berat / Jumlah</label>
                    <div class="input-group input-group-lg">
                        <input type="number" name="jumlah" id="jumlah" class="form-control rounded-start-3"
                               value="{{ old('jumlah', 1) }}" min="1" step="0.5" required>
                        <span class="input-group-text bg-pink-soft text-pink fw-semibold rounded-end-3" id="labelSatuan">kg</span>
                    </div>
                    <small class="text-muted">Berat final akan ditimbang ulang oleh petugas saat drop-off di outlet.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Kode Voucher Promo (Opsional)</label>
                    <input type="text" name="kode_voucher" id="kode_voucher"
                           class="form-control form-control-lg rounded-3 text-uppercase"
                           placeholder="CONTOH: ECLATBARU" value="{{ old('kode_voucher') }}">

                    @if($vouchers->count() > 0)
                        <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                            <small class="text-muted">Klik promo tersedia:</small>
                            @foreach($vouchers as $v)
                                @php $minBerat = $v->minimal_berat ?? 3; @endphp
                                <button type="button"
                                        class="badge border-0 bg-pink-soft text-pink px-3 py-2 rounded-pill btn-pilih-voucher"
                                        data-kode="{{ $v->kode_voucher }}"
                                        data-tipe="{{ $v->tipe_diskon ?? 'nominal' }}"
                                        data-nilai="{{ $v->nilai_diskon }}"
                                        data-min="{{ $v->minimal_transaksi ?? 0 }}"
                                        data-minberat="{{ $minBerat }}">
                                    <i class="bi bi-ticket-perforated me-1"></i> {{ $v->kode_voucher }} (Min. {{ $minBerat }} kg)
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold">Catatan Khusus (Opsional)</label>
                    <textarea name="catatan" rows="3" class="form-control rounded-3"
                              placeholder="Contoh: Pisahkan pakaian putih, jangan pakai pelembut...">{{ old('catatan') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Ringkasan & Validasi Minimal Berat Voucher -->
        <div class="col-lg-5">
            <div class="card-pink p-4 p-md-5 sticky-top" style="top: 24px;">
                <h5 class="fw-bold mb-4"><i class="bi bi-receipt text-pink me-2"></i>Ringkasan Pesanan</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Layanan</span>
                    <span class="fw-semibold text-end" id="ringkasanLayanan">Belum dipilih</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Jumlah / Berat</span>
                    <span class="fw-semibold" id="ringkasanJumlah">1 kg</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold" id="ringkasanSubtotal">Rp 0</span>
                </div>

                <!-- Baris Potongan Voucher + Syarat Minimal Berat -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-success">Potongan Voucher</span>
                        <small class="d-block text-muted" id="infoSyaratVoucher" style="font-size: 11px;">
                            Pilih/masukkan voucher (Min. 3 kg)
                        </small>
                    </div>
                    <span class="fw-semibold text-success" id="ringkasanDiskon">- Rp 0</span>
                </div>

                <!-- Peringatan jika berat belum memenuhi syarat voucher -->
                <div id="alertMinimalBerat" class="alert alert-warning border-0 rounded-3 py-2 px-3 small d-none mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    <span id="teksMinimalBerat"></span>
                </div>

                <hr style="border-color: var(--pink-border);">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold fs-6">Estimasi Total</span>
                    <span class="fw-bold fs-4 text-pink" id="ringkasanTotal">Rp 0</span>
                </div>

                <div class="p-3 rounded-4 bg-pink-soft small text-muted mb-4">
                    <i class="bi bi-info-circle-fill text-pink me-1"></i>
                    Setelah mengirim pesanan, bawa pakaian ke outlet dan tunjukkan kode pesanan Anda kepada petugas.
                </div>

                <button type="submit" class="btn btn-pink btn-lg w-100 py-3 mb-2">
                    Konfirmasi & Dapatkan Kode Pesanan
                </button>
                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-light w-100 py-2 rounded-3 text-muted">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

<script>
    const radioLayanans = document.querySelectorAll('.layanan-radio');
    const inputJumlah = document.getElementById('jumlah');
    const inputVoucher = document.getElementById('kode_voucher');
    const voucherBtns = document.querySelectorAll('.btn-pilih-voucher');

    const alertMinimalBerat = document.getElementById('alertMinimalBerat');
    const teksMinimalBerat = document.getElementById('teksMinimalBerat');
    const infoSyaratVoucher = document.getElementById('infoSyaratVoucher');

    let activeVoucher = null;

    function formatRupiah(angka) {
        return 'Rp ' + Math.max(0, Math.round(angka)).toLocaleString('id-ID');
    }

    function hitungTotal() {
        const selected = document.querySelector('.layanan-radio:checked');
        const harga = selected ? parseFloat(selected.dataset.harga || 0) : 0;
        const satuan = selected ? (selected.dataset.satuan || 'kg') : 'kg';
        const namaLayanan = selected ? selected.dataset.nama : 'Belum dipilih';
        const jumlah = parseFloat(inputJumlah.value || 0);
        const subtotal = harga * jumlah;

        let diskon = 0;
        alertMinimalBerat.classList.add('d-none');

        if (activeVoucher) {
            const minBerat = activeVoucher.minBerat || 3;
            infoSyaratVoucher.innerText = `Kode ${activeVoucher.kode} (Syarat min. ${minBerat} ${satuan})`;

            if (jumlah < minBerat) {
                alertMinimalBerat.classList.remove('d-none');
                teksMinimalBerat.innerText = `Berat masih ${jumlah} ${satuan}. Tambah hingga minimal ${minBerat} ${satuan} untuk mengaktifkan voucher ${activeVoucher.kode}.`;
            } else if (subtotal < activeVoucher.min) {
                alertMinimalBerat.classList.remove('d-none');
                teksMinimalBerat.innerText = `Minimal transaksi untuk voucher ${activeVoucher.kode} adalah ${formatRupiah(activeVoucher.min)}.`;
            } else {
                if (activeVoucher.tipe === 'persen') {
                    diskon = (subtotal * activeVoucher.nilai) / 100;
                } else {
                    diskon = activeVoucher.nilai;
                }
            }
        } else {
            infoSyaratVoucher.innerText = 'Syarat voucher berlaku minimal 3 kg';
        }

        document.getElementById('labelSatuan').innerText = satuan;
        document.getElementById('ringkasanLayanan').innerText = namaLayanan;
        document.getElementById('ringkasanJumlah').innerText = jumlah + ' ' + satuan;
        document.getElementById('ringkasanSubtotal').innerText = formatRupiah(subtotal);
        document.getElementById('ringkasanDiskon').innerText = '- ' + formatRupiah(diskon);
        document.getElementById('ringkasanTotal').innerText = formatRupiah(subtotal - diskon);
    }

    voucherBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            inputVoucher.value = btn.dataset.kode;
            activeVoucher = {
                kode: btn.dataset.kode,
                tipe: btn.dataset.tipe,
                nilai: parseFloat(btn.dataset.nilai || 0),
                min: parseFloat(btn.dataset.min || 0),
                minBerat: parseFloat(btn.dataset.minberat || 3)
            };
            hitungTotal();
        });
    });

    inputVoucher.addEventListener('input', () => {
        const kodeKetik = inputVoucher.value.trim().toUpperCase();
        const cocok = Array.from(voucherBtns).find(b => b.dataset.kode.toUpperCase() === kodeKetik);
        if (cocok) {
            activeVoucher = {
                kode: cocok.dataset.kode,
                tipe: cocok.dataset.tipe,
                nilai: parseFloat(cocok.dataset.nilai || 0),
                min: parseFloat(cocok.dataset.min || 0),
                minBerat: parseFloat(cocok.dataset.minberat || 3)
            };
        } else {
            activeVoucher = null;
        }
        hitungTotal();
    });

    radioLayanans.forEach(radio => radio.addEventListener('change', hitungTotal));
    inputJumlah.addEventListener('input', hitungTotal);
    hitungTotal();
</script>
@endsection