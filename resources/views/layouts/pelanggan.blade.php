<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Area Pelanggan') — Éclat Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink-primary: #FF6B9D;
            --pink-hover: #E85586;
            --pink-soft: #FFF5F8;
            --pink-border: #F8D7E3;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FFF9FB;
            color: #2D3142;
        }
        .sidebar {
            width: 265px;
            min-width: 265px;
            flex-shrink: 0;
            min-height: 100vh;
            background-color: #FFFFFF;
            border-right: 1px solid var(--pink-border);
        }
        .sidebar .nav-link {
            color: #64748B;
            border-radius: 12px;
            padding: 11px 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--pink-soft);
            color: var(--pink-primary);
            font-weight: 600;
        }
        .text-pink { color: var(--pink-primary) !important; }
        .bg-pink-soft { background-color: var(--pink-soft) !important; }
        .btn-pink {
            background-color: var(--pink-primary);
            border-color: var(--pink-primary);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.25s;
        }
        .btn-pink:hover {
            background-color: var(--pink-hover);
            border-color: var(--pink-hover);
            color: #FFFFFF;
        }
        .card-pink {
            background: #FFFFFF;
            border: 1px solid var(--pink-border);
            border-radius: 20px;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--pink-primary);
            color: #FFFFFF;
            font-weight: 700;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            flex-shrink: 0;
        }
        .btn-notif {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #FFFFFF;
            border: 1px solid var(--pink-border);
            color: #2D3142;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.2s;
        }
        .btn-notif:hover {
            background-color: var(--pink-soft);
            color: var(--pink-primary);
        }
        .notif-dot {
            position: absolute;
            top: 9px;
            right: 10px;
            width: 8px;
            height: 8px;
            background-color: var(--pink-primary);
            border-radius: 50%;
            border: 2px solid #FFFFFF;
        }
    </style>
