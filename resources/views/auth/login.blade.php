<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Éclat Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FFF5F8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-wrapper {
            background: #FFFFFF;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(255, 107, 157, 0.16);
            overflow: hidden;
            max-width: 920px;
            width: 100%;
        }
        .auth-banner {
            background: linear-gradient(145deg, #FF6B9D 0%, #E0487B 100%);
            color: #FFFFFF;
            position: relative;
            overflow: hidden;
        }
        .auth-banner::before {
            content: '';
            position: absolute;
            width: 260px;
            height: 260px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            top: -80px;
            right: -60px;
        }
        .auth-banner::after {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -50px;
            left: -40px;
        }
        .brand-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(6px);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .feature-pill {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            padding: 12px 16px;
            font-size: 0.875rem;
        }
        .btn-pink {
            background-color: #FF6B9D;
            border-color: #FF6B9D;
            color: #FFFFFF;
            font-weight: 600;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.25s;
        }
        .btn-pink:hover {
            background-color: #E85586;
            border-color: #E85586;
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(255, 107, 157, 0.3);
        }
        .form-control {
            border-radius: 12px;
            padding: 11px 15px;
            border-color: #F3D1DC;
        }
        .form-control:focus {
            border-color: #FF6B9D;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 157, 0.18);
        }
        .text-pink { color: #FF6B9D; }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="row g-0">
            <!-- Panel Kiri: Branding & Visual -->
            <div class="col-lg-5 auth-banner p-4 p-md-5 d-flex flex-column justify-content-between">
                <div class="position-relative z-1">
                    <div class="brand-badge mb-4">
                        <i class="bi bi-stars"></i> Éclat Laundry
                    </div>
                    <h2 class="fw-bold mb-3">Pakaian Bersih, Wangi & Rapi Tanpa Antre.</h2>
                    <p class="opacity-75 small mb-4">
                        Pesan layanan laundry secara online, bawa cucian ke outlet dengan kode pesanan, dan pantau progres cucian Anda secara real-time.
                    </p>
                </div>

                <div class="position-relative z-1 d-flex flex-column gap-2 mt-3">
                    <div class="feature-pill d-flex align-items-center gap-3">
                        <i class="bi bi-qr-code-scan fs-5"></i>
                        <span>Booking online & drop-off cepat di outlet</span>
                    </div>
                    <div class="feature-pill d-flex align-items-center gap-3">
                        <i class="bi bi-clock-history fs-5"></i>
                        <span>Notifikasi status cucian real-time</span>
                    </div>
                </div>
            </div>

            <!-- Panel Kanan: Form Login -->
            <div class="col-lg-7 p-4 p-md-5 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Selamat Datang Kembali</h4>
                        <p class="text-muted small mb-0">Masuk ke akun Éclat Laundry Anda</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-light rounded-pill px-3 text-muted">
                        <i class="bi bi-arrow-left me-1"></i> Beranda
                    </a>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger py-2 small rounded-3">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success py-2 small rounded-3">{{ session('success') }}</div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email atau Username</label>
                        <input type="text" name="login" value="{{ old('login') }}" class="form-control @error('login') is-invalid @enderror" placeholder="Masukkan email atau username Anda" required autofocus>
                        @error('login') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password Anda" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small text-muted" for="remember">Ingat sesi saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-pink w-100 mb-3">
                        Masuk Sekarang
                    </button>
                </form>

                <p class="text-center small text-muted mb-0 mt-3">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-pink fw-semibold text-decoration-none">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>