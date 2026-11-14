<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Halaman Utama (Guest)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Autentikasi (Hanya untuk tamu yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Route Khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan', [AdminDashboardController::class, 'index'])->name('pesanan.index');
    Route::patch('/pesanan/{id}/status', [AdminDashboardController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/layanan', [AdminDashboardController::class, 'index'])->name('layanan.index');
    Route::get('/voucher', [AdminDashboardController::class, 'index'])->name('voucher.index');
    Route::get('/pembayaran', [AdminDashboardController::class, 'index'])->name('pembayaran.index');
    Route::get('/pelanggan', [AdminDashboardController::class, 'index'])->name('pelanggan.index');
    Route::get('/laporan', [AdminDashboardController::class, 'index'])->name('laporan.index');
});

// Route Khusus Pelanggan
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan/create', [PelangganDashboardController::class, 'createPesanan'])->name('pesanan.create');
    Route::post('/pesanan', [PelangganDashboardController::class, 'storePesanan'])->name('pesanan.store');
    Route::get('/status-laundry', [PelangganDashboardController::class, 'statusLaundry'])->name('status');
    Route::get('/pembayaran', [PelangganDashboardController::class, 'pembayaran'])->name('pembayaran');
    Route::get('/voucher', [PelangganDashboardController::class, 'voucher'])->name('voucher');
    Route::get('/riwayat', [PelangganDashboardController::class, 'riwayat'])->name('riwayat');
});