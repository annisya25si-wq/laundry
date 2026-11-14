<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique()->after('name');
            $table->enum('role', ['admin', 'pelanggan'])->default('pelanggan')->after('password');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('role');
            $table->string('no_hp', 20)->nullable()->after('status');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->string('foto')->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'role', 'status', 'no_hp', 'alamat', 'foto']);
        });
    }
};