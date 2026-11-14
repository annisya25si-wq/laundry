<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pembayaran_id')->nullable()->constrained('pembayaran')->onDelete('set null');
            $table->enum('tipe_transaksi', ['pemasukan', 'pengeluaran'])->default('pemasukan');
            $table->integer('referensi_id')->nullable();
            $table->decimal('jumlah', 10, 2);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};