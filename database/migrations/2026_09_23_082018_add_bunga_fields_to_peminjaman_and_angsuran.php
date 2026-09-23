<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom di tabel peminjaman
        Schema::table('peminjaman', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjaman', 'total_bunga')) {
                $table->bigInteger('total_bunga')->default(0)->after('jumlah_pinjaman');
            }
            if (!Schema::hasColumn('peminjaman', 'bunga_per_bulan')) {
                $table->bigInteger('bunga_per_bulan')->default(0)->after('total_bunga');
            }
            if (!Schema::hasColumn('peminjaman', 'sisa_bunga')) {
                $table->bigInteger('sisa_bunga')->default(0)->after('bunga_per_bulan');
            }
        });

        // Tambah kolom di tabel angsuran
        Schema::table('angsuran', function (Blueprint $table) {
            if (!Schema::hasColumn('angsuran', 'jenis_pembayaran')) {
                $table->string('jenis_pembayaran')->default('pokok')->after('jumlah');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['total_bunga', 'bunga_per_bulan', 'sisa_bunga']);
        });

        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropColumn('jenis_pembayaran');
        });
    }
};