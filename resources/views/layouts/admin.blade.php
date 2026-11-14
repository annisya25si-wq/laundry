<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') — Éclat Laundry</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.css') }}">

    <style>
        :root {
            --admin-dark: #1E293B;
            --admin-dark-hover: #293548;
            --admin-pink: #F45B84;
            --admin-pink-hover: #E04871;
            --admin-bg: #F1F5F9;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: #1E293B;
        }

        /* Dark Navy Sidebar */
        .sidebar-wrapper {
            background-color: var(--admin-dark) !important;
            border-right: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-brand-box {
            padding: 2rem 1.5rem 1.25rem;
            text-align: center;
        }
        .brand-circle {
            width: 56px;
            height: 56px;
            background-color: var(--admin-pink);
            color: #FFFFFF;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 6px 16px rgba(244, 91, 132, 0.35);
        }
        .sidebar-wrapper .menu {
            padding: 0 1.1rem;
            margin-top: 0.5rem;
        }
        .sidebar-wrapper .menu .sidebar-item {
            margin-bottom: 0.35rem;
        }
        .sidebar-wrapper .menu .sidebar-link {
            color: #CBD5E1 !important;
            border-radius: 10px;
            padding: 0.72rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .sidebar-wrapper .menu .sidebar-link i {
            color: #94A3B8 !important;
            font-size: 1.1rem;
        }
        .sidebar-wrapper .menu .sidebar-link:hover {
            background-color: var(--admin-dark-hover) !important;
            color: #FFFFFF !important;
        }
        .sidebar-wrapper .menu .sidebar-link:hover i {
            color: #FFFFFF !important;
        }
        .sidebar-wrapper .menu .sidebar-item.active > .sidebar-link {
            background-color: var(--admin-pink) !important;
            color: #FFFFFF !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(244, 91, 132, 0.3);
        }
        .sidebar-wrapper .menu .sidebar-item.active > .sidebar-link i {
            color: #FFFFFF !important;
        }

        /* Top Header Dark Bar */
        #main {
            padding: 0 !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .admin-topbar {
            background-color: var(--admin-dark);
            color: #FFFFFF;
            padding: 1.15rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-content-area {
            padding: 1.75rem 2rem;
            flex-grow: 1;
        }

        /* Utilities */
        .bg-admin-pink { background-color: var(--admin-pink) !important; color: #FFFFFF !important; }
        .text-admin-pink { color: var(--admin-pink) !important; }
        .btn-admin-pink {
            background-color: var(--admin-pink);
            border-color: var(--admin-pink);
            color: #FFFFFF;
            font-weight: 600;
        }
        .btn-admin-pink:hover {
            background-color: var(--admin-pink-hover);
            border-color: var(--admin-pink-hover);
            color: #FFFFFF;
        }
        .stat-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background-color: var(--admin-pink);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        <!-- Dark Navy Sidebar -->
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div>
                    <div class="sidebar-brand-box position-relative">
                        <a href="#" class="sidebar-hide d-xl-none d-block text-white position-absolute top-0 end-0 m-3">
                            <i class="bi bi-x fs-4"></i>
                        </a>
                        <div class="brand-circle">
                            <i class="bi bi-stars"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Éclat Laundry</h5>
                        <small class="text-secondary" style="font-size: 12px;">Panel Admin</small>
                    </div>

                    <div class="sidebar-menu">
                        <ul class="menu">
                            <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.pesanan.index') }}" class="sidebar-link d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-bag-fill"></i>
                                        <span>Pesanan</span>
                                    </div>
                                    @php
                                        $notifMenunggu = \App\Models\Pesanan::where('status_pesanan', 'menunggu')->count();
                                    @endphp
                                    @if($notifMenunggu > 0)
                                        <span class="badge rounded-circle bg-admin-pink d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px;">
                                            {{ $notifMenunggu }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.layanan.index') }}" class="sidebar-link">
                                    <i class="bi bi-tools"></i>
                                    <span>Layanan</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('admin.voucher.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.voucher.index') }}" class="sidebar-link">
                                    <i class="bi bi-ticket-perforated-fill"></i>
                                    <span>Voucher</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.pembayaran.index') }}" class="sidebar-link">
                                    <i class="bi bi-credit-card-fill"></i>
                                    <span>Pembayaran</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.pelanggan.index') }}" class="sidebar-link">
                                    <i class="bi bi-people-fill"></i>
                                    <span>Pelanggan</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                    <span>Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tombol Logout Pink di Bawah -->
                <div class="p-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-admin-pink w-100 py-2 rounded-3">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main">
            <!-- Topbar Dark Navy -->
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="burger-btn d-block d-xl-none text-white">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                    <h4 class="text-white fw-bold mb-0">@yield('page-title', 'Dashboard Admin')</h4>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-admin-pink d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="small fw-semibold text-white d-none sm:inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </div>

                    <a href="{{ route('admin.pesanan.index') }}" class="position-relative text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px; background-color: rgba(255,255,255,0.1);">
                        <i class="bi bi-bell"></i>
                        @if(($notifMenunggu ?? 0) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-admin-pink" style="font-size: 10px;">
                                {{ $notifMenunggu }}
                            </span>
                        @endif
                    </a>
                </div>
            </header>

            <!-- Area Konten -->
            <div class="admin-content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>