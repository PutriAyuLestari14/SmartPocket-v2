<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Tambah kolom status (aktif/lunas)
            $table->enum('status', ['aktif', 'lunas'])->default('aktif')->after('status_verifikasi');
            // Tambah tanggal pelunasan
            $table->date('tanggal_lunas')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['status', 'tanggal_lunas']);
        });
    }
};