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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_pinjaman');
            $table->foreignId('id_nasabah')->constrained('nasabah', 'id_nasabah')->onDelete('cascade');
            $table->foreignId('id_petugas')->nullable()->constrained('petugas', 'id_petugas')->onDelete('set null');
            $table->date('tanggal_ajuan');
            $table->bigInteger('jumlah_pinjaman');
            $table->bigInteger('sisa_pinjaman');
            $table->string('status_verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
