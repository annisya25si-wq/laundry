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
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar Pelanggan (White + Pink) -->
        <aside class="sidebar p-4 d-flex flex-column justify-content-between">
            <div>
                <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center gap-2 fs-4 fw-bold text-pink mb-4">
                    <i class="bi bi-stars"></i> Éclat Laundry
                </a>

                <div class="p-3 rounded-4 bg-pink-soft mb-4">
                    <small class="text-muted d-block">Member Pelanggan</small>
                    <span class="fw-bold text-dark">{{ auth()->user()->name }}</span>
                </div>

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

        <!-- Main Content -->
        <main class="flex-grow-1 p-4 p-lg-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>