<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('voucher_id')->nullable()->constrained('voucher')->onDelete('set null');
            $table->dateTime('tanggal_pesan');
            $table->enum('status_pesanan', ['menunggu', 'diproses', 'selesai', 'diambil'])->default('menunggu');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->json('foto_cucian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};