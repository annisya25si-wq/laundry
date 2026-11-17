<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat Laundry — Pakaian Bersih, Wangi & Rapi Tanpa Antre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink-primary: #FF6B9D;
            --pink-hover: #E85586;
            --pink-soft: #FFF5F8;
            --pink-border: #F8D7E3;
        }
        html {
            scroll-behavior: smooth;
        }
        section {
            scroll-margin-top: 80px;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2D3142;
            background-color: #FFFFFF;
        }
        .text-pink { color: var(--pink-primary) !important; }
        .bg-pink-soft { background-color: var(--pink-soft) !important; }
        .btn-pink {
            background-color: var(--pink-primary);
            border-color: var(--pink-primary);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 22px;
            transition: all 0.25s;
        }
        .btn-pink:hover {
            background-color: var(--pink-hover);
            border-color: var(--pink-hover);
            color: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 157, 0.28);
        }
        .btn-outline-pink {
            border: 1.5px solid var(--pink-primary);
            color: var(--pink-primary);
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 22px;
            transition: all 0.25s;
        }
        .btn-outline-pink:hover {
            background-color: var(--pink-primary);
            color: #FFFFFF;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #F5E6EC;
        }
        .navbar .nav-link {
            color: #2D3142;
            transition: color 0.2s;
        }
        .navbar .nav-link:hover {
            color: var(--pink-primary);
        }

        /* Split Hero Section (Latar Gambar Separuh Kanan) */
        .hero-section {
            position: relative;
            background: linear-gradient(180deg, #FFF5F8 0%, #FFFFFF 100%);
            min-height: 560px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        .hero-right-bg {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 50%;
            background-image: url("{{ asset('guest/assets/img/bg/bg1.jpg') }}");
            background-size: cover;
            background-position: center;
            z-index: 1;
        }
        /* Gradasi halus penyambung antara area teks kiri dan gambar kanan */
        .hero-right-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, #FFF7FA 0%, rgba(255, 247, 250, 0.45) 22%, rgba(255, 247, 250, 0) 55%);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            padding: 75px 0;
        }
        .hero-badge {
            background: #FFE3ED;
            color: var(--pink-primary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 7px 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .hero-floating-badge {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 16px 20px;
            border: 1px solid var(--pink-border);
            box-shadow: 0 15px 35px rgba(45, 49, 66, 0.12);
        }
        @media (max-width: 991.98px) {
            .hero-right-bg {
                position: relative;
                width: 100%;
                height: 340px;
            }
            .hero-right-bg::before {
                background: linear-gradient(180deg, #FFF7FA 0%, rgba(255, 247, 250, 0) 35%);
            }
            .hero-content {
                padding: 50px 0 30px;
            }
        }

        .step-card, .service-card {
            border: 1px solid var(--pink-border);
            border-radius: 20px;
            transition: all 0.25s;
            background: #FFFFFF;
            overflow: hidden;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 107, 157, 0.14);
            border-color: var(--pink-primary);
        }
        /* Foto Header Kartu Layanan */
        .service-img-box {
            position: relative;
            height: 175px;
            overflow: hidden;
            background-color: var(--pink-soft);
        }
        .service-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .service-card:hover .service-img-box img {
            transform: scale(1.06);
        }
        .service-badge-hari {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.94);
            color: var(--pink-primary);
            font-weight: 700;
            font-size: 0.78rem;
            padding: 5px 12px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }
        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #FFE8F0;
            color: var(--pink-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .gallery-img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 18px;
            border: 1px solid var(--pink-border);
            transition: transform 0.3s ease;
        }
        .gallery-img:hover {
            transform: scale(1.02);
        }
        .voucher-card {
            background: linear-gradient(135deg, #FF6B9D 0%, #E0487B 100%);
            color: #FFFFFF;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }
        .voucher-code {
            background: rgba(255, 255, 255, 0.22);
            border: 1.5px dashed #FFFFFF;
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4 text-pink" href="#beranda">
                <i class="bi bi-stars"></i> Éclat Laundry
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-lg-3 fw-medium">
                    <li class="nav-item"><a class="nav-link fw-semibold text-pink" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cara-pesan">Cara Kerja</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Daftar Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#galeri">Fasilitas Outlet</a></li>
                    <li class="nav-item"><a class="nav-link" href="#promo">Promo Voucher</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="btn btn-pink btn-sm px-3">Dashboard Admin</a>
                        @else
                            <a href="{{ url('/pelanggan/dashboard') }}" class="btn btn-pink btn-sm px-3">Dashboard Saya</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm rounded-pill px-3 text-muted">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-pink btn-sm px-3">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-pink btn-sm px-3">Daftar Akun</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section dengan Latar Gambar Separuh Kanan -->
    <section id="beranda" class="hero-section flex-column flex-lg-row">
        <div class="container hero-content">
            @if(session('success'))
                <div class="alert alert-success rounded-4 mb-4">{{ session('success') }}</div>
            @endif
            <div class="row align-items-end g-4">
                <div class="col-lg-6 pe-lg-5">
                    <div class="hero-badge mb-3">
                        <i class="bi bi-bag-check-fill"></i> Online Booking • Drop-off & Pick-up Outlet
                    </div>
                    <h1 class="display-5 fw-bold mb-3 lh-sm">
                        Pakaian Bersih, Wangi & Rapi <span class="text-pink">Tanpa Antre.</span>
                    </h1>
                    <p class="text-muted fs-6 mb-4 lh-lg">
                        Pesan layanan laundry dari rumah, tunjukkan <strong>Kode Pesanan</strong> saat menyerahkan cucian ke outlet kami, dan pantau status cucian Anda secara <em>real-time</em> sebelum datang mengambilnya.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/pelanggan/pesanan/create') }}" class="btn btn-pink">
                                Buat Pesanan Sekarang <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-pink">
                                Mulai Pesan Online <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        @endauth
                        <a href="#layanan" class="btn btn-outline-pink">Lihat Harga Layanan</a>
                    </div>
                </div>

                <!-- Badge Melayang di Sisi Kanan Bawah (Desktop) -->
                <div class="col-lg-6 d-none d-lg-block ps-lg-5">
                    <div class="hero-floating-badge d-flex align-items-center justify-content-between gap-3 mt-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">1 Mesin 1 Pelanggan</h6>
                                <small class="text-muted">Higienis, pakaian tidak tercampur & pewangi tahan lama</small>
                            </div>
                        </div>
                        <span class="badge bg-pink-soft text-pink rounded-pill px-3 py-2">Buka 07.00–21.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latar Belakang Gambar Separuh Layar Kanan -->
        <div class="hero-right-bg d-flex align-items-end p-3">
            <!-- Badge Melayang untuk Tampilan Mobile/Tablet -->
            <div class="hero-floating-badge d-flex d-lg-none align-items-center justify-content-between gap-2 w-100 position-relative z-2">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-circle">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">1 Mesin 1 Pelanggan</h6>
                        <small class="text-muted">Higienis & pewangi tahan lama</small>
                    </div>
                </div>
                <span class="badge bg-pink-soft text-pink rounded-pill px-3 py-2">07.00–21.00</span>
            </div>
        </div>
    </section>

    <!-- Cara Kerja (4 Langkah Mudah) -->
    <section id="cara-pesan" class="py-5 border-top border-bottom" style="border-color: #F5E6EC !important;">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="text-pink fw-semibold small text-uppercase">Alur Praktis di Outlet</span>
                <h2 class="fw-bold mt-1">4 Langkah Mudah Mencuci</h2>
                <p class="text-muted">Cukup booking dari rumah, antar ke outlet, dan ambil saat sudah selesai</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-circle"><i class="bi bi-phone"></i></div>
                            <span class="fw-bold text-pink fs-4 opacity-50">01</span>
                        </div>
                        <h6 class="fw-bold">Booking Layanan Online</h6>
                        <p class="text-muted small mb-0">Pilih jenis cuci, masukkan estimasi berat/item, dan klaim voucher promo.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-circle"><i class="bi bi-qr-code-scan"></i></div>
                            <span class="fw-bold text-pink fs-4 opacity-50">02</span>
                        </div>
                        <h6 class="fw-bold">Serahkan ke Outlet</h6>
                        <p class="text-muted small mb-0">Datang ke outlet Éclat Laundry dan tunjukkan Kode Pesanan Anda ke petugas.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-circle"><i class="bi bi-clock-history"></i></div>
                            <span class="fw-bold text-pink fs-4 opacity-50">03</span>
                        </div>
                        <h6 class="fw-bold">Pantau Progres Real-Time</h6>
                        <p class="text-muted small mb-0">Cek status cucian (Menunggu, Diproses, hingga Selesai) langsung dari dashboard.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card p-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-circle"><i class="bi bi-bag-heart"></i></div>
                            <span class="fw-bold text-pink fs-4 opacity-50">04</span>
                        </div>
                        <h6 class="fw-bold">Ambil Cucian Rapi</h6>
                        <p class="text-muted small mb-0">Datang ke outlet saat status sudah Selesai untuk mengambil pakaian wangi Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Layanan dengan Foto -->
    <section id="layanan" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-pink fw-semibold small text-uppercase">Katalog Layanan</span>
                <h2 class="fw-bold mt-1">Pilihan Perawatan Pakaian Terbaik</h2>
                <p class="text-muted">Harga transparan per kilogram maupun per satuan item</p>
            </div>
            @php
                // Daftar gambar layanan dari folder public/guest/assets/img/bg/
                $gambarLayanan = [
                    'guest/assets/img/bg/bg2.jpg',
                    'guest/assets/img/bg/bg15.jpg',
                    'guest/assets/img/bg/bg14.jpg',
                    'guest/assets/img/bg/bg13.jpg',
                ];
            @endphp
            <div class="row g-4">
                @forelse($layanans as $layanan)
                    @php
                        $foto = $gambarLayanan[$loop->index % count($gambarLayanan)];
                    @endphp
                    <div class="col-md-6 col-lg-3">
                        <div class="service-card h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="service-img-box">
                                    <img src="{{ asset($foto) }}" alt="{{ $layanan->nama_layanan }}">
                                </div>
                                <div class="p-4 pb-2">
                                    <h5 class="fw-bold mb-2">{{ $layanan->nama_layanan }}</h5>
                                    <p class="text-muted small mb-0">{{ $layanan->deskripsi ?? 'Pencucian higienis, pewangi premium, dan setrika uap rapi.' }}</p>
                                </div>
                            </div>
                            <div class="p-4 pt-3">
                                <div class="border-top pt-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fs-5 fw-bold text-pink">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                        <small class="text-muted">/ {{ $layanan->satuan }}</small>
                                    </div>
                                    <a href="{{ auth()->check() ? url('/pelanggan/pesanan/create') : route('register') }}" class="btn btn-sm btn-outline-pink rounded-pill px-3">
                                        Pilih
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">
                        Belum ada layanan yang tersedia saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Galeri Fasilitas & Proses Kerja -->
    <section id="galeri" class="py-5 bg-light">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="text-pink fw-semibold small text-uppercase">Standar Kualitas Kami</span>
                <h2 class="fw-bold mt-1">Bersih, Terawat & Profesional</h2>
                <p class="text-muted">Setiap pakaian ditangani dengan mesin modern dan proses penyetrikaan uap higienis</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="bg-white p-3 rounded-4 shadow-sm h-100">
                        <img src="{{ asset('guest/assets/img/bg/bg6.jpg') }}" alt="Mesin Cuci Modern" class="gallery-img mb-3">
                        <h6 class="fw-bold mb-1">Mesin Cuci & Pengering Modern</h6>
                        <small class="text-muted">Pencucian terpisah untuk menjaga warna dan serat kain tetap awet.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-3 rounded-4 shadow-sm h-100">
                        <img src="{{ asset('guest/assets/img/bg/bg3.jpg') }}" alt="Setrika Uap Rapi" class="gallery-img mb-3">
                        <h6 class="fw-bold mb-1">Setrika Uap & Lipat Presisi</h6>
                        <small class="text-muted">Bebas kusut dan aman untuk bahan kemeja, jas, maupun pakaian sehari-hari.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-3 rounded-4 shadow-sm h-100">
                        <img src="{{ asset('guest/assets/img/bg/bg11.jpg') }}" alt="Kemasan Wangi Rapi" class="gallery-img mb-3">
                        <h6 class="fw-bold mb-1">Parfum Eksklusif & Siap Pakai</h6>
                        <small class="text-muted">Dikemas rapi dan wangi segar saat Anda datang mengambilnya di outlet.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Voucher -->
    <section id="promo" class="py-5 bg-pink-soft">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-pink fw-semibold small text-uppercase">Penawaran Spesial</span>
                <h2 class="fw-bold mt-1">Voucher Diskon Pelanggan</h2>
                <p class="text-muted">Gunakan kode voucher saat membuat pesanan online untuk potongan harga langsung</p>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse($vouchers as $voucher)
                    <div class="col-md-6 col-lg-4">
                        <div class="voucher-card p-4 h-100 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-white text-pink rounded-pill px-3 py-1 fw-bold">
                                    Diskon {{ $voucher->tipe_diskon === 'persen' ? $voucher->nilai_diskon . '%' : 'Rp ' . number_format($voucher->nilai_diskon, 0, ',', '.') }}
                                </span>
                                <i class="bi bi-ticket-perforated fs-3 opacity-75"></i>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $voucher->nama_voucher }}</h5>
                            <p class="small opacity-75 mb-3">
                                Min. transaksi Rp {{ number_format($voucher->minimal_transaksi ?? 0, 0, ',', '.') }}
                                @if(!empty($voucher->berlaku_sampai))
                                    • Berlaku s/d {{ \Carbon\Carbon::parse($voucher->berlaku_sampai)->format('d M Y') }}
                                @endif
                            </p>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-white border-opacity-25">
                                <span class="small">Kode Promo:</span>
                                <span class="voucher-code">{{ $voucher->kode_voucher }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        Belum ada promo voucher aktif saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 border-top bg-white">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span class="fw-bold text-pink"><i class="bi bi-stars"></i> Éclat Laundry</span>
            <small class="text-muted">© {{ date('Y') }} Éclat Laundry — Sistem Pemesanan Laundry Online & Outlet.</small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>