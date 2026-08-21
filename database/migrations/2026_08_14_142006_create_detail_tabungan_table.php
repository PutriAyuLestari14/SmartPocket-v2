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
        Schema::create('detail_tabungans', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek');
            $table->foreign('no_rek')->references('no_rek')->on('rekening_tabungan')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugas', 'id_petugas')->onDelete('cascade');
            $table->foreignId('id_jenis_transaksi')->constrained('jenis_transaksi', 'id_jenis_transaksi')->onDelete('cascade');
            $table->bigInteger('jumlah');
            $table->dateTime('tanggal_transaksi');
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