</head>
<body>
    @php
        $user = auth()->user();
        $inisial = strtoupper(substr($user->name ?? 'U', 0, 1));
        $notifikasiPesanans = \App\Models\Pesanan::where('user_id', $user->id)
            ->latest('updated_at')
            ->take(5)
            ->get();
        $adaNotifBaru = $notifikasiPesanans->whereIn('status_pesanan', ['menunggu', 'diproses', 'dicuci', 'disetrika', 'selesai'])->count() > 0;
    @endphp

    <div class="d-flex">
        <!-- Sidebar Pelanggan -->
        <aside class="sidebar p-4 d-flex flex-column justify-content-between">
            <div>
                <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center gap-2 fs-4 fw-bold text-pink mb-4">
                    <i class="bi bi-stars"></i> Éclat Laundry
                </a>

                <nav class="nav flex-column gap-1">
                    <a class="nav-link {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}" href="{{ route('pelanggan.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('pelanggan.pesanan.create') ? 'active' : '' }}" href="{{ route('pelanggan.pesanan.create') }}">
                        <i class="bi bi-plus-circle-fill"></i> Buat Pesanan
                    </a>
                    <a class="nav-link {{ request()->routeIs('pelanggan.status') ? 'active' : '' }}" href="{{ route('pelanggan.status') }}">
                        <i class="bi bi-arrow-repeat"></i> Status Laundry
                    </a>
                    <a class="nav-link {{ request()->routeIs('pelanggan.pembayaran') ? 'active' : '' }}" href="{{ route('pelanggan.pembayaran') }}">
                        <i class="bi bi-wallet2"></i> Pembayaran
                    </a>
                    <a class="nav-link {{ request()->routeIs('pelanggan.voucher') ? 'active' : '' }}" href="{{ route('pelanggan.voucher') }}">
                        <i class="bi bi-ticket-perforated-fill"></i> Voucher Promo
                    </a>
                    <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}" href="{{ route('pelanggan.riwayat') }}">
                        <i class="bi bi-clock-history"></i> Riwayat Transaksi
                    </a>
                </nav>
            </div>

            <div class="pt-3 border-top" style="border-color: var(--pink-border) !important;">
                <a href="{{ route('home') }}" class="nav-link mb-1">
                    <i class="bi bi-house-door"></i> Ke Beranda
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link w-100 border-0 bg-transparent text-danger">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow-1 d-flex flex-column">
            <!-- Top Header Bar -->
           <header class="px-4 px-lg-5 pt-4 pb-2 d-flex justify-content-end align-items-center gap-3 position-relative" style="z-index: 1050;">
                <!-- Dropdown Lonceng Notifikasi -->
                <div class="dropdown">
                    <button class="btn-notif" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
                        <i class="bi bi-bell fs-5"></i>
                        @if($adaNotifBaru)
                            <span class="notif-dot"></span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3 mt-2" style="width: 330px; border: 1px solid var(--pink-border) !important;">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <span class="fw-bold small">Notifikasi Pesanan</span>
                            <span class="badge bg-pink-soft text-pink rounded-pill">{{ $notifikasiPesanans->count() }} Terbaru</span>
                        </div>

                        <div style="max-height: 280px; overflow-y: auto;">
                            @forelse($notifikasiPesanans as $notif)
                                @php
                                    $status = strtolower($notif->status_pesanan);
                                    if ($status === 'menunggu') {
                                        $judul = 'Menunggu Drop-off';
                                        $pesan = "Pesanan {$notif->kode_pesanan} dibuat. Silakan antar cucian ke outlet.";
                                        $ikon = 'bi-hourglass-split text-warning';
                                        $link = route('pelanggan.status');
                                    } elseif (in_array($status, ['diproses', 'dicuci', 'disetrika'])) {
                                        $judul = 'Cucian Sedang ' . ucfirst($status);
                                        $pesan = "Pesanan {$notif->kode_pesanan} sedang dikerjakan oleh tim Éclat.";
                                        $ikon = 'bi-arrow-repeat text-pink';
                                        $link = route('pelanggan.status');
                                    } else {
                                        $judul = 'Cucian Selesai! ✨';
                                        $pesan = "Pesanan {$notif->kode_pesanan} sudah bersih & siap diambil di outlet.";
                                        $ikon = 'bi-check-circle-fill text-success';
                                        $link = route('pelanggan.riwayat');
                                    }
                                @endphp

                                <a href="{{ $link }}" class="text-decoration-none d-block p-2 rounded-3 mb-2 {{ $status !== 'selesai' ? 'bg-pink-soft' : 'bg-light' }}">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi {{ $ikon }} fs-5 mt-1"></i>
                                        <div>
                                            <p class="mb-0 fw-semibold text-dark small">{{ $judul }}</p>
                                            <span class="text-muted d-block" style="font-size: 12px;">{{ $pesan }}</span>
                                            <small class="text-muted" style="font-size: 10px;">{{ $notif->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-3 rounded-3 bg-pink-soft text-center small">
                                    <p class="mb-1 fw-semibold text-dark">Belum ada aktivitas pesanan</p>
                                    <span class="text-muted" style="font-size: 12px;">Gunakan kode <strong>ECLATBARU</strong> untuk pesanan pertamamu!</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Dropdown Profil Pelanggan -->
                <div class="dropdown">
                    <button class="btn border-0 bg-white rounded-pill py-1 ps-3 pe-1 d-flex align-items-center gap-2"
                            style="border: 1px solid var(--pink-border) !important;"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-semibold small text-dark">{{ $user->name }}</span>
                        <div class="avatar-circle" style="width: 34px; height: 34px; font-size: 14px;">
                            {{ $inisial }}
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-2 mt-2" style="min-width: 200px;">
                        <li class="px-3 py-2 border-bottom mb-1">
                            <small class="text-muted d-block">Login sebagai</small>
                            <span class="fw-bold small">{{ $user->email }}</span>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-3 py-2 small text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </header>

            <!-- Konten Utama Halaman -->
            <main class="flex-grow-1 px-4 px-lg-5 pb-5 pt-2">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>