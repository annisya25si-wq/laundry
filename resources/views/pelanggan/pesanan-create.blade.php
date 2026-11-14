@extends('layouts.pelanggan')
@section('title', 'Buat Pesanan Laundry')

@section('content')
<div class="mb-4">
    <span class="badge bg-pink-soft text-pink px-3 py-2 rounded-pill fw-semibold mb-2">Online Booking</span>
    <h3 class="fw-bold mb-1">Buat Pesanan Laundry</h3>
    <p class="text-muted mb-0">Lengkapi detail cucian Anda untuk mendapatkan kode pesanan instan.</p>
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
        <!-- Kolom Kiri: Form Isian -->
        <div class="col-lg-7">
            <div class="card-pink p-4 p-md-5">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Pilih Layanan Laundry</label>
                    <select name="layanan_id" id="layanan_id" class="form-select form-select-lg rounded-3" required>
                        <option value="" data-harga="0" data-satuan="kg">-- Pilih Jenis Layanan --</option>
                        @foreach($layanans as $layanan)
                            <option value="{{ $layanan->id }}"
                                    data-harga="{{ $layanan->harga }}"
                                    data-satuan="{{ $layanan->satuan ?? 'kg' }}"
                                    {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                {{ $layanan->nama_layanan }} — Rp {{ number_format($layanan->harga, 0, ',', '.') }}/{{ $layanan->satuan ?? 'kg' }}
                            </option>
                        @endforeach
                    </select>
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
                                <button type="button"
                                        class="badge border-0 bg-pink-soft text-pink px-3 py-2 rounded-pill btn-pilih-voucher"
                                        data-kode="{{ $v->kode_voucher }}"
                                        data-tipe="{{ $v->tipe_diskon ?? 'nominal' }}"
                                        data-nilai="{{ $v->nilai_diskon }}"
                                        data-min="{{ $v->minimal_transaksi ?? 0 }}">
                                    <i class="bi bi-ticket-perforated me-1"></i> Kode: {{ $v->kode_voucher }}
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

        <!-- Kolom Kanan: Ringkasan & Estimasi Harga Real-time -->
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
                <div class="d-flex justify-content-between mb-3 text-success">
                    <span>Potongan Voucher</span>
                    <span class="fw-semibold" id="ringkasanDiskon">- Rp 0</span>
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
    const selectLayanan = document.getElementById('layanan_id');
    const inputJumlah = document.getElementById('jumlah');
    const inputVoucher = document.getElementById('kode_voucher');
    const voucherBtns = document.querySelectorAll('.btn-pilih-voucher');

    let activeVoucher = null;

    function formatRupiah(angka) {
        return 'Rp ' + Math.max(0, Math.round(angka)).toLocaleString('id-ID');
    }

    function hitungTotal() {
        const option = selectLayanan.options[selectLayanan.selectedIndex];
        const harga = parseFloat(option.dataset.harga || 0);
        const satuan = option.dataset.satuan || 'kg';
        const jumlah = parseFloat(inputJumlah.value || 0);
        const subtotal = harga * jumlah;

        let diskon = 0;
        if (activeVoucher && subtotal >= activeVoucher.min) {
            if (activeVoucher.tipe === 'persen') {
                diskon = (subtotal * activeVoucher.nilai) / 100;
            } else {
                diskon = activeVoucher.nilai;
            }
        }

        document.getElementById('labelSatuan').innerText = satuan;
        document.getElementById('ringkasanLayanan').innerText = harga > 0 ? option.text.split('—')[0].trim() : 'Belum dipilih';
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
                min: parseFloat(btn.dataset.min || 0)
            };
            hitungTotal();
        });
    });

    selectLayanan.addEventListener('change', hitungTotal);
    inputJumlah.addEventListener('input', hitungTotal);
    hitungTotal();
</script>
@endsection