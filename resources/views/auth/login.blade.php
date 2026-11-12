<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Éclat Laundry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            background-color: #FFF7FA;
            min-height: 100vh;
            margin: 0;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }
        .auth-left {
            width: 50%;
            min-height: 100vh;
            background: linear-gradient(145deg, #FF6B9D 0%, #FF4D88 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .circle-decor {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
        }
        .washer-box {
            width: 140px;
            height: 165px;
            background: #ffffff;
            border-radius: 26px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 18px 35px rgba(190, 24, 93, 0.22);
            margin-bottom: 1.5rem;
            z-index: 2;
        }
        .washer-top { width: 100%; display: flex; align-items: center; }
        .washer-bar { width: 42px; height: 7px; background: #FFD6E5; border-radius: 99px; }
        .washer-drum {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            border: 14px solid #FFB3CE;
            background: #ffffff;
            margin-bottom: 6px;
        }
        .auth-right {
            width: 50%;
            min-height: 100vh;
            background-color: #FFF9FB;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
        }
        .auth-card { width: 100%; max-width: 420px; }
        .auth-tabs {
            background: #FFE6EF;
            border-radius: 999px;
            padding: 5px;
            display: flex;
            margin-bottom: 2rem;
        }
        .auth-tab-btn {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 0;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #C95B82;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        .auth-tab-btn.active {
            background: #FF6B9D;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(255, 107, 157, 0.35);
        }
        .mb-2 { margin-bottom: 0.6rem; }
        .mb-3 { margin-bottom: 1.1rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-0 { margin-bottom: 0; }
        .form-label {
            display: block;
            margin-bottom: 0.45rem;
            font-weight: 700;
            color: #2D2D2D;
            font-size: 0.9rem;
        }
        .position-relative { position: relative; }
        .form-control-pill {
            width: 100%;
            border-radius: 999px;
            padding: 13px 20px;
            border: 1.5px solid #F5D0DE;
            background-color: #ffffff;
            font-size: 0.95rem;
            outline: none;
            transition: 0.2s;
        }
        .form-control-pill:focus {
            border-color: #FF6B9D;
            box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.18);
        }
        .pe-5 { padding-right: 45px; }
        .position-absolute {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            color: #888;
        }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .small { font-size: 0.875rem; }
        .fw-bold { font-weight: 700; }
        .text-pink { color: #FF6B9D !important; }
        .text-muted { color: #6c757d; }
        .text-decoration-none { text-decoration: none; }
        .btn-pink {
            background-color: #FF6B9D;
            border: none;
            color: #ffffff;
            border-radius: 999px;
            padding: 13px;
            font-size: 1rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: 0.2s;
            box-shadow: 0 6px 16px rgba(255, 107, 157, 0.3);
        }
        .btn-pink:hover { background-color: #F05288; }
        @media (max-width: 768px) {
            .auth-left, .auth-right { width: 100%; min-height: auto; }
            .auth-left { padding: 2.5rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-left">
            <div class="circle-decor" style="width: 70px; height: 70px; top: 18%; left: 16%;"></div>
            <div class="circle-decor" style="width: 36px; height: 36px; top: 32%; right: 20%;"></div>
            <div class="circle-decor" style="width: 90px; height: 90px; bottom: 16%; right: 24%;"></div>

            <div class="washer-box">
                <div class="washer-top"><div class="washer-bar"></div></div>
                <div class="washer-drum"></div>
            </div>

            <h1 style="font-size: 2.3rem; font-weight: 800; color: #fff; margin: 0 0 8px 0; z-index: 2;">Éclat Laundry</h1>
            <p style="color: rgba(255,255,255,0.85); font-size: 1.15rem; margin: 0; z-index: 2;">Laundry bersih, wangi, dan rapi</p>
        </div>

        <div class="auth-right">
            <div class="auth-card">
                <div class="auth-tabs">
                    <button type="button" id="tab-login" class="auth-tab-btn active" onclick="switchAuth('login')">Masuk</button>
                    <button type="button" id="tab-register" class="auth-tab-btn" onclick="switchAuth('register')">Daftar</button>
                </div>

                <div id="form-login-box">
                    <h2 style="font-weight: 800; color: #222; margin: 0 0 4px 0; font-size: 1.75rem;">Selamat datang</h2>
                    <p class="text-pink mb-4" style="margin-top: 0;">Masuk untuk memesan atau mengelola laundry</p>

                    <form action="/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control-pill" placeholder="Masukkan username" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" id="login-pass" name="password" class="form-control-pill pe-5" placeholder="Masukkan password" required>
                                <i class="bi bi-eye-slash position-absolute" style="cursor:pointer;" onclick="togglePass('login-pass', this)"></i>
                            </div>
                        </div>
                        <div class="text-end mb-4">
                            <a href="#" class="small text-pink text-decoration-none" style="font-weight: 600;">Lupa password?</a>
                        </div>
                        <button type="submit" class="btn-pink mb-3">Login</button>
                    </form>

                    <p class="text-center small text-muted mb-0">
                        Belum punya akun? <a href="javascript:void(0)" onclick="switchAuth('register')" class="fw-bold text-pink text-decoration-none">Daftar di sini</a>
                    </p>
                </div>

                <div id="form-register-box" style="display: none;">
                    <h2 style="font-weight: 800; color: #222; margin: 0 0 4px 0; font-size: 1.75rem;">Daftar</h2>
                    <p class="text-pink mb-4" style="margin-top: 0;">Lengkapi data di bawah untuk membuat akun baru</p>

                    <form action="/register" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control-pill" placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control-pill" placeholder="Buat username unik" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" id="reg-pass" name="password" class="form-control-pill pe-5" placeholder="Buat password yang kuat" required>
                                <i class="bi bi-eye-slash position-absolute" style="cursor:pointer;" onclick="togglePass('reg-pass', this)"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn-pink mb-3">Daftar Sekarang</button>
                    </form>

                    <p class="text-center small text-muted mb-0">
                        Sudah punya akun? <a href="javascript:void(0)" onclick="switchAuth('login')" class="fw-bold text-pink text-decoration-none">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchAuth(mode) {
            const loginBox = document.getElementById('form-login-box');
            const regBox = document.getElementById('form-register-box');
            const tabLogin = document.getElementById('tab-login');
            const tabReg = document.getElementById('tab-register');

            if (mode === 'login') {
                loginBox.style.display = 'block';
                regBox.style.display = 'none';
                tabLogin.classList.add('active');
                tabReg.classList.remove('active');
            } else {
                loginBox.style.display = 'none';
                regBox.style.display = 'block';
                tabReg.classList.add('active');
                tabLogin.classList.remove('active');
            }
        }

        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
</body>
</html>