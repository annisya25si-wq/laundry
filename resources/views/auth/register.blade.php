<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan — Éclat Laundry</title>
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
            width: 240px;
            height: 240px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            top: -70px;
            right: -50px;
        }
        .brand-badge {
            background: rgba(255, 255, 255, 0.2);
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
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(255, 107, 157, 0.3);
        }
        .form-control {
            border-radius: 12px;
            padding: 10px 15px;
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
            <!-- Panel Kiri: Branding -->
            <div class="col-lg-5 auth-banner p-4 p-md-5 d-flex flex-column justify-content-between">
                <div class="position-relative z-1">
                    <div class="brand-badge mb-4">
                        <i class="bi bi-stars"></i> Éclat Laundry
                    </div>
                    <h2 class="fw-bold mb-3">Mulai Pengalaman Laundry Lebih Praktis.</h2>
                    <p class="opacity-75 small mb-4">
                        Daftar dalam hitungan detik untuk memesan layanan cuci, menggunakan voucher promo, dan mengecek status cucian dari mana saja.
                    </p>
                </div>

                <div class="position-relative z-1 d-flex flex-column gap-2 mt-3">
                    <div class="feature-pill d-flex align-items-center gap-3">
                        <i class="bi bi-ticket-perforated fs-5"></i>
                        <span>Akses voucher diskon khusus member</span>
                    </div>
                    <div class="feature-pill d-flex align-items-center gap-3">
                        <i class="bi bi-receipt fs-5"></i>
                        <span>Riwayat transaksi & nota digital tersimpan</span>
                    </div>
                </div>
            </div>

            <!-- Panel Kanan: Form Daftar (4 Input) -->
            <div class="col-lg-7 p-4 p-md-5 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Daftar Akun Baru</h4>
                        <p class="text-muted small mb-0">Lengkapi data singkat di bawah ini</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-light rounded-pill px-3 text-muted">
                        <i class="bi bi-arrow-left me-1"></i> Beranda
                    </a>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" required autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username" required>
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-pink w-100 mb-3">
                        Daftar Akun
                    </button>
                </form>

                <p class="text-center small text-muted mb-0 mt-3">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-pink fw-semibold text-decoration-none">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>