<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_tabungan', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek');
            $table->foreign('no_rek')
                ->references('no_rek')
                ->on('rekening_tabungan')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_petugas')->nullable();
            $table->foreign('id_petugas')
                ->references('id_petugas')
                ->on('petugas')
                ->onDelete('set null');
            $table->foreignId('id_jenis_transaksi')
                ->constrained('jenis_transaksi', 'id_jenis_transaksi')
                ->onDelete('cascade');
            $table->bigInteger('jumlah');
            $table->dateTime('tanggal_transaksi');
            $table->enum('status', ['pending', 'berhasil', 'gagal'])
                ->default('berhasil');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_tabungan');
    }
};