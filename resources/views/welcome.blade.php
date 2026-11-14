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
        .hero-section {
            background: linear-gradient(180deg, #FFF5F8 0%, #FFFFFF 100%);
            padding: 90px 0 70px;
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
        .step-card, .service-card {
            border: 1px solid var(--pink-border);
            border-radius: 20px;
            transition: all 0.25s;
            background: #FFFFFF;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 107, 157, 0.12);
            border-color: var(--pink-primary);
        }
        .icon-circle {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #FFE8F0;
            color: var(--pink-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
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
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4 text-pink" href="{{ route('home') }}">
                <i class="bi bi-stars"></i> Éclat Laundry
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-lg-3 fw-medium">
                    <li class="nav-item"><a class="nav-link" href="#cara-pesan">Cara Kerja</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Daftar Layanan</a></li>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success rounded-4 mb-4">{{ session('success') }}</div>
            @endif

            <div class="row align-items-center g-5">
                <div class="col-lg-6">
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

                <div class="col-lg-6">
                    <div class="p-4 p-md-5 rounded-4 bg-white shadow-sm border" style="border-color: var(--pink-border) !important;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <span class="badge bg-pink-soft text-pink px-3 py-2 rounded-pill">Alur Praktis di Outlet</span>
                                <h5 class="fw-bold mt-2 mb-0">4 Langkah Mudah Mencuci</h5>
                            </div>
                            <div class="icon-circle"><i class="bi bi-qr-code-scan"></i></div>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex gap-3 align-items-start">
                                <span class="badge rounded-circle bg-pink-soft text-pink p-2 fw-bold">1</span>
                                <div>
                                    <h6 class="fw-bold mb-0">Booking Layanan Online</h6>
                                    <small class="text-muted">Pilih jenis cuci, masukkan estimasi berat/item, dan klaim voucher promo.</small>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <span class="badge rounded-circle bg-pink-soft text-pink p-2 fw-bold">2</span>
                                <div>
                                    <h6 class="fw-bold mb-0">Serahkan Cucian ke Outlet</h6>
                                    <small class="text-muted">Datang ke outlet Éclat Laundry dan tunjukkan Kode Pesanan Anda.</small>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <span class="badge rounded-circle bg-pink-soft text-pink p-2 fw-bold">3</span>
                                <div>
                                    <h6 class="fw-bold mb-0">Pantau Progres Real-Time</h6>
                                    <small class="text-muted">Cek status cucian (Menunggu, Diproses, hingga Selesai) dari dashboard.</small>
                                </div>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <span class="badge rounded-circle bg-pink-soft text-pink p-2 fw-bold">4</span>
                                <div>
                                    <h6 class="fw-bold mb-0">Ambil Cucian Rapi & Wangi</h6>
                                    <small class="text-muted">Datang ke outlet saat status sudah Selesai untuk pengambilan pakaian.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Layanan -->
    <section id="layanan" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-pink fw-semibold small text-uppercase">Katalog Layanan</span>
                <h2 class="fw-bold mt-1">Pilihan Perawatan Pakaian Terbaik</h2>
                <p class="text-muted">Harga transparan per kilogram maupun per satuan item</p>
            </div>

            <div class="row g-4">
                @forelse($layanans as $layanan)
                    <div class="col-md-6 col-lg-3">
                        <div class="service-card p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="icon-circle mb-3">
                                    <i class="bi bi-droplet-half"></i>
                                </div>
                                <h5 class="fw-bold mb-1">{{ $layanan->nama_layanan }}</h5>
                                <p class="text-muted small mb-3">{{ $layanan->deskripsi ?? 'Pencucian higienis, pewangi premium, dan setrika uap rapi.' }}</p>
                            </div>
                            <div>
                                <div class="border-top pt-3 d-flex align-items-baseline justify-content-between">
                                    <div>
                                        <span class="fs-5 fw-bold text-pink">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                        <small class="text-muted">/ {{ $layanan->satuan }}</small>
                                    </div>
                                    <span class="badge bg-pink-soft text-pink">{{ $layanan->estimasi_hari }} Hari</span>
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