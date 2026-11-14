<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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