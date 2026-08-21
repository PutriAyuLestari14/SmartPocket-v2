<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('angsuran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_pinjaman')->constrained('peminjaman', 'id_pinjaman')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugas', 'id_petugas')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->bigInteger('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsuran');
    }
};
