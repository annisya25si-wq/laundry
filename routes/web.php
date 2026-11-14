<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;

// Halaman Utama Sementara (Nanti kita ganti dengan Template Guest)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route Autentikasi (Hanya untuk tamu yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Route Khusus Admin (Sementara untuk test login)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return '<h1>Halo Admin Éclat Laundry!</h1><form method="POST" action="'.route('logout').'">'.csrf_field().'<button type="submit">Logout</button></form>';
    })->name('dashboard');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan/create', [PelangganDashboardController::class, 'createPesanan'])->name('pesanan.create');
    Route::post('/pesanan', [PelangganDashboardController::class, 'storePesanan'])->name('pesanan.store');
});

Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan/create', [PelangganDashboardController::class, 'createPesanan'])->name('pesanan.create');
    Route::post('/pesanan', [PelangganDashboardController::class, 'storePesanan'])->name('pesanan.store');
    Route::get('/status-laundry', [PelangganDashboardController::class, 'statusLaundry'])->name('status');
    Route::get('/pembayaran', [PelangganDashboardController::class, 'pembayaran'])->name('pembayaran');
    Route::get('/voucher', [PelangganDashboardController::class, 'voucher'])->name('voucher');
    Route::get('/riwayat', [PelangganDashboardController::class, 'riwayat'])->name('riwayat');
});