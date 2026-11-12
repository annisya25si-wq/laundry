<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Éclat Laundry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --eclat-pink: #FF6B9D;
            --eclat-pink-dark: #F05288;
            --eclat-pink-soft: #FFE8F0;
            --eclat-bg: #FFF8FA;
        }
        * { box-sizing: border-box; }
        body {
            background-color: var(--eclat-bg);
            font-family: 'Nunito', sans-serif;
            margin: 0;
            color: #2D2D2D;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        /* SIDEBAR KIRI */
        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #F7DCE6;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem 1.1rem;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }
        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.25rem 0.5rem 1.5rem 0.5rem;
        }
        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--eclat-pink);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .brand-title {
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--eclat-pink);
            line-height: 1.1;
            margin: 0;
        }
        .brand-sub {
            font-size: 0.75rem;
            color: #999;
            margin: 0;
        }
        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .nav-link-eclat {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            border-radius: 999px;
            text-decoration: none;
            color: #666;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .nav-link-eclat i {
            font-size: 1.05rem;
            color: #E5A9BF;
            transition: 0.2s;
        }
        .nav-link-eclat:hover {
            background: #FFF0F5;
            color: var(--eclat-pink);
        }
        .nav-link-eclat.active {
            background: var(--eclat-pink-soft);
            color: var(--eclat-pink);
        }
        .nav-link-eclat.active i {
            color: var(--eclat-pink);
        }
        .btn-logout-sidebar {
            width: 100%;
            border: 1.5px solid #F3B8CE;
            background: #ffffff;
            color: var(--eclat-pink);
            border-radius: 999px;
            padding: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: 0.2s;
        }
        .btn-logout-sidebar:hover {
            background: var(--eclat-pink);
            color: #ffffff;
            border-color: var(--eclat-pink);
        }

        /* KONTEN UTAMA KANAN */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        /* HEADER PINK SESUAI PROTOTYPE */
        .top-banner {
            background: linear-gradient(135deg, #FF6B9D 0%, #FF558E 100%);
            color: #ffffff;
            padding: 1.75rem 2.25rem 2.2rem 2.25rem;
            border-bottom-left-radius: 26px;
            border-bottom-right-radius: 26px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 24px rgba(255, 107, 157, 0.2);
        }
        .top-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .notif-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            position: relative;
            font-size: 1.15rem;
            transition: 0.2s;
        }
        .notif-btn:hover {
            background: rgba(255, 255, 255, 0.35);
            color: #fff;
        }
        .notif-badge {
            position: absolute;
            top: 4px;
            right: 5px;
            width: 9px;
            height: 9px;
            background: #FFE600;
            border-radius: 50%;
        }
        .profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            font-weight: 700;
        }
        .avatar-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #ffffff;
            color: var(--eclat-pink);
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
        }
        .content-body {
            padding: 2rem 2.25rem;
        }
        .eclat-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #F9E3EC;
            padding: 1.35rem 1.5rem;
            box-shadow: 0 4px 14px rgba(255, 107, 157, 0.04);
        }
        @media (max-width: 991px) {
            .sidebar { width: 220px; }
            .main-wrapper { margin-left: 220px; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div>
                <div class="brand-box">
                    <div class="brand-logo"><i class="bi bi-droplet-fill"></i></div>
                    <div>
                        <p class="brand-title">Éclat Laundry</p>
                        <p class="brand-sub">Panel Admin</p>
                    </div>
                </div>

                <ul class="nav-menu">
                    <li>
                        <a href="{{ url('/dashboard') }}" class="nav-link-eclat {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/pesanan') }}" class="nav-link-eclat {{ request()->is('admin/pesanan*') ? 'active' : '' }}">
                            <i class="bi bi-bag-check-fill"></i> Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/layanan') }}" class="nav-link-eclat {{ request()->is('admin/layanan*') ? 'active' : '' }}">
                            <i class="bi bi-stars"></i> Layanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/voucher') }}" class="nav-link-eclat {{ request()->is('admin/voucher*') ? 'active' : '' }}">
                            <i class="bi bi-ticket-perforated-fill"></i> Voucher
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/pembayaran') }}" class="nav-link-eclat {{ request()->is('admin/pembayaran*') ? 'active' : '' }}">
                            <i class="bi bi-credit-card-2-front-fill"></i> Pembayaran
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/pelanggan') }}" class="nav-link-eclat {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i> Pelanggan
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/laporan') }}" class="nav-link-eclat {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
                        </a>
                    </li>
                </ul>
            </div>

            <a href="{{ url('/') }}" class="btn-logout-sidebar">Logout</a>
        </aside>

        <!-- KONTEN KANAN -->
        <div class="main-wrapper">
            <header class="top-banner">
                <div>
                    <h2 class="fw-bold mb-1" style="font-size: 1.65rem;">@yield('page_title', 'Selamat Datang, admin')</h2>
                    <p class="mb-0" style="opacity: 0.9; font-size: 0.95rem;">@yield('page_subtitle', 'Kelola layanan, pengguna, dan pesanan laundry.')</p>
                </div>

                <div class="top-actions">
                    <!-- Notifikasi di Header -->
                    <a href="{{ url('/admin/notifikasi') }}" class="notif-btn" title="Notifikasi">
                        <i class="bi bi-bell-fill"></i>
                        <span class="notif-badge"></span>
                    </a>
                    <!-- Profil Admin di Header -->
                    <a href="{{ url('/admin/profil') }}" class="profile-pill" title="Profil Admin">
                        <span>Admin</span>
                        <div class="avatar-circle">A</div>
                    </a>
                </div>
            </header>

            <main class="content-body">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>