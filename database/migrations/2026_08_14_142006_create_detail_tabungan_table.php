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
        Schema::create('detail_tabungan', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek');
            $table->foreign('no_rek')->references('no_rek')->on('rekening_tabungan')->onDelete('cascade');

            $table->string('id_petugas'); 
            $table->foreign('id_petugas')->references('username')->on('users')->onDelete('cascade');

            $table->foreignId('id_jenis_transaksi')->constrained('jenis_transaksi', 'id_jenis_transaksi')->onDelete('cascade');
            $table->bigInteger('jumlah');
            $table->dateTime('tanggal_transaksi');
            $table->enum('status', ['pending', 'berhasil', 'gagal'])->default('berhasil'); 
            $table->string('keterangan')->nullable();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tabungan');
    }
};
