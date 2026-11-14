<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Éclat Laundry
        User::create([
            'name' => 'Admin Éclat',
            'username' => 'admin',
            'email' => 'admin@eclatlaundry.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'aktif',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Sudirman No. 10, Pekanbaru',
        ]);

        // 2. Akun Pelanggan Contoh
        User::create([
            'name' => 'Annisya Putri',
            'username' => 'annisya',
            'email' => 'annisya@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'status' => 'aktif',
            'no_hp' => '082298765432',
            'alamat' => 'Jl. Melati Indah No. 5, Pekanbaru',
        ]);

        // 3. Data Layanan Awal
        Layanan::insert([
            [
                'nama_layanan' => 'Cuci Komplit Reguler',
                'harga' => 7000,
                'satuan' => 'kg',
                'deskripsi' => 'Cuci bersih, kering sempurna, setrika uap rapi, dan parfum premium tahan lama (2-3 hari).',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_layanan' => 'Cuci Express Kilat 6 Jam',
                'harga' => 14000,
                'satuan' => 'kg',
                'deskripsi' => 'Layanan prioritas selesai dalam 6 jam dengan lipatan rapi dan wangi eksklusif.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_layanan' => 'Dry Clean Jas & Gaun',
                'harga' => 25000,
                'satuan' => 'pcs',
                'deskripsi' => 'Perawatan khusus bahan sensitif, jas, kebaya, dan gaun pesta tanpa merusak serat kain.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_layanan' => 'Cuci Bedcover & Selimut',
                'harga' => 30000,
                'satuan' => 'pcs',
                'deskripsi' => 'Pencucian mendalam anti tungau dan pengeringan higienis untuk bedcover ukuran besar.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. Data Voucher Awal
        Voucher::create([
            'kode_voucher' => 'ECLATBARU',
            'tipe_diskon' => 'persen',
            'nilai_diskon' => 15,
            'min_berat' => 3,
            'tanggal_berakhir' => now()->addMonths(3),
            'kuota' => 50,
            'kuota_terpakai' => 0,
            'status' => 'aktif',
        ]);
    }
}